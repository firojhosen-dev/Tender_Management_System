<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
*    Filename: database.php
*    Project: Tender Management System
*    Description:
*        This file is responsible for establishing and managing
*        the primary MySQL database connection for the entire
*        Tender Management System. All backend modules such as
*        user authentication, company management, tender creation,
*        tender listing, searching, and reporting depend on this
*        centralized database connection file.
*
*        It ensures:
*        - Secure and consistent database connectivity
*        - UTF-8 character encoding support
*        - Graceful failure handling on connection errors
*
*    Version: 1.0.0
*    Author: Tender Management System Team
?    Developer Contact:
*        - Name: Firoj Hosen
*        - Email: firojdeveloper@gmail.com
*        - Website: https://firojhosen.com
*        - Linkedin: https://www.linkedin.com/in/firojhossendev
*        - Twitter X: https://x.com/firojhossendev
*        - Facebook: https://www.facebook.com/firojhossendev
*        - Github: https://github.com/firojhosen-dev
*
*    Created Date and Time: 2026-01-18 00:00:00
*    Last Updated: 2026-01-18 00:00:00
*    License: Proprietary (Internal Use Only by Tender Management System).
*             See LICENSE.md for full terms.
*    Copyright:
*        (c) 2026 Tender Management System
*
*    DB Engine: MySQL
*    Backend Engine: PHP (mysqli – procedural)
*    Frontend: N/A (Backend Configuration File)
*    Charset: UTF-8
*    Dependencies:
*        - PHP 7.4+
*        - MySQL 5.7+ / MariaDB
*
*    Contact: support@tms.com (for support and inquiries)
===========================================
?    Tender Management System Information End
===========================================
*/

/* ================================
   DATABASE CONFIGURATION
   ================================ */

$db_host = "localhost";
$db_user = "root";      // Change according to server configuration
$db_pass = "";          // Change according to server configuration
$db_name = "tender_management_system";

/* ================================
   CREATE DATABASE CONNECTION
   ================================ */

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

/* ================================
   CONNECTION ERROR HANDLING
   ================================ */

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

/* ================================
   SET CHARACTER ENCODING
   ================================ */

mysqli_set_charset($conn, "utf8");

/* ================================
   DATABASE CONNECTION READY
   ================================ */
?>
