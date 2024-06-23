<!-- template.php -->
<!DOCTYPE html>
<html>
<head>
    <title>My Website</title>
</head>
<body>
    <?php $this->load->view('partials/nav'); ?>
    
    <div class="content">
        <?php echo $content; ?>
    </div>
    
    <?php $this->load->view('partials/sidebar'); ?>
    
    <footer>
        &copy; <?php echo date('Y'); ?> My Website
    </footer>
</body>
</html>
