INSERT INTO utilisateur (login, nom, prénom, motdepasse, estmodérateur)
VALUES ('a@gmail.com', 'Doe', 'John',
        '$2y$10$Tf6jDPjOEIhJKA6H6jyn6Oahpdhy7U97uJjYQF7MI07jdVMeWNMQi', FALSE);
INSERT INTO utilisateur (login, nom, prénom, motdepasse, estmodérateur)
VALUES ('b@gmail.com', 'Doe', 'Jane',
        '$2y$10$Tf6jDPjOEIhJKA6H6jyn6Oahpdhy7U97uJjYQF7MI07jdVMeWNMQi', FALSE);
INSERT INTO utilisateur (login, nom, prénom, motdepasse, estmodérateur)
VALUES ('c@gmail.com', 'Friedli', 'Jonathan',
        '$2y$10$Tf6jDPjOEIhJKA6H6jyn6Oahpdhy7U97uJjYQF7MI07jdVMeWNMQi', TRUE);
INSERT INTO utilisateur (login, nom, prénom, motdepasse, estmodérateur)
VALUES ('d@gmail.com', 'Marengo', 'Stéphane',
        '$2y$10$Tf6jDPjOEIhJKA6H6jyn6Oahpdhy7U97uJjYQF7MI07jdVMeWNMQi', TRUE);
INSERT INTO utilisateur (login, nom, prénom, motdepasse, estmodérateur)
VALUES ('e@gmail.com', 'Marzullo', 'Loris',
        '$2y$10$Tf6jDPjOEIhJKA6H6jyn6Oahpdhy7U97uJjYQF7MI07jdVMeWNMQi', TRUE);

INSERT INTO lieu (nom, capacité, nomrue, norue, npa, localité, typelieu)
VALUES ('Paleo', 230000, 'Route de Saint-Cergue', 310, 1260, 'Nyon', 'Intérieur');
INSERT INTO lieu (nom, capacité, nomrue, norue, npa, localité, typelieu)
VALUES ('Amalgame', 24000, 'Av. des Sports', 5, 1400, 'Yverdon-les-Bains', 'Intérieur');
INSERT INTO lieu (nom, capacité, nomrue, norue, npa, localité, typelieu)
VALUES ('Salle Métropole', 120000, 'Rue de Genève', 12, 1003, 'Lausanne', 'Intérieur');
INSERT INTO lieu (nom, capacité, nomrue, norue, npa, localité, typelieu)
VALUES ('Stade de France', 81000, 'Saint-Denis', 7, 9300, 'Paris', 'Extérieur');

ALTER TABLE concert DISABLE TRIGGER ALL;
INSERT INTO concert (nom, début, durée, nomlieu, idcréateur)
VALUES ('ConcertA', '2021-10-11 22:30', 130, 'Paleo', 1);
INSERT INTO concert (nom, début, durée, nomlieu, idcréateur)
VALUES ('ConcertB', '2021-11-24 21:30', 140, 'Paleo', 1);
INSERT INTO concert (nom, début, durée, nomlieu, idcréateur)
VALUES ('ConcertC', '2022-03-20 20:30', 120, 'Amalgame', 2);
INSERT INTO concert (nom, début, durée, nomlieu, idcréateur)
VALUES ('ConcertD', '2022-03-23 19:00', 60, 'Salle Métropole', 4);
INSERT INTO concert (nom, début, durée, nomlieu, idcréateur)
VALUES ('ConcertE', '2022-04-09 20:00', 180, 'Stade de France', 4);
ALTER TABLE concert ENABLE TRIGGER ALL;

/* Concerts ayant déjà eu lieu (2021) */
INSERT INTO utilisateur_concert (idconcert, idutilisateur)
VALUES (1, 1);
INSERT INTO utilisateur_concert (idconcert, idutilisateur)
VALUES (1, 2);
INSERT INTO utilisateur_concert (idconcert, idutilisateur)
VALUES (2, 3);
INSERT INTO utilisateur_concert (idconcert, idutilisateur)
VALUES (2, 4);
INSERT INTO utilisateur_concert (idconcert, idutilisateur)
VALUES (2, 5);
/* Concerts à venir (2022) */
INSERT INTO utilisateur_concert (idconcert, idutilisateur)
VALUES (3, 3);
INSERT INTO utilisateur_concert (idconcert, idutilisateur)
VALUES (3, 4);
INSERT INTO utilisateur_concert (idconcert, idutilisateur)
VALUES (3, 5);
INSERT INTO utilisateur_concert (idconcert, idutilisateur)
VALUES (4, 1);
INSERT INTO utilisateur_concert (idconcert, idutilisateur)
VALUES (4, 2);
INSERT INTO utilisateur_concert (idconcert, idutilisateur)
VALUES (5, 2);
INSERT INTO utilisateur_concert (idconcert, idutilisateur)
VALUES (5, 4);

INSERT INTO style (nom)
VALUES ('classique');
INSERT INTO style (nom)
VALUES ('jazz');
INSERT INTO style (nom)
VALUES ('rock');
INSERT INTO style (nom)
VALUES ('blues');
INSERT INTO style (nom)
VALUES ('pop');
INSERT INTO style (nom)
VALUES ('métal');
INSERT INTO style (nom)
VALUES ('rap');

/* On crée tous les artistes (solo et groupe) */
INSERT INTO artiste (nomscène)
VALUES ('John Lennon');
INSERT INTO artiste (nomscène)
VALUES ('Ringo Star');
INSERT INTO artiste (nomscène)
VALUES ('Paul McCartney');
INSERT INTO artiste (nomscène)
VALUES ('George Harrisson');
INSERT INTO artiste (nomscène)
VALUES ('Les Beatles');

/* On crée tous les artistes solo et on les binds sur un artiste */
INSERT INTO artistesolo (id, nom, prénom)
VALUES (1, 'Lennon', 'John');
INSERT INTO artistesolo (id, nom, prénom)
VALUES (2, 'Ringo', 'Star');
INSERT INTO artistesolo (id, nom, prénom)
VALUES (3, 'McCartney', 'Paulo');
INSERT INTO artistesolo (id, nom, prénom)
VALUES (4, 'Stéphane', 'Margengo');

/* On crée tous le groupe et on le bind sur l'artiste */
INSERT INTO groupe (id)
VALUES (5);

/* On ajoute les artistes dans le groupe */
INSERT INTO membre (idartistesolo, idgroupe, datedébut)
VALUES (1, 5, '2020-07-20');
INSERT INTO membre (idartistesolo, idgroupe, datedébut)
VALUES (2, 5, '2020-07-20');
INSERT INTO membre (idartistesolo, idgroupe, datedébut)
VALUES (3, 5, '2020-07-20');
INSERT INTO membre (idartistesolo, idgroupe, datedébut)
VALUES (4, 5, '2020-07-20');

/* On affecte les artistes à leur concert */
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage)
VALUES (1, 1, 1);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage)
VALUES (1, 2, 2);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage)
VALUES (2, 3, 1);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage)
VALUES (2, 4, 2);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage)
VALUES (3, 5, 1);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage)
VALUES (4, 1, 1);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage)
VALUES (4, 2, 2);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage)
VALUES (4, 3, 3);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage)
VALUES (5, 5, 1);

/* Style des artistes */
INSERT INTO style_artiste (idartiste, nomstyle)
VALUES (1, 'rock');
INSERT INTO style_artiste (idartiste, nomstyle)
VALUES (2, 'rock');
INSERT INTO style_artiste (idartiste, nomstyle)
VALUES (3, 'rock');
INSERT INTO style_artiste (idartiste, nomstyle)
VALUES (4, 'rock');
INSERT INTO style_artiste (idartiste, nomstyle)
VALUES (5, 'rock');
INSERT INTO style_artiste (idartiste, nomstyle)
VALUES (1, 'blues');
INSERT INTO style_artiste (idartiste, nomstyle)
VALUES (2, 'blues');
INSERT INTO style_artiste (idartiste, nomstyle)
VALUES (3, 'blues');
INSERT INTO style_artiste (idartiste, nomstyle)
VALUES (4, 'blues');
INSERT INTO style_artiste (idartiste, nomstyle)
VALUES (5, 'blues');

/* Les notes doivent correspondre à des concerts auquels l'utilisateur a déjà assisté */
INSERT INTO notelieu (nom, idutilisateur, note)
VALUES ('Paleo', 1, 0);
INSERT INTO notelieu (nom, idutilisateur, note)
VALUES ('Paleo', 2, 4);

INSERT INTO noteconcert (idconcert, idutilisateur, note)
VALUES (2, 3, 1);
INSERT INTO noteconcert (idconcert, idutilisateur, note)
VALUES (2, 4, 3);
INSERT INTO noteconcert (idconcert, idutilisateur, note)
VALUES (2, 5, 5);

INSERT INTO noteartiste (idartiste, idutilisateur, note)
VALUES (1, 1, 2);
INSERT INTO noteartiste (idartiste, idutilisateur, note)
VALUES (2, 2, 4);
INSERT INTO noteartiste (idartiste, idutilisateur, note)
VALUES (3, 3, 5);
INSERT INTO noteartiste (idartiste, idutilisateur, note)
VALUES (4, 4, 3);
