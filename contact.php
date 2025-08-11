<?php 
require_once 'includes/init.php'; 
$pageTitle = $lang_pack['page_title_contact'];
require_once 'includes/header.php'; 
?>

<section class="content-section reveal-on-scroll">
    <h1><?php echo $lang_pack['contact_title']; ?></h1>
    <p><?php echo $lang_pack['contact_description']; ?></p>
    
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'success'): ?>
            <div class="status-message success">
                Thank you for your message! I will get back to you shortly.
            </div>
        <?php else: ?>
            <div class="status-message error">
                Sorry, something went wrong. Please try again later.
            </div>
        <?php endif; ?>
    <?php endif; ?>


    <form id="contact-form" action="contact/form-handler.php" method="POST">
        <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Your Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" required>
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="6" required></textarea>
        </div>
        <button type="submit" class="cta-button">Send Message</button>
    </form>

</section>

<?php include 'includes/footer.php'; ?>

