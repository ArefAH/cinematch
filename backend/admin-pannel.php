<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

session_start();

include "connection.php";

$query = $connection->prepare(
    "SELECT users.id, users.username, users.user_type_id, users.ban, user_type.user_type AS user_type
    FROM users
    JOIN user_type ON users.user_type_id = user_type.id"
);

$query->execute();

$result = $query->get_result();

$users = [];

if($result->num_rows != 0){
    while ($user = $result->fetch_assoc()) {
        $users[] = [
            "userId" => $user['id'],
            "username" => $user['username'],
            "user_type_id" => $user['user_type_id'],
            "user_type" => $user['user_type'],
            "ban" => $user['ban']
        ];
    }    

    echo json_encode([
        "status" => "Success",
        "users" => $users
    ]);    
}else {
    // No users found case
    echo json_encode([
        "status" => "Failed",
        "message" => "No users found"
    ]);
}