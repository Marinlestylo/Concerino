<?php

$router->get('', 'PagesController@home');
$router->get('about', 'PagesController@about');
$router->get('contact', 'PagesController@contact');

$router->get('villes', 'VillesControllers@index');
$router->post('villes', 'VillesControllers@store');