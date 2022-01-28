/* ------------------------------------------------------------------ */
/* Gestion de l'héritage Artiste - ArtisteSolo/Groupe                 */
/* ------------------------------------------------------------------ */
-- Vérifie que le nouveau artiste solo n'est pas aussi un autre artiste
CREATE OR REPLACE FUNCTION function_check_artiste_solo()
    RETURNS TRIGGER AS
$$
BEGIN
    IF NEW.id IN (SELECT id FROM Groupe) THEN
        RAISE EXCEPTION 'Id d''artiste solo invalide --> %', NEW.id
            USING HINT = 'L''heritage sur Artiste est disjoint. '
                'Un artiste ne peut appartenir a plusieurs sous-types.';
    ELSE
        RETURN NEW;
    END IF;
END;
$$
    LANGUAGE plpgsql;

-- Vérifie que le nouveau groupe n'est pas aussi un autre artiste

CREATE OR REPLACE FUNCTION function_check_groupe()
    RETURNS TRIGGER AS
$$
BEGIN
    IF NEW.id IN (SELECT id FROM ArtisteSolo) THEN
        RAISE EXCEPTION 'Id de groupe invalide --> %', NEW.id
            USING HINT = 'L''heritage sur Artiste est disjoint. '
                'Un artiste ne peut appartenir a plusieurs sous-types.';
    ELSE
        RETURN NEW;
    END IF;
END;
$$
    LANGUAGE plpgsql;

CREATE TRIGGER check_groupe
    BEFORE INSERT OR UPDATE
    ON Groupe
    FOR EACH ROW
EXECUTE FUNCTION function_check_groupe();
CREATE TRIGGER check_artiste_solo
    BEFORE INSERT OR UPDATE
    ON ArtisteSolo
    FOR EACH ROW
EXECUTE FUNCTION function_check_artiste_solo();
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
/* Concerts                                                           */
/* ------------------------------------------------------------------ */

-- Plusieurs concerts ne peuvent pas avoir lieu en même temps et au même endroit
CREATE OR REPLACE FUNCTION function_check_concert_simultane_lieu()
    RETURNS TRIGGER AS
$$
DECLARE
    concertExistant VARCHAR;
BEGIN
    SELECT nom
    INTO concertExistant
    FROM Concert
    WHERE Concert.id != NEW.id
      AND Concert.nomLieu = NEW.nomLieu
      AND NEW.début BETWEEN Concert.début AND (Concert.début + INTERVAL '1' MINUTE * Concert.durée);
    IF FOUND THEN
        RAISE EXCEPTION 'Un concert se déroule en même temps --> %', concertExistant
            USING HINT = 'Plusieurs concerts ne peuvent pas avoir lieu en même temps et au même endroit.';
    ELSE
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;

-- Un concert ne peut pas être créé avec une date de début antérieure à la date courante.
CREATE OR REPLACE FUNCTION function_check_concert_date_debut()
    RETURNS TRIGGER AS
$$
BEGIN
    IF NEW.début > NOW() THEN
        RETURN NEW;
    ELSE
        RAISE EXCEPTION 'La date de début est dans le passé.';
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_concert_date_debut
    BEFORE INSERT
    ON Concert
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_date_debut();

CREATE TRIGGER check_concert_simultane
    BEFORE INSERT OR UPDATE
    ON Concert
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_simultane_lieu();
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
/* Concert_Artiste                                                    */
/* ------------------------------------------------------------------ */
-- Un artiste ne peut pas se produire lors de plusieurs concerts en même temps.

CREATE OR REPLACE FUNCTION function_check_concert_simultane_artiste()
    RETURNS TRIGGER AS
$$
DECLARE
    concertExistant VARCHAR;
BEGIN
    SELECT nom
    INTO concertExistant
    FROM Concert
             INNER JOIN Concert_Artiste ON Concert.id = Concert_Artiste.idConcert
    WHERE id != NEW.idConcert
      AND (SELECT début FROM Concert WHERE id = NEW.idConcert) BETWEEN début AND (début + INTERVAL '1' MINUTE * durée);
    IF FOUND THEN
        RAISE EXCEPTION 'L''artiste se produit déjà à ce moment --> %', concertExistant
            USING HINT = 'Un artiste ne peut pas se produire lors de plusieurs concerts en même temps';
    ELSE
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;

-- Le numéro de passage est une suite (commençant à 1) continue de valeurs.
CREATE OR REPLACE FUNCTION function_check_concert_artiste_ordre()
    RETURNS TRIGGER AS
$$
DECLARE
    dernierNo SMALLINT;
BEGIN
    SELECT MAX(numéroPassage)
    INTO dernierNo
    FROM Concert_Artiste
    WHERE idConcert = NEW.idConcert;
    IF dernierNo + 1 != NEW.numéroPassage THEN
        RAISE EXCEPTION 'Le numéro de passage doit être une suite continue de valeurs. Prochaine valeur : %', dernierNo + 1;
    ELSE
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;

-- Un groupe sans membres actifs ne peut pas se produire en concert.
CREATE OR REPLACE FUNCTION function_check_concert_groupe_actif()
    RETURNS TRIGGER AS
$$
BEGIN
    PERFORM
    FROM Membre
    WHERE idGroupe = NEW.idArtiste
      AND dateFin IS NULL;

    IF NOT FOUND AND NEW.idArtiste IN (SELECT id FROM Groupe) THEN
        RAISE EXCEPTION 'Aucun membre actif dans le groupe.';
    ELSE
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_concert_groupe_actif
    BEFORE INSERT OR UPDATE
    ON Concert_Artiste
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_groupe_actif();

CREATE TRIGGER check_concert_artiste_ordre
    BEFORE INSERT OR UPDATE
    ON Concert_Artiste
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_artiste_ordre();

CREATE TRIGGER check_concert_artiste_simultane
    BEFORE INSERT OR UPDATE
    ON Concert_Artiste
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_simultane_artiste();
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
/* Utilisateur_Concert                                                */
/* ------------------------------------------------------------------ */
-- Le nombre de personne inscrite à un concert ne peut pas excéder la capacité de sa salle.
CREATE OR REPLACE FUNCTION function_check_concert_capacite_salle()
    RETURNS TRIGGER AS
$$
DECLARE
    participants INT;
    capacite     INT;
BEGIN
    SELECT COUNT(*), Lieu.capacité
    INTO participants, capacite
    FROM Utilisateur_Concert
             INNER JOIN Concert ON Utilisateur_Concert.idConcert = Concert.id
             INNER JOIN Lieu ON Concert.nomLieu = Lieu.nom
    WHERE Utilisateur_Concert.idConcert = NEW.idConcert
    GROUP BY Lieu.nom;

    IF FOUND AND participants + 1 >= capacite THEN
        RAISE EXCEPTION 'Le salle du concert % a atteint sa capacité maximale --> %', NEW.idConcert, participants;
    ELSE
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;

-- Un utilisateur ne peut pas s’inscrire à différents concerts ayant lieu en même temps.
CREATE OR REPLACE FUNCTION function_check_concert_simultane_utilisateur()
    RETURNS TRIGGER AS
$$
DECLARE
    concertExistant VARCHAR;
BEGIN
    SELECT nom
    INTO concertExistant
    FROM Concert
             INNER JOIN Utilisateur_Concert ON Concert.id = Utilisateur_Concert.idConcert
    WHERE id != NEW.idConcert
      AND (SELECT début FROM Concert WHERE id = NEW.idConcert) BETWEEN début AND (début + INTERVAL '1' MINUTE * durée);
    IF FOUND THEN
        RAISE EXCEPTION 'L''utilisateur est déjà inscrit à un concert se produisant à ce moment --> %', concertExistant
            USING HINT = 'Un utilisateur ne peut pas s’inscrire à différents concerts ayant lieu en même temps.';
    ELSE
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_utilisateur_concert_simultane
    BEFORE INSERT OR UPDATE
    ON Utilisateur_Concert
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_simultane_utilisateur();

CREATE TRIGGER check_concert_capacite_salle
    BEFORE INSERT
    ON Utilisateur_Concert
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_capacite_salle();
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
/* Lieu                                                               */
/* ------------------------------------------------------------------ */
-- Le nombre de personne inscrite à un concert ne peut pas excéder la capacité de sa salle.
CREATE OR REPLACE FUNCTION function_check_concert_changement_capacite_salle()
    RETURNS TRIGGER AS
$$
BEGIN
    PERFORM
    FROM Utilisateur_Concert
             INNER JOIN Concert ON Utilisateur_Concert.idConcert = Concert.id
    WHERE nomLieu = NEW.nom
      AND (début + INTERVAL '1' MINUTE * durée) > NOW()
    GROUP BY id
    HAVING COUNT(*) > NEW.capacité;

    IF FOUND THEN
        RAISE EXCEPTION 'Ce changement entraînerait l''invalidation de certains concerts.';
    ELSE
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_concert_changement_capacite_salle
    BEFORE UPDATE
    ON Lieu
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_changement_capacite_salle();
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
/* Membre                                                             */
/* ------------------------------------------------------------------ */
-- La date de début d’un membre doit être antérieure ou égale à la date de fin.
CREATE OR REPLACE FUNCTION function_check_date_membre()
    RETURNS TRIGGER AS
$$
BEGIN
    IF NEW.dateDébut > NEW.dateFin THEN
        RAISE EXCEPTION 'La date de début doit être antérieure ou égale à la date de fin.';
    ELSE
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;

-- Un artiste solo ne peut pas rejoindre un groupe dont il fait déjà partie.
CREATE OR REPLACE FUNCTION function_check_membre_deja_groupe()
    RETURNS TRIGGER AS
$$
BEGIN
    PERFORM
    FROM Membre
    WHERE idGroupe = NEW.idGroupe
      AND idArtisteSolo = NEW.idArtisteSolo;

    IF FOUND THEN
        RAISE EXCEPTION 'L''artiste fait déjà parti de ce groupe.';
    ELSE
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_membre_deja_groupe
    BEFORE INSERT
    ON Membre
    FOR EACH ROW
EXECUTE FUNCTION function_check_membre_deja_groupe();

CREATE TRIGGER check_date_membre
    BEFORE INSERT OR UPDATE
    ON Membre
    FOR EACH ROW
EXECUTE FUNCTION function_check_date_membre();
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
/* Notes                                                              */
/* ------------------------------------------------------------------ */
-- Un concert ne peut être noté que par un utilisateur ayant assisté audit concert.
CREATE OR REPLACE FUNCTION function_check_note_concert()
    RETURNS TRIGGER AS
$$
BEGIN
    NEW.date = CURRENT_DATE;

    PERFORM
    FROM Utilisateur_Concert
             INNER JOIN Concert ON Utilisateur_Concert.idConcert = Concert.id
    WHERE idConcert = NEW.idConcert
      AND idUtilisateur = NEW.idUtilisateur
      AND début < NEW.date;

    IF NOT FOUND THEN
        RAISE EXCEPTION 'L''utilisateur n''a pas assisté à ce concert --> %', NEW.idConcert;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Une salle ne peut être notée que par un utilisateur ayant assisté à au moins un concert dans cette dernière.
CREATE OR REPLACE FUNCTION function_check_note_lieu()
    RETURNS TRIGGER AS
$$
BEGIN
    NEW.date = CURRENT_DATE;

    PERFORM
    FROM Utilisateur_Concert
             INNER JOIN Concert ON Utilisateur_Concert.idConcert = Concert.id
    WHERE Concert.nomLieu = NEW.nom
      AND idUtilisateur = NEW.idUtilisateur
      AND Concert.début < NEW.date;

    IF NOT FOUND THEN
        RAISE EXCEPTION 'L''utilisateur n''a pas assisté à des concerts dans cette salle.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Un artiste ne peut être noté que par un utilisateur ayant effectivement assisté à une de ses performances.
CREATE OR REPLACE FUNCTION function_check_note_artiste()
    RETURNS TRIGGER AS
$$
BEGIN
    NEW.date = CURRENT_DATE;

    PERFORM
    FROM Utilisateur_Concert
             INNER JOIN Concert ON Utilisateur_Concert.idConcert = Concert.id
             INNER JOIN Concert_Artiste ON Concert.id = Concert_Artiste.idConcert
    WHERE idUtilisateur = NEW.idUtilisateur
      AND idArtiste = NEW.idArtiste
      AND Concert.début < NEW.date;

    IF NOT FOUND THEN
        RAISE EXCEPTION 'L''utilisateur n''a pas assisté à des concerts de cet artiste.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_note_concert
    BEFORE INSERT OR UPDATE
    ON NoteConcert
    FOR EACH ROW
EXECUTE FUNCTION function_check_note_concert();

CREATE TRIGGER check_note_lieu
    BEFORE INSERT OR UPDATE
    ON NoteLieu
    FOR EACH ROW
EXECUTE FUNCTION function_check_note_lieu();

CREATE TRIGGER check_note_artiste
    BEFORE INSERT OR UPDATE
    ON NoteArtiste
    FOR EACH ROW
EXECUTE FUNCTION function_check_note_artiste();
/* ------------------------------------------------------------------ */