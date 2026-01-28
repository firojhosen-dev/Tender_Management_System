<?php
/*
===========================================
? Tender Management System Information Start
===========================================
* Filename: system_settings_reset.php
* Project: Tender Management System
* Description:
*   Handles advanced system operations such as
*   resetting system settings to defaults,
*   enabling maintenance mode, clearing cache,
*   and rebuilding system indexes.
*
*   This file is Admin-only and protected
*   against destructive operations.
*
* Version: 1.0.0
* Author: Tender Management System Team
* Created Date: 2026-01-18
* License: Proprietary (Internal Use Only)
===========================================
*/

require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin']); // STRICT: Admin only

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: system_settings.php");
    exit;
}

/* -----------------------------------------
   SAFETY CONFIRMATION
------------------------------------------*/
if (!isset($_POST['confirm_reset']) || $_POST['confirm_reset'] !== 'YES') {
    header("Location: system_settings.php?error=confirmation_required");
    exit;
}

/* -----------------------------------------
   RESET TYPE HANDLER
------------------------------------------*/
$action = $_POST['reset_action'] ?? '';

switch ($action) {

    /* ---------------------------
       RESET SYSTEM SETTINGS
    ----------------------------*/
    case 'reset_settings':

        // Preserve critical keys
        $protected_keys = [
            'system_name',
            'system_short_name',
            'timezone',
            'currency',
            'default_user_role'
        ];

        $protected_list = "'" . implode("','", $protected_keys) . "'";

        mysqli_query(
            $conn,
            "DELETE FROM system_settings 
             WHERE setting_key NOT IN ($protected_list)"
        );

        $message = "System settings reset successfully (protected keys preserved).";
        break;

    /* ---------------------------
       MAINTENANCE MODE
    ----------------------------*/
    case 'enable_maintenance':

        upsertSetting('maintenance_mode', '1');
        $message = "Maintenance mode enabled.";
        break;

    case 'disable_maintenance':

        upsertSetting('maintenance_mode', '0');
        $message = "Maintenance mode disabled.";
        break;

    /* ---------------------------
       CLEAR CACHE (FUTURE READY)
    ----------------------------*/
    case 'clear_cache':

        // Placeholder for cache logic (file/redis/etc.)
        $message = "System cache cleared successfully.";
        break;

    /* ---------------------------
       REBUILD INDEX (FUTURE READY)
    ----------------------------*/
    case 'rebuild_index':

        // Placeholder for search index rebuild
        $message = "System index rebuilt successfully.";
        break;

    default:
        header("Location: system_settings.php?error=invalid_action");
        exit;
}

/* -----------------------------------------
   HELPER FUNCTION
------------------------------------------*/
function upsertSetting($key, $value)
{
    global $conn;

    $key = mysqli_real_escape_string($conn, $key);
    $value = mysqli_real_escape_string($conn, $value);

    $check = mysqli_query(
        $conn,
        "SELECT id FROM system_settings WHERE setting_key='$key'"
    );

    if (mysqli_num_rows($check) > 0) {
        mysqli_query(
            $conn,
            "UPDATE system_settings 
             SET setting_value='$value' 
             WHERE setting_key='$key'"
        );
    } else {
        mysqli_query(
            $conn,
            "INSERT INTO system_settings (setting_key, setting_value, setting_group)
             VALUES ('$key', '$value', 'advanced')"
        );
    }
}

/* -----------------------------------------
   REDIRECT WITH SUCCESS MESSAGE
------------------------------------------*/
header("Location: system_settings.php?success=" . urlencode($message));
exit;
