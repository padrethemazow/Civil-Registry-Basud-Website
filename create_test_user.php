<?php
include 'db_connect.php';
$username = 'admin';
$password = password_hash('12345', PASSWORD_DEFAULT);
$realname = 'Administrator';
$conn->query("INSERT INTO login (username, userpassword, userrealname) VALUES ('$username', '$password', '$realname')");
echo "Test user created!";
?>
