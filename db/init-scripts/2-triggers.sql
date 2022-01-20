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

CREATE OR REPLACE FUNCTION function_check_concert_simultane()
    RETURNS TRIGGER AS
$$
DECLARE
    concertExistant concert%ROWTYPE;
BEGIN
    SELECT *
    INTO concertExistant
    FROM concert
    WHERE concert.nomlieu = NEW.nomlieu
      AND NEW.début BETWEEN concert.début AND (concert.début + INTERVAL '1' MINUTE * concert.durée);
    IF FOUND THEN
        RAISE EXCEPTION 'Un concert se déroule en même temps --> %', concertExistant.nom
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
EXECUTE FUNCTION function_check_concert_simultane();
/* ------------------------------------------------------------------ */