<?php
session_start();
require_once("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['reset_email'])) {
        header("Location: forgot_password.php");
        exit();
    }

    $email = $_SESSION['reset_email'];
    $otp = $_POST['otp'] ?? '';

    if (empty($otp)) {
        $_SESSION['auth_flash'] = "Please enter the OTP.";
        header("Location: verify_otp.php");
        exit();
    }

    // Check OTP in DB
    $stmt = $con->prepare("SELECT id, expires_at FROM password_token WHERE email = ? AND otp = ?");
    $stmt->bind_param("ss", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $expires = strtotime($row['expires_at']);
        $now = time();

        if ($now > $expires) {
            $_SESSION['auth_flash'] = "OTP has expired. Please request a new one.";
            header("Location: forgot_password.php");
            exit();
        }

        // OTP is valid, proceed to reset password
        $_SESSION['otp_verified'] = true;
        
        // Remove OTP logic here so user can't reuse it. Wait, remove it AFTER reset is complete.
        // Or remove OTP and store session verification. We will just nullify it upon successful reset.
        
        header("Location: reset_password.php");
        exit();
    } else {
        // Invalid OTP
        // Optional: Implement `otp_attempts` tracking here from your DB structure. 
        // For simplicity, just error out.
        $_SESSION['auth_flash'] = "Invalid OTP. Please try again.";
        header("Location: verify_otp.php");
        exit();
    }
} else {
    header("Location: verify_otp.php");
    exit();
}
?>
