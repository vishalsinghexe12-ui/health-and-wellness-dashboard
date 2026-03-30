<?php
$title = "Gallery - Health & Wellness";
$css = "guest.css"; 

ob_start();
?>

<div id="section-Gallery" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-5 text-center">
                <h1 class="guest-bottom-heading">Gallery</h1>
                <hr class="heading-hr mx-auto">
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card p-2 border-0">
                    <img src="images/Guest-Img-1.jpeg" class="w-100 rounded" alt="Morning Meditation"/>
                    <h3 class="guest-card-heading text-center mt-3" style="font-size: 1.1rem;">Morning Meditation</h3>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card p-2 border-0">
                    <img src="images/fruit-image.jpeg" class="w-100 rounded" alt="Balanced Nutrition Bowl"/>
                    <h3 class="guest-card-heading text-center mt-3" style="font-size: 1.1rem;">Balanced Nutrition Bowl</h3>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card p-2 border-0">
                    <img src="Images/Guest-Img-2.jpeg" class="w-100 rounded" alt="Daily Hydration"/>
                    <h3 class="guest-card-heading text-center mt-3" style="font-size: 1.1rem;">Daily Hydration</h3>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card p-2 border-0">
                    <img src="Images/manage-stress.jpeg" class="w-100 rounded" alt="Managing Stress"/>
                    <h3 class="guest-card-heading text-center mt-3" style="font-size: 1.1rem;">Managing Stress</h3>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card p-2 border-0">
                    <img src="Images/Guest-Img-4.jpeg" class="w-100 rounded" alt="Active Lifestyle"/>
                    <h3 class="guest-card-heading text-center mt-3" style="font-size: 1.1rem;">Active Lifestyle</h3>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card p-2 border-0">
                    <img src="Images/bottle-water-plank-park.jpg" class="w-100 rounded" alt="Stay Hydrated"/>
                    <h3 class="guest-card-heading text-center mt-3" style="font-size: 1.1rem;">Stay Hydrated</h3>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card p-2 border-0">
                    <img src="Images/Guest-Img-6.jpeg" class="w-100 rounded" alt="Morning Stretch Routine"/>
                    <h3 class="guest-card-heading text-center mt-3" style="font-size: 1.1rem;">Morning Stretch Routine</h3>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card p-2 border-0">
                    <img src="Images/Guest-Img-7.jpeg" class="w-100 rounded" alt="Clean Eating Meal Prep"/>
                    <h3 class="guest-card-heading text-center mt-3" style="font-size: 1.1rem;">Clean Eating Meal Prep</h3>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
