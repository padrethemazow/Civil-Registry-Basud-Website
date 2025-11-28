<?php
$servername = "sql105.infinityfree.com";
$username   = "if0_40542314";
$password   = "Sx5Sw60QmFT";
$dbname = "if0_40542314_mbdis_cris";

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

header("Location: quick-search-death.php?deleted=1");
exit;
?>
