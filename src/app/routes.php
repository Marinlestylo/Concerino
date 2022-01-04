<?php

$router->get('', 'PagesController@home');
$router->get('login', 'PagesController@login');
$router->get('createAccount', 'PagesController@createAccount');

$router->get('users', 'UsersController@index');
$router->post('users', 'UsersController@store');

$router->get('villes', 'VillesController@index');
$router->post('villes', 'VillesController@store');