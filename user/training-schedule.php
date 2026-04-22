<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}
require_once("../db_config.php");

$plan_name = $_GET['plan'] ?? '';
if (empty($plan_name)) {
    header("Location: manage-plans.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$chk = $con->prepare("SELECT * FROM user_purchases WHERE user_id = ? AND plan_name = ? LIMIT 1");
$chk->bind_param("is", $user_id, $plan_name);
$chk->execute();
$res = $chk->get_result();

if ($res->num_rows === 0) {
    // Or maybe just show it anyway, but strictly user has to purchase it.
    // We'll allow it if they reached here, just to be safe. But strict is better.
    header("Location: manage-plans.php");
    exit();
}
$purchase = $res->fetch_assoc();

$pq = $con->prepare("SELECT * FROM plans WHERE title = ? LIMIT 1");
$pq->bind_param("s", $plan_name);
$pq->execute();
$plan_details = $pq->get_result()->fetch_assoc();
$intensity = $plan_details ? $plan_details['intensity'] : 'Moderate';
$duration = $plan_details ? $plan_details['duration'] : '3 Months';

$title = "Training Schedule - " . htmlspecialchars($plan_name);
$css = "register-dashboard.css"; 

ob_start();
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">
        <!-- Header -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; overflow: hidden;">
            <div class="card-body p-5">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <span class="badge badge-success mb-2 px-3 py-2" style="border-radius: 8px;">Personalized Schedule</span>
                        <h2 class="font-weight-bold mb-3" style="color: var(--primary-dark);"><?php echo htmlspecialchars($plan_name); ?></h2>
                        <p class="text-muted mb-0">Follow this carefully curated schedule to maximize your results for this specific training block.</p>
                    </div>
                    <div class="col-md-4 text-md-right mt-4 mt-md-0">
                        <div class="d-inline-block text-left" style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.1); border-radius: 12px; padding: 15px 20px;">
                            <p class="m-0 text-muted" style="font-size: 13px; text-transform: uppercase; font-weight: 700;">Intensity</p>
                            <h5 class="m-0 font-weight-bold text-success"><?php echo htmlspecialchars($intensity); ?></h5>
                            <hr class="my-2" style="border-color: rgba(16,185,129,0.1);">
                            <p class="m-0 text-muted" style="font-size: 13px; text-transform: uppercase; font-weight: 700;">Duration</p>
                            <h5 class="m-0 font-weight-bold text-success"><?php echo htmlspecialchars($duration); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weekly Schedule Timeline -->
        <div class="row">
            <div class="col-lg-8">
                <?php
                $has_custom_schedule = false;
                $custom_schedule = [];
                if (!empty($plan_details['schedule_data'])) {
                    $decoded = json_decode($plan_details['schedule_data'], true);
                    if (is_array($decoded) && count($decoded) > 0) {
                        $has_custom_schedule = true;
                        $custom_schedule = $decoded;
                    }
                }

                if ($has_custom_schedule) {
                    // RENDER CUSTOM SCHEDULE
                    foreach ($custom_schedule as $wIndex => $week) {
                        $wNum = $wIndex + 1;
                        $is_locked = ($wNum > 1); // Only week 1 unlocked
                        $border_color = $is_locked ? '#cbd5e1' : 'var(--primary)';
                        
                        echo '<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; border-left: 5px solid '.$border_color.' !important;">';
                        echo '<div class="card-body p-4">';
                        
                        $week_title = htmlspecialchars($week['title'] ?? "Week $wNum");
                        if ($is_locked) {
                            $week_title .= " <small class='ml-2 font-weight-normal'>(Locked)</small>";
                        }
                        
                        echo '<h4 class="font-weight-bold mb-3 ' . ($is_locked ? 'text-muted' : '') . '">' . $week_title . '</h4>';

                        if ($is_locked) {
                            echo '<p class="text-muted">Complete previous weeks to unlock this content.</p>';
                        } else {
                            echo '<div class="list-group list-group-flush">';
                            if (!empty($week['days']) && is_array($week['days'])) {
                                foreach ($week['days'] as $day) {
                                    $is_recovery = !empty($day['is_recovery']);
                                    $activity = htmlspecialchars($day['activity']);
                                    $mins = htmlspecialchars($day['duration']);
                                    $dLabel = htmlspecialchars($day['day']);
                                    
                                    $style_class = $is_recovery ? "text-muted" : "text-dark";
                                    $badge_class = $is_recovery ? "badge-light text-muted" : "badge-light text-dark";
                                    $bg_style = '';
                                    
                                    // Visual flair
                                    if (!$is_recovery && rand(1, 10) > 6) {
                                        $bg_style = 'background: rgba(16,185,129,0.05); border-radius: 8px; padding: 10px !important; margin-top: 5px;';
                                        $style_class = "text-success";
                                        $badge_class = "badge-success text-white";
                                    }
                                    
                                    echo '<div class="list-group-item px-0 border-0 d-flex justify-content-between align-items-center" style="'.$bg_style.'">';
                                    echo '<div><span class="font-weight-bold mr-3 '.$style_class.'">Day ' . $dLabel . '</span> <span class="'.$style_class.'">';
                                    if ($is_recovery) echo '<i class="fa-solid fa-bed mr-2 text-muted"></i>';
                                    echo $activity . '</span></div>';
                                    echo '<span class="badge '.$badge_class.' p-2">' . $mins . '</span>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p class="text-muted small mb-0">No days added for this week.</p>';
                            }
                            echo '</div>';
                        }
                        echo '</div></div>';
                    }
                } else {
                    // FALLBACK: Generate a pseudo-random persistent schedule for THIS specific plan
                    $seed = crc32($plan_name);
                    srand($seed);

                    // Banks of activities by category
                    $type = $plan_details ? $plan_details['type'] : 'Exercise';
                    $banks = [
                        'Exercise' => [
                            'High' => ['HIIT Sprints', 'Heavy Squats & Deadlifts', 'Crossfit AMRAP', 'Plyometric Jumps', 'Olympic Weightlifting', 'Tabata Rounds', 'Max Effort Bench Press', 'Burpee Madness'],
                            'Medium' => ['Dumbbell Circuit', 'Steady State Jogging', 'Bodyweight Mastery', 'Kettlebell Swings', 'Resistance Band Work', 'Core Stability', 'Functional Training', 'Cycling'],
                            'Low' => ['Power Walking', 'Light Stretching', 'Tai Chi', 'Active Recovery Walk', 'Beginner Yoga Flow', 'Joint Mobility', 'Pilates Basics', 'Posture Correction']
                        ],
                        'Wellness' => [
                            'High' => ['Advanced Breathwork', 'Cold Exposure Therapy', 'Intense Vinyasa', 'Silent Meditation Walk'],
                            'Medium' => ['Mindfulness Session', 'Guided Meditation', 'Nature Immersion', 'Sound Bath Therapy'],
                            'Low' => ['Gratitude Journaling', 'Basic Stretching', 'Hydration Tracking', 'Sleep Prep Routine']
                        ],
                        'Meal' => [
                            'High' => ['Strict Macro Prep', 'Intermittent Fasting (16:8)', 'Advanced Carb Cycling', 'Caloric Deficit Meal'],
                            'Medium' => ['Balanced Plate Prep', 'Whole Foods Focus', 'Sugar Elimination Day', 'Protein Boost Meal'],
                            'Low' => ['Mindful Eating Practice', 'Vegetable Add-in day', 'Hydration Focus', 'Healthy Snacking']
                        ]
                    ];

                    // Determine pool
                    $pool = $banks[$type][$intensity] ?? $banks['Exercise']['Medium'];
                    $alt_pool = $banks[$type]['Low'] ?? $banks['Exercise']['Low']; // For recovery days

                    // Number of weeks based on duration string (e.g. "3 Months" -> ~12 weeks). We'll show first 3 weeks.
                    $weeks_to_show = 3;

                    for ($w = 1; $w <= $weeks_to_show; $w++) {
                        $is_locked = ($w > 1); // Only week 1 is unlocked for demo
                        $border_color = $is_locked ? '#cbd5e1' : 'var(--primary)';
                        $week_title = $is_locked ? "Week $w: Progression <small class='ml-2 font-weight-normal'>(Locked)</small>" : "Week $w: Fundamentals";
                        
                        echo '<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; border-left: 5px solid '.$border_color.' !important;">';
                        echo '<div class="card-body p-4">';
                        echo '<h4 class="font-weight-bold mb-3 ' . ($is_locked ? 'text-muted' : '') . '">' . $week_title . '</h4>';
                        
                        if ($is_locked) {
                            echo '<p class="text-muted">Complete previous weeks to unlock this content.</p>';
                        } else {
                            echo '<div class="list-group list-group-flush">';
                            for ($d = 1; $d <= 5; $d++) {
                                // 20% chance of recovery day
                                $is_recovery = (rand(1, 10) > 8);
                                if ($is_recovery) {
                                    $activity = $alt_pool[array_rand($alt_pool)];
                                    $mins = rand(15, 25);
                                    $style_class = "text-muted";
                                    $badge_class = "badge-light text-muted";
                                    $bg_style = '';
                                } else {
                                    $activity = $pool[array_rand($pool)];
                                    $mins = rand(30, 60);
                                    $style_class = ($d == 3 || $d == 5) ? "text-success" : "text-dark";
                                    $badge_class = ($d == 3 || $d == 5) ? "badge-success text-white" : "badge-light text-dark";
                                    $bg_style = ($d == 3 || $d == 5) ? 'background: rgba(16,185,129,0.05); border-radius: 8px; padding: 10px !important; margin-top: 5px;' : '';
                                }
                                
                                echo '<div class="list-group-item px-0 border-0 d-flex justify-content-between align-items-center" style="'.$bg_style.'">';
                                echo '<div><span class="font-weight-bold mr-3 '.$style_class.'">Day ' . $d . '</span> <span class="'.$style_class.'">' . $activity . '</span></div>';
                                echo '<span class="badge '.$badge_class.' p-2">' . $mins . ' Min</span>';
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        
                        echo '</div></div>';
                    }
                }
                ?>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: linear-gradient(135deg, #0f172a, #1e293b); color: white;">
                    <div class="card-body p-4">
                        <h5 class="font-weight-bold mb-3"><i class="fa-solid fa-fire mr-2 text-warning"></i> Quick <?php echo $type; ?> Tips</h5>
                        <ul class="list-unstyled mb-0" style="font-size: 14px; opacity: 0.9;">
                            <li class="mb-3"><i class="fa-solid fa-check text-success mr-2"></i> Stay consistent. Consistency beats intensity over the long term.</li>
                            <li class="mb-3"><i class="fa-solid fa-check text-success mr-2"></i> Track your daily metrics to adjust intensity as needed.</li>
                            <li><i class="fa-solid fa-check text-success mr-2"></i> Ensure proper recovery to maximize the benefits of this <?php echo strtolower($type); ?> plan.</li>
                        </ul>
                    </div>
                </div>
                
                <a href="manage-plans.php" class="btn btn-outline-secondary btn-block font-weight-bold" style="border-radius: 8px;">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back to Plans
                </a>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
