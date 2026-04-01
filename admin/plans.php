<?php
$title = "Manage Plans";
$css = "admin.css";
ob_start();
?>


<div class="container mt-5">
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