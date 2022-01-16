<?php

/**
 * Ce fichier est la classe controller des salles.
 * Il permet de faire des requêtes à propos des salles à la db et renvoie les views concernant les salles.
 * Ce projet a été réalisé par Stéphane Marengo, Loris Marzullo et Jonathan Friedli.
 */

namespace App\Controllers;

session_start();

use App\Core\App;

class RoomsController
{

    /**
     * Retourne tous les lieux contenu dans la db
     */
    public function index()
    {
        $rooms = App::get('database')->selectAll('lieu');

        return view('rooms', compact('rooms'));
    }

    /**
     * Afficher les détails d'une salle
     */
    public function detail()
    {
        if (!isset($_GET['nom'])) {
            redirect('rooms');
        }
        // Select l'utilisateur ayant l'id passé en paramètre
        $room = App::get('database')->selectWhereCondition('lieu', 'nom', $_GET['nom']);
        // Si on en trouve aucun, redirect
        if (count($room) == 0) {
            redirect('rooms');
        }
        return view('roomDetails', compact('room'));
    }

    /**
     * Affiche le formulaire de création de salle
     */
    public function createRoom(){
        if(!isset($_SESSION["login"])){
            return view('notLogged');
        }
        $typeLieu = App::get('database')->getTypeLieu();
        return view('createRoom', compact('typeLieu'));
    }
}
