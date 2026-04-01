<?php
session_start();
require_once("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Determine if admin or user
    $is_admin = isset($_POST['panel']) && $_POST['panel'] === 'admin';
    $redirect_page = $is_admin ? "admin/change-password.php" : "user/change-password.php";

    // Check if user is logged in
    if (!isset($_SESSION['logged_in']) || !isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id      = $_SESSION['user_id'];
    $old_password  = trim($_POST['old_password'] ?? '');
    $new_password  = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    // Validate inputs
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['pwd_flash'] = "All fields are required.";
        $_SESSION['pwd_flash_type'] = "danger";
        header("Location: $redirect_page");
        exit();
    }

    if ($new_password !== $confirm_password) {
        $_SESSION['pwd_flash'] = "New password and confirm password do not match.";
        $_SESSION['pwd_flash_type'] = "danger";
        header("Location: $redirect_page");
        exit();
    }

    if (strlen($new_password) < 4) {
        $_SESSION['pwd_flash'] = "New password must be at least 4 characters long.";
        $_SESSION['pwd_flash_type'] = "danger";
        header("Location: $redirect_page");
        exit();
    }

    if (strlen($new_password) > 20) {
        $_SESSION['pwd_flash'] = "New password cannot exceed 20 characters.";
        $_SESSION['pwd_flash_type'] = "danger";
        header("Location: $redirect_page");
        exit();
    }

    // Fetch current password from database
    $stmt = $con->prepare("SELECT password FROM register WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Compare old password (plaintext comparison matching login_process.php)
        if ($old_password === $row['password']) {
            // Old password matches — update to new password
            $update_stmt = $con->prepare("UPDATE register SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $new_password, $user_id);

            if ($update_stmt->execute()) {
                $_SESSION['pwd_flash'] = "Password changed successfully!";
                $_SESSION['pwd_flash_type'] = "success";
            } else {
                $_SESSION['pwd_flash'] = "Something went wrong. Please try again.";
                $_SESSION['pwd_flash_type'] = "danger";
            }
        } else {
            // Old password does NOT match
            $_SESSION['pwd_flash'] = "Incorrect old password. Please try again.";
            $_SESSION['pwd_flash_type'] = "danger";
        }
    } else {
        $_SESSION['pwd_flash'] = "User not found.";
        $_SESSION['pwd_flash_type'] = "danger";
    }

    header("Location: $redirect_page");
    exit();

} else {
    header("Location: login.php");
    exit();
}
?>
