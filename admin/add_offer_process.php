<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offer_id = isset($_POST['offer_id']) ? mysqli_real_escape_string($con, $_POST['offer_id']) : null;
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $discount = mysqli_real_escape_string($con, $_POST['discount_percentage']);
    $valid_until = mysqli_real_escape_string($con, $_POST['valid_until']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $plan_type = mysqli_real_escape_string($con, $_POST['plan_type'] ?? 'Both');

    $image_path = "";
    $update_image = false;

    // Handle image upload
    if (isset($_FILES['offer_image']) && $_FILES['offer_image']['error'] === 0) {
        $target_dir = "images/";
        if (!is_dir("../" . $target_dir)) {
            mkdir("../" . $target_dir, 0777, true);
        }
        $file_name = time() . "_" . basename($_FILES["offer_image"]["name"]);
        $target_file = "../" . $target_dir . $file_name;
        $db_image_path = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["offer_image"]["tmp_name"], $target_file)) {
            $image_path = $db_image_path;
            $update_image = true;
        }
    }

    if ($offer_id) {
        // Update existing offer
        if ($update_image) {
            $query = "UPDATE offers_discounts SET title='$title', description='$description', discount_percentage='$discount', image_path='$image_path', valid_until='$valid_until', status='$status', plan_type='$plan_type' WHERE id='$offer_id'";
        } else {
            $query = "UPDATE offers_discounts SET title='$title', description='$description', discount_percentage='$discount', valid_until='$valid_until', status='$status', plan_type='$plan_type' WHERE id='$offer_id'";
        }
        $success_msg = "Offer updated successfully!";
    } else {
        // Insert new offer
        $query = "INSERT INTO offers_discounts (title, description, discount_percentage, image_path, valid_until, status, plan_type) VALUES ('$title', '$description', '$discount', '$image_path', '$valid_until', '$status', '$plan_type')";
        $success_msg = "Offer published successfully!";
    }

    if (mysqli_query($con, $query)) {
        $_SESSION['offer_success'] = $success_msg;
        header("Location: manage-offers.php");
    } else {
        $_SESSION['offer_error'] = "Error: " . mysqli_error($con);
        header("Location: add-offer.php" . ($offer_id ? "?edit_id=$offer_id" : ""));
    }
} else {
    header("Location: manage-offers.php");
}
?>
