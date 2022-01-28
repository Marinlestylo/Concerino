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
        $query = "SELECT AVG(note) AS moyenne FROM $tableName WHERE $colName = $val;";
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
            'INSERT INTO %s (%s) VALUES (%s)',
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
        $query = "SELECT id, login, nom, prénom, estModérateur 
                    FROM Utilisateur 
                    WHERE id = $id;";
        return $this->prepareExecute($query);
    }

    public function selectEveryConcertUserWentTo($idUser)
    {
        $query = "SELECT id, nom, début, durée, nomLieu 
                    FROM Utilisateur_Concert 
                    INNER JOIN Concert ON Utilisateur_Concert.idConcert = Concert.id 
                    WHERE idUtilisateur = $idUser;";
        return $this->prepareExecute($query);
    }

    public function showVotes($idUser)
    {
        $queryNoteArtist = "SELECT idArtiste, note, nomScène 
                                FROM NoteArtiste 
                                INNER JOIN Artiste ON NoteArtiste.idArtiste = Artiste.id 
                                WHERE idUtilisateur = $idUser;";
        $queryNoteConcert = "SELECT idConcert, note, nom 
                                FROM NoteConcert 
                                INNER JOIN Concert ON NoteConcert.idConcert = Concert.id
                                WHERE idUtilisateur = $idUser;";
        $queryNoteLieu = "SELECT nom, note 
                            FROM NoteLieu 
                            WHERE idUtilisateur = $idUser;";
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
        $query = "UPDATE Utilisateur 
                    SET estModérateur = TRUE
                    WHERE id = $id;";
        return $this->prepareExecute($query);
    }

    /* ------------------------------- Querry concernant les salles ------------------------------- */

    /**
     * Sélectionne toutes les informations, concernant l'utilisateur, que l'on va afficher à l'écran.
     * $id est l'id de l'utilisateur en question
     */
    public function selectRoom($nom)
    {
        $query = "SELECT Lieu.*, AVG(note) 
                    FROM Lieu
                    LEFT JOIN NoteLieu ON Lieu.nom = NoteLieu.nom
                    WHERE Lieu.nom = '$nom'
                    GROUP BY Lieu.nom;";
        return $this->prepareExecute($query);
    }


    /* ------------------------------- Querry concernant les concerts ------------------------------- */

    /**
     * Sélectionne les informations liées aux concerts, à l'utilisateur qui l'a créé et aux nombre de participant de chaque concert.
     */
    public function selectConcertsAndUser()
    {
        $query = "SELECT Concert.id,
                        Concert.nom, 
                        Concert.début, 
                        Concert.durée, 
                        Concert.nomLieu, 
                        Concert.idCréateur, 
                        Utilisateur.nom AS \"nomUser\", 
                        Utilisateur.prénom, 
                        COUNT(Utilisateur_Concert.idUtilisateur) AS nbParticipant, 
                        Lieu.capacité AS nbMaxParticipant
        FROM Concert 
        INNER JOIN Utilisateur ON Concert.idCréateur = Utilisateur.id
        INNER JOIN Lieu ON Concert.nomLieu = Lieu.nom 
        LEFT JOIN Utilisateur_Concert ON Concert.id = Utilisateur_Concert.idConcert
        GROUP BY Concert.id, Utilisateur.nom, Utilisateur.prénom, Lieu.capacité
        ORDER BY début;";

        return $this->prepareExecute($query);
    }

    /**
     * Select les infos de la table concert ainsi que des infos sur le créateur du concert
     * avec une condition where afin de n'en retourner que le concert qui nous intéresse.
     */
    public function SelectOneConcertAndInfos($id)
    {
        $query = "SELECT Concert.*, 
                        Utilisateur.nom AS nomUser, 
                        prénom, 
                        COUNT(Utilisateur_Concert.idConcert) AS nbParticipants, 
                        capacité AS nbMaxParticipants, 
                        AVG(note) AS moyenneNotes
                    FROM Concert
                    INNER JOIN Utilisateur ON Concert.idCréateur = Utilisateur.id
                    INNER JOIN Lieu ON Concert.nomLieu = Lieu.nom
                    LEFT JOIN Utilisateur_Concert ON Concert.id = Utilisateur_Concert.idConcert
                    LEFT JOIN NoteConcert ON Concert.id = NoteConcert.idConcert
                    WHERE Concert.id = $id
                    GROUP BY Concert.id, Utilisateur.id, Lieu.nom;";

        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne tous les groupes qui font partie d'un concert en particulier
     */
    public function SelectArtistsOfOneConcert($idConcert)
    {
        $query = "SELECT id, numéroPassage, nomScène 
                    FROM Concert_Artiste 
                    INNER JOIN Artiste ON Concert_Artiste.idArtiste  = Artiste.id 
                    WHERE idConcert = $idConcert 
                    ORDER BY numéroPassage;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne tous les gens inscrit à un concert en particulier
     */
    public function SelecAttendeeOfOneConcert($idConcert)
    {
        $query = "SELECT id, nom, prénom 
                    FROM Utilisateur_Concert 
                    INNER JOIN Utilisateur ON Utilisateur_Concert.idUtilisateur = Utilisateur.id 
                    WHERE idConcert = $idConcert;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne tous les concerts qui sont prévu dans le futur
     */
    public function getFiveNextConcerts()
    {
        $query = "SELECT Concert.id,
                        Concert.nom,
                        Concert.début,
                        Concert.durée,
                        Concert.nomLieu,
                        Concert.idCréateur,
                        Utilisateur.nom AS \"nomUser\",
                        Utilisateur.prénom 
                    FROM Concert 
                    INNER JOIN Utilisateur ON Concert.idCréateur = Utilisateur.id 
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
        $query = "SELECT * 
                    FROM Utilisateur_Concert 
                    WHERE idConcert = $idConcert 
                        AND idUtilisateur = $idUser;";
        $result = $this->prepareExecute($query);
        return count($result) == 0;
    }

    /**
     * Suppression d'un concert
     */
    public function deleteConcert($idConcert)
    {
        $query = "DELETE FROM Concert WHERE id = $idConcert;";
        $this->prepareExecute($query);
    }

    /**
     * Désinscription d'un utilisateur
     */
    public function unsignUserFromConcert($idUser, $idConcert)
    {
        $query = "DELETE FROM Utilisateur_Concert WHERE idUtilisateur = $idUser AND idConcert = $idConcert;";
        $this->prepareExecute($query);
    }

    /**
     * Transaction pour créer un concert
     */
    public function createConcert($concert, $artistes)
    {
        $query = "INSERT INTO concert (nom, début, durée, nomLieu, idCréateur) VALUES (?, ?, ?, ?, ?) RETURNING id;";
        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare($query);
            $statement->execute(array_values($concert));
            $idConcert = $statement->fetch();
            $idConcert = $idConcert[0];

            foreach ($artistes as $i => $idArtist) {
                $this->insert('Concert_Artiste', [
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
        $query = "SELECT nom FROM Lieu;";
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
        $query = "SELECT ArtisteSolo.id, ArtisteSolo.nom, ArtisteSolo.prénom, Artiste.nomScène 
                    FROM ArtisteSolo 
                        INNER JOIN Artiste ON ArtisteSolo.id = Artiste.id;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne tous les artistes solo
     */
    public function getAllGroups()
    {
        $query = "SELECT Groupe.id, Artiste.nomScène 
                    FROM Groupe 
                        INNER JOIN Artiste ON Groupe.id = Artiste.id;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne tous les groupes dont l'artiste solo à fait partie
     */
    public function getAllGroupsWhereIdSoloArtist($id)
    {

        $query = "SELECT Artiste.nomScène, 
                        Artiste.id, 
                        STRING_AGG(Style_Artiste.nomStyle::text, ', ') AS styles,
                        Membre.dateDébut,
                        Membre.dateFin 
                    FROM Membre 
                    INNER JOIN Artiste ON Membre.idGroupe = Artiste.id 
                    LEFT JOIN Style_Artiste ON Membre.idGroupe = Style_Artiste.idArtiste
                    WHERE Membre.idArtisteSolo = $id
                    GROUP BY Artiste.nomScène, Artiste.id, Membre.dateDébut, Membre.dateFin 
                    ORDER BY Membre.dateDébut DESC;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne toutes les infos liée à un artiste
     */
    public function getInfoArtistSolo($id)
    {
        $query = "SELECT Artiste.nomScène as nomScène,
                        nom,
                        prénom,
                        STRING_AGG(nomStyle::TEXT, ', ') AS styles, 
                        ArtisteGroupe.nomScène AS nomGroupe, 
                        ArtisteGroupe.id
                    FROM Artiste
                    INNER JOIN ArtisteSolo ON artiste.id = artistesolo.id
                    LEFT JOIN Style_Artiste ON artiste.id = Style_Artiste.idArtiste
                    LEFT JOIN Membre ON ArtisteSolo.id = Membre.idArtisteSolo 
                                            AND (Membre.dateFin IS NULL OR Membre.dateFin > CURRENT_DATE)
                    LEFT JOIN Artiste ArtisteGroupe ON ArtisteGroupe.id = Membre.idGroupe
                    WHERE Artiste.id = $id
                    GROUP BY Artiste.id, ArtisteSolo.id, ArtisteGroupe.id;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne tous les artistes ayant fait partie d'un groupe en particulier
     */
    public function getAllMembersOfOneGroup($id)
    {
        $query = "SELECT Membre.idArtisteSolo, Artiste.nomScène, Membre.dateDébut, Membre.dateFin
                    FROM Membre 
                    INNER JOIN Artiste ON Membre.idArtisteSolo = Artiste.id 
                    WHERE Membre.idGroupe = $id;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne tous les styles de musique qu'un groupe représente
     */
    public function getAllStylesForGroup($id)
    {
        $query = "SELECT Artiste.nomScène, STRING_AGG(Style_Artiste.nomStyle::TEXT, ', ') as styles
                    FROM Groupe
                    INNER JOIN Artiste ON groupe.id = Artiste.id
                    LEFT JOIN Style_Artiste ON Groupe.id = Style_Artiste.idArtiste
                    WHERE Groupe.id = $id
                    GROUP BY Groupe.id, Artiste.nomScène;";
        return $this->prepareExecute($query);
    }

    /**
     * Sélectionne 5 artistes de même style que celui passé en paramètre.
     */
    public function getSuggestionsFromArtist($id)
    {
        $query = "SELECT *
                    FROM (SELECT DISTINCT Artiste.id,
                                          nomScène,
                                          STRING_AGG(nomStyle, ', ') AS styles,
                                          Groupe.id IS NOT NULL AS estGroupe
                          FROM Artiste
                                   LEFT JOIN Style_Artiste ON Artiste.id = Style_Artiste.idArtiste
                                   LEFT JOIN Groupe ON Artiste.id = Groupe.id
                          WHERE EXISTS(SELECT 1
                                       FROM Style_Artiste
                                       WHERE idArtiste != $id
                                         AND Artiste.id = idArtiste)
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
        $query = "INSERT INTO Artiste (nomScène) VALUES (?) RETURNING id;";
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
            $this->insert('ArtisteSolo', $data);
            if (count($params3) != 0) {
                $params3['idartistesolo'] = $id;
                $this->insert('Membre', $params3);
            }
            if (count($params4) != 0) {
                $nb = count($params4);
                $query2 = "INSERT INTO Style_Artiste (idArtiste, nomStyle) VALUES ($id, ?)";
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
        $query = "INSERT INTO Artiste (nomScène) VALUES (?) RETURNING id;";
        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare($query);
            $statement->execute(array_values($params1));
            $id = $statement->fetchAll(PDO::FETCH_OBJ);
            $id = $id[0]->id;
            $data = [
                'id' => $id,
            ];
            $this->insert('Groupe', $data);
            if (count($params2) != 0) {
                $query2 = "INSERT INTO Membre (idArtisteSolo, idGroupe, dateDébut) VALUES (?, $id, ?)";
                for ($i = 1; $i < count($params2) / 2; $i++) {
                    $query2 = $query2 . ", (?, $id, ?)";
                }
                $statement = $this->pdo->prepare($query2);
                $statement->execute(array_values($params2));
            }
            if (count($params3) != 0) {
                $nb = count($params3);
                $query3 = "INSERT INTO Style_Artiste (idArtiste, nomStyle) VALUES ($id, ?)";
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
