<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

session_start();

include "connection.php";

$username = $_POST["username"];
$password = $_POST["password"];

$query = $connection->prepare(
    "SELECT users.id, users.username, users.password, user_type_id
    FROM users 
    WHERE username = ?");
    
$query->bind_param("s", $username);
$query->execute();

$result = $query->get_result();

if($result->num_rows != 0){
    $user = $result->fetch_assoc();

    $check = password_verify($password, $user['password']);
    
    if ($check) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type_id'] = $user['user_type_id'];
        
        echo json_encode([
            "status" => "Login Successful",
            "userId" => $user['id'],
            "user" => $user['username'],
            "user_type_id" => $user['user_type_id']
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