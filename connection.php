<?php

class DataBaseConnection {

    const HOST = "localhost";
    const USER = "pousk";
    const PWD = "Aikawa429010";
    const DBNAME = "fashion24";

    public static function createConnect() {
        $dbh = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::DBNAME, self::USER, self::PWD);
        $dbh->exec("SET names utf8");
        $dbh->exec("SET character_set_results=utf8");
        $dbh->exec("SET character_set_client='utf8'");
        $dbh->exec("SET character_set_connection='utf8'");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    }

}

?>