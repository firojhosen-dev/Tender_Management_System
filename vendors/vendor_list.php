<?php
require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin','Tender Creator','Reviewer']);

$result = $conn->query("SELECT * FROM vendors ORDER BY id DESC");
?>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

<h2>Vendor List</h2>
<a href="add_vendor.php">Add New Vendor</a>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Vendor Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['vendor_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <a href="vendor_view.php?id=<?= $row['id'] ?>">View</a> |
                <a href="edit_vendor.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete_vendor.php?id=<?= $row['id'] ?>"
                   onclick="return confirm('Delete this vendor?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
