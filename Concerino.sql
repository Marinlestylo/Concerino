set client_encoding to 'UTF8';

DROP TYPE IF EXISTS TypeLieu CASCADE;
CREATE TYPE TypeLieu AS ENUM ('Int�rieur', 'Ext�rieur');

DROP TABLE IF EXISTS Lieu CASCADE;
CREATE TABLE Lieu
(
    nom      VARCHAR(50),
    capacit� INTEGER     NOT NULL,
    nomRue   VARCHAR(50) NOT NULL,
    noRue    VARCHAR(10) NOT NULL,
    npa      SMALLINT    NOT NULL,
    localit� VARCHAR(50) NOT NULL,
    typeLieu TypeLieu    NOT NULL,
    CONSTRAINT PK_Lieu PRIMARY KEY (nom)
);

DROP TABLE IF EXISTS Concert CASCADE;
CREATE TABLE Concert
(
    id         SMALLSERIAL,
    nom        VARCHAR(50)  NOT NULL,
    d�but      TIMESTAMP(0) NOT NULL,
    dur�e      SMALLINT     NOT NULL,
    nomLieu    VARCHAR(50)  NOT NULL,
    idCr�ateur SMALLINT     NOT NULL,
    CONSTRAINT PK_Concert PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Utilisateur CASCADE;
CREATE TABLE Utilisateur
(
    id            SMALLSERIAL,
    login         VARCHAR(50) NOT NULL,
    nom           VARCHAR(50) NOT NULL,
    pr�nom        VARCHAR(50) NOT NULL,
    motDePasse    CHAR(60)    NOT NULL,
    estMod�rateur BOOLEAN     NOT NULL,
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
    nomSc�ne VARCHAR(50) NOT NULL,
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
    num�roPassage SMALLINT NOT NULL,
    CONSTRAINT PK_Concert_Artiste PRIMARY KEY (idConcert, idArtiste)
);

DROP TABLE IF EXISTS ArtisteSolo CASCADE;
CREATE TABLE ArtisteSolo
(
    id     SMALLINT,
    nom    VARCHAR(50) NOT NULL,
    pr�nom VARCHAR(50) NOT NULL,
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
    dateD�but     DATE,
    dateFin       DATE NULL,
    CONSTRAINT PK_Membre PRIMARY KEY (idArtisteSolo, idGroupe, dateD�but)
);

DROP TABLE IF EXISTS NoteLieu CASCADE;
CREATE TABLE NoteLieu
(
    nom           VARCHAR(50),
    idUtilisateur SMALLSERIAL,
    date          DATE DEFAULT CURRENT_DATE,
    note          SMALLINT NOT NULL,
    CONSTRAINT PK_NoteLieu PRIMARY KEY (nom, idUtilisateur, date)
);

DROP TABLE IF EXISTS NoteConcert CASCADE;
CREATE TABLE NoteConcert
(
    idConcert     SMALLSERIAL,
    idUtilisateur SMALLSERIAL,
    date          DATE DEFAULT CURRENT_DATE,
    note          SMALLINT NOT NULL,
    CONSTRAINT PK_NoteConcert PRIMARY KEY (idConcert, idUtilisateur, date)
);

DROP TABLE IF EXISTS NoteArtiste CASCADE;
CREATE TABLE NoteArtiste
(
    idArtiste     SMALLSERIAL,
    idUtilisateur SMALLSERIAL,
    date          DATE DEFAULT CURRENT_DATE,
    note          SMALLINT NOT NULL,
    CONSTRAINT PK_NoteArtiste PRIMARY KEY (idArtiste, idUtilisateur, date)
);

ALTER TABLE Concert
    ADD CONSTRAINT FK_Concert_nomLieu
        FOREIGN KEY (nomLieu)
            REFERENCES Lieu (nom)
            ON UPDATE CASCADE,
    ADD CONSTRAINT FK_Concert_idCr�ateur
        FOREIGN KEY (idCr�ateur)
            REFERENCES Utilisateur (id)
            ON UPDATE CASCADE,
    ADD CONSTRAINT CK_Concert_d�but
        CHECK (d�but > NOW()),
    ADD CONSTRAINT CK_Concert_dur�e
        CHECK (dur�e > 0);

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
    ADD CONSTRAINT CK_Concert_Artiste_num�roPassage
        CHECK (num�roPassage > 0);

ALTER TABLE Lieu
    ADD CONSTRAINT CK_Lieu_capacit�
        CHECK (capacit� > 0),
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
        CHECK (dateFin >= dateD�but);

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
        CHECK (note BETWEEN 1 AND 5),
    ADD CONSTRAINT CK_NoteLieu_date
        CHECK (date = CURRENT_DATE);

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
        CHECK (note BETWEEN 1 AND 5),
    ADD CONSTRAINT CK_NoteConcert_date
        CHECK (date = CURRENT_DATE);

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
        CHECK (note BETWEEN 1 AND 5),
    ADD CONSTRAINT CK_NoteArtiste_date
        CHECK (date = CURRENT_DATE);

CREATE INDEX IDX_FK_Concert_nomLieu ON Concert (nomLieu ASC);
CREATE INDEX IDX_FK_Concert_idCr�ateur ON Concert (idCr�ateur ASC);
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