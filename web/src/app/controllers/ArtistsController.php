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

    public function detailArtist(){
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] > 32767) {
            redirect('artists');
        }

        $artist = App::get('database')->getInfoArtistSolo($_GET['id']);
        if(count($artist) == 0){
            redirect('artists');
        }
        
        // Select tous les groupes dont l'artiste à fait partie
        $groups = App::get('database')->getAllGroupsWhereIdSoloArtist($_GET['id']);
        $data = [
            'artist' => $artist,
            'groups' => $groups
        ];
        return view('artistDetails', compact('data'));
    }

    public function detailGroup(){
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] > 32767) {
            redirect('artists');
        }

        $exist = App::get('database')->selectWhereCondition('groupe', 'id', $_GET['id']);
        if(count($exist) == 0){
            redirect('artists');
        }

        $members = App::get('database')->getAllMembersOfOneGroup($_GET['id']);
        $styles = App::get('database')->getAllStylesForGroup($_GET['id']);
        $data = [
            'info' => $styles,
            'members' => $members
        ];
        return view('groupDetails', compact('data'));
    }
}
