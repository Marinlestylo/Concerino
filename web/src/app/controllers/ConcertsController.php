<?php

namespace App\Controllers;

session_start();

use App\Core\App;

class ConcertsController
{
    // Affiche toutes les infos du concert et quelques infos de son créateur
    public function index()
    {
        $concerts = App::get('database')->selectConcertsAndUser();

        return view('concerts', compact('concerts'));
    }

    /**
     * Afficher les détails d'un concert
     */
    public function detail()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] > 32767) {
            redirect('users');
        }
        // Select l'utilisateur ayant l'id passé en paramètre
        $concert = App::get('database')->selectOneConcertAndUser($_GET['id']);
        // Si on en trouve aucun, redirect
        if (count($concert) == 0) {
            redirect('concerts');
        }
        return view('concertDetails', compact('concert'));
    }
}
