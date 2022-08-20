<?php

include_once 'abastractValidation.php';

$host = 'localhost';
$user = 'root';
$pass = 'root123456';
$db = 'stock_system2';

$mysqli = new mysqli($host, $user, $pass, $db);
if($mysqli->connect_errno) {
    die("ERRO $mysqli->connect_errno, $mysqli->connect_error");
}

return array('host' => $host, 'user' =>$user, 'pass' => $pass, 'db' => $db);