<?php

/**
 * Ce fichier déclare un tableau global, ainsi que deux fonctions.
 * C'est de cette manière que nous accédons à la DB depuis les classes controllers.
 * Ce fichier a été créé à l'aide d'un tutoriel: https://laracasts.com/series/php-for-beginners
 * Ce projet a été réalisé par Stéphane Marengo, Loris Marzullo et Jonathan Friedli.
 */

namespace App\Core;

use Exception;

class App
{
    protected static $registery = [];

    /**
     * Permet de stocker une info dans le tableau
     */
    public static function bind($key, $value)
    {
        static::$registery[$key] = $value;
    }

    /**
     * Permet d'accéder à une info du tableau
     */
    public static function get($key)
    {
        if (!array_key_exists($key, static::$registery)) {
            throw new Exception("No {$key} is bound in the container");
        }

        return static::$registery[$key];
    }
}
