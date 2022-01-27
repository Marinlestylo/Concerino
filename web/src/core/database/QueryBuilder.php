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
     * Fonction pour obtenir une moyenne de note
     */
    public function getAVGFromTable($tableName, $colName, $val)
    {
        $query = "SELECT avg(note) AS moyenne FROM $tableName WHERE $colName = $val;";
        return $this->prepareExecute($query);
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

    public function selectEveryConcertUserWentTo($idUser)
    {
        $query = "SELECT id, nom, début, durée, nomlieu FROM utilisateur_concert INNER JOIN concert ON utilisateur_concert.idconcert = concert.id WHERE idutilisateur = $idUser;";
        return $this->prepareExecute($query);
    }

    public function showVotes($idUser)
    {
        $queryNoteArtist = "SELECT idArtiste, note, nomscène FROM noteartiste INNER JOIN artiste ON noteartiste.idartiste = artiste.id WHERE idutilisateur = $idUser;";
        $queryNoteConcert = "SELECT idconcert, note, nom FROM noteconcert INNER JOIN concert ON noteconcert.idconcert = concert.id WHERE idutilisateur = $idUser;";
        $queryNoteLieu = "SELECT nom, note FROM notelieu WHERE idutilisateur = $idUser;";
        $artist = $this->prepareExecute($queryNoteArtist);
        $concerts = $this->prepareExecute($queryNoteConcert);
        $lieux = $this->prepareExecute($queryNoteLieu);
        return [
            'artists' => $artist,
            'concerts' => $concerts,
            'lieux' => $lieux
        ];
    }

    /**
     * Promouvoir un user en admin
     */
    public function promoteAdmin($id)
    {
        $query = "UPDATE utilisateur SET estmodérateur = TRUE WHERE id = $id;";
        return $this->prepareExecute($query);
    }

    /* ------------------------------- Querry concernant les salles ------------------------------- */

    /**
     * Sélectionne toutes les informations, concernant l'utilisateur, que l'on va afficher à l'écran.
     * $id est l'id de l'utilisateur en question
     */
    public function selectRoom($nom)
    {
        $query = "SELECT lieu.*, avg(note) FROM lieu
                    LEFT JOIN notelieu ON lieu.nom = notelieu.nom
                    WHERE lieu.nom = '$nom'
                    GROUP BY lieu.nom;";
        return $this->prepareExecute($query);
    }


    /* ------------------------------- Querry concernant les concerts ------------------------------- */

    /**
     * Sélectionne les informations liées aux concerts, à l'utilisateur qui l'a créé et aux nombre de participant de chaque concert.
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
    public function SelectOneConcertAndInfos($id)
    {
        $query = "SELECT Concert.*, Utilisateur.nom AS nomUser, prénom, COUNT(Utilisateur_Concert.idConcert) AS nbParticipants, capacité AS nbMaxParticipants, AVG(note) AS moyenneNotes
                    FROM Concert
                    INNER JOIN Utilisateur ON Concert.idCréateur = Utilisateur.id
                    INNER JOIN Lieu ON Concert.nomlieu = Lieu.nom
                    LEFT JOIN Utilisateur_Concert ON Concert.id = Utilisateur_Concert.idconcert
                    LEFT JOIN NoteConcert ON Concert.id = Noteconcert.idconcert
                    WHERE Concert.id = $id
                    GROUP BY Concert.id, Utilisateur.id, Lieu.nom;";

        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne tous les groupes qui font partie d'un concert en particulier
     */
    public function SelectArtistsOfOneConcert($idConcert)
    {
        $query = "SELECT id, numéropassage, nomscène FROM concert_artiste INNER JOIN artiste ON concert_artiste.idartiste  = artiste.id 
                    WHERE idconcert = $idConcert ORDER BY numéropassage;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne tous les gens inscrit à un concert en particulier
     */
    public function SelecAttendeeOfOneConcert($idConcert)
    {
        $query = "SELECT id, nom, prénom FROM utilisateur_concert INNER JOIN utilisateur ON utilisateur_concert.idutilisateur = utilisateur.id WHERE idconcert = $idConcert;";
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

    /**
     * Informe si l'utilisateur peut s'inscrire à un concert (Oui, s'il n'est pas déjà inscrit)
     */
    public function canUserSignUpForThisConcert($idUser, $idConcert)
    {
        $query = "SELECT * FROM utilisateur_concert WHERE idconcert = $idConcert AND idutilisateur = $idUser;";
        $result = $this->prepareExecute($query);
        if (count($result) == 0) {
            return true;
        }
        return false;
    }

    /**
     * Suppression d'un concert
     */
    public function deleteConcert($idConcert)
    {
        $query = "DELETE FROM concert WHERE id = $idConcert;";
        $this->prepareExecute($query);
    }

    /**
     * Désinscription d'un utilisateur
     */
    public function unsignUserFromConcert($idUser, $idConcert)
    {
        $query = "DELETE FROM utilisateur_concert WHERE idutilisateur = $idUser AND idconcert = $idConcert;";
        $this->prepareExecute($query);
    }

    /**
     * Transaction pour créer un concert
     */
    public function createConcert($concert, $artistes)
    {
        $query = "INSERT INTO concert (nom, début, durée, nomlieu, idcréateur) VALUES (?, ?, ?, ?, ?) RETURNING id;";
        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare($query);
            $statement->execute(array_values($concert));
            $idConcert = $statement->fetch();
            $idConcert = $idConcert[0];

            foreach ($artistes as $i => $idArtist) {
                $this->insert('concert_artiste', [
                    'idConcert' => $idConcert,
                    'idArtiste' => $idArtist,
                    'numéroPassage' => $i + 1
                ]);
            }

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollback();
            }
            $e->getMessage();
            return true;
        }
        return false;
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
                    LEFT JOIN style_artiste ON membre.idGroupe = style_artiste.idartiste
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

    /**
     * Sélectionne 5 artistes de même style que celui passé en paramètre.
     */
    public function getSuggestionsFromArtist($id)
    {
        $query = "SELECT *
                    FROM (SELECT DISTINCT Artiste.id,
                                          nomscène,
                                          STRING_AGG(nomstyle, ', ') AS styles,
                                          Groupe.id IS NOT NULL AS estGroupe
                          FROM Artiste
                                   LEFT JOIN Style_Artiste ON Artiste.id = Style_Artiste.idArtiste
                                   LEFT JOIN Groupe ON Artiste.id = Groupe.id
                          WHERE EXISTS(SELECT 1
                                       FROM Style_Artiste
                                       WHERE idArtiste != $id
                                         AND artiste.id = idArtiste)
                          GROUP BY Artiste.id, Groupe.id
                         ) t
                    ORDER BY RANDOM()
                    LIMIT 5;";
        return $this->prepareExecute($query);
    }

    /**
     * Transaction pour créer un artiste
     */
    public function createSoloArtiste($params1, $params2, $params3 = [], $params4 = [])
    {
        $query = "INSERT INTO artiste (nomscène) VALUES (?) RETURNING id;";
        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare($query);
            $statement->execute(array_values($params1));
            $id = $statement->fetchAll(PDO::FETCH_OBJ);
            $id = $id[0]->id;
            $data = [
                'id' => $id,
                'nom' => $params2['nom'],
                'prénom' => $params2['prénom']
            ];
            $this->insert('artistesolo', $data);
            if (count($params3) != 0) {
                $params3['idartistesolo'] = $id;
                $this->insert('membre', $params3);
            }
            if (count($params4) != 0) {
                $nb = count($params4);
                $query2 = "INSERT INTO style_artiste (idartiste, nomstyle) VALUES ($id, ?)";
                for ($i = 1; $i < $nb; $i++) {
                    $query2 = $query2 . ", ($id, ?)";
                }
                $statement = $this->pdo->prepare($query2);
                $statement->execute(array_values($params4));
            }

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollback();
            }
            return true;
        }
        return false;
    }


    /**
     * Transaction pour créer un groupe
     */
    public function createGroup($params1, $params2, $params3)
    {
        $query = "INSERT INTO artiste (nomscène) VALUES (?) RETURNING id;";
        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare($query);
            $statement->execute(array_values($params1));
            $id = $statement->fetchAll(PDO::FETCH_OBJ);
            $id = $id[0]->id;
            $data = [
                'id' => $id,
            ];
            $this->insert('groupe', $data);
            if (count($params2) != 0) {
                $query2 = "INSERT INTO membre (idartistesolo, idgroupe, datedébut) VALUES (?, $id, ?)";
                for ($i = 1; $i < count($params2) / 2; $i++) {
                    $query2 = $query2 . ", (?, $id, ?)";
                }
                $statement = $this->pdo->prepare($query2);
                $statement->execute(array_values($params2));
            }
            if (count($params3) != 0) {
                $nb = count($params3);
                $query3 = "INSERT INTO style_artiste (idartiste, nomstyle) VALUES ($id, ?)";
                for ($i = 1; $i < $nb; $i++) {
                    $query3 = $query3 . ", ($id, ?)";
                }
                $statement = $this->pdo->prepare($query3);
                $statement->execute(array_values($params3));
            }

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollback();
            }
            return true;
        }
        return false;
    }
}
