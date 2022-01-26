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

CREATE TRIGGER check_artiste_solo
    BEFORE INSERT
    ON ArtisteSolo
    FOR EACH ROW
EXECUTE FUNCTION function_check_artiste_solo();
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
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
    BEFORE INSERT
    ON Groupe
    FOR EACH ROW
EXECUTE FUNCTION function_check_groupe();
/* ------------------------------------------------------------------ */

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
    WHERE Concert.nomLieu = NEW.nomlieu
      AND NEW.début BETWEEN Concert.début AND (Concert.début + INTERVAL '1' MINUTE * Concert.durée);
    IF FOUND THEN
        RAISE EXCEPTION 'Un concert se déroule en même temps --> %', concertExistant
            USING HINT = 'Plusieurs concerts ne peuvent pas avoir lieu en même temps et au même endroit.';
    ELSE
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_concert_simultane
    BEFORE INSERT
    ON Concert
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_simultane_lieu();
/* ------------------------------------------------------------------ */

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
        RAISE EXCEPTION 'Le concert % a atteint sa capacité maximale --> %', NEW.idConcert, participants;
    ELSE
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_concert_capacite_salle
    BEFORE INSERT
    ON Utilisateur_Concert
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_capacite_salle();
/* ------------------------------------------------------------------ */

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

CREATE TRIGGER check_concert_artiste_simultane
    BEFORE INSERT
    ON Concert_Artiste
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_simultane_artiste();
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
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
    BEFORE INSERT
    ON Utilisateur_Concert
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_simultane_utilisateur();
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
-- Le numéro de passage est une suite (commençant à 1) continue de valeurs.

CREATE OR REPLACE FUNCTION function_check_concert_artiste_ordre()
    RETURNS TRIGGER AS
$$
DECLARE
    dernierNo SMALLINT;
BEGIN
    SELECT numéroPassage
    INTO dernierNo
    FROM Concert_Artiste
    WHERE idConcert = NEW.idConcert
    ORDER BY numéropassage DESC
        FETCH FIRST 1 ROW ONLY;
    IF dernierNo + 1 != NEW.numéroPassage THEN
        RAISE EXCEPTION 'Le numéro de passage doit être une suite continue de valeurs. Prochaine valeur : %', dernierNo + 1;
    ELSE
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_concert_artiste_ordre
    BEFORE INSERT OR UPDATE
    ON Concert_Artiste
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_artiste_ordre();
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
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
    BEFORE INSERT OR UPDATE
    ON Concert
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_date_debut();
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
-- Un concert ne peut être noté que par un utilisateur ayant assisté audit concert.

CREATE OR REPLACE FUNCTION function_check_note_concert()
    RETURNS TRIGGER AS
$$
BEGIN
    PERFORM
    FROM Utilisateur_Concert
    WHERE idConcert = NEW.idConcert
      AND idUtilisateur = NEW.idUtilisateur;

    IF NOT FOUND THEN
        RAISE EXCEPTION 'L''utilisateur n''a pas assisté à ce concert --> %', NEW.idConcert;
    END IF;

    NEW.date = CURRENT_DATE;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_note_concert
    BEFORE INSERT
    ON NoteConcert
    FOR EACH ROW
EXECUTE FUNCTION function_check_note_concert();
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
-- Une salle ne peut être notée que par un utilisateur ayant assisté à au moins un concert dans cette dernière.

CREATE OR REPLACE FUNCTION function_check_note_lieu()
    RETURNS TRIGGER AS
$$
BEGIN
    PERFORM
    FROM Utilisateur_Concert
             INNER JOIN Concert ON Utilisateur_Concert.idConcert = Concert.id
    WHERE Concert.nom = NEW.nom
      AND idUtilisateur = NEW.idUtilisateur;

    IF NOT FOUND THEN
        RAISE EXCEPTION 'L''utilisateur n''a pas assisté à des concerts dans cette salle.';
    END IF;

    NEW.date = CURRENT_DATE;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_note_lieu
    BEFORE INSERT
    ON NoteLieu
    FOR EACH ROW
EXECUTE FUNCTION function_check_note_lieu();
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
-- Un artiste ne peut être noté que par un utilisateur ayant effectivement assisté à une de ses performances.

CREATE OR REPLACE FUNCTION function_check_note_artiste()
    RETURNS TRIGGER AS
$$
BEGIN
    PERFORM
    FROM Utilisateur_Concert
             INNER JOIN Concert ON Utilisateur_Concert.idConcert = Concert.id
             INNER JOIN Concert_Artiste ON Concert.id = Concert_Artiste.idConcert
    WHERE idUtilisateur = NEW.idUtilisateur
      AND idArtiste = NEW.idArtiste;

    IF NOT FOUND THEN
        RAISE EXCEPTION 'L''utilisateur n''a pas assisté à des concerts de cet artiste.';
    END IF;

    NEW.date = CURRENT_DATE;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_note_artiste
    BEFORE INSERT
    ON NoteArtiste
    FOR EACH ROW
EXECUTE FUNCTION function_check_note_artiste();
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
-- Un groupe sans membres actifs ne peut pas se produire en concert.

CREATE OR REPLACE FUNCTION function_check_concert_groupe_actif()
    RETURNS TRIGGER AS
$$
BEGIN
    PERFORM
    FROM Membre
    WHERE idGroupe = NEW.idArtiste
      AND dateFin IS NULL;

    IF NOT FOUND THEN
        RAISE EXCEPTION 'Aucun membre actif dans le groupe.';
    ELSE
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_concert_groupe_actif
    BEFORE INSERT
    ON Concert_Artiste
    FOR EACH ROW
EXECUTE FUNCTION function_check_concert_groupe_actif();
/* ------------------------------------------------------------------ */

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

CREATE TRIGGER check_date_membre
    BEFORE INSERT OR UPDATE
    ON Membre
    FOR EACH ROW
EXECUTE FUNCTION function_check_date_membre();
/* ------------------------------------------------------------------ */