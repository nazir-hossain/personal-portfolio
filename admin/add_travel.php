<?php
$page_title = 'Add Travel Post';
require_once 'partials/header.php';
?>

<h1>Add New Travel Post</h1>

<form action="travel_handler.php?action=add" method="POST" class="content-form">
    <div class="form-group">
        <label for="title_en">Title (English)</label>
        <input type="text" id="title_en" name="title_en" required>
    </div>
    <div class="form-group">
        <label for="title_bn">Title (Bengali)</label>
        <input type="text" id="title_bn" name="title_bn" required>
    </div>

    <div class="form-group">
        <label for="content_en">Content (English)</label>
        <textarea name="content_en" class="editor" rows="15"></textarea>
    </div>
    <div class="form-group">
        <label for="content_bn">Content (Bengali)</label>
        <textarea name="content_bn" class="editor" rows="15"></textarea>
    </div>

    <div class="form-group">
        <label for="excerpt_en">Excerpt / Short Summary (English)</label>
        <textarea name="excerpt_en" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="excerpt_bn">Excerpt / Short Summary (Bengali)</label>
        <textarea name="excerpt_bn" rows="3"></textarea>
    </div>

    <div class="form-group">
        <label for="country_name">Country Name</label>
        <input type="text" name="country_name" placeholder="e.g., Switzerland">
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <input type="text" name="category" placeholder="e.g., Adventure, Cultural">
    </div>
    <div class="form-group">
        <label for="tags">Tags (comma-separated)</label>
        <input type="text" name="tags" placeholder="e.g., hiking, mountains, food">
    </div>

    <div class="form-group">
        <label for="featured_image">Featured Image URL</label>
        <input type="url" name="featured_image" placeholder="https://example.com/image.jpg">
    </div>

    <div class="form-group">
        <label for="published_at">Publish Date</label>
        <input type="datetime-local" name="published_at" value="<?php echo date('Y-m-d\TH:i'); ?>">
    </div>

    <button type="submit" class="btn">Publish Post</button>
</form>

<?php require_once 'partials/footer.php'; ?>