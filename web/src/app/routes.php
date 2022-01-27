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
$router->post('promote', 'UsersController@promote'); // Promouvoir un utilisateur en modo

$router->get('concerts', 'ConcertsController@index'); // Afficher tous les concerts
$router->get('concert', 'ConcertsController@detail'); // Page pour 1 concert
$router->get('createConcert', 'ConcertsController@createConcert'); // Page de création d'un concert (view)
$router->post('createConcert', 'ConcertsController@store'); // Page de création d'un concert (creation dans la db)
$router->post('signup', 'ConcertsController@signup'); // S'inscrire à un concert
$router->post('unsign', 'ConcertsController@unsign'); // Se désinscrire à un concert
$router->post('deleteConcert', 'ConcertsController@delete'); // S'inscrire à un concert
$router->post('noteConcert', 'ConcertsController@note'); // Voter pour un concert

$router->get('rooms', 'RoomsController@index'); // Afficher toutes les salles
$router->get('room', 'RoomsController@detail');// Page pour 1 salle
$router->get('createRoom', 'RoomsController@createRoom');// Page pour créer une salle (view)
$router->post('createRoom', 'RoomsController@store');// Page pour créer une salle (création dans la db)
$router->post('noteRoom', 'RoomsController@note');// Noter une salle de concert

$router->get('artists', 'ArtistsController@index'); // Affiche tous les artistes
$router->get('artist', 'ArtistsController@detailArtist'); // Affiche les infos de 1 artistesolo
$router->get('group', 'ArtistsController@detailGroup'); // Affiche les infos de 1 groupe
$router->get('createArtist', 'ArtistsController@createArtist'); // Créer un artist (formulaire)
$router->post('createArtist', 'ArtistsController@storeArtist'); // Créer un artist solo
$router->get('createGroup', 'ArtistsController@createGroup'); // Créer un groupe (formulaire)
$router->post('createGroup', 'ArtistsController@storeGroup'); // Créer un groupe
$router->post('noteArtist', 'ArtistsController@note'); // Noter un artiste solo ou un groupe