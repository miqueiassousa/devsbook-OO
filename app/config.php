<?php
session_start();
$base = 'http://localhost/';

$db_name = 'devsbook';
$db_host = 'mysql';
$db_user = 'root';
$db_pass = 'root';

$maxWidth = 800;
$maxHeight = 800;

$pdo = new PDO("mysql:dbname=".$db_name.";host=".$db_host, $db_user, $db_pass);