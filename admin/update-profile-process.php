<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = $_SESSION['user_id'];
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $gender = trim($_POST['gender'] ?? '');

    // Basic validation
    if (empty($name) || empty($email)) {
        $_SESSION['profile_msg'] = "Name and Email are required.";
        header("Location: admin-profile.php");
        exit();
    }

    // Handle Profile Picture Upload
    $img_sql = "";
    $params = [$name, $email, $mobile, $gender];
    $types = "ssss";

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $upload_dir = '../images/profiles/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $new_name = "admin_" . $admin_id . "_" . time() . "." . $ext;
        $dest = $upload_dir . $new_name;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $dest)) {
            $img_path = "images/profiles/" . $new_name;
            $img_sql = ", profile_picture = ?";
            $params[] = $img_path;
            $types .= "s";
        }
    }

    $params[] = $admin_id;
    $types .= "i";

    $sql = "UPDATE register SET name = ?, email = ?, mobile = ?, gender = ? $img_sql WHERE id = ? AND role = 'admin'";
    $stmt = $con->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        $_SESSION['profile_msg'] = "Profile updated successfully!";
    } else {
        $_SESSION['profile_msg'] = "Failed to update profile.";
    }

    header("Location: admin-profile.php");
    exit();
}
?>
