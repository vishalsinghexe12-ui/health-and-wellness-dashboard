<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}
require_once("../db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $fitness_goal = $_POST['fitness_goal'] ?? '';
    $diet_preference = $_POST['diet_preference'] ?? '';
    $activity_level = $_POST['activity_level'] ?? '';
    $age = (int)($_POST['age'] ?? 0);
    $weight = (float)($_POST['weight'] ?? 0);
    $height = (float)($_POST['height'] ?? 0);

    // Validate
    if (empty($fitness_goal) || empty($diet_preference) || empty($activity_level) || $age <= 0 || $weight <= 0 || $height <= 0) {
        $_SESSION['auth_flash'] = "Please complete all quiz steps.";
        header("Location: wellness-quiz.php");
        exit();
    }

    // Calculate BMI: weight(kg) / (height(m))^2
    $height_m = $height / 100;
    $bmi = round($weight / ($height_m * $height_m), 1);

    // Delete old profile if exists, then insert new one
    $del = $con->prepare("DELETE FROM user_wellness_profiles WHERE user_id = ?");
    $del->bind_param("i", $user_id);
    $del->execute();

    $stmt = $con->prepare("INSERT INTO user_wellness_profiles (user_id, fitness_goal, diet_preference, activity_level, age, weight, height, bmi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssiddd", $user_id, $fitness_goal, $diet_preference, $activity_level, $age, $weight, $height, $bmi);

    if ($stmt->execute()) {
        header("Location: my-recommendations.php");
        exit();
    } else {
        $_SESSION['auth_flash'] = "Error saving your profile.";
        header("Location: wellness-quiz.php");
        exit();
    }
} else {
    header("Location: wellness-quiz.php");
    exit();
}
?>
