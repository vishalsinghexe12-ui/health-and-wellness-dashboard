<?php
session_start();
require_once("../db_config.php");

// Auth check
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = mysqli_real_escape_string($con, $_POST['planTitle'] ?? '');
    $type = mysqli_real_escape_string($con, $_POST['type'] ?? 'Wellness');
    $category = mysqli_real_escape_string($con, $_POST['category'] ?? '');
    $duration_months = $_POST['duration'] ?? 1;
    $duration = $duration_months == 1 ? $duration_months . " Month" : $duration_months . " Months";
    
    $price = $_POST['price'] ?? 0;
    $calories = mysqli_real_escape_string($con, $_POST['calories'] ?? '');
    $intensity = mysqli_real_escape_string($con, $_POST['intensity'] ?? '');
    $description = mysqli_real_escape_string($con, $_POST['description'] ?? '');
    $status = mysqli_real_escape_string($con, $_POST['status'] ?? 'Active');

    // Handle Image Upload
    $image_path = "images/default-plan.jpg";
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $new_name = time() . "_" . uniqid() . "." . $ext;
        
        // Use generic upload dir or type-specific
        $upload_dir = '../images/plans/';
        if ($type === 'Exercise') {
            $upload_dir = '../Exercise-Images/';
        } elseif ($type === 'Meal') {
            $upload_dir = '../meal-plans-images/';
        }
        
        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0777, true);
        }
        
        $dest = $upload_dir . $new_name;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $dest)){
            $image_path = str_replace('../', '', $dest);
        }
    }

    $query = "INSERT INTO plans (title, type, description, category, duration, calories, intensity, price, image_path, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssssssssss", $title, $type, $description, $category, $duration, $calories, $intensity, $price, $image_path, $status);
    
    if ($stmt->execute()) {
        header("Location: admin.php?msg=plan_added");
        exit();
    } else {
        header("Location: add-plans.php?error=failed&db_error=" . urlencode($con->error));
        exit();
    }
} else {
    header("Location: add-plans.php");
    exit();
}
?>
