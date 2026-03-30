<?php
$title = "Dashboard - Health & Wellness";
$css = "register-dashboard.css"; 

ob_start();
?>
    <!-- Register Dashboard Content -->
    <div class="container-fluid" style="flex: 1; padding: 0;">
      <div class="row m-0" style="min-height: calc(100vh - 70px);">

         <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 bg-success p-0">
          <div class="sticky-top sidebar"> 
            <nav class="nav flex-column">
              <a class="nav-link active sidebar-link" href="register-dashboard.php">
                <i class="fa-solid fa-gauge"></i> 
                <span class="d-none d-sm-inline">Dashboard</span>
              </a>

              <hr class="sidebar-divider">

              <a class="nav-link sidebar-link" href="meal-plans.php">
                <i class="fa-solid fa-bowl-food"></i> 
                <span class="d-none d-sm-inline">Meal Plans</span>
              </a>

              <a class="nav-link sidebar-link" href="Exercise-plans.php">
                <i class="fa-solid fa-dumbbell"></i> 
                <span class="d-none d-sm-inline">Exercise Plans</span>
              </a>

              <a class="nav-link sidebar-link" href="progress.php">
                <i class="fa-solid fa-bars-progress"></i> 
                <span class="d-none d-sm-inline">Progress Data</span>
              </a>

              <a class="nav-link sidebar-link" href="Sub-tips.php">
                <i class="fa-solid fa-lightbulb"></i> 
                <span class="d-none d-sm-inline">SUBI Tips</span>
              </a>

              <!-- NEW: Manage Plans -->
              <a class="nav-link sidebar-link" href="manage-plans.php">
                <i class="fa-solid fa-clipboard-list"></i> 
                <span class="d-none d-sm-inline">Manage Plans</span>
              </a>

              <!-- NEW: Support -->
              <a class="nav-link sidebar-link" href="support.php">
                <i class="fa-solid fa-headset"></i> 
                <span class="d-none d-sm-inline">Support</span>
              </a>

              <hr class="sidebar-divider pt-4 mt-auto">

              <a class="nav-link sidebar-link" href="../login.php">
                <i class="fa-solid fa-right-from-bracket"></i> 
                <span class="d-none d-sm-inline">Logout</span>
              </a>
            </nav>
          </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4" style="background-color: var(--bg-light);">
          <div class="d-flex justify-content-between align-items-center mb-4">
              <h2 class="font-weight-bold m-0" style="color: var(--text-main);">Welcome Back!</h2>
              <span class="text-muted"><?php echo date('l, F j, Y'); ?></span>
          </div>

          <div class="row g-4 mb-5">
            <!-- Card 1 -->
            <div class="col-12 col-sm-6 col-xl-3 mb-4">
              <div class="stat-card">
                <i class="fa-solid fa-stopwatch stat-icon"></i>
                <h5>Total Sessions</h5>
                <h2>1,250</h2>
                <p class="text-success"><i class="fa-solid fa-arrow-up"></i> 12% from last week</p>
              </div>
            </div>

            <!-- Card 2 -->
            <div class="col-12 col-sm-6 col-xl-3 mb-4">
              <div class="stat-card">
                <i class="fa-solid fa-coins stat-icon"></i>
                <h5>Credits Balance</h5>
                <h2>850</h2>
                <p>Available credits</p>
              </div>
            </div>

            <!-- Card 3 -->
            <div class="col-12 col-sm-6 col-xl-3 mb-4">
              <div class="stat-card">
                <i class="fa-solid fa-calendar-check stat-icon"></i>
                <h5>Days Active</h5>
                <h2>12</h2>
                <p>Out of 30 this month</p>
              </div>
            </div>

            <!-- Card 4 -->
            <div class="col-12 col-sm-6 col-xl-3 mb-4">
              <div class="stat-card">
                <i class="fa-solid fa-fire stat-icon"></i>
                <h5>Streak</h5>
                <h2>4 Days</h2>
                <p class="text-warning"><i class="fa-solid fa-star"></i> Keep it up!</p>
              </div>
            </div>
          </div>

          <div class="row">
              <div class="col-lg-8 mb-4">
                  <div class="activity-card h-100 m-0">
                      <h4 class="font-weight-bold mb-4">Recent Activity</h4>
                      <div class="d-flex align-items-center mb-3">
                          <div class="bg-success text-white rounded p-2 mr-3"><i class="fa-solid fa-dumbbell"></i></div>
                          <div class="flex-grow-1">
                              <h6 class="m-0 font-weight-bold">Completed HIIT Workout</h6>
                              <small class="text-muted">Today at 8:30 AM</small>
                          </div>
                      </div>
                      <div class="d-flex align-items-center mb-3">
                          <div class="bg-info text-white rounded p-2 mr-3"><i class="fa-solid fa-bowl-food"></i></div>
                          <div class="flex-grow-1">
                              <h6 class="m-0 font-weight-bold">Logged High Protein Breakfast</h6>
                              <small class="text-muted">Today at 9:15 AM</small>
                          </div>
                      </div>
                      <div class="d-flex align-items-center mb-3">
                          <div class="bg-warning text-white rounded p-2 mr-3"><i class="fa-solid fa-medal"></i></div>
                          <div class="flex-grow-1">
                              <h6 class="m-0 font-weight-bold">Achieved 10k Steps Goal</h6>
                              <small class="text-muted">Yesterday at 6:45 PM</small>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="col-lg-4 mb-4">
                  <div class="activity-card h-100 m-0 text-center d-flex flex-column justify-content-center align-items-center">
                      <h4 class="font-weight-bold mb-3">Next Milestone</h4>
                      <div class="spinner-border text-success mb-3" role="status" style="width: 3rem; height: 3rem;">
                          <span class="sr-only">Loading...</span>
                      </div>
                      <p class="text-muted mb-0">5 Workout Sessions away from Level 3!</p>
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
