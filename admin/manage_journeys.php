<?php
$page_title = 'Manage Learning Journey';
require_once 'partials/header.php';
require_once '../includes/db_connect.php';

try {
    $stmt = $pdo->query("SELECT id, title_en, type, rating, created_at FROM learning_journey ORDER BY created_at DESC");
    $journeys = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Could not retrieve data: " . $e->getMessage());
}
?>

<h1>Manage Learning Journey</h1>
<p>Add, edit, or delete your learning experiences like courses, books, etc.</p>

<a href="add_journey.php" class="btn btn-add">Add New Journey Item</a>

<?php if (isset($_GET['status'])): ?>
    <div class="success-message">
        <?php 
            if ($_GET['status'] == 'added') echo 'New journey item added successfully!';
            if ($_GET['status'] == 'updated') echo 'Journey item updated successfully!';
            if ($_GET['status'] == 'deleted') echo 'Journey item deleted successfully!';
        ?>
    </div>
<?php endif; ?>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Rating</th>
                <th>Date Added</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($journeys)): ?>
                <tr><td colspan="5">No items found.</td></tr>
            <?php else: ?>
                <?php foreach ($journeys as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['title_en']); ?></td>
                        <td><span class="category-tag-admin"><?php echo htmlspecialchars($item['type']); ?></span></td>
                        <td><?php echo $item['rating']; ?> / 5</td>
                        <td><?php echo date('M d, Y', strtotime($item['created_at'])); ?></td>
                        <td class="actions">
                            <a href="edit_journey.php?id=<?php echo $item['id']; ?>" class="btn-action edit">Edit</a>
                            <a href="delete_journey.php?id=<?php echo $item['id']; ?>" class="btn-action delete" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'partials/footer.php'; ?>