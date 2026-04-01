<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}
require_once("../db_config.php");

$user_id = $_SESSION['user_id'];

// Fetch user's wellness profile
$stmt = $con->prepare("SELECT * FROM user_wellness_profiles WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$profile = $stmt->get_result()->fetch_assoc();

if (!$profile) {
    $_SESSION['auth_flash'] = "Please take the wellness quiz first to get personalized recommendations.";
    header("Location: wellness-quiz.php");
    exit();
}

// BMI category
$bmi = $profile['bmi'];
if ($bmi < 18.5) {
    $bmi_category = "Underweight";
    $bmi_color = "#f59e0b";
    $bmi_advice = "Consider a calorie-surplus diet to gain healthy weight.";
} elseif ($bmi < 25) {
    $bmi_category = "Normal";
    $bmi_color = "#10b981";
    $bmi_advice = "Great! Maintain your healthy weight with balanced nutrition.";
} elseif ($bmi < 30) {
    $bmi_category = "Overweight";
    $bmi_color = "#f97316";
    $bmi_advice = "Focus on calorie deficit and regular exercise.";
} else {
    $bmi_category = "Obese";
    $bmi_color = "#ef4444";
    $bmi_advice = "Consult a healthcare provider. Focus on gradual weight loss.";
}

// Build meal plan matching logic
$goal = $profile['fitness_goal'];
$diet = $profile['diet_preference'];
$level = $profile['activity_level'];

// Match meal plans based on diet preference and goal
$meal_conditions = [];
$meal_params = [];
$meal_types = "s";

// Always filter by Meal type
$meal_where = "type = 'Meal' AND status = 'Active'";

// Match by diet preference title keywords
$diet_map = [
    'Low Carb' => 'Low Carb',
    'High Protein' => 'High Protein',
    'Keto' => 'Keto',
    'Vegan' => 'Vegan',
    'Balanced' => 'Balanced'
];

// Match by goal category
$goal_meal_map = [
    'Weight Loss' => ['Weight Loss'],
    'Muscle Gain' => ['Muscle Gain', 'Bulking'],
    'General Fitness' => ['General Fitness', 'Healthy Lifestyle'],
    'Stress Relief' => ['Healthy Lifestyle', 'General Fitness']
];

// Build meal query - match by title keyword (diet preference) OR category (goal)
$diet_keyword = isset($diet_map[$diet]) ? $diet_map[$diet] : 'Balanced';
$goal_categories = isset($goal_meal_map[$goal]) ? $goal_meal_map[$goal] : ['General Fitness'];

$cat_placeholders = implode(',', array_fill(0, count($goal_categories), '?'));
$meal_query = "SELECT * FROM plans WHERE type = 'Meal' AND status = 'Active' AND (title LIKE ? OR category IN ($cat_placeholders)) ORDER BY price ASC";

$meal_stmt = $con->prepare($meal_query);
$like_diet = "%$diet_keyword%";
$bind_types = "s" . str_repeat("s", count($goal_categories));
$bind_values = array_merge([$like_diet], $goal_categories);

// Use dynamic binding
$meal_stmt->bind_param($bind_types, ...$bind_values);
$meal_stmt->execute();
$meal_plans = $meal_stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Match exercise plans based on goal and activity level
$goal_exercise_map = [
    'Weight Loss' => ['Weight Loss'],
    'Muscle Gain' => ['Muscle Building', 'Advanced'],
    'General Fitness' => ['General Fitness', 'Intermediate'],
    'Stress Relief' => ['General Fitness']
];

$intensity_map = [
    'Beginner' => ['Low', 'Medium'],
    'Intermediate' => ['Medium', 'High'],
    'Advanced' => ['High', 'Very High']
];

$ex_categories = isset($goal_exercise_map[$goal]) ? $goal_exercise_map[$goal] : ['General Fitness'];
$ex_intensities = isset($intensity_map[$level]) ? $intensity_map[$level] : ['Medium'];

$ex_cat_ph = implode(',', array_fill(0, count($ex_categories), '?'));
$ex_int_ph = implode(',', array_fill(0, count($ex_intensities), '?'));

$ex_query = "SELECT * FROM plans WHERE type = 'Exercise' AND status = 'Active' AND (category IN ($ex_cat_ph) OR intensity IN ($ex_int_ph)) ORDER BY price ASC";

$ex_stmt = $con->prepare($ex_query);
$ex_bind_types = str_repeat("s", count($ex_categories) + count($ex_intensities));
$ex_bind_values = array_merge($ex_categories, $ex_intensities);
$ex_stmt->bind_param($ex_bind_types, ...$ex_bind_values);
$ex_stmt->execute();
$exercise_plans = $ex_stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$title = "My Recommendations - Health & Wellness";
$css = "register-dashboard.css";

ob_start();
?>

<style>
.bmi-card {
    border-radius: 16px;
    padding: 30px;
    background: white;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    text-align: center;
}
.bmi-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-size: 28px;
    font-weight: 800;
    color: white;
    font-family: 'Outfit', sans-serif;
}
.profile-badge {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    margin: 3px;
}
.rec-plan-card {
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    background: white;
    height: 100%;
    display: flex;
    flex-direction: column;
}
.rec-plan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}
.rec-plan-card img {
    height: 180px;
    object-fit: cover;
    width: 100%;
}
.rec-plan-body {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.rec-match-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(16, 185, 129, 0.9);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
</style>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">

        <!-- Header -->
        <div class="text-center mb-5">
            <h2 class="font-weight-bold" style="color: var(--primary-dark);"><i class="fa-solid fa-wand-magic-sparkles mr-2"></i>Your Personalized Recommendations</h2>
            <p class="text-muted">Based on your wellness quiz results, here are plans tailored just for you.</p>
            <a href="wellness-quiz.php" class="btn btn-outline-success btn-sm mt-2" style="border-radius: 8px;"><i class="fa-solid fa-rotate mr-1"></i> Retake Quiz</a>
        </div>

        <!-- BMI + Profile Summary Row -->
        <div class="row mb-5">
            <div class="col-lg-4 mb-4">
                <div class="bmi-card h-100">
                    <div class="bmi-circle" style="background: <?php echo $bmi_color; ?>;">
                        <?php echo $bmi; ?>
                    </div>
                    <h5 class="font-weight-bold"><?php echo $bmi_category; ?></h5>
                    <p class="text-muted mb-0" style="font-size: 14px;"><?php echo $bmi_advice; ?></p>
                </div>
            </div>
            <div class="col-lg-8 mb-4">
                <div class="bmi-card h-100 text-left">
                    <h5 class="font-weight-bold mb-3"><i class="fa-solid fa-user-check text-success mr-2"></i>Your Profile</h5>
                    <div class="row">
                        <div class="col-6 col-md-3 mb-3">
                            <small class="text-muted d-block">Age</small>
                            <strong><?php echo $profile['age']; ?> years</strong>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <small class="text-muted d-block">Weight</small>
                            <strong><?php echo $profile['weight']; ?> kg</strong>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <small class="text-muted d-block">Height</small>
                            <strong><?php echo $profile['height']; ?> cm</strong>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <small class="text-muted d-block">BMI</small>
                            <strong style="color: <?php echo $bmi_color; ?>;"><?php echo $bmi; ?></strong>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <span class="profile-badge" style="background: rgba(16,185,129,0.1); color: #059669;"><i class="fa-solid fa-bullseye mr-1"></i><?php echo htmlspecialchars($profile['fitness_goal']); ?></span>
                        <span class="profile-badge" style="background: rgba(59,130,246,0.1); color: #2563eb;"><i class="fa-solid fa-utensils mr-1"></i><?php echo htmlspecialchars($profile['diet_preference']); ?></span>
                        <span class="profile-badge" style="background: rgba(245,158,11,0.1); color: #d97706;"><i class="fa-solid fa-gauge-high mr-1"></i><?php echo htmlspecialchars($profile['activity_level']); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Meal Plans -->
        <div class="mb-5">
            <h4 class="font-weight-bold mb-4" style="color: var(--primary-dark);"><i class="fa-solid fa-bowl-food mr-2 text-success"></i>Recommended Meal Plans</h4>
            <?php if (count($meal_plans) > 0): ?>
            <div class="row">
                <?php foreach ($meal_plans as $plan): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="rec-plan-card" style="position: relative;">
                        <span class="rec-match-badge"><i class="fa-solid fa-check mr-1"></i>Matched</span>
                        <?php $img = !empty($plan['image_path']) ? "../".$plan['image_path'] : "../meal-plans-images/weight loss.jpg"; ?>
                        <img src="<?php echo htmlspecialchars($img); ?>" alt="<?php echo htmlspecialchars($plan['title']); ?>">
                        <div class="rec-plan-body">
                            <h5 class="font-weight-bold"><?php echo htmlspecialchars($plan['title']); ?></h5>
                            <p class="text-muted flex-grow-1" style="font-size: 14px;"><?php echo htmlspecialchars($plan['description']); ?></p>
                            <?php if (!empty($plan['calories'])): ?>
                            <p class="mb-2"><small><i class="fa-solid fa-fire text-warning mr-1"></i><?php echo htmlspecialchars($plan['calories']); ?></small></p>
                            <?php endif; ?>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <strong style="font-size: 20px; color: var(--primary-dark);">&#8377;<?php echo htmlspecialchars($plan['price']); ?></strong>
                                <a href="payment.php?plan=<?php echo urlencode($plan['title']); ?>&price=<?php echo urlencode($plan['price']); ?>" class="btn btn-success" style="border-radius: 8px;">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="alert alert-light text-center py-4" style="border-radius: 12px;">
                <i class="fa-solid fa-info-circle text-muted mr-2"></i>No meal plans matched your preferences. <a href="meal-plans.php" class="text-success font-weight-bold">Browse all plans</a>
            </div>
            <?php endif; ?>
        </div>

        <!-- Recommended Exercise Plans -->
        <div class="mb-5">
            <h4 class="font-weight-bold mb-4" style="color: var(--primary-dark);"><i class="fa-solid fa-dumbbell mr-2 text-success"></i>Recommended Exercise Plans</h4>
            <?php if (count($exercise_plans) > 0): ?>
            <div class="row">
                <?php foreach ($exercise_plans as $plan): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="rec-plan-card" style="position: relative;">
                        <span class="rec-match-badge"><i class="fa-solid fa-check mr-1"></i>Matched</span>
                        <?php $img = !empty($plan['image_path']) ? "../".$plan['image_path'] : "../Exercise-Images/Beginner Fitness.jpg"; ?>
                        <img src="<?php echo htmlspecialchars($img); ?>" alt="<?php echo htmlspecialchars($plan['title']); ?>">
                        <div class="rec-plan-body">
                            <h5 class="font-weight-bold"><?php echo htmlspecialchars($plan['title']); ?></h5>
                            <p class="text-muted flex-grow-1" style="font-size: 14px;"><?php echo htmlspecialchars($plan['description']); ?></p>
                            <div class="d-flex mb-2" style="gap: 10px;">
                                <?php if (!empty($plan['duration'])): ?>
                                <small><i class="fa-solid fa-clock text-info mr-1"></i><?php echo htmlspecialchars($plan['duration']); ?></small>
                                <?php endif; ?>
                                <?php if (!empty($plan['intensity'])): ?>
                                <small><i class="fa-solid fa-bolt text-warning mr-1"></i><?php echo htmlspecialchars($plan['intensity']); ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <strong style="font-size: 20px; color: var(--primary-dark);">&#8377;<?php echo htmlspecialchars($plan['price']); ?></strong>
                                <a href="payment.php?plan=<?php echo urlencode($plan['title']); ?>&price=<?php echo urlencode($plan['price']); ?>" class="btn btn-success" style="border-radius: 8px;">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="alert alert-light text-center py-4" style="border-radius: 12px;">
                <i class="fa-solid fa-info-circle text-muted mr-2"></i>No exercise plans matched your level. <a href="Exercise-plans.php" class="text-success font-weight-bold">Browse all plans</a>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
