<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "q");

if (!$conn) {
    // Return an error if connection fails
    die("Connection failed: " . mysqli_connect_error());
}

// Get user message through AJAX
$getMesg = $_POST['text'];

// Use prepared statements to prevent SQL injection
$query = "SELECT replies FROM qq WHERE queries LIKE CONCAT('%', ?, '%')";
$stmt = mysqli_prepare($conn, $query);

// Bind the parameter to the prepared statement
mysqli_stmt_bind_param($stmt, "s", $getMesg);

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Check if there are any matching results
if (mysqli_num_rows($result) > 0) {
    // Fetch the reply from the database
    $fetch_data = mysqli_fetch_assoc($result);
    // Send the reply to the frontend
    echo $fetch_data['replies'];
} else {
    // If no match is found in the database, call the external API
    $apiKey = "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";
    $apiUrl = "https://api.openai.com/v1/chat/completions"; // OpenAI's endpoint for chat completions

    // Prepare the data for the API request
    $data = array(
        "model" => "gpt-3.5-turbo", // Make sure to use the appropriate model
        "messages" => [
            ["role" => "system", "content" => "You are a helpful assistant."],
            ["role" => "user", "content" => $getMesg]  // Sending user input to the model
        ]
    );

    // cURL Setup
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Convert the data to JSON
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ));

    // Execute the cURL request and capture the response
    $response = curl_exec($ch);
    curl_close($ch);

    // Check if the response is valid
    if ($response) {
        // Decode the response (assuming it's JSON)
        $responseData = json_decode($response, true);
        
        // Check if the response contains the 'choices' field
        if (isset($responseData['choices'][0]['message']['content'])) {
            echo $responseData['choices'][0]['message']['content'];  // Send the bot's reply to the frontend
        } else {
            echo "Sorry, I couldn't understand that.";
        }
    } else {
        echo "Sorry, I couldn't reach the API.";
    }
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
