<?php

/**
 * Ce fichier est la classe controller des utilisateurs.
 * Il permet de faire des requêtes à propos des utilisateurs à la db et renvoie les views concernant les utilisateurs.
 * Il permet égalemnent de gérer la connexion d'utilisateur ainsi que sa deconnexion.
 * Ce projet a été réalisé par Stéphane Marengo, Loris Marzullo et Jonathan Friedli.
 */

namespace App\Controllers;

session_start();

use App\Core\App;

class UsersController
{

    public function index()
    {
        $users = App::get('database')->selectAll('utilisateur');

        return view('users', compact('users')); // on peut utiliser ['users' => $users] pour remplacer compact('users')
    }

    /**
     * Ajouter un utilisateur dans la db
     */
    public function store()
    {
        App::get('database')->insert('utilisateur', [
            'login' => $_POST['email'],
            'nom' => $_POST['name'],
            'prénom' => $_POST['fname'],
            'motdepasse' => password_hash($_POST["password"], PASSWORD_DEFAULT),
            'estmodérateur' => 'FALSE'
        ]);

        return redirect('login');
    }

    /**
     * Permet de se connecter
     */
    public function login()
    {
        $acc = App::get('database')->selectWhereCondition('utilisateur', 'login', $_POST['email']);

        if (count($acc) < 0) {
            redirect('login');
        }
        if (password_verify($_POST['password'], $acc[0]->motdepasse)) {
            $_SESSION['id'] = $acc[0]->id;
            $_SESSION['login'] = $acc[0]->login;
            $_SESSION['nom'] = $acc[0]->nom;
            $_SESSION['prénom'] = $acc[0]->prénom;
            $_SESSION['isAdmin'] = $acc[0]->estmodérateur;
            redirect('');
        } else {
            redirect('login');
        }
    }

    /**
     * Afficher les détails d'un utilisateur
     */
    public function detail()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] > 32767) {
            redirect('users');
        }
        // Select l'utilisateur ayant l'id passé en paramètre
        $user = App::get('database')->selectWhereCondition('utilisateur', 'id', $_GET['id']);
        // Si on en trouve aucun, redirect
        if (count($user) == 0) {
            redirect('users');
        }
        return view('userDetails', compact('user'));
    }

    /**
     * Permet de se déconnecter
     */
    public function logout()
    {
        session_destroy();
        redirect('');
    }
}
