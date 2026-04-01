<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}
require_once("../db_config.php");

$user_id = $_SESSION['user_id'];

// Fetch wellness profile (BMI, weight, height, goal)
$q1 = $con->prepare("SELECT * FROM user_wellness_profiles WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$q1->bind_param("i", $user_id);
$q1->execute();
$wellness = $q1->get_result()->fetch_assoc();

// Fetch purchased plans count
$q2 = $con->prepare("SELECT COUNT(*) as total FROM user_purchases WHERE user_id = ?");
$q2->bind_param("i", $user_id);
$q2->execute();
$total_plans = $q2->get_result()->fetch_assoc()['total'];

// Fetch total spent
$q3 = $con->prepare("SELECT COALESCE(SUM(price), 0) as spent FROM user_purchases WHERE user_id = ?");
$q3->bind_param("i", $user_id);
$q3->execute();
$total_spent = $q3->get_result()->fetch_assoc()['spent'];

// Fetch purchased plans list
$q4 = $con->prepare("SELECT plan_name, price, purchase_date FROM user_purchases WHERE user_id = ? ORDER BY purchase_date DESC");
$q4->bind_param("i", $user_id);
$q4->execute();
$purchases = $q4->get_result()->fetch_all(MYSQLI_ASSOC);

// Calculate data
$bmi = $wellness ? $wellness['bmi'] : null;
$weight = $wellness ? $wellness['weight'] : null;
$height = $wellness ? $wellness['height'] : null;
$goal = $wellness ? $wellness['fitness_goal'] : null;
$diet = $wellness ? $wellness['diet_preference'] : null;
$level = $wellness ? $wellness['activity_level'] : null;
$age = $wellness ? $wellness['age'] : null;

// BMI category
if ($bmi) {
    if ($bmi < 18.5) { $bmi_cat = "Underweight"; $bmi_color = "#f59e0b"; }
    elseif ($bmi < 25) { $bmi_cat = "Normal"; $bmi_color = "#10b981"; }
    elseif ($bmi < 30) { $bmi_cat = "Overweight"; $bmi_color = "#f97316"; }
    else { $bmi_cat = "Obese"; $bmi_color = "#ef4444"; }
} else {
    $bmi_cat = "Unknown";
    $bmi_color = "#94a3b8";
}

$title = "My Progress - Health & Wellness";
$css = "register-dashboard.css"; 

ob_start();
?>

<style>
.progress-stat {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    height: 100%;
    transition: transform 0.3s ease;
}
.progress-stat:hover {
    transform: translateY(-3px);
}
.progress-icon-box {
    width: 50px; height: 50px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    margin-right: 15px;
    flex-shrink: 0;
}
.bmi-gauge {
    width: 140px; height: 140px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center; flex-direction: column;
    margin: 0 auto 15px;
    font-family: 'Outfit', sans-serif;
    position: relative;
}
.bmi-gauge::after {
    content: '';
    position: absolute;
    inset: 6px;
    border-radius: 50%;
    background: white;
}
.bmi-gauge-inner {
    position: relative;
    z-index: 1;
    text-align: center;
}
.purchase-timeline-item {
    position: relative;
    padding-left: 30px;
    padding-bottom: 20px;
    border-left: 2px solid rgba(16,185,129,0.2);
}
.purchase-timeline-item:last-child {
    border-left: 2px solid transparent;
}
.purchase-timeline-item::before {
    content: '';
    position: absolute;
    left: -6px; top: 4px;
    width: 10px; height: 10px;
    border-radius: 50%;
    background: #10b981;
    border: 2px solid white;
    box-shadow: 0 0 0 2px rgba(16,185,129,0.3);
}
</style>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);"><i class="fa-solid fa-chart-line mr-2"></i>My Progress</h2>
            <p class="text-muted">Track your fitness journey and achievements</p>
        </div>

        <?php if (!$wellness): ?>
        <!-- No profile yet -->
        <div class="text-center py-5">
            <div style="background: white; border-radius: 20px; padding: 50px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); max-width: 500px; margin: 0 auto;">
                <i class="fa-solid fa-clipboard-question text-muted mb-4" style="font-size: 64px; opacity:0.4;"></i>
                <h4 class="font-weight-bold">No Profile Data Yet</h4>
                <p class="text-muted mb-4">Take the Wellness Quiz so we can track your health metrics and show personalized progress.</p>
                <a href="wellness-quiz.php" class="btn btn-success btn-lg px-5" style="border-radius: 10px;"><i class="fa-solid fa-heart-pulse mr-2"></i>Take Wellness Quiz</a>
            </div>
        </div>
        <?php else: ?>

        <!-- Top Stat Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="progress-stat">
                    <div class="d-flex align-items-center">
                        <div class="progress-icon-box" style="background: rgba(16,185,129,0.1); color: #10b981;">
                            <i class="fa-solid fa-weight-scale"></i>
                        </div>
                        <div>
                            <p class="text-muted m-0" style="font-size:13px;">Weight</p>
                            <h4 class="m-0 font-weight-bold"><?php echo $weight; ?> kg</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="progress-stat">
                    <div class="d-flex align-items-center">
                        <div class="progress-icon-box" style="background: rgba(59,130,246,0.1); color: #3b82f6;">
                            <i class="fa-solid fa-ruler-vertical"></i>
                        </div>
                        <div>
                            <p class="text-muted m-0" style="font-size:13px;">Height</p>
                            <h4 class="m-0 font-weight-bold"><?php echo $height; ?> cm</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="progress-stat">
                    <div class="d-flex align-items-center">
                        <div class="progress-icon-box" style="background: rgba(245,158,11,0.1); color: #f59e0b;">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                        <div>
                            <p class="text-muted m-0" style="font-size:13px;">Plans Purchased</p>
                            <h4 class="m-0 font-weight-bold"><?php echo $total_plans; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="progress-stat">
                    <div class="d-flex align-items-center">
                        <div class="progress-icon-box" style="background: rgba(139,92,246,0.1); color: #8b5cf6;">
                            <i class="fa-solid fa-cake-candles"></i>
                        </div>
                        <div>
                            <p class="text-muted m-0" style="font-size:13px;">Age</p>
                            <h4 class="m-0 font-weight-bold"><?php echo $age; ?> years</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BMI + Profile Row -->
        <div class="row mb-4">
            <div class="col-lg-4 mb-4">
                <div class="progress-stat text-center">
                    <h5 class="font-weight-bold mb-3">BMI Score</h5>
                    <div class="bmi-gauge" style="background: conic-gradient(<?php echo $bmi_color; ?> <?php echo min($bmi * 3, 100); ?>%, #e2e8f0 0);">
                        <div class="bmi-gauge-inner">
                            <div style="font-size: 32px; font-weight: 800; color: <?php echo $bmi_color; ?>;"><?php echo $bmi; ?></div>
                            <div style="font-size: 14px; font-weight: 600; color: <?php echo $bmi_color; ?>;"><?php echo $bmi_cat; ?></div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between px-3 mt-3" style="font-size: 11px;">
                        <span style="color:#f59e0b;">Underweight<br>&lt;18.5</span>
                        <span style="color:#10b981;">Normal<br>18.5-24.9</span>
                        <span style="color:#f97316;">Overweight<br>25-29.9</span>
                        <span style="color:#ef4444;">Obese<br>30+</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 mb-4">
                <div class="progress-stat">
                    <h5 class="font-weight-bold mb-4"><i class="fa-solid fa-user-check text-success mr-2"></i>Health Profile Summary</h5>
                    <div class="row">
                        <div class="col-6 col-md-4 mb-3">
                            <div style="background: rgba(16,185,129,0.06); border-radius: 12px; padding: 15px; text-align: center;">
                                <i class="fa-solid fa-bullseye mb-2" style="font-size:20px; color:#10b981;"></i>
                                <p class="text-muted m-0" style="font-size:12px;">Fitness Goal</p>
                                <strong style="font-size:14px;"><?php echo htmlspecialchars($goal); ?></strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 mb-3">
                            <div style="background: rgba(59,130,246,0.06); border-radius: 12px; padding: 15px; text-align: center;">
                                <i class="fa-solid fa-utensils mb-2" style="font-size:20px; color:#3b82f6;"></i>
                                <p class="text-muted m-0" style="font-size:12px;">Diet Preference</p>
                                <strong style="font-size:14px;"><?php echo htmlspecialchars($diet); ?></strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 mb-3">
                            <div style="background: rgba(245,158,11,0.06); border-radius: 12px; padding: 15px; text-align: center;">
                                <i class="fa-solid fa-gauge-high mb-2" style="font-size:20px; color:#f59e0b;"></i>
                                <p class="text-muted m-0" style="font-size:12px;">Activity Level</p>
                                <strong style="font-size:14px;"><?php echo htmlspecialchars($level); ?></strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 mb-3">
                            <div style="background: rgba(139,92,246,0.06); border-radius: 12px; padding: 15px; text-align: center;">
                                <i class="fa-solid fa-cake-candles mb-2" style="font-size:20px; color:#8b5cf6;"></i>
                                <p class="text-muted m-0" style="font-size:12px;">Age</p>
                                <strong style="font-size:14px;"><?php echo $age; ?> years</strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 mb-3">
                            <div style="background: rgba(236,72,153,0.06); border-radius: 12px; padding: 15px; text-align: center;">
                                <i class="fa-solid fa-weight-scale mb-2" style="font-size:20px; color:#ec4899;"></i>
                                <p class="text-muted m-0" style="font-size:12px;">Weight</p>
                                <strong style="font-size:14px;"><?php echo $weight; ?> kg</strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 mb-3">
                            <div style="background: rgba(6,182,212,0.06); border-radius: 12px; padding: 15px; text-align: center;">
                                <i class="fa-solid fa-ruler-vertical mb-2" style="font-size:20px; color:#06b6d4;"></i>
                                <p class="text-muted m-0" style="font-size:12px;">Height</p>
                                <strong style="font-size:14px;"><?php echo $height; ?> cm</strong>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <a href="wellness-quiz.php" class="btn btn-outline-success btn-sm" style="border-radius: 8px;"><i class="fa-solid fa-rotate mr-1"></i>Update Profile</a>
                        <a href="my-recommendations.php" class="btn btn-success btn-sm ml-2" style="border-radius: 8px;"><i class="fa-solid fa-wand-magic-sparkles mr-1"></i>View Recommendations</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchases Chart + Timeline -->
        <div class="row mb-4">
            <div class="col-lg-7 mb-4">
                <div class="progress-stat">
                    <h5 class="font-weight-bold mb-3"><i class="fa-solid fa-chart-pie text-success mr-2"></i>Spending Breakdown</h5>
                    <?php if (count($purchases) > 0): ?>
                        <canvas id="spendingChart" height="250"></canvas>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fa-solid fa-chart-pie mb-2" style="font-size: 40px; opacity:0.3;"></i>
                            <p>No purchase data to display yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-5 mb-4">
                <div class="progress-stat">
                    <h5 class="font-weight-bold mb-4"><i class="fa-solid fa-timeline text-success mr-2"></i>Purchase Timeline</h5>
                    <?php if (count($purchases) > 0): ?>
                        <?php foreach ($purchases as $p): ?>
                        <div class="purchase-timeline-item">
                            <h6 class="font-weight-bold m-0"><?php echo htmlspecialchars($p['plan_name']); ?></h6>
                            <small class="text-muted"><?php echo date('M j, Y', strtotime($p['purchase_date'])); ?></small>
                            <span class="d-block font-weight-bold" style="color: var(--primary-dark);">₹<?php echo number_format($p['price']); ?></span>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <p>No purchases yet. <a href="meal-plans.php" class="text-success">Browse plans</a></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php endif; ?>
    </div>
</div>

<?php if ($wellness && count($purchases) > 0): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var labels = <?php echo json_encode(array_column($purchases, 'plan_name')); ?>;
var prices = <?php echo json_encode(array_map('intval', array_column($purchases, 'price'))); ?>;
var colors = ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4', '#ef4444', '#14b8a6'];

var ctx = document.getElementById('spendingChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            data: prices,
            backgroundColor: colors.slice(0, labels.length),
            borderWidth: 3,
            borderColor: '#fff',
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    usePointStyle: true,
                    pointStyle: 'circle',
                    font: { size: 12 }
                }
            }
        },
        cutout: '65%'
    }
});
</script>
<?php endif; ?>

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
