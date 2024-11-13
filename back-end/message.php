<?php
$conn = mysqli_connect("localhost", "root", "", "q");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$getMesg = $_POST['text'];
$query = "SELECT replies FROM qq WHERE queries LIKE CONCAT('%', ?, '%')";
$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "s", $getMesg);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $fetch_data = mysqli_fetch_assoc($result);
    echo $fetch_data['replies'];
} else {
    $apiKey = "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";
    $apiUrl = "https://api.openai.com/v1/chat/completions"; 

    $data = array(
        "model" => "gpt-3.5-turbo", 
        "messages" => [
            ["role" => "system", "content" => "You are a helpful assistant."],
            ["role" => "user", "content" => $getMesg] 
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
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
