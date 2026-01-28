<?php
require_once '../config/db.php';
require_once "../includes/access.php";

checkRole(['Admin']); // Only Admin can access

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
}
header("Location: user_list.php?msg=User Deleted");
exit;