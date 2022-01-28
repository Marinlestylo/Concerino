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
