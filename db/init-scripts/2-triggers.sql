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