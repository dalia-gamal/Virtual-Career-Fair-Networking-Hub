<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role']; // student or recruiter

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Error: Email is already registered.'); window.location.href='Login.html';</script>";
        exit;
    }

    // Hash password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$full_name, $email, $hashed_password, $role])) {
        // Automatically log them in after registration
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['role'] = $role;
        $_SESSION['full_name'] = $full_name;

        // Redirect based on role
        if ($role === 'student') {
            header('Location: Student.html');
        } else {
            header('Location: Recruiter.html');
        }
        exit;
    } else {
        echo "<script>alert('Error: Registration failed.'); window.location.href='Login.html';</script>";
    }
}
?>
