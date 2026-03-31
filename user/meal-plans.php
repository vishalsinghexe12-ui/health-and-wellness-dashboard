<?php
$title = "Meal Plans";
$css = "register-dashboard.css"; 

ob_start();
?>
    
<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">
        <!-- Back Button from remote -->
        <div class="mb-4">
            <a href="register-dashboard.php" class="btn btn-outline-success d-inline-flex align-items-center" style="border-radius: 20px; padding: 5px 20px;">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                <span>Back to Dashboard</span>
            </a>
        </div>

        <div class="text-center mb-5">
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);">Nutrition Meal Plans</h2>
            <p class="text-muted">Scientifically crafted meal plans to accelerate your health journey.</p>
        </div>
        
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../meal-plans-images/weight loss.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Low Carb Plan</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">Reduce carbs to promote fat burning and stable energy levels.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Goal: Weight Loss</span>
                        <span>1,500 kcal/day</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 2499</div>
                    <a href="payment.php?plan=Low+Carb+Plan&price=2499" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../meal-plans-images/High Protien.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">High Protein Plan</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">Increase protein intake to support muscle growth and recovery.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Goal: Muscle Gain</span>
                        <span>2,500 kcal/day</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 2999</div>
                    <a href="payment.php?plan=High+Protein+Plan&price=2999" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../meal-plans-images/keto meal.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Keto Plan</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">Limit carbohydrates to enhance fat burning and enter ketosis quickly.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Goal: Weight Loss</span>
                        <span>1,800 kcal/day</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 2799</div>
                    <a href="payment.php?plan=Keto+Plan&price=2799" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../meal-plans-images/Vegan meal.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Vegan Plan</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">Plant-based meals for better digestion, energy, and overall health.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Lifestyle: Vegan</span>
                        <span>1,700 kcal/day</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 2499</div>
                    <a href="payment.php?plan=Vegan+Plan&price=2499" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../meal-plans-images/muscle gain.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Muscle Gain Pro</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">Increase calories with rich nutrients to maximize muscle mass predictably.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Goal: Bulking</span>
                        <span>2,800 kcal/day</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 3299</div>
                    <a href="payment.php?plan=Muscle+Gain+Pro&price=3299" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <img src="../meal-plans-images/Balanced meal.jpg" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);">Balanced Diet</h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;">Maintain a perfect macronutrient balance for steady daily energy.</p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Goal: Maintenance</span>
                        <span>2,000 kcal/day</span>
                    </div>
                    <div class="buy-amoount text-center mb-3">₹ 2499</div>
                    <a href="payment.php?plan=Balanced+Diet&price=2499" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>
        </div>
    </div>
</div>     

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
