<?php 
$page_title = 'Manage Projects';
require_once 'partials/header.php';
require_once '../includes/db_connect.php';

try {
    $stmt = $pdo->query("SELECT id, main_image, title_en, category, view_count, created_at FROM projects ORDER BY created_at DESC");
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Could not retrieve projects: " . $e->getMessage());
}
?>

<h1>Manage Projects</h1>
<p>Here you can add, edit, or delete your projects.</p>

<a href="add_project.php" class="btn btn-add">Add New Project</a>

<?php if (isset($_GET['status'])): ?>
    <div class="success-message">
        <?php 
            switch ($_GET['status']) {
                case 'added': echo 'Project added successfully!'; break;
                case 'updated': echo 'Project updated successfully!'; break;
                case 'deleted': echo 'Project deleted successfully!'; break;
            }
        ?>
    </div>
<?php endif; ?>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Views</th>
                <th>Date Added</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($projects)): ?>
                <tr><td colspan="6">No projects found. Add one to get started.</td></tr>
            <?php else: ?>
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <td>
                            <img src="../<?php echo htmlspecialchars($project['main_image'] ?? 'assets/img/placeholder.png'); ?>" alt="Project Image" class="table-thumb">
                        </td>
                        <td><?php echo htmlspecialchars($project['title_en']); ?></td>
                        <td><span class="category-tag-admin"><?php echo htmlspecialchars($project['category']); ?></span></td>
                        <td><?php echo $project['view_count']; ?></td>
                        <td><?php echo date('M d, Y', strtotime($project['created_at'])); ?></td>
                        <td class="actions">
                            <a href="edit_project.php?id=<?php echo $project['id']; ?>" class="btn-action edit">Edit</a>
                            <a href="delete_project.php?id=<?php echo $project['id']; ?>" class="btn-action delete" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'partials/footer.php'; ?>

