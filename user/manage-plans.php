<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}
require_once("../db_config.php");

$title = "Manage Active Plans";
$css = "register-dashboard.css"; 

$user_id = $_SESSION['user_id'];
$purchases = [];

$stmt = $con->prepare("SELECT plan_name, price, status, purchase_date FROM user_purchases WHERE user_id = ? ORDER BY purchase_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $purchases[] = $row;
}

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
                <?php if (count($purchases) > 0): ?>
                    <?php foreach ($purchases as $plan): ?>
                        <?php 
                        $purchase_time = strtotime($plan['purchase_date']);
                        $started = date("F j, Y", $purchase_time);
                        $expires = date("F j, Y", strtotime("+60 days", $purchase_time)); // Dummy 60-day expiry
                        ?>
                        <div class="stat-card mb-4" style="border-left: 5px solid var(--success);">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="font-weight-bold" style="color: var(--primary-dark);"><?php echo htmlspecialchars($plan['plan_name']); ?></h4>
                                <span class="badge badge-success p-2"><i class="fa-solid fa-check-circle mr-1"></i> <?php echo htmlspecialchars($plan['status']); ?></span>
                            </div>
                            <p class="text-muted mb-4">Started on: <strong><?php echo $started; ?></strong> <br> Expires on: <strong><?php echo $expires; ?></strong></p>
                            <div class="progress mb-3" style="height: 10px; border-radius: 5px;">
                              <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 5%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="text-muted"><small>Week 1 - Just Started!</small></p>
                            <hr>
                            <a href="training-schedule.php?plan=<?php echo urlencode($plan['plan_name']); ?>" class="btn border-success text-success font-weight-bold px-4" style="border-radius: 8px; text-decoration: none;">View Training Schedule</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="stat-card d-flex flex-column align-items-center justify-content-center h-100 text-center py-5">
                        <i class="fa-solid fa-folder-open text-muted mb-3" style="font-size: 64px; opacity: 0.5;"></i>
                        <h4 class="font-weight-bold text-dark mt-2 mb-2">No Plans Purchased Yet</h4>
                        <p class="text-muted">You haven't purchased any plans. Browse our catalog to get started on your wellness journey!</p>
                    </div>
                <?php endif; ?>
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
