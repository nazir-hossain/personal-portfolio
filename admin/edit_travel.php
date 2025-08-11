<?php
$page_title = 'Edit Travel Post';
require_once 'partials/header.php';
require_once '../includes/db_connect.php';

if (!isset($_GET['id'])) { header("Location: manage_travels.php"); exit(); }
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM travel_journal WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();
if (!$post) { die("Post not found."); }
?>

<h1>Edit Travel Post</h1>

<form action="travel_handler.php?action=edit" method="POST" class="content-form">
    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
    
    <div class="form-group">
        <label for="title_en">Title (English)</label>
        <input type="text" name="title_en" value="<?php echo htmlspecialchars($post['title_en']); ?>" required>
    </div>
    <div class="form-group">
        <label for="title_bn">Title (Bengali)</label>
        <input type="text" name="title_bn" value="<?php echo htmlspecialchars($post['title_bn']); ?>" required>
    </div>

    <div class="form-group">
        <label for="content_en">Content (English)</label>
        <textarea name="content_en" class="editor" rows="15"><?php echo htmlspecialchars($post['content_en']); ?></textarea>
    </div>
    <div class="form-group">
        <label for="content_bn">Content (Bengali)</label>
        <textarea name="content_bn" class="editor" rows="15"><?php echo htmlspecialchars($post['content_bn']); ?></textarea>
    </div>

    <div class="form-group">
        <label for="excerpt_en">Excerpt / Short Summary (English)</label>
        <textarea name="excerpt_en" rows="3"><?php echo htmlspecialchars($post['excerpt_en']); ?></textarea>
    </div>
    <div class="form-group">
        <label for="excerpt_bn">Excerpt / Short Summary (Bengali)</label>
        <textarea name="excerpt_bn" rows="3"><?php echo htmlspecialchars($post['excerpt_bn']); ?></textarea>
    </div>

    <div class="form-group">
        <label for="country_name">Country Name</label>
        <input type="text" name="country_name" value="<?php echo htmlspecialchars($post['country_name']); ?>">
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <input type="text" name="category" value="<?php echo htmlspecialchars($post['category']); ?>">
    </div>
    <div class="form-group">
        <label for="tags">Tags (comma-separated)</label>
        <input type="text" name="tags" value="<?php echo htmlspecialchars($post['tags']); ?>">
    </div>

    <div class="form-group">
        <label for="featured_image">Featured Image URL</label>
        <input type="url" name="featured_image" value="<?php echo htmlspecialchars($post['featured_image']); ?>">
    </div>

    <div class="form-group">
        <label for="published_at">Publish Date</label>
        <input type="datetime-local" name="published_at" value="<?php echo date('Y-m-d\TH:i', strtotime($post['published_at'])); ?>">
    </div>

    <button type="submit" class="btn">Update Post</button>
</form>

<?php require_once 'partials/footer.php'; ?>