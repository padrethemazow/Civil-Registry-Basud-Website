<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mbdis_phcris";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    die("No record ID provided.");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM death WHERE ID=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: quick-search-death.php?ph_deleted=1");
exit;
?>
