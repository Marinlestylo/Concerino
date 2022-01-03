<?php

class Connection
{
    // Fonction static utilisée dans bootstrap afin de se co à la DB
    public static function make($config){
        try{
            return new PDO(
                $config['connection'].';dbname='.$config['name'], $config['username'], $config['password'], $config['options']
            );
        } catch (PDOException $e){
            die($e->getMessage());
        }
    }
}