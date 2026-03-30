<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : "Health & Wellness Dashboard"; ?></title>

    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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
<body class="d-flex flex-column min-vh-100" style="font-family: 'Inter', sans-serif;">

    <!-- Register Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top w-100" style="z-index: 1030; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div class="container-fluid px-2">
            <a class="navbar-brand d-flex align-items-center" href="register-dashboard.php">
                <img class="guest-nav-image" src="../images/logo.jpeg" style="height:40px; border-radius:8px; margin-right:10px;" alt="Logo"/>
                <span class="guest-navbar-heading font-weight-bold" style="font-size: 22px; color: #059669;">Health & Wellness</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto align-items-center">
                    <span class="mr-3 text-muted"><i class="fa-solid fa-bell"></i></span>
                    <a class="nav-link btn btn-success text-white px-4 py-2" style="border-radius: 8px;" href="../login.php">
                        <i class="fa-regular fa-user mr-2"></i>My Profile
                    </a>
                </div>
            </div>
        </div>
    </nav>

<!-- PAGE CONTENT -->
<main class="flex-fill d-flex flex-column">
    <?php
    if(isset($content)){
        echo $content;
    }
    ?>
</main>

<!-- Footer Section -->
<footer class="simple-footer mt-auto" style="background-color: #111827; color: #f9fafb; padding: 20px 0; text-align: center;">
    <div class="container footer-container">
        <h3 style="color: #10B981; font-weight: 700; font-size:18px; margin-bottom: 5px;">Health & Wellness</h3>
        <p class="mb-3 text-muted" style="font-size: 14px;">Stay Fit • Stay Healthy • Stay Strong</p>
        
        <div class="social-icons" style="margin-bottom: 10px;">
            <a href="#" class="text-muted mr-3"><i class="fa-brands fa-linkedin" style="font-size: 16px;"></i></a>
            <a href="#" class="text-muted"><i class="fa-brands fa-instagram" style="font-size: 16px;"></i></a>
        </div>
        
        <p class="copyright text-muted" style="font-size:12px; margin: 0; border-top: 1px solid #374151; padding-top: 10px; max-width: 300px; margin: 0 auto;">
            © <?php echo date("Y"); ?> Health & Wellness.
        </p>
    </div>
</footer>

</body>
</html>
