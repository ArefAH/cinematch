<?php
include 'connection.php';

$user_id = $_POST['user_id'];
$movie_id = $_POST['movie_id'];
$rating = $_POST['rating'];

$query = $connection->prepare('INSERT INTO `ratings` (`users_id`, `movies_id`, `rating`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `rating` = VALUES(`rating`)');
$query->bind_param('iii', $user_id, $movie_id, $rating);
$query->execute();
$result = $query->affected_rows;

if($result != 0){
    echo json_encode([
        "status" => "Successful",
        "message" => "$result rating added",
    ]);
} else{
    echo json_encode([
        "status" => "Failed",
        "message" => "Could not add rating",
    ]);
}


?>