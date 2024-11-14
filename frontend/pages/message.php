<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'cinematch';

$connection = new mysqli($host, $username, $password, $dbname);

if($connection -> connect_error){
    die('Connection Error');
}

$apiKey = "";
$apiUrl = "https://api.openai.com/v1/chat/completions"; 

$userId = $_POST['userId'];

$query = "
    SELECT m.title 
    FROM bookmarks b
    JOIN movies m ON b.movies_id = m.id
    WHERE b.users_id = ?
    ";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$bookmarkedMovies = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookmarkedMovies[] = $row['title'];
    }
}

$stmt->close();
$connection->close();

if (!empty($bookmarkedMovies)) {
    $bookmarksText = "Based on your bookmarks: " . implode(", ", $bookmarkedMovies) . ", please recommend only 3 movies:";
} else {
    $bookmarksText = "You haven't bookmarked any movies yet, but please recommend only 3 movies:";
}

$getMesg = $_POST['text'];
$data = array(
    "model" => "gpt-3.5-turbo", 
    "messages" => [
        ["role" => "system", "content" => "You are a helpful assistant."],
        ["role" => "user", "content" => $bookmarksText . " " . $getMesg] 
    ]
);

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
));

$response = curl_exec($ch);
curl_close($ch);

if ($response) {
    $responseData = json_decode($response, true);
    if (isset($responseData['choices'][0]['message']['content'])) {
        echo $responseData['choices'][0]['message']['content'];  
    } else {
        echo "Sorry, I couldn't understand that.";
    }
} else {
    echo "Sorry, I couldn't reach the API.";
}
?>
