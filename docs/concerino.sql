SET
    client_encoding TO 'UTF8';

DROP TYPE IF EXISTS TypeLieu CASCADE;
CREATE TYPE TypeLieu AS ENUM ('Intérieur', 'Extérieur');

DROP TABLE IF EXISTS Lieu CASCADE;
CREATE TABLE Lieu
(
    nom      VARCHAR(50),
    capacité INTEGER     NOT NULL,
    nomRue   VARCHAR(50) NOT NULL,
    noRue    VARCHAR(10) NOT NULL,
    npa      SMALLINT    NOT NULL,
    localité VARCHAR(50) NOT NULL,
    typeLieu TypeLieu    NOT NULL,
    CONSTRAINT PK_Lieu PRIMARY KEY (nom)
);

DROP TABLE IF EXISTS Concert CASCADE;
CREATE TABLE Concert
(
    id         SMALLSERIAL,
    nom        VARCHAR(50)  NOT NULL,
    début      TIMESTAMP(0) NOT NULL,
    durée      SMALLINT     NOT NULL,
    nomLieu    VARCHAR(50)  NOT NULL,
    idCréateur SMALLINT     NOT NULL,
    CONSTRAINT PK_Concert PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Utilisateur CASCADE;
CREATE TABLE Utilisateur
(
    id            SMALLSERIAL,
    login         VARCHAR(50) NOT NULL,
    nom           VARCHAR(50) NOT NULL,
    prénom        VARCHAR(50) NOT NULL,
    motDePasse    CHAR(60)    NOT NULL,
    estModérateur BOOLEAN     NOT NULL,
    CONSTRAINT PK_Utilisateur PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Utilisateur_Concert CASCADE;
CREATE TABLE Utilisateur_Concert
(
    idConcert     SMALLINT,
    idUtilisateur SMALLINT,
    CONSTRAINT PK_Utilisateur_Concert PRIMARY KEY (idConcert, idUtilisateur)
);

DROP TABLE IF EXISTS Artiste CASCADE;
CREATE TABLE Artiste
(
    id       SMALLSERIAL,
    nomScène VARCHAR(50) NOT NULL,
    CONSTRAINT PK_Artiste PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Style CASCADE;
CREATE TABLE Style
(
    nom VARCHAR(50),
    CONSTRAINT PK_Style PRIMARY KEY (nom)
);

DROP TABLE IF EXISTS Style_Artiste CASCADE;
CREATE TABLE Style_Artiste
(
    idArtiste SMALLINT,
    nomStyle  VARCHAR(50),
    CONSTRAINT PK_Style_Artiste PRIMARY KEY (idArtiste, nomStyle)
);

DROP TABLE IF EXISTS Concert_Artiste CASCADE;
CREATE TABLE Concert_Artiste
(
    idConcert     SMALLINT,
    idArtiste     SMALLINT,
    numéroPassage SMALLINT NOT NULL,
    CONSTRAINT PK_Concert_Artiste PRIMARY KEY (idConcert, idArtiste)
);

DROP TABLE IF EXISTS ArtisteSolo CASCADE;
CREATE TABLE ArtisteSolo
(
    id     SMALLINT,
    nom    VARCHAR(50) NOT NULL,
    prénom VARCHAR(50) NOT NULL,
    CONSTRAINT PK_ArtisteSolo PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Groupe CASCADE;
CREATE TABLE Groupe
(
    id SMALLINT,
    CONSTRAINT PK_Groupe PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Membre CASCADE;
CREATE TABLE Membre
(
    idArtisteSolo SMALLINT,
    idGroupe      SMALLINT,
    dateDébut     DATE,
    dateFin       DATE NULL,
    CONSTRAINT PK_Membre PRIMARY KEY (idArtisteSolo, idGroupe, dateDébut)
);

DROP TABLE IF EXISTS NoteLieu CASCADE;
CREATE TABLE NoteLieu
(
    nom           VARCHAR(50),
    idUtilisateur SMALLSERIAL,
    date          DATE DEFAULT CURRENT_DATE,
    note          SMALLINT NOT NULL,
    CONSTRAINT PK_NoteLieu PRIMARY KEY (nom, idUtilisateur)
);

DROP TABLE IF EXISTS NoteConcert CASCADE;
CREATE TABLE NoteConcert
(
    idConcert     SMALLSERIAL,
    idUtilisateur SMALLSERIAL,
    date          DATE DEFAULT CURRENT_DATE,
    note          SMALLINT NOT NULL,
    CONSTRAINT PK_NoteConcert PRIMARY KEY (idConcert, idUtilisateur)
);

DROP TABLE IF EXISTS NoteArtiste CASCADE;
CREATE TABLE NoteArtiste
(
    idArtiste     SMALLSERIAL,
    idUtilisateur SMALLSERIAL,
    date          DATE DEFAULT CURRENT_DATE,
    note          SMALLINT NOT NULL,
    CONSTRAINT PK_NoteArtiste PRIMARY KEY (idArtiste, idUtilisateur)
);

ALTER TABLE Concert
    ADD CONSTRAINT FK_Concert_nomLieu
        FOREIGN KEY (nomLieu)
            REFERENCES Lieu (nom)
            ON UPDATE CASCADE,
    ADD CONSTRAINT FK_Concert_idCréateur
        FOREIGN KEY (idCréateur)
            REFERENCES Utilisateur (id)
            ON UPDATE CASCADE,
    ADD CONSTRAINT CK_Concert_durée
        CHECK (durée > 0);

ALTER TABLE Utilisateur
    ADD CONSTRAINT UC_Utilisateur_login
        UNIQUE (login);

ALTER TABLE Utilisateur_Concert
    ADD CONSTRAINT FK_Utilisateur_Concert_idConcert
        FOREIGN KEY (idConcert)
            REFERENCES Concert (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    ADD CONSTRAINT FK_Utilisateur_Concert_idUtilisateur
        FOREIGN KEY (idUtilisateur)
            REFERENCES Utilisateur (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE;

ALTER TABLE Style_Artiste
    ADD CONSTRAINT FK_Style_Artiste_idArtiste
        FOREIGN KEY (idArtiste)
            REFERENCES Artiste (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    ADD CONSTRAINT FK_Style_Artiste_nomStyle
        FOREIGN KEY (nomStyle)
            REFERENCES Style (nom)
            ON DELETE CASCADE
            ON UPDATE CASCADE;

ALTER TABLE Concert_Artiste
    ADD CONSTRAINT FK_Concert_Artiste_idConcert
        FOREIGN KEY (idConcert)
            REFERENCES Concert (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    ADD CONSTRAINT FK_Concert_Artiste_idArtiste
        FOREIGN KEY (idArtiste)
            REFERENCES Artiste (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    ADD CONSTRAINT CK_Concert_Artiste_numéroPassage
        CHECK (numéroPassage > 0);

ALTER TABLE Lieu
    ADD CONSTRAINT CK_Lieu_capacité
        CHECK (capacité > 0),
    ADD CONSTRAINT CK_Lieu_npa
        CHECK (npa > 0);

ALTER TABLE ArtisteSolo
    ADD CONSTRAINT FK_ArtisteSolo_id
        FOREIGN KEY (id)
            REFERENCES Artiste (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE;

ALTER TABLE Groupe
    ADD CONSTRAINT FK_Groupe_id
        FOREIGN KEY (id)
            REFERENCES Artiste (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE;

ALTER TABLE Membre
    ADD CONSTRAINT FK_Membre_idArtisteSolo
        FOREIGN KEY (idArtisteSolo)
            REFERENCES ArtisteSolo (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    ADD CONSTRAINT FK_Membre_idGroupe
        FOREIGN KEY (idGroupe)
            REFERENCES Groupe (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    ADD CONSTRAINT CK_Membre_dateFin
        CHECK (dateFin >= dateDébut);

ALTER TABLE NoteLieu
    ADD CONSTRAINT FK_NoteLieu_nom
        FOREIGN KEY (nom)
            REFERENCES Lieu (nom)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    ADD CONSTRAINT FK_NoteLieu_idUtilisateur
        FOREIGN KEY (idUtilisateur)
            REFERENCES Utilisateur (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    ADD CONSTRAINT CK_NoteLieu_note
        CHECK (note BETWEEN 0 AND 5);

ALTER TABLE NoteConcert
    ADD CONSTRAINT FK_NoteConcert_idConcert
        FOREIGN KEY (idConcert)
            REFERENCES Concert (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    ADD CONSTRAINT FK_NoteConcert_idUtilisateur
        FOREIGN KEY (idUtilisateur)
            REFERENCES Utilisateur (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    ADD CONSTRAINT CK_NoteConcert_note
        CHECK (note BETWEEN 0 AND 5);

ALTER TABLE NoteArtiste
    ADD CONSTRAINT FK_NoteArtiste_idArtiste
        FOREIGN KEY (idArtiste)
            REFERENCES Artiste (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    ADD CONSTRAINT FK_NoteArtiste_idUtilisateur
        FOREIGN KEY (idUtilisateur)
            REFERENCES Utilisateur (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    ADD CONSTRAINT CK_NoteArtiste_note
        CHECK (note BETWEEN 0 AND 5);

CREATE INDEX IDX_FK_Concert_nomLieu ON Concert (nomLieu ASC);
CREATE INDEX IDX_FK_Concert_idCréateur ON Concert (idCréateur ASC);
CREATE INDEX IDX_FK_Utilisateur_Concert_idConcert ON Utilisateur_Concert (idConcert ASC);
CREATE INDEX IDX_FK_Utilisateur_Concert_idUtilisateur ON Utilisateur_Concert (idUtilisateur ASC);
CREATE INDEX IDX_FK_Style_Artiste_idArtiste ON Style_Artiste (idArtiste ASC);
CREATE INDEX IDX_FK_Style_Artiste_nomStyle ON Style_Artiste (nomStyle ASC);
CREATE INDEX IDX_FK_Concert_Artiste_idConcert ON Concert_Artiste (idConcert ASC);
CREATE INDEX IDX_FK_Concert_Artiste_idArtiste ON Concert_Artiste (idArtiste ASC);
CREATE INDEX IDX_FK_ArtisteSolo_id ON ArtisteSolo (id ASC);
CREATE INDEX IDX_FK_Groupe_id ON Groupe (id ASC);
CREATE INDEX IDX_FK_Membre_idArtisteSolo ON Membre (idArtisteSolo ASC);
CREATE INDEX IDX_FK_Membre_idGroupe ON Membre (idGroupe ASC);
CREATE INDEX IDX_FK_NoteLieu_nom ON NoteLieu (nom ASC);
CREATE INDEX IDX_FK_NoteLieu_idUtilisateur ON NoteLieu (idUtilisateur ASC);
CREATE INDEX IDX_FK_NoteConcert_idConcert ON NoteConcert (idConcert ASC);
CREATE INDEX IDX_FK_NoteConcert_idUtilisateur ON NoteConcert (idUtilisateur ASC);
CREATE INDEX IDX_FK_NoteArtiste_idArtiste ON NoteArtiste (idArtiste ASC);
CREATE INDEX IDX_FK_NoteArtiste_idUtilisateur ON NoteArtiste (idUtilisateur ASC);


/* Début des triggers*/

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
    BEFORE INSERT OR UPDATE --TODO DELETE
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


/* Début du peuplement de la DB*/

INSERT INTO Utilisateur (login, nom, prénom, motDePasse, estModérateur)
VALUES ('a@gmail.com', 'Doe', 'John',
        '$2y$10$Tf6jDPjOEIhJKA6H6jyn6Oahpdhy7U97uJjYQF7MI07jdVMeWNMQi', FALSE);
INSERT INTO Utilisateur (login, nom, prénom, motDePasse, estModérateur)
VALUES ('b@gmail.com', 'Doe', 'Jane',
        '$2y$10$Tf6jDPjOEIhJKA6H6jyn6Oahpdhy7U97uJjYQF7MI07jdVMeWNMQi', FALSE);
INSERT INTO Utilisateur (login, nom, prénom, motDePasse, estModérateur)
VALUES ('c@gmail.com', 'Friedli', 'Jonathan',
        '$2y$10$Tf6jDPjOEIhJKA6H6jyn6Oahpdhy7U97uJjYQF7MI07jdVMeWNMQi', TRUE);
INSERT INTO Utilisateur (login, nom, prénom, motDePasse, estModérateur)
VALUES ('d@gmail.com', 'Marengo', 'Stéphane',
        '$2y$10$Tf6jDPjOEIhJKA6H6jyn6Oahpdhy7U97uJjYQF7MI07jdVMeWNMQi', TRUE);
INSERT INTO Utilisateur (login, nom, prénom, motDePasse, estModérateur)
VALUES ('e@gmail.com', 'Marzullo', 'Loris',
        '$2y$10$Tf6jDPjOEIhJKA6H6jyn6Oahpdhy7U97uJjYQF7MI07jdVMeWNMQi', TRUE);
INSERT INTO Utilisateur (login, nom, prénom, motDePasse, estModérateur)
VALUES ('f@gmail.com', 'Peter', 'Parker',
        '$2y$10$Tf6jDPjOEIhJKA6H6jyn6Oahpdhy7U97uJjYQF7MI07jdVMeWNMQi', FALSE);

INSERT INTO Lieu (nom, capacité, nomRue, noRue, npa, localité, typeLieu)
VALUES ('Paleo', 230000, 'Route de Saint-Cergue', 310, 1260, 'Nyon', 'Intérieur');
INSERT INTO Lieu (nom, capacité, nomRue, noRue, npa, localité, typeLieu)
VALUES ('Amalgame', 24000, 'Av. des Sports', 5, 1400, 'Yverdon-les-Bains', 'Intérieur');
INSERT INTO Lieu (nom, capacité, nomRue, noRue, npa, localité, typeLieu)
VALUES ('Salle Métropole', 120000, 'Rue de Genève', 12, 1003, 'Lausanne', 'Intérieur');
INSERT INTO Lieu (nom, capacité, nomRue, noRue, npa, localité, typeLieu)
VALUES ('Stade de France', 81000, 'Saint-Denis', 7, 9300, 'Paris', 'Extérieur');

-- Désactivation des triggers pour faire des insertions dans le passé
ALTER TABLE Concert DISABLE TRIGGER ALL;
INSERT INTO Concert (nom, début, durée, nomLieu, idCréateur)
VALUES ('ConcertA', '2021-10-11 22:30', 130, 'Paleo', 1);
INSERT INTO Concert (nom, début, durée, nomLieu, idCréateur)
VALUES ('ConcertB', '2021-11-24 21:30', 140, 'Paleo', 1);
INSERT INTO Concert (nom, début, durée, nomLieu, idCréateur)
VALUES ('ConcertC', '2022-03-20 20:30', 120, 'Amalgame', 2);
INSERT INTO Concert (nom, début, durée, nomLieu, idCréateur)
VALUES ('ConcertD', '2022-03-23 19:00', 60, 'Salle Métropole', 4);
INSERT INTO Concert (nom, début, durée, nomLieu, idCréateur)
VALUES ('ConcertE', '2022-04-09 20:00', 180, 'Stade de France', 4);
INSERT INTO Concert (nom, début, durée, nomLieu, idCréateur)
VALUES ('ConcertF', '2021-04-09 20:00', 210, 'Paleo', 6);
INSERT INTO Concert (nom, début, durée, nomLieu, idCréateur)
VALUES ('ConcertG', '2021-05-09 20:00', 210, 'Amalgame', 6);
INSERT INTO Concert (nom, début, durée, nomLieu, idCréateur)
VALUES ('ConcertH', '2021-06-09 20:00', 210, 'Salle Métropole', 6);
INSERT INTO Concert (nom, début, durée, nomLieu, idCréateur)
VALUES ('ConcertI', '2021-07-09 20:00', 210, 'Stade de France', 6);
ALTER TABLE Concert ENABLE TRIGGER ALL;

/* Concerts ayant déjà eu Lieu (2021) */
INSERT INTO Utilisateur_Concert (idConcert, idUtilisateur)
VALUES (1, 1);
INSERT INTO Utilisateur_Concert (idConcert, idUtilisateur)
VALUES (1, 2);
INSERT INTO utilisateur_concert (idConcert, idUtilisateur)
VALUES (1, 6);
INSERT INTO utilisateur_concert (idConcert, idUtilisateur)
VALUES (2, 3);
INSERT INTO Utilisateur_Concert (idConcert, idUtilisateur)
VALUES (2, 4);
INSERT INTO Utilisateur_Concert (idConcert, idUtilisateur)
VALUES (2, 5);
INSERT INTO utilisateur_concert (idConcert, idUtilisateur)
VALUES (2, 6);
INSERT INTO utilisateur_concert (idConcert, idUtilisateur)
VALUES (6, 6);
INSERT INTO utilisateur_concert (idConcert, idUtilisateur)
VALUES (7, 6);
INSERT INTO utilisateur_concert (idConcert, idUtilisateur)
VALUES (8, 6);
INSERT INTO utilisateur_concert (idConcert, idUtilisateur)
VALUES (9, 6);
/* Concerts à venir (2022) */
INSERT INTO Utilisateur_Concert (idConcert, idUtilisateur)
VALUES (3, 3);
INSERT INTO Utilisateur_Concert (idConcert, idUtilisateur)
VALUES (3, 4);
INSERT INTO Utilisateur_Concert (idConcert, idUtilisateur)
VALUES (3, 5);
INSERT INTO Utilisateur_Concert (idConcert, idUtilisateur)
VALUES (4, 1);
INSERT INTO Utilisateur_Concert (idConcert, idUtilisateur)
VALUES (4, 2);
INSERT INTO Utilisateur_Concert (idConcert, idUtilisateur)
VALUES (5, 2);
INSERT INTO Utilisateur_Concert (idConcert, idUtilisateur)
VALUES (5, 4);

INSERT INTO Style (nom)
VALUES ('classique');
INSERT INTO Style (nom)
VALUES ('jazz');
INSERT INTO Style (nom)
VALUES ('rock');
INSERT INTO Style (nom)
VALUES ('blues');
INSERT INTO Style (nom)
VALUES ('pop');
INSERT INTO Style (nom)
VALUES ('métal');
INSERT INTO Style (nom)
VALUES ('rap');

/* On crée tous les Artistes (solo et groupe) */
INSERT INTO Artiste (nomscène)
VALUES ('John Lennon');
INSERT INTO Artiste (nomscène)
VALUES ('Ringo Star');
INSERT INTO Artiste (nomscène)
VALUES ('Paul McCartney');
INSERT INTO Artiste (nomscène)
VALUES ('George Harrisson');
INSERT INTO Artiste (nomscène)
VALUES ('Les Beatles');
INSERT INTO Artiste (nomscène)
VALUES ('Chester Bennington');
INSERT INTO Artiste (nomscène)
VALUES ('Mike Shindoa');
INSERT INTO Artiste (nomscène)
VALUES ('Joe Hahn');
INSERT INTO Artiste (nomscène)
VALUES ('Big Jay');
INSERT INTO Artiste (nomscène)
VALUES ('Linkin Park');

/* On crée tous les Artistes solo et on les binds sur un Artiste */
INSERT INTO ArtisteSolo (id, nom, prénom)
VALUES (1, 'Lennon', 'John');
INSERT INTO ArtisteSolo (id, nom, prénom)
VALUES (2, 'Ringo', 'Star');
INSERT INTO ArtisteSolo (id, nom, prénom)
VALUES (3, 'McCartney', 'Paulo');
INSERT INTO ArtisteSolo (id, nom, prénom)
VALUES (4, 'Stéphane', 'Marengo');
INSERT INTO ArtisteSolo (id, nom, prénom)
VALUES (6, 'Chester', 'Bennington');
INSERT INTO ArtisteSolo (id, nom, prénom)
VALUES (7, 'Mike', 'Shindoa');
INSERT INTO ArtisteSolo (id, nom, prénom)
VALUES (8, 'Joe', 'Hahn');
INSERT INTO ArtisteSolo (id, nom, prénom)
VALUES (9, 'Big', 'Jay');

/* On crée tous le groupe et on le bind sur l'Artiste */
INSERT INTO Groupe (id)
VALUES (5);
INSERT INTO Groupe (id)
VALUES (10);

/* On ajoute les Artistes dans le groupe */
INSERT INTO Membre (idArtisteSolo, idGroupe, dateDébut)
VALUES (1, 5, '2020-07-20');
INSERT INTO Membre (idArtisteSolo, idGroupe, dateDébut)
VALUES (2, 5, '2020-07-20');
INSERT INTO Membre (idArtisteSolo, idGroupe, dateDébut)
VALUES (3, 5, '2020-07-20');
INSERT INTO Membre (idArtisteSolo, idGroupe, dateDébut)
VALUES (4, 5, '2020-07-20');
INSERT INTO Membre (idartistesolo, idgroupe, datedébut)
VALUES (6, 10, '1997-11-14');
INSERT INTO Membre (idartistesolo, idgroupe, datedébut)
VALUES (7, 10, '1997-11-14');
INSERT INTO Membre (idartistesolo, idgroupe, datedébut)
VALUES (8, 10, '1997-11-14');
INSERT INTO Membre (idartistesolo, idgroupe, datedébut)
VALUES (9, 10, '1997-11-14');

/* On affecte les Artistes à leur Concert */
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (1, 1, 1);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (1, 2, 2);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (2, 3, 1);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (2, 4, 2);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (3, 5, 1);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (4, 1, 1);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (4, 2, 2);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (4, 3, 3);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (5, 5, 1);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (6, 10, 1);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (7, 10, 1);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (8, 10, 1);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (9, 6, 1);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (9, 7, 2);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (9, 8, 3);
INSERT INTO Concert_Artiste (idConcert, idArtiste, numéroPassage)
VALUES (9, 9, 4);

/* Style des Artistes */
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (1, 'rock');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (2, 'rock');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (3, 'rock');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (4, 'rock');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (5, 'rock');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (1, 'blues');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (2, 'blues');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (3, 'blues');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (4, 'blues');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (5, 'blues');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (6, 'rock');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (7, 'rock');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (8, 'rock');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (9, 'rock');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (10, 'rock');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (6, 'métal');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (7, 'métal');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (8, 'métal');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (9, 'métal');
INSERT INTO Style_Artiste (idArtiste, nomStyle)
VALUES (10, 'métal');

/* Les notes doivent correspondre à des Concerts auquels l'Utilisateur a déjà assisté */
INSERT INTO NoteLieu (nom, idUtilisateur, note)
VALUES ('Paleo', 1, 0);
INSERT INTO NoteLieu (nom, idUtilisateur, note)
VALUES ('Paleo', 2, 4);

INSERT INTO NoteConcert (idConcert, idUtilisateur, note)
VALUES (2, 3, 1);
INSERT INTO NoteConcert (idConcert, idUtilisateur, note)
VALUES (2, 4, 3);
INSERT INTO NoteConcert (idConcert, idUtilisateur, note)
VALUES (2, 5, 5);

INSERT INTO NoteArtiste (idArtiste, idUtilisateur, note)
VALUES (1, 1, 2);
INSERT INTO NoteArtiste (idArtiste, idUtilisateur, note)
VALUES (2, 2, 4);
INSERT INTO NoteArtiste (idArtiste, idUtilisateur, note)
VALUES (3, 3, 5);
INSERT INTO NoteArtiste (idArtiste, idUtilisateur, note)
VALUES (4, 4, 3);
