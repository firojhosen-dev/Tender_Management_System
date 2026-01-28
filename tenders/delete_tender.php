<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
*    Filename: delete_tender.php
*    Project: Tender Management System
*    Description:
*        This file handles deletion of a tender.
*        It deletes the tender record based on the provided tender ID
*        and redirects back to the tender management page.
*
*    Version: 1.0.0
*    Author: Tender Management System Team
===========================================
*/

require_once "../includes/header.php";
require_once "../config/database.php";

if (!isset($_GET['id'])) {
    header("Location: tender_management.php");
    exit;
}

$tender_id = intval($_GET['id']);

mysqli_query($conn, "DELETE FROM tenders WHERE id=$tender_id");

header("Location: tender_management.php");
exit;
