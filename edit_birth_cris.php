<?php
session_start();

if (!isset($_SESSION['userrealname'])) {
    header("Location: index.html");
    exit;
}
// --- Database Connection ---
$servername = "sql105.infinityfree.com";
$username   = "if0_40542314";
$password   = "Sx5Sw60QmFT";
$dbname = "if0_40542314_mbdis_cris";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Validate ID ---
if (!isset($_GET['id'])) {
    die("No ID provided.");
}

$id = intval($_GET['id']);

// --- Fetch current record ---
$sql = "SELECT * FROM birth WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$record = $stmt->get_result()->fetch_assoc();

if (!$record) {
    die("Record not found.");
}

// --- Update when form is submitted ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fields = [
        "CT","PLACE","FOL","PAGE","FIRST","MI","LAST","MFIRST","MMI","MLAST",
        "FFIRST","FMI","FLAST","PRN","LCR","RSTAT","SEX","DATE","BOC","WGT",
        "MNATL","TNC","TNAC","TNDC","MOCCP","MAGE","RESIDE","FNATL","FOCCP",
        "FAGE","ATTD","TBIRTH","MRELI","FRELI","CSTAT","IND","PLACEMAR",
        "DATEMAR","DREG","USER","MODE"
    ];

    // Build dynamic SQL
    $updateSQL = "UPDATE birth SET ";
    foreach ($fields as $field) {
        $updateSQL .= "$field = ?, ";
    }
    $updateSQL .= "DATEMOD = NOW() WHERE ID = ?";

    // Prepare values
    $values = [];
    foreach ($fields as $field) {
        $values[] = $_POST[$field] ?? NULL;
    }
    $values[] = $id;

    // Bind parameters dynamically
    $types = str_repeat("s", count($fields)) . "i";

    $stmt = $conn->prepare($updateSQL);
    $stmt->bind_param($types, ...$values);

    if ($stmt->execute()) {
        header("Location: quick-search-birth.php?cris_update=1");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Birth Record (CRIS)</title>
    <style>
        body { font-family: Arial; background: #eef0f3; padding: 20px; }
        .container { background: white; padding: 20px; width: 850px; margin: auto; border-radius: 10px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 15px; }
        .row { display: flex; gap: 10px; }
        .col { flex: 1; }
        button { padding: 10px 18px; background: #2563eb; color: white; border-radius: 6px; border: none; cursor: pointer; }
        a { text-decoration: none; display: inline-block; margin-top: 10px; }
        h2 { margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Birth Record (CRIS)</h2>

    <form method="POST">

        <?php
        // Render all fields automatically
        foreach ($record as $field => $value) {
            if ($field === "ID" || $field === "DATEMOD") continue;

            echo "<label>$field</label>";

            if ($field === "DATE" || $field === "DATEMAR" || $field === "DREG") {
                echo "<input type='date' name='$field' value='$value'>";
            } elseif ($field === "WGT") {
                echo "<input type='number' step='0.01' name='$field' value='$value'>";
            } else {
                echo "<input type='text' name='$field' value=\"" . htmlspecialchars($value) . "\">";
            }
        }
        ?>

        <button type="submit">Save Changes</button>

    </form>

    <a href="quick-search-birth.php">← Back to Search</a>
</div>

</body>
</html>
