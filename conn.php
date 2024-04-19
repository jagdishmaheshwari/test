<?php   // Your database connection code goes here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kachchhkala";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
date_default_timezone_set('Asia/Kolkata');

?>