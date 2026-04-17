<?php
ob_start();
session_start();
require_once("db_config.php");
require_once("includes/send_email.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = $_POST['firstName'] ?? '';
    $lastName  = $_POST['lastName']  ?? '';
    $name      = trim($firstName . ' ' . $lastName);
    $email     = $_POST['email']    ?? '';
    $phone     = $_POST['phone']    ?? '';
    $password  = $_POST['password'] ?? '';
    $gender    = $_POST['gender']   ?? '';

    // Check if email or phone already exists
    $check_stmt = $con->prepare("SELECT id, status FROM register WHERE email = ? OR mobile = ?");
    $check_stmt->bind_param("ss", $email, $phone);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $existing = $check_result->fetch_assoc();
        // If account exists but is inactive, allow re-sending activation link
        if ($existing['status'] === 'Inactive') {
            $_SESSION['pending_email']     = $email;
            $_SESSION['pending_firstName'] = $firstName;
            $_SESSION['auth_flash']        = "An account already exists but isn't verified yet. We've resent your activation link.";
            // Regenerate token and resend
            $token   = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', time() + 3600);
            $con->query("UPDATE register SET token='$token', token_expires='$expires' WHERE email='" . mysqli_real_escape_string($con, $email) . "'");
            $activation_link = "http://" . $_SERVER['HTTP_HOST'] . "/health-and-wellness-dashboard/verify_email.php?token=" . $token;
            $subject = "Activate Your Account - Health & Wellness";
            $message = "
                <div style='font-family: Arial, sans-serif; padding: 20px; color: #333; max-width: 600px; margin: auto;'>
                    <div style='background: linear-gradient(135deg,#065f46,#047857); padding: 30px; border-radius: 16px 16px 0 0; text-align:center;'>
                        <h1 style='color:white; margin:0; font-size:28px;'>🌿 Health &amp; Wellness</h1>
                    </div>
                    <div style='background:white; padding:30px; border-radius:0 0 16px 16px; border:1px solid #e2e8f0; border-top:none;'>
                        <h2 style='color:#047857;'>Activate Your Account</h2>
                        <p>Hello <strong>{$firstName}</strong>,</p>
                        <p>You're almost there! Click the button below to activate your Health &amp; Wellness account. This link is valid for <strong>1 hour</strong>.</p>
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
            send_email($email, $subject, $message);
            header("Location: register_verify.php");
        } else {
            $_SESSION['auth_flash'] = "Email or Phone Number already registered. Please login.";
            header("Location: register.php");
        }
        exit();
    }

    // Default profile picture
    $profile_picture = "images/uploads/default.png";

    // Handle image upload (optional)
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
        $ext      = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
        $new_name = time() . "_" . uniqid() . "." . $ext;
        $upload_dir = "images/uploads/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $dest = $upload_dir . $new_name;
        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $dest)) {
            $profile_picture = $dest;
        }
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate activation token (expires in 1 hour)
    $token   = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', time() + 3600);

    // Insert user as Inactive
    $ins = $con->prepare("INSERT INTO register (name, email, password, mobile, gender, profile_picture, role, status, token, token_expires) VALUES (?, ?, ?, ?, ?, ?, 'user', 'Inactive', ?, ?)");
    $ins->bind_param("ssssssss", $name, $email, $hashed_password, $phone, $gender, $profile_picture, $token, $expires);

    if (!$ins->execute()) {
        $_SESSION['auth_flash'] = "Registration failed: " . $ins->error;
        header("Location: register.php");
        exit();
    }

    // Store email in session so verify page can show it
    $_SESSION['pending_email']     = $email;
    $_SESSION['pending_firstName'] = $firstName;

    // Build activation link
    $activation_link = "http://" . $_SERVER['HTTP_HOST'] . "/health-and-wellness-dashboard/verify_email.php?token=" . $token;

    // Email body
    $subject = "Activate Your Account - Health & Wellness";
    $message = "
        <div style='font-family: Arial, sans-serif; padding: 20px; color: #333; max-width: 600px; margin: auto;'>
            <div style='background: linear-gradient(135deg,#065f46,#047857); padding: 30px; border-radius: 16px 16px 0 0; text-align:center;'>
                <h1 style='color:white; margin:0; font-size:28px;'>🌿 Health &amp; Wellness</h1>
            </div>
            <div style='background:white; padding:30px; border-radius:0 0 16px 16px; border:1px solid #e2e8f0; border-top:none;'>
                <h2 style='color:#047857;'>Welcome! Activate Your Account</h2>
                <p>Hello <strong>{$firstName}</strong>,</p>
                <p>Thank you for signing up with Health &amp; Wellness! Click the button below to activate your account. This link is valid for <strong>1 hour</strong>.</p>
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
        $_SESSION['auth_flash'] = "Activation link sent to your email. Please check your inbox.";
        header("Location: register_verify.php");
    } else {
        // Rollback — delete the inserted user so they can try again
        $con->query("DELETE FROM register WHERE email='" . mysqli_real_escape_string($con, $email) . "' AND status='Inactive'");
        $_SESSION['auth_flash'] = "Failed to send activation email. Please try again.";
        header("Location: register.php");
    }
    exit();

} else {
    header("Location: register.php");
    exit();
}
?>
