<?php

namespace App\Controllers;

session_start();

use App\Core\App;

class ConcertsController
{

    public function index()
    {
        $concerts = App::get('database')->selectAll('concert');
        for ($i = 0; $i < count($concerts); $i++) {
            $user = App::get('database')->selectWhereCondition('utilisateur', 'id', $concerts[$i]->idcréateur);
            $concerts[$i]->login = $user[0]->login;
            $concerts[$i]->nomUser = $user[0]->nom;
            $concerts[$i]->prénom = $user[0]->prénom;
        }

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
        $concert = App::get('database')->selectWhereCondition('concert', 'id', $_GET['id']);
        // Si on en trouve aucun, redirect
        if (count($concert) == 0) {
            redirect('concerts');
        }

        $user = App::get('database')->selectWhereCondition('utilisateur', 'id', $concert[0]->idcréateur);
        $concert[0]->nomUser = $user[0]->nom;
        $concert[0]->prénom = $user[0]->prénom;
        return view('concertDetails', compact('concert'));
    }
}
