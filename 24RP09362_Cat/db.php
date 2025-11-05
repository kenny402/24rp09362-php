<?php
$servername = "localhost";
$username = "root"; // default for XAMPP
$password = ""; // leave empty
$dbname = "library_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
