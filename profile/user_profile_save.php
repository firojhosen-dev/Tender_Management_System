<?php
/*
===========================================
? Tender Management System Information Start
===========================================
* Filename: user_profile_save.php
* Project: Tender Management System
* Description:
*   Handles saving user profile updates including
*   personal info, account settings, security, 
*   preferences, and profile picture upload.
*
* Version: 1.0.0
* Author: Tender Management System Team
* Created Date: 2026-01-18
* License: Proprietary (Internal Use Only)
===========================================
*/

require_once "../config/database.php";
require_once "../includes/access.php";

// Only logged-in users can access
if(!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Sanitize POST input
function clean($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

// Collect form data
$full_name = clean($_POST['full_name'] ?? '');
$email = clean($_POST['email'] ?? '');
$mobile = clean($_POST['mobile'] ?? '');
$office_phone = clean($_POST['office_phone'] ?? '');
$address = clean($_POST['address'] ?? '');
$country_city_zip = clean($_POST['country_city_zip'] ?? '');
$gender = clean($_POST['gender'] ?? '');
$dob = clean($_POST['dob'] ?? '');
$department = clean($_POST['department'] ?? '');
$designation = clean($_POST['designation'] ?? '');
$supervisor = clean($_POST['supervisor'] ?? '');
$company_name = clean($_POST['company_name'] ?? '');
$company_id = clean($_POST['company_id'] ?? '');
$preferred_language = clean($_POST['preferred_language'] ?? 'English');
$timezone = clean($_POST['timezone'] ?? 'Asia/Dhaka');
$theme_preference = clean($_POST['theme_preference'] ?? 'Light');
$notification_preferences = clean($_POST['notification_preferences'] ?? 'Email, SMS');
$security_questions = clean($_POST['security_questions'] ?? '');

// =========================
// Handle Password Change
// =========================
$new_password = $_POST['new_password'] ?? '';
$password_sql = '';
if(!empty($new_password)) {
    // Hash the password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $password_sql = ", password='$hashed_password'";
}

// =========================
// Handle Profile Picture Upload
// =========================
$profile_picture_sql = '';
if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['name'] != '') {
    $file = $_FILES['profile_picture'];
    $filename = time() . '_' . basename($file['name']);
    $target_dir = "../uploads/avatars/";
    $target_file = $target_dir . $filename;

    // Allowed file types
    $allowed = ['jpg','jpeg','png','gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if(in_array($ext, $allowed)) {
        if(move_uploaded_file($file['tmp_name'], $target_file)) {
            $profile_picture_sql = ", profile_picture='$filename'";
        } else {
            $_SESSION['error'] = "Profile picture upload failed!";
        }
    } else {
        $_SESSION['error'] = "Invalid profile picture type!";
    }
}

// =========================
// Update user in DB
// =========================
$sql = "UPDATE users SET
    full_name='$full_name',
    email='$email',
    mobile='$mobile',
    office_phone='$office_phone',
    address='$address',
    country_city_zip='$country_city_zip',
    gender='$gender',
    dob='$dob',
    department='$department',
    designation='$designation',
    supervisor='$supervisor',
    company_name='$company_name',
    company_id='$company_id',
    preferred_language='$preferred_language',
    timezone='$timezone',
    theme_preference='$theme_preference',
    notification_preferences='$notification_preferences',
    security_questions='$security_questions'
    $password_sql
    $profile_picture_sql
WHERE id=$user_id";

if(mysqli_query($conn, $sql)) {
    $_SESSION['success'] = "Profile updated successfully!";
} else {
    $_SESSION['error'] = "Error updating profile: " . mysqli_error($conn);
}

// Redirect back to profile page
header("Location: user_profile_settings.php");
exit;
