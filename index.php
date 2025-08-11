<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'includes/init.php'; 
$pageTitle = $lang_pack['page_title_home'];
require_once 'includes/header.php'; 

$recent_projects = [];
$recent_research = [];
$recent_books = [];
$db_error = false;

try {
    if (get_setting('show_recent_projects') == '1') {
        $stmt_projects = $pdo->prepare("SELECT * FROM projects WHERE category IN ('project', 'php', 'javascript', 'react') ORDER BY created_at DESC LIMIT 3");
        $stmt_projects->execute();
        $recent_projects = $stmt_projects->fetchAll();
    }
    if (get_setting('show_recent_research') == '1') {
        $stmt_research = $pdo->prepare("SELECT * FROM projects WHERE category = 'research' ORDER BY created_at DESC LIMIT 2");
        $stmt_research->execute();
        $recent_research = $stmt_research->fetchAll();
    }
    if (get_setting('show_recent_books') == '1') {
        $stmt_books = $pdo->prepare("SELECT * FROM projects WHERE category = 'book' ORDER BY created_at DESC LIMIT 2");
        $stmt_books->execute();
        $recent_books = $stmt_books->fetchAll();
    }
} catch (PDOException $e) {
    $db_error = true;
}
?>

<section class="hero-section reveal-on-scroll">
    <div class="hero-text">
        <h1><?php echo get_setting('author_name'); ?></h1>
        <h2><?php echo get_setting('hero_subtitle'); ?></h2>
        <p><?php echo get_setting('hero_description'); ?></p>
        <a href="<?php echo get_setting('hero_button_url', 'projects.php'); ?>" class="cta-button"><?php echo get_setting('hero_button_text', 'View My Work'); ?></a>
    </div>
    <div class="hero-image">
        <img src="assets/img/profile.jpg" alt="Profile picture of <?php echo get_setting('author_name'); ?>">
    </div>
</section>

<?php if ($db_error): ?>
    <section class="homepage-section"><div class="status-message error">Could not load dynamic content.</div></section>
<?php endif; ?>

<?php if (get_setting('show_recent_projects') == '1' && !empty($recent_projects)): ?>
<section class="homepage-section reveal-on-scroll">
    <h2>Recent Projects</h2>
    <div class="project-grid">
        <?php foreach ($recent_projects as $project) { include 'includes/project_card.php'; } ?>
    </div>
</section>
<?php endif; ?>

<?php if (get_setting('show_recent_research') == '1' && !empty($recent_research)): ?>
<section class="homepage-section reveal-on-scroll">
    <h2>Recent Research</h2>
    <div class="project-grid">
        <?php foreach ($recent_research as $project) { include 'includes/project_card.php'; } ?>
    </div>
</section>
<?php endif; ?>

<?php if (get_setting('show_recent_books') == '1' && !empty($recent_books)): ?>
<section class="homepage-section reveal-on-scroll">
    <h2>Books / Publications</h2>
     <div class="project-grid">
        <?php foreach ($recent_books as $project) { include 'includes/project_card.php'; } ?>
    </div>
</section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
