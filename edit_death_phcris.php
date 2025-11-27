<?php
session_start();

if (!isset($_SESSION['userrealname'])) {
    header("Location: index.html");
    exit;
}
// edit_death_phcris.php
// Dynamic edit form for mbdis_phcris.death — all fields editable
// Works on older PHP versions (no use of variadic ... in bind_param)

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

// ========== UPDATE RECORD ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Build field list and values (skip ID if provided in POST)
    $fields = [];
    $values = [];

    foreach ($_POST as $key => $val) {
        if ($key === "ID") continue;
        $fields[] = "`$key` = ?";
        $values[] = $val;
    }

    // nothing to update?
    if (count($fields) === 0) {
        header("Location: quick-search-death.php?ph_updated=1");
        exit;
    }

    $sql = "UPDATE `death` SET " . implode(", ", $fields) . " WHERE `ID` = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // build types string: all strings for dynamic simplicity, then final 'i' for ID
    // If you want stricter typing you can map column names to types.
    $types = str_repeat("s", count($values)) . "i";
    $values[] = $id; // add ID as last param

    // bind_param requires references for call_user_func_array
    $bind_names[] = $types;
    for ($i = 0; $i < count($values); $i++) {
        // create a variable reference for each value
        $bind_name = 'bind_' . $i;
        $$bind_name = $values[$i];
        $bind_names[] = &$$bind_name;
    }

    // call bind_param with dynamic params
    if (!call_user_func_array([$stmt, 'bind_param'], $bind_names)) {
        die("bind_param failed: " . $stmt->error);
    }

    if ($stmt->execute()) {
        header("Location: quick-search-death.php?ph_updated=1");
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}

// ========== FETCH RECORD ==========
$stmt = $conn->prepare("SELECT * FROM `death` WHERE `ID` = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result === false) {
    die("Fetch failed: " . $conn->error);
}
$record = $result->fetch_assoc();
if (!$record) {
    die("Record not found.");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Death Record (PHCRIS)</title>
<style>
    body{font-family:Arial,Helvetica,sans-serif;padding:18px;}
    .grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;max-width:1100px;}
    .field{margin-bottom:8px;}
    label{display:block;font-size:12px;color:#333;font-weight:600;margin-bottom:4px;}
    input[type=text], input[type=date], input[type=time], input[type=datetime-local], textarea{
        width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:14px;
    }
    textarea{min-height:80px;resize:vertical;}
    .full{grid-column:1/-1;}
    button{padding:10px 16px;background:#059669;color:#fff;border:0;border-radius:6px;cursor:pointer;}
</style>
</head>
<body>

<h2>Edit Death Record (PHCRIS)</h2>
<form method="post">
    <div class="grid">
        <?php
        foreach ($record as $field => $value) {
            if ($field === 'ID') {
                echo '<input type="hidden" name="ID" value="'.htmlspecialchars($value).'">';
                continue;
            }

            // decide input type
            $inputType = 'text';
            if (preg_match('/date$/i', $field)) $inputType = 'date';
            if (preg_match('/time$/i', $field)) $inputType = 'time';
            if (preg_match('/datetime/i', $field)) $inputType = 'datetime-local';

            // format datetime-local if present
            $displayValue = $value;
            if ($inputType === 'datetime-local' && !empty($value)) {
                // ensure seconds precision trimmed if DB has them
                $displayValue = str_replace(' ', 'T', $displayValue);
            }

            // long text fields -> textarea; otherwise input
            $isTextArea = (is_string($value) && strlen($value) > 300) || stripos($field,'remark') !== false || stripos($field,'address') !== false || stripos($field,'DocumentCoding') !== false || stripos($field,'ImageFile') !== false || stripos($field,'Image') !== false;

            // make some fields full width for readability
            $wrapClass = $isTextArea || strlen($field) > 20 ? 'field full' : 'field';
            echo '<div class="'. $wrapClass .'">';
            echo '<label>'.htmlspecialchars($field).'</label>';

            if ($isTextArea) {
                echo '<textarea name="'.htmlspecialchars($field).'">'.htmlspecialchars($displayValue).'</textarea>';
            } else {
                echo '<input type="'. $inputType .'" name="'.htmlspecialchars($field).'" value="'.htmlspecialchars($displayValue).'">';
            }

            echo '</div>';
        }
        ?>
    </div>

    <p style="margin-top:16px;">
        <button type="submit">Save Changes</button>
        &nbsp;
        <a href="quick-search-death.php" style="text-decoration:none;color:#555;margin-left:12px;">Cancel</a>
    </p>
</form>

</body>
</html>
