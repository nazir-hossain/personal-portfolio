<?php
session_start();
require_once '../includes/db_connect.php'; // Go up one directory to find includes

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header('Location: login.php?error=empty');
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Verify user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, start the session
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to the admin dashboard
            header('Location: index.php');
            exit;
        } else {
            // Incorrect credentials
            header('Location: login.php?error=invalid');
            exit;
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    header('Location: login.php');
    exit;
}
