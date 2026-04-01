<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: ../login.php");
    exit();
}
require_once("../db_config.php");

// Check if user already has a profile
$user_id = $_SESSION['user_id'];
$existing = $con->prepare("SELECT * FROM user_wellness_profiles WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$existing->bind_param("i", $user_id);
$existing->execute();
$profile = $existing->get_result()->fetch_assoc();

$title = "Wellness Quiz - Personalized Plan";
$css = "register-dashboard.css";

ob_start();
?>

<style>
.quiz-container {
    max-width: 700px;
    margin: 0 auto;
}
.quiz-step {
    display: none;
    animation: fadeInUp 0.4s ease;
}
.quiz-step.active {
    display: block;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.quiz-option {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 18px 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
}
.quiz-option:hover {
    border-color: #10b981;
    background: rgba(16, 185, 129, 0.05);
    transform: translateX(5px);
}
.quiz-option.selected {
    border-color: #10b981;
    background: rgba(16, 185, 129, 0.1);
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
}
.quiz-option .option-icon {
    font-size: 24px;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    margin-right: 15px;
    flex-shrink: 0;
}
.quiz-option.selected .option-icon {
    background: #10b981;
    color: white;
}
.quiz-progress {
    height: 6px;
    background: #e2e8f0;
    border-radius: 3px;
    margin-bottom: 30px;
    overflow: hidden;
}
.quiz-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #059669, #10b981);
    border-radius: 3px;
    transition: width 0.5s ease;
}
.step-counter {
    font-size: 14px;
    color: #94a3b8;
    margin-bottom: 8px;
}
.quiz-title {
    font-family: 'Outfit', sans-serif;
    font-weight: 700;
    font-size: 24px;
    color: #1e293b;
    margin-bottom: 5px;
}
.quiz-subtitle {
    color: #64748b;
    margin-bottom: 25px;
}
</style>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">
        <div class="quiz-container">

            <div class="text-center mb-4">
                <h2 class="font-weight-bold" style="color: var(--primary-dark);"><i class="fa-solid fa-heart-pulse mr-2"></i>Wellness Quiz</h2>
                <p class="text-muted">Answer a few quick questions and we'll recommend the perfect plans for you.</p>
            </div>

            <?php if ($profile): ?>
            <div class="alert alert-info d-flex align-items-center mb-4" style="border-radius: 12px;">
                <i class="fa-solid fa-circle-info mr-3" style="font-size: 20px;"></i>
                <div>
                    You already have a profile! Retaking the quiz will update your recommendations.
                    <a href="my-recommendations.php" class="font-weight-bold text-success ml-1">View Current Recommendations →</a>
                </div>
            </div>
            <?php endif; ?>

            <div class="stat-card" style="border-radius: 16px;">
                <div class="quiz-progress">
                    <div class="quiz-progress-bar" id="progressBar" style="width: 25%;"></div>
                </div>

                <form id="quizForm" method="POST" action="wellness-quiz-process.php">

                    <!-- Step 1: Fitness Goal -->
                    <div class="quiz-step active" id="step1">
                        <p class="step-counter">Step 1 of 4</p>
                        <h4 class="quiz-title">What's your primary fitness goal?</h4>
                        <p class="quiz-subtitle">This helps us find the right exercise and meal plans for you.</p>
                        <input type="hidden" name="fitness_goal" id="fitness_goal" required>

                        <div class="quiz-option" data-value="Weight Loss" data-target="fitness_goal">
                            <div class="option-icon"><i class="fa-solid fa-weight-scale"></i></div>
                            <div><strong>Weight Loss</strong><br><small class="text-muted">Lose weight and get lean</small></div>
                        </div>
                        <div class="quiz-option" data-value="Muscle Gain" data-target="fitness_goal">
                            <div class="option-icon"><i class="fa-solid fa-dumbbell"></i></div>
                            <div><strong>Muscle Gain</strong><br><small class="text-muted">Build muscle and strength</small></div>
                        </div>
                        <div class="quiz-option" data-value="General Fitness" data-target="fitness_goal">
                            <div class="option-icon"><i class="fa-solid fa-heart-pulse"></i></div>
                            <div><strong>General Fitness</strong><br><small class="text-muted">Stay active and healthy</small></div>
                        </div>
                        <div class="quiz-option" data-value="Stress Relief" data-target="fitness_goal">
                            <div class="option-icon"><i class="fa-solid fa-spa"></i></div>
                            <div><strong>Stress Relief</strong><br><small class="text-muted">Reduce stress, improve sleep</small></div>
                        </div>

                        <button type="button" class="btn btn-success btn-lg btn-block mt-4" style="border-radius: 10px;" onclick="nextStep(2)" id="btn1" disabled>
                            Next <i class="fa-solid fa-arrow-right ml-2"></i>
                        </button>
                    </div>

                    <!-- Step 2: Diet Preference -->
                    <div class="quiz-step" id="step2">
                        <p class="step-counter">Step 2 of 4</p>
                        <h4 class="quiz-title">What's your diet preference?</h4>
                        <p class="quiz-subtitle">We'll match meal plans that fit your lifestyle.</p>
                        <input type="hidden" name="diet_preference" id="diet_preference" required>

                        <div class="quiz-option" data-value="Low Carb" data-target="diet_preference">
                            <div class="option-icon"><i class="fa-solid fa-bread-slice"></i></div>
                            <div><strong>Low Carb</strong><br><small class="text-muted">Reduce carbs, burn fat</small></div>
                        </div>
                        <div class="quiz-option" data-value="High Protein" data-target="diet_preference">
                            <div class="option-icon"><i class="fa-solid fa-drumstick-bite"></i></div>
                            <div><strong>High Protein</strong><br><small class="text-muted">Fuel muscle growth</small></div>
                        </div>
                        <div class="quiz-option" data-value="Keto" data-target="diet_preference">
                            <div class="option-icon"><i class="fa-solid fa-fire"></i></div>
                            <div><strong>Keto</strong><br><small class="text-muted">High fat, low carb ketosis</small></div>
                        </div>
                        <div class="quiz-option" data-value="Vegan" data-target="diet_preference">
                            <div class="option-icon"><i class="fa-solid fa-leaf"></i></div>
                            <div><strong>Vegan</strong><br><small class="text-muted">100% plant-based</small></div>
                        </div>
                        <div class="quiz-option" data-value="Balanced" data-target="diet_preference">
                            <div class="option-icon"><i class="fa-solid fa-bowl-food"></i></div>
                            <div><strong>Balanced</strong><br><small class="text-muted">A little bit of everything</small></div>
                        </div>

                        <div class="d-flex mt-4" style="gap: 12px;">
                            <button type="button" class="btn btn-outline-secondary btn-lg" style="border-radius: 10px; flex: 1;" onclick="prevStep(1)">
                                <i class="fa-solid fa-arrow-left mr-2"></i> Back
                            </button>
                            <button type="button" class="btn btn-success btn-lg" style="border-radius: 10px; flex: 2;" onclick="nextStep(3)" id="btn2" disabled>
                                Next <i class="fa-solid fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Activity Level -->
                    <div class="quiz-step" id="step3">
                        <p class="step-counter">Step 3 of 4</p>
                        <h4 class="quiz-title">What's your current activity level?</h4>
                        <p class="quiz-subtitle">This helps us set the right intensity for your workouts.</p>
                        <input type="hidden" name="activity_level" id="activity_level" required>

                        <div class="quiz-option" data-value="Beginner" data-target="activity_level">
                            <div class="option-icon"><i class="fa-solid fa-seedling"></i></div>
                            <div><strong>Beginner</strong><br><small class="text-muted">New to fitness or returning after a break</small></div>
                        </div>
                        <div class="quiz-option" data-value="Intermediate" data-target="activity_level">
                            <div class="option-icon"><i class="fa-solid fa-person-running"></i></div>
                            <div><strong>Intermediate</strong><br><small class="text-muted">Exercise 2-4 times a week regularly</small></div>
                        </div>
                        <div class="quiz-option" data-value="Advanced" data-target="activity_level">
                            <div class="option-icon"><i class="fa-solid fa-trophy"></i></div>
                            <div><strong>Advanced</strong><br><small class="text-muted">Daily intense workouts, experienced athlete</small></div>
                        </div>

                        <div class="d-flex mt-4" style="gap: 12px;">
                            <button type="button" class="btn btn-outline-secondary btn-lg" style="border-radius: 10px; flex: 1;" onclick="prevStep(2)">
                                <i class="fa-solid fa-arrow-left mr-2"></i> Back
                            </button>
                            <button type="button" class="btn btn-success btn-lg" style="border-radius: 10px; flex: 2;" onclick="nextStep(4)" id="btn3" disabled>
                                Next <i class="fa-solid fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 4: Body Stats -->
                    <div class="quiz-step" id="step4">
                        <p class="step-counter">Step 4 of 4</p>
                        <h4 class="quiz-title">Tell us about yourself</h4>
                        <p class="quiz-subtitle">We'll calculate your BMI to fine-tune recommendations.</p>

                        <div class="form-group">
                            <label class="font-weight-bold">Age</label>
                            <input type="number" name="age" class="form-control" placeholder="e.g. 25" min="10" max="100" required style="border-radius: 10px; padding: 12px 15px;">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Weight (kg)</label>
                                    <input type="number" name="weight" class="form-control" placeholder="e.g. 65" min="20" max="300" step="0.1" required style="border-radius: 10px; padding: 12px 15px;">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Height (cm)</label>
                                    <input type="number" name="height" class="form-control" placeholder="e.g. 170" min="100" max="250" step="0.1" required style="border-radius: 10px; padding: 12px 15px;">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex mt-4" style="gap: 12px;">
                            <button type="button" class="btn btn-outline-secondary btn-lg" style="border-radius: 10px; flex: 1;" onclick="prevStep(3)">
                                <i class="fa-solid fa-arrow-left mr-2"></i> Back
                            </button>
                            <button type="submit" class="btn btn-success btn-lg" style="border-radius: 10px; flex: 2;">
                                <i class="fa-solid fa-wand-magic-sparkles mr-2"></i> Get My Plan
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Handle option selection
document.querySelectorAll('.quiz-option').forEach(function(option) {
    option.addEventListener('click', function() {
        var target = this.getAttribute('data-target');
        var value = this.getAttribute('data-value');

        // Deselect siblings
        this.parentElement.querySelectorAll('.quiz-option[data-target="'+target+'"]').forEach(function(el) {
            el.classList.remove('selected');
        });
        // Select this one
        this.classList.add('selected');
        document.getElementById(target).value = value;

        // Enable the next button for this step
        var stepNum = this.closest('.quiz-step').id.replace('step', '');
        var btn = document.getElementById('btn' + stepNum);
        if (btn) btn.disabled = false;
    });
});

function nextStep(step) {
    document.querySelectorAll('.quiz-step').forEach(function(el) { el.classList.remove('active'); });
    document.getElementById('step' + step).classList.add('active');
    document.getElementById('progressBar').style.width = (step * 25) + '%';
}

function prevStep(step) {
    document.querySelectorAll('.quiz-step').forEach(function(el) { el.classList.remove('active'); });
    document.getElementById('step' + step).classList.add('active');
    document.getElementById('progressBar').style.width = (step * 25) + '%';
}
</script>

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
