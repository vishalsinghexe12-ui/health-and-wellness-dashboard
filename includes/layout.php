<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : "Health & Wellness"; ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Page CSS -->
    <?php
    if(isset($css)){
        echo '<link rel="stylesheet" href="'.$css.'">';
    }
    ?>

</head>
<body>

<!-- NAVBAR -->
<div class="container-fluid p-0 sticky-top" style="z-index: 1030; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="guest.php">
                <img class="guest-nav-image" src="images/logo.jpeg" alt="Logo" style="height:48px; width:auto; border-radius:8px; margin-right:12px;"/>
                <span class="guest-navbar-heading" style="font-weight: 800; font-size: 26px; background: linear-gradient(135deg, #047857, #10b981); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Health & Wellness</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                    <a class="nav-link active" href="guest.php">Home</a>
                    <a class="nav-link" href="about.php">About Us</a>
                    <a class="nav-link" href="plans.php">Plans</a>
                    <a class="nav-link" href="gallery.php">Gallery</a>
                    <a class="nav-link" href="contact.php">Contact Us</a>
                    <a class="nav-link bg-success text-white ml-2 px-4" href="login.php" style="border-radius: 12px; font-weight: 600; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">Login</a>
                </div>
            </div>
        </div>
    </nav>
</div>


<!-- PAGE CONTENT -->
<main>
<?php
if(isset($content)){
    echo $content;
}
?>
</main>


<!--Footer Section -->
<footer class="simple-footer" style="background: linear-gradient(to right, #111827, #1f2937); color: #f9fafb; padding: 60px 0 30px 0; margin-top: 80px; text-align: center;">
    <div class="container footer-container">
        <h3 style="font-weight: 800; font-size: 26px; background: linear-gradient(135deg, #10b981, #0d9488); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 15px;">Health & Wellness</h3>
        <p class="mb-4 text-muted" style="color: #9ca3af !important; font-size: 16px;">Stay Fit • Stay Healthy • Stay Strong</p>
        
        <div class="social-icons" style="display: flex; justify-content: center; align-items: center; gap: 24px; margin-bottom: 30px;">
            <a href="#" style="color: #9ca3af; text-decoration: none; font-size: 20px;"><i class="fa-brands fa-linkedin"></i></a>
            <a href="#" style="color: #9ca3af; text-decoration: none; font-size: 20px;"><i class="fa-brands fa-instagram"></i></a>
        </div>

        <p class="copyright" style="font-size: 14px; color: #6b7280; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 25px; max-width: 500px; margin: 0 auto;">
            © <?php echo date("Y"); ?> Health & Wellness. All Rights Reserved.
        </p>

    </div>
</footer>

</body>
</html>
