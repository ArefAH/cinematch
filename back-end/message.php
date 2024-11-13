<?php
$conn = mysqli_connect("localhost", "root", "", "q");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
