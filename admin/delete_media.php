<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) { die("Access denied."); }
if (!isset($_GET['id'])) { header("Location: manage_media.php"); exit(); }

$media_id = $_GET['id'];

// Get file path before deleting record
$stmt = $pdo->prepare("SELECT file_path FROM media WHERE id = ?");
$stmt->execute([$media_id]);
$media = $stmt->fetch();

if ($media) {
    // Delete physical file from server
    $file_on_server = '../' . $media['file_path'];
    if (file_exists($file_on_server)) {
        unlink($file_on_server);
    }

    // Delete record from database
    $stmt_delete = $pdo->prepare("DELETE FROM media WHERE id = ?");
    $stmt_delete->execute([$media_id]);
}

header("Location: manage_media.php?status=deleted");
exit();