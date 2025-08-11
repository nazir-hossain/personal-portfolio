<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Admin Panel'; ?> - Portfolio CMS</title>
    <link rel="stylesheet" href="/admin/style.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/plugins/colors/ui/trumbowyg.colors.min.css">
</head>
<body>
    <div class="admin-wrapper">
        <aside class="sidebar">
            <h2>CMS</h2>
            <nav>
                <ul>

<li class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['manage_journeys.php', 'add_journey.php', 'edit_journey.php']) ? 'active' : ''; ?>"><a href="manage_journeys.php">Learning Journey</a></li>

                    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><a href="index.php">Dashboard</a></li>
                    <li class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['manage_projects.php', 'add_project.php', 'edit_project.php']) ? 'active' : ''; ?>"><a href="manage_projects.php">Manage Projects</a></li>

<li class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['manage_travels.php', 'add_travel.php', 'edit_travel.php']) ? 'active' : ''; ?>"><a href="manage_travels.php">Travel Journal</a></li>

                    <li class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['manage_media.php', 'edit_media.php']) ? 'active' : ''; ?>"><a href="manage_media.php">Media Library</a></li>
                    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'manage_page_about.php' ? 'active' : ''; ?>"><a href="manage_page_about.php">Manage About Page</a></li>
                    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>"><a href="settings.php">Settings</a></li>
                    <li><a href="../index.php" target="_blank">View Site</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header class="top-bar">
                <div class="welcome-message">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                </div>
                <a href="logout.php" class="btn btn-logout">Logout</a>
            </header>
            <div class="content-area">
