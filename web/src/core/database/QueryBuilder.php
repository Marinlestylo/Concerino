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
     * Select les infos de la table concert ainsi que des infos sur le créateur du concert (sans condition)
     */
    public function selectConcertsAndUser()
    {
        $statement = $this->pdo->prepare("SELECT concert.id, concert.nom, concert.début, concert.durée, concert.nomlieu, concert.idcréateur, utilisateur.nom AS \"nomUser\", utilisateur.prénom FROM concert INNER JOIN utilisateur ON concert.idcréateur = utilisateur.id;");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Select les infos de la table concert ainsi que des infos sur le créateur du concert
     * avec une condition where afin de n'en retourner que le concert qui nous intéresse.
     */
    public function selectOneConcertAndUser($id)
    {
        $statement = $this->pdo->prepare("SELECT concert.id, concert.nom, concert.début, concert.durée, concert.nomlieu, concert.idcréateur, utilisateur.nom AS \"nomUser\", utilisateur.prénom FROM concert INNER JOIN utilisateur ON concert.idcréateur = utilisateur.id WHERE concert.id = {$id};");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Prend tous les noms de lieux (utile pour la création de concert)
     */
    public function selectNomFromLieu(){
        $statement = $this->pdo->prepare("SELECT nom FROM lieu;");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}
