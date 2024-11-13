<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'cinematch';

$connection = new mysqli($host, $username, $password, $dbname);

if($connection -> connect_error){
    die('Connection Error');
}
?>