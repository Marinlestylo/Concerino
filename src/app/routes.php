<?php

$router->get('', 'PagesController@home');
$router->get('login', 'PagesController@login');
$router->get('createAccount', 'PagesController@createAccount');

$router->get('users', 'UsersController@index');// Afficher tous les users
$router->post('users', 'UsersController@store');// Créer un utilisateur
$router->post('login', 'UsersController@login');// S'identifier
$router->get('logout', 'UsersController@logout');// Se logout

$router->get('villes', 'VillesController@index');
$router->post('villes', 'VillesController@store');