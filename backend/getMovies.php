<?php
include 'connection.php';
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$id = $data['movieId'];

$query = $connection->prepare('SELECT * FROM `movies` WHERE id = ?');
$query->bind_param('i', $id);
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