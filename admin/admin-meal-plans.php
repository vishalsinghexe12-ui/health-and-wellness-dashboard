<?php
$title = "Meal Plans";
$css = "admin.css"; 
ob_start();
?>

<div class="meal-plan-container py-5">
    <div class="container">
        <div class="mb-4">
            <a href="javascript:history.back()" class="back-btn d-inline-flex align-items-center">
                <span class="back-icon">
                    <i class="fa-solid fa-arrow-left"></i>
                </span>
                <span class="ml-2">Back</span>
            </a>
        </div>
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="font-weight-bold">Meal Plans</h3>
            <a href="add-plans.php" class="btn btn-success">+ Add New Plan</a>
        </div>

        <div class="row">

            <!-- CARD 1 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="meal-plan-card shadow w-100 d-flex flex-column text-center h-100 p-3">
                    <img src="../meal-plans-images/weight loss.jpg" class="img-fluid mb-3 meal-img">
                    <h4>Low Carb Plan</h4>
                    <p>Reduce carbs to promote fat burning and stable energy levels.</p>
                    <p><strong>Category:</strong> Weight Loss</p>
                    <p><strong>Calories:</strong> 1,500 kcal/day</p>
                    <p class="font-weight-bold">₹ 2499</p>
                    <hr>
                    <button class="btn btn-success mt-auto">Buy Now</button>
                </div>
            </div>

            <!-- CARD 2 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="meal-plan-card shadow w-100 d-flex flex-column text-center h-100 p-3">
                    <img src="../meal-plans-images/High Protien.jpg" class="img-fluid mb-3 meal-img">
                    <h4>High Protein Plan</h4>
                    <p>Increase protein intake to support muscle growth and recovery.</p>
                    <p><strong>Category:</strong> Muscle Gain</p>
                    <p><strong>Calories:</strong> 2,500 kcal/day</p>
                    <p class="font-weight-bold">₹ 2999</p>
                    <hr>
                    <button class="btn btn-success mt-auto">Buy Now</button>
                </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="meal-plan-card shadow w-100 d-flex flex-column text-center h-100 p-3">
                    <img src="../meal-plans-images/keto meal.jpg" class="img-fluid mb-3 meal-img">
                    <h4>Keto Plan</h4>
                    <p>Limit carbohydrates to enhance fat burning.</p>
                    <p><strong>Category:</strong> Weight Loss</p>
                    <p><strong>Calories:</strong> 1,800 kcal/day</p>
                    <p class="font-weight-bold">₹ 2799</p>
                    <hr>
                    <button class="btn btn-success mt-auto">Buy Now</button>
                </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="meal-plan-card shadow w-100 d-flex flex-column text-center h-100 p-3">
                    <img src="../meal-plans-images/Vegan meal.jpg" class="img-fluid mb-3 meal-img">
                    <h4>Vegan Plan</h4>
                    <p>Plant-based meals for better digestion and energy.</p>
                    <p><strong>Category:</strong> Healthy Lifestyle</p>
                    <p><strong>Calories:</strong> 1,700 kcal/day</p>
                    <p class="font-weight-bold">₹ 2499</p>
                    <hr>
                    <button class="btn btn-success mt-auto">Buy Now</button>
                </div>
            </div>

            <!-- CARD 5 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="meal-plan-card shadow w-100 d-flex flex-column text-center h-100 p-3">
                    <img src="../meal-plans-images/muscle gain.jpg" class="img-fluid mb-3 meal-img">
                    <h4>Muscle Gain Pro</h4>
                    <p>Increase calories to maximize muscle mass.</p>
                    <p><strong>Category:</strong> Bulking</p>
                    <p><strong>Calories:</strong> 2,800 kcal/day</p>
                    <p class="font-weight-bold">₹ 3299</p>
                    <hr>
                    <button class="btn btn-success mt-auto">Buy Now</button>
                </div>
            </div>

            <!-- CARD 6 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="meal-plan-card shadow w-100 d-flex flex-column text-center h-100 p-3">
                    <img src="../meal-plans-images/Balanced meal.jpg" class="img-fluid mb-3 meal-img">
                    <h4>Balanced Diet</h4>
                    <p>Maintain nutrient balance for steady energy.</p>
                    <p><strong>Category:</strong> General Fitness</p>
                    <p><strong>Calories:</strong> 2,000 kcal/day</p>
                    <p class="font-weight-bold">₹ 2499</p>
                    <hr>
                    <button class="btn btn-success mt-auto">Buy Now</button>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>