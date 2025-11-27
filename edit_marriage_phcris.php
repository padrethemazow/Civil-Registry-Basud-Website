<?php
session_start();

if (!isset($_SESSION['userrealname'])) {
    header("Location: index.html");
    exit;
}
// edit_phmarriage.php
// Full PDO editor for `phmarriage` (all fields) — uses prepared statements & safe NULL handling

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

// --- ID required ---
if (!isset($_GET['id'])) die("Missing ID.");
$id = intval($_GET['id']);

// --- Fetch record ---
try {
    $stmt = $pdo->prepare("SELECT * FROM phmarriage WHERE ID = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if (!$row) die("Record not found.");
} catch (Exception $e) {
    die("Error fetching record: " . htmlspecialchars($e->getMessage()));
}

// --- Column definitions (name => type) ---
// types: 'text' (use textarea), 'date', 'time', 'checkbox' (tinyint(1)), 'textline' (single-line)
$cols = [
    'PlaceOfMarriage' => 'text',
    'DateOfMarriage' => 'date',
    'TimeOfMarriage' => 'time',
    'HusbandName' => 'textline',
    'WifeName' => 'textline',
    'HasMarriageSettlement' => 'checkbox',
    'MarriageSettlementDate' => 'date',
    'WithMarriageLicense' => 'checkbox',
    'MarriageLicenseNumber' => 'textline',
    'MarriageLicenseDateIssued' => 'date',
    'MarriageLicensePlaceIssued' => 'text',
    'ExecutiveOrderNo209' => 'checkbox',
    'HasEO209' => 'checkbox',
    'PresidentialDecree1083' => 'checkbox',
    'SolemnizingOfficerName' => 'textline',
    'SolemnizingOfficerTitle' => 'textline',
    'SolemnizingOfficerAddress' => 'text',
    'SolemnizingOfficerReligiousSect' => 'checkbox',
    'RegistryNumber' => 'textline',
    'ExpirationDate' => 'date',
    'HasWitness' => 'checkbox',
    'ReceiverName' => 'textline',
    'ReceiverTitle' => 'textline',
    'DateReceived' => 'date',
    'RegistrarName' => 'textline',
    'RegistrarTitle' => 'textline',
    'DateRegistered' => 'date',
    'DelayedOrCorrected' => 'text',
    'Witness1Name' => 'textline',
    'Witness2Name' => 'textline',
    'Witness3Name' => 'textline',
    'Witness4Name' => 'textline',
    'SolemnizingOfficerReligiousSectName' => 'textline',
    'SolemnizingOfficerReligiousSectAddress' => 'text',
    'CHusbandName' => 'textline',
    'CWifeName' => 'textline',
    'SectionD' => 'text',
    'SectionE' => 'text',
    'CeremonyDate' => 'date',
    'CeremonyPlace' => 'text',
    'SignatureOfSolemnizingOfficer' => 'text',
    'PrintedNameOfSolemnizingOfficer' => 'textline',
    'DateSigned1' => 'date',
    'DateSigned2' => 'date',
    'LocationSigned' => 'text',
    'CommunityTaxCert' => 'textline',
    'CommunityTaxCertDate' => 'date',
    'CommunityTaxCertPlace' => 'text',
    'AdminOfficerSignature' => 'text',
    'AdminOfficerName' => 'textline',
    'AdminOfficerTitle' => 'textline',
    'AdminOfficerAddress' => 'text',
    'AffiantName' => 'textline',
    'AffiantSingle' => 'checkbox',
    'AffiantMarried' => 'checkbox',
    'AffiantDivorced' => 'checkbox',
    'AffiantWidowed' => 'checkbox',
    'AffiantWidower' => 'checkbox',
    'AffiantAddress' => 'text',
    'IfMy' => 'text',
    'HasSpouse' => 'checkbox',
    'MarriagePlace' => 'text',
    'MarriageDate' => 'date',
    'MarriageOf' => 'text',
    'MarriageHusbandName' => 'textline',
    'MarriageWifeName' => 'textline',
    'MarriagePlaceRepeat' => 'text',
    'MarriageDateRepeat' => 'date',
    'MarriageSolemnizingOfficerName' => 'textline',
    'ReligiousCeremony' => 'checkbox',
    'CivilCeremony' => 'checkbox',
    'MuslimRites' => 'checkbox',
    'TribalRites' => 'checkbox',
    'MarriageLicenseMarker' => 'text',
    'MarriageLicenseNumberRepeat' => 'textline',
    'MarriageLicenseDateIssuedRepeat' => 'date',
    'MarriageLicensePlaceIssuedRepeat' => 'text',
    'IsExecutiveOrder209' => 'checkbox',
    'ArticleNumber' => 'textline',
    'AffiantCountry' => 'textline',
    'SpouseCountry' => 'textline',
    'WifeCountry' => 'textline',
    'HusbandCountry' => 'textline',
    'ReasonForDelayedRegistration' => 'text',
    'AffiantSignedDate' => 'date',
    'AffiantSignedPlace' => 'text',
    'AffiantPrintedName' => 'textline',
    'DateSubscribed' => 'date',
    'PlaceSubscribed' => 'text',
    'CTCNumber' => 'textline',
    'CTCDateIssued' => 'date',
    'CTCPlaceIssued' => 'text',
    'SolemnizingOfficerNameRepeat' => 'textline',
    'SolemnizingOfficerTitleRepeat' => 'textline',
    'SolemnizingOfficerAddressRepeat' => 'text'
];

// --- Handle Update ---
if (isset($_POST['update'])) {
    $update_pairs = [];
    $params = [];

    foreach ($cols as $col => $type) {
        // checkbox: set 1 if present, else 0
        if ($type === 'checkbox') {
            $val = isset($_POST[$col]) ? 1 : 0;
        } else {
            $val = array_key_exists($col, $_POST) ? $_POST[$col] : null;
            if ($val === '') $val = null;
        }

        // basic sanitization/casting for date/time fields (null or value)
        if ($type === 'date' && $val !== null) {
            // ensure format YYYY-MM-DD or set null
            $d = date_create($val);
            $val = $d ? $d->format('Y-m-d') : null;
        } elseif ($type === 'time' && $val !== null) {
            $t = date_create($val);
            $val = $t ? $t->format('H:i:s') : null;
        }

        $update_pairs[] = "`$col` = :$col";
        $params[$col] = $val;
    }

    // Build SQL
    $sql = "UPDATE `phmarriage` SET " . implode(', ', $update_pairs) . " WHERE `ID` = :ID";
    $params['ID'] = $id;

    try {
        $stmt2 = $pdo->prepare($sql);
        $stmt2->execute($params);

        header("Location: quick-search-marriage.php?updated=1");
        exit;
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }

    // reload row
    try {
        $stmt = $pdo->prepare("SELECT * FROM phmarriage WHERE ID = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) die("Record not found after update.");
    } catch (Exception $e) {
        // ignore
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit PHCRIS Marriage — ID <?= htmlspecialchars($id) ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; margin:16px; background:#f6f7fb; color:#111; }
        .container { max-width:1200px; margin:0 auto; background:#fff; padding:18px; border-radius:8px; box-shadow:0 6px 20px rgba(0,0,0,0.06); }
        h2 { margin-top:0; }
        label { font-weight:600; display:block; margin-top:8px; font-size:14px; }
        input[type="text"], input[type="date"], input[type="time"], textarea { width:100%; padding:8px 10px; margin-top:6px; border:1px solid #d0d6dd; border-radius:6px; box-sizing:border-box; }
        textarea { min-height:80px; }
        fieldset { margin-bottom:12px; padding:12px; border-radius:8px; border:1px solid #e6eaee; background:#fbfcfe; }
        legend { font-weight:700; padding:0 8px; }
        .two-col { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .three-col { display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; }
        .full { grid-column:1/-1; }
        .buttons { display:flex; gap:12px; align-items:center; margin-top:10px; }
        button { background:#0b63d9; color:#fff; border:0; padding:10px 14px; border-radius:8px; cursor:pointer; font-weight:700; }
        .note { font-size:13px; color:#666; }
        .error { color:#c00; font-weight:700; margin-bottom:8px; }
        @media (max-width:900px) {
            .two-col,.three-col { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit PHCRIS Marriage Record — ID <?= htmlspecialchars($id) ?></h2>
    <?php if (!empty($error_msg)): ?>
        <p class="error"><?= htmlspecialchars($error_msg) ?></p>
    <?php endif; ?>

    <form method="post" autocomplete="off">

        <fieldset>
            <legend>Basic Marriage Info</legend>
            <div class="two-col">
                <div>
                    <label>Place Of Marriage</label>
                    <textarea name="PlaceOfMarriage"><?= htmlspecialchars($row['PlaceOfMarriage'] ?? '') ?></textarea>
                </div>
                <div>
                    <label>Date Of Marriage</label>
                    <input type="date" name="DateOfMarriage" value="<?= htmlspecialchars($row['DateOfMarriage'] ?? '') ?>">
                </div>
                <div>
                    <label>Time Of Marriage</label>
                    <input type="time" name="TimeOfMarriage" value="<?= htmlspecialchars($row['TimeOfMarriage'] ?? '') ?>">
                </div>
                <div>
                    <label>Registry Number</label>
                    <input type="text" name="RegistryNumber" value="<?= htmlspecialchars($row['RegistryNumber'] ?? '') ?>">
                </div>
                <div>
                    <label>Date Registered</label>
                    <input type="date" name="DateRegistered" value="<?= htmlspecialchars($row['DateRegistered'] ?? '') ?>">
                </div>
                <div>
                    <label>Expiration Date</label>
                    <input type="date" name="ExpirationDate" value="<?= htmlspecialchars($row['ExpirationDate'] ?? '') ?>">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Spouses</legend>
            <div class="two-col">
                <div>
                    <label>Husband Name</label>
                    <input type="text" name="HusbandName" value="<?= htmlspecialchars($row['HusbandName'] ?? '') ?>">
                </div>
                <div>
                    <label>Wife Name</label>
                    <input type="text" name="WifeName" value="<?= htmlspecialchars($row['WifeName'] ?? '') ?>">
                </div>

                <div>
                    <label>Husband Country</label>
                    <input type="text" name="HusbandCountry" value="<?= htmlspecialchars($row['HusbandCountry'] ?? '') ?>">
                </div>
                <div>
                    <label>Wife Country</label>
                    <input type="text" name="WifeCountry" value="<?= htmlspecialchars($row['WifeCountry'] ?? '') ?>">
                </div>
                <div class="full">
                    <label>CHusbandName</label>
                    <input type="text" name="CHusbandName" value="<?= htmlspecialchars($row['CHusbandName'] ?? '') ?>">
                </div>
                <div class="full">
                    <label>CWifeName</label>
                    <input type="text" name="CWifeName" value="<?= htmlspecialchars($row['CWifeName'] ?? '') ?>">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Marriage License & Settlement</legend>
            <div class="two-col">
                <div>
                    <label><input type="checkbox" name="HasMarriageSettlement" <?= !empty($row['HasMarriageSettlement']) ? 'checked' : '' ?>> Has Marriage Settlement</label>
                </div>
                <div>
                    <label>Marriage Settlement Date</label>
                    <input type="date" name="MarriageSettlementDate" value="<?= htmlspecialchars($row['MarriageSettlementDate'] ?? '') ?>">
                </div>

                <div>
                    <label><input type="checkbox" name="WithMarriageLicense" <?= !empty($row['WithMarriageLicense']) ? 'checked' : '' ?>> With Marriage License</label>
                </div>
                <div>
                    <label>Marriage License Number</label>
                    <input type="text" name="MarriageLicenseNumber" value="<?= htmlspecialchars($row['MarriageLicenseNumber'] ?? '') ?>">
                </div>
                <div>
                    <label>Marriage License Date Issued</label>
                    <input type="date" name="MarriageLicenseDateIssued" value="<?= htmlspecialchars($row['MarriageLicenseDateIssued'] ?? '') ?>">
                </div>
                <div>
                    <label>Marriage License Place Issued</label>
                    <input type="text" name="MarriageLicensePlaceIssued" value="<?= htmlspecialchars($row['MarriageLicensePlaceIssued'] ?? '') ?>">
                </div>

                <div>
                    <label><input type="checkbox" name="IsExecutiveOrder209" <?= !empty($row['IsExecutiveOrder209']) ? 'checked' : '' ?>> Is Executive Order 209</label>
                </div>
                <div>
                    <label><input type="checkbox" name="HasEO209" <?= !empty($row['HasEO209']) ? 'checked' : '' ?>> Has EO209</label>
                </div>
                <div>
                    <label><input type="checkbox" name="ExecutiveOrderNo209" <?= !empty($row['ExecutiveOrderNo209']) ? 'checked' : '' ?>> Executive Order No. 209</label>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Solemnizing Officer</legend>
            <div class="two-col">
                <div>
                    <label>Solemnizing Officer Name</label>
                    <input type="text" name="SolemnizingOfficerName" value="<?= htmlspecialchars($row['SolemnizingOfficerName'] ?? '') ?>">
                </div>
                <div>
                    <label>Solemnizing Officer Title</label>
                    <input type="text" name="SolemnizingOfficerTitle" value="<?= htmlspecialchars($row['SolemnizingOfficerTitle'] ?? '') ?>">
                </div>
                <div class="full">
                    <label>Solemnizing Officer Address</label>
                    <textarea name="SolemnizingOfficerAddress"><?= htmlspecialchars($row['SolemnizingOfficerAddress'] ?? '') ?></textarea>
                </div>
                <div>
                    <label><input type="checkbox" name="SolemnizingOfficerReligiousSect" <?= !empty($row['SolemnizingOfficerReligiousSect']) ? 'checked' : '' ?>> Religious Sect</label>
                </div>
                <div>
                    <label>Solemnizing Officer Religious Sect Name</label>
                    <input type="text" name="SolemnizingOfficerReligiousSectName" value="<?= htmlspecialchars($row['SolemnizingOfficerReligiousSectName'] ?? '') ?>">
                </div>
                <div class="full">
                    <label>Solemnizing Officer Religious Sect Address</label>
                    <textarea name="SolemnizingOfficerReligiousSectAddress"><?= htmlspecialchars($row['SolemnizingOfficerReligiousSectAddress'] ?? '') ?></textarea>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Witnesses & Reception</legend>
            <div class="two-col">
                <div>
                    <label>Has Witness</label>
                    <label><input type="checkbox" name="HasWitness" <?= !empty($row['HasWitness']) ? 'checked' : '' ?>> Yes</label>
                </div>
                <div>
                    <label>Witness 1 Name</label>
                    <input type="text" name="Witness1Name" value="<?= htmlspecialchars($row['Witness1Name'] ?? '') ?>">
                </div>
                <div>
                    <label>Witness 2 Name</label>
                    <input type="text" name="Witness2Name" value="<?= htmlspecialchars($row['Witness2Name'] ?? '') ?>">
                </div>
                <div>
                    <label>Witness 3 Name</label>
                    <input type="text" name="Witness3Name" value="<?= htmlspecialchars($row['Witness3Name'] ?? '') ?>">
                </div>
                <div>
                    <label>Witness 4 Name</label>
                    <input type="text" name="Witness4Name" value="<?= htmlspecialchars($row['Witness4Name'] ?? '') ?>">
                </div>
            </div>
            <div class="two-col" style="margin-top:10px;">
                <div>
                    <label>Receiver Name</label>
                    <input type="text" name="ReceiverName" value="<?= htmlspecialchars($row['ReceiverName'] ?? '') ?>">
                </div>
                <div>
                    <label>Receiver Title</label>
                    <input type="text" name="ReceiverTitle" value="<?= htmlspecialchars($row['ReceiverTitle'] ?? '') ?>">
                </div>
                <div>
                    <label>Date Received</label>
                    <input type="date" name="DateReceived" value="<?= htmlspecialchars($row['DateReceived'] ?? '') ?>">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Registrar / Admin Officer</legend>
            <div class="two-col">
                <div>
                    <label>Registrar Name</label>
                    <input type="text" name="RegistrarName" value="<?= htmlspecialchars($row['RegistrarName'] ?? '') ?>">
                </div>
                <div>
                    <label>Registrar Title</label>
                    <input type="text" name="RegistrarTitle" value="<?= htmlspecialchars($row['RegistrarTitle'] ?? '') ?>">
                </div>
                <div>
                    <label>Admin Officer Name</label>
                    <input type="text" name="AdminOfficerName" value="<?= htmlspecialchars($row['AdminOfficerName'] ?? '') ?>">
                </div>
                <div>
                    <label>Admin Officer Title</label>
                    <input type="text" name="AdminOfficerTitle" value="<?= htmlspecialchars($row['AdminOfficerTitle'] ?? '') ?>">
                </div>
                <div class="full">
                    <label>Admin Officer Address</label>
                    <textarea name="AdminOfficerAddress"><?= htmlspecialchars($row['AdminOfficerAddress'] ?? '') ?></textarea>
                </div>
                <div class="full">
                    <label>Admin Officer Signature</label>
                    <textarea name="AdminOfficerSignature"><?= htmlspecialchars($row['AdminOfficerSignature'] ?? '') ?></textarea>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Affiant / Subscription / CTC</legend>
            <div class="two-col">
                <div>
                    <label>Affiant Name</label>
                    <input type="text" name="AffiantName" value="<?= htmlspecialchars($row['AffiantName'] ?? '') ?>">
                </div>
                <div>
                    <label>Affiant Address</label>
                    <textarea name="AffiantAddress"><?= htmlspecialchars($row['AffiantAddress'] ?? '') ?></textarea>
                </div>

                <div>
                    <label>Affiant Single</label>
                    <label><input type="checkbox" name="AffiantSingle" <?= !empty($row['AffiantSingle']) ? 'checked' : '' ?>> Single</label>
                </div>
                <div>
                    <label>Affiant Married</label>
                    <label><input type="checkbox" name="AffiantMarried" <?= !empty($row['AffiantMarried']) ? 'checked' : '' ?>> Married</label>
                </div>
                <div>
                    <label>Affiant Divorced</label>
                    <label><input type="checkbox" name="AffiantDivorced" <?= !empty($row['AffiantDivorced']) ? 'checked' : '' ?>> Divorced</label>
                </div>
                <div>
                    <label>Affiant Widowed</label>
                    <label><input type="checkbox" name="AffiantWidowed" <?= !empty($row['AffiantWidowed']) ? 'checked' : '' ?>> Widowed</label>
                </div>
                <div>
                    <label>Affiant Widower</label>
                    <label><input type="checkbox" name="AffiantWidower" <?= !empty($row['AffiantWidower']) ? 'checked' : '' ?>> Widower</label>
                </div>

                <div>
                    <label>Affiant Signed Date</label>
                    <input type="date" name="AffiantSignedDate" value="<?= htmlspecialchars($row['AffiantSignedDate'] ?? '') ?>">
                </div>
                <div>
                    <label>Affiant Signed Place</label>
                    <input type="text" name="AffiantSignedPlace" value="<?= htmlspecialchars($row['AffiantSignedPlace'] ?? '') ?>">
                </div>

                <div>
                    <label>Affiant Printed Name</label>
                    <input type="text" name="AffiantPrintedName" value="<?= htmlspecialchars($row['AffiantPrintedName'] ?? '') ?>">
                </div>
                <div>
                    <label>Date Subscribed</label>
                    <input type="date" name="DateSubscribed" value="<?= htmlspecialchars($row['DateSubscribed'] ?? '') ?>">
                </div>
                <div>
                    <label>Place Subscribed</label>
                    <input type="text" name="PlaceSubscribed" value="<?= htmlspecialchars($row['PlaceSubscribed'] ?? '') ?>">
                </div>

                <div>
                    <label>CTC Number</label>
                    <input type="text" name="CTCNumber" value="<?= htmlspecialchars($row['CTCNumber'] ?? '') ?>">
                </div>
                <div>
                    <label>CTC Date Issued</label>
                    <input type="date" name="CTCDateIssued" value="<?= htmlspecialchars($row['CTCDateIssued'] ?? '') ?>">
                </div>
                <div class="full">
                    <label>CTC Place Issued</label>
                    <textarea name="CTCPlaceIssued"><?= htmlspecialchars($row['CTCPlaceIssued'] ?? '') ?></textarea>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Ceremony / Location / Signatures</legend>
            <div class="two-col">
                <div>
                    <label>Ceremony Date</label>
                    <input type="date" name="CeremonyDate" value="<?= htmlspecialchars($row['CeremonyDate'] ?? '') ?>">
                </div>
                <div>
                    <label>Ceremony Place</label>
                    <textarea name="CeremonyPlace"><?= htmlspecialchars($row['CeremonyPlace'] ?? '') ?></textarea>
                </div>
                <div>
                    <label>Printed Name Of Solemnizing Officer</label>
                    <input type="text" name="PrintedNameOfSolemnizingOfficer" value="<?= htmlspecialchars($row['PrintedNameOfSolemnizingOfficer'] ?? '') ?>">
                </div>
                <div>
                    <label>Date Signed 1</label>
                    <input type="date" name="DateSigned1" value="<?= htmlspecialchars($row['DateSigned1'] ?? '') ?>">
                </div>
                <div>
                    <label>Date Signed 2</label>
                    <input type="date" name="DateSigned2" value="<?= htmlspecialchars($row['DateSigned2'] ?? '') ?>">
                </div>
                <div>
                    <label>Location Signed</label>
                    <textarea name="LocationSigned"><?= htmlspecialchars($row['LocationSigned'] ?? '') ?></textarea>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Misc / Repeats / Markers</legend>
            <div class="two-col">
                <div>
                    <label>Marriage Of</label>
                    <textarea name="MarriageOf"><?= htmlspecialchars($row['MarriageOf'] ?? '') ?></textarea>
                </div>
                <div>
                    <label>Marriage Place (repeat)</label>
                    <textarea name="MarriagePlaceRepeat"><?= htmlspecialchars($row['MarriagePlaceRepeat'] ?? '') ?></textarea>
                </div>
                <div>
                    <label>Marriage Date Repeat</label>
                    <input type="date" name="MarriageDateRepeat" value="<?= htmlspecialchars($row['MarriageDateRepeat'] ?? '') ?>">
                </div>
                <div>
                    <label>Marriage Solemnizing Officer Name (repeat)</label>
                    <input type="text" name="MarriageSolemnizingOfficerName" value="<?= htmlspecialchars($row['MarriageSolemnizingOfficerName'] ?? '') ?>">
                </div>
                <div>
                    <label>Religious Ceremony</label>
                    <label><input type="checkbox" name="ReligiousCeremony" <?= !empty($row['ReligiousCeremony']) ? 'checked' : '' ?>> Yes</label>
                </div>
                <div>
                    <label>Civil Ceremony</label>
                    <label><input type="checkbox" name="CivilCeremony" <?= !empty($row['CivilCeremony']) ? 'checked' : '' ?>> Yes</label>
                </div>
                <div>
                    <label>Muslim Rites</label>
                    <label><input type="checkbox" name="MuslimRites" <?= !empty($row['MuslimRites']) ? 'checked' : '' ?>> Yes</label>
                </div>
                <div>
                    <label>Tribal Rites</label>
                    <label><input type="checkbox" name="TribalRites" <?= !empty($row['TribalRites']) ? 'checked' : '' ?>> Yes</label>
                </div>
                <div class="full">
                    <label>Marriage License Marker</label>
                    <textarea name="MarriageLicenseMarker"><?= htmlspecialchars($row['MarriageLicenseMarker'] ?? '') ?></textarea>
                </div>
                <div>
                    <label>Marriage License Number Repeat</label>
                    <input type="text" name="MarriageLicenseNumberRepeat" value="<?= htmlspecialchars($row['MarriageLicenseNumberRepeat'] ?? '') ?>">
                </div>
                <div>
                    <label>Marriage License Date Issued Repeat</label>
                    <input type="date" name="MarriageLicenseDateIssuedRepeat" value="<?= htmlspecialchars($row['MarriageLicenseDateIssuedRepeat'] ?? '') ?>">
                </div>
                <div class="full">
                    <label>Marriage License Place Issued Repeat</label>
                    <textarea name="MarriageLicensePlaceIssuedRepeat"><?= htmlspecialchars($row['MarriageLicensePlaceIssuedRepeat'] ?? '') ?></textarea>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Location / Tax / Other</legend>
            <div class="two-col">
                <div>
                    <label>Community Tax Cert</label>
                    <input type="text" name="CommunityTaxCert" value="<?= htmlspecialchars($row['CommunityTaxCert'] ?? '') ?>">
                </div>
                <div>
                    <label>Community Tax Cert Date</label>
                    <input type="date" name="CommunityTaxCertDate" value="<?= htmlspecialchars($row['CommunityTaxCertDate'] ?? '') ?>">
                </div>
                <div class="full">
                    <label>Community Tax Cert Place</label>
                    <textarea name="CommunityTaxCertPlace"><?= htmlspecialchars($row['CommunityTaxCertPlace'] ?? '') ?></textarea>
                </div>
                <div>
                    <label>Article Number</label>
                    <input type="text" name="ArticleNumber" value="<?= htmlspecialchars($row['ArticleNumber'] ?? '') ?>">
                </div>
                <div>
                    <label>Affiant Country</label>
                    <input type="text" name="AffiantCountry" value="<?= htmlspecialchars($row['AffiantCountry'] ?? '') ?>">
                </div>
                <div>
                    <label>Spouse Country</label>
                    <input type="text" name="SpouseCountry" value="<?= htmlspecialchars($row['SpouseCountry'] ?? '') ?>">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Signatures / Repeats</legend>
            <div class="two-col">
                <div>
                    <label>Solemnizing Officer Name (repeat)</label>
                    <input type="text" name="SolemnizingOfficerNameRepeat" value="<?= htmlspecialchars($row['SolemnizingOfficerNameRepeat'] ?? '') ?>">
                </div>
                <div>
                    <label>Solemnizing Officer Title (repeat)</label>
                    <input type="text" name="SolemnizingOfficerTitleRepeat" value="<?= htmlspecialchars($row['SolemnizingOfficerTitleRepeat'] ?? '') ?>">
                </div>
                <div class="full">
                    <label>Solemnizing Officer Address (repeat)</label>
                    <textarea name="SolemnizingOfficerAddressRepeat"><?= htmlspecialchars($row['SolemnizingOfficerAddressRepeat'] ?? '') ?></textarea>
                </div>
            </div>
        </fieldset>

        <div class="buttons">
            <button type="submit" name="update">Save Changes</button>
            <a href="quick-search-marriage.php" style="text-decoration:none; color:#0b63d9; font-weight:700; align-self:center;">Cancel</a>
            <span class="note">ID: <?= htmlspecialchars($id) ?></span>
        </div>
    </form>
</div>
</body>
</html>
