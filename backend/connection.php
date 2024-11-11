<?php

$host = "localhost";
$username = "root";
$pass = "";
$dbname = "cinamatch";

$connection = new mysqli($host, $username, $pass, $dbname);
if ($connection->connect_error) {
    die("Conection Error");
}