<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT userid, userpassword, userrealname FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userid, $hashed_password, $userrealname);
        $stmt->fetch();

        // If you haven't hashed passwords yet, temporarily replace password_verify with ($password == $hashed_password)
        if (password_verify($password, $hashed_password)) {
            $_SESSION['userid'] = $userid;
            $_SESSION['userrealname'] = $userrealname;
            header("Location: dashboard.php"); // redirect after login
            exit;
        } else {
            echo "<script>alert('Invalid password'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('User not found'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
