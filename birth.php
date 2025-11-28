<?php
// Database connections
$servername = "sql105.infinityfree.com";
$username   = "if0_40542314";
$password   = "Sx5Sw60QmFT";

// Connect to MBDIS-CRIS (legacy)
$conn1 = new mysqli($servername, $username, $password, "if0_40542314_mbdis_cris");
if ($conn1->connect_error) {
    die("Connection to mbdis_cris failed: " . $conn1->connect_error);
}

// Connect to MBDIS-PHCRIS (new)
$conn2 = new mysqli($servername, $username, $password, "if0_40542314_mbdis_phcris");
if ($conn2->connect_error) {
    die("Connection to mbdis_phcris failed: " . $conn2->connect_error);
}

$search = "";
$results_birth = null;
$results_phbirth = null;

if (isset($_POST['search'])) {
    $search = trim($_POST['search']);
    $param = "%$search%";

    // --- Search in 'birth' table (mbdis_cris) ---
    $stmt1 = $conn1->prepare("
        SELECT ID, FIRST, MI, LAST, SEX, DATE, PLACE, FOL, PAGE, LCR, MFIRST, MMI, MLAST, FFIRST, FMI, FLAST, DREG
        FROM birth
        WHERE FIRST LIKE ? OR LAST LIKE ? OR LCR LIKE ? OR FOL LIKE ? OR PAGE LIKE ?
        ORDER BY DATE DESC
    ");
    $stmt1->bind_param("sssss", $param, $param, $param, $param, $param);
    $stmt1->execute();
    $results_birth = $stmt1->get_result();

    // --- Search in 'phbirth' table (mbdis_phcris) ---
    $stmt2 = $conn2->prepare("
        SELECT ID, CFirstName, CMiddleName, CLastName, CSex, CBirthDate, CBirthMunicipality, CBirthProvince, RegistryNum,
               MFirstName, MMiddleName, MLastName, FFirstName, FMiddleName, FLastName, DateRegistered
        FROM phbirth
        WHERE CFirstName LIKE ? OR CLastName LIKE ? OR RegistryNum LIKE ? OR BookNum LIKE ? OR PageNum LIKE ?
        ORDER BY CBirthDate DESC
    ");
    $stmt2->bind_param("sssss", $param, $param, $param, $param, $param);
    $stmt2->execute();
    $results_phbirth = $stmt2->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Birth Record Search | MBDIS-CRIS Unified</title>
<style>
/* same CSS as before */
body {
    font-family: Arial, sans-serif;
    background-color: #eef2f7;
    margin: 0;
    padding: 0;
}
.container {
    width: 90%;
    max-width: 1200px;
    background: white;
    margin: 40px auto;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}
h2, h3 {
    text-align: center;
    color: #2b4f75;
}
form {
    text-align: center;
    margin-bottom: 25px;
}
input[type="text"] {
    padding: 10px;
    width: 60%;
    border: 1px solid #aaa;
    border-radius: 5px;
}
button {
    padding: 10px 15px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
}
button:hover {
    background: #0056b3;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}
th {
    background: #007bff;
    color: white;
}
tr:nth-child(even) {
    background: #f9f9f9;
}
.section-title {
    background: #f1f1f1;
    padding: 8px;
    font-weight: bold;
    border-left: 5px solid #007bff;
    margin-top: 40px;
}
.no-result {
    text-align: center;
    color: red;
    font-weight: bold;
}
</style>
</head>
<body>

<div class="container">
    <h2>Unified Birth Record Search</h2>
    <form method="post">
        <input type="text" name="search" placeholder="Enter name or registry number..." value="<?php echo htmlspecialchars($search); ?>" required>
        <button type="submit">Search</button>
    </form>

    <!-- Results from birth table -->
    <div class="section-title">Legacy CRIS Birth Table (birth)</div>
    <?php if ($results_birth && $results_birth->num_rows > 0): ?>
        <table>
            <tr>
                <th>Child’s Full Name</th>
                <th>Sex</th>
                <th>Date of Birth</th>
                <th>Place Code</th>
                <th>Book/Page</th>
                <th>LCR No.</th>
                <th>Mother’s Name</th>
                <th>Father’s Name</th>
                <th>Date Registered</th>
            </tr>
            <?php while($row = $results_birth->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['FIRST'].' '.$row['MI'].'. '.$row['LAST']); ?></td>
                    <td><?php echo ($row['SEX'] == 1) ? 'Male' : (($row['SEX'] == 2) ? 'Female' : 'Unknown'); ?></td>
                    <td><?php echo htmlspecialchars($row['DATE']); ?></td>
                    <td><?php echo htmlspecialchars($row['PLACE']); ?></td>
                    <td><?php echo htmlspecialchars($row['FOL'].'/'.$row['PAGE']); ?></td>
                    <td><?php echo htmlspecialchars($row['LCR']); ?></td>
                    <td><?php echo htmlspecialchars($row['MFIRST'].' '.$row['MMI'].'. '.$row['MLAST']); ?></td>
                    <td><?php echo htmlspecialchars($row['FFIRST'].' '.$row['FMI'].'. '.$row['FLAST']); ?></td>
                    <td><?php echo htmlspecialchars($row['DREG']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p class="no-result">No matches found in <strong>birth</strong> table.</p>
    <?php endif; ?>

    <!-- Results from phbirth table -->
    <div class="section-title">Philippine CRIS Birth Table (phbirth)</div>
    <?php if ($results_phbirth && $results_phbirth->num_rows > 0): ?>
        <table>
            <tr>
                <th>Child’s Full Name</th>
                <th>Sex</th>
                <th>Date of Birth</th>
                <th>Municipality</th>
                <th>Province</th>
                <th>Registry No.</th>
                <th>Mother’s Name</th>
                <th>Father’s Name</th>
                <th>Date Registered</th>
            </tr>
            <?php while($row = $results_phbirth->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['CFirstName'].' '.$row['CMiddleName'].' '.$row['CLastName']); ?></td>
                    <td><?php echo htmlspecialchars($row['CSex']); ?></td>
                    <td><?php echo htmlspecialchars($row['CBirthDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['CBirthMunicipality']); ?></td>
                    <td><?php echo htmlspecialchars($row['CBirthProvince']); ?></td>
                    <td><?php echo htmlspecialchars($row['RegistryNum']); ?></td>
                    <td><?php echo htmlspecialchars($row['MFirstName'].' '.$row['MMiddleName'].' '.$row['MLastName']); ?></td>
                    <td><?php echo htmlspecialchars($row['FFirstName'].' '.$row['FMiddleName'].' '.$row['FLastName']); ?></td>
                    <td><?php echo htmlspecialchars($row['DateRegistered']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p class="no-result">No matches found in <strong>phbirth</strong> table.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php
$conn1->close();
$conn2->close();
?>
