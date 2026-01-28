<?php
/*
===========================================
? Tender Management System Information Start
===========================================
* Filename: system_settings_save.php
* Project: Tender Management System
* Description:
*   Handles saving of all system settings.
*   Updates or inserts settings into system_settings table
*   with proper security and Admin-only access.
*
* Version: 1.0.0
* Author: Tender Management System Team
* Created Date: 2026-01-18
* License: Proprietary (Internal Use Only)
===========================================
*/

require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin']); // Only Admin

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: system_settings.php");
    exit;
}

/* Loop through all POST values */
foreach ($_POST as $key => $value) {

    // Skip submit buttons
    if ($key === 'submit') continue;

    $setting_key = mysqli_real_escape_string($conn, $key);
    $setting_value = mysqli_real_escape_string($conn, trim($value));

    // Check if setting exists
    $check = mysqli_query(
        $conn,
        "SELECT id FROM system_settings WHERE setting_key = '$setting_key' LIMIT 1"
    );

    if (mysqli_num_rows($check) > 0) {
        // Update
        mysqli_query(
            $conn,
            "UPDATE system_settings 
             SET setting_value = '$setting_value' 
             WHERE setting_key = '$setting_key'"
        );
    } else {
        // Insert
        mysqli_query(
            $conn,
            "INSERT INTO system_settings (setting_key, setting_value, setting_group)
             VALUES ('$setting_key', '$setting_value', 'general')"
        );
    }
}

/* Redirect back with success */
header("Location: system_settings.php?success=1");
exit;
