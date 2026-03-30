<?php
$title = "Exercise Plans";
$css = "register-dashboard.css"; 

ob_start();
?>
    
<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);">Fitness Programs</h2>
            <p class="text-muted">Choose a structured workout plan designed for your specific goals.</p>
        </div>
        
        <div class="row g-4">

            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../Exercise-Images/Beginner Fitness.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Beginner Fitness Plan</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">A simple and effective workout routine designed for beginners to improve stamina and flexibility.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Level: Beginner</span>
                        <span>8 Weeks</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 1999</div>
                    <a href="payment.php?plan=Beginner+Fitness+Plan&price=1999" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../Exercise-Images/Weight loss fitness.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Weight Loss Program</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">Fat-burning cardio workouts combined with strength exercises to help you lose weight effectively.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Goal: Weight Loss</span>
                        <span>12 Weeks</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 2499</div>
                    <a href="payment.php?plan=Weight+Loss+Program&price=2499" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../Exercise-Images/muscle gain fitness.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Muscle Gain Program</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">Strength training routines focused on increasing muscle mass and improving overall strength.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Goal: Muscle Building</span>
                        <span>16 Weeks</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 2999</div>
                    <a href="payment.php?plan=Muscle+Gain+Program&price=2999" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../Exercise-Images/HIIT Blast.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">HIIT Blast Plan</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">High-Intensity Interval Training designed to burn maximum calories in minimum time.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Level: Advanced</span>
                        <span>10 Weeks</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 2799</div>
                    <a href="payment.php?plan=HIIT+Blast+Plan&price=2799" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../Exercise-Images/Strenght.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Strength & Conditioning</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">Improve endurance, core strength, and athletic performance with structured training.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Level: Intermediate</span>
                        <span>14 Weeks</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 3199</div>
                    <a href="payment.php?plan=Strength+and+Conditioning&price=3199" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../Exercise-Images/Full Body Workout.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Full Body Workout</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">Balanced workouts targeting all major muscle groups for overall fitness.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Goal: General Fitness</span>
                        <span>12 Weeks</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 4999</div>
                    <a href="payment.php?plan=Full+Body+Workout&price=4999" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

        </div>
    </div>
</div>     

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
