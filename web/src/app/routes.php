<?php

/**
 * Ce fichier déclare toutes les routes qui sont disponible sur notre applications ainsi que la view qui va avec.
 * Les fonction get représente des requêtes HTTTP de type GET. Pareil pour les post
 * Ce fichier a été créé à l'aide d'un tutoriel: https://laracasts.com/series/php-for-beginners
 * Ce projet a été réalisé par Stéphane Marengo, Loris Marzullo et Jonathan Friedli.
 */

$router->get('', 'PagesController@home');
$router->get('login', 'PagesController@login');
$router->get('createAccount', 'PagesController@createAccount');

$router->get('users', 'UsersController@index'); // Afficher tous les users
$router->get('user', 'UsersController@detail'); // Page pour 1 user
$router->post('users', 'UsersController@store'); // Créer un utilisateur
$router->post('login', 'UsersController@login'); // S'identifier
$router->get('logout', 'UsersController@logout'); // Se logout

$router->get('concerts', 'ConcertsController@index'); // Afficher tous les concerts
$router->get('concert', 'ConcertsController@detail'); // Page pour 1 concert

$router->get('rooms', 'RoomsController@index'); // Afficher toutes les salles
$router->get('room', 'RoomsController@detail');// Page pour 1 salle