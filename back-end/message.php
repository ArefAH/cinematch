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

