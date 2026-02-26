<?php
$title = "Plans";
$css = "register-dashboard.css"; 

ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health & Wellness</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
      crossorigin="anonymous"
    />
    <script
      src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
      integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
      integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
      integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
      crossorigin="anonymous"
    ></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="Sub-tips.css">
    
</head>
<body>

<div class="tips-page">
<div class="mb-4">
                <a href="javascript:history.back()" class="back-btn d-inline-flex align-items-center">
                    <span class="back-icon">
                        <i class="fa-solid fa-arrow-left"></i>
                    </span>
                    <span class="ml-2">Back</span>
                </a>
            </div>
    <div class="tips-title">
        <h2>SUBI Special Tips</h2>
        <p>Improve your lifestyle with smart daily habits</p>
    </div>

    <div class="tips-container">

        <!-- Card 1 -->
        <div class="tips-card">
            <div class="tips-icon">
                <i class="fas fa-glass-water"></i>
                <span class="badge">Nutrition</span>
            </div>
            <div class="tips-content">
                <h3>Hydration Boost</h3>
                <p>Drink 2-3 liters of water daily to improve metabolism and energy levels.</p>
                <a href="#" class="tips-btn">Learn More</a>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="tips-card">
            <div class="tips-icon">
                <i class="fas fa-dumbbell"></i>
                <span class="badge">Workout</span>
            </div>
            <div class="tips-content">
                <h3>Daily Exercise</h3>
                <p>30 minutes of daily exercise strengthens your heart and muscles.</p>
                <a href="#" class="tips-btn">Learn More</a>
            </div>
        </div>

        <!-- Featured Card -->
        <div class="tips-card featured">
            <div class="tips-icon">
                <i class="fas fa-bed"></i>
                <span class="badge">Recovery</span>
            </div>
            <div class="tips-content">
                <h3>Quality Sleep</h3>
                <p>Maintain 7-8 hours of sleep to enhance recovery and focus.</p>
                <a href="#" class="tips-btn">Start Now</a>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="tips-card">
            <div class="tips-icon">
                <i class="fas fa-apple-whole"></i>
                <span class="badge">Diet</span>
            </div>
            <div class="tips-content">
                <h3>Balanced Diet</h3>
                <p>Include proteins, carbs, and healthy fats in balanced proportions.</p>
                <a href="#" class="tips-btn">Learn More</a>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="tips-card">
            <div class="tips-icon">
                <i class="fas fa-chart-line"></i>
                <span class="badge">Tracking</span>
            </div>
            <div class="tips-content">
                <h3>Track Progress</h3>
                <p>Weekly tracking helps you stay consistent and motivated.</p>
                <a href="#" class="tips-btn">Learn More</a>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="tips-card">
            <div class="tips-icon">
                <i class="fas fa-brain"></i>
                <span class="badge">Mind</span>
            </div>
            <div class="tips-content">
                <h3>Mental Wellness</h3>
                <p>Practice meditation to reduce stress and improve concentration.</p>
                <a href="#" class="tips-btn">Learn More</a>
            </div>
        </div>

    </div>

</div>


     <script type="text/javascript" src="https://new-assets.ccbp.in/frontend/content/static-ccbp-ui-kit/static-ccbp-ui-kit.js"></script>
</body>
</html>

 
<?php
$content = ob_get_clean();
include("../includes/registered_layout.php");

?>
