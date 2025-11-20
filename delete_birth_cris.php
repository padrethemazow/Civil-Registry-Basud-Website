<?php
// --- Database Connection ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mbdis_cris";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID exists
if (!isset($_GET['id'])) {
    die("No ID provided.");
}

$id = intval($_GET['id']);

// Fetch record for confirmation
$sql = "SELECT * FROM birth WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$record = $stmt->get_result()->fetch_assoc();

if (!$record) {
    die("Record not found.");
}

// If user confirms deletion
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $del = $conn->prepare("DELETE FROM birth WHERE ID = ?");
    $del->bind_param("i", $id);

    if ($del->execute()) {
        header("Location: quick-search-birth.php?deleted=1");
        exit;
    } else {
        echo "Error deleting record.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete CRIS Birth Record</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        .box { background: white; padding: 25px; width: 450px; margin: auto; border-radius: 10px; }
        button { padding: 10px 18px; margin: 5px; border: none; border-radius: 6px; cursor: pointer; }
        .yes { background: #dc2626; color: white; }
        .no { background: #6b7280; color: white; text-decoration: none; }
    </style>
</head>
<body>

<div class="box">
    <h2>Confirm Delete</h2>

    <p>Are you sure you want to delete this record?</p>

    <b>Child Name:</b> <?php echo $record['ChildName']; ?><br>
    <b>Date of Birth:</b> <?php echo $record['DateOfBirth']; ?><br>
    <b>Place of Birth:</b> <?php echo $record['PlaceOfBirth']; ?><br><br>

    <form method="POST">
        <button class="yes" type="submit">YES, DELETE</button>
        <a class="no" href="quick-search-birth.php">Cancel</a>
    </form>
</div>

</body>
</html>
