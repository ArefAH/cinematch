<?php
include 'connection.php';

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$user_id = $data['movieId'];
$movie_id = $data['movieId'];

$query = $connection->prepare('SELECT rating FROM ratings WHERE user_id = ? AND movie_id = ?');
$query->bind_param('ii', $user_id, $movie_id);
$query->execute();
$result = $query->get_result();
if($result -> num_rows != 0 ){
    $array = [];
    while($row = $result -> fetch_assoc()){
        $array[] = $row;
    }

    echo json_encode($array);
}
else{
    echo json_encode([
        "message" => "No Ratings",
    ]);
}

?>