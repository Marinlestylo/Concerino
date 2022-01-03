<?php

class QueryBuilder
{

    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function selectAll($table){
        $stat = $this->pdo->prepare("Select * from {$table}");

        $stat->execute();

        return $stat->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert($table, $params){
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($params)),
            ':' .implode(', :', array_keys($params))
        );

        try{
            $statement = $this->pdo->prepare($sql);

            $statement->execute($params);
        }catch (Exception $e){
            die('oupsy');
        }
    }
}