<?php
/*
===========================================
? Tender Management System Information 
===========================================
*/

require_once "../includes/header.php";
require_once "../includes/access.php";
require_once "../config/database.php";

checkRole(['Admin', 'Auditor']); 

// Fetch settings
$settings = [];
$result = mysqli_query($conn, "SELECT setting_key, setting_value FROM system_settings");
while ($row = mysqli_fetch_assoc($result)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

function setting($key, $default = '') {
    global $settings;
    return htmlspecialchars($settings[$key] ?? $default);
}

// DB & System Info
$db_name = "tender_management_system"; 
$table_count = mysqli_num_rows(mysqli_query($conn, "SHOW TABLES"));
$system_version = "v1.0.0";
$developer_name = "Firoj Hosen / TMS Team";
$developer_email = "firojdeveloper@gmail.com";
$developer_website = "https://firojhosen.com";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Info | TMS</title>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

    <style>
        :root {
                /* Default Light Theme */
    --app-bg: var(--accent-light);
    --surface: var(--white);
    --sidebar-bg: var(--primary-dark);
    --text-main: var(--secondary-dark);
    --text-muted: #6c757d;
    --border-color: var(--gray-light);
    --glass-bg: rgba(255, 255, 255, 0.8);
    --shadow: 0 10px 25px rgba(0,0,0,0.05);
}

[data-theme="dark"] {
    --app-bg: var(--bg-dark);
    --surface: #1a1147;
    --sidebar-bg: #0a0624;
    --text-main: var(--white);
    --text-muted: var(--gray-light);
    --border-color: rgba(255, 255, 255, 0.1);
    --glass-bg: rgba(22, 12, 64, 0.85);
    --shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .header-section h2 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #0f172a;
        }

        /* Grid System */
        .system-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        /* Card Design */
        .info-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow);
            transition: transform 0.2s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--bg-color);
            color: var(--primary-color);
            display: flex;
            align-items: center;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list li {
            padding: 8px 0;
            font-size: 0.95rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: 600;
            color: var(--text-muted);
            margin-right: 10px;
        }

        .value {
            text-align: right;
            word-break: break-word;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .badge {
            background: #dcfce7;
            color: #166534;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
        }

        /* Print Button */
        .btn-print {
            background: var(--primary-dark);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 20px;
        }

        @media (max-width: 600px) {
            .system-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-section">
        <h2>🖥️ System Information</h2>
        <p>Comprehensive overview for administrators and auditors.</p>
    </div>

    <div class="system-grid">
        
        <div class="info-card">
            <div class="card-title">1. System Overview</div>
            <ul class="info-list">
                <li><span class="label">Name:</span> <span class="value"><?= setting('system_name') ?></span></li>
                <li><span class="label">Users:</span> <span class="value">Admin, Vendor, Auditor</span></li>
                <li><span class="label">Benefit:</span> <span class="value">Transparency & Security</span></li>
            </ul>
        </div>

        <div class="info-card">
            <div class="card-title">2. Developer Info</div>
            <ul class="info-list">
                <li><span class="label">Lead:</span> <span class="value"><?= $developer_name ?></span></li>
                <li><span class="label">Email:</span> <span class="value"><?= $developer_email ?></span></li>
                <li><span class="label">Website:</span> <span class="value"><a href="<?= $developer_website ?>"><?= $developer_website ?></a></span></li>
            </ul>
        </div>

        <div class="info-card">
            <div class="card-title">3. Version Info</div>
            <ul class="info-list">
                <li><span class="label">Version:</span> <span class="value badge"><?= $system_version ?></span></li>
                <li><span class="label">Status:</span> <span class="value">Stable</span></li>
                <li><span class="label">Updated:</span> <span class="value">2026-01-18</span></li>
            </ul>
        </div>

        <div class="info-card">
            <div class="card-title">4. Tech Stack</div>
            <ul class="info-list">
                <li><span class="label">Backend:</span> <span class="value">PHP</span></li>
                <li><span class="label">DB:</span> <span class="value">MySQL</span></li>
                <li><span class="label">Frontend:</span> <span class="value">HTML, CSS, JS</span></li>
            </ul>
        </div>

        <div class="info-card">
            <div class="card-title">5. Requirements</div>
            <ul class="info-list">
                <li><span class="label">PHP:</span> <span class="value"><?= phpversion() ?></span></li>
                <li><span class="label">RAM:</span> <span class="value"><?= ini_get('memory_limit') ?></span></li>
                <li><span class="label">Disk:</span> <span class="value">Available</span></li>
            </ul>
        </div>

        <div class="info-card">
            <div class="card-title">6. User Roles</div>
            <ul class="info-list">
                <li><span class="label">Roles:</span> <span class="value">Admin, Creator, Vendor, Auditor</span></li>
                <li><span class="label">Access:</span> <span class="value">RBAC Enabled</span></li>
            </ul>
        </div>

        <div class="info-card">
            <div class="card-title">7. Core Modules</div>
            <ul class="info-list">
                <li><span class="label">Mgmt:</span> <span class="value">Tender, Vendor, User</span></li>
                <li><span class="label">Tools:</span> <span class="value">Audit Log, Analytics</span></li>
            </ul>
        </div>

        <div class="info-card" style="border-top: 3px solid #ef4444;">
            <div class="card-title">8. Security</div>
            <ul class="info-list">
                <li><span class="label">Encryption:</span> <span class="value">Password Hashing</span></li>
                <li><span class="label">Protection:</span> <span class="value">CSRF & XSS</span></li>
            </ul>
        </div>

        <div class="info-card">
            <div class="card-title">9. Database</div>
            <ul class="info-list">
                <li><span class="label">DB Name:</span> <span class="value"><?= $db_name ?></span></li>
                <li><span class="label">Tables:</span> <span class="value"><?= $table_count ?></span></li>
            </ul>
        </div>

        <div class="info-card">
            <div class="card-title">10. License</div>
            <ul class="info-list">
                <li><span class="label">Type:</span> <span class="value">Proprietary</span></li>
                <li><span class="label">Copyright:</span> <span class="value">© <?= date('Y') ?> TMS</span></li>
            </ul>
        </div>

        <div class="info-card">
            <div class="card-title">11. Installation</div>
            <ul class="info-list">
                <li><span class="label">Status:</span> <span class="value">Installed</span></li>
                <li><span class="label">Mode:</span> <span class="value">Production</span></li>
            </ul>
        </div>

        <div class="info-card">
            <div class="card-title">12. Support</div>
            <ul class="info-list">
                <li><span class="label">Email:</span> <span class="value"><?= $developer_email ?></span></li>
                <li><span class="label">Docs:</span> <span class="value">Included</span></li>
            </ul>
        </div>

        <div class="info-card full-width" style="background: #1e293b; color: white;">
            <div class="card-title" style="color: #60a5fa;">13. System Metadata</div>
            <div style="display: flex; justify-content: space-around; flex-wrap: wrap; text-align: center;">
                <div><p style="margin:5px">Architecture</p><strong>Monolithic</strong></div>
                <div><p style="margin:5px">Build</p><strong><?= $system_version ?></strong></div>
                <div><p style="margin:5px">Server Software</p><strong><?= $_SERVER['SERVER_SOFTWARE'] ?></strong></div>
            </div>
        </div>

    </div>

    <div style="text-align: center; margin-top: 30px;">
        <button class="btn-print" onclick="window.print()">Print Information</button>
        <a href="system_setting.php"><button class="btn-print">System Settings</button></a>

    </div>
</div>
<!-- <?php require_once "../includes/footer.php"; ?> -->
<script>
    // Simple JS to log system access
    console.log("System Information Module Loaded - v1.0.0");
    
    // Add interactivity: highlight card on click
    document.querySelectorAll('.info-card').forEach(card => {
        card.addEventListener('click', () => {
            console.log("Viewing: " + card.querySelector('.card-title').innerText);
        });
    });
</script>

</body>
</html>