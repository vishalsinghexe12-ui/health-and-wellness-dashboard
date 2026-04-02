<?php
session_start();
require_once("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $login_type = $_POST['login_type'] ?? 'user';

    if (empty($email) || empty($password)) {
        $_SESSION['auth_flash'] = "Please fill completely.";
        header("Location: " . ($login_type === 'admin' ? "admin/admin-login.php" : "login.php") . "?error=empty");
        exit();
    }

    $stmt = $con->prepare("SELECT id, name, email, mobile, password, role, profile_picture, status FROM register WHERE email = ? OR mobile = ?");
    $stmt->bind_param("ss", $email, $email); // Use the same input for both email and mobile
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Use password_verify to check hashed passwords
        if (password_verify($password, $row['password'])) {
            if ($row['status'] === 'Inactive') {
                $_SESSION['auth_flash'] = "Your account is not activated. Please verify your email first.";
                header("Location: login.php?error=inactive");
                exit();
            }
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['profile_picture'] = $row['profile_picture'];
            $_SESSION['logged_in'] = true;
            $_SESSION['login_success'] = "Login successful! Welcome back, " . htmlspecialchars($row['name']) . ".";

            if (isset($_POST['remember'])) {
                $token = bin2hex(random_bytes(16));
                $update_token = $con->prepare("UPDATE register SET token = ? WHERE id = ?");
                $update_token->bind_param("si", $token, $row['id']);
                $update_token->execute();
                setcookie('remember_login', $token, time() + (86400 * 30), "/"); // 30 days
            }

            // Redirect based on role
            if ($row['role'] === 'admin') {
                header("Location: admin/admin.php");
            } else {
                if (isset($_SESSION['redirect_url'])) {
                    $redirect = $_SESSION['redirect_url'];
                    unset($_SESSION['redirect_url']);
                    header("Location: $redirect");
                } else {
                    header("Location: user/register-dashboard.php");
                }
            }
            exit();
        } else {
            $_SESSION['auth_flash'] = "Incorrect password.";
            header("Location: " . ($login_type === 'admin' ? "admin/admin-login.php" : "login.php") . "?error=incorrect_password");
            exit();
        }
    } else {
        $_SESSION['auth_flash'] = "Account not found.";
        header("Location: " . ($login_type === 'admin' ? "admin/admin-login.php" : "login.php") . "?error=not_found");
        exit();
    }

} else {
    header("Location: login.php");
    exit();
}
