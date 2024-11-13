<?php
include 'connection.php';

$user_id = $_POST['user_id'];
$movie_id = $_POST['movie_id'];

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