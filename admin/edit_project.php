<?php 
$page_title = 'Edit Project';
require_once 'partials/header.php'; 
require_once '../includes/db_connect.php';

if (!isset($_GET['id'])) {
    header("Location: manage_projects.php");
    exit();
}
$project_id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$project_id]);
    $project = $stmt->fetch();
    if (!$project) {
        die("Project not found.");
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<h1>Edit Project: <?php echo htmlspecialchars($project['title_en']); ?></h1>

<form action="project_handler.php?action=edit" method="POST" class="content-form">
    <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
    
    <div class="form-group">
        <label for="title_en">Title (English)</label>
        <input type="text" id="title_en" name="title_en" value="<?php echo htmlspecialchars($project['title_en']); ?>" required>
    </div>
    <div class="form-group">
        <label for="title_bn">Title (Bengali)</label>
        <input type="text" id="title_bn" name="title_bn" value="<?php echo htmlspecialchars($project['title_bn']); ?>" required>
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <select id="category" name="category" required>
            <option value="project" <?php echo ($project['category'] == 'project') ? 'selected' : ''; ?>>Project</option>
            <option value="research" <?php echo ($project['category'] == 'research') ? 'selected' : ''; ?>>Research</option>
            <option value="book" <?php echo ($project['category'] == 'book') ? 'selected' : ''; ?>>Book</option>
            <option value="php" <?php echo ($project['category'] == 'php') ? 'selected' : ''; ?>>PHP</option>
            <option value="javascript" <?php echo ($project['category'] == 'javascript') ? 'selected' : ''; ?>>JavaScript</option>
            <option value="react" <?php echo ($project['category'] == 'react') ? 'selected' : ''; ?>>React</option>
        </select>
    </div>
    <div class="form-group">
        <label for="short_desc_en">Short Description (English)</label>
        <textarea id="short_desc_en" name="short_desc_en" rows="3" required><?php echo htmlspecialchars($project['short_desc_en']); ?></textarea>
    </div>
    <div class="form-group">
        <label for="short_desc_bn">Short Description (Bengali)</label>
        <textarea id="short_desc_bn" name="short_desc_bn" rows="3" required><?php echo htmlspecialchars($project['short_desc_bn']); ?></textarea>
    </div>
    <div class="form-group">
        <label for="long_desc_en">Long Description (English)</label>
        <textarea id="long_desc_en" name="long_desc_en" rows="12" class="editor"><?php echo htmlspecialchars($project['long_desc_en']); ?></textarea>
    </div>
    <div class="form-group">
        <label for="long_desc_bn">Long Description (Bengali)</label>
        <textarea id="long_desc_bn" name="long_desc_bn" rows="12" class="editor"><?php echo htmlspecialchars($project['long_desc_bn']); ?></textarea>
    </div>
    <div class="form-group">
        <label for="technologies">Technologies (comma-separated)</label>
        <input type="text" id="technologies" name="technologies" value="<?php echo htmlspecialchars($project['technologies']); ?>">
    </div>
    
    <div class="form-group">
        <label for="main_image">Main Image URL</label>
        <input type="url" id="main_image" name="main_image" value="<?php echo htmlspecialchars($project['main_image']); ?>" placeholder="https://example.com/image.jpg">
        <?php if ($project['main_image']): ?>
            <p style="margin-top: 10px;">Current image preview: <br><img src="<?php echo htmlspecialchars($project['main_image']); ?>" alt="Current Image" width="150" style="border-radius: 4px; border: 1px solid #ddd;"></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="live_link">Live Link</label>
        <input type="url" id="live_link" name="live_link" value="<?php echo htmlspecialchars($project['live_link']); ?>">
    </div>
    <div class="form-group">
        <label for="source_code">Source Code Link</label>
        <input type="url" id="source_code" name="source_code" value="<?php echo htmlspecialchars($project['source_code']); ?>">
    </div>
    <div class="form-group">
        <label for="download_file">Download File Path (optional)</label>
        <input type="text" id="download_file" name="download_file" value="<?php echo htmlspecialchars($project['download_file']); ?>">
    </div>

    <button type="submit" class="btn">Update Project</button>
</form>

<?php require_once 'partials/footer.php'; ?>
