<?php
require_once 'includes/init.php';
$pageTitle = $lang_pack['page_title_travel_journal'];
$meta_description = "A journal of travels and experiences by " . get_setting('author_name');
require_once 'includes/header.php';

$posts = [];
$countries = [];
try {
    // Fetch all travel posts
    $stmt_posts = $pdo->query("SELECT * FROM travel_journal ORDER BY published_at DESC");
    $posts = $stmt_posts->fetchAll();

    // Fetch unique countries for the filter dropdown
    $stmt_countries = $pdo->query("SELECT DISTINCT country_name FROM travel_journal WHERE country_name IS NOT NULL AND country_name != '' ORDER BY country_name ASC");
    $countries = $stmt_countries->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    echo '<div class="status-message error">Could not load travel journal.</div>';
}
?>

<section class="content-section">
    <div class="reveal-on-scroll">
        <h1><?php echo $lang_pack['page_title_travel_journal']; ?></h1>
    </div>

    <?php if (!empty($countries)): ?>
    <div id="travel-filters" class="reveal-on-scroll">
        <label for="country-filter"><?php echo $lang_pack['filter_by_country']; ?></label>
        <select id="country-filter">
            <option value="all"><?php echo $lang_pack['all_countries']; ?></option>
            <?php foreach ($countries as $country): ?>
                <option value="<?php echo htmlspecialchars($country); ?>"><?php echo htmlspecialchars($country); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php endif; ?>

    <div class="project-grid" id="travel-grid">
        <?php if (empty($posts)): ?>
            <p style="text-align: center; width: 100%;">No travel posts have been added yet.</p>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="project-card travel-card reveal-on-scroll" data-country="<?php echo htmlspecialchars($post['country_name']); ?>">
                    <a href="travel/<?php echo $post['slug']; ?>" class="card-image-link">
                        <img src="<?php echo htmlspecialchars($post['featured_image'] ?? 'assets/img/placeholder.png'); ?>" alt="<?php echo htmlspecialchars($post['title_en']); ?>">
                    </a>
                    <div class="card-content">
                        <span class="category-tag"><?php echo htmlspecialchars($post['country_name']); ?></span>
                        <h3><a href="travel/<?php echo $post['slug']; ?>"><?php echo htmlspecialchars($post['title_' . $lang]); ?></a></h3>
                        <p><?php echo htmlspecialchars($post['excerpt_' . $lang]); ?></p>
                        <div class="project-links">
                            <a href="travel/<?php echo $post['slug']; ?>" class="details-link">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const countryFilter = document.querySelector('#country-filter');
    const travelCards = document.querySelectorAll('#travel-grid .travel-card');

    if (countryFilter) {
        countryFilter.addEventListener('change', function() {
            const selectedCountry = this.value;

            travelCards.forEach(card => {
                if (selectedCountry === 'all' || card.getAttribute('data-country') === selectedCountry) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>