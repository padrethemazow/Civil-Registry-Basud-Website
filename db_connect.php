<?php
$host = "sql105.infinityfree.com";      // usually 'localhost'
$user = "if0_40542314";           // your MySQL username
$pass = "Sx5Sw60QmFT";               // your MySQL password
$dbname = "if0_40542314_mbdis_users";  // your database name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
