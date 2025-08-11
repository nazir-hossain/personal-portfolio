<?php
session_start();
// If user is already logged in, redirect to the dashboard
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Portfolio CMS</title>
    <link rel="stylesheet" href="/admin/style.css">
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">Invalid username or password.</div>
        <?php endif; ?>

        <form action="auth.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
