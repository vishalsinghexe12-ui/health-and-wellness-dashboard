<?php
$title = "Admin";
$css = "admin.css";
ob_start();
?>


<div class="container mt-5">
    <div class="mb-4">
        <a href="javascript:history.back()" class="back-btn d-inline-flex align-items-center">
            <span class="back-icon">
                <i class="fa-solid fa-arrow-left"></i>
            </span>
            <span class="ml-2">Back</span>
        </a>
    </div>
    <h3 class="mb-4 font-weight-bold">Manage Plans</h3>

    <div class="row">

        <!-- Meal Plans Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm text-center p-4">
                <img class="w-100 P-1" src="../meal-plans-images/Balanced meal.jpg"/>
                <h4>Meal Plans</h4>
                <p class="text-muted">Manage all nutrition and diet plans.</p>
                <a href="admin-meal-plans.php" class="btn btn-success">Manage Meal Plans</a>
            </div>
        </div>

        <!-- Exercise Plans Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm text-center p-4">
                <img class="w-100 P-1" src="../Exercise-Images/Beginner Fitness.jpg"/>
                <h4>Exercise Plans</h4>
                <p class="text-muted"> Manage workout and training programs.</p>
                <a href="admin-exercise-plans.php"class="btn btn-success"> Manage Exercise Plans</a>
            </div>
        </div>

    </div>
</div>


<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>