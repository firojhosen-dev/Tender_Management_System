<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
*    Filename: company_list.php
*    Project: Tender Management System
*    Description:
*        This file displays all tender companies in a card-based layout.
*        Each card shows the company name, description, and action buttons:
*        View Tender List, Edit, Delete.
*        Supports deletion and links to the tender list page for that company.
*
*    Version: 1.0.0
*    Author: Tender Management System Team
===========================================
*/

require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin']); // Only Admin can access
/* Handle Delete */
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM tender_companies WHERE id=$id");
    header("Location: company_list.php");
    exit;
}

/* Fetch all companies */
$companies = mysqli_query($conn, "SELECT * FROM tender_companies ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company List</title>
    <link rel="stylesheet" href="../assets/css/companies.css">
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

</head>
<body>
<div class="main_container_company_add_and_list"> 
    <div class="header-row" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div class="left-actions">
            <h3 style="margin-bottom: 10px;">Tender Companies</h3>
            <a href="add_company.php" class="btn-action">+ Add New Company</a>
        </div>
        
        <div class="search-container">
            <input type="text" id="companySearch" placeholder="Search companies..." 
                   style="padding: 10px; width: 350px; border-radius: 5px; border: 1px solid #ccc;">
        </div>
    </div>

    <div class="company-grid" id="companyGrid">
    <?php while ($row = mysqli_fetch_assoc($companies)) { ?>
        <div class="company-card" data-name="<?php echo strtolower(htmlspecialchars($row['company_name'])); ?>">
            <h4><?php echo htmlspecialchars($row['company_name']); ?></h4>
            <p><?php echo htmlspecialchars($row['description']); ?></p>

            <div class="card-actions">
                <a href="../tenders/view_tender_list_page.php?company_id=<?php echo $row['id']; ?>" class="link-view">View Tenders</a>
                <a href="edit_company.php?id=<?php echo $row['id']; ?>" class="link-edit">Edit</a>
                <a href="company_list.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this company?')" class="link-delete">Delete</a>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<?php
require_once "../includes/footer.php";
?>
<!-- <script src="../assets/js/companies.js"></script> -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('companySearch');
    const cards = document.querySelectorAll('.company-card');
    let timeout = null;

    searchInput.addEventListener('keyup', function() {
        // Clear the previous timeout (Debounce)
        clearTimeout(timeout);

        // Set a new timeout to run after 300ms
        timeout = setTimeout(() => {
            const filter = searchInput.value.toLowerCase();

            cards.forEach(card => {
                const companyName = card.getAttribute('data-name');
                if (companyName.includes(filter)) {
                    card.style.display = ""; // Show
                } else {
                    card.style.display = "none"; // Hide
                }
            });
        }, 300); 
    });
});
</script>
</body>
</html>
