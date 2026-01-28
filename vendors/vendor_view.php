<?php
require_once "../includes/header.php";
require_once "../config/database.php";

$id = intval($_GET['id']);
$vendor = $conn->query("SELECT * FROM vendors WHERE id=$id")->fetch_assoc();
?>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

<h2>Vendor Details</h2>

<ul>
    <li><strong>Name:</strong> <?= $vendor['vendor_name'] ?></li>
    <li><strong>Email:</strong> <?= $vendor['email'] ?></li>
    <li><strong>Phone:</strong> <?= $vendor['phone'] ?></li>
    <li><strong>Status:</strong> <?= $vendor['status'] ?></li>
    <li><strong>Registered At:</strong> <?= $vendor['created_at'] ?></li>
</ul>

<a href="vendor_list.php">← Back</a>
