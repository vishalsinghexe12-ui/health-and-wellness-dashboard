<?php
$title = "My Progress - Health & Wellness";
$css = "register-dashboard.css"; 

ob_start();
?>

<?php
// Static Data
$currentWeight = 65;
$goalWeight = 60;
$workoutsCompleted = 18;
$bmi = 22.4;

$weightData = [70, 69, 68, 67, 66, 65.5, 65];
$dates = ["Apr 1", "Apr 8", "Apr 15", "Apr 22", "Apr 29", "May 6", "May 13"];
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);">My Progress</h2>
            <p class="text-muted">Track your fitness journey</p>
        </div>

        <!-- Top Stats -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, var(--primary), var(--accent));">
                    <div style="font-size:14px; color:rgba(255,255,255,0.8);">Current Weight</div>
                    <div style="font-size:22px; font-weight:700; color:#fff;"><?php echo $currentWeight; ?> kg</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, var(--primary), var(--accent));">
                    <div style="font-size:14px; color:rgba(255,255,255,0.8);">Goal Weight</div>
                    <div style="font-size:22px; font-weight:700; color:#fff;"><?php echo $goalWeight; ?> kg</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, var(--primary), var(--accent));">
                    <div style="font-size:14px; color:rgba(255,255,255,0.8);">Workouts Completed</div>
                    <div style="font-size:22px; font-weight:700; color:#fff;"><?php echo $workoutsCompleted; ?></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, var(--primary), var(--accent));">
                    <div style="font-size:14px; color:rgba(255,255,255,0.8);">BMI</div>
                    <div style="font-size:22px; font-weight:700; color:#fff;"><?php echo $bmi; ?></div>
                </div>
            </div>
        </div>

        <!-- Weight Progress Chart -->
        <div class="stat-card p-4 mb-4">
            <h5 class="font-weight-bold mb-3" style="color: var(--text-main);">Weight Progress</h5>
            <canvas id="weightChart"></canvas>
        </div>

        <!-- Recent Activity -->
        <div class="stat-card p-4">
            <h5 class="font-weight-bold mb-3" style="color: var(--text-main);">Recent Activity</h5>
            <div style="padding:8px 0;">✅ Completed Full Body Workout</div>
            <div style="padding:8px 0;">✅ Logged 1500 Calories</div>
            <div style="padding:8px 0;">✅ Drank 2 Liters Water</div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('weightChart').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dates); ?>,
        datasets: [{
            label: 'Weight (kg)',
            data: <?php echo json_encode($weightData); ?>,
            borderColor: '#059669',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: '#059669'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});
</script>

<?php
$content = ob_get_clean();
include("../includes/registered_layout.php");
?>
