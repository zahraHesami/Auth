<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "php_api";

try {
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" , PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password ,$options);
}

catch (PDOException $e) {
    echo 'ERRor : '.$e->getMessage();
    return false;
}