<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}
require_once("../db_config.php");

$user_id = $_SESSION['user_id'];

// Restrict Access to Active Members Only
$check_membership = $con->prepare("SELECT 1 FROM user_memberships WHERE user_id = ? AND end_date > NOW() AND status = 'Active' UNION SELECT 1 FROM user_purchases p JOIN memberships m ON p.plan_name = m.title WHERE p.user_id = ? AND p.status = 'Active'");
$check_membership->bind_param("ii", $user_id, $user_id);
$check_membership->execute();
$mbr_result = $check_membership->get_result();

if ($mbr_result->num_rows == 0) {
    $_SESSION['login_error'] = "This is a premium feature. Please upgrade your membership to access Surprise Rewards.";
    header("Location: memberships.php");
    exit();
}

$membership_id = null;
$streak_days = 0;
$last_login = null;

$stmt = $con->prepare("SELECT id, streak_days, last_login FROM user_memberships WHERE user_id = ? AND end_date > NOW() AND status = 'Active'");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $membership_data = $res->fetch_assoc();
    $streak_days = $membership_data['streak_days'] ?? 0;
    $last_login = $membership_data['last_login'] ?? null;
    $membership_id = $membership_data['id'];
}

$current_date = date('Y-m-d');

// Update streak logic (basic)
if ($membership_id && $last_login !== $current_date) {
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    if ($last_login === $yesterday) {
        $streak_days++;
    } else {
        $streak_days = 1; // reset streak
    }
    
    // Check if we hit 7 days, if so, trigger a surprise? (For simulation, we cap at visual representation)
    $update_streak = $con->prepare("UPDATE user_memberships SET streak_days = ?, last_login = ? WHERE id = ?");
    $update_streak->bind_param("isi", $streak_days, $current_date, $membership_id);
    $update_streak->execute();
}

$title = "Surprise Rewards";
$css = "register-dashboard.css"; 
ob_start();

$progress_percent = min(($streak_days / 7) * 100, 100);
$days_left = 7 - ($streak_days % 7);
if($days_left == 7 && $streak_days > 0) $days_left = 0; // if exactly multiple of 7
?>

<style>
    .reward-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    .reward-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: #10b981;
    }
    .reward-icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 36px;
    }
    .streak-container {
        background: white;
        border-radius: 24px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
        position: relative;
        overflow: hidden;
    }
    .streak-container::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 6px;
        background: linear-gradient(90deg, #f59e0b, #ef4444);
    }
    .streak-number {
        font-size: 84px;
        font-weight: 900;
        line-height: 1;
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 20px 0;
        font-family: 'Outfit', sans-serif;
    }
    .progress {
        height: 12px;
        border-radius: 6px;
        background-color: #e2e8f0;
        margin: 30px 0 15px 0;
    }
    .progress-bar {
        background: linear-gradient(90deg, #f59e0b, #ef4444);
        border-radius: 6px;
    }
    .day-marker {
        display: flex;
        justify-content: space-between;
        color: #94a3b8;
        font-size: 14px;
        font-weight: 600;
    }
    .locked-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255,255,255,0.8);
        backdrop-filter: blur(4px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 10;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .reward-card:hover .locked-overlay {
        opacity: 1;
    }
</style>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container pb-5">
        
        <div class="d-flex align-items-center mb-5">
            <div>
                <span class="badge badge-warning text-dark px-3 py-2 mb-2" style="border-radius: 8px;"><i class="fa-solid fa-crown mr-1"></i> Premium Feature</span>
                <h2 class="font-weight-bold m-0" style="color: var(--text-main); font-family: 'Outfit', sans-serif; font-size:36px;">Surprise Rewards</h2>
                <p class="text-muted m-0" style="font-size: 18px;">Maintain your streak to unlock exclusive bonuses and surprises!</p>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="streak-container">
                    <h4 class="text-muted font-weight-bold text-uppercase" style="letter-spacing: 2px; font-size:14px;"><i class="fa-solid fa-fire text-danger mr-2"></i> Current Login Streak</h4>
                    <div class="streak-number"><?php echo $streak_days; ?></div>
                    <p class="font-weight-bold text-dark" style="font-size:18px;">Days in a row!</p>
                    
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $progress_percent; ?>%" aria-valuenow="<?php echo $progress_percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="day-marker">
                        <span>Day 1</span>
                        <span>Day 3</span>
                        <span>Day 5</span>
                        <span class="text-danger"><i class="fa-solid fa-gift mr-1"></i> Day 7 Prize</span>
                    </div>

                    <?php if ($days_left == 0 && $streak_days > 0): ?>
                        <div class="alert alert-success mt-4 p-3 font-weight-bold" style="border-radius: 12px; background: rgba(16, 185, 129, 0.1); border-color: #10b981; color: #059669;">
                            🎉 Congratulations! You've unlcoked your 7-Day Prize. Scroll down to claim it.
                        </div>
                    <?php else: ?>
                        <p class="mt-4 text-muted border-top pt-4">You are just <strong class="text-danger"><?php echo $days_left; ?> days</strong> away from unlocking your next Surprise Reward. Keep logging in!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <h4 class="font-weight-bold mb-4">Your Reward Vault</h4>
        <div class="row">
            <!-- Unlocked Reward -->
            <div class="col-md-4 mb-4">
                <div class="reward-card" style="border-color: #10b981;">
                    <div class="reward-icon-wrapper" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fa-solid fa-bowl-rice"></i>
                    </div>
                    <h5 class="font-weight-bold">Bonus Recipe Book</h5>
                    <p class="text-muted">High-protein vegan recipes carefully curated for premium members.</p>
                    <button class="btn btn-success btn-sm font-weight-bold" style="border-radius: 8px;"><i class="fa-solid fa-download mr-1"></i> Download</button>
                    <span class="badge badge-success position-absolute" style="top: 20px; right: 20px; border-radius: 8px;">Unlocked</span>
                </div>
            </div>

            <!-- Conditional Reward (7 days) -->
            <div class="col-md-4 mb-4">
                <div class="reward-card <?php echo ($streak_days < 7) ? 'opacity-75' : ''; ?>">
                    <div class="reward-icon-wrapper" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                        <i class="fa-solid fa-video"></i>
                    </div>
                    <h5 class="font-weight-bold">Exclusive Masterclass</h5>
                    <p class="text-muted">A 45-minute core strengthening masterclass by Coach Alex.</p>
                    <?php if ($streak_days >= 7): ?>
                        <button class="btn btn-primary btn-sm font-weight-bold" style="border-radius: 8px;"><i class="fa-solid fa-play mr-1"></i> Watch Now</button>
                        <span class="badge badge-primary position-absolute" style="top: 20px; right: 20px; border-radius: 8px;">Unlocked</span>
                    <?php else: ?>
                        <div class="locked-overlay">
                            <i class="fa-solid fa-lock text-muted mb-2" style="font-size: 24px;"></i>
                            <span class="font-weight-bold text-dark">Unlocks at 7-Day Streak</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Future Reward -->
            <div class="col-md-4 mb-4">
                <div class="reward-card">
                    <div class="reward-icon-wrapper" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                        <i class="fa-solid fa-medal"></i>
                    </div>
                    <h5 class="font-weight-bold">Mystery Box</h5>
                    <p class="text-muted">A massive surprise reward that will accelerate your fitness journey.</p>
                    <div class="locked-overlay">
                        <i class="fa-solid fa-lock text-muted mb-2" style="font-size: 24px;"></i>
                        <span class="font-weight-bold text-dark">Unlocks at 14-Day Streak</span>
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
