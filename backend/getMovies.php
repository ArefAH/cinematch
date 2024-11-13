<?php
include 'connection.php';

$movie_id = $_POST['movie_id'];

$query = $connection->prepare('SELECT * FROM `movies` WHERE id = ?');
$query->bind_param('i', $movie_id);
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
        "message" => "No Movies",
    ]);
}

?>