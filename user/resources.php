<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}
require_once("../db_config.php");

$user_id = $_SESSION['user_id'];

// Restrict Access to Active Members Only
$check_membership = $con->prepare("SELECT * FROM user_memberships WHERE user_id = ? AND end_date > NOW() AND status = 'Active'");
$check_membership->bind_param("i", $user_id);
$check_membership->execute();
$mbr_result = $check_membership->get_result();

if ($mbr_result->num_rows == 0) {
    $_SESSION['login_error'] = "This is a premium feature. Please upgrade your membership to access Downloadable Resources.";
    header("Location: memberships.php");
    exit();
}

$title = "Premium Resources";
$css = "register-dashboard.css"; 
ob_start();
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container pb-5">
        
        <div class="d-flex align-items-center mb-5">
            <div>
                <span class="badge badge-warning text-dark px-3 py-2 mb-2" style="border-radius: 8px;"><i class="fa-solid fa-crown mr-1"></i> Premium Feature</span>
                <h2 class="font-weight-bold m-0" style="color: var(--text-main); font-family: 'Outfit', sans-serif; font-size:36px;">Downloadable Resources</h2>
                <p class="text-muted m-0" style="font-size: 18px;">Access the complete library of printable guides, trackers, and recipe books.</p>
            </div>
        </div>

        <!-- Section: Dietary Guides -->
        <h4 class="font-weight-bold mb-4 mt-5"><i class="fa-solid fa-apple-whole text-success mr-2"></i> Dietary Guides & Recipes</h4>
        <div class="row">
            <!-- Resource Card 1 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden; border: 1px solid #e2e8f0;">
                    <div style="height: 160px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); display:flex; align-items:center; justify-content:center; color:white;">
                        <i class="fa-solid fa-file-pdf" style="font-size: 60px; opacity: 0.8;"></i>
                    </div>
                    <div class="card-body p-4">
                        <span class="badge badge-soft-success mb-2" style="background: rgba(16,185,129,0.1); color: #10b981; border-radius: 8px;">PDF Guide</span>
                        <h5 class="font-weight-bold">Keto Starter Pack</h5>
                        <p class="text-muted small">A complete 14-day Keto meal plan including grocery lists and macronutrient breakdowns.</p>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">4.2 MB</small>
                            <a href="#" class="btn btn-outline-success btn-sm font-weight-bold" style="border-radius: 8px;"><i class="fa-solid fa-download mr-1"></i> Download</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resource Card 2 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden; border: 1px solid #e2e8f0;">
                    <div style="height: 160px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); display:flex; align-items:center; justify-content:center; color:white;">
                        <i class="fa-solid fa-file-pdf" style="font-size: 60px; opacity: 0.8;"></i>
                    </div>
                    <div class="card-body p-4">
                        <span class="badge badge-soft-primary mb-2" style="background: rgba(59,130,246,0.1); color: #3b82f6; border-radius: 8px;">PDF Guide</span>
                        <h5 class="font-weight-bold">High-Protein Vegan</h5>
                        <p class="text-muted small">Discover 50+ plant-based recipes packed with protein to fuel your muscle growth naturally.</p>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">6.8 MB</small>
                            <a href="#" class="btn btn-outline-primary btn-sm font-weight-bold" style="border-radius: 8px;"><i class="fa-solid fa-download mr-1"></i> Download</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resource Card 3 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden; border: 1px solid #e2e8f0;">
                    <div style="height: 160px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); display:flex; align-items:center; justify-content:center; color:white;">
                        <i class="fa-solid fa-file-excel" style="font-size: 60px; opacity: 0.8;"></i>
                    </div>
                    <div class="card-body p-4">
                        <span class="badge badge-soft-warning mb-2" style="background: rgba(245,158,11,0.1); color: #d97706; border-radius: 8px;">Spreadsheet</span>
                        <h5 class="font-weight-bold">Macro Tracker</h5>
                        <p class="text-muted small">An interactive Excel spreadsheet to automatically log and calculate your daily macros.</p>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">1.1 MB</small>
                            <a href="#" class="btn btn-outline-warning text-dark btn-sm font-weight-bold" style="border-radius: 8px;"><i class="fa-solid fa-download mr-1"></i> Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section: Workout Trackers -->
        <h4 class="font-weight-bold mb-4 mt-5"><i class="fa-solid fa-dumbbell text-primary mr-2"></i> Workout Trackers</h4>
        <div class="row">
            <!-- Resource Card 4 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden; border: 1px solid #e2e8f0;">
                    <div style="height: 160px; background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); display:flex; align-items:center; justify-content:center; color:white;">
                        <i class="fa-solid fa-file-lines" style="font-size: 60px; opacity: 0.8;"></i>
                    </div>
                    <div class="card-body p-4">
                        <span class="badge badge-soft-purple mb-2" style="background: rgba(139,92,246,0.1); color: #8b5cf6; border-radius: 8px;">Printable</span>
                        <h5 class="font-weight-bold">Hypertrophy Log</h5>
                        <p class="text-muted small">Printable log sheets designed specifically for progressive overload and hypertrophy training.</p>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">2.0 MB</small>
                            <a href="#" class="btn btn-outline-dark btn-sm font-weight-bold" style="border-radius: 8px; color:#8b5cf6; border-color:#8b5cf6;"><i class="fa-solid fa-download mr-1"></i> Download</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resource Card 5 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden; border: 1px solid #e2e8f0;">
                    <div style="height: 160px; background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); display:flex; align-items:center; justify-content:center; color:white;">
                        <i class="fa-solid fa-file-pdf" style="font-size: 60px; opacity: 0.8;"></i>
                    </div>
                    <div class="card-body p-4">
                        <span class="badge badge-soft-danger mb-2" style="background: rgba(239,68,68,0.1); color: #ef4444; border-radius: 8px;">PDF Guide</span>
                        <h5 class="font-weight-bold">HIIT Circuit Cards</h5>
                        <p class="text-muted small">Cut out these 50 flashcards to instantly generate random, high-intensity sweaty routines at home.</p>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">8.5 MB</small>
                            <a href="#" class="btn btn-outline-danger btn-sm font-weight-bold" style="border-radius: 8px;"><i class="fa-solid fa-download mr-1"></i> Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
