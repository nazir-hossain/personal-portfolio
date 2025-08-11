<?php 
require_once 'includes/init.php'; 

$item_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($item_id === 0) { header("Location: learning_journey.php"); exit(); }

try {
    $stmt = $pdo->prepare("SELECT * FROM learning_journey WHERE id = ?");
    $stmt->execute([$item_id]);
    $item = $stmt->fetch();
} catch (PDOException $e) { $item = null; }

// v2.6: SEO - Set dynamic title and description
if ($item) {
    $pageTitle = $item['title_' . $lang];
    $meta_description = htmlspecialchars($item['short_desc_' . $lang]);
} else {
    $pageTitle = 'Not Found';
    $meta_description = 'The requested learning journey item was not found.';
}

require_once 'includes/header.php'; 
?>

<div class="project-detail-container">
    <?php if ($item): ?>
    <article class="project-detail-content reveal-on-scroll">
        
        <h1><?php echo htmlspecialchars($item['title_' . $lang]); ?></h1>

        <div class="project-meta">
            <span class="category-tag"><?php echo htmlspecialchars($item['type']); ?></span>
            <span class="meta-item">Added on: <?php echo date('F d, Y', strtotime($item['created_at'])); ?></span>
        </div>

        <?php if(!empty($item['main_image'])): ?>
            <img src="<?php echo htmlspecialchars($item['main_image']); ?>" alt="<?php echo htmlspecialchars($item['title_en']); ?>" class="project-detail-image">
        <?php endif; ?>

        <div class="journey-section">
            <h3><?php echo $lang_pack['what_i_learned']; ?></h3>
            <div class="project-body"><?php echo $item['what_i_learned_' . $lang]; ?></div>
        </div>

        <div class="journey-section">
            <h3><?php echo $lang_pack['my_rating']; ?></h3>
            <div class="star-rating large">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span class="star <?php echo ($i <= $item['rating']) ? 'filled' : ''; ?>">&#9733;</span>
                <?php endfor; ?>
                <span>(<?php echo $item['rating']; ?> out of 5)</span>
            </div>
        </div>
        
        <?php if (!empty($item['recommendation_' . $lang])): ?>
        <div class="journey-section">
            <h3><?php echo $lang_pack['my_recommendation']; ?></h3>
            <div class="project-body">
                <p><em><?php echo htmlspecialchars($item['recommendation_' . $lang]); ?></em></p>
            </div>
        </div>
        <?php endif; ?>

        <div class="project-actions">
            <?php if (!empty($item['certificate_url'])): ?>
                <a href="<?php echo htmlspecialchars($item['certificate_url']); ?>" class="cta-button" target="_blank"><?php echo $lang_pack['view_certificate']; ?></a>
            <?php endif; ?>
        </div>

    </article>
    <?php else: ?>
        <section class="content-section text-center"><h1>Item Not Found</h1></section>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>