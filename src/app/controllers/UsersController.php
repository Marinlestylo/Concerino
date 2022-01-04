<?php

namespace App\Controllers;

session_start();

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
            'motdepasse' => password_hash($_POST["password"], PASSWORD_DEFAULT),
            'estmodérateur' => 'FALSE'
        ]);
        
        return redirect('users');
    }

    public function login() {
        $acc = App::get('database')->selectWhereCondition('utilisateur', 'login', $_POST['email']);

        if(count($acc) < 0){
            redirect('login');
        }
        if(password_verify($_POST['password'], $acc[0]->motdepasse)){
            $_SESSION['login'] = $acc[0]->login;
            $_SESSION['nom'] = $acc[0]->nom;
            $_SESSION['prénom'] = $acc[0]->prénom;
            $_SESSION['isAdmin'] = $acc[0]->estmodérateur;
            redirect('');
        }else{
            redirect('login');
        }
    }

    public function logout(){
        session_destroy();
        redirect('');
    }
}