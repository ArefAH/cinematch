<?php
include 'connection.php';

$genre = $_POST['genre'];

$query = $connection->prepare('SELECT * FROM `movies-info` WHERE `genre` = ? LIMIT 4');//using temp database
$query->bind_param('s', $genre);
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