<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    die("Access denied.");
}

$action = $_GET['action'] ?? 'update_main';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    try {
        $pdo->beginTransaction();

        if ($action === 'update_about') {
            $settings_to_update = [
                'about_content_en' => $_POST['about_content_en'] ?? '',
                'about_content_bn' => $_POST['about_content_bn'] ?? '',
            ];
            $redirect_url = "manage_page_about.php?status=success";
        } else { // Default action is 'update_main'
            $settings_to_update = [
                'site_title' => $_POST['site_title'] ?? '',
                'author_name' => $_POST['author_name'] ?? '',
                'logo_text' => $_POST['logo_text'] ?? '',
                'contact_email' => $_POST['contact_email'] ?? '',
                'default_language' => $_POST['default_language'] ?? 'en',
                'copyright_text' => $_POST['copyright_text'] ?? '',
                'hero_subtitle' => $_POST['hero_subtitle'] ?? '',
                'hero_description' => $_POST['hero_description'] ?? '',
                'hero_button_text' => $_POST['hero_button_text'] ?? '',
                'hero_button_url' => $_POST['hero_button_url'] ?? '',
                'show_recent_projects' => isset($_POST['show_recent_projects']) ? '1' : '0',
                'show_recent_research' => isset($_POST['show_recent_research']) ? '1' : '0',
                'show_recent_books' => isset($_POST['show_recent_books']) ? '1' : '0',
                'site_categories' => $_POST['site_categories'] ?? '',
                'github_url' => $_POST['github_url'] ?? '',
                'linkedin_url' => $_POST['linkedin_url'] ?? '',
                'twitter_url' => $_POST['twitter_url'] ?? ''
            ];
            $redirect_url = "settings.php?status=success";
        }
        
        $stmt = $pdo->prepare("UPDATE settings SET setting_value = :value WHERE setting_key = :key");

        foreach ($settings_to_update as $key => $value) {
            $stmt->execute([':value' => $value, ':key' => $key]);
        }

        $pdo->commit();
        header("Location: " . $redirect_url);
        exit();

    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Could not save settings: " . $e->getMessage());
    }
} else {
    header("Location: settings.php");
    exit();
}