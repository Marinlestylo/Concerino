<?php

/**
 * Ce fichier contient toutes les querry pgsql.
 * Ce fichier a été créé à l'aide d'un tutoriel: https://laracasts.com/series/php-for-beginners
 * Ce projet a été réalisé par Stéphane Marengo, Loris Marzullo et Jonathan Friedli.
 */

class QueryBuilder
{

    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Select * from table (sans condition)
     * TODO: Enlever cette function
     */
    public function selectAll($table)
    {
        $stat = $this->pdo->prepare("SELECT * FROM {$table}");

        $stat->execute();

        return $stat->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Select * avec une condition where
     */
    public function SelectWhereCondition($table, $col, $val)
    {
        $statement = $this->pdo->prepare("SELECT * FROM {$table} WHERE {$col} = '{$val}'");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Insert des données dans la db en fonction des paramètres passé.
     * $params est un tableau
     * TODO: Enlever le commentaire
     */
    public function insert($table, $params)
    {
        $placeholder = '?';
        $nb = count($params);
        for ($i = 1; $i < $nb; $i++) {
            $placeholder = $placeholder . ", ?";
        }

        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($params)),
            $placeholder
        );

        try {
            $statement = $this->pdo->prepare($sql);

            $statement->execute(array_values($params));
        } catch (Exception $e) {
            //die($e->getMessage());
            return true;
        }
        return false;
    }

    /**
     * Fonction permettant de preparer puis d'exécuter une query
     * Cette fonction est appelée par toutes les fonctions suivantes
     */
    public function prepareExecute($query)
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    /* ------------------------------- Querry concernant les utilisateurs ------------------------------- */

    /**
     * Sélectionne toutes les informations, concernant l'utilisateur, que l'on va afficher à l'écran.
     * $id est l'id de l'utilisateur en question
     */
    public function selectUserInfo($id)
    {
        $query = "SELECT id, login, nom, prénom, estmodérateur FROM utilisateur WHERE id = $id;";
        return $this->prepareExecute($query);
    }


    /* ------------------------------- Querry concernant les concerts ------------------------------- */

    /**
     * Sélectionne les informations liées au concert, à l'utilisateur qui l'a créé et aux nombre de participant de chaque concert.
     */
    public function selectConcertsAndUser()
    {
        $query = "SELECT concert.id, concert.nom, concert.début, concert.durée, concert.nomlieu, concert.idcréateur, 
        utilisateur.nom AS \"nomUser\", utilisateur.prénom, count(utilisateur_concert.idutilisateur) AS nbParticipant, lieu.capacité AS nbMaxParticipant
        FROM concert 
        INNER JOIN utilisateur ON concert.idcréateur = utilisateur.id
        INNER JOIN lieu ON concert.nomlieu = lieu.nom 
        LEFT JOIN utilisateur_concert ON concert.id = utilisateur_concert.idconcert
        GROUP BY concert.id, utilisateur.nom, utilisateur.prénom, lieu.capacité
        ORDER BY début;";

        return $this->prepareExecute($query);
    }

    /**
     * Select les infos de la table concert ainsi que des infos sur le créateur du concert
     * avec une condition where afin de n'en retourner que le concert qui nous intéresse.
     */
    public function selectOneConcertAndUser($id)
    {
        $query = "SELECT concert.id, concert.nom, concert.début, concert.durée, concert.nomlieu, concert.idcréateur, utilisateur.nom AS \"nomUser\",
                     utilisateur.prénom FROM concert INNER JOIN utilisateur ON concert.idcréateur = utilisateur.id WHERE concert.id = {$id};";

        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne tous les concerts qui sont prévu dans le futur
     */
    public function getFiveNextConcerts()
    {
        $query = "SELECT concert.id, concert.nom, concert.début, concert.durée, concert.nomlieu, concert.idcréateur, utilisateur.nom AS \"nomUser\", utilisateur.prénom 
                    FROM concert 
                    INNER JOIN utilisateur ON concert.idcréateur = utilisateur.id 
                    WHERE début > now() 
                    ORDER BY début 
                    LIMIT 5;";
        return $this->prepareExecute($query);
    }


    /* ------------------------------- Querry concernant les Lieux ------------------------------- */

    /**
     * Sélectionne tous les noms de lieux (utile pour la création de concert)
     */
    public function selectNomFromLieu()
    {
        $query = "SELECT nom FROM lieu;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne toutes les valeurs possible de l'énum type lieu 
     */
    public function getTypeLieu()
    {
        $query = "SELECT unnest(enum_range(NULL::TypeLieu));";
        return $this->prepareExecute($query);
    }

    /* ------------------------------- Querry concernant les Artistes ------------------------------- */

    /**
     * Sélectionne tous les artistes solo
     */
    public function getAllArtistsSolo()
    {
        $query = "SELECT artistesolo.id, artistesolo.nom, artistesolo.prénom, artiste.nomscène 
                    FROM artistesolo INNER JOIN artiste ON artistesolo.id = artiste.id;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne tous les artistes solo
     */
    public function getAllGroups()
    {
        $query = "SELECT groupe.id, artiste.nomscène FROM groupe INNER JOIN artiste ON groupe.id = artiste.id;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne tous les groupes dont l'artiste solo à fait partie
     */
    public function getAllGroupsWhereIdSoloArtist($id)
    {

        $query = "SELECT artiste.nomscène, artiste.id, string_agg(style_artiste.nomstyle::text, ', ') AS styles, membre.dateDébut, membre.datefin 
                    FROM membre 
                    INNER JOIN artiste ON Membre.idGroupe = artiste.id 
                    INNER JOIN style_artiste ON membre.idArtisteSolo = style_artiste.idartiste
                    WHERE membre.idArtisteSolo = $id
                    GROUP BY artiste.nomscène, artiste.id, membre.dateDébut, membre.dateFin 
                    ORDER BY membre.dateDébut DESC;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne toutes les infos liée à un artiste
     */
    public function getInfoArtistSolo($id)
    {
        $query = "SELECT artiste.nomscène as nomScène, nom, prénom, STRING_AGG(nomstyle::TEXT, ', ') as styles, artisteGroupe.nomscène as nomGroupe, artisteGroupe.id
                    FROM artiste
                    INNER JOIN artistesolo ON artiste.id = artistesolo.id
                    LEFT JOIN style_artiste ON artiste.id = style_artiste.idartiste
                    LEFT JOIN membre ON artistesolo.id = membre.idartistesolo AND (membre.datefin IS NULL OR membre.datefin > CURRENT_DATE)
                    LEFT JOIN artiste artisteGroupe ON artisteGroupe.id = membre.idgroupe
                    WHERE artiste.id = $id
                    GROUP BY artiste.id, artistesolo.id, artisteGroupe.id;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne tous les artistes ayant fait partie d'un groupe en particulier
     */
    public function getAllMembersOfOneGroup($id)
    {
        $query = "SELECT membre.idartistesolo, artiste.nomscène, membre.datedébut, membre.datefin FROM membre 
                    INNER JOIN artiste ON membre.idartistesolo = artiste.id 
                    WHERE membre.idgroupe = $id;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne tous les styles de musique qu'un groupe représente
     */
    public function getAllStylesForGroup($id)
    {
        $query = "SELECT artiste.nomscène, STRING_AGG(style_artiste.nomstyle::TEXT, ', ') as styles FROM groupe
                    INNER JOIN artiste ON groupe.id = artiste.id
                    LEFT JOIN style_artiste ON groupe.id = style_artiste.idartiste
                    WHERE groupe.id = $id
                    GROUP BY groupe.id, artiste.nomscène;";
        return $this->prepareExecute($query);
    }
}
