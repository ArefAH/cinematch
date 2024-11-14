<?php
include 'connection.php';
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$user_id = $data['userId'];
$movie_id = $data['movieId'];

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