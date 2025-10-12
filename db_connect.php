<?php
$host = "localhost";      // usually 'localhost'
$user = "root";           // your MySQL username
$pass = "";               // your MySQL password
$dbname = "mbdis_users";  // your database name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
