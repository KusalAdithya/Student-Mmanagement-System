<?php

class Database{

    public static $conection;

    public static function setUpConnection(){
        if (!isset(Database::$conection)) {
            Database::$conection = new mysqli("localhost", "**********", "**********", "**********", "3306");
        }
    }
    
    public static function iud($q){
        Database::setUpConnection();
        Database::$conection->query($q);
    }

    public static function search($q){
        Database::setUpConnection();
        $resultset = Database::$conection->query($q);
        return $resultset;
    }
}

?>