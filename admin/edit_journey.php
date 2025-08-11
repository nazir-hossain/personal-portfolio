<?php
$page_title = 'Edit Journey Item';
require_once 'partials/header.php';
require_once '../includes/db_connect.php';

if (!isset($_GET['id'])) {
    header("Location: manage_journeys.php");
    exit();
}
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM learning_journey WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();
if (!$item) { die("Item not found."); }
?>

<h1>Edit Learning Journey Item</h1>

<form action="journey_handler.php?action=edit" method="POST" class="content-form">
    <input type="hidden" name="journey_id" value="<?php echo $item['id']; ?>">
    
    <div class="form-group">
        <label for="type">Type</label>
        <select name="type" id="type" required>
            <option value="course" <?php echo ($item['type'] == 'course') ? 'selected' : ''; ?>>Course</option>
            <option value="book" <?php echo ($item['type'] == 'book') ? 'selected' : ''; ?>>Book</option>
            <option value="other" <?php echo ($item['type'] == 'other') ? 'selected' : ''; ?>>Other</option>
        </select>
    </div>

    <div class="form-group">
        <label for="title_en">Title (English)</label>
        <input type="text" id="title_en" name="title_en" value="<?php echo htmlspecialchars($item['title_en']); ?>" required>
    </div>
    <div class="form-group">
        <label for="title_bn">Title (Bengali)</label>
        <input type="text" id="title_bn" name="title_bn" value="<?php echo htmlspecialchars($item['title_bn']); ?>" required>
    </div>

    <div class="form-group">
        <label for="main_image">Featured Image URL</label>
        <input type="url" id="main_image" name="main_image" value="<?php echo htmlspecialchars($item['main_image']); ?>">
    </div>

    <div class="form-group">
        <label for="short_desc_en">Short Description (English)</label>
        <textarea name="short_desc_en" id="short_desc_en" rows="3" required><?php echo htmlspecialchars($item['short_desc_en']); ?></textarea>
    </div>
    <div class="form-group">
        <label for="short_desc_bn">Short Description (Bengali)</label>
        <textarea name="short_desc_bn" id="short_desc_bn" rows="3" required><?php echo htmlspecialchars($item['short_desc_bn']); ?></textarea>
    </div>

    <div class="form-group">
        <label for="what_i_learned_en">What I Learned (English)</label>
        <textarea name="what_i_learned_en" id="what_i_learned_en" class="editor" rows="10"><?php echo htmlspecialchars($item['what_i_learned_en']); ?></textarea>
    </div>
    <div class="form-group">
        <label for="what_i_learned_bn">What I Learned (Bengali)</label>
        <textarea name="what_i_learned_bn" id="what_i_learned_bn" class="editor" rows="10"><?php echo htmlspecialchars($item['what_i_learned_bn']); ?></textarea>
    </div>

    <div class="form-group">
        <label for="rating">My Rating (out of 5)</label>
        <input type="number" id="rating" name="rating" min="1" max="5" step="1" value="<?php echo $item['rating']; ?>" required>
    </div>

    <div class="form-group">
        <label for="recommendation_en">Recommendation (English)</label>
        <textarea name="recommendation_en" id="recommendation_en" rows="3"><?php echo htmlspecialchars($item['recommendation_en']); ?></textarea>
    </div>
    <div class="form-group">
        <label for="recommendation_bn">Recommendation (Bengali)</label>
        <textarea name="recommendation_bn" id="recommendation_bn" rows="3"><?php echo htmlspecialchars($item['recommendation_bn']); ?></textarea>
    </div>

    <div class="form-group">
        <label for="certificate_url">Certificate URL (Optional)</label>
        <input type="url" id="certificate_url" name="certificate_url" value="<?php echo htmlspecialchars($item['certificate_url']); ?>">
    </div>

    <button type="submit" class="btn">Update Item</button>
</form>

<?php require_once 'partials/footer.php'; ?>