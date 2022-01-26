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

INSERT INTO lieu (nom, capacité, nomrue, norue, npa, localité, typelieu) VALUES ('Paleo', 230000, 'Route de Saint-Cergue', 310, 1260, 'Nyon', 'Intérieur');
INSERT INTO lieu (nom, capacité, nomrue, norue, npa, localité, typelieu) VALUES ('Amalgame', 24000, 'Av. des Sports', 5, 1400, 'Yverdon-les-Bains', 'Intérieur');
INSERT INTO lieu (nom, capacité, nomrue, norue, npa, localité, typelieu) VALUES ('Salle Métropole', 120000, 'Rue de Genève', 12, 1003, 'Lausanne', 'Intérieur');
INSERT INTO lieu (nom, capacité, nomrue, norue, npa, localité, typelieu) VALUES ('Stade de France', 81000, 'Saint-Denis', 7, 9300, 'Paris', 'Extérieur');

INSERT INTO concert (nom, début, durée, nomlieu, idcréateur) VALUES ('ConcertA', '2022-10-11 22:30', 130, 'Paleo', 1);
INSERT INTO concert (nom, début, durée, nomlieu, idcréateur) VALUES ('ConcertB', '2022-11-24 21:30', 140, 'Paleo', 1);
INSERT INTO concert (nom, début, durée, nomlieu, idcréateur) VALUES ('ConcertC', '2022-03-20 20:30', 120, 'Amalgame', 2);
INSERT INTO concert (nom, début, durée, nomlieu, idcréateur) VALUES ('ConcertD', '2022-03-23 19:00', 60, 'Salle Métropole', 4);
INSERT INTO concert (nom, début, durée, nomlieu, idcréateur) VALUES ('ConcertE', '2022-04-09 20:00', 180, 'Stade de France', 4);

INSERT INTO utilisateur_concert (idconcert, idutilisateur) VALUES (3, 3);
INSERT INTO utilisateur_concert (idconcert, idutilisateur) VALUES (3, 4);
INSERT INTO utilisateur_concert (idconcert, idutilisateur) VALUES (3, 5);
INSERT INTO utilisateur_concert (idconcert, idutilisateur) VALUES (4, 1);
INSERT INTO utilisateur_concert (idconcert, idutilisateur) VALUES (4, 2);
INSERT INTO utilisateur_concert (idconcert, idutilisateur) VALUES (5, 2);
INSERT INTO utilisateur_concert (idconcert, idutilisateur) VALUES (5, 4);

INSERT INTO style (nom) VALUES ('classique');
INSERT INTO style (nom) VALUES ('jazz');
INSERT INTO style (nom) VALUES ('rock');
INSERT INTO STYLE (nom) VALUES ('blues');
INSERT INTO style (nom) VALUES ('pop');
INSERT INTO style (nom) VALUES ('métal');
INSERT INTO style (nom) VALUES ('rap');

/* On crée tous les artistes (solo et groupe) */
INSERT INTO artiste (nomscène) VALUES ('John Lennon');
INSERT INTO artiste (nomscène) VALUES ('Ringo Star');
INSERT INTO artiste (nomscène) VALUES ('Paul McCartney');
INSERT INTO artiste (nomscène) VALUES ('George Harrisson');
INSERT INTO artiste (nomscène) VALUES ('Les Beatles');
INSERT INTO artiste (nomscène) VALUES ('Les Beatles2');
INSERT INTO artiste (nomscène) VALUES ('Les Beatles3');
INSERT INTO artiste (nomscène) VALUES ('Sans groupe');

/* On crée tous les artistes solo et on les binds sur un artiste*/
INSERT INTO artistesolo (id, nom, prénom) VALUES (1,'Lennon', 'John');
INSERT INTO artistesolo (id, nom, prénom) VALUES (2, 'Ringo', 'Star');
INSERT INTO artistesolo (id, nom, prénom) VALUES (3,'McCartney', 'Paulo');
INSERT INTO artistesolo (id, nom, prénom) VALUES (4, 'Stéphane', 'Marengo');
INSERT INTO artistesolo (id, nom, prénom) VALUES (8, 'Sans', 'Groupe');

/* On crée tous les groupe et on le bind sur l'artiste*/
INSERT INTO groupe (id) VALUES (5);
INSERT INTO groupe (id) VALUES (6);
INSERT INTO groupe (id) VALUES (7);

/* On ajoute les artistes dans le groupe*/
INSERT INTO membre (idartistesolo, idgroupe, datedébut) VALUES (1, 5, '2020-07-20');
INSERT INTO membre (idartistesolo, idgroupe, datedébut) VALUES (2, 5, '2020-07-20');
INSERT INTO membre (idartistesolo, idgroupe, datedébut) VALUES (3, 5, '2020-07-20');
INSERT INTO membre (idartistesolo, idgroupe, datedébut) VALUES (4, 5, '2020-07-20');
INSERT INTO membre (idartistesolo, idgroupe, datedébut, datefin) VALUES (4, 6, '2002-06-22', '2010-07-20');
INSERT INTO membre (idartistesolo, idgroupe, datedébut, datefin) VALUES (4, 7, '2011-07-20', '2018-07-20');

/* On affecte les artistes à leur concert */
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage) VALUES (1, 1, 1);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage) VALUES (1, 2, 2);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage) VALUES (2, 3, 1);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage) VALUES (2, 4, 2);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage) VALUES (3, 5, 1);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage) VALUES (4, 1, 1);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage) VALUES (4, 2, 2);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage) VALUES (4, 3, 3);
INSERT INTO concert_artiste (idconcert, idartiste, numéropassage) VALUES (5, 5, 1);

/* style des artistes */
INSERT INTO style_artiste (idartiste, nomstyle) VALUES (1, 'rock');
INSERT INTO style_artiste (idartiste, nomstyle) VALUES (2, 'rock');
INSERT INTO style_artiste (idartiste, nomstyle) VALUES (3, 'rock');
INSERT INTO style_artiste (idartiste, nomstyle) VALUES (4, 'rock');
INSERT INTO style_artiste (idartiste, nomstyle) VALUES (5, 'rock');
INSERT INTO style_artiste (idartiste, nomstyle) VALUES (1, 'blues');
INSERT INTO style_artiste (idartiste, nomstyle) VALUES (2, 'blues');
INSERT INTO style_artiste (idartiste, nomstyle) VALUES (3, 'blues');
INSERT INTO style_artiste (idartiste, nomstyle) VALUES (4, 'blues');
INSERT INTO style_artiste (idartiste, nomstyle) VALUES (5, 'blues');

