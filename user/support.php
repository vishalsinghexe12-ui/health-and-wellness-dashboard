<?php
$title = "Support - Health & Wellness";
$css = "register-dashboard.css"; 

ob_start();
?>
<div class="row m-0" style="min-height: calc(100vh - 70px);">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 bg-success p-0 d-none d-md-block">
        <div class="sticky-top sidebar"> 
            <nav class="nav flex-column">
                <a class="nav-link sidebar-link" href="register-dashboard.php"><i class="fa-solid fa-gauge"></i> <span class="d-none d-sm-inline">Dashboard</span></a>
                <hr class="sidebar-divider">
                <a class="nav-link sidebar-link" href="meal-plans.php"><i class="fa-solid fa-bowl-food"></i> <span class="d-none d-sm-inline">Meal Plans</span></a>
                <a class="nav-link sidebar-link" href="Exercise-plans.php"><i class="fa-solid fa-dumbbell"></i> <span class="d-none d-sm-inline">Exercise Plans</span></a>
                <a class="nav-link sidebar-link" href="progress.php"><i class="fa-solid fa-bars-progress"></i> <span class="d-none d-sm-inline">Progress Data</span></a>
                <a class="nav-link sidebar-link" href="Sub-tips.php"><i class="fa-solid fa-lightbulb"></i> <span class="d-none d-sm-inline">SUBI Tips</span></a>
                <a class="nav-link sidebar-link" href="manage-plans.php"><i class="fa-solid fa-clipboard-list"></i> <span class="d-none d-sm-inline">Manage Plans</span></a>
                
                <a class="nav-link active sidebar-link" href="support.php"><i class="fa-solid fa-headset"></i> <span class="d-none d-sm-inline">Support</span></a>
                <hr class="sidebar-divider pt-4 mt-auto">
                <a class="nav-link sidebar-link" href="../login.php"><i class="fa-solid fa-right-from-bracket"></i> <span class="d-none d-sm-inline">Logout</span></a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-4" style="background-color: var(--bg-light);">
        <div class="text-center mb-5 mt-4">
            <h2 class="font-weight-bold" style="color: var(--text-main);">How can we help you today?</h2>
            <p class="text-muted">Our support team is here for your success journey.</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            
            <div class="col-lg-5 mb-4">
                <div class="stat-card h-100 text-center py-5">
                    <i class="fa-solid fa-envelope" style="font-size: 50px; color: var(--primary);"></i>
                    <h4 class="font-weight-bold mt-4">Email Support</h4>
                    <p class="text-muted">Send us an email and we'll reply within 24 hours.</p>
                    <a href="mailto:support@healthwellness.com" class="btn btn-outline-success px-4 mt-3" style="border-radius: 8px;">Contact via Email</a>
                </div>
            </div>
            
            <div class="col-lg-5 mb-4">
                <div class="stat-card h-100 text-center py-5">
                    <i class="fa-solid fa-book-open-reader" style="font-size: 50px; color: var(--primary-dark);"></i>
                    <h4 class="font-weight-bold mt-4">FAQ Library</h4>
                    <p class="text-muted">Find quick answers instantly in our knowledge base.</p>
                    <button class="btn btn-success px-4 mt-3" style="border-radius: 8px;">Browse FAQs</button>
                </div>
            </div>
            
        </div>
        
    </div>
</div>
<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
