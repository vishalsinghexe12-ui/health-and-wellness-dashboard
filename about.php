<?php
$title = "About Us - Health & Wellness";
$css = "guest.css";

ob_start();
?>

<div class="container mt-5 mb-5">

    <!-- Heading -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 font-weight-bold text-success">About Health & Wellness</h1>
            <p class="lead text-muted">Empowering healthier lifestyles every day</p>
        </div>
    </div>


    <!-- Our Story and Mission -->
    <div class="row mb-5">

        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body p-4">
                    <h2 class="font-weight-bold mb-3 text-success">Our Story</h2>

                    <p class="text-muted">
                        Health & Wellness was created to help individuals take control of their physical and mental well-being. 
                        In today's fast-paced world, maintaining a healthy lifestyle can be challenging, and our platform 
                        provides the tools and guidance needed to stay on track.
                    </p>

                    <p class="text-muted">
                        We believe that small daily habits can lead to significant long-term improvements. Our goal is to 
                        make health tracking simple, accessible, and effective for everyone.
                    </p>
                </div>
            </div>
        </div>


        <!--Mission -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body p-4">
                    <h2 class="font-weight-bold mb-3 text-success">
                        Our Mission
                    </h2>
                    <div class="mb-3">
                        <h5 class="font-weight-bold">
                            Promote Healthy Habits
                        </h5>
                        <p class="text-muted">
                            Encourage regular exercise, proper nutrition, and hydration.
                        </p>

                    </div>

                    <div class="mb-3">
                        <h5 class="font-weight-bold">Track Wellness Progress </h5>
                        <p class="text-muted">Help users monitor sleep, exercise, and daily health activities. </p>

                    </div>

                    <div>
                        <h5 class="font-weight-bold">Support Mental Well-being </h5>

                        <p class="text-muted">Promote stress management and balanced living.</p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Our Features -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow text-center p-5 bg-success text-white">
                <h2 class="font-weight-bold mb-4">
                    What We Offer
                </h2>
                <div class="row">
                    <div class="col-md-4">
                        <h5 class="font-weight-bold">
                            Health Tracking
                        </h5>
                        <p>
                            Track water intake, sleep, and exercise routines.
                        </p>
                    </div>

                    <div class="col-md-4">
                        <h5 class="font-weight-bold">
                            Wellness Plans
                        </h5>
                        <p>Follow structured plans for better health and fitness.</p>

                    </div>

                    <div class="col-md-4">

                        <h5 class="font-weight-bold">
                            Health Tips
                        </h5>

                        <p>
                            Learn and apply daily habits for long-term wellness.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
