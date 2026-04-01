<?php
$title = "Manage Active Plans";
$css = "register-dashboard.css"; 

ob_start();
?>
<div class="row m-0" style="min-height: calc(100vh - 70px);">

    <!-- Main Content -->
    <div class="col-12 py-4 px-5" style="background-color: var(--bg-light);">
        <div class="text-center mb-5">
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);">Active Plan Subscriptions</h2>
            <p class="text-muted">Track and manage your current wellness plans.</p>
        </div>
        
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-8">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="font-weight-bold" style="color: var(--primary-dark);">Beginner Fitness Plan</h4>
                        <span class="badge badge-success p-2">Active</span>
                    </div>
                    <p class="text-muted mb-4">Started on: <strong>October 12, 2025</strong> <br> Expires on: <strong>December 12, 2025</strong></p>
                    <div class="progress mb-3" style="height: 10px; border-radius: 5px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="text-muted"><small>Week 2 of 8 Completed</small></p>
                    <hr>
                    <button class="btn border-success text-success font-weight-bold px-4" style="border-radius: 8px;">View Training Schedule</button>
                </div>
            </div>
            
            <div class="col-12 col-lg-4">
               <div class="activity-card mt-0 h-100 d-flex flex-column justify-content-center text-center">
                   <div style="font-size: 50px; color: var(--primary);"><i class="fa-solid fa-plus-circle"></i></div>
                   <h5 class="font-weight-bold mt-3">Find New Plans</h5>
                   <p class="text-muted">Browse the catalog to add meal or workout routines.</p>
                   <a href="meal-plans.php" class="btn btn-success mt-2">Browse Catalog</a>
               </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
