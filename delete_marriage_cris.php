<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mbdis_cris";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed.");

if (!isset($_GET['id'])) die("No record ID.");

$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM marriage WHERE ID=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: quick-search-marriage.php?deleted=1");
} else {
    echo "Error deleting record.";
}
?>
