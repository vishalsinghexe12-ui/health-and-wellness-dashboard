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

    $stmt = $con->prepare("SELECT id, name, email, password, role, profile_picture FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Since we are using varchar(20) for password, we compare plaintext
        if ($password === $row['password']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['profile_picture'] = $row['profile_picture'];
            $_SESSION['logged_in'] = true;

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
?>
