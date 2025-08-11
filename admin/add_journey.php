<?php
$page_title = 'Add Journey Item';
require_once 'partials/header.php';
?>

<h1>Add New Learning Journey Item</h1>

<form action="journey_handler.php?action=add" method="POST" class="content-form">
    
    <div class="form-group">
        <label for="type">Type</label>
        <select name="type" id="type" required>
            <option value="course">Course</option>
            <option value="book">Book</option>
            <option value="other">Other</option>
        </select>
    </div>

    <div class="form-group">
        <label for="title_en">Title (English)</label>
        <input type="text" id="title_en" name="title_en" required>
    </div>
    <div class="form-group">
        <label for="title_bn">Title (Bengali)</label>
        <input type="text" id="title_bn" name="title_bn" required>
    </div>

    <div class="form-group">
        <label for="main_image">Featured Image URL</label>
        <input type="url" id="main_image" name="main_image" placeholder="Image URL for social sharing">
    </div>

    <div class="form-group">
        <label for="short_desc_en">Short Description (English)</label>
        <textarea name="short_desc_en" id="short_desc_en" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label for="short_desc_bn">Short Description (Bengali)</label>
        <textarea name="short_desc_bn" id="short_desc_bn" rows="3" required></textarea>
    </div>

    <div class="form-group">
        <label for="what_i_learned_en">What I Learned (English)</label>
        <textarea name="what_i_learned_en" id="what_i_learned_en" class="editor" rows="10"></textarea>
    </div>
    <div class="form-group">
        <label for="what_i_learned_bn">What I Learned (Bengali)</label>
        <textarea name="what_i_learned_bn" id="what_i_learned_bn" class="editor" rows="10"></textarea>
    </div>

    <div class="form-group">
        <label for="rating">My Rating (out of 5)</label>
        <input type="number" id="rating" name="rating" min="1" max="5" step="1" value="5" required>
    </div>

    <div class="form-group">
        <label for="recommendation_en">Recommendation (English)</label>
        <textarea name="recommendation_en" id="recommendation_en" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="recommendation_bn">Recommendation (Bengali)</label>
        <textarea name="recommendation_bn" id="recommendation_bn" rows="3"></textarea>
    </div>

    <div class="form-group">
        <label for="certificate_url">Certificate URL (Optional)</label>
        <input type="url" id="certificate_url" name="certificate_url">
    </div>

    <button type="submit" class="btn">Add Item</button>
</form>

<?php require_once 'partials/footer.php'; ?>
