<?php

class QueryBuilder
{

    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Select * from table (sans condition)
    public function selectAll($table){
        $stat = $this->pdo->prepare("SELECT * FROM {$table}");

        $stat->execute();

        return $stat->fetchAll(PDO::FETCH_OBJ);
    }

    public function SelectWhereCondition($table, $col, $val){
        $statement = $this->pdo->prepare("SELECT * FROM {$table} WHERE {$col} = '{$val}'");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    // Insert des données dans la db
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