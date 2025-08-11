<?php 
$page_title = 'Dashboard';
require_once 'partials/header.php'; 
require_once '../includes/db_connect.php';

// --- v2.2: Fetch Visitor Statistics ---
try {
    // Today's Unique Visitors
    $stmt_today = $pdo->query("SELECT COUNT(DISTINCT ip_address) FROM visitors WHERE DATE(visit_date) = CURDATE()");
    $today_visitors = $stmt_today->fetchColumn();

    // Yesterday's Unique Visitors
    $stmt_yesterday = $pdo->query("SELECT COUNT(DISTINCT ip_address) FROM visitors WHERE DATE(visit_date) = CURDATE() - INTERVAL 1 DAY");
    $yesterday_visitors = $stmt_yesterday->fetchColumn();

    // This Month's Unique Visitors
    $stmt_month = $pdo->query("SELECT COUNT(DISTINCT ip_address) FROM visitors WHERE MONTH(visit_date) = MONTH(CURDATE()) AND YEAR(visit_date) = YEAR(CURDATE())");
    $month_visitors = $stmt_month->fetchColumn();

    // This Year's Unique Visitors
    $stmt_year = $pdo->query("SELECT COUNT(DISTINCT ip_address) FROM visitors WHERE YEAR(visit_date) = YEAR(CURDATE())");
    $year_visitors = $stmt_year->fetchColumn();

} catch (PDOException $e) {
    // If stats fail, show N/A instead of breaking the page
    $today_visitors = $yesterday_visitors = $month_visitors = $year_visitors = "N/A";
}

// Fetch project count
try {
    $project_count = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
} catch (PDOException $e) {
    $project_count = "N/A";
}
?>

<h1>Dashboard</h1>
<p>Welcome to your Content Management System. Here's a summary of your site's activity.</p>

<div class="dashboard-widgets">
    <div class="widget widget-stats">
        <h4>Today's Visitors</h4>
        <p class="stat-number"><?php echo $today_visitors; ?></p>
    </div>
    <div class="widget widget-stats">
        <h4>Yesterday's Visitors</h4>
        <p class="stat-number"><?php echo $yesterday_visitors; ?></p>
    </div>
    <div class="widget widget-stats">
        <h4>This Month's Visitors</h4>
        <p class="stat-number"><?php echo $month_visitors; ?></p>
    </div>
    <div class="widget widget-stats">
        <h4>This Year's Visitors</h4>
        <p class="stat-number"><?php echo $year_visitors; ?></p>
    </div>
</div>

<div class="dashboard-widgets">
    <div class="widget">
        <h3>Projects</h3>
        <p>You have a total of <strong><?php echo $project_count; ?></strong> projects.</p>
        <a href="manage_projects.php" class="btn">Manage Projects</a>
    </div>
    <div class="widget">
        <h3>Media Library</h3>
        <p>Manage all your uploaded images and files.</p>
        <a href="manage_media.php" class="btn">Go to Media Library</a>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>
