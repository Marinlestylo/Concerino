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
        $placeholder = '?';
        $nb = count($params);
        for($i = 1; $i < $nb; $i++){
            $placeholder = $placeholder . ", ?";
        }
        
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($params)),
            $placeholder
        );

        try{
            $statement = $this->pdo->prepare($sql);

            $statement->execute(array_values($params));
        }catch (Exception $e){
            die($e->getMessage());
        }
    }
}