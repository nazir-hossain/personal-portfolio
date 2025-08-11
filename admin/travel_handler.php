<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    die("Access denied.");
}

// Function to generate a URL-friendly slug
function generateSlug($text) {
    // Convert to lowercase
    $text = strtolower($text);
    // Replace non-letter or digits with -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // Transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // Remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // Trim
    $text = trim($text, '-');
    // Remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // Check if empty
    if (empty($text)) {
        return 'n-a-' . time();
    }
    return $text;
}

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $params = [
        ':title_en' => $_POST['title_en'],
        ':title_bn' => $_POST['title_bn'],
        ':content_en' => $_POST['content_en'],
        ':content_bn' => $_POST['content_bn'],
        ':excerpt_en' => $_POST['excerpt_en'],
        ':excerpt_bn' => $_POST['excerpt_bn'],
        ':country_name' => $_POST['country_name'],
        ':category' => $_POST['category'],
        ':tags' => $_POST['tags'],
        ':featured_image' => $_POST['featured_image'],
        ':published_at' => $_POST['published_at']
    ];

    if ($action === 'add') {
        $slug = generateSlug($_POST['title_en']);
        // Ensure slug is unique
        $stmt_check = $pdo->prepare("SELECT id FROM travel_journal WHERE slug = ?");
        $stmt_check->execute([$slug]);
        if($stmt_check->rowCount() > 0) {
            $slug = $slug . '-' . time(); // Append timestamp to make it unique
        }
        $params[':slug'] = $slug;

        $sql = "INSERT INTO travel_journal (slug, title_en, title_bn, content_en, content_bn, excerpt_en, excerpt_bn, country_name, category, tags, featured_image, published_at) 
                VALUES (:slug, :title_en, :title_bn, :content_en, :content_bn, :excerpt_en, :excerpt_bn, :country_name, :category, :tags, :featured_image, :published_at)";
        $redirect_status = 'added';
    } 
    elseif ($action === 'edit' && isset($_POST['post_id'])) {
        $params[':id'] = $_POST['post_id'];
        $sql = "UPDATE travel_journal SET title_en = :title_en, title_bn = :title_bn, content_en = :content_en, content_bn = :content_bn, excerpt_en = :excerpt_en, excerpt_bn = :excerpt_bn, country_name = :country_name, category = :category, tags = :tags, featured_image = :featured_image, published_at = :published_at WHERE id = :id";
        $redirect_status = 'updated';
    } 
    else {
        header("Location: manage_travels.php");
        exit();
    }

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        header("Location: manage_travels.php?status=$redirect_status");
        exit();
    } catch (PDOException $e) {
        die("Database operation failed: " . $e->getMessage());
    }
}
elseif ($_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM travel_journal WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_travels.php?status=deleted");
    exit();
}

header("Location: manage_travels.php");
exit();