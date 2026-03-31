<?php
$title = "Plans";
$css = "admin.css"; 
ob_start();
?>

<div class="exercise-plan-container py-5">
    <div class="container">
        <div class="mb-4">
            <a href="javascript:history.back()" class="back-btn d-inline-flex align-items-center">
                <span class="back-icon">
                    <i class="fa-solid fa-arrow-left"></i>
                </span>
                <span class="ml-2">Back</span>
            </a>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="font-weight-bold">Exercise Plans</h3>
            <a href="add-plans.php" class="btn btn-success">+ Add New Plan</a>
        </div>
        
        <div class="row">

            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="exercise-plan-card shadow w-100 d-flex flex-column text-center">
                    <img src="../Exercise-Images/Beginner Fitness.jpg" class="img-fluid exercise-img">
                    <h3 class="exercise-plan-title mt-3">Beginner Fitness Plan</h3>
                    <p class="exercise-plan-description">
                        A simple and effective workout routine designed for beginners to improve stamina and flexibility.
                    </p>
                    <p class="exercise-plan-category"><strong>Level:</strong> Beginner</p>
                    <p class="exercise-plan-duration"><strong>Duration:</strong> 8 Weeks</p>
                    <p class="exercise-plan-price font-weight-bold">₹ 1999</p>
                    <hr>
                    <button class="btn btn-success btn-block mt-auto">Join Now</button>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="exercise-plan-card shadow w-100 d-flex flex-column text-center">
                    <img src="../Exercise-Images/Weight loss fitness.jpg" class="img-fluid exercise-img">
                    <h3 class="exercise-plan-title mt-3">Weight Loss Program</h3>
                    <p class="exercise-plan-description">
                        Fat-burning cardio workouts combined with strength exercises to help you lose weight effectively.
                    </p>
                    <p class="exercise-plan-category"><strong>Goal:</strong> Weight Loss</p>
                    <p class="exercise-plan-duration"><strong>Duration:</strong> 12 Weeks</p>
                    <p class="exercise-plan-price font-weight-bold">₹ 2499</p>
                    <hr>
                    <button class="btn btn-success btn-block mt-auto">Join Now</button>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="exercise-plan-card shadow w-100 d-flex flex-column text-center">
                    <img src="../Exercise-Images/muscle gain fitness.jpg" class="img-fluid exercise-img">
                    <h3 class="exercise-plan-title mt-3">Muscle Gain Program</h3>
                    <p class="exercise-plan-description">
                        Strength training routines focused on increasing muscle mass and improving overall strength.
                    </p>
                    <p class="exercise-plan-category"><strong>Goal:</strong> Muscle Building</p>
                    <p class="exercise-plan-duration"><strong>Duration:</strong> 16 Weeks</p>
                    <p class="exercise-plan-price font-weight-bold">₹ 2999</p>
                    <hr>
                    <button class="btn btn-success btn-block mt-auto">Join Now</button>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="exercise-plan-card shadow w-100 d-flex flex-column text-center">
                    <img src="../Exercise-Images/HIIT Blast.jpg" class="img-fluid exercise-img">
                    <h3 class="exercise-plan-title mt-3">HIIT Blast Plan</h3>
                    <p class="exercise-plan-description">
                        High-Intensity Interval Training designed to burn maximum calories in minimum time.
                    </p>
                    <p class="exercise-plan-category"><strong>Level:</strong> Advanced</p>
                    <p class="exercise-plan-duration"><strong>Duration:</strong> 10 Weeks</p>
                    <p class="exercise-plan-price font-weight-bold">₹ 2799</p>
                    <hr>
                    <button class="btn btn-success btn-block mt-auto">Join Now</button>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="exercise-plan-card shadow w-100 d-flex flex-column text-center">
                    <img src="../Exercise-Images/Beginner Fitness.jpg" class="img-fluid exercise-img">
                    <h3 class="exercise-plan-title mt-3">Strength & Conditioning</h3>
                    <p class="exercise-plan-description">
                        Improve endurance, core strength, and athletic performance with structured training.
                    </p>
                    <p class="exercise-plan-category"><strong>Level:</strong> Intermediate</p>
                    <p class="exercise-plan-duration"><strong>Duration:</strong> 14 Weeks</p>
                    <p class="exercise-plan-price font-weight-bold">₹ 3199</p>
                    <hr>
                    <button class="btn btn-success btn-block mt-auto">Join Now</button>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="exercise-plan-card shadow w-100 d-flex flex-column text-center">
                    <img src="../Exercise-Images/Full Body Workout.jpg" class="img-fluid exercise-img">
                    <h3 class="exercise-plan-title mt-3">Full Body Workout</h3>
                    <p class="exercise-plan-description">
                        Balanced workouts targeting all major muscle groups for overall fitness.
                    </p>
                    <p class="exercise-plan-category"><strong>Goal:</strong> General Fitness</p>
                    <p class="exercise-plan-duration"><strong>Duration:</strong> 12 Weeks</p>
                    <p class="exercise-plan-price font-weight-bold">₹ 2599</p>
                    <hr>
                    <button class="btn btn-success btn-block mt-auto">Join Now</button>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>