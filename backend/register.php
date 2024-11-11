<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "connection.php";

$username = $_POST["username"];
$password = $_POST["password"];

$hashed = password_hash($password, PASSWORD_DEFAULT);

$query = $connection->prepare("INSERT INTO users (username, password, user_type_id) VALUES (?, ?, ?)");

$query->bind_param("ssi", $username, $hashed, $user_type_id);

$query->execute();

$result = $query->affected_rows;

if ($result != 0){
    echo json_encode([
        "status" => "Successful",
        "message" => "$result user(s) created"
    ]);
} else {
    echo json_encode([
        "status" => "Failed",
        "message" => "Couldn't create records"
    ]);
}
