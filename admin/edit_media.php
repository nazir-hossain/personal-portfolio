<?php
$page_title = 'Edit Media';
require_once 'partials/header.php';
require_once '../includes/db_connect.php';

if (!isset($_GET['id'])) {
    header("Location: manage_media.php");
    exit();
}
$media_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM media WHERE id = ?");
$stmt->execute([$media_id]);
$media = $stmt->fetch();

if (!$media) { die("Media not found."); }
?>

<h1>Edit Media</h1>

<form action="media_handler.php?action=edit" method="POST" class="content-form">
    <input type="hidden" name="media_id" value="<?php echo $media['id']; ?>">
    
    <div class="form-group">
        <label>File Preview</label>
        <div class="media-preview large">
             <?php if (strpos($media['file_type'], 'image') !== false): ?>
                <img src="../<?php echo htmlspecialchars($media['file_path']); ?>" alt="<?php echo htmlspecialchars($media['alt_text']); ?>">
            <?php else: ?>
                <p>File: <a href="../<?php echo htmlspecialchars($media['file_path']); ?>" target="_blank"><?php echo htmlspecialchars($media['file_name']); ?></a></p>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="form-group">
        <label for="alt_text">Alternative Text (for images)</label>
        <input type="text" id="alt_text" name="alt_text" value="<?php echo htmlspecialchars($media['alt_text']); ?>">
    </div>

    <button type="submit" class="btn">Update Media</button>
</form>

<?php require_once 'partials/footer.php'; ?>