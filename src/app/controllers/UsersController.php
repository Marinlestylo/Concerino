<?php

namespace App\Controllers;

use App\Core\App;

class UsersController{

    public function index(){
        $users = App::get('database')->selectAll('utilisateur');

        return view('users', compact('users'));// on peut utiliser ['villes' => $villes] pour remplacer compact('villes')
    }

    public function store(){
        App::get('database')->insert('utilisateur', [
            'login' => 'g@gmail.com',
            'nom' => $_POST['name'],
            'prénom' => 'Doe',
            'motdepasse' => 'randomshit4',
            'estmodérateur' => 'FALSE'
        ]);
        
        return redirect('');
    }
}