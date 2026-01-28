<?php
// config/database.php
$host = 'localhost';
$db   = 'tender_management_system';
$user = 'root';
$pass = ''; // XAMPP ডিফল্ট পাসওয়ার্ড ফাঁকা থাকে
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     // এই ভেরিয়েবলটির নাম অবশ্যই $pdo হতে হবে
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>