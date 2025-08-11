<?php
session_start();
require_once '../includes/db_connect.php';

// ... (Login check) ...

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Prepare an array of all possible settings from the form
    $settings_to_update = [
        'site_title' => $_POST['site_title'] ?? '',
        'author_name' => $_POST['author_name'] ?? '',
        'contact_email' => $_POST['contact_email'] ?? '',
        'default_language' => $_POST['default_language'] ?? 'en',
        'copyright_text' => $_POST['copyright_text'] ?? '',
        
        // v2.4: New hero settings
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

    // ... (Database update logic remains the same) ...

} else {
    header("Location: settings.php");
    exit();
}