<?php
// --- Database Connection ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mbdis_phcris";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Validate ID ---
if (!isset($_GET['id'])) {
    die("No ID provided.");
}

$id = intval($_GET['id']);

// --- Fetch record for confirmation ---
$sql = "SELECT CFirstName, CLastName, CBirthDate FROM phbirth WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$record = $stmt->get_result()->fetch_assoc();

if (!$record) {
    die("Record not found.");
}

// --- DELETE when confirmed ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $delete = "DELETE FROM phbirth WHERE ID = ?";
    $stmt = $conn->prepare($delete);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: quick-search-birth.php?phcris_deleted=1");
        exit;
    } else {
        echo "Error deleting record.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete PHCRIS Birth Record</title>
    <style>
        body { font-family: Arial; background: #f8e2e2; padding: 20px; }
        .container { background: white; padding: 20px; width: 500px; margin: auto; border-radius: 10px; }
        .danger { color: #b91c1c; font-weight: bold; }
        button { padding: 10px 18px; background: #dc2626; color: white; border-radius: 6px; border: none; cursor: pointer; }
        a { text-decoration: none; color: #333; }
    </style>
</head>
<body>

<div class="container">
    <h2>Delete Birth Record (PHCRIS)</h2>

    <p class="danger">Are you sure you want to permanently delete this record?</p>

    <p><strong>Name:</strong> <?php echo $record['CFirstName'] . " " . $record['CLastName']; ?></p>
    <p><strong>Date of Birth:</strong> <?php echo $record['CBirthDate']; ?></p>

    <form method="POST">
        <button type="submit">Yes, Delete Record</button>
    </form>

    <br>
    <a href="quick-search-birth.php">← Cancel and Go Back</a>

</div>

</body>
</html>
