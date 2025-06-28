<?php
$servername = "localhost";
$username = "root";  // Use root instead of hoteluser
$password = "";  // root's password (if same as before)
$dbname = "hotel_db";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>