<?php

namespace App\Controllers;

use App\Core\App;

class UsersController{

    public function index(){
        $users = App::get('database')->selectAll('utilisateur');

        return view('users', compact('users'));// on peut utiliser ['villes' => $villes] pour remplacer compact('villes')
    }

    public function store(){
        // todo : faire les checks (pas sur qu'on en ait besoin vu que c'est un projet de bdr)
        App::get('database')->insert('utilisateur', [
            'login' => $_POST['email'],
            'nom' => $_POST['name'],
            'prénom' => $_POST['fname'],
            'motdepasse' => password_hash($_POST["password"], PASSWORD_BCRYPT),
            'estmodérateur' => 'FALSE'
        ]);
        
        return redirect('users');
    }
}