<?php
$servername = "localhost";
$username = "root";        // your MySQL username
$password = "";            // your MySQL password (fill if you have one)
$database = "library_db";  // database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
