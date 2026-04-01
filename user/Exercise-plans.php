<?php
$title = "Exercise Plans";
$css = "register-dashboard.css"; 

ob_start();
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">


        <div class="text-center mb-5">
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);">Fitness Exercise Plans</h2>
            <p class="text-muted">Expertly designed workout routines for maximum results.</p>
        </div>
        
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../Exercise-Images/Weight loss fitness.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Weight Loss Plan</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">High-intensity workouts designed to burn calories and shed weight fast.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Intensity: High</span>
                        <span>45 mins</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 3499</div>
                    <a href="payment.php?plan=Weight+Loss+Plan&price=3499" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../Exercise-Images/muscle gain fitness.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Muscle Building Plan</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">Focused strength training to increase muscle mass and strength.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Intensity: Medium</span>
                        <span>60 mins</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 3999</div>
                    <a href="payment.php?plan=Muscle+Building+Plan&price=3999" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../Exercise-Images/Full Body Workout.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Yoga & Flexibility</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">Improve flexibility, balance, and mental clarity with guided yoga.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Intensity: Low</span>
                        <span>30 mins</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 2999</div>
                    <a href="payment.php?plan=Yoga+Focus&price=2999" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../Exercise-Images/HIIT Blast.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">HIIT Intensity</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">Short, intense bursts of exercise followed by brief recovery periods.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Intensity: Very High</span>
                        <span>25 mins</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 3699</div>
                    <a href="payment.php?plan=HIIT+Intensity&price=3699" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../Exercise-Images/Beginner Fitness.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Endurance Plan</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">Building cardiovascular strength and long-term stamina.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Intensity: Medium</span>
                        <span>50 mins</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 3299</div>
                    <a href="payment.php?plan=Endurance+Power&price=3299" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../Exercise-Images/Strenght.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Strength Pro</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">In-depth resistance training for total body strength and power.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Intensity: High</span>
                        <span>60 mins</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 3999</div>
                    <a href="payment.php?plan=Strength+Titan&price=3999" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

        </div>
    </div>
</div>     

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
