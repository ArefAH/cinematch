<?php
include 'connection.php';

$query = $connection->prepare('SELECT * FROM `movies-info`');//using temp database
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