<?php
$page_title = 'Manage Travel Journal';
require_once 'partials/header.php';
require_once '../includes/db_connect.php';

try {
    $stmt = $pdo->query("SELECT id, title_en, country_name, category, published_at FROM travel_journal ORDER BY published_at DESC");
    $posts = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Could not retrieve data: " . $e->getMessage());
}
?>

<h1>Manage Travel Journal</h1>
<p>Add, edit, or delete your travel posts.</p>

<a href="add_travel.php" class="btn btn-add">Add New Post</a>

<?php if (isset($_GET['status'])): ?>
    <div class="success-message">
        <?php 
            if ($_GET['status'] == 'added') echo 'New post added successfully!';
            if ($_GET['status'] == 'updated') echo 'Post updated successfully!';
            if ($_GET['status'] == 'deleted') echo 'Post deleted successfully!';
        ?>
    </div>
<?php endif; ?>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Country</th>
                <th>Category</th>
                <th>Published Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($posts)): ?>
                <tr><td colspan="5">No posts found.</td></tr>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($post['title_en']); ?></td>
                        <td><?php echo htmlspecialchars($post['country_name']); ?></td>
                        <td><?php echo htmlspecialchars($post['category']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($post['published_at'])); ?></td>
                        <td class="actions">
                            <a href="edit_travel.php?id=<?php echo $post['id']; ?>" class="btn-action edit">Edit</a>
                            <a href="travel_handler.php?action=delete&id=<?php echo $post['id']; ?>" class="btn-action delete" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'partials/footer.php'; ?>