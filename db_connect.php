<?php
$servername = "localhost";
$username = "root";  // MySQL username
$password = "";      // MySQL password (default XAMPP is empty)
$dbname = "todo"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8");
?>
