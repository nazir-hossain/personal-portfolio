<?php 
require_once 'includes/init.php'; 
$pageTitle = $lang_pack['page_title_projects'];
require_once 'includes/header.php'; 

$projects = [];
$error_message = null;

try {
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    $error_message = "Sorry, projects could not be loaded at this time. Please try again later.";
}
?>

<section class="content-section">
    <div class="reveal-on-scroll">
        <h1><?php echo $lang_pack['projects_title']; ?></h1>
        <p><?php echo $lang_pack['projects_description']; ?></p>
    </div>

    <div id="project-filters" class="reveal-on-scroll">
        <button class="filter-btn active" data-filter="all"><?php echo $lang_pack['filter_all']; ?></button>
        <?php
            $categories_str = get_setting('site_categories', '');
            $categories = !empty($categories_str) ? explode(',', $categories_str) : [];
            foreach ($categories as $category):
                $category = trim($category);
        ?>
            <button class="filter-btn" data-filter="<?php echo strtolower($category); ?>"><?php echo htmlspecialchars($category); ?></button>
        <?php endforeach; ?>
    </div>

    <?php if ($error_message): ?>
        <div class="status-message error"><?php echo $error_message; ?></div>
    <?php else: ?>
        <div class="project-grid">
            <?php if (empty($projects)): ?>
                <p style="text-align: center; width: 100%;">No projects have been added yet.</p>
            <?php else: ?>
                <?php foreach ($projects as $project) { include 'includes/project_card.php'; } ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
