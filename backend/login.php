<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "connection.php";

$username = $_POST["username"];
$password = $_POST["password"];

$query = $connection->prepare(
    "SELECT users.id, users.username, users.password, user_type.user_type 
    FROM users 
    JOIN user_type ON users.user_type_id = user_type.id 
    WHERE username = ?");
    
$query->bind_param("s", $username);
$query->execute();

$result = $query->get_result();

if($result->num_rows != 0){
    $user = $result->fetch_assoc();

    $check = password_verify($password, $user['password']);
    
    if ($check) {
        echo json_encode([
            "status" => "Login Successful",
            "user" => $user['username']
        ]);
    }else {
        // Invalid password case
        echo json_encode([
            "status" => "Failed",
            "message" => "Invalid password"
        ]);
    }
}else {
    // No user found case
    echo json_encode([
        "status" => "Failed",
        "message" => "User not found"
    ]);
}