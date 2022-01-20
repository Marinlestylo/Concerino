<?php

/**
 * Ce fichier est la classe controller des artistes.
 * Il permet de retourner de montrer tous les artistes ainsi que d'en créer.
 * Ce projet a été réalisé par Stéphane Marengo, Loris Marzullo et Jonathan Friedli.
 */

namespace App\Controllers;

session_start();

use App\Core\App;

class ArtistsController
{

    /**
     * Afficher tous les artistes
     */
    public function index(){
        $artists = App::get('database')->getAllArtistsSolo();
        $groups = App::get('database')->getAllGroups();
        $data = [
            'artists' => $artists,
            'groups' => $groups

        ];
        return view('artists', compact('data'));
    }
}
