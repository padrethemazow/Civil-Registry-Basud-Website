<?php
// add_death_phcris.php
// Add a new PHCRIS death record (all columns, dynamic like birth/marriage)

// --- Config ---
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "mbdis_phcris";

date_default_timezone_set('Asia/Manila');

try {
    $dsn = "mysql:host={$servername};dbname={$dbname};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Exception $e) {
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}

// --- Get all columns dynamically ---
$columns = [];
$textareaFields = [];
$stmtCols = $pdo->query("DESCRIBE death");
while ($row = $stmtCols->fetch()) {
    if ($row['Extra'] !== 'auto_increment') {
        $columns[] = $row['Field'];
        if (stripos($row['Type'], 'text') !== false) {
            $textareaFields[] = $row['Field'];
        }
    }
}

// --- Handle form submission ---
if (isset($_POST['submit'])) {
    $params = [];
    foreach ($columns as $col) {
        $val = $_POST[$col] ?? null;
        if ($val === '') $val = null;
        $params[$col] = $val;
    }

    $placeholders = implode(',', array_fill(0, count($columns), '?'));
    $sql = "INSERT INTO death (" . implode(',', $columns) . ") VALUES ($placeholders)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute(array_values($params));
        header("Location: quick-search-death.php?added=1");
        exit;
    } catch (Exception $e) {
        echo "<p style='color:red;'>Error adding record: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add PHCRIS Death Record</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; margin:20px; background:#f7f8fa; color:#111; }
        .container { max-width:1000px; margin:0 auto; background:#fff; padding:18px; border-radius:8px; box-shadow:0 6px 18px rgba(0,0,0,0.06); }
        h2 { margin-top:0; }
        label { font-weight:600; display:block; margin-top:10px; font-size:14px; }
        input[type="text"], input[type="date"], input[type="time"], input[type="number"], select, textarea {
            width:100%; padding:8px 10px; margin-top:6px; border:1px solid #ccd0d6; border-radius:6px; box-sizing:border-box;
        }
        textarea { resize: vertical; min-height:40px; }
        .two-col { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        button { background:#0052cc; color:#fff; border:0; padding:10px 16px; border-radius:8px; cursor:pointer; font-weight:700; }
        @media (max-width:700px) { .two-col { grid-template-columns:1fr; } }
    </style>
</head>
<body>
<div class="container">
    <h2>Add New PHCRIS Death Record</h2>
    <form method="post" autocomplete="off">
        <?php
        $half = ceil(count($columns)/2);
        $chunks = array_chunk($columns, $half, true);

        foreach ($chunks as $chunk) {
            echo '<div class="two-col">';
            foreach ($chunk as $col) {

                $type = 'text';
                $lower = strtolower($col);

                if (strpos($lower, 'date') !== false) $type = 'date';
                if (strpos($lower, 'time') !== false) $type = 'time';
                if (strpos($lower, 'id') !== false || strpos($lower, 'age') !== false || strpos($lower, 'number') !== false) $type = 'number';

                echo "<div><label>" . htmlspecialchars($col) . "</label>";

                if (in_array($col, $textareaFields)) {
                    echo "<textarea name='" . htmlspecialchars($col) . "'></textarea></div>";
                } else {
                    echo "<input type='{$type}' name='" . htmlspecialchars($col) . "'></div>";
                }
            }
            echo '</div>';
        }
        ?>

        <br>
        <button type="submit" name="submit">Add Record</button>
        <a href="quick-search-death.php" style="margin-left:12px;">Cancel</a>
    </form>
</div>
</body>
</html>
