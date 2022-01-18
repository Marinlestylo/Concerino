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
INSERT INTO style (nom) VALUES ('pop');
INSERT INTO style (nom) VALUES ('métal');
INSERT INTO style (nom) VALUES ('rap');