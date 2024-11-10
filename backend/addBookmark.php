<?php
session_start();
include 'connection.php';

$user_id = $_SESSION['user_id'];
$movie_id = $_GET['movie_id'];

$query = $connection->prepare('INSERT INTO `bookmarks` (`users_id`, `movies_id`) VALUES (?, ?)');
$query->bind_param('ii', $user_id, $movie_id);
$query->execute();
$result = $query->affected_rows;

if($result != 0){
    echo json_encode([
        "status" => "Successful",
        "message" => "$result bookmark added",
    ]);
} else{
    echo json_encode([
        "status" => "Failed",
        "message" => "Could not add bookmark",
    ]);
}


?>