<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
*    Filename: edit_company.php
*    Project: Tender Management System
*    Description:
*        This file allows editing an existing tender company's
*        details (company name and description). The company
*        record is fetched from the database using its ID.
*        After updating, changes are saved to the database.
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
$message = "";

/* Fetch company data */
$result = mysqli_query($conn, "SELECT * FROM tender_companies WHERE id=$id LIMIT 1");
if (mysqli_num_rows($result) == 0) {
    echo "<p>Company not found.</p>";
    exit;
}

$company = mysqli_fetch_assoc($result);

/* Handle update */
if (isset($_POST['update_company'])) {
    $company_name = trim($_POST['company_name']);
    $description = trim($_POST['description']);

    if ($company_name == "") {
        $message = "Company Name is required.";
    } else {
        $sql = "UPDATE tender_companies 
                SET company_name='$company_name', description='$description'
                WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            $message = "Company updated successfully ✔";
            // Refresh data
            $company = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tender_companies WHERE id=$id"));
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

    <link rel="stylesheet" href="../assets/css/companies.css">
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">


<div class="main_container_company_edit">
    <div class="header-row">
        <h3>Edit Company</h3>
    </div>

    <?php if ($message != "") { echo "<p style='color:var(--you_access_icon); background:rgba(76,175,80,0.1); padding:10px; border-radius:8px;'>$message</p>"; } ?>

    <form method="post">
        <label>Company Name:</label>
        <input type="text" name="company_name" value="<?php echo htmlspecialchars($company['company_name']); ?>" required>

        <label>Company Description:</label>
        <textarea name="description" rows="4"><?php echo htmlspecialchars($company['description']); ?></textarea>

        <button type="submit" name="update_company">Update Company</button>
    </form>

    <a href="company_list.php" class="back-link">← Back to Company List</a>
</div>

<!-- <script src="../assets/js/companies.js"></script> -->
</body>
</html>