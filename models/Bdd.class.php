<?php

abstract class Bdd{
    private static $pdo;

    private static function setBdd(){  
        self::$pdo = new PDO("mysql:host=localhost;dbname=sp_eco;charset=utf8", "root", "root");
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, pdo::ERRMODE_WARNING);
    }

    protected function getBdd(){
        if(self::$pdo === null){
            self::setBdd();
        }
        return self::$pdo;
    }
}
