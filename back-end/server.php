<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'moviedb';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/movies') {
    $query = "SELECT id, imageSrc FROM movies";  

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $movies = [];
        while($row = $result->fetch_assoc()) {
            $movies[] = $row;
        }
        echo json_encode($movies);  
    } else {
        echo json_encode(['message' => 'No movies found']);
    }
} else {
    echo json_encode(['message' => 'Invalid request']);
}

$conn->close();
?>
