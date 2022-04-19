<?php

namespace DB;

use \PDO;

class DBPool {

    private static PDO $pdo;

    public static function getInstance(){
        if (!isset(self::$pdo)){
            try{
                self::$pdo = new PDO("mysql:dbname=the_qref", "root", "", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]);
            } catch (\PDOException $e){
                die();
            }
        }
        return self::$pdo;
    }

}