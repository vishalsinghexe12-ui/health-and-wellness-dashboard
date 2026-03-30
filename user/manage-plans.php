<?php
$title = "Manage Active Plans";
$css = "register-dashboard.css"; 

ob_start();
?>
<div class="row m-0" style="min-height: calc(100vh - 70px);">
    <!-- Sidebar Duplicate (Or in future, centralized) -->
    <div class="col-md-3 col-lg-2 bg-success p-0 d-none d-md-block">
        <div class="sticky-top sidebar"> 
            <nav class="nav flex-column">
                <a class="nav-link sidebar-link" href="register-dashboard.php"><i class="fa-solid fa-gauge"></i> <span class="d-none d-sm-inline">Dashboard</span></a>
                <hr class="sidebar-divider">
                <a class="nav-link sidebar-link" href="meal-plans.php"><i class="fa-solid fa-bowl-food"></i> <span class="d-none d-sm-inline">Meal Plans</span></a>
                <a class="nav-link sidebar-link" href="Exercise-plans.php"><i class="fa-solid fa-dumbbell"></i> <span class="d-none d-sm-inline">Exercise Plans</span></a>
                <a class="nav-link sidebar-link" href="progress.php"><i class="fa-solid fa-bars-progress"></i> <span class="d-none d-sm-inline">Progress Data</span></a>
                <a class="nav-link sidebar-link" href="Sub-tips.php"><i class="fa-solid fa-lightbulb"></i> <span class="d-none d-sm-inline">SUBI Tips</span></a>
                
                <a class="nav-link active sidebar-link" href="manage-plans.php"><i class="fa-solid fa-clipboard-list"></i> <span class="d-none d-sm-inline">Manage Plans</span></a>
                <a class="nav-link sidebar-link" href="support.php"><i class="fa-solid fa-headset"></i> <span class="d-none d-sm-inline">Support</span></a>
                <hr class="sidebar-divider pt-4 mt-auto">
                <a class="nav-link sidebar-link" href="../login.php"><i class="fa-solid fa-right-from-bracket"></i> <span class="d-none d-sm-inline">Logout</span></a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-4" style="background-color: var(--bg-light);">
        <h2 class="font-weight-bold mb-4" style="color: var(--text-main);">Active Plan Subscriptions</h2>
        
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
