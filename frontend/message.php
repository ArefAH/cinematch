<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'cinematch';

$connection = new mysqli($host, $username, $password, $dbname);

if($connection -> connect_error){
    die('Connection Error');
}

$apiKey = "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";
$apiUrl = "https://api.openai.com/v1/chat/completions"; 

// $userId = $_POST['user_id'];

// $query = $conn->prepare("SELECT motitle FROM bookmarks WHERE user_id = ?");
// $query->bind_param('i', $userId);
// $query->execute();
// $result = $query->get_result();

// $bookmarkedMovies = [];
// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $bookmarkedMovies[] = $row['movie_title'];
//     }
// }

// $query->close();
// $conn->close();

// if (!empty($bookmarkedMovies)) {
//     $bookmarksText = "Based on your bookmarks: " . implode(", ", $bookmarkedMovies) . ", I recommend the following movies:";
// } else {
//     $bookmarksText = "You haven't bookmarked any movies yet, but here are some recommendations:";
// }

$getMesg = $_POST['text'];
$data = array(
    "model" => "gpt-3.5-turbo", 
    "messages" => [
        ["role" => "system", "content" => "You are a helpful assistant."],
        ["role" => "user", "content" => 'Hello'] 
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
