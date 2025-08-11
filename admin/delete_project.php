<?php
session_start();
require_once '../includes/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    die("Access denied.");
}

// Check if an ID is provided
if (!isset($_GET['id'])) {
    header("Location: manage_projects.php");
    exit();
}

$project_id = $_GET['id'];

try {
    // Optional: Delete the associated image file from the server
    $stmt = $pdo->prepare("SELECT main_image FROM projects WHERE id = ?");
    $stmt->execute([$project_id]);
    $project = $stmt->fetch();

    if ($project && !empty($project['main_image'])) {
        $image_path = '../' . $project['main_image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    // Delete the project record from the database
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$project_id]);

    header("Location: manage_projects.php?status=deleted");
    exit();

} catch (PDOException $e) {
    die("Could not delete project: " . $e->getMessage());
}
