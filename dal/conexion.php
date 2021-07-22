<?php

define('DB_NAME', 'bd');

function getConnection() {
    // $conn = null;
    // $server = '209.217.245.186';
    // $db = 'delnorte_opccenter';
    // $user = 'delnorte_opfabio';
    // $pwd = 'f+159753';

    $conn = null;
    $server = 'localhost';
    $db = 'bdopticenter1';
    $user = 'root';
    $pwd = '12345678';
    
    try {
        $conn = new PDO('mysql:host=' . $server . ';dbname=' . $db, $user, $pwd, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET SESSION SQL_BIG_SELECTS=1',
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET SESSION sql_mode = REPLACE(@@sql_mode,"ONLY_FULL_GROUP_BY","")',
        ));
    } catch (PDOException $e) {
        exit;
    }
    
    return $conn;
}

?>