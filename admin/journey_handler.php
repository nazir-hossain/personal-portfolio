<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    die("Access denied.");
}

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $params = [
        ':type' => $_POST['type'],
        ':title_en' => $_POST['title_en'],
        ':title_bn' => $_POST['title_bn'],
        ':short_desc_en' => $_POST['short_desc_en'],
        ':short_desc_bn' => $_POST['short_desc_bn'],
        ':what_i_learned_en' => $_POST['what_i_learned_en'],
        ':what_i_learned_bn' => $_POST['what_i_learned_bn'],
        ':rating' => (int)$_POST['rating'],
        ':recommendation_en' => $_POST['recommendation_en'],
        ':recommendation_bn' => $_POST['recommendation_bn'],
        ':certificate_url' => $_POST['certificate_url'],
        ':main_image' => $_POST['main_image'],
    ];

    if ($action === 'add') {
        $sql = "INSERT INTO learning_journey (type, title_en, title_bn, short_desc_en, short_desc_bn, what_i_learned_en, what_i_learned_bn, rating, recommendation_en, recommendation_bn, certificate_url, main_image) 
                VALUES (:type, :title_en, :title_bn, :short_desc_en, :short_desc_bn, :what_i_learned_en, :what_i_learned_bn, :rating, :recommendation_en, :recommendation_bn, :certificate_url, :main_image)";
        $redirect_status = 'added';
    } elseif ($action === 'edit' && isset($_POST['journey_id'])) {
        $sql = "UPDATE learning_journey SET type = :type, title_en = :title_en, title_bn = :title_bn, short_desc_en = :short_desc_en, short_desc_bn = :short_desc_bn, what_i_learned_en = :what_i_learned_en, what_i_learned_bn = :what_i_learned_bn, rating = :rating, recommendation_en = :recommendation_en, recommendation_bn = :recommendation_bn, certificate_url = :certificate_url, main_image = :main_image WHERE id = :id";
        $params[':id'] = $_POST['journey_id'];
        $redirect_status = 'updated';
    } else {
        header("Location: manage_journeys.php");
        exit();
    }

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        header("Location: manage_journeys.php?status=$redirect_status");
        exit();
    } catch (PDOException $e) {
        die("Database operation failed: " . $e->getMessage());
    }
}
// For delete action (GET request)
elseif ($_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM learning_journey WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_journeys.php?status=deleted");
    exit();
}

header("Location: manage_journeys.php");
exit();