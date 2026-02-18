<?php
$title = "Plans";
$css = "guest.css"; 

ob_start();
?>

<!--Guest Gallery Section -->
    <div id="section-Gallery">
        <div class="guest-gallery-container mb-5 bg-white mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-3 ">
                        <h1 class="guest-bottom-heading">Gallery</h1>
                        <hr>
                    </div>

                    <div class="col-3 mb-3 shadow p-2">
                        <img src="images/Guest-Img-1.jpeg" class="w-100"/>
                        <h1 class="guest-card-heading text-center mt-2">Morning Meditation</h1>
                    </div>

                    <div class="col-3 mb-3 shadow p-2">
                        <img src="images/fruit-image.jpeg" class="w-100"/>
                        <h1 class="guest-card-heading text-center mt-2">Balanced Nutrition Bowl</h1>
                    </div>

                    <div class="col-3 mb-3 shadow p-2">
                        <img src="Images/Guest-Img-2.jpeg" class="w-100"/>
                        <h1 class="guest-card-heading text-center mt-2">Daily Hydration</h1>
                    </div>

                    <div class="col-3 mb-3 shadow p-2">
                        <img src="Images/manage-stress.jpeg" class="w-100"/>
                        <h1 class="guest-card-heading text-center mt-2">Managing Stress</h1>
                    </div>

                    <div class="col-3 mb-3 shadow p-2 mt-3">
                        <img src="Images/Guest-Img-4.jpeg" class="w-100"/>
                        <h1 class="guest-card-heading text-center mt-2">Active Lifestyle</h1>
                    </div>

                    <div class="col-3 mb-3 shadow p-2 mt-3">
                        <img src="Images/bottle-water-plank-park.jpg" class="w-100"/>
                        <h1 class="guest-card-heading text-center mt-2">Stay Hydrated</h1>
                    </div>

                    <div class="col-3 mb-3 shadow p-2 mt-3">
                        <img src="Images/Guest-Img-6.jpeg" class="w-100"/>
                        <h1 class="guest-card-heading text-center mt-2">Morning Stretch Routine</h1>
                    </div>

                    <div class="col-3 mb-3 shadow p-2 mt-3">
                        <img src="Images/Guest-Img-7.jpeg" class="w-100"/>
                        <h1 class="guest-card-heading text-center mt-2 ">Clean Eating Meal Prep</h1>
                    </div>

                <button class="get-started-button shadow-lg mt-3" onclick="location.href='guest.php' ">Back to Home</button>
                </div>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
