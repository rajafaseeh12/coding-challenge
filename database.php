<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbName = 'booking_system';


$conn = new mysqli($host, $username, $password, $dbName);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// echo "Connected to the database.";

?>