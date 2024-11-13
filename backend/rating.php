<?php
include 'connection.php';
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$user_id = $data['userId'];
$movie_id = $data['movieId'];
$rating = $data['rating'];

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