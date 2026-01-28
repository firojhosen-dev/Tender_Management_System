<?php
/*
===========================================
? System Settings Controller
===========================================
*/

require_once "../includes/header.php";
require_once "../includes/access.php";
require_once "../config/database.php";

checkRole(['Admin']); 

$message = "";

// 1. Settings Update Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_settings'])) {
    foreach ($_POST['settings'] as $key => $value) {
        $key = mysqli_real_escape_string($conn, $key);
        $value = mysqli_real_escape_string($conn, $value);
        
        // Check if this setting key already exists
        $check = mysqli_query($conn, "SELECT setting_id FROM system_settings WHERE setting_key = '$key'");
        
        if (mysqli_num_rows($check) > 0) {
            mysqli_query($conn, "UPDATE system_settings SET setting_value = '$value' WHERE setting_key = '$key'");
        } else {
            mysqli_query($conn, "INSERT INTO system_settings (setting_key, setting_value) VALUES ('$key', '$value')");
        }
    }
    $message = "Settings updated successfully!";
}

// 2. Fetch current settings
$settings = [];
$res = mysqli_query($conn, "SELECT setting_key, setting_value FROM system_settings");
while ($row = mysqli_fetch_assoc($res)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

function getVal($key, $default = '') {
    global $settings;
    return htmlspecialchars($settings[$key] ?? $default);
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit System Settings</title>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

    <style>
        :root {
            --bg-color: #f1f5f9;
            --card-bg: rgba(255, 255, 255, 0.8);
            --text-color: #1e293b;
            --primary: #2563eb;
            --border: rgba(0,0,0,0.1);
        }

        [data-theme="dark"] {
            --bg-color: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.8);
            --text-color: #f8fafc;
            --primary: #3b82f6;
            --border: rgba(255,255,255,0.1);
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', sans-serif;
            margin: 0; padding: 20px;
            transition: 0.3s;
        }

        .container { max-width: 900px; margin: 0 auto; }

        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        
        .form-section { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
        @media (max-width: 600px) { .form-section { grid-template-columns: 1fr; } }

        .form-group { display: flex; flex-direction: column; }
        label { font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--primary); }
        
        input, textarea {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: rgba(255,255,255,0.05);
            color: var(--text-color);
            font-size: 1rem;
        }

        .btn-save {
            background: var(--primary);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            font-size: 1rem;
            margin-top: 20px;
        }

        .alert {
            padding: 15px;
            background: #22c55e;
            color: white;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .theme-toggle {
            cursor: pointer;
            background: none; border: 1px solid var(--primary);
            color: var(--primary); padding: 5px 15px; border-radius: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>⚙️ System Settings</h2>
        <button class="theme-toggle" onclick="toggleTheme()">Toggle Theme</button>
    </div>

    <?php if($message): ?>
        <div class="alert"><?= $message ?></div>
    <?php endif; ?>

    <form action="" method="POST" class="glass-card">
        
        <h3 style="border-bottom: 1px solid var(--border); padding-bottom: 10px;">1. General Information</h3>
        <div class="form-section">
            <div class="form-group">
                <label>System Name</label>
                <input type="text" name="settings[system_name]" value="<?= getVal('system_name', 'Tender Management System') ?>" required>
            </div>
            <div class="form-group">
                <label>Version</label>
                <input type="text" name="settings[system_version]" value="<?= getVal('system_version', 'v1.0.0') ?>">
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label>System Description</label>
                <textarea name="settings[system_description]" rows="2"><?= getVal('system_description') ?></textarea>
            </div>
        </div>

        <h3 style="border-bottom: 1px solid var(--border); padding-bottom: 10px; margin-top: 30px;">2. Developer & Contact</h3>
        <div class="form-section">
            <div class="form-group">
                <label>Developer/Lead Name</label>
                <input type="text" name="settings[dev_name]" value="<?= getVal('dev_name', 'Firoj Hosen') ?>">
            </div>
            <div class="form-group">
                <label>Support Email</label>
                <input type="email" name="settings[dev_email]" value="<?= getVal('dev_email', 'firojdeveloper@gmail.com') ?>">
            </div>
            <div class="form-group">
                <label>Website URL</label>
                <input type="text" name="settings[dev_website]" value="<?= getVal('dev_website', 'https://firojhosen.com') ?>">
            </div>
            <div class="form-group">
                <label>Organization Address</label>
                <input type="text" name="settings[org_address]" value="<?= getVal('org_address', 'Dhaka, Bangladesh') ?>">
            </div>
        </div>

        <h3 style="border-bottom: 1px solid var(--border); padding-bottom: 10px; margin-top: 30px;">3. Security & Database Policy</h3>
        <div class="form-section">
            <div class="form-group">
                <label>Backup Policy</label>
                <input type="text" name="settings[backup_policy]" value="<?= getVal('backup_policy', 'Daily / Weekly') ?>">
            </div>
            <div class="form-group">
                <label>License Type</label>
                <input type="text" name="settings[license_type]" value="<?= getVal('license_type', 'Proprietary') ?>">
            </div>
        </div>

        <button type="submit" name="save_settings" class="btn-save">💾 Save All Settings</button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <a href="system_information.php" style="color: var(--primary); text-decoration: none;">← Back to System Info</a>
    </div>
</div>

<script>
    function toggleTheme() {
        const doc = document.documentElement;
        const current = doc.getAttribute('data-theme');
        const next = current === 'light' ? 'dark' : 'light';
        doc.setAttribute('data-theme', next);
        localStorage.setItem('theme', next);
    }

    // Load saved theme
    document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'light');
</script>

</body>
</html>