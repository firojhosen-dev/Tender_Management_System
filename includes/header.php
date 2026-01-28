<?php
ob_start();

/**
 * header.php - Tender Management System
 */
require_once "../config/database.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// *Tracking will start if the user is logged in.
if (isset($_SESSION['user_id'])) {
    $current_time = time();
    
    // *Attempt to get role from session (role_name or user_role whichever is available)
    $user_role = $_SESSION['role_name'] ?? ($_SESSION['user_role'] ?? 'Guest'); 
    $today = date('Y-m-d');

    if (isset($_SESSION['last_action_time'])) {
        $time_diff = $current_time - $_SESSION['last_action_time'];
        // If user clicked within the last 5 minutes (considered active)
        // We increment by 1 minute directly for clarity
        if ($time_diff > 0 && $time_diff < 300) { 
            $minutes_to_add = 1; // Add 1 minute per click

            // Database update or insert (correct query)
            $check_log = mysqli_query($conn, "SELECT id FROM activity_logs WHERE role='$user_role' AND created_at='$today'");
            
            if (mysqli_num_rows($check_log) > 0) {
                mysqli_query($conn, "UPDATE activity_logs SET duration_minutes = duration_minutes + $minutes_to_add WHERE role='$user_role' AND created_at='$today'");
            } else {
                mysqli_query($conn, "INSERT INTO activity_logs (role, duration_minutes, created_at) VALUES ('$user_role', '$minutes_to_add', '$today')");
            }
        }
    }
    $_SESSION['last_action_time'] = $current_time;
}


// 1. Security and Session Management
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}

// *1. Retrieve roll and image data from the session
$user_role = $_SESSION['role_name'] ?? 'Guest';
$db_image = $_SESSION['profile_pic'] ?? '';
$upload_dir = "../assets/uploads/profiles/";

// *2. Define default avatars based on roles
$default_avatars = [
    'Admin'          => '../assets/uploads/default/admin.png',
    'Auditor'        => '../assets/uploads/default/auditor.png',
    'Reviewer'       => '../assets/uploads/default/reviewer.png',
    'Tender Creator' => '../assets/uploads/default/creator.png',
    'Vendor'         => '../assets/uploads/default/vendor.png',
    'Guest'          => '../assets/uploads/default.png'
];

// *3. Determine the correct avatar to use
if (!empty($db_image) && file_exists($upload_dir . $db_image)) {
    // *If the user has uploaded the image themselves
    $user_avatar = $upload_dir . $db_image;
} else {
    // *Use default avatar based on role
    $user_avatar = $default_avatars[$user_role] ?? $default_avatars['Guest'];
}


// *2. Set session data based on database
$display_name = $_SESSION['user_name'] ?? 'User';
$display_role = $_SESSION['role_name'] ?? 'No Role';
$user_name    = $_SESSION['username'] ?? 'User'; 
$system_name  = "TMS Dashboard";


// *3. Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) { 
    header("Location: ../login.php"); 
    exit; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $system_name; ?></title>
    <link rel="stylesheet" href="../assets/css/includes.css">
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet"> -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
@import url(https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap);
*{
    font-family: 'Rajdhani', sans-serif;
}
.global_search_button_box{
    padding: 10px 10px;
    background: black;
    color: #fff;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    cursor: pointer;
}
.global_search_button_box a{
    color: #fff;
    text-decoration: none;
}

/* Sidebar Image Icon Styles */
.sidebar-icon {
    width: 40px;          
    height: 40px;
    margin-right: 12px;   
    border-radius: 12px;
    object-fit: contain;
    vertical-align: middle;
    transition: transform 0.3s ease;
}

.menu-link:hover .sidebar-icon {
    transform: scale(1.2);
}

[data-theme="dark"] .sidebar-icon {
    filter: brightness(0) invert(1);
    opacity: 0.9;
}

</style>
</head>
<body>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="tms-sidebar" id="tmsSidebar">
    <div class="sidebar-header">
        <span class="logo-text"><i class="fas fa-gavel"></i> TMS Pro</span>
        <button class="close-btn" id="closeMenu"><i class="fas fa-times"></i></button>
    </div>
    
    <div class="sidebar-menu">
        <a href="../dashboard/dashboard.php" class="menu-link active"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="../companies/add_company.php" class="menu-link">
            <img src="../assets/image/icons/company_add.jpg" class="sidebar-icon" alt="">
            Add Company
        </a>
        <a href="../companies/company_list.php" class="menu-link">
            <img src="../assets/image/icons/company_list_icon.jpg" class="sidebar-icon" alt="">
            Company List</a>
        <a href="../tenders/add_tender.php" class="menu-link">
            <img src="../assets/image/icons/add_tender.jpg" class="sidebar-icon" alt="">
            Add Tender</a>
        <a href="../tenders/tender_management.php" class="menu-link">
            <img src="../assets/image/icons/tender_management.jpg" class="sidebar-icon" alt="">
            Tender Management</a>
        <a href="../companies/company_management.php" class="menu-link">
            <img src="../assets/image/icons/company-management.jpg" class="sidebar-icon" alt="">
            Company Management</a>
        <a href="../tenders/view_all_tender_list.php" class="menu-link">
            <img src="../assets/image/icons/view_all_tender.jpg" class="sidebar-icon" alt="">
            View All Tenders</a>
        <a href="../search/global_search.php" class="menu-link">
            <img src="../assets/image/icons/global_search.jpg" class="sidebar-icon" alt="">
            Global Search</a>
        
        <div class="menu-divider"></div>
        
        <a href="../profile/user_profile_information.php" class="menu-link">
            <img src="../assets/image/icons/my_profile.jpg" class="sidebar-icon" alt="">
            My Profile</a>
        <a href="../auth/register.php" class="menu-link">
            <img src="../assets/image/icons/create_user.jpg" class="sidebar-icon" alt="">
            User Create</a>
        <a href="../users/user_list.php" class="menu-link"> 
            <img src="../assets/image/icons/user_list.jpg" class="sidebar-icon" alt="">
            User List</a>
        <a href="../users/add_user_request_list.php" class="menu-link">
            <img src="../assets/image/icons/user_list.jpg" class="sidebar-icon" alt="">
            User Add Request List</a>
        <a href="../users/user_management.php" class="menu-link">
            <img src="../assets/image/icons/user_management.jpg" class="sidebar-icon" alt="">
            User Manage</a>
        <a href="../users/user_edit.php" class="menu-link">
            <img src="../assets/image/icons/user_edit.jpg" class="sidebar-icon" alt="">
            User Edit</a>
        <a href="../users/blocked_users.php" class="menu-link">
            <img src="../assets/image/icons/block_user.jpg" class="sidebar-icon" alt="">
            Blocked Users</a>
        <a href="../profile/user_profile_settings.php" class="menu-link">
            <img src="../assets/image/icons/profile-settings.jpg" class="sidebar-icon" alt="">
            My Profile Settings</a>
        <a href="../system/system_information.php" class="menu-link">
            <img src="../assets/image/icons/system_Information.jpg" class="sidebar-icon" alt="">
            System Information</a>
        <a href="../system/system_setting.php" class="menu-link">
            <img src="../assets/image/icons/system_settings.jpg" class="sidebar-icon" alt="">
            System Settings</a>
        <a href="../system/process_ticket.php" class="menu-link">
            <img src="../assets/image/icons/Process_Ticket.jpg" class="sidebar-icon" alt="">
            Process Ticket</a>

        <a href="logout.php" class="menu-link logout-link">
            <img src="../assets/image/icons/logout.jpg" class="sidebar-icon" alt="">
            Logout</a>
    </div>
</aside>
    
<nav class="tms-navbar">
    <div class="nav-left">
        <button class="menu-toggle-btn" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <a href="../dashboard/dashboard.php" class="system-logo">
            <img src="../assets/image/logo.png" alt="System Logo" style="height: 70px; width: 70px; border-radius: 50%; object-fit: cover;">
            <!-- <?php echo htmlspecialchars($system_name); ?> -->
        </a>
    </div>

    <div class="nav-right">
        <div class="nav-search">
            <div class="global_search_button">
                <button class="global_search_button_box"><a href="../search/global_search.php">Go to Global Search</a></button>
            </div>
        </div>

        <button class="theme-toggle" id="themeToggle">
            <i class="fas fa-moon"></i>
        </button>

        <div class="nav-icon-btn">
            <i class="far fa-bell"></i>
            <span class="badge">0</span>
        </div>

        <div class="user-dropdown" id="userDropdown">
            <div class="user-trigger" id="userMenu">
                <img src="<?php echo $user_avatar; ?>" alt="User Avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                <!-- <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($display_name); ?>&background=random" alt="User"> -->
                <div class="user-info">
                    <span class="user-name"><?php echo htmlspecialchars($display_name); ?></span>
                    <span class="user-role"><?php echo htmlspecialchars($display_role); ?></span>
                </div>
            </div>
            
            <ul class="dropdown-content" id="dropdownContent">
                <li><a href="../profile/user_profile_information.php"><i class="far fa-user"></i> My Profile</a></li>
                <li><a href="../auth/change_password.php"><i class="fas fa-key"></i> Password</a></li>
                <li class="divider"></li>
                <li><a href="../auth/logout.php" class="text-danger"><i class="fas fa-sign-out-alt"></i> Sign Out</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="content-spacer"></div>
<script src="../assets/js/includes.js"></script>
</body>
</html>