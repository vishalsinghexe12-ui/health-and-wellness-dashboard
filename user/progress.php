<?php
$title = "Registered User";
$css = "register-dashboard.css"; 

ob_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Progress</title>
    <meta charset="UTF-8">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .dashboard-container {
            max-width: 1000px;
            margin: 40px auto;
        }

        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .stat-card {
            padding: 20px;
        }

        .stat-title {
            font-size: 14px;
            color: gray;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 600;
            color: #1f7a5c;
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 20px;
        }

        .activity-item {
            padding: 8px 0;
        }
    </style>
</head>
<body>

<?php
// Static Data
$currentWeight = 65;
$goalWeight = 60;
$workoutsCompleted = 18;
$bmi = 22.4;

$weightData = [70, 69, 68, 67, 66, 65.5, 65];
$dates = ["Apr 1", "Apr 8", "Apr 15", "Apr 22", "Apr 29", "May 6", "May 13"];
?>

<div class="dashboard-container">
    <div class="mb-4">
                <a href="javascript:history.back()" class="back-btn d-inline-flex align-items-center">
                    <span class="back-icon">
                        <i class="fa-solid fa-arrow-left"></i>
                    </span>
                    <span class="ml-2">Back</span>
                </a>
    </div>
    <h2 class="mb-1">My Progress</h2>
    <p class="text-muted">Track your fitness journey</p>

    <!-- Top Stats -->
    <div class="row g-3 mb-4" >

        <div class="col-md-3" >
            <div class="card card-custom stat-card" >
                <div class="stat-title text-white" >Current Weight</div>
                <div class="stat-value text-white" ><?php echo $currentWeight; ?> kg</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-custom stat-card">
                <div class="stat-title text-white">Goal Weight</div>
                <div class="stat-value text-white"><?php echo $goalWeight; ?> kg</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-custom stat-card">
                <div class="stat-title text-white">Workouts Completed</div>
                <div class="stat-value text-white"><?php echo $workoutsCompleted; ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-custom stat-card">
                <div class="stat-title text-white">BMI</div>
                <div class="stat-value text-white"><?php echo $bmi; ?></div>
            </div>
        </div>

    </div>

    <!-- Weight Progress Chart -->
    <div class="card card-custom p-4 mb-4">
        <h5 class="section-title">Weight Progress</h5>
        <canvas id="weightChart"></canvas>
    </div>

    <!-- Recent Activity -->
    <div class="card card-custom p-4">
        <h5 class="section-title">Recent Activity</h5>

        <div class="activity-item">✅ Completed Full Body Workout</div>
        <div class="activity-item">✅ Logged 1500 Calories</div>
        <div class="activity-item">✅ Drank 2 Liters Water</div>
    </div>

</div>

<script>
const ctx = document.getElementById('weightChart').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dates); ?>,
        datasets: [{
            label: 'Weight (kg)',
            data: <?php echo json_encode($weightData); ?>,
            borderColor: '#1f7a5c',
            backgroundColor: 'white',
            tension: 0.4,
            fill: true,
            pointRadius: 4
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

</body>
</html>

<?php
$content = ob_get_clean();
include("../includes/registered_layout.php");
?>
