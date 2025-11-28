<?php

session_start();

if (!isset($_SESSION['userrealname'])) {
    header("Location: index.html");
    exit;
}

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
$results_death = null;
$results_phdeath = null;

if (isset($_POST['search'])) {
    $search = trim($_POST['search']);
    $param = "%$search%";

    // --- Search in 'death' table (legacy) ---
    $stmt1 = $conn1->prepare("
        SELECT ID, FIRST, MI, LAST, SEX, DATEX, LCR_NO, FOLIO_NO, PAGE_NO, DREG
        FROM death
        WHERE FIRST LIKE ? OR LAST LIKE ? OR LCR_NO LIKE ? OR FOLIO_NO LIKE ? OR PAGE_NO LIKE ?
        ORDER BY DATEX DESC
    ");
    $stmt1->bind_param("sssss", $param, $param, $param, $param, $param);
    $stmt1->execute();
    $results_death = $stmt1->get_result();

    // --- Search in 'death' table (PHCRIS) ---
    $stmt2 = $conn2->prepare("
        SELECT ID, CFirstName, CMiddleName, CLastName, CSexId, CDeathDate, RegistryNum, BookNum, PageNum, DateRegistered
        FROM death
        WHERE CFirstName LIKE ? OR CLastName LIKE ? OR RegistryNum LIKE ? OR BookNum LIKE ? OR PageNum LIKE ?
        ORDER BY CDeathDate DESC
    ");
    $stmt2->bind_param("sssss", $param, $param, $param, $param, $param);
    $stmt2->execute();
    $results_phdeath = $stmt2->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quick Search | Basud MBDIS</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Zen+Dots&display=swap" rel="stylesheet">
<style>
:root {
  --bg: #EFEAE4;
  --blue: #313D65;
  --muted: #837f78;
  --card-border: #d9d3cc;
}
body { font-family: 'Inter', sans-serif; background-color: var(--bg); margin: 0; padding: 0; color: #1f2937; display: flex; flex-direction: column; min-height: 100vh; }
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
.topbar { background-color: var(--blue); color: var(--bg); padding: 10px 18px; display: flex; justify-content: space-between; align-items: center; }
.brand { display: flex; align-items: center; gap: 14px; }
.brand-logo { width: 180px; height: 56px; display: flex; align-items: center; justify-content: center; background-color: var(--bg); border: 3px solid var(--blue); padding: 6px 10px; }
.brand-logo img { max-height: 100%; object-fit: contain; }
.menu { margin-left: 24px; background-color: rgba(255,255,255,0.08); border-radius: 6px; display: flex; padding: 6px; gap: 2px; }
.menu button { background: transparent; border: 0; color: var(--bg); font-size: 13px; padding: 8px 16px; border-radius: 6px; cursor: pointer; }
.menu button:hover { background-color: rgba(255,255,255,0.12); }
.right-info { display: flex; align-items: center; gap: 16px; font-size: 12px; }
.icon { width: 28px; height: 28px; border-radius: 50%; background-color: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; color: var(--bg); }
.user-chip { display: flex; align-items: center; gap: 8px; background-color: rgba(255,255,255,0.15); padding: 6px 10px; border-radius: 20px; color: var(--bg); }
.avatar { width: 26px; height: 26px; border-radius: 50%; background-color: var(--bg); color: var(--blue); display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px; }
.container { width: 100%; max-width: 1240px; margin: 24px auto 80px; padding: 0 20px; }
.tabs { display: flex; gap: 0; margin-bottom: 20px; background-color: #e8e3dd; border-radius: 10px; padding: 4px; }
.tab { background-color: transparent; color: #6b7280; padding: 10px 16px; border-radius: 8px; font-size: 14px; text-decoration: none; }
.tab.active { background-color: #EFEAE4; color: #111827; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
.search-box { background-color: #fff; border-radius: 12px; box-shadow: 0 3px 12px rgba(0,0,0,0.08); padding: 20px; margin-bottom: 28px; border: 1px solid var(--card-border); }
.search-box form { display: flex; gap: 12px; align-items: center; justify-content: center; }
.search-box input[type="text"] { width: 60%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; }
.search-box button { background-color: #3b82f6; color: #fff; border: none; padding: 10px 18px; border-radius: 8px; cursor: pointer; }
.search-box button:hover { background-color: #2563eb; }
.section-title { background: #f1f1f1; padding: 8px; font-weight: 600; border-left: 5px solid var(--blue); margin-top: 40px; }
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
th, td { border: 1px solid #d9d3cc; padding: 8px; text-align: center; font-size: 13px; }
th { background-color: var(--blue); color: var(--bg); }
tr:nth-child(even) { background-color: #f7f5f2; }
.no-result { color: #b91c1c; font-weight: 500; margin: 12px 0; text-align: center; }
.footer { margin-top: auto; background-color: var(--blue); color: var(--bg); text-align: center; padding: 14px 10px; font-size: 12px; }
</style>
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
    <a href="detailed-search-birth.php" class="tab">Detailed Search</a>
    <div class="tab active">Quick Search</div>
  </div>
  <div style="display: flex; gap: 20px;">
    <button onclick="location.href='quick-search-birth.php'">Birth</button>  
    <button onclick="location.href='quick-search-marriage.php'">Marriage</button>
    <button style="background:#d1d5db; font-weight:bold;">Death</button>  
  </div>

  <h1 class="title" style="font-family:'Zen Dots'; color:var(--blue); font-size:28px;">Quick Death Record Search</h1>
  <div class="subtitle" style="color:var(--muted); font-size:14px;">Unified Search across Legacy and Philippine CRIS</div>

  <div class="search-box">
    <form method="post">
      <input type="text" name="search" placeholder="Enter name or registry number..." value="<?php echo htmlspecialchars($search); ?>" required>
      <button type="submit">🔍 Search</button>
    </form>
  </div>
  <a href="add_death_phcris.php"><button>Add Death record</button></a>

  <div class="section-title">Legacy CRIS Death Table</div>
  <?php if ($results_death && $results_death->num_rows > 0): ?>
      <table>
          <tr>
              <th>Name</th>
              <th>Sex</th>
              <th>Date of Death</th>
              <th>Registry No.</th>
              <th>Book/Page</th>
              <th>Date Registered</th>
              <th>Actions</th>
          </tr>
          <?php while($row = $results_death->fetch_assoc()): ?>
              <tr>
                  <td><?php echo htmlspecialchars($row['FIRST'].' '.$row['MI'].'. '.$row['LAST']); ?></td>
                  <td><?php echo ($row['SEX'] == 1) ? 'Male' : (($row['SEX'] == 2) ? 'Female' : 'Unknown'); ?></td>
                  <td><?php echo htmlspecialchars($row['DATEX']); ?></td>
                  <td><?php echo htmlspecialchars($row['LCR_NO']); ?></td>
                  <td><?php echo htmlspecialchars($row['FOLIO_NO'].'/'.$row['PAGE_NO']); ?></td>
                  <td><?php echo htmlspecialchars($row['DREG']); ?></td>
                  <td>
                    <!-- EDIT (Legacy CRIS) -->
                    <a href="edit_death_cris.php?id=<?php echo $row['ID']; ?>" 
                      style="padding:6px 10px; background:#2563eb; color:white; border-radius:6px; text-decoration:none; font-size:12px;">
                      Edit (CRIS)
                    </a>

                    <!-- DELETE (Legacy CRIS) -->
                    <a href="delete_death_cris.php?id=<?php echo $row['ID']; ?>"
                      onclick="return confirm('Delete this legacy CRIS death record?');"
                      style="padding:6px 10px; background:#b91c1c; color:white; border-radius:6px; text-decoration:none; font-size:12px; margin-left:6px;">
                      Delete
                    </a>
                  </td>
              </tr>
          <?php endwhile; ?>
      </table>
  <?php else: ?>
      <p class="no-result">No matches found in <strong>Legacy CRIS</strong>.</p>
  <?php endif; ?>

  <div class="section-title">Philippine CRIS Death Table</div>
  <?php if ($results_phdeath && $results_phdeath->num_rows > 0): ?>
      <table>
          <tr>
              <th>Name</th>
              <th>Sex</th>
              <th>Date of Death</th>
              <th>Registry No.</th>
              <th>Book/Page</th>
              <th>Date Registered</th>
              <th>Actions</th>
          </tr>
          <?php while($row = $results_phdeath->fetch_assoc()): ?>
              <tr>
                  <td><?php echo htmlspecialchars($row['CFirstName'].' '.$row['CMiddleName'].' '.$row['CLastName']); ?></td>
                  <td><?php echo ($row['CSexId'] == 1) ? 'Male' : (($row['CSexId'] == 2) ? 'Female' : 'Unknown'); ?></td>
                  <td><?php echo htmlspecialchars($row['CDeathDate']); ?></td>
                  <td><?php echo htmlspecialchars($row['RegistryNum']); ?></td>
                  <td><?php echo htmlspecialchars($row['BookNum'].'/'.$row['PageNum']); ?></td>
                  <td><?php echo htmlspecialchars($row['DateRegistered']); ?></td>
                  <td>
                    <!-- EDIT (PHCRIS) -->
                    <a href="edit_death_phcris.php?id=<?php echo $row['ID']; ?>" 
                      style="padding:6px 10px; background:#059669; color:white; border-radius:6px; text-decoration:none; font-size:12px;">
                      Edit (PH)
                    </a>

                    <!-- DELETE (PHCRIS) -->
                    <a href="delete_death_phcris.php?id=<?php echo $row['ID']; ?>"
                      onclick="return confirm('Delete this PHCRIS birth record?');"
                      style="padding:6px 10px; background:#dc2626; color:white; border-radius:6px; text-decoration:none; font-size:12px; margin-left:6px;">
                      Delete
                    </a>
                </td>
              </tr>
          <?php endwhile; ?>
      </table>
  <?php else: ?>
      <p class="no-result">No matches found in <strong>Philippine CRIS</strong>.</p>
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
});
</script>

</body>
</html>

<?php
$conn1->close();
$conn2->close();
?>
