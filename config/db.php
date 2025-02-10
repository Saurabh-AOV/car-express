<?php
// Database credentials
$servername = "localhost"; // Change if your database is on a different host
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "car-express"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}