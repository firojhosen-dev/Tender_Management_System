<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
*    Filename: logout.php
*    Project: Tender Management System
*    Description:
*        Destroys user session securely and logs the user out
*        of the Tender Management System.
*
*    Version: 1.0.0
*    Author: Tender Management System Team
===========================================
*/

session_start();
require_once "../config/database.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $logout_sql = "UPDATE users 
                   SET last_logout = NOW(), 
                   total_duration_minutes = total_duration_minutes + TIMESTAMPDIFF(MINUTE, last_login, NOW()) 
                   WHERE id = '$user_id'";
    
    mysqli_query($conn, $logout_sql);
}

session_destroy();
header("Location: login.php");
exit();
?>
