<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
*    Filename: auth.php
*    Project: Tender Management System
*    Description:
*        Central authentication helper for Tender Management System.
*        - Checks if user is logged in
*        - Checks dynamic role-based page access from 'permissions' table
*        - Can be included at the top of any page to protect access
*
*    Version: 1.0.0
*    Author: Tender Management System Team
===========================================
*/

require_once "database.php";
session_start();

/**
 * Check if user is logged in
 */
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../auth/login.php");
        exit;
    }
}

/**
 * Check if the current user has access to a page
 * @param mysqli $conn - database connection
 * @param string $page_name - the current page (e.g., add_tender.php)
 */
function checkPermission($conn, $page_name) {
    checkLogin(); // Make sure user is logged in

    $role_id = $_SESSION['role_id'];

    // Fetch permission from database
    $sql = "SELECT can_access FROM permissions 
            WHERE role_id=$role_id AND page_name='$page_name' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error checking permissions: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['can_access'] == 1) {
            return true; // access granted
        }
    }

    // Access denied
    echo "<h3>Access Denied</h3>";
    echo "<p>You do not have permission to access this page.</p>";
    echo '<a href="../dashboard/dashboard.php">Go to Dashboard</a>';
    exit;
}
