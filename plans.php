<?php
$title = "Plans";
$css = "guest.css"; 

ob_start();
?>


  
        <div class="guest-plans-container mb-5 bg-light mt-3">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-3">
                        <h1 class="guest-bottom-heading">Plans</h1>
                        <hr>
                    </div>
                    

                <!-- Plan 1 -->
                    <div class="col-6 mb-3">
                        <div class="plan-card shadow p-3 text-center">
                            <img src="images/beautiful-girls-are-playing-yoga-park.jpg" class="w-100 plan-img"/>
                            <h1 class="guest-card-heading mt-3">Beginner Plan</h1>
                            <p class="guest-card-paragraph pl-3 pr-3 mt-3">Basic Yoga<br>10 Min Daily Exercise<br>Water tracking</p>
                            <p class="guest-card-paragraph">Duration: 4 Weeks</p>
                            <p class="guest-card-paragraph">Goal: Build healthy habits</p>
                            <button class="get-started-button shadow-lg">Start Plan</button>
                        </div>
                    </div>

                <!-- Plan 2 -->
                    <div class="col-6">
                        <div class="plan-card shadow p-3 text-center">
                            <img src="images/Guest-Img-5.jpeg" class="w-100 plan-img"/>
                            <h1 class="guest-card-heading mt-3">Fitness Plan</h1>
                            <p class="guest-card-paragraph mt-3">Strength Training<br>Daily step tracking<br>Workout Shedule</p>
                            <p class="guest-card-paragraph">Duration: 8 Weeks</p>
                            <p class="guest-card-paragraph">Goal :Improve Strength</p></p>
                            <button class="get-started-button shadow-lg">Start Plan</button>
                        </div>
                    </div>
                    
                <!-- Plan 3 -->
                    <div class="col-6">
                        <div class="plan-card shadow p-3 text-center">
                            <img src="images/vegetable-image.jpeg" class="w-100 plan-img"/>
                            <h1 class="guest-card-heading mt-3">Diet Plan</h1>
                            <p class="guest-card-paragraph mt-3">Healthy Meal Suggestions<br>Water intake goals<br>Nutrition tips</p>
                            <p class="guest-card-paragraph">Duration: 4 Weeks</p>
                            <p>Goal : Improve Nutrition</p>
                            <button class="get-started-button shadow-lg">Start Plan</button>
                        </div>
                    </div>


                <!-- Plan 4 -->
                    <div class="col-6">
                        <div class="plan-card shadow p-3 text-center">
                            <img src="images/woman-lotus-pose-park.jpg" class="w-100 plan-img"/>
                            <h1 class="guest-card-heading mt-3">Mental Wellness Plan</h1>
                            <p class="guest-card-paragraph mt-3">Meditation<br>Sleep tracking<br>Stress Management tips</p>
                            <p class="guest-card-paragraph">Duration: 6 Weeks</p>
                            <p class="guest-card-paragraph">Goal: Reduce stress</p>
                            <button class="get-started-button shadow-lg">Start Plan</button>
                        </div>
                    </div>

                <button class="get-started-button shadow-lg mt-3 ml-3" onclick="location.href='guest.php'">Back to Home</button>
                </div>
            </div>
        </div>
   


     <script type="text/javascript" src="https://new-assets.ccbp.in/frontend/content/static-ccbp-ui-kit/static-ccbp-ui-kit.js"></script>


<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
