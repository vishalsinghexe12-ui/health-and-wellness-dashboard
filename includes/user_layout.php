<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : "Health & Wellness"; ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
<body  class="d-flex flex-column min-vh-100">


    <!-- Register Navigation Bar -->
    <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <a class="navbar-brand" href="#"><img class="guest-nav-image" src="../images/logo.jpeg"/><span class="guest-navbar-heading pt-5">Health & Wellness</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                <a class="nav-link active mr-3" id="gnavitem1" href="#">Dashboard <span class="sr-only">(current)</span></a>
                <a class="nav-link mr-3" id="gnavitem2" href="#">Manage Plans</a>
                <a class="nav-link mr-3" id="gnavitem3" href="#">Workout Library</a>
                <a class="nav-link mr-3" id="gnavitem4" href="#">Support</a>
                <a class="nav-link bg-success mr-3 text-white" id="gnavitem6" href="../login.php">Logout</a>
                </div>
            </div>
            </nav>
    </div>



<!-- PAGE CONTENT -->
<main class="flex-fill">
        <?php
        if(isset($content)){
            echo $content;
        }
        ?>
</main>

<!-- Footer Section -->
<footer class="simple-footer mt-auto">
    <div class="footer-container d-flex justify-content-between align-items-center">

        <span class="copyright mb-0">
            © <?php echo date("Y"); ?> Health & Wellness
        </span>

        <span class="mb-0">
            Logged in as User
        </span>

    </div>
</footer>

</body>
</html>

