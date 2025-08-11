<?php
session_start();
require_once '../includes/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    die("Access denied.");
}

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // --- ADD ACTION ---
    if ($action === 'add') {
        
        $sql = "INSERT INTO projects (title_en, title_bn, category, short_desc_en, short_desc_bn, long_desc_en, long_desc_bn, technologies, main_image, live_link, source_code, download_file) 
                VALUES (:title_en, :title_bn, :category, :short_desc_en, :short_desc_bn, :long_desc_en, :long_desc_bn, :technologies, :main_image, :live_link, :source_code, :download_file)";
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':title_en' => $_POST['title_en'],
                ':title_bn' => $_POST['title_bn'],
                ':category' => $_POST['category'],
                ':short_desc_en' => $_POST['short_desc_en'],
                ':short_desc_bn' => $_POST['short_desc_bn'],
                ':long_desc_en' => $_POST['long_desc_en'],
                ':long_desc_bn' => $_POST['long_desc_bn'],
                ':technologies' => $_POST['technologies'],
                ':main_image' => !empty($_POST['main_image']) ? filter_var($_POST['main_image'], FILTER_SANITIZE_URL) : null,
                ':live_link' => $_POST['live_link'],
                ':source_code' => $_POST['source_code'],
                ':download_file' => $_POST['download_file'],
            ]);

            header("Location: manage_projects.php?status=added");
            exit();
        } catch (PDOException $e) {
            die("Could not add project: " . $e->getMessage());
        }
    }

    // --- EDIT ACTION ---
    elseif ($action === 'edit') {
        $project_id = $_POST['project_id'];

        $sql = "UPDATE projects SET 
                    title_en = :title_en, 
                    title_bn = :title_bn, 
                    category = :category, 
                    short_desc_en = :short_desc_en, 
                    short_desc_bn = :short_desc_bn, 
                    long_desc_en = :long_desc_en, 
                    long_desc_bn = :long_desc_bn, 
                    technologies = :technologies, 
                    main_image = :main_image,
                    live_link = :live_link, 
                    source_code = :source_code, 
                    download_file = :download_file
                WHERE id = :id";
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':title_en' => $_POST['title_en'],
                ':title_bn' => $_POST['title_bn'],
                ':category' => $_POST['category'],
                ':short_desc_en' => $_POST['short_desc_en'],
                ':short_desc_bn' => $_POST['short_desc_bn'],
                ':long_desc_en' => $_POST['long_desc_en'],
                ':long_desc_bn' => $_POST['long_desc_bn'],
                ':technologies' => $_POST['technologies'],
                ':main_image' => !empty($_POST['main_image']) ? filter_var($_POST['main_image'], FILTER_SANITIZE_URL) : null,
                ':live_link' => $_POST['live_link'],
                ':source_code' => $_POST['source_code'],
                ':download_file' => $_POST['download_file'],
                ':id' => $project_id
            ]);

            header("Location: manage_projects.php?status=updated");
            exit();
        } catch (PDOException $e) {
            die("Could not update project: " . $e->getMessage());
        }
    }
}

// If no action matched or not a POST request, redirect
header("Location: manage_projects.php");
exit();
