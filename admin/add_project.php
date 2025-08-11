<?php 
$page_title = 'Add New Project';
require_once 'partials/header.php'; 
?>

<h1>Add New Project</h1>

<form action="project_handler.php?action=add" method="POST" class="content-form">
    
    <div class="form-group">
        <label for="title_en">Title (English)</label>
        <input type="text" id="title_en" name="title_en" required>
    </div>
    
    <div class="form-group">
        <label for="title_bn">Title (Bengali)</label>
        <input type="text" id="title_bn" name="title_bn" required>
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <select id="category" name="category" required>
            <option value="project">Project</option>
            <option value="research">Research</option>
            <option value="book">Book</option>
            <option value="php">PHP</option>
            <option value="javascript">JavaScript</option>
            <option value="react">React</option>
        </select>
    </div>

    <div class="form-group">
        <label for="short_desc_en">Short Description (English)</label>
        <textarea id="short_desc_en" name="short_desc_en" rows="3" required></textarea>
    </div>
    
    <div class="form-group">
        <label for="short_desc_bn">Short Description (Bengali)</label>
        <textarea id="short_desc_bn" name="short_desc_bn" rows="3" required></textarea>
    </div>

    <div class="form-group">
        <label for="long_desc_en">Long Description (English)</label>
        <textarea id="long_desc_en" name="long_desc_en" rows="12" class="editor"></textarea>
    </div>
    
    <div class="form-group">
        <label for="long_desc_bn">Long Description (Bengali)</label>
        <textarea id="long_desc_bn" name="long_desc_bn" rows="12" class="editor"></textarea>
    </div>

    <div class="form-group">
        <label for="technologies">Technologies (comma-separated)</label>
        <input type="text" id="technologies" name="technologies" placeholder="e.g., PHP, MySQL, JavaScript">
    </div>
    
    <div class="form-group">
        <label for="main_image">Main Image URL</label>
        <input type="url" id="main_image" name="main_image" placeholder="https://example.com/image.jpg">
    </div>

    <div class="form-group">
        <label for="live_link">Live Link</label>
        <input type="url" id="live_link" name="live_link" placeholder="https://example.com">
    </div>
    
    <div class="form-group">
        <label for="source_code">Source Code Link</label>
        <input type="url" id="source_code" name="source_code" placeholder="https://github.com/user/repo">
    </div>
    
    <div class="form-group">
        <label for="download_file">Download File Path (optional)</label>
        <input type="text" id="download_file" name="download_file" placeholder="e.g., assets/downloads/paper.pdf">
    </div>

    <button type="submit" class="btn">Add Project</button>
</form>

<?php require_once 'partials/footer.php'; ?>
