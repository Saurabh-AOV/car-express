<?php
$host = "localhost";
$dbname = "car-express";
$username = "root"; // Change this according to your DB setup
$password = "";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
