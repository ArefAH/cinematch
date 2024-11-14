<?php
include 'connection.php';

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$user_id = $data['userId'];
$query = $connection->prepare('
    SELECT m.* 
    FROM bookmarks b
    INNER JOIN movies m ON b.movies_id = m.id
    WHERE b.users_id = ?
');

$query->bind_param('i', $user_id);
$query->execute();

$result = $query->get_result();
if ($result->num_rows > 0) {
    $array = [];
    while ($row = $result->fetch_assoc()) {
        $array[] = $row;
    }
    echo json_encode($array);
} else {
    echo json_encode([
        "message" => "No Movies"
    ]);
}
?>
