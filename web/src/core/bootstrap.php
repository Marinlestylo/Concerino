<?php

/**
 * Ce fichier permet de faire le lien ave la DB.
 * Il contient également des fonctions "Helpers".
 * Ce fichier a été créé à l'aide d'un tutoriel: https://laracasts.com/series/php-for-beginners
 * Ce projet a été réalisé par Stéphane Marengo, Loris Marzullo et Jonathan Friedli.
 */

use App\Core\App;

App::bind('config', require 'config.php');

App::bind('database', new QueryBuilder(Connection::make(App::get('config')['database'])));

/**
 * Renvoie une view avec les data voulues.
 * Si l'on ne veut pas de data, le tableau est vide.
 */
function view($name, $data = [])
{
    extract($data);
    return require "app/views/{$name}.view.php";
}

/**
 * Permet de rediriger vers une autre page
 */
function redirect($path)
{
    header("Location: /{$path}");
}

/**
 * Fonction de debug, permettant d'afficher le contenu d'une variable et ensuite de stoper l'execution de l'application
 */

function dd($val)
{
    die(var_dump($val));
}
