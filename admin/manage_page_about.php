<?php
$page_title = 'Manage About Page';
require_once 'partials/header.php';
require_once '../includes/db_connect.php';

$about_contents_db = [];
try {
    $stmt = $pdo->query("SELECT * FROM settings WHERE setting_key IN ('about_content_en', 'about_content_bn')");
    $about_contents_db = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
} catch(PDOException $e) {
    echo '<div class="error-message">Could not load about page content.</div>';
}

$about_en = $about_contents_db['about_content_en'] ?? '';
$about_bn = $about_contents_db['about_content_bn'] ?? '';
?>

<h1>Manage 'About Me' Page</h1>
<p>Use the editors below to update the content of your About Me page.</p>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div class="success-message">About page content saved successfully!</div>
<?php endif; ?>

<form action="settings_handler.php?action=update_about" method="POST" class="content-form">
    <div class="form-group">
        <label for="about_content_en">Content (English)</label>
        <textarea name="about_content_en" id="about_content_en" class="editor" rows="15"><?php echo htmlspecialchars($about_en); ?></textarea>
    </div>
    <div class="form-group">
        <label for="about_content_bn">Content (Bengali)</label>
        <textarea name="about_content_bn" id="about_content_bn" class="editor" rows="15"><?php echo htmlspecialchars($about_bn); ?></textarea>
    </div>
    <button type="submit" class="btn">Save About Page</button>
</form>

<?php require_once 'partials/footer.php'; ?>