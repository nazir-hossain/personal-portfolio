<?php 
require_once 'includes/init.php'; 

// Get project ID from URL
$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($project_id === 0) {
    header("Location: projects.php");
    exit();
}

// Fetch the specific project from the database
try {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$project_id]);
    $project = $stmt->fetch();
} catch (PDOException $e) {
    $project = null; 
}

// If project is not found, display a proper message and exit.
if (!$project) {
    $pageTitle = 'Project Not Found';
    $meta_description = 'The project you are looking for could not be found.';
    require_once 'includes/header.php';
    echo '<section class="content-section not-found-section"><h1>404</h1><p>Sorry, the project you are looking for does not exist.</p><a href="/projects.php" class="cta-button">Back to Projects</a></section>';
    require_once 'includes/footer.php';
    exit();
}

// Fetch related projects ("More Projects")
$more_projects = [];
try {
    $stmt_more = $pdo->prepare("SELECT * FROM projects WHERE category = :category AND id != :id ORDER BY RAND() LIMIT 2");
    $stmt_more->execute([':category' => $project['category'], ':id' => $project['id']]);
    $more_projects = $stmt_more->fetchAll();
} catch (PDOException $e) {
    $more_projects = []; // Don't crash if this query fails
}

// Set SEO meta tags using data with fallbacks
$pageTitle = htmlspecialchars($project['title_' . $lang] ?? $project['title_en'] ?? 'Project Details');
$meta_description = htmlspecialchars($project['short_desc_' . $lang] ?? $project['short_desc_en'] ?? 'Details about a project.');

require_once 'includes/header.php'; 

// Prepare technologies array
$technologies = !empty($project['technologies']) ? explode(',', $project['technologies']) : [];
?>

<div class="project-detail-container">
    <article class="project-detail-content">
        
        <h1><?php echo htmlspecialchars($project['title_' . $lang] ?? $project['title_en']); ?></h1>

        <div class="project-meta">
            <span class="category-tag"><?php echo htmlspecialchars($project['category']); ?></span>
            <span class="meta-item">Published on: <?php echo date('F d, Y', strtotime($project['created_at'])); ?></span>
        </div>

        <img src="<?php echo htmlspecialchars($project['main_image'] ?? 'assets/img/placeholder.png'); ?>" alt="<?php echo htmlspecialchars($project['title_en']); ?>" class="project-detail-image">

        <div class="project-body">
            <?php echo $project['long_desc_' . $lang] ?? $project['long_desc_en']; ?>
        </div>

        <?php if (!empty($technologies)): ?>
        <div class="project-tech">
            <h3>Technologies Used</h3>
            <div class="tech-tags">
                <?php foreach ($technologies as $tech): ?>
                    <span class="tech-tag"><?php echo htmlspecialchars(trim($tech)); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="project-actions">
            <?php if (!empty($project['live_link'])): ?><a href="<?php echo htmlspecialchars($project['live_link']); ?>" class="cta-button" target="_blank"><?php echo $lang_pack['live_demo']; ?></a><?php endif; ?>
            <?php if (!empty($project['source_code'])): ?><a href="<?php echo htmlspecialchars($project['source_code']); ?>" class="cta-button secondary" target="_blank"><?php echo $lang_pack['source_code']; ?></a><?php endif; ?>
            <?php if (!empty($project['download_file'])): ?><a href="<?php echo htmlspecialchars($project['download_file']); ?>" class="cta-button" download>Download Paper (PDF)</a><?php endif; ?>
        </div>

    </article>
</div>

<?php if (!empty($more_projects)): ?>
<section class="homepage-section reveal-on-scroll">
    <h2>More in '<?php echo htmlspecialchars($project['category']); ?>'</h2>
    <div class="project-grid">
        <?php foreach ($more_projects as $project_card_data):
            include 'includes/project_card.php';
        endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
