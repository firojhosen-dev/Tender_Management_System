<?php
require_once "../config/database.php";
require_once "../includes/access.php";

checkRole(['Admin']);

$id = intval($_GET['id']);
$conn->query("DELETE FROM vendors WHERE id=$id");

header("Location: vendor_list.php");
exit;
