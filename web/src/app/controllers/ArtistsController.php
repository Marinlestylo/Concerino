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
    public function index()
    {
        $artists = App::get('database')->getAllArtistsSolo();
        $groups = App::get('database')->getAllGroups();
        $data = [
            'artists' => $artists,
            'groups' => $groups

        ];
        return view('artists', compact('data'));
    }

    /**
     * Renvoie le formulaire pour la création d'un artiste
     */
    public function createArtist()
    {
        if (!isset($_SESSION["login"])) {
            return view('notLogged');
        }
        $styles = App::get('database')->selectAll('style');
        $groups = App::get('database')->getAllGroups();
        $data = [
            'styles' => $styles,
            'groups' => $groups
        ];
        return view('createArtist', compact('data'));
    }

    /**
     * Permet de stocker un nouvel artiste
     */
    public function storeArtist()
    {
        $params1 = ['nomscène' => $_POST['Sname']];
        $params2 = ['id' => 0, 'nom' => $_POST['lName'], 'prénom' => $_POST['fName']];
        $params3 = [];
        if ($_POST['group'] != "None") {
            $params3 = ['idartistesolo' => 0, 'idgroupe' => $_POST['group'], 'datedébut' => $_POST['date']];
        }
        $params4 = [];
        if (isset($_POST['styles'])) {
            $params4 = $_POST['styles'];
        }
        $error = App::get('database')->createSoloArtiste($params1, $params2, $params3, $params4);
        if ($error) {
            return view('error');
        }

        return $this->index();
    }

    /**
     * Renvoie le formulaire pour créer un groupe
     */
    public function createGroup()
    {
        if (!isset($_SESSION["login"])) {
            return view('notLogged');
        }
        $styles = App::get('database')->selectAll('style');
        $artist = App::get('database')->getAllArtistsSolo();
        $data = [
            'styles' => $styles,
            'artists' => $artist
        ];
        return view('createGroup', compact('data'));
    }

    /**
     * Permet de stocker un nouveau groupe
     */
    public function storeGroup()
    {
        if (!isset($_POST['members'])) {
            return view('error');
        }
        $members = $_POST['members'];
        $dates = $_POST['dates'];
        $dates = array_diff($dates, array("")); // On enlève tous les ""
        if (count($dates) != count($members)) {
            return view('error');
        }
        $params1 = ['nomscène' => $_POST['Sname']];

        $params2 = [];
        $i = 0;
        foreach ($dates as $date) {
            array_push($params2, $members[$i++]);
            array_push($params2, date("Y-m-d", strtotime($date)));
        }

        $params3 = [];
        if (isset($_POST['styles'])) {
            $params3 = $_POST['styles'];
        }

        $error = App::get('database')->createGroup($params1, $params2, $params3);
        if ($error) {
            return view('error');
        }

        return $this->index();
    }

    /**
     * Donne tous les détails d'un artiste
     */
    public function detailArtist()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] > 32767) {
            redirect('artists');
        }

        $artist = App::get('database')->getInfoArtistSolo($_GET['id']);
        if (count($artist) == 0) {
            redirect('artists');
        }

        // Select tous les groupes dont l'artiste à fait partie
        $groups = App::get('database')->getAllGroupsWhereIdSoloArtist($_GET['id']);
        $moyenne = App::get('database')->getAVGFromTable('noteartiste', 'idartiste', $_GET['id']);
        $suggestions = App::get('database')->getSuggestionsFromArtist($_GET['id']);

        $data = [
            'artist' => $artist,
            'groups' => $groups,
            'moyenne' => $moyenne,
            'suggestions' => $suggestions
        ];
        return view('artistDetails', compact('data'));
    }

    /**
     * Donne tous les détails d'un groupe
     */
    public function detailGroup()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] > 32767) {
            redirect('artists');
        }

        $exist = App::get('database')->selectWhereCondition('groupe', 'id', $_GET['id']);
        if (count($exist) == 0) {
            redirect('artists');
        }

        $members = App::get('database')->getAllMembersOfOneGroup($_GET['id']);
        $styles = App::get('database')->getAllStylesForGroup($_GET['id']);
        $moyenne = App::get('database')->getAVGFromTable('noteartiste', 'idartiste', $_GET['id']);
        $suggestions = App::get('database')->getSuggestionsFromArtist($_GET['id']);

        $data = [
            'info' => $styles,
            'members' => $members,
            'moyenne' => $moyenne,
            'suggestions' => $suggestions
        ];
        return view('groupDetails', compact('data'));
    }

    /**
     * Noter un artist
     */
    public function note()
    {
        if (is_numeric($_POST['note']) && $_POST['note'] < 6 && $_POST['note'] > -1) {
            $data = ['idartiste' => $_POST['idArtist'], 'idutilisateur' => $_POST['idUser'], 'note' => $_POST['note']];
            $error = App::get('database')->insert('noteartiste', $data);
            if (!$error) {
                return $this->index();
            }
        }
        return view('error');
    }
}
