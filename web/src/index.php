<?php

/**
 * Point d'entrée de notre application. Ici, nous chargeons le fichier routes.php qui permet de nous diriger partout dans l'application.
 * Ce fichier a été créé à l'aide d'un tutoriel: https://laracasts.com/series/php-for-beginners
 * Ce projet a été réalisé par Stéphane Marengo, Loris Marzullo et Jonathan Friedli.
 */
require 'vendor/autoload.php';
require 'core/bootstrap.php';

use App\Core\{Request, Router};

Router::load('app/routes.php')->direct(Request::uri(), Request::method());
