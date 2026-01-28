<?php
require_once "../includes/header.php";
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin','Tender Creator']);

$message = "";

if (isset($_POST['add_vendor'])) {

    $vendor_name = trim($_POST['vendor_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $reg_no = trim($_POST['company_registration_no']);
    $created_by = $_SESSION['user_id'];

    if ($vendor_name == "") {
        $message = "Vendor name is required.";
    } else {

        // CHECK DUPLICATE
        $check = $conn->prepare("SELECT id FROM vendors WHERE vendor_name = ?");
        $check->bind_param("s", $vendor_name);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "A Vendor with this name has already been added. Please choose a different name.";
        } else {

            $stmt = $conn->prepare("
                INSERT INTO vendors
                (vendor_name, email, phone, address, company_registration_no, created_by)
                VALUES (?,?,?,?,?,?)
            ");

            $stmt->bind_param(
                "sssssi",
                $vendor_name, $email, $phone, $address, $reg_no, $created_by
            );

            if ($stmt->execute()) {
                $message = "Vendor added successfully!";
            } else {
                $message = "Error adding vendor.";
            }
        }
    }
}
?>
<link rel="shortcut icon" href="../assets/image/system_logo.png" type="image/x-icon">

<div class="container">
    <h2>Add Vendor</h2>

    <?php if($message): ?>
        <div class="alert"><?= $message ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Vendor Name *</label>
        <input type="text" name="vendor_name" required>

        <label>Email</label>
        <input type="email" name="email">

        <label>Phone</label>
        <input type="text" name="phone">

        <label>Address</label>
        <textarea name="address"></textarea>

        <label>Company Registration No</label>
        <input type="text" name="company_registration_no">

        <button type="submit" name="add_vendor">Add Vendor</button>
    </form>
</div>
