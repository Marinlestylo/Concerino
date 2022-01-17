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

    public function store(){
        // Si un des champs est vide, on renvoie à la view de création
        if(!isset($_POST['name']) || !isset($_POST['capacity']) || !isset($_POST['streetName']) || !isset($_POST['streetNumber']) || !isset($_POST['npa']) || !isset($_POST['city'])|| !isset($_POST['type'])){
            return $this->createRoom();
        }

        $lieu = [
            'nom' => $_POST['name'],
            'capacité' => $_POST['capacity'],
            'nomrue' => $_POST['streetName'],
            'norue' => $_POST["streetNumber"],
            'npa' => $_POST['npa'],
            'localité' => $_POST['city'],
            'typelieu' => $_POST['type']
        ];
        $error = App::get('database')->insert('lieu', $lieu);
        if($error){
            return view('error');
        }

        return redirect('rooms');
    }
}
