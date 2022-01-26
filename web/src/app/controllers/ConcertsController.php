<?php

/**
 * Ce fichier est la classe controller des concerts.
 * Il permet de faire des requêtes à propos des concerts à la db et renvoie les views concernant les concerts.
 * Ce projet a été réalisé par Stéphane Marengo, Loris Marzullo et Jonathan Friedli.
 */

namespace App\Controllers;

session_start();

use App\Core\App;

class ConcertsController
{
    /**  
     * Affiche toutes les infos du concert et quelques infos de son créateur
     */
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
            redirect('concerts');
        }
        // Select l'utilisateur ayant l'id passé en paramètre
        $concert = App::get('database')->SelectOneConcertAndInfos($_GET['id']);
        // Si on en trouve aucun, redirect
        if (count($concert) == 0) {
            redirect('concerts');
        }
        $artists = App::get('database')->SelectArtistsOfOneConcert($_GET['id']);
        $users = App::get('database')->SelecAttendeeOfOneConcert($_GET['id']);
        $canSignup = false;
        if(isset($_SESSION['id'])){
            $canSignup = App::get('database')->canUserSignUpForThisConcert($_SESSION['id'], $_GET['id']);
        }
        $data = [
            'concert' => $concert,
            'artists' => $artists,
            'users' => $users,
            'signUp' => $canSignup
        ];
        // dd($data);
        return view('concertDetails', compact('data'));
    }

    /**
     * Affiche le formulaire de création de concert
     */
    public function createConcert(){
        if(!isset($_SESSION["login"])){
            return view('notLogged');
        }
        $lieux = App::get('database')->selectNomFromLieu();
        $artists = App::get('database')->selectAll('artiste');
        $data = [
            'lieux' => $lieux,
            'artists' => $artists
        ];
        // dd($data);
        return view('createConcert', compact('data'));
    }

    /**
     * Ajoute un concert dans la DB
     */
    public function store(){
        // Si un des champs est vide, on renvoie à la view de création
        if(!isset($_POST['name']) || !isset($_POST['date']) || !isset($_POST['hour']) || !isset($_POST['duration']) || !isset($_POST['place'])){
            return $this->createConcert();
        }

        $concert = [
            'nom' => $_POST['name'],
            'début' => $_POST['date'] . ' ' . $_POST['hour'],
            'durée' => $_POST['duration'],
            'nomlieu' => $_POST["place"],
            'idcréateur' => $_SESSION['id']
        ];
        $error = App::get('database')->insert('concert', $concert);
        if($error){
            return view('error');
        }

        return redirect('concerts');
    }

    /**
     * Inscrit le user au concert
     */

     public function signup(){
         $ids = [
            'idconcert' => $_POST['idConcert'],
            'idutilisateur' => $_POST['idUser']
         ];
         $error = App::get('database')->insert('utilisateur_concert', $ids);
         if($error){
            return view('error');
        }

        return redirect('');
     }
}
