<?php
/*
===========================================
?    Tender Management System Information Start
===========================================
*    Filename: search_history.php
*    Project: Tender Management System
*    Description:
*        Displays a history of all searches performed by users.
*        Tracks: User Name, Role, Search Query, Date & Time.
*        Useful for auditing and analytics.
*
*    Version: 1.0.0
*    Author: Tender Management System Team
===========================================
*/

require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin', 'Auditor']); // Only Admin and Auditor can access

// Fetch search history
$query = "
    SELECT sh.id, sh.user_id, u.name AS user_name, r.role_name, sh.search_query, sh.search_date
    FROM search_history sh
    LEFT JOIN users u ON sh.user_id = u.id
    LEFT JOIN roles r ON u.role_id = r.id
    ORDER BY sh.search_date DESC
";

$result = mysqli_query($conn, $query);
if(!$result){
    die("Error fetching search history: " . mysqli_error($conn));
}
?>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

<h3>Search History</h3>

<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead style="background:#ddd;">
        <tr>
            <th>S/L</th>
            <th>User Name</th>
            <th>Role</th>
            <th>Search Query</th>
            <th>Date & Time</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if(mysqli_num_rows($result) > 0){
            $sl = 1;
            while($row = mysqli_fetch_assoc($result)){ ?>
                <tr>
                    <td><?php echo $sl++; ?></td>
                    <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['role_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['search_query']); ?></td>
                    <td><?php echo $row['search_date']; ?></td>
                </tr>
        <?php } } else { ?>
            <tr><td colspan="5" style="text-align:center;">No search history found.</td></tr>
        <?php } ?>
    </tbody>
</table>

<br>
<a href="dashboard.php">Back to Dashboard</a>

<?php include "../includes/footer.php"; ?>
