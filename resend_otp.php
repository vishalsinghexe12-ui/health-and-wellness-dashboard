<?php
session_start();
require_once("db_config.php");
require_once("includes/send_email.php");

// Only applies to Registration process
if (!isset($_SESSION['pending_email'])) {
    header("Location: register.php");
    exit();
}

$email = $_SESSION['pending_email'];
$firstName = $_SESSION['pending_firstName'] ?? 'User';

// Find Inactive user matching this email
$res = mysqli_query($con, "SELECT id FROM register WHERE email='" . mysqli_real_escape_string($con, $email) . "' AND status='Inactive' LIMIT 1");

if ($res && mysqli_num_rows($res) > 0) {
    // Generate new token & extend expiration
    $token   = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', time() + 3600); // +1 hour from now

    mysqli_query($con, "UPDATE register SET token='$token', token_expires='$expires' WHERE email='" . mysqli_real_escape_string($con, $email) . "'");

    $activation_link = "http://" . $_SERVER['HTTP_HOST'] . "/health-and-wellness-dashboard/verify_email.php?token=" . $token;

    $subject = "Resend: Activate Your Account - Health & Wellness";
    $message = "
        <div style='font-family: Arial, sans-serif; padding: 20px; color: #333; max-width: 600px; margin: auto;'>
            <div style='background: linear-gradient(135deg,#065f46,#047857); padding: 30px; border-radius: 16px 16px 0 0; text-align:center;'>
                <h1 style='color:white; margin:0; font-size:28px;'>🌿 Health &amp; Wellness</h1>
            </div>
            <div style='background:white; padding:30px; border-radius:0 0 16px 16px; border:1px solid #e2e8f0; border-top:none;'>
                <h2 style='color:#047857;'>Activate Your Account</h2>
                <p>Hello <strong>{$firstName}</strong>,</p>
                <p>You requested a new activation link. Click the button below to activate your Health &amp; Wellness account. This link is valid for <strong>1 hour</strong>.</p>
                <div style='text-align:center; margin:30px 0;'>
                    <a href='{$activation_link}' style='background:linear-gradient(135deg,#059669,#0d9488); color:white; text-decoration:none; padding:16px 36px; border-radius:12px; font-size:16px; font-weight:700; display:inline-block;'>✅ Activate My Account</a>
                </div>
                <p style='color:#64748b; font-size:13px;'>Or copy this link into your browser:</p>
                <p style='color:#059669; font-size:12px; word-break:break-all;'>{$activation_link}</p>
                <hr style='border:none; border-top:1px solid #e2e8f0; margin:20px 0;'>
                <p style='color:#94a3b8; font-size:12px;'>If you didn't create this account, you can safely ignore this email.</p>
            </div>
        </div>
    ";

    if (send_email($email, $subject, $message)) {
        $_SESSION['auth_flash'] = "A new activation link has been sent to your email.";
    } else {
        $_SESSION['auth_flash'] = "Failed to resend email. Please try again later.";
    }
} else {
    $_SESSION['auth_flash'] = "Account already activated or not found.";
}

header("Location: register_verify.php");
exit();
?>
