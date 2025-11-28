<?php
session_start();

if (!isset($_SESSION['userrealname'])) {
    header("Location: index.html");
    exit;
}
$servername = "sql105.infinityfree.com";
$username   = "if0_40542314";
$password   = "Sx5Sw60QmFT";
$dbname = "if0_40542314_mbdis_phcris";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the record
$result = $conn->query("SELECT * FROM phbirth WHERE ID=$id");
if ($result->num_rows == 0) die("Record not found.");
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // Dynamically prepare update
    $fields = $conn->query("SHOW COLUMNS FROM phbirth");
    $update_fields = [];
    $params = [];
    $types = '';

    while ($col = $fields->fetch_assoc()) {
        $col_name = $col['Field'];
        if ($col_name === 'ID') continue; // skip primary key
        $update_fields[] = "$col_name = ?";
        $value = isset($_POST[$col_name]) ? $_POST[$col_name] : null;
        $params[] = $value;

        // Determine type
        if (stripos($col['Type'], 'int') !== false) $types .= 'i';
        elseif (stripos($col['Type'], 'decimal') !== false || stripos($col['Type'], 'float') !== false) $types .= 'd';
        else $types .= 's';
    }

    $sql = "UPDATE phbirth SET " . implode(',', $update_fields) . " WHERE ID=?";
    $stmt = $conn->prepare($sql);

    $types .= 'i'; // for ID
    $params[] = $id;

    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $stmt->close();

    header("Location: quick-search-birth.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Birth Record (PHCRIS)</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h2>Edit Birth Record (PHCRIS)</h2>
    <form method="post">
        <div id="accordion">
            <?php
            // Create accordion panels for sections
            $sections = [
                'Child Info' => ['BReN','CFirstName','CMiddleName','CLastName','CSex','CSexId','CBirthDate','CBirthAddress','CBirthBarangay','CBirthBarangayId','CBirthMunicipality','CBirthMunicipalityId','CBirthProvince','CBirthProvinceId','CBirthCountry','CBirthCountryId','CBirthType','CBirthTypeId','CChildWas','CChildWasId','CBirthOrder','CBirthOrderId','CWeight','CBirthTime','CBirthTime'],
                'Mother Info' => ['MFirstName','MMiddleName','MLastName','MCitizenship','MCitizenshipId','MReligion','MReligionId','MBornAlive','MStillLiving','MNowDead','MOccupation','MOccupationId','MOccupationIdCris2','MAge','MAddress','MBarangay','MBarangayId','MMunicipality','MMunicipalityId','MProvince','MProvinceId','MCountry','MCountryId','MEthnicity','MEthnicityId','MEthnicityIdCris2'],
                'Father Info' => ['FFirstName','FMiddleName','FLastName','FCitizenship','FCitizenshipId','FReligion','FReligionId','FOccupation','FOccupationId','FOccupationIdCris2','FAge','FAddress','FBarangay','FBarangayId','FMunicipality','FMunicipalityId','FProvince','FProvinceId','FCountry','FCountryId','FEthnicity','FEthnicityId','FEthnicityIdCris2'],
                'Marriage Info' => ['MarriageDate','MarriageMunicipality','MarriageMunicipalityId','MarriageProvince','MarriageProvinceId','MarriageCountry','MarriageCountryId','Placemar'],
                'Attendant & Informant' => ['AttendantId','AttendantDescription','AttendantStatus','AttendantName','AttendantTitle','AttendantAddress','AttendantDate','InformantName','InformantTitle','InformantAddress','InformantDate','PreparerName','PreparerTitle','PreparerDate','ReceiverName','ReceiverTitle','DateReceived','RegistrarName','RegistrarTitle','DateRegistered'],
                'Remarks & Images' => ['Remark1','Remark2','Remark3','Remark4','Remark5','Remark6','ImageFilePage1','ImageFilePage2','ImageFileAttachment1','ImageFileAttachment2','ImagePage1','ImagePage2','ImageAttachment1','ImageAttachment2'],
                'Document & Codes' => ['DocumentTimeCreated','DocumentTimeUpdated','DocumentTimeTransmitted','DocumentWasPrinted','DocumentStatus','DocumentLocation','DocumentEncodedIn','DocumentEncodedBy','DocumentUpdatedIn','DocumentUpdatedBy','DocumentPsocVersion','DocumentPsgcVersion','DocumentCoding','Country','Province','Municipality','BReN','CStatus']
            ];
            $i=0;
            foreach($sections as $title=>$fields_arr){
                $i++;
                echo '<div class="card">';
                echo '<div class="card-header" id="heading'.$i.'">';
                echo '<h5 class="mb-0">';
                echo '<button class="btn btn-link" data-toggle="collapse" data-target="#collapse'.$i.'" aria-expanded="true" aria-controls="collapse'.$i.'">';
                echo $title;
                echo '</button></h5></div>';
                echo '<div id="collapse'.$i.'" class="collapse'.($i==1?' show':'').'" aria-labelledby="heading'.$i.'" data-parent="#accordion">';
                echo '<div class="card-body">';
                foreach($fields_arr as $field){
                    $value = isset($row[$field]) ? htmlspecialchars($row[$field]) : '';
                    echo '<div class="form-group">';
                    echo '<label>'.$field.'</label>';
                    if (stripos($field,'Date') !== false) {
                        echo '<input type="date" class="form-control" name="'.$field.'" value="'.$value.'">';
                    } elseif (stripos($field,'Time') !== false) {
                        echo '<input type="time" class="form-control" name="'.$field.'" value="'.$value.'">';
                    } elseif (stripos($field,'Id') !== false) {
                        echo '<input type="number" class="form-control" name="'.$field.'" value="'.$value.'">';
                    } elseif (stripos($field,'Text') !== false || stripos($field,'Address') !== false || stripos($field,'Remark') !== false || stripos($field,'Image') !== false) {
                        echo '<textarea class="form-control" name="'.$field.'">'.$value.'</textarea>';
                    } else {
                        echo '<input type="text" class="form-control" name="'.$field.'" value="'.$value.'">';
                    }
                    echo '</div>';
                }
                echo '</div></div></div>';
            }
            ?>
        </div>
        <button type="submit" name="update" class="btn btn-success mt-3">Update Record</button>
        <a href="quick-search-birth.php" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
</body>
</html>
