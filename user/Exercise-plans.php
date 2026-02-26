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
    
    <link rel="stylesheet" href="Exercise-plans.css">
    
</head>
<body>

<div class="exercise-plan-container py-5">
    <div class="container">
        <div class="row">

            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 text-center">
                <div class="exercise-plan-card shadow">
                    <img src="../Exercise-Images/Beginner Fitness.jpg" class="img-fluid exercise-img">
                    <h3 class="exercise-plan-title mt-3">Beginner Fitness Plan</h3>
                    <p class="exercise-plan-description">
                        A simple and effective workout routine designed for beginners to improve stamina and flexibility.
                    </p>
                    <p class="exercise-plan-category">Level: Beginner</p>
                    <p class="exercise-plan-duration">Duration: 8 Weeks</p>
                    <p class="exercise-plan-price">₹ 1999</p>
                    <hr>
                    <button class="btn btn-success btn-block">Join Now</button>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 text-center">
                <div class="exercise-plan-card shadow">
                    <img src="../Exercise-Images/Weight loss fitness.jpg" class="img-fluid exercise-img">
                    <h3 class="exercise-plan-title mt-3">Weight Loss Program</h3>
                    <p class="exercise-plan-description">
                        Fat-burning cardio workouts combined with strength exercises to help you lose weight effectively.
                    </p>
                    <p class="exercise-plan-category">Goal: Weight Loss</p>
                    <p class="exercise-plan-duration">Duration: 12 Weeks</p>
                    <p class="exercise-plan-price">₹ 2499</p>
                    <hr>
                    <button class="btn btn-success btn-block">Join Now</button>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 text-center">
                <div class="exercise-plan-card shadow">
                    <img src="../Exercise-Images/muscle gain fitness.jpg" class="img-fluid exercise-img">
                    <h3 class="exercise-plan-title mt-3">Muscle Gain Program</h3>
                    <p class="exercise-plan-description">
                        Strength training routines focused on increasing muscle mass and improving overall strength.
                    </p>
                    <p class="exercise-plan-category">Goal: Muscle Building</p>
                    <p class="exercise-plan-duration">Duration: 16 Weeks</p>
                    <p class="exercise-plan-price">₹ 2999</p>
                    <hr>
                    <button class="btn btn-success btn-block">Join Now</button>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 text-center">
                <div class="exercise-plan-card shadow">
                    <img src="../Exercise-Images/HIIT Blast.jpg" class="img-fluid exercise-img">
                    <h3 class="exercise-plan-title mt-3">HIIT Blast Plan</h3>
                    <p class="exercise-plan-description">
                        High-Intensity Interval Training designed to burn maximum calories in minimum time.
                    </p>
                    <p class="exercise-plan-category">Level: Advanced</p>
                    <p class="exercise-plan-duration">Duration: 10 Weeks</p>
                    <p class="exercise-plan-price">₹ 2799</p>
                    <hr>
                    <button class="btn btn-success btn-block">Join Now</button>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 text-center">
                <div class="exercise-plan-card shadow">
                    <img src="../Exercise-Images/Beginner Fitness.jpg" class="img-fluid exercise-img">
                    <h3 class="exercise-plan-title mt-3">Strength & Conditioning</h3>
                    <p class="exercise-plan-description">
                        Improve endurance, core strength, and athletic performance with structured training.
                    </p>
                    <p class="exercise-plan-category">Level: Intermediate</p>
                    <p class="exercise-plan-duration">Duration: 14 Weeks</p>
                    <p class="exercise-plan-price">₹ 3199</p>
                    <hr>
                    <button class="btn btn-success btn-block">Join Now</button>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 text-center">
                <div class="exercise-plan-card shadow">
                    <img src="../Exercise-Images/Full Body Workout.jpg" class="img-fluid exercise-img">
                    <h3 class="exercise-plan-title mt-3">Full Body Workout</h3>
                    <p class="exercise-plan-description">
                        Balanced workouts targeting all major muscle groups for overall fitness.
                    </p>
                    <p class="exercise-plan-category">Goal: General Fitness</p>
                    <p class="exercise-plan-duration">Duration: 12 Weeks</p>
                    <p class="exercise-plan-price">₹ 2599</p>
                    <hr>
                    <button class="btn btn-success btn-block">Join Now</button>
                </div>
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