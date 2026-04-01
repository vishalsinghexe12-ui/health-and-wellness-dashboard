<?php
session_start();
require_once("../db_config.php");

// Auth check
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['planTitle'] ?? '';
    // Use the dropdown 'type' which is 'Exercise plan' or 'Meal Plan', standardise to 'Exercise' or 'Meal'
    $raw_type = $_POST['type'] ?? '';
    $type = 'Wellness'; // fallback
    if (stripos($raw_type, 'Exercise') !== false) {
        $type = 'Exercise';
    } elseif (stripos($raw_type, 'Meal') !== false) {
        $type = 'Meal';
    }

    $duration = $_POST['duration'] ?? ''; // Currently number of weeks
    if (is_numeric($duration)) $duration .= " Weeks";

    $price = $_POST['price'] ?? 0;
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'Active';

    // The form doesn't capture intensity or calories currently, we will leave them blank or add logic if needed.
    $category = '';
    $intensity = '';
    $calories = '';

    // Handle Image Upload
    $image_path = "images/default-plan.jpg";
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $new_name = time() . "_" . uniqid() . "." . $ext;
        
        // Define directory based on type
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
            // Store relative path in DB assuming root is `health-and-wellness-dashboard`
            $image_path = str_replace('../', '', $dest);
        }
    }

    $stmt = $con->prepare("INSERT INTO plans (title, type, description, category, duration, calories, intensity, price, image_path, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $title, $type, $description, $category, $duration, $calories, $intensity, $price, $image_path, $status);
    
    if ($stmt->execute()) {
        header("Location: admin.php?msg=plan_added");
        exit();
    } else {
        header("Location: add-plans.php?error=failed");
        exit();
    }
}
?>
