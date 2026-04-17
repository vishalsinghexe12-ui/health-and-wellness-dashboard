<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id          = isset($_POST['section_id']) ? (int)$_POST['section_id'] : 0;
    $section     = mysqli_real_escape_string($con, $_POST['section']);
    $sort_order  = (int)$_POST['sort_order'];
    $title       = mysqli_real_escape_string($con, $_POST['title']);
    $subtitle    = mysqli_real_escape_string($con, $_POST['subtitle']);
    $body        = mysqli_real_escape_string($con, $_POST['body']);
    $button_text = mysqli_real_escape_string($con, $_POST['button_text']);
    $button_url  = mysqli_real_escape_string($con, $_POST['button_url']);
    $is_active   = isset($_POST['is_active']) ? 1 : 0;

    $image_path = "";
    $update_image = false;

    // Image Upload
    if (isset($_FILES['sec_image']) && $_FILES['sec_image']['error'] === 0) {
        $upload_dir = "images/guest/";
        if (!is_dir("../" . $upload_dir)) mkdir("../" . $upload_dir, 0777, true);
        $file_name = time() . "_" . basename($_FILES["sec_image"]["name"]);
        $target_file = "../" . $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES["sec_image"]["tmp_name"], $target_file)) {
            $image_path = $upload_dir . $file_name;
            $update_image = true;
        }
    }

    if ($id > 0) {
        // Update
        if ($update_image) {
            $q = "UPDATE guest_content SET section='$section', sort_order=$sort_order, title='$title', subtitle='$subtitle', body='$body', button_text='$button_text', button_url='$button_url', is_active=$is_active, image_path='$image_path' WHERE id=$id";
        } else {
            $q = "UPDATE guest_content SET section='$section', sort_order=$sort_order, title='$title', subtitle='$subtitle', body='$body', button_text='$button_text', button_url='$button_url', is_active=$is_active WHERE id=$id";
        }
    } else {
        // Insert
        $q = "INSERT INTO guest_content (section, sort_order, title, subtitle, body, image_path, button_text, button_url, is_active) VALUES ('$section', $sort_order, '$title', '$subtitle', '$body', '$image_path', '$button_text', '$button_url', $is_active)";
    }

    if (mysqli_query($con, $q)) {
        $_SESSION['guest_success'] = "Content saved successfully!";
    } else {
        $_SESSION['guest_error'] = "Error: " . mysqli_error($con);
    }
    
    header("Location: manage-guest-page.php");
    exit();
} else {
    header("Location: manage-guest-page.php");
    exit();
}
?>
