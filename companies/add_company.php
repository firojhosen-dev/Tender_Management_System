<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
*    Filename: add_company.php
*    Project: Tender Management System
*    Description:
*        This file allows the user to add a new tender company
*        into the system. Duplicate company names are prevented.
*
*    Version: 1.0.1
*    Author: Tender Management System Team
===========================================
*/

require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin']); // Only Admin can access

$message = "";
$message_type = "success"; // success | error

if (isset($_POST['add_company'])) {

    $company_name = trim($_POST['company_name']);
    $description  = trim($_POST['description']);

    if ($company_name === "") {
        $message = "Company Name cannot be left blank.";
        $message_type = "error";
    } else {

        /* 🔍 Step 1: Check duplicate company name */
        $check_sql = "SELECT id FROM tender_companies WHERE company_name = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $company_name);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) > 0) {

            $message = "A company with this name has already been added. You cannot add it, please choose a different name.";
            $message_type = "error";

        } else {

            /* ✅ Step 2: Insert company */
            $insert_sql = "INSERT INTO tender_companies (company_name, description)
                           VALUES (?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($insert_stmt, "ss", $company_name, $description);

            if (mysqli_stmt_execute($insert_stmt)) {
                $message = "Company successfully added ✔";
                $message_type = "success";
            } else {

                // Extra safety for UNIQUE constraint
                if (mysqli_errno($conn) == 1062) {
                    $message = "A company with this name already exists. Please use a different name.";
                } else {
                    $message = "Something went wrong. Please try again.";
                }
                $message_type = "error";
            }
        }
    }
}
?>
<link rel="stylesheet" href="../assets/css/companies.css">
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">
<div class="main_container_company_add">
    <h3>Add New Tender Company</h3>

    <?php if ($message): ?>
        <div class="message-<?= $message_type ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <label>Company Name</label>
        <input type="text" name="company_name" required placeholder="Enter company name">

        <label>Company Description</label>
        <textarea name="description" rows="4" placeholder="Enter description"></textarea>

        <button type="submit" name="add_company">Add Company</button>
    </form>

    <a href="company_list.php" class="back-link">← Back to Company List</a>
</div>

<!-- <script src="../assets/js/companies.js"></script> -->
</body>
</html>
