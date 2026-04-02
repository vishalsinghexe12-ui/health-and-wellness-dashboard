<?php
session_start();
require_once("includes/send_email.php");

if (!isset($_SESSION['pending_registration'])) {
    header("Location: register.php");
    exit();
}

$pending_user = &$_SESSION['pending_registration'];
$email = $pending_user['email'];
$firstName = explode(' ', $pending_user['name'])[0];

// Generate NEW 6-digit OTP
$otp = sprintf("%06d", mt_rand(1, 999999));

// Update session
$pending_user['otp'] = $otp;
$pending_user['expires'] = time() + 600; // Reset expiry to 10 mins from now

// Email body
$subject = "Your NEW Verification Code - Health & Wellness";
$message = "
    <div style='font-family: Arial, sans-serif; padding: 20px; color: #333;'>
        <h2 style='color: #10b981;'>Email Verification</h2>
        <p>Hello <strong>{$firstName}</strong>,</p>
        <p>You requested a new verification code. Your NEW code is:</p>
        <div style='font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #10b981; margin: 20px 0;'>{$otp}</div>
        <p>This code will expire in 10 minutes from now.</p>
        <p>If you did not request this, please ignore this email.</p>
    </div>
";

// Send Email
if (send_email($email, $subject, $message)) {
    $_SESSION['auth_flash'] = "A new verification code has been sent to your email.";
} else {
    $_SESSION['auth_flash'] = "Failed to resend email. Please check your internet connection and try again.";
}

header("Location: register_verify.php");
exit();
?>
