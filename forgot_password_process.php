<?php
session_start();
require_once("db_config.php");
require_once("includes/send_email.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';

    if (empty($email)) {
        $_SESSION['auth_flash'] = "Please enter your email.";
        header("Location: forgot_password.php");
        exit();
    }

    // Check if email exists in `register` table
    $stmt = $con->prepare("SELECT id, name FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $otp = sprintf("%06d", mt_rand(1, 999999));
        $expires = date("Y-m-d H:i:s", strtotime('+15 minutes'));

        // Check if an entry already exists in password_token
        $check_token = $con->prepare("SELECT id FROM password_token WHERE email = ?");
        $check_token->bind_param("s", $email);
        $check_token->execute();
        $token_res = $check_token->get_result();

        if ($token_res->num_rows > 0) {
            // Update existing
            $update = $con->prepare("UPDATE password_token SET otp = ?, expires_at = ? WHERE email = ?");
            $update->bind_param("sss", $otp, $expires, $email);
            $update->execute();
        } else {
            // Insert new
            $insert = $con->prepare("INSERT INTO password_token (email, otp, expires_at) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $email, $otp, $expires);
            $insert->execute();
        }

        // Send Email
        $subject = "Password Reset OTP - Health & Wellness";
        $message = "
            <h3>Hello {$name},</h3>
            <p>You requested a password reset. Here is your 6-digit OTP:</p>
            <h2 style='color: #28a745;'>{$otp}</h2>
            <p>This OTP will expire in 15 minutes. If you did not request this, please ignore it.</p>
        ";

        if (send_email($email, $subject, $message)) {
            $_SESSION['reset_email'] = $email;
            $_SESSION['auth_flash'] = "OTP has been sent to your email address.";
            header("Location: verify_otp.php");
            exit();
        } else {
             $_SESSION['auth_flash'] = "Failed to send email. Please try again later.";
             header("Location: forgot_password.php");
             exit();
        }

    } else {
        // Generic message for security reason
        $_SESSION['auth_flash'] = "If that email is registered, an OTP has been sent.";
        // But for testing ease, let's redirect them back
        header("Location: forgot_password.php");
        exit();
    }
} else {
    header("Location: forgot_password.php");
    exit();
}
?>
