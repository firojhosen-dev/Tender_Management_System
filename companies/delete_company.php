<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
*    Filename: delete_company.php
*    Project: Tender Management System
*    Description:
*        This file handles deletion of a tender company.
*        It deletes the company record from the database based
*        on the provided company ID. After deletion, it redirects
*        back to the company list.
*
*    Version: 1.0.0
*    Author: Tender Management System Team
===========================================
*/

require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin']); // Only Admin can access

if (!isset($_GET['id'])) {
    header("Location: company_list.php");
    exit;
}

$id = intval($_GET['id']);

/* Delete company record */
mysqli_query($conn, "DELETE FROM tender_companies WHERE id=$id");

/* Redirect back */
header("Location: company_list.php");
exit;
