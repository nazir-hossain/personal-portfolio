<?php
require_once 'includes/init.php';

// Get the slug from the URL
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
if (empty($slug)) {
    header("Location: travel_journal.php");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM travel_journal WHERE slug = ?");
    $stmt->execute([$slug]);
    $post = $stmt->fetch();
} catch (PDOException $e) {
    $post = null;
}

// SEO: Set dynamic title and description
if ($post) {
    $pageTitle = htmlspecialchars($post['title_' . $lang] ?? $post['title_en'] ?? 'Travel Post');
    $meta_description = htmlspecialchars($post['excerpt_' . $lang] ?? $post['excerpt_en'] ?? 'A post from my travel journal.');
} else {
    $pageTitle = 'Post Not Found';
    $meta_description = 'The requested travel post was not found.';
}

require_once 'includes/header.php';
?>

<div class="project-detail-container">
    <?php if ($post): ?>
    <?php
        $tags = !empty($post['tags']) ? explode(',', $post['tags']) : [];
    ?>
    <article class="project-detail-content">
        
        <h1><?php echo htmlspecialchars($post['title_' . $lang] ?? $post['title_en'] ?? 'Untitled Post'); ?></h1>

        <div class="project-meta">
            <?php if (!empty($post['country_name'])): ?>
                <span class="category-tag"><?php echo htmlspecialchars($post['country_name']); ?></span>
            <?php endif; ?>
            <span class="meta-item">Published on: <?php echo date('F d, Y', strtotime($post['published_at'])); ?></span>
        </div>

        <?php if(!empty($post['featured_image'])): ?>
            <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" alt="<?php echo htmlspecialchars($post['title_en']); ?>" class="project-detail-image">
        <?php endif; ?>

        <div class="project-body">
            <?php echo $post['content_' . $lang] ?? $post['content_en'] ?? '<p>Content not available.</p>'; ?>
        </div>

        <?php if (!empty($tags)): ?>
        <div class="journey-section">
            <h3><?php echo $lang_pack['tags']; ?></h3>
            <div class="tech-tags">
                <?php foreach ($tags as $tag): ?>
                    <span class="tech-tag"><?php echo htmlspecialchars(trim($tag)); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </article>
    <?php else: ?>
        <section class="content-section not-found-section">
            <h1>404</h1>
            <p>Sorry, the post you are looking for does not exist.</p>
            <a href="/travel_journal.php" class="cta-button">Back to Travel Journal</a>
        </section>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>