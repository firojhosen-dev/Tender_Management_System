<?php
require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin','Tender Creator']);

$id = intval($_GET['id']);

$vendor = $conn->query("SELECT * FROM vendors WHERE id=$id")->fetch_assoc();

if (!$vendor) die("Vendor not found");

if (isset($_POST['update_vendor'])) {

    $vendor_name = trim($_POST['vendor_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("
        UPDATE vendors
        SET vendor_name=?, email=?, phone=?, status=?
        WHERE id=?
    ");

    $stmt->bind_param("ssssi", $vendor_name, $email, $phone, $status, $id);
    $stmt->execute();

    header("Location: vendor_list.php");
    exit;
}
?>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

<h2>Edit Vendor</h2>

<form method="post">
    <label>Vendor Name</label>
    <input type="text" name="vendor_name" value="<?= $vendor['vendor_name'] ?>" required>

    <label>Email</label>
    <input type="email" name="email" value="<?= $vendor['email'] ?>">

    <label>Phone</label>
    <input type="text" name="phone" value="<?= $vendor['phone'] ?>">

    <label>Status</label>
    <select name="status">
        <option <?= $vendor['status']=='Active'?'selected':'' ?>>Active</option>
        <option <?= $vendor['status']=='Inactive'?'selected':'' ?>>Inactive</option>
        <option <?= $vendor['status']=='Blacklisted'?'selected':'' ?>>Blacklisted</option>
    </select>

    <button type="submit" name="update_vendor">Update Vendor</button>
</form>
