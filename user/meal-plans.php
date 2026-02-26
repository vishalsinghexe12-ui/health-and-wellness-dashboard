<?php
$title = "Plans";
$css = "register-dashboard.css"; 

ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health & Wellness</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
      crossorigin="anonymous"
    />
    <script
      src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
      integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
      integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
      integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
      crossorigin="anonymous"
    ></script>
    
    <link rel="stylesheet" href="meal-plans.css">
    
</head>
<body>
    <div class="meal-plan-container py-5">
    <div class="container">
        <div class="row">

            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 text-center">
                <div class="meal-plan-card shadow">
                    <img src="../meal-plans-images/weight loss.jpg" class="img-fluid">
                    <h3 class="meal-plan-title mt-3">Low Carb Plan</h3>
                    <p class="meal-plan-description">Reduce carbs to promote fat burning and stable energy levels.</p>
                    <p class="meal-plan-category">Weight Loss</p>
                    <p class="meal-plan-kcal">1,500 kcal/day</p>
                    <p class="meal-plan-price">₹ 2499</p>
                    <hr>
                    <button class="btn btn-success btn-block">Buy Now</button>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 text-center">
                <div class="meal-plan-card shadow">
                    <img src="../meal-plans-images/High Protien.jpg" class="img-fluid">
                    <h3 class="meal-plan-title mt-3">High Protein Plan</h3>
                    <p class="meal-plan-description">Increase protein intake to support muscle growth and recovery.</p>
                    <p class="meal-plan-category">Muscle Gain</p>
                    <p class="meal-plan-kcal">2,500 kcal/day</p>
                    <p class="meal-plan-price">₹ 2999</p>
                    <hr>
                    <button class="btn btn-success btn-block">Buy Now</button>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 text-center">
                <div class="meal-plan-card shadow">
                    <img src="../meal-plans-images/keto meal.jpg" class="img-fluid">
                    <h3 class="meal-plan-title mt-3">Keto Plan</h3>
                    <p class="meal-plan-description">Limit carbohydrates to enhance fat burning.</p>
                    <p class="meal-plan-category">Weight Loss</p>
                    <p class="meal-plan-kcal">1,800 kcal/day</p>
                    <p class="meal-plan-price">₹ 2799</p>
                    <hr>
                    <button class="btn btn-success btn-block">Buy Now</button>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 text-center">
                <div class="meal-plan-card shadow">
                    <img src="../meal-plans-images/Vegan meal.jpg" class="img-fluid">
                    <h3 class="meal-plan-title mt-3">Vegan Plan</h3>
                    <p class="meal-plan-description">Plant-based meals for better digestion and energy.</p>
                    <p class="meal-plan-category">Healthy Lifestyle</p>
                    <p class="meal-plan-kcal">1,700 kcal/day</p>
                    <p class="meal-plan-price">₹ 2499</p>
                    <hr>
                    <button class="btn btn-success btn-block">Buy Now</button>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 text-center">
                <div class="meal-plan-card shadow">
                    <img src="../meal-plans-images/muscle gain.jpg" class="img-fluid">
                    <h3 class="meal-plan-title mt-3">Muscle Gain Pro</h3>
                    <p class="meal-plan-description">Increase calories to maximize muscle mass.</p>
                    <p class="meal-plan-category">Bulking</p>
                    <p class="meal-plan-kcal">2,800 kcal/day</p>
                    <p class="meal-plan-price">₹ 3299</p>
                    <hr>
                    <button class="btn btn-success btn-block">Buy Now</button>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 text-center">
                <div class="meal-plan-card shadow">
                    <img src="../meal-plans-images/Balanced meal.jpg" class="img-fluid">
                    <h3 class="meal-plan-title mt-3">Balanced Diet</h3>
                    <p class="meal-plan-description">Maintain nutrient balance for steady energy.</p>
                    <p class="meal-plan-category">General Fitness</p>
                    <p class="meal-plan-kcal">2,000 kcal/day</p>
                    <p class="meal-plan-price">₹ 2499</p>
                    <hr>
                    <button class="btn btn-success btn-block">Buy Now</button>
                </div>
            </div>

        </div>
    </div>
</div>     

     <script type="text/javascript" src="https://new-assets.ccbp.in/frontend/content/static-ccbp-ui-kit/static-ccbp-ui-kit.js"></script>
</body>
</html>

 
<?php
$content = ob_get_clean();
include("../includes/registered_layout.php");

?>
