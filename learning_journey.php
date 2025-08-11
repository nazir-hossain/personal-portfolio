<?php 
require_once 'includes/init.php'; 
$pageTitle = $lang_pack['page_title_learning_journey'];
$meta_description = "A collection of courses, books, and other learning experiences undertaken by " . get_setting('author_name');
require_once 'includes/header.php'; 

$journeys = [];
try {
    $stmt = $pdo->query("SELECT * FROM learning_journey ORDER BY created_at DESC");
    $journeys = $stmt->fetchAll();
} catch (PDOException $e) {
    echo '<div class="status-message error">Could not load learning journey items.</div>';
}
?>

<section class="content-section">
    <div class="reveal-on-scroll">
        <h1><?php echo $lang_pack['nav_learning_journey']; ?></h1>
    </div>

    <div id="journey-filters" class="reveal-on-scroll">
        <button class="filter-btn active" data-filter="all"><?php echo $lang_pack['filter_all']; ?></button>
        <button class="filter-btn" data-filter="course"><?php echo $lang_pack['filter_courses']; ?></button>
        <button class="filter-btn" data-filter="book"><?php echo $lang_pack['filter_books']; ?></button>
        <button class="filter-btn" data-filter="other"><?php echo $lang_pack['filter_others']; ?></button>
    </div>

    <div class="project-grid" id="journey-grid">
        <?php if (empty($journeys)): ?>
            <p style="text-align: center; width: 100%;">No learning journey items have been added yet.</p>
        <?php else: ?>
            <?php foreach ($journeys as $item): ?>
                <div class="project-card journey-card reveal-on-scroll" data-type="<?php echo htmlspecialchars($item['type']); ?>">
                    <a href="journey_detail.php?id=<?php echo $item['id']; ?>" class="card-image-link">
                        <img src="<?php echo htmlspecialchars($item['main_image'] ?? 'assets/img/placeholder.png'); ?>" alt="<?php echo htmlspecialchars($item['title_en']); ?>">
                    </a>
                    <div class="card-content">
                        <div class="star-rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star <?php echo ($i <= $item['rating']) ? 'filled' : ''; ?>">&#9733;</span>
                            <?php endfor; ?>
                        </div>
                        <h3><a href="journey_detail.php?id=<?php echo $item['id']; ?>"><?php echo htmlspecialchars($item['title_' . $lang]); ?></a></h3>
                        <p><?php echo htmlspecialchars($item['short_desc_' . $lang]); ?></p>
                        <div class="project-links">
                            <a href="journey_detail.php?id=<?php echo $item['id']; ?>" class="details-link">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterContainer = document.querySelector('#journey-filters');
    const journeyCards = document.querySelectorAll('#journey-grid .journey-card');

    if (filterContainer) {
        filterContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('filter-btn')) {
                filterContainer.querySelector('.active').classList.remove('active');
                e.target.classList.add('active');

                const filterValue = e.target.getAttribute('data-filter');

                journeyCards.forEach(card => {
                    if (filterValue === 'all' || card.getAttribute('data-type') === filterValue) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>