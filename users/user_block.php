<?php
require_once '../config/db.php';
require_once "../includes/access.php";

checkRole(['Admin']); // Only Admin can access

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
}
header("Location: " . $_SERVER['HTTP_REFERER']); // যে পেজ থেকে এসেছে সেখানে ফেরত যাবে
exit;