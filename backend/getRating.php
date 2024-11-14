<?php
include 'connection.php';

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$movie_id = $data['movieId'];

$query = $connection->prepare('SELECT rating FROM ratings WHERE movies_id = ?');
$query->bind_param('i', $movie_id);
$query->execute();
$result = $query->get_result();

if($result->num_rows != 0) {
    $sum = 0;
    while($row = $result->fetch_assoc()) {
        $sum += $row['rating'];
    }

    echo json_encode([
        "totalRating" => $sum
    ]);
} else {
    echo json_encode([
        "message" => "No Ratings",
    ]);
}
?>