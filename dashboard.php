<?php
session_start();

if (!isset($_SESSION['userrealname'])) {
    header("Location: index.html");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BASUD MBDIS Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Zen+Dots&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #EFEAE4;      /* white in design */
            --blue: #313D65;    /* brand blue */
            --muted: #837f78;   /* subtle text */
            --card-border: #d9d3cc; /* slightly stronger to show borders */
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg);
            color: #1f2937;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }


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
    background: white;
    color: #333;
    padding: 8px 0;
    border-radius: 8px;
    min-width: 140px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    display: none;
    z-index: 999;
}

.dropdown-item {
    display: block;
    padding: 10px 16px;
    font-size: 14px;
    color: #333;
    text-decoration: none;
}

.dropdown-item:hover {
    background-color: #f3f4f6;
}



        /* Top Nav */
        .topbar {
            background-color: var(--blue);
            color: var(--bg);
            padding: 10px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
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

        /* Page */
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
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .tab {
            background-color: transparent;
            color: #6b7280;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .tab.active {
            background-color: #EFEAE4;
            color: #111827;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        h1.title {
            font-family: 'Zen Dots', cursive;
            color: var(--blue);
            font-size: 32px;
            font-weight: 400;
            letter-spacing: 0.5px;
        }
        .subtitle {
            color: var(--muted);
            font-size: 14px;
            margin-top: 6px;
        }

        .row {
            display: flex;
            gap: 24px;
            align-items: center;
            justify-content: space-between;
            margin-top: 22px;
        }
        .row .spacer { flex: 1; }
        .muted { color: var(--muted); font-size: 12px; }
        .btn {
            background-color: #3b82f6;
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
        }

        /* Cards */
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-top: 22px;
        }
        .card {
            background-color: #EFEAE4; /* surface that pops */
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 18px 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }
        .card h4 { font-size: 13px; color: #4b5563; font-weight: 500; }
        .metric { font-size: 28px; font-weight: 700; margin-top: 8px; color: #0f172a; }
        .trend { font-size: 11px; color: #16a34a; margin-top: 4px; }
        .kicon {
            width: 34px; height: 34px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-left: auto;
        }

        /* Bottom Panels */
        .panels {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 24px;
            margin-top: 22px;
        }
        .panel {
            background-color: #EFEAE4;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 14px 16px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }
        .panel h5 { font-size: 13px; color: #374151; margin-bottom: 8px; }
        .panel .muted { font-size: 12px; }

        /* Footer */
        .footer {
            margin-top: auto;
            background-color: var(--blue);
            color: var(--bg);
            text-align: center;
            padding: 14px 10px;
            font-size: 12px;
        }

        @media (max-width: 1024px) {
            .grid { grid-template-columns: repeat(2, 1fr); }
            .panels { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .menu { display: none; }
            .brand-logo { width: 140px; height: 48px; }
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="brand">
            <div class="brand-logo">
                <img src="system logo.png" alt="BASUD MBDIS">
            </div>
            <div class="menu" role="toolbar" aria-label="Main menu">
                <button>File</button>
                <button>Search</button>
                <button>View</button>
                <button>Tools</button>
                <button>Windows</button>
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
            <div class="tab active">Dashboard</div>
            <a href="detailed-search-birth.php" class="tab">Detailed Search</a>
            <a href="quick-search-birth.php" class="tab">Quick Search</a>
        </div>

        <h1 class="title">Welcome to Basud MBDIS Dashboard</h1>
        <div class="subtitle">Philippine Civil Registry Information System - Modern Edition</div>

        <div class="row">
            <div style="font-weight:600;color:#374151;">Dashboard Statistics</div>
            <div class="spacer"></div>
            <div class="muted">Last updated: 9/26/2025</div>
            <button class="btn" onclick="refreshStats()">⟳ Refresh</button>
        </div>

        <div class="grid">
            <div class="card">
                <div style="display:flex;align-items:center;gap:12px;">
                    <h4>Total Records</h4>
                    <span class="kicon" style="background:#d1fae5;color:#16a34a;">📄</span>
                </div>
                <div class="metric">12,543</div>
                <div class="trend">12% vs last month</div>
            </div>
            <div class="card">
                <div style="display:flex;align-items:center;gap:12px;">
                    <h4>Pending Approvals</h4>
                    <span class="kicon" style="background:#e0e7ff;color:#3730a3;">📝</span>
                </div>
                <div class="metric">38</div>
                <div class="trend" style="color:#16a34a;">5% vs last month</div>
            </div>
            <div class="card">
                <div style="display:flex;align-items:center;gap:12px;">
                    <h4>System Alerts</h4>
                    <span class="kicon" style="background:#fef3c7;color:#b45309;">⚠️</span>
                </div>
                <div class="metric">3</div>
                <div class="trend" style="color:#b45309;">Monitoring</div>
            </div>
            <div class="card">
                <div style="display:flex;align-items:center;gap:12px;">
                    <h4>Active Users</h4>
                    <span class="kicon" style="background:#fde2f3;color:#be185d;">👥</span>
                </div>
                <div class="metric">24</div>
                <div class="trend">12% vs last month</div>
            </div>
        </div>

        <div class="panels">
            <div class="panel">
                <h5>Recent Activities</h5>
                <div class="muted">No recent activities</div>
            </div>
            <div class="panel">
                <h5>Announcements</h5>
                <div class="muted">System maintenance scheduled for next weekend</div>
            </div>
            <div class="panel">
                <h5>Quick Links</h5>
                <div class="muted">Detailed Search · Quick Search</div>
            </div>
        </div>
    </div>

    <div class="footer">© 2025 Basud MBDIS Dashboard. All rights reserved.</div>

    <script>
        function refreshStats() {
            alert('Refreshed');
        }

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

