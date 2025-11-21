<?php
// edit_marriage_cris.php
// Full corrected version (uses PDO for robust binding & null handling)

// --- Config ---
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "mbdis_cris"; // keep your original DB name

// Set timezone (Asia/Manila as per your environment)
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

// --- Get ID ---
if (!isset($_GET['id'])) {
    die("No record ID provided.");
}
$id = intval($_GET['id']);

// --- Fetch record ---
try {
    $stmt = $pdo->prepare("SELECT * FROM marriage WHERE ID = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if (!$row) {
        die("Record not found.");
    }
} catch (Exception $e) {
    die("Error fetching record: " . htmlspecialchars($e->getMessage()));
}

// --- Handle Update ---
if (isset($_POST['update'])) {
    // list of editable columns (kept consistent with your table)
    $fields = [
        'CT','PLACE','FOL','PAGE',
        'G_FNAME','G_MI','G_LNAME','G_AGE','G_CITI','G_RESI','G_RELI','G_STATUS','G_PRN',
        'W_FNAME','W_MI','W_LNAME','W_AGE','W_CITI','W_RESI','W_RELI','W_STATUS','W_PRN',
        'G_FFIRST','G_FMI','G_FLAST','G_MFIRST','G_MMI','G_MLAST',
        'W_FFIRST','W_FMI','W_FLAST','W_MFIRST','W_MMI','W_MLAST',
        'DATE','CEREMONY','IND','DREG','USER','MODE','REGST','LCR'
        // DATEMOD will be auto-updated below
    ];

    // fields that are integers (if you want explicit casting)
    $int_fields = ['CT','PLACE','G_AGE','W_AGE','G_RELI','W_RELI','REGST'];

    $update_pairs = [];
    $params = [];

    foreach ($fields as $field) {
        $update_pairs[] = "`$field` = :$field";
        // get POSTed value; if missing => null
        $val = array_key_exists($field, $_POST) ? $_POST[$field] : null;

        // convert empty strings to NULL
        if ($val === '') $val = null;

        // cast integer-like fields to int if not null
        if (in_array($field, $int_fields, true) && $val !== null) {
            // remove non-digits except leading minus
            $val = preg_replace('/[^\d\-]/', '', (string)$val);
            if ($val === '') {
                $val = null;
            } else {
                $val = intval($val);
            }
        }

        $params[$field] = $val;
    }

    // Update DATEMOD to now
    $update_pairs[] = "`DATEMOD` = :DATEMOD";
    $params['DATEMOD'] = date('Y-m-d H:i:s');

    // Build SQL
    $sql = "UPDATE `marriage` SET " . implode(', ', $update_pairs) . " WHERE `ID` = :ID";
    $params['ID'] = $id;

    try {
        $stmt2 = $pdo->prepare($sql);
        $stmt2->execute($params);

        // Redirect after successful update
        header("Location: quick-search-marriage.php?updated=1");
        exit;
    } catch (Exception $e) {
        echo "<p style='color:red;'>Error updating record: " . htmlspecialchars($e->getMessage()) . "</p>";
    }

    // Refresh $row from DB after update so form shows latest values
    try {
        $stmt = $pdo->prepare("SELECT * FROM marriage WHERE ID = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) {
            die("Record not found after update.");
        }
    } catch (Exception $e) {
        // ignore; the update already reported error if any
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Legacy CRIS Marriage</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; margin:20px; background:#f7f8fa; color:#111; }
        .container { max-width:980px; margin:0 auto; background:#fff; padding:18px; border-radius:8px; box-shadow:0 6px 18px rgba(0,0,0,0.06); }
        h2 { margin-top:0; }
        label { font-weight:600; display:block; margin-top:10px; font-size:14px; }
        input[type="text"], input[type="date"], input[type="number"], select { width:100%; padding:8px 10px; margin-top:6px; border:1px solid #ccd0d6; border-radius:6px; box-sizing:border-box; }
        fieldset { margin-bottom:16px; padding:12px; border-radius:8px; border:1px solid #e2e6ea; background:#fafafa; }
        legend { font-weight:700; padding:0 8px; }
        .two-col { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .full { grid-column:1/-1; }
        button { background:#0052cc; color:#fff; border:0; padding:10px 16px; border-radius:8px; cursor:pointer; font-weight:700; }
        .meta { font-size:13px; color:#666; margin-bottom:12px; }
        @media (max-width:700px) {
            .two-col { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Legacy CRIS Marriage Record — ID <?= htmlspecialchars($id) ?></h2>
    <p class="meta">Last modified: <?= htmlspecialchars($row['DATEMOD'] ?? 'N/A') ?></p>

    <form method="post" autocomplete="off">
        <!-- Groom Section -->
        <fieldset>
            <legend>Groom Information</legend>
            <div class="two-col">
                <?php
                $groom_fields = ['G_FNAME'=>'First Name','G_MI'=>'M.I.','G_LNAME'=>'Last Name','G_AGE'=>'Age',
                                 'G_CITI'=>'Citizenship','G_RESI'=>'Residence','G_RELI'=>'Religion','G_STATUS'=>'Civil Status','G_PRN'=>'PRN'];
                foreach ($groom_fields as $f => $label) {
                    $val = $row[$f] ?? '';
                    $type = ($f === 'G_AGE') ? 'number' : 'text';
                    echo "<div><label>".htmlspecialchars($label)."</label>";
                    echo "<input type='{$type}' name='".htmlspecialchars($f)."' value='".htmlspecialchars($val)."'></div>";
                }
                ?>
            </div>
        </fieldset>

        <!-- Wife Section -->
        <fieldset>
            <legend>Wife Information</legend>
            <div class="two-col">
                <?php
                $wife_fields = ['W_FNAME'=>'First Name','W_MI'=>'M.I.','W_LNAME'=>'Last Name','W_AGE'=>'Age',
                                'W_CITI'=>'Citizenship','W_RESI'=>'Residence','W_RELI'=>'Religion','W_STATUS'=>'Civil Status','W_PRN'=>'PRN'];
                foreach ($wife_fields as $f => $label) {
                    $val = $row[$f] ?? '';
                    $type = ($f === 'W_AGE') ? 'number' : 'text';
                    echo "<div><label>".htmlspecialchars($label)."</label>";
                    echo "<input type='{$type}' name='".htmlspecialchars($f)."' value='".htmlspecialchars($val)."'></div>";
                }
                ?>
            </div>
        </fieldset>

        <!-- Groom Parents -->
        <fieldset>
            <legend>Groom Parents</legend>
            <div class="two-col">
                <?php
                $gpar_fields = ['G_FFIRST'=>'Father First','G_FMI'=>'Father M.I.','G_FLAST'=>'Father Last',
                                'G_MFIRST'=>'Mother First','G_MMI'=>'Mother M.I.','G_MLAST'=>'Mother Last'];
                foreach ($gpar_fields as $f => $label) {
                    $val = $row[$f] ?? '';
                    echo "<div><label>".htmlspecialchars($label)."</label>";
                    echo "<input type='text' name='".htmlspecialchars($f)."' value='".htmlspecialchars($val)."'></div>";
                }
                ?>
            </div>
        </fieldset>

        <!-- Wife Parents -->
        <fieldset>
            <legend>Wife Parents</legend>
            <div class="two-col">
                <?php
                $wpar_fields = ['W_FFIRST'=>'Father First','W_FMI'=>'Father M.I.','W_FLAST'=>'Father Last',
                                'W_MFIRST'=>'Mother First','W_MMI'=>'Mother M.I.','W_MLAST'=>'Mother Last'];
                foreach ($wpar_fields as $f => $label) {
                    $val = $row[$f] ?? '';
                    echo "<div><label>".htmlspecialchars($label)."</label>";
                    echo "<input type='text' name='".htmlspecialchars($f)."' value='".htmlspecialchars($val)."'></div>";
                }
                ?>
            </div>
        </fieldset>

        <!-- Ceremony & Registration -->
        <fieldset>
            <legend>Ceremony & Registration</legend>
            <div class="two-col">
                <?php
                // show some fields as appropriate types
                $ceremony_fields = [
                    'DATE' => ['label'=>'Date of Marriage','type'=>'date'],
                    'CEREMONY' => ['label'=>'Place of Marriage','type'=>'text'],
                    'FOL' => ['label'=>'Book Number (FOL)','type'=>'text'],
                    'PAGE' => ['label'=>'Page Number','type'=>'text'],
                    'LCR' => ['label'=>'Registry Number (LCR)','type'=>'text'],
                    'PLACE' => ['label'=>'Place Code','type'=>'text'],
                    'DREG' => ['label'=>'Date Registered','type'=>'date'],
                    'IND' => ['label'=>'IND','type'=>'text'],
                    'USER' => ['label'=>'USER','type'=>'text'],
                    'MODE' => ['label'=>'MODE','type'=>'text'],
                    'CT' => ['label'=>'Certificate Type (CT)','type'=>'text'],
                    'REGST' => ['label'=>'Registration Status (REGST)','type'=>'text']
                ];

                foreach ($ceremony_fields as $f => $meta) {
                    $val = $row[$f] ?? '';
                    $type = $meta['type'];
                    echo "<div><label>".htmlspecialchars($meta['label'])."</label>";
                    echo "<input type='{$type}' name='".htmlspecialchars($f)."' value='".htmlspecialchars($val)."'></div>";
                }
                ?>
            </div>
            <div style="margin-top:10px;">
                <label>DATEMOD (auto-updated):</label>
                <input type="text" value="<?= htmlspecialchars($row['DATEMOD'] ?? '') ?>" readonly>
            </div>
        </fieldset>

        <div style="display:flex; gap:12px; align-items:center;">
            <button type="submit" name="update">Save Changes</button>
            <a href="quick-search-marriage.php" style="text-decoration:none; color:#0052cc; font-weight:600;">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
