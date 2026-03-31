<?php
$title = "SUBI Tips";
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
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);">Health & Wellness Tips</h2>
            <p class="text-muted">Master your health with these curated wellness strategies.</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 p-4">
                    <i class="fa-solid fa-droplet mb-3" style="font-size: 2rem; color: var(--primary-dark);"></i>
                    <h4 class="font-weight-bold">Hydration First</h4>
                    <p class="text-muted">Drink at least 3-4 liters of water daily to maintain energy and clear skin.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 p-4">
                    <i class="fa-solid fa-moon mb-3" style="font-size: 2rem; color: var(--primary-dark);"></i>
                    <h4 class="font-weight-bold">Sleep Quality</h4>
                    <p class="text-muted">Aim for 7-9 hours of consistent sleep to allow your body to recover fully.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 p-4">
                    <i class="fa-solid fa-seedling mb-3" style="font-size: 2rem; color: var(--primary-dark);"></i>
                    <h4 class="font-weight-bold">Mindful Eating</h4>
                    <p class="text-muted">Focus on your food, chew slowly, and enjoy every bite to improve digestion.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 p-4">
                    <i class="fa-solid fa-walking mb-3" style="font-size: 2rem; color: var(--primary-dark);"></i>
                    <h4 class="font-weight-bold">Daily Movement</h4>
                    <p class="text-muted">Even on rest days, a 20-minute walk can boost mood and metabolism significantly.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 p-4">
                    <i class="fa-solid fa-brain mb-3" style="font-size: 2rem; color: var(--primary-dark);"></i>
                    <h4 class="font-weight-bold">Stress Management</h4>
                    <p class="text-muted">Practice deep breathing or meditation for 10 minutes daily to lower cortisol levels.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 p-4">
                    <i class="fa-solid fa-apple-whole mb-3" style="font-size: 2rem; color: var(--primary-dark);"></i>
                    <h4 class="font-weight-bold">Whole Foods</h4>
                    <p class="text-muted">Prioritize single-ingredient, unprocessed foods for maximum nutrient density.</p>
                </div>
            </div>
        </div>
    </div>
</div>     

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
