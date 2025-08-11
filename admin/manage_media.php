<?php
$page_title = 'Media Library';
require_once 'partials/header.php';
require_once '../includes/db_connect.php';

// Pagination logic
$items_per_page = 12;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

// Get total number of media files
$total_items = $pdo->query("SELECT COUNT(*) FROM media")->fetchColumn();
$total_pages = ceil($total_items / $items_per_page);

// Fetch media files for the current page
$stmt = $pdo->prepare("SELECT * FROM media ORDER BY uploaded_at DESC LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$media_files = $stmt->fetchAll();
?>

<h1>Media Library</h1>
<p>Upload and manage your images and documents.</p>

<div class="content-form" style="margin-bottom: 2rem;">
    <h3>Upload New Media</h3>
    <form action="media_handler.php?action=upload" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="media_file">Select File (Image or PDF)</label>
            <input type="file" id="media_file" name="media_file" required>
        </div>
        <div class="form-group">
            <label for="alt_text">Alternative Text (for images)</label>
            <input type="text" id="alt_text" name="alt_text" placeholder="Describe the image for accessibility">
        </div>
        <button type="submit" class="btn">Upload</button>
    </form>
</div>

<?php if (isset($_GET['status'])): ?>
    <div class="success-message">
        <?php
        switch ($_GET['status']) {
            case 'uploaded': echo 'File uploaded successfully!'; break;
            case 'deleted': echo 'File deleted successfully!'; break;
            case 'updated': echo 'Media updated successfully!'; break;
        }
        ?>
    </div>
<?php endif; ?>

<div class="media-grid">
    <?php if (empty($media_files)): ?>
        <p>No media files found. Upload one to get started.</p>
    <?php else: ?>
        <?php foreach ($media_files as $file): ?>
            <div class="media-item">
                <div class="media-preview">
                    <?php if (strpos($file['file_type'], 'image') !== false): ?>
                        <img src="../<?php echo htmlspecialchars($file['file_path']); ?>" alt="<?php echo htmlspecialchars($file['alt_text']); ?>">
                    <?php else: ?>
                        <div class="file-icon">[PDF]</div>
                    <?php endif; ?>
                </div>
                <div class="media-info">
                    <p class="media-name" title="<?php echo htmlspecialchars($file['file_name']); ?>"><?php echo htmlspecialchars($file['file_name']); ?></p>
                    <div class="media-actions">
                        <button class="btn-action copy-btn" data-url="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($file['file_path']); ?>">Copy URL</button>
                        <a href="edit_media.php?id=<?php echo $file['id']; ?>" class="btn-action edit">Edit</a>
                        <a href="delete_media.php?id=<?php echo $file['id']; ?>" class="btn-action delete" onclick="return confirm('Are you sure?');">Delete</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $current_page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const copyButtons = document.querySelectorAll('.copy-btn');
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const urlToCopy = this.getAttribute('data-url');
            navigator.clipboard.writeText(urlToCopy).then(() => {
                this.textContent = 'Copied!';
                setTimeout(() => { this.textContent = 'Copy URL'; }, 2000);
            }).catch(err => {
                alert('Failed to copy URL.');
            });
        });
    });
});
</script>

<?php require_once 'partials/footer.php'; ?>