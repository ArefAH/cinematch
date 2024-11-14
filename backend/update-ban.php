<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];
    $isBanned = $_POST['isBanned'] == 'true' ? 1 : 0;

    $query = $connection->prepare("UPDATE users SET ban = ? WHERE id = ?");
    $query->bind_param("ii", $isBanned, $userId);

    if ($query->execute()) {
        echo json_encode([
            "status" => "Success",
            "message" => "Ban status updated successfully"
        ]);
    } else {
        echo json_encode([
            "status" => "Failed",
            "message" => "Failed to update ban status"
        ]);
    }
} else {
    echo json_encode([
        "status" => "Failed",
        "message" => "Invalid request method"
    ]);
}

?>
