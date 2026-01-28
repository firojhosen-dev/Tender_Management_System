<?php
/*
===========================================
? Tender Management System Information Start
===========================================
* Filename: user_profile_information.php
* Project: Tender Management System
* Description:
*   Displays user profile information in a read-only format.
*   Shows personal info, account & security details,
*   and preferences / activity summary.
* Version: 1.0.0
* Author: Tender Management System Team
* Created Date: 2026-01-18
* License: Proprietary (Internal Use Only)
===========================================
*/

require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

// Only logged-in users can access
if(!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($user_query);

// Defaults
// Fetch user data
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($user_query);

// 1. Get role and profile pic from session
$user_role = $_SESSION['role_name'] ?? 'Guest';
$db_image = $_SESSION['profile_pic'] ?? '';
$upload_dir = "../assets/uploads/profiles/";

// 2. role dependent default avatars
$default_avatars = [
    'Admin'          => '../assets/uploads/default/admin.png',
    'Auditor'        => '../assets/uploads/default/auditor.png',
    'Reviewer'       => '../assets/uploads/default/reviewer.png',
    'Tender Creator' => '../assets/uploads/default/creator.png',
    'Vendor'         => '../assets/uploads/default/vendor.png',
    'Guest'          => '../assets/uploads/default.png' // default for others
];

// 3. Finally, check if user has a custom image; otherwise use default
if (!empty($db_image) && file_exists($upload_dir . $db_image)) {
    $user_avatar = $upload_dir . $db_image;
} else {
    $user_avatar = $default_avatars[$user_role] ?? $default_avatars['Guest'];
}

// --- Logic End ---
$gender = $user['gender'] ?? '';
$dob = $user['dob'] ?? '';
$department = $user['department'] ?? '';
$designation = $user['designation'] ?? '';
$company_name = $user['company_name'] ?? '';
$role_name = $user['role_name'] ?? '';
$account_status = $user['account_status'] ?? 'Active';
$preferred_language = $user['preferred_language'] ?? 'English';
$timezone = $user['timezone'] ?? 'Asia/Dhaka';
$theme_preference = $user['theme_preference'] ?? 'Light';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Information</title>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

<!-- <link rel="stylesheet" href="../assets/css/profile.css"> -->
<style>
@import url(https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap);
*{
    font-family: 'Rajdhani', sans-serif;
}
    :root {
        --bg-color: #f0f2f5;
        --card-bg: #ffffff;
        --primary-blue: #007bff;
        --text-dark: #333;
        --text-muted: #666;
        --border-color: #eee;
    }

    body {
        background-color: var(--bg-color);
        font-family: 'Rajdhani', sans-serif;
        color: var(--text-dark);
    }

    h1{
        text-align: center;
        margin-bottom: 30px;
    }
    .profile-layout {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .avatar-card {
        background: var(--card-bg);
        padding: 25px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        height: fit-content;
    }

    .avatar-card img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--primary-blue);
        margin-bottom: 15px;
    }

    .social-icons {
        margin-top: 15px;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .social-icons a {
        color: var(--text-muted);
        font-size: 20px;
        transition: 0.3s;
    }

    .social-icons a:hover {
        color: var(--primary-blue);
        transform: translateY(-3px);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 20px;
    }

    .card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        border-top: 4px solid var(--primary-blue);
    }
    .card h3 {
        margin-top: 0;
        font-size: 1.2rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #f9f9f9;
    }

    .info-row strong {
        color: var(--text-muted);
        font-weight: 600;
    }

    .info-row span {
        text-align: right;
        color: var(--text-dark);
    }
    .bio-text {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.5;
        margin: 15px 0;
        font-style: italic;
    }
    /* Responsive */
    @media (max-width: 992px) {
        .profile-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
        .info-row {
            flex-direction: column;
            text-align: left;
        }
        .info-row span {
            text-align: left;
            margin-top: 5px;
        }
    }
</style>
</head>
<body>
<div class="container" style="max-width: 1200px; margin: 20px auto; padding: 0 15px;">
<h1>User Profile Information</h1>

<div class="profile-layout">
    
<div class="avatar-card">
    <img src="<?= $user_avatar ?>" alt="Avatar">
    <h2><?= htmlspecialchars($user['full_name'] ?? 'User Name') ?></h2>
    <p style="color: var(--primary-blue); font-weight: 600;"><?= htmlspecialchars($role_name) ?></p>
    
    <p class="bio-text">
        <?= htmlspecialchars($user['bio'] ?? 'No professional summary added yet.') ?>
    </p>
    
    <div class="social-icons">
        <a href="<?= $user['fb_url'] ?? '#' ?>" style="color: #1877F2;"><i class="fab fa-facebook"></i></a>
        <a href="<?= $user['ln_url'] ?? '#' ?>" style="color: #0A66C2;"><i class="fab fa-linkedin"></i></a>
        <a href="<?= $user['tw_url'] ?? '#' ?>" style="color: #1DA1F2;"><i class="fab fa-twitter"></i></a>
        <a href="<?= $user['gh_url'] ?? '#' ?>" style="color: #1DA1F2;"><i class="fab fa-github"></i></a>
        <a href="mailto:<?= $user['email'] ?>" style="color: #EA4335;"><i class="fas fa-envelope"></i></a>
    </div>

    <div style="margin-top: 25px;">
        <a href="user_profile_settings.php" class="global_search_button_box" style="display: block; padding: 12px; margin-bottom: 10px;">Edit Profile</a>
        <a href="../auth/change_password.php" class="global_search_button_box" style="display: block; padding: 12px; margin-bottom: 10px;"><i class="fas fa-key"></i> Change Password</a>
        <a href="../auth/logout.php" class="global_search_button_box" style="display: block; padding: 12px; margin-bottom: 10px;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

    <div class="info-grid">
        
        <div class="card">
            <h3><i class="fas fa-id-card"></i> Basic Information</h3>
            <div class="info-row"><strong>Full Name:</strong> <span><?= htmlspecialchars($user['full_name'] ?? '') ?></span></div>
            <div class="info-row"><strong>Username:</strong> <span><?= htmlspecialchars($user['username'] ?? '') ?></span></div>
            <div class="info-row"><strong>Gender:</strong> <span><?= htmlspecialchars($gender) ?></span></div>
            <div class="info-row"><strong>DOB:</strong> <span><?= htmlspecialchars($dob) ?></span></div>
            <div class="info-row"><strong>Employee ID:</strong> <span><?= htmlspecialchars($user['employee_id'] ?? '') ?></span></div>
        </div>

        <div class="card">
            <h3><i class="fas fa-envelope-open-text"></i> Contact Information</h3>
            <div class="info-row"><strong>Email:</strong> <span><?= htmlspecialchars($user['email'] ?? '') ?></span></div>
            <div class="info-row"><strong>Mobile:</strong> <span><?= htmlspecialchars($user['mobile'] ?? '') ?></span></div>
            <div class="info-row"><strong>Office:</strong> <span><?= htmlspecialchars($user['office_phone'] ?? '') ?></span></div>
            <div class="info-row"><strong>Address:</strong> <span><?= htmlspecialchars($user['address'] ?? '') ?></span></div>
            <div class="info-row"><strong>ZIP/City:</strong> <span><?= htmlspecialchars($user['country_city_zip'] ?? '') ?></span></div>
        </div>

        <div class="card">
            <h3><i class="fas fa-building"></i> Organization Info</h3>
            <div class="info-row"><strong>Department:</strong> <span><?= htmlspecialchars($user['department'] ?? '') ?></span></div>
            <div class="info-row"><strong>Designation:</strong> <span><?= htmlspecialchars($user['designation'] ?? '') ?></span></div>
            <div class="info-row"><strong>Supervisor:</strong> <span><?= htmlspecialchars($user['supervisor'] ?? '') ?></span></div>
            <div class="info-row"><strong>Company Name:</strong> <span><?= htmlspecialchars($user['company_name'] ?? '') ?></span></div>
            <div class="info-row"><strong>Reg Number:</strong> <span><?= htmlspecialchars($user['company_id'] ?? '') ?></span></div>
        </div>

        <div class="card">
            <h3><i class="fas fa-user-shield"></i> Account & Security</h3>
            <div class="info-row"><strong>Role:</strong> <span><?= htmlspecialchars($role_name) ?></span></div>
            <div class="info-row"><strong>Status:</strong> <span style="color: green; font-weight: bold;"><?= htmlspecialchars($account_status) ?></span></div>
            <div class="info-row"><strong>Last Login:</strong> <span><?= htmlspecialchars($user['last_login'] ?? 'Never') ?></span></div>
            <div class="info-row"><strong>Reg Date:</strong> <span><?= htmlspecialchars($user['created_at'] ?? '') ?></span></div>
            <div class="info-row"><strong>2FA Status:</strong> <span><?= htmlspecialchars($user['2fa_status'] ?? 'Disabled') ?></span></div>
            <div class="info-row"><strong>Security Questions:</strong> <span><?= nl2br(htmlspecialchars($user['security_questions'] ?? 'None')) ?></span></div>
        </div>

        <div class="card">
    <h3><i class="fas fa-tools"></i> Professional Expertise</h3>
    <div class="info-row"><strong>Years of Exp:</strong> <?= htmlspecialchars($user['years_of_exp'] ?? '') ?></div>
    <div class="info-row"><strong>Core Skills:</strong> <span><?= htmlspecialchars($user['core_skills'] ?? 'Tendering, Audit, Management') ?></span></div>
    <div class="info-row"><strong>Signature Status:</strong> <span style="color: green;">Digital Signature Active</span></div>
</div>

<div class="card">
    <h3><i class="fas fa-phone-square-alt"></i> Emergency Contact</h3>
    <div class="info-row"><strong>Person:</strong> <?= htmlspecialchars($user['emergency_contact_name'] ?? '') ?></div>
    <div class="info-row"><strong>Emergency Phone:</strong> <span><?= htmlspecialchars($user['emergency_contact_phone'] ?? '+880 17XX-XXXXXX') ?></span></div>
    <div class="info-row"><strong>Blood Group:</strong> <span style="color: red; font-weight: bold;"><?= htmlspecialchars($user['blood_group'] ?? '') ?></span></div>
</div>

<div class="card">
    <h3><i class="fas fa-chart-line"></i> Performance Stats</h3>
    <div class="info-row"><strong>Tender Success Rate:</strong> <span>78%</span></div>
    <div class="info-row"><strong>Avg. Response Time:</strong> <span>2.5 Hours</span></div>
    <div class="info-row"><strong>System Rating:</strong> <span>⭐⭐⭐⭐ (4.5/5)</span></div>
</div>

        <div class="card">
            <h3><i class="fas fa-cog"></i> Activity & Preferences</h3>
            <div class="info-row"><strong>Total Tenders:</strong> <span><?= htmlspecialchars($user['total_tenders'] ?? '0') ?></span></div>
            <div class="info-row"><strong>Pending Approvals:</strong> <span><?= htmlspecialchars($user['pending_approvals'] ?? '0') ?></span></div>
            <div class="info-row"><strong>Completed Tenders:</strong> <span><?= htmlspecialchars($user['completed_tenders'] ?? '0') ?></span></div>
            <div class="info-row"><strong>Notifications Summary:</strong> <span><?= nl2br(htmlspecialchars($user['notifications_summary'] ?? 'None')) ?></span></div>
            <div class="info-row"><strong>Language:</strong> <span><?= htmlspecialchars($preferred_language) ?></span></div>
            <div class="info-row"><strong>Time Zone:</strong> <span><?= htmlspecialchars($timezone) ?></span></div>
            <div class="info-row"><strong>Theme:</strong> <span><?= htmlspecialchars($theme_preference) ?></span></div>
            <div class="info-row"><strong>Notifications:</strong> <span><?= htmlspecialchars($user['notification_preferences'] ?? 'Email') ?></span></div>
        </div>

    </div>
</div>

</div> <!-- container -->
<!-- <script src="../assets/js/profile.js"></script> -->
</body>
</html>
