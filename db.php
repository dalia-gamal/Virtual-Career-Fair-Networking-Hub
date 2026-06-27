<?php
$host = '127.0.0.1';
$db   = 'link_platform';
$user = 'root';
$pass = ''; // Default XAMPP password is empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed. Please make sure XAMPP MySQL is running and the database 'link_platform' is created.");
}
?>
