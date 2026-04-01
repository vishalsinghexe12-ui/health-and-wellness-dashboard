<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}
require_once("../db_config.php");

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'User';

// Fetch total purchased plans
$q1 = $con->prepare("SELECT COUNT(*) as total FROM user_purchases WHERE user_id = ?");
$q1->bind_param("i", $user_id);
$q1->execute();
$total_plans = $q1->get_result()->fetch_assoc()['total'];

// Fetch total amount spent
$q2 = $con->prepare("SELECT COALESCE(SUM(price), 0) as total_spent FROM user_purchases WHERE user_id = ?");
$q2->bind_param("i", $user_id);
$q2->execute();
$total_spent = $q2->get_result()->fetch_assoc()['total_spent'];

// Fetch wellness profile
$q3 = $con->prepare("SELECT * FROM user_wellness_profiles WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$q3->bind_param("i", $user_id);
$q3->execute();
$wellness = $q3->get_result()->fetch_assoc();

// Fetch account creation date
$q4 = $con->prepare("SELECT id FROM register WHERE id = ?");
$q4->bind_param("i", $user_id);
$q4->execute();
$q4->get_result();

// Recent purchases (last 5)
$q5 = $con->prepare("SELECT plan_name, price, purchase_date, duration FROM user_purchases WHERE user_id = ? ORDER BY purchase_date DESC LIMIT 5");
$q5->bind_param("i", $user_id);
$q5->execute();
$recent_purchases = $q5->get_result()->fetch_all(MYSQLI_ASSOC);

// BMI data
$bmi = $wellness ? $wellness['bmi'] : null;
$fitness_goal = $wellness ? $wellness['fitness_goal'] : null;

$title = "Dashboard - Health & Wellness";
$css = "register-dashboard.css"; 

ob_start();
?>
    <!-- Register Dashboard Content -->
    <div class="container-fluid" style="flex: 1; padding: 0;">
      <div class="row m-0" style="min-height: calc(100vh - 70px);">

        <!-- Main Content -->
        <div class="col-12 py-4 px-5" style="background-color: var(--bg-light);">
          <?php if (isset($_SESSION['login_success'])): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <i class="fa-solid fa-circle-check mr-2"></i> <?php echo $_SESSION['login_success']; unset($_SESSION['login_success']); ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          <?php endif; ?>

          <!-- Greeting -->
          <div class="d-flex justify-content-between align-items-center mb-4">
              <div>
                  <h2 class="font-weight-bold m-0" style="color: var(--text-main);">Welcome Back, <?php echo htmlspecialchars(explode(' ', $user_name)[0]); ?>! 👋</h2>
                  <p class="text-muted m-0 mt-1">Here's an overview of your wellness journey.</p>
              </div>
              <span class="text-muted"><?php echo date('l, F j, Y'); ?></span>
          </div>

          <!-- Stat Cards -->
          <div class="row g-4 mb-5">
            <!-- Card 1: Active Plans -->
            <div class="col-12 col-sm-6 col-xl-3 mb-4">
              <div class="stat-card" style="border-left: 4px solid #10b981;">
                <div class="d-flex align-items-center mb-2">
                    <div style="width:45px; height:45px; border-radius:12px; background:rgba(16,185,129,0.1); display:flex; align-items:center; justify-content:center; margin-right:12px;">
                        <i class="fa-solid fa-clipboard-list" style="font-size:20px; color:#10b981;"></i>
                    </div>
                    <div>
                        <p class="text-muted m-0" style="font-size:13px;">Active Plans</p>
                        <h3 class="m-0 font-weight-bold"><?php echo $total_plans; ?></h3>
                    </div>
                </div>
                <a href="manage-plans.php" class="text-success" style="font-size:13px;">View plans →</a>
              </div>
            </div>

            <!-- Card 2: Activity Level -->
            <div class="col-12 col-sm-6 col-xl-3 mb-4">
              <div class="stat-card" style="border-left: 4px solid #3b82f6;">
                <div class="d-flex align-items-center mb-2">
                    <div style="width:45px; height:45px; border-radius:12px; background:rgba(59,130,246,0.1); display:flex; align-items:center; justify-content:center; margin-right:12px;">
                        <i class="fa-solid fa-gauge-high" style="font-size:20px; color:#3b82f6;"></i>
                    </div>
                    <div>
                        <p class="text-muted m-0" style="font-size:13px;">Activity Level</p>
                        <h3 class="m-0 font-weight-bold" style="font-size:18px;"><?php echo $wellness ? htmlspecialchars($wellness['activity_level']) : 'Not Set'; ?></h3>
                    </div>
                </div>
                <a href="wellness-quiz.php" class="text-success" style="font-size:13px;">Update level →</a>
              </div>
            </div>

            <!-- Card 3: BMI Score -->
            <div class="col-12 col-sm-6 col-xl-3 mb-4">
              <div class="stat-card" style="border-left: 4px solid #f59e0b;">
                <div class="d-flex align-items-center mb-2">
                    <div style="width:45px; height:45px; border-radius:12px; background:rgba(245,158,11,0.1); display:flex; align-items:center; justify-content:center; margin-right:12px;">
                        <i class="fa-solid fa-heart-pulse" style="font-size:20px; color:#f59e0b;"></i>
                    </div>
                    <div>
                        <p class="text-muted m-0" style="font-size:13px;">BMI Score</p>
                        <h3 class="m-0 font-weight-bold"><?php echo $bmi ? $bmi : '—'; ?></h3>
                    </div>
                </div>
                <?php if (!$bmi): ?>
                    <a href="wellness-quiz.php" class="text-success" style="font-size:13px;">Take quiz →</a>
                <?php else: ?>
                    <a href="my-recommendations.php" class="text-success" style="font-size:13px;">View recommendations →</a>
                <?php endif; ?>
              </div>
            </div>

            <!-- Card 4: Fitness Goal -->
            <div class="col-12 col-sm-6 col-xl-3 mb-4">
              <div class="stat-card" style="border-left: 4px solid #8b5cf6;">
                <div class="d-flex align-items-center mb-2">
                    <div style="width:45px; height:45px; border-radius:12px; background:rgba(139,92,246,0.1); display:flex; align-items:center; justify-content:center; margin-right:12px;">
                        <i class="fa-solid fa-bullseye" style="font-size:20px; color:#8b5cf6;"></i>
                    </div>
                    <div>
                        <p class="text-muted m-0" style="font-size:13px;">Fitness Goal</p>
                        <h3 class="m-0 font-weight-bold" style="font-size:18px;"><?php echo $fitness_goal ? htmlspecialchars($fitness_goal) : 'Not Set'; ?></h3>
                    </div>
                </div>
                <a href="wellness-quiz.php" class="text-success" style="font-size:13px;"><?php echo $fitness_goal ? 'Update goal →' : 'Set goal →'; ?></a>
              </div>
            </div>
          </div>

          <!-- Bottom Row -->
          <div class="row">
              <!-- Recent Purchases -->
              <div class="col-lg-8 mb-4">
                  <div class="activity-card h-100 m-0">
                      <h4 class="font-weight-bold mb-4"><i class="fa-solid fa-clock-rotate-left mr-2 text-success"></i>Recent Purchases</h4>
                      <?php if (count($recent_purchases) > 0): ?>
                          <?php foreach ($recent_purchases as $purchase): ?>
                          <div class="d-flex align-items-center mb-3 pb-3" style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                              <div class="bg-success text-white rounded p-2 mr-3" style="width:40px; height:40px; display:flex; align-items:center; justify-content:center; border-radius:10px !important;">
                                  <i class="fa-solid fa-bag-shopping"></i>
                              </div>
                              <div class="flex-grow-1">
                                  <h6 class="m-0 font-weight-bold"><?php echo htmlspecialchars($purchase['plan_name']); ?></h6>
                                  <div class="d-flex align-items-center">
                                      <small class="text-muted mr-2"><?php echo date('M j, Y', strtotime($purchase['purchase_date'])); ?></small>
                                      <?php if(!empty($purchase['duration'])): ?>
                                          <small class="badge badge-soft-success" style="font-size: 10px; background: rgba(16, 185, 129, 0.08); color: #10b981; border-radius: 4px; padding: 1px 6px;">
                                              Valid until <?php echo date('M j, Y', strtotime($purchase['purchase_date'] . " + " . $purchase['duration'])); ?>
                                          </small>
                                      <?php endif; ?>
                                  </div>
                              </div>
                              <span class="font-weight-bold" style="color: var(--primary-dark);">₹<?php echo number_format($purchase['price']); ?></span>
                          </div>
                          <?php endforeach; ?>
                          <a href="manage-plans.php" class="btn btn-outline-success btn-sm mt-2" style="border-radius: 8px;">View All Plans</a>
                      <?php else: ?>
                          <div class="text-center py-4">
                              <i class="fa-solid fa-cart-shopping text-muted mb-3" style="font-size: 40px; opacity: 0.4;"></i>
                              <p class="text-muted mb-3">You haven't purchased any plans yet.</p>
                              <a href="meal-plans.php" class="btn btn-success btn-sm" style="border-radius: 8px;">Browse Plans</a>
                          </div>
                      <?php endif; ?>
                  </div>
              </div>

              <!-- Quick Actions -->
              <div class="col-lg-4 mb-4">
                  <div class="activity-card h-100 m-0">
                      <h4 class="font-weight-bold mb-4"><i class="fa-solid fa-bolt mr-2 text-warning"></i>Quick Actions</h4>
                      
                      <a href="wellness-quiz.php" class="d-flex align-items-center mb-3 p-3 text-decoration-none" style="background: rgba(16,185,129,0.06); border-radius: 12px; border: 1px solid rgba(16,185,129,0.12); transition: all 0.3s;" onmouseover="this.style.transform='translateX(5px)'" onmouseout="this.style.transform='translateX(0)'">
                          <div style="width:40px; height:40px; border-radius:10px; background:#10b981; display:flex; align-items:center; justify-content:center; margin-right:12px;">
                              <i class="fa-solid fa-heart-pulse text-white"></i>
                          </div>
                          <div>
                              <h6 class="m-0 font-weight-bold text-dark">Wellness Quiz</h6>
                              <small class="text-muted">Get personalized plans</small>
                          </div>
                      </a>

                      <a href="meal-plans.php" class="d-flex align-items-center mb-3 p-3 text-decoration-none" style="background: rgba(59,130,246,0.06); border-radius: 12px; border: 1px solid rgba(59,130,246,0.12); transition: all 0.3s;" onmouseover="this.style.transform='translateX(5px)'" onmouseout="this.style.transform='translateX(0)'">
                          <div style="width:40px; height:40px; border-radius:10px; background:#3b82f6; display:flex; align-items:center; justify-content:center; margin-right:12px;">
                              <i class="fa-solid fa-bowl-food text-white"></i>
                          </div>
                          <div>
                              <h6 class="m-0 font-weight-bold text-dark">Browse Meal Plans</h6>
                              <small class="text-muted">Explore nutrition options</small>
                          </div>
                      </a>

                      <a href="Exercise-plans.php" class="d-flex align-items-center mb-3 p-3 text-decoration-none" style="background: rgba(245,158,11,0.06); border-radius: 12px; border: 1px solid rgba(245,158,11,0.12); transition: all 0.3s;" onmouseover="this.style.transform='translateX(5px)'" onmouseout="this.style.transform='translateX(0)'">
                          <div style="width:40px; height:40px; border-radius:10px; background:#f59e0b; display:flex; align-items:center; justify-content:center; margin-right:12px;">
                              <i class="fa-solid fa-dumbbell text-white"></i>
                          </div>
                          <div>
                              <h6 class="m-0 font-weight-bold text-dark">Browse Exercise Plans</h6>
                              <small class="text-muted">Find your workout routine</small>
                          </div>
                      </a>

                      <a href="my-profile.php" class="d-flex align-items-center p-3 text-decoration-none" style="background: rgba(139,92,246,0.06); border-radius: 12px; border: 1px solid rgba(139,92,246,0.12); transition: all 0.3s;" onmouseover="this.style.transform='translateX(5px)'" onmouseout="this.style.transform='translateX(0)'">
                          <div style="width:40px; height:40px; border-radius:10px; background:#8b5cf6; display:flex; align-items:center; justify-content:center; margin-right:12px;">
                              <i class="fa-solid fa-user-pen text-white"></i>
                          </div>
                          <div>
                              <h6 class="m-0 font-weight-bold text-dark">Edit Profile</h6>
                              <small class="text-muted">Update your details</small>
                          </div>
                      </a>
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
