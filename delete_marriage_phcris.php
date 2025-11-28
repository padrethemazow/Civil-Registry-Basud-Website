<?php
$servername = "sql105.infinityfree.com";
$username   = "if0_40542314";
$password   = "Sx5Sw60QmFT";
$dbname = "if0_40542314_mbdis_phcris";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed.");

if (!isset($_GET['id'])) die("No ID.");
$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM phmarriage WHERE ID=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: quick-search-marriage.php?deleted=1");
} else {
    echo "Error deleting.";
}
?>
