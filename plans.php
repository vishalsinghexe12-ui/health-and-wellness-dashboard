<?php
$title = "Plans - Health & Wellness";
$css = "guest.css"; 

ob_start();
?>

<div class="guest-plans-container py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-5 text-center">
                <h1 class="guest-bottom-heading">Our Wellness Plans</h1>
                <hr class="heading-hr mx-auto">
            </div>
            
            <!-- Plan 1 -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="plan-card text-center">
                    <img src="images/beautiful-girls-are-playing-yoga-park.jpg" class="w-100 plan-img" alt="Beginner Plan"/>
                    <h2 class="guest-card-heading">Beginner Plan</h2>
                    <p class="guest-card-paragraph mt-3">Basic Yoga &bull; 10 Min Daily Exercise &bull; Water tracking</p>
                    <p class="guest-card-paragraph text-primary font-weight-bold">Duration: 4 Weeks</p>
                    <p class="guest-card-paragraph mb-4">Goal: Build healthy habits</p>
                    <button class="get-started-button">Start Plan</button>
                </div>
            </div>

            <!-- Plan 2 -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="plan-card text-center">
                    <img src="images/Guest-Img-5.jpeg" class="w-100 plan-img" alt="Fitness Plan"/>
                    <h2 class="guest-card-heading">Fitness Plan</h2>
                    <p class="guest-card-paragraph mt-3">Strength Training &bull; Daily step tracking &bull; Workout Schedule</p>
                    <p class="guest-card-paragraph text-primary font-weight-bold">Duration: 8 Weeks</p>
                    <p class="guest-card-paragraph mb-4">Goal: Improve Strength</p>
                    <button class="get-started-button">Start Plan</button>
                </div>
            </div>
            
            <!-- Plan 3 -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="plan-card text-center">
                    <img src="images/vegetable-image.jpeg" class="w-100 plan-img" alt="Diet Plan"/>
                    <h2 class="guest-card-heading">Diet Plan</h2>
                    <p class="guest-card-paragraph mt-3">Healthy Meals &bull; Water goals &bull; Nutrition tips</p>
                    <p class="guest-card-paragraph text-primary font-weight-bold">Duration: 4 Weeks</p>
                    <p class="guest-card-paragraph mb-4">Goal: Improve Nutrition</p>
                    <button class="get-started-button">Start Plan</button>
                </div>
            </div>

            <!-- Plan 4 -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="plan-card text-center">
                    <img src="images/woman-lotus-pose-park.jpg" class="w-100 plan-img" alt="Mental Wellness"/>
                    <h2 class="guest-card-heading">Mental Wellness Plan</h2>
                    <p class="guest-card-paragraph mt-3">Meditation &bull; Sleep tracking &bull; Stress Management</p>
                    <p class="guest-card-paragraph text-primary font-weight-bold">Duration: 6 Weeks</p>
                    <p class="guest-card-paragraph mb-4">Goal: Reduce stress</p>
                    <button class="get-started-button">Start Plan</button>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
