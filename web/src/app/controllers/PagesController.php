<?php

/**
 * Ce fichier est la classe controller de base.
 * Il permet de retourner des views de base telle que la page d'accueil ou de login.
 * Ce fichier a été créé à l'aide d'un tutoriel: https://laracasts.com/series/php-for-beginners
 * Ce projet a été réalisé par Stéphane Marengo, Loris Marzullo et Jonathan Friedli.
 */

namespace App\Controllers;

session_start();

class PagesController
{

    /**
     * Revoie la page d'accueil
     */
    public function home()
    {
        return view('index');
    }

    /**
     * Revoie la page de login
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Revoie la page de création de compte
     */
    public function createAccount()
    {
        return view('createAccount');
    }
}
