<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "connection.php";

$username = $_POST["username"];
$password = $_POST["password"];

// Check if this is the first user being added
$check_user_count_query = $connection->prepare("SELECT COUNT(*) AS user_count FROM users");
$check_user_count_query->execute();
$result = $check_user_count_query->get_result();
$row = $result->fetch_assoc();

if ($row['user_count'] == 0) {
    // Assign user_type_id as 1 for the first user (aka admin)
    $user_type_id = 1;
} else {
    // Assign user_type_id as 2 for all other users (aka regular users)
    $user_type_id = 2;
}

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
