<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Find the user by email
    $stmt = $pdo->prepare("SELECT id, full_name, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify user exists and password is correct
    if ($user && password_verify($password, $user['password'])) {
        // Create session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['full_name'] = $user['full_name'];

        // Redirect based on role
        if ($user['role'] === 'student') {
            header('Location: Student.html');
        } else if ($user['role'] === 'recruiter') {
            header('Location: Recruiter.html');
        } else {
            header('Location: Admin.html');
        }
        exit;
    } else {
        echo "<script>alert('Error: Invalid email or password.'); window.location.href='Login.html';</script>";
    }
}
?>
