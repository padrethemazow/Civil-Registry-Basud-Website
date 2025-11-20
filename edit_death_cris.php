<?php
// Connect DB
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mbdis_cris";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// GET record by ID
if (!isset($_GET['id'])) {
    die("No record ID provided.");
}

$id = intval($_GET['id']);

// --- UPDATE RECORD ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("
        UPDATE death SET
            CT=?, PLACE=?, FOLIO_NO=?, PAGE_NO=?, FIRST=?, MI=?, LAST=?, PRN=?, 
            LCR_NO=?, REG_STAT=?, SEX=?, RELIG=?, AGE=?, DATEX=?, NATLTY=?, URES=?, 
            CS=?, UOCC=?, CAUSEX=?, MED_ATT=?, MAGE=?, METHOD=?, LENGTH=?, TYPE=?, 
            CAUSE1=?, CAUSE2=?, IND=?, DREG=?, USER=?, DATEMOD=?, MODE=?
        WHERE ID=?
    ");

    $stmt->bind_param(
        "iisssssssiiiissssisssisssssssisi",
        $_POST['CT'], $_POST['PLACE'], $_POST['FOLIO_NO'], $_POST['PAGE_NO'],
        $_POST['FIRST'], $_POST['MI'], $_POST['LAST'], $_POST['PRN'],
        $_POST['LCR_NO'], $_POST['REG_STAT'], $_POST['SEX'], $_POST['RELIG'],
        $_POST['AGE'], $_POST['DATEX'], $_POST['NATLTY'], $_POST['URES'],
        $_POST['CS'], $_POST['UOCC'], $_POST['CAUSEX'], $_POST['MED_ATT'],
        $_POST['MAGE'], $_POST['METHOD'], $_POST['LENGTH'], $_POST['TYPE'],
        $_POST['CAUSE1'], $_POST['CAUSE2'], $_POST['IND'],
        $_POST['DREG'], $_POST['USER'], $_POST['DATEMOD'], $_POST['MODE'],
        $id
    );

    if ($stmt->execute()) {
        header("Location: quick-search-death.php?updated=1");
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}

// --- FETCH RECORD ---
$stmt = $conn->prepare("SELECT * FROM death WHERE ID=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$record = $stmt->get_result()->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Death Record</title>
</head>
<body>

<h2>Edit Death Record</h2>

<form method="post">

<?php foreach ($record as $field => $value): ?>
    <?php if ($field == "ID") continue; ?>  

    <label><?= $field ?>:</label><br>

    <?php if ($field === "DATEX" || $field === "DREG"): ?>
        <input type="date" name="<?= $field ?>" value="<?= $value ?>"><br><br>

    <?php elseif ($field === "DATEMOD"): ?>
        <input type="datetime-local" name="<?= $field ?>" value="<?= str_replace(' ', 'T', $value) ?>"><br><br>

    <?php else: ?>
        <input type="text" name="<?= $field ?>" value="<?= htmlspecialchars($value) ?>"><br><br>
    <?php endif; ?>

<?php endforeach; ?>

<button type="submit">Save Changes</button>

</form>

</body>
</html>
