<?php
$title = "SUBI Tips";
$css = "Sub-tips.css"; 

ob_start();
?>

<div class="tips-page py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">
        <div class="tips-title text-center mb-5">
            <h2 class="font-weight-bold" style="color: var(--primary-dark);">SUBI Special Tips</h2>
            <p class="text-muted">Improve your lifestyle with smart daily habits.</p>
        </div>

        <div class="row g-4">
            
            <!-- Tip 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 text-center py-4">
                    <div style="font-size: 40px; color: var(--primary);" class="mb-3"><i class="fas fa-glass-water"></i></div>
                    <span class="badge badge-success mb-2 p-2">Nutrition</span>
                    <h4 class="font-weight-bold">Hydration Boost</h4>
                    <p class="text-muted mt-2" style="font-size: 14px;">Drink 2-3 liters of water daily to improve metabolism and energy levels.</p>
                    <button class="btn btn-outline-success mt-auto mx-auto" style="border-radius:8px;" data-toggle="modal" data-target="#tipModal1">Learn More</button>
                </div>
            </div>

            <!-- Tip 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 text-center py-4">
                    <div style="font-size: 40px; color: var(--primary);" class="mb-3"><i class="fas fa-dumbbell"></i></div>
                    <span class="badge badge-success mb-2 p-2">Workout</span>
                    <h4 class="font-weight-bold">Daily Exercise</h4>
                    <p class="text-muted mt-2" style="font-size: 14px;">30 minutes of daily exercise strengthens your heart and muscles.</p>
                    <button class="btn btn-outline-success mt-auto mx-auto" style="border-radius:8px;" data-toggle="modal" data-target="#tipModal2">Learn More</button>
                </div>
            </div>

            <!-- Tip 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 text-center py-4" style="background: linear-gradient(135deg, var(--bg-light), #e6fcf5); border: 2px solid var(--primary);">
                    <div style="font-size: 40px; color: var(--primary-dark);" class="mb-3"><i class="fas fa-bed"></i></div>
                    <span class="badge badge-success mb-2 p-2">Recovery</span>
                    <h4 class="font-weight-bold">Quality Sleep</h4>
                    <p class="text-muted mt-2" style="font-size: 14px;">Maintain 7-8 hours of sleep to enhance recovery and focus.</p>
                    <button class="btn btn-success mt-auto mx-auto" style="border-radius:8px;" data-toggle="modal" data-target="#tipModal3">Start Now</button>
                </div>
            </div>

            <!-- Tip 4 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 text-center py-4">
                    <div style="font-size: 40px; color: var(--primary);" class="mb-3"><i class="fas fa-apple-whole"></i></div>
                    <span class="badge badge-success mb-2 p-2">Diet</span>
                    <h4 class="font-weight-bold">Balanced Diet</h4>
                    <p class="text-muted mt-2" style="font-size: 14px;">Include proteins, carbs, and healthy fats in balanced proportions.</p>
                    <button class="btn btn-outline-success mt-auto mx-auto" style="border-radius:8px;" data-toggle="modal" data-target="#tipModal4">Learn More</button>
                </div>
            </div>

            <!-- Tip 5 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 text-center py-4">
                    <div style="font-size: 40px; color: var(--primary);" class="mb-3"><i class="fas fa-chart-line"></i></div>
                    <span class="badge badge-success mb-2 p-2">Tracking</span>
                    <h4 class="font-weight-bold">Track Progress</h4>
                    <p class="text-muted mt-2" style="font-size: 14px;">Weekly tracking helps you stay consistent and motivated.</p>
                    <button class="btn btn-outline-success mt-auto mx-auto" style="border-radius:8px;" data-toggle="modal" data-target="#tipModal5">Learn More</button>
                </div>
            </div>

            <!-- Tip 6 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 text-center py-4">
                    <div style="font-size: 40px; color: var(--primary);" class="mb-3"><i class="fas fa-brain"></i></div>
                    <span class="badge badge-success mb-2 p-2">Mind</span>
                    <h4 class="font-weight-bold">Mental Wellness</h4>
                    <p class="text-muted mt-2" style="font-size: 14px;">Practice meditation to reduce stress and improve concentration.</p>
                    <button class="btn btn-outline-success mt-auto mx-auto" style="border-radius:8px;" data-toggle="modal" data-target="#tipModal6">Learn More</button>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="tipModal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content p-4 text-center">
      <h3 class="font-weight-bold text-success mb-3">💧 Hydration Framework</h3>
      <p class="text-muted">Start your morning with a large glass of water. Keep a bottle at your desk and aim to refill it at least 3 times a day. Sipping consistently is much better than chugging all at once.</p>
      <button class="btn btn-success mt-3" data-dismiss="modal">Got it!</button>
    </div>
  </div>
</div>

<div class="modal fade" id="tipModal2" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content p-4 text-center">
      <h3 class="font-weight-bold text-success mb-3">🏃 Workout Plan</h3>
      <p class="text-muted">Break your 30 minutes into two 15-minute bursts if you're strapped for time. Bodyweight exercises at home (like pushups, squats, and planks) are an excellent start.</p>
      <button class="btn btn-success mt-3" data-dismiss="modal">Got it!</button>
    </div>
  </div>
</div>

<div class="modal fade" id="tipModal3" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content p-4 text-center">
      <h3 class="font-weight-bold text-success mb-3">🌙 Sleep Hygiene</h3>
      <p class="text-muted">Lower the temperature in your room slightly and completely remove screen exposure 1 hour before bed. Deep sleep is mathematically when your muscles grow and recover!</p>
      <button class="btn btn-success mt-3" data-dismiss="modal">Got it!</button>
    </div>
  </div>
</div>

<div class="modal fade" id="tipModal4" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content p-4 text-center">
      <h3 class="font-weight-bold text-success mb-3">🥗 Dietary Routine</h3>
      <p class="text-muted">Aim for the "Plate Rule": 50% color (vegetables), 25% clean protein (chicken, tofu, beans), and 25% complex carbs (rice, quinoa). Avoid hidden liquid calories.</p>
      <button class="btn btn-success mt-3" data-dismiss="modal">Got it!</button>
    </div>
  </div>
</div>

<div class="modal fade" id="tipModal5" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content p-4 text-center">
      <h3 class="font-weight-bold text-success mb-3">📈 Tracking Strategy</h3>
      <p class="text-muted">Weigh yourself once a week, ideally at the same time in the morning. Better yet, track how your clothes feel or your energy levels throughout the week rather than just staring at numbers.</p>
      <button class="btn btn-success mt-3" data-dismiss="modal">Got it!</button>
    </div>
  </div>
</div>

<div class="modal fade" id="tipModal6" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content p-4 text-center">
      <h3 class="font-weight-bold text-success mb-3">🧘 Mental Framework</h3>
      <p class="text-muted">Box breathing (4s inhale, 4s hold, 4s exhale, 4s hold) can immediately drop cortisol levels. Stress triggers fat retention, so relaxing is a core part of physical health!</p>
      <button class="btn btn-success mt-3" data-dismiss="modal">Got it!</button>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
// We add Sub-tips CSS context so it loads both general and sub-tips if needed.
$css = "register-dashboard.css";
include("../includes/user_layout.php");
?>
