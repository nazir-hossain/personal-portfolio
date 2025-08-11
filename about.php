<?php 
require_once 'includes/init.php'; 
$pageTitle = $lang_pack['page_title_about'];
require_once 'includes/header.php'; 
?>

<section class="content-section reveal-on-scroll">
    <div class="project-body">
        <?php echo get_setting('about_content_' . $lang); ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
