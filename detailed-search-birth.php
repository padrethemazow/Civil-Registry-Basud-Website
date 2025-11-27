<?php
session_start();

if (!isset($_SESSION['userrealname'])) {
    header("Location: index.html");
    exit;
}

// Database connections
$servername = "localhost";
$username = "root";
$password = "";

// Connect to MBDIS-CRIS (legacy)
$conn1 = new mysqli($servername, $username, $password, "mbdis_cris");
if ($conn1->connect_error) {
    die("Connection to mbdis_cris failed: " . $conn1->connect_error);
}

// Connect to MBDIS-PHCRIS (new)
$conn2 = new mysqli($servername, $username, $password, "mbdis_phcris");
if ($conn2->connect_error) {
    die("Connection to mbdis_phcris failed: " . $conn2->connect_error);
}

// Read inputs (GET so fields persist in URL)
$book    = trim($_GET['book']    ?? '');
$page    = trim($_GET['page']    ?? '');
$reg     = trim($_GET['reg']     ?? '');
$cf      = trim($_GET['cf']      ?? ''); // child first
$cm      = trim($_GET['cm']      ?? ''); // child middle
$cl      = trim($_GET['cl']      ?? ''); // child last
$mf      = trim($_GET['mf']      ?? ''); // mother first
$mm      = trim($_GET['mm']      ?? ''); // mother middle (optional)
$ml      = trim($_GET['ml']      ?? ''); // mother last
$ff      = trim($_GET['ff']      ?? ''); // father first
$fmi     = trim($_GET['fmi']     ?? ''); // father middle (optional)
$fl      = trim($_GET['fl']      ?? ''); // father last

$ranSearch = false; // whether to run queries
$notice = '';

// helper to check if at least one input has content
if (
    $book !== '' || $page !== '' || $reg !== '' ||
    $cf !== '' || $cm !== '' || $cl !== '' ||
    $mf !== '' || $mm !== '' || $ml !== '' ||
    $ff !== '' || $fmi !== '' || $fl !== ''
) {
    $ranSearch = true;
} else {
    $notice = "Please enter at least one search field to run the search.";
}

// Prepare results containers
$results_phbirth = null;
$results_birth   = null;

if ($ranSearch) {
    //
    // PHCRIS (mbdis_phcris.phbirth)
    //
    $conds = [];
    $types = '';
    $vals  = [];

    // mapping: BookNum, PageNum, RegistryNum, CFirstName, CMiddleName, CLastName,
    // MFirstName, MMiddleName, MLastName, FFirstName, FMiddleName, FLastName
    if ($book !== '') { $conds[] = "BookNum LIKE ?";        $types .= 's'; $vals[] = "%$book%"; }
    if ($page !== '') { $conds[] = "PageNum LIKE ?";        $types .= 's'; $vals[] = "%$page%"; }
    if ($reg !== '')  { $conds[] = "RegistryNum LIKE ?";    $types .= 's'; $vals[] = "%$reg%"; }

    if ($cf !== '')   { $conds[] = "CFirstName LIKE ?";     $types .= 's'; $vals[] = "%$cf%"; }
    if ($cm !== '')   { $conds[] = "CMiddleName LIKE ?";    $types .= 's'; $vals[] = "%$cm%"; }
    if ($cl !== '')   { $conds[] = "CLastName LIKE ?";      $types .= 's'; $vals[] = "%$cl%"; }

    if ($mf !== '')   { $conds[] = "MFirstName LIKE ?";     $types .= 's'; $vals[] = "%$mf%"; }
    if ($mm !== '')   { $conds[] = "MMiddleName LIKE ?";    $types .= 's'; $vals[] = "%$mm%"; }
    if ($ml !== '')   { $conds[] = "MLastName LIKE ?";      $types .= 's'; $vals[] = "%$ml%"; }

    if ($ff !== '')   { $conds[] = "FFirstName LIKE ?";     $types .= 's'; $vals[] = "%$ff%"; }
    if ($fmi !== '')  { $conds[] = "FMiddleName LIKE ?";    $types .= 's'; $vals[] = "%$fmi%"; }
    if ($fl !== '')   { $conds[] = "FLastName LIKE ?";      $types .= 's'; $vals[] = "%$fl%"; }

    $where_sql = '';
    if (count($conds) > 0) {
        $where_sql = 'WHERE ' . implode(' AND ', $conds);
    }

    // Limit results to prevent huge responses
    $sql_ph = "
        SELECT ID, BookNum, PageNum, RegistryNum,
               CFirstName, CMiddleName, CLastName,
               CSex, CBirthDate, CBirthMunicipality, CBirthProvince, DateRegistered,
               MFirstName, MMiddleName, MLastName,
               FFirstName, FMiddleName, FLastName
        FROM phbirth
        $where_sql
        ORDER BY CBirthDate DESC
        LIMIT 1000
    ";

    $stmt_ph = $conn2->prepare($sql_ph);
    if ($stmt_ph === false) {
        die("phbirth prepare failed: " . $conn2->error);
    }

    if (count($vals) > 0) {
        // bind params dynamically
        $bind_names[] = $types;
        for ($i = 0; $i < count($vals); $i++) {
            $bind_names[] = &$vals[$i];
        }
        call_user_func_array([$stmt_ph, 'bind_param'], $bind_names);
    }

    $stmt_ph->execute();
    $results_phbirth = $stmt_ph->get_result();

    //
    // LEGACY birth (mbdis_cris.birth)
    //
    $conds2 = [];
    $types2 = '';
    $vals2  = [];

    // mapping: FOL, PAGE, LCR, FIRST, MI, LAST, MFIRST, MMI, MLAST, FFIRST, FMI, FLAST
    if ($book !== '') { $conds2[] = "FOL LIKE ?";     $types2 .= 's'; $vals2[] = "%$book%"; }
    if ($page !== '') { $conds2[] = "PAGE LIKE ?";    $types2 .= 's'; $vals2[] = "%$page%"; }
    if ($reg !== '')  { $conds2[] = "LCR LIKE ?";     $types2 .= 's'; $vals2[] = "%$reg%"; }

    if ($cf !== '')   { $conds2[] = "FIRST LIKE ?";   $types2 .= 's'; $vals2[] = "%$cf%"; }
    if ($cm !== '')   { $conds2[] = "MI LIKE ?";      $types2 .= 's'; $vals2[] = "%$cm%"; }
    if ($cl !== '')   { $conds2[] = "LAST LIKE ?";    $types2 .= 's'; $vals2[] = "%$cl%"; }

    if ($mf !== '')   { $conds2[] = "MFIRST LIKE ?";  $types2 .= 's'; $vals2[] = "%$mf%"; }
    if ($mm !== '')   { $conds2[] = "MMI LIKE ?";     $types2 .= 's'; $vals2[] = "%$mm%"; }
    if ($ml !== '')   { $conds2[] = "MLAST LIKE ?";   $types2 .= 's'; $vals2[] = "%$ml%"; }

    if ($ff !== '')   { $conds2[] = "FFIRST LIKE ?";  $types2 .= 's'; $vals2[] = "%$ff%"; }
    if ($fmi !== '')  { $conds2[] = "FMI LIKE ?";     $types2 .= 's'; $vals2[] = "%$fmi%"; }
    if ($fl !== '')   { $conds2[] = "FLAST LIKE ?";   $types2 .= 's'; $vals2[] = "%$fl%"; }

    $where_sql2 = '';
    if (count($conds2) > 0) {
        $where_sql2 = 'WHERE ' . implode(' AND ', $conds2);
    }

    $sql_birth = "
        SELECT ID, FOL, PAGE, LCR, FIRST, MI, LAST, MFIRST, MMI, MLAST, FFIRST, FMI, FLAST, DATE, PLACE, DREG, SEX
        FROM birth
        $where_sql2
        ORDER BY DATE DESC
        LIMIT 1000
    ";

    $stmt_birth = $conn1->prepare($sql_birth);
    if ($stmt_birth === false) {
        die("birth prepare failed: " . $conn1->error);
    }

    if (count($vals2) > 0) {
        $bind_names2[] = $types2;
        for ($i = 0; $i < count($vals2); $i++) {
            $bind_names2[] = &$vals2[$i];
        }
        call_user_func_array([$stmt_birth, 'bind_param'], $bind_names2);
    }

    $stmt_birth->execute();
    $results_birth = $stmt_birth->get_result();
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Detailed Search | Basud MBDIS</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Zen+Dots&display=swap" rel="stylesheet">
<style>
/* === GLOBAL THEME (same as new dashboard) === */
:root {
  --bg: #EFEAE4;
  --blue: #313D65;
  --muted: #837f78;
  --card-border: #d9d3cc;
}
body {
  font-family: 'Inter', sans-serif;
  background-color: var(--bg);
  margin: 0;
  padding: 0;
  color: #1f2937;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

/* === DROPDOWN USER MENU === */
.user-dropdown {
position: relative;
}

.user-chip {
cursor: pointer;
}

.dropdown-menu {
position: absolute;
right: 0;
top: 40px;
background: #ffffff;
color: #333;
border-radius: 10px;
min-width: 150px;
padding: 8px 0;
border: 1px solid #d9d3cc;
box-shadow: 0 4px 12px rgba(0,0,0,0.15);
display: none;
z-index: 1000;
}

.dropdown-item {
display: block;
padding: 10px 16px;
font-size: 14px;
text-decoration: none;
color: #333;
}

.dropdown-item:hover {
background-color: #f3f4f6;
}

/* === TOP NAV === */
.topbar {
background-color: var(--blue);
color: var(--bg);
padding: 10px 18px;
display: flex;
justify-content: space-between;
align-items: center;
}
.brand {
display: flex;
align-items: center;
gap: 14px;
}
.brand-logo {
width: 180px;
height: 56px;
display: flex;
align-items: center;
justify-content: center;
background-color: var(--bg);
border: 3px solid var(--blue);
padding: 6px 10px;
}
.brand-logo img {
max-height: 100%;
object-fit: contain;
}
.menu {
margin-left: 24px;
background-color: rgba(255,255,255,0.08);
border-radius: 6px;
display: flex;
padding: 6px;
gap: 2px;
}
.menu button {
background: transparent;
border: 0;
color: var(--bg);
font-size: 13px;
padding: 8px 16px;
border-radius: 6px;
cursor: pointer;
}
.menu button:hover {
background-color: rgba(255,255,255,0.12);
}
.right-info {
display: flex;
align-items: center;
gap: 16px;
font-size: 12px;
}
.icon {
width: 28px;
height: 28px;
border-radius: 50%;
background-color: rgba(255,255,255,0.15);
display: flex;
align-items: center;
justify-content: center;
color: var(--bg);
}
.user-chip {
display: flex;
align-items: center;
gap: 8px;
background-color: rgba(255,255,255,0.15);
padding: 6px 10px;
border-radius: 20px;
color: var(--bg);
}
.avatar {
width: 26px;
height: 26px;
border-radius: 50%;
background-color: var(--bg);
color: var(--blue);
display: inline-flex;
align-items: center;
justify-content: center;
font-weight: 700;
font-size: 12px;
}

/* === CONTENT === */
.container {
width: 100%;
max-width: 1240px;
margin: 24px auto 80px;
padding: 0 20px;
}
.tabs {
display: flex;
gap: 0;
margin-bottom: 20px;
background-color: #e8e3dd;
border-radius: 10px;
padding: 4px;
}
.tab {
background-color: transparent;
color: #6b7280;
padding: 10px 16px;
border-radius: 8px;
font-size: 14px;
text-decoration: none;
}
.tab.active {
background-color: #EFEAE4;
color: #111827;
box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

/* === SEARCH BOX === */
.search-box {
background-color: #fff;
border-radius: 12px;
box-shadow: 0 3px 12px rgba(0,0,0,0.08);
padding: 20px;
margin-bottom: 28px;
border: 1px solid var(--card-border);
}
.form-grid {
display: grid;
grid-template-columns: repeat(2, 1fr);
gap: 12px;
}
.form-grid label { display:block; font-size:13px; color:var(--muted); margin-bottom:4px; }
.form-grid input[type="text"] {
width: 100%;
padding: 10px;
border-radius: 8px;
border: 1px solid #ccc;
box-sizing: border-box;
}
.search-actions { display:flex; gap:10px; align-items:center; margin-top:12px; }
.search-actions button { padding:10px 16px; border-radius:8px; border:0; cursor:pointer; }
.search-actions .primary { background:#3b82f6; color:#fff; }
.search-actions .secondary { background:#e5e7eb; color:#111; }

/* === TABLES === */
.section-title {
background: #f1f1f1;
padding: 8px;
font-weight: 600;
border-left: 5px solid var(--blue);
margin-top: 40px;
}
table {
width: 100%;
border-collapse: collapse;
margin-top: 10px;
}
th, td {
border: 1px solid #d9d3cc;
padding: 8px;
text-align: center;
font-size: 13px;
}
th {
background-color: var(--blue);
color: var(--bg);
}
tr:nth-child(even) {
background-color: #f7f5f2;
}
.no-result {
color: #b91c1c;
font-weight: 500;
margin: 12px 0;
text-align: center;
}

/* small responsive */
@media (max-width: 900px) {
.form-grid { grid-template-columns: 1fr; }
}
.footer {
margin-top: auto;
background-color: var(--blue);
color: var(--bg);
text-align: center;
padding: 14px 10px;
font-size: 12px;
} </style>

</head>
<body>
<div class="topbar">
  <div class="brand">
    <div class="brand-logo">
      <img src="system logo.png" alt="BASUD MBDIS">
    </div>
    <div class="menu">
      <button onclick="location.href='dashboard.php'">Dashboard</button>
      <button>Search</button>
      <button>View</button>
      <button>Tools</button>
      <button>Help</button>
    </div>
  </div>
  <div class="right-info">
      <span>User: <?= htmlspecialchars($_SESSION['userrealname']); ?></span>
      <span class="icon">⚙️</span>
      <div class="user-dropdown">
          <div class="user-chip" onclick="toggleUserMenu()">
              <span class="avatar">
                  <?= strtoupper(substr($_SESSION['userrealname'], 0, 2)); ?>
              </span>
              <?= htmlspecialchars($_SESSION['userrealname']); ?> ▾
          </div>

      <div class="dropdown-menu" id="userMenu">
          <a href="logout.php" class="dropdown-item">Logout</a>
      </div>
  </div>

  </div>
</div>

<div class="container">
  <div class="tabs">
    <a href="dashboard.php" class="tab">Dashboard</a>
    <div class="tab active">Detailed Search</div>
    <a href="quick-search-birth.php" class="tab">Quick Search</a>

  </div>
  <div style="display: flex; gap: 20px;">
    <button onclick="location.href='detailed-search-birth.php'" style="background:#d1d5db; font-weight:bold;">Birth</button>
    <button onclick="location.href='detailed-search-marriage.php'">Marriage</button>
    <button onclick="location.href='detailed-search-death.php'">Death</button>
  </div>

  <h1 class="title" style="font-family:'Zen Dots'; color:var(--blue); font-size:28px;">Detailed Birth Record Search</h1>
  <div class="subtitle" style="color:var(--muted); font-size:14px;">Search across Legacy and Philippine CRIS</div>

  <div class="search-box">
    <form method="GET">
      <div class="form-grid">
        <div>
          <label>Book No.</label>
          <input type="text" name="book" value="<?= htmlspecialchars($book) ?>">
        </div>
        <div>
          <label>Page No.</label>
          <input type="text" name="page" value="<?= htmlspecialchars($page) ?>">
        </div>

```
    <div>
      <label>Registry No.</label>
      <input type="text" name="reg" value="<?= htmlspecialchars($reg) ?>">
    </div>
    <div>
      <label>Child's First Name</label>
      <input type="text" name="cf" value="<?= htmlspecialchars($cf) ?>">
    </div>

    <div>
      <label>Child's Middle Name</label>
      <input type="text" name="cm" value="<?= htmlspecialchars($cm) ?>">
    </div>
    <div>
      <label>Child's Last Name</label>
      <input type="text" name="cl" value="<?= htmlspecialchars($cl) ?>">
    </div>

    <div>
      <label>Mother's First Name</label>
      <input type="text" name="mf" value="<?= htmlspecialchars($mf) ?>">
    </div>
    <div>
      <label>Mother's Middle Name</label>
      <input type="text" name="mm" value="<?= htmlspecialchars($mm) ?>">
    </div>

    <div>
      <label>Mother's Last Name</label>
      <input type="text" name="ml" value="<?= htmlspecialchars($ml) ?>">
    </div>
    <div>
      <label>Father's First Name</label>
      <input type="text" name="ff" value="<?= htmlspecialchars($ff) ?>">
    </div>

    <div>
      <label>Father's Middle Name</label>
      <input type="text" name="fmi" value="<?= htmlspecialchars($fmi) ?>">
    </div>
    <div>
      <label>Father's Last Name</label>
      <input type="text" name="fl" value="<?= htmlspecialchars($fl) ?>">
    </div>
  </div>

  <div class="search-actions">
    <button type="submit" class="primary">🔍 Search</button>
    <a href="detailed-search-birth.php"><button type="button" class="secondary">Reset</button></a>
  </div>
  <?php if ($notice !== ''): ?>
    <p class="no-result"><?= htmlspecialchars($notice) ?></p>
  <?php endif; ?>
</form>
```

  </div>

<a href="add_birth_phcris.php"><button style="margin-top:10px;">Add Birth record</button></a>

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
              <th>Actions</th>
          </tr>
          <?php while($row = $results_birth->fetch_assoc()): ?>
              <tr>
                  <td><?php echo htmlspecialchars($row['FIRST'].' '.($row['MI'] ? $row['MI'].'. ' : '').$row['LAST']); ?></td>
                  <td><?php echo ($row['SEX'] == 1) ? 'Male' : (($row['SEX'] == 2) ? 'Female' : 'Unknown'); ?></td>
                  <td><?php echo htmlspecialchars($row['DATE']); ?></td>
                  <td><?php echo htmlspecialchars($row['PLACE']); ?></td>
                  <td><?php echo htmlspecialchars($row['FOL'].'/'.$row['PAGE']); ?></td>
                  <td><?php echo htmlspecialchars($row['LCR']); ?></td>
                  <td><?php echo htmlspecialchars($row['MFIRST'].' '.($row['MMI'] ? $row['MMI'].'. ' : '').$row['MLAST']); ?></td>
                  <td><?php echo htmlspecialchars($row['FFIRST'].' '.($row['FMI'] ? $row['FMI'].'. ' : '').$row['FLAST']); ?></td>
                  <td><?php echo htmlspecialchars($row['DREG']); ?></td>
                  <td>
                    <!-- EDIT (Legacy CRIS) -->
                    <a href="edit_birth_cris.php?id=<?php echo $row['ID']; ?>" 
                      style="padding:6px 10px; background:#2563eb; color:white; border-radius:6px; text-decoration:none; font-size:12px;">
                      Edit (CRIS)
                    </a>

```
                <!-- DELETE (Legacy CRIS) -->
                <a href="delete_birth_cris.php?id=<?php echo $row['ID']; ?>"
                  onclick="return confirm('Delete this legacy CRIS birth record?');"
                  style="padding:6px 10px; background:#b91c1c; color:white; border-radius:6px; text-decoration:none; font-size:12px; margin-left:6px;">
                  Delete
                </a>
              </td>
          </tr>
      <?php endwhile; ?>
  </table>
```

  <?php else: ?>

```
  <p class="no-result">No matches found in <strong>birth</strong> table.</p>
```

  <?php endif; ?>

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
              <th>Actions</th>
          </tr>
          <?php while($row = $results_phbirth->fetch_assoc()): ?>
              <tr>
                  <td><?php echo htmlspecialchars($row['CFirstName'].' '.($row['CMiddleName'] ? $row['CMiddleName'].' ' : '').$row['CLastName']); ?></td>
                  <td><?php echo htmlspecialchars($row['CSex']); ?></td>
                  <td><?php echo htmlspecialchars($row['CBirthDate']); ?></td>
                  <td><?php echo htmlspecialchars($row['CBirthMunicipality']); ?></td>
                  <td><?php echo htmlspecialchars($row['CBirthProvince']); ?></td>
                  <td><?php echo htmlspecialchars($row['RegistryNum']); ?></td>
                  <td><?php echo htmlspecialchars($row['MFirstName'].' '.($row['MMiddleName'] ? $row['MMiddleName'].' ' : '').$row['MLastName']); ?></td>
                  <td><?php echo htmlspecialchars($row['FFirstName'].' '.($row['FMiddleName'] ? $row['FMiddleName'].' ' : '').$row['FLastName']); ?></td>
                  <td><?php echo htmlspecialchars($row['DateRegistered']); ?></td>
                  <td>
                    <!-- EDIT (PHCRIS) -->
                    <a href="edit_birth_phcris.php?id=<?php echo $row['ID']; ?>" 
                      style="padding:6px 10px; background:#059669; color:white; border-radius:6px; text-decoration:none; font-size:12px;">
                      Edit (PH)
                    </a>

```
                <!-- DELETE (PHCRIS) -->
                <a href="delete_birth_phcris.php?id=<?php echo $row['ID']; ?>"
                  onclick="return confirm('Delete this PHCRIS birth record?');"
                  style="padding:6px 10px; background:#dc2626; color:white; border-radius:6px; text-decoration:none; font-size:12px; margin-left:6px;">
                  Delete
                </a>
            </td>

          </tr>
      <?php endwhile; ?>
  </table>
```

  <?php else: ?>

```
  <p class="no-result">No matches found in <strong>phbirth</strong> table.</p>
```

  <?php endif; ?>

</div>

<div class="footer">© 2025 Basud MBDIS Dashboard. All rights reserved.</div>
<script>
function toggleUserMenu() {
    const menu = document.getElementById("userMenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

window.addEventListener("click", function(e) {
const menu = document.getElementById("userMenu");
if (!e.target.closest(".user-dropdown")) {
menu.style.display = "none";
}
}); </script>

</body>
</html>

<?php
// close db connections
$conn1->close();
$conn2->close();
?>
