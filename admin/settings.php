<?php
$page_title = 'Site Settings';
require_once 'partials/header.php';
require_once '../includes/db_connect.php';

// Fetch all settings from the database
try {
    $stmt = $pdo->query("SELECT * FROM settings");
    $settings_from_db = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    // If settings fail to load, create an empty array to prevent fatal errors
    $settings_from_db = [];
    echo '<div class="error-message">Could not load settings from the database. Please check your connection.</div>';
}


// Function to safely get a setting value
function get_setting_admin($key, $default = '') {
    global $settings_from_db;
    return isset($settings_from_db[$key]) ? htmlspecialchars($settings_from_db[$key]) : $default;
}
?>

<h1>Site Settings</h1>
<p>Manage the global settings for your website from here.</p>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div class="success-message">Settings saved successfully!</div>
<?php endif; ?>

<form action="settings_handler.php" method="POST" class="content-form">
    
    <h3>General Settings</h3>
    <div class="form-group">
        <label for="site_title">Site Title</label>
        <input type="text" id="site_title" name="site_title" value="<?php echo get_setting_admin('site_title'); ?>">
    </div>
    <div class="form-group">
        <label for="author_name">Author Name (for footer, etc.)</label>
        <input type="text" id="author_name" name="author_name" value="<?php echo get_setting_admin('author_name'); ?>">
    </div>
    <!-- v2.5.1 FIX: Added Logo Text field -->
    <div class="form-group">
        <label for="logo_text">Logo Text (for header)</label>
        <input type="text" id="logo_text" name="logo_text" value="<?php echo get_setting_admin('logo_text'); ?>">
        <small>This text will appear as the logo in the header.</small>
    </div>
    <div class="form-group">
        <label for="contact_email">Contact Form Email</label>
        <input type="email" id="contact_email" name="contact_email" value="<?php echo get_setting_admin('contact_email'); ?>">
        <small>The email address where contact form submissions will be sent.</small>
    </div>
    <div class="form-group">
        <label for="default_language">Default Language</label>
        <select id="default_language" name="default_language">
            <option value="en" <?php echo (get_setting_admin('default_language') == 'en') ? 'selected' : ''; ?>>English</option>
            <option value="bn" <?php echo (get_setting_admin('default_language') == 'bn') ? 'selected' : ''; ?>>Bengali</option>
        </select>
    </div>
    <div class="form-group">
        <label for="copyright_text">Footer Copyright Text</label>
        <input type="text" id="copyright_text" name="copyright_text" value="<?php echo get_setting_admin('copyright_text'); ?>">
    </div>

    <hr>

    <h3>Homepage Hero Section</h3>
    <div class="form-group">
        <label for="hero_subtitle">Hero Subtitle (e.g., Web Developer & Programmer)</label>
        <input type="text" id="hero_subtitle" name="hero_subtitle" value="<?php echo get_setting_admin('hero_subtitle'); ?>">
    </div>
    <div class="form-group">
        <label for="hero_description">Hero Description</label>
        <textarea id="hero_description" name="hero_description" rows="4"><?php echo get_setting_admin('hero_description'); ?></textarea>
    </div>
    <div class="form-group">
        <label for="hero_button_text">Hero Button Text (e.g., View My Work)</label>
        <input type="text" id="hero_button_text" name="hero_button_text" value="<?php echo get_setting_admin('hero_button_text'); ?>">
    </div>
    <div class="form-group">
        <label for="hero_button_url">Hero Button URL (e.g., projects.php)</label>
        <input type="text" id="hero_button_url" name="hero_button_url" value="<?php echo get_setting_admin('hero_button_url'); ?>">
    </div>

    <hr>

    <h3>Homepage Content</h3>
    <div class="form-group">
        <label>Select sections to show on the homepage:</label>
        <div class="checkbox-group">
            <input type="checkbox" id="show_recent_projects" name="show_recent_projects" value="1" <?php echo (get_setting_admin('show_recent_projects') == '1') ? 'checked' : ''; ?>>
            <label for="show_recent_projects">Show Recent Projects</label>
        </div>
        <div class="checkbox-group">
            <input type="checkbox" id="show_recent_research" name="show_recent_research" value="1" <?php echo (get_setting_admin('show_recent_research') == '1') ? 'checked' : ''; ?>>
            <label for="show_recent_research">Show Recent Research</label>
        </div>
        <div class="checkbox-group">
            <input type="checkbox" id="show_recent_books" name="show_recent_books" value="1" <?php echo (get_setting_admin('show_recent_books') == '1') ? 'checked' : ''; ?>>
            <label for="show_recent_books">Show Recent Books</label>
        </div>
    </div>
    <div class="form-group">
        <label for="site_categories">Site Categories</label>
        <textarea id="site_categories" name="site_categories" rows="4"><?php echo get_setting_admin('site_categories'); ?></textarea>
        <small>Enter categories separated by a comma (e.g., Project,Research,Book,PHP). These will appear in the filter buttons.</small>
    </div>
    
    <hr>

    <h3>Social Links</h3>
    <div class="form-group">
        <label for="github_url">GitHub URL</label>
        <input type="url" id="github_url" name="github_url" value="<?php echo get_setting_admin('github_url'); ?>">
    </div>
    <div class="form-group">
        <label for="linkedin_url">LinkedIn URL</label>
        <input type="url" id="linkedin_url" name="linkedin_url" value="<?php echo get_setting_admin('linkedin_url'); ?>">
    </div>
    <div class="form-group">
        <label for="twitter_url">Twitter URL</label>
        <input type="url" id="twitter_url" name="twitter_url" value="<?php echo get_setting_admin('twitter_url'); ?>">
    </div>


    <button type="submit" class="btn">Save Settings</button>
</form>

<?php require_once 'partials/footer.php'; ?>