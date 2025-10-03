<?php
// Connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "budaya_betawi";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>