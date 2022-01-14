<?php

namespace App\Controllers;

session_start();

use App\Core\App;

class RoomsController{

    public function index(){
        $rooms = App::get('database')->selectAll('lieu');

        return view('rooms', compact('rooms'));
    }

    /**
     * Afficher les détails d'un utilisateur
     */
    public function detail(){
        if(!isset($_GET['nom'])){
            redirect('rooms');
        }
        // Select l'utilisateur ayant l'id passé en paramètre
        $room = App::get('database')->selectWhereCondition('lieu', 'nom', $_GET['nom']);
        // Si on en trouve aucun, redirect
        if(count($room) == 0){
            redirect('rooms');
        }
        return view('roomDetails', compact('room'));
    }
}