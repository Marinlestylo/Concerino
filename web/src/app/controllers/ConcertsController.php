<?php

namespace App\Controllers;

session_start();

use App\Core\App;

class ConcertsController{

    public function index(){
        $concerts = App::get('database')->selectAll('concert');
        $users = [];
        for ($i = 0; $i < count($concerts); $i++){
            $user = App::get('database')->selectWhereCondition('utilisateur', 'id', $concerts[$i]->idcréateur);
            $concerts[$i]->login = $user[0]->login;
            $concerts[$i]->nomUser = $user[0]->nom;
            $concerts[$i]->prénom = $user[0]->prénom;
        }

        return view('concerts', compact('concerts'));
    }
}