<?php
ob_start();
session_start();
require_once("db_config.php");
require_once("includes/send_email.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $name = trim($firstName . ' ' . $lastName);
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? ''; 
    $gender = $_POST['gender'] ?? '';
    
    // Check if email or phone already exists
    $check_query = "SELECT id FROM register WHERE email = ? OR mobile = ?";
    $check_stmt = $con->prepare($check_query);
    $check_stmt->bind_param("ss", $email, $phone);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $_SESSION['auth_flash'] = "Email or Phone Number already registered.";
        header("Location: register.php");
        exit();
    }

    // Default image
    $profile_picture = "images/uploads/default.png";

    // Handle Image Upload (Optional)
    if(isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0){
        $ext = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
        $new_name = time() . "_" . uniqid() . "." . $ext;
        
        $upload_dir = "images/uploads/";
        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0777, true);
        }
        
        $dest = $upload_dir . $new_name;
        if(move_uploaded_file($_FILES['profileImage']['tmp_name'], $dest)){
            $profile_picture = $dest;
        }
    }

    // Generate 6-digit OTP
    $otp = sprintf("%06d", mt_rand(1, 999999));

    // Store in session
    $_SESSION['pending_registration'] = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'password' => $password, // Note: Handled by verify_process later
        'gender' => $gender,
        'profile_picture' => $profile_picture,
        'otp' => $otp,
        'expires' => time() + 600 // 10 minutes
    ];

    // Email body
    $subject = "Verify Your Email - Health & Wellness";
    $message = "
        <div style='font-family: Arial, sans-serif; padding: 20px; color: #333;'>
            <h2 style='color: #10b981;'>Email Verification</h2>
            <p>Hello <strong>{$firstName}</strong>,</p>
            <p>Thank you for signing up with Health & Wellness. Your verification code is:</p>
            <div style='font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #10b981; margin: 20px 0;'>{$otp}</div>
            <p>This code will expire in 10 minutes.</p>
            <p>If you did not request this, please ignore this email.</p>
        </div>
    ";

    // Send Email
    if (send_email($email, $subject, $message)) {
        $_SESSION['auth_flash'] = "Verification code sent to your email.";
        header("Location: register_verify.php");
    } else {
        $_SESSION['auth_flash'] = "Failed to send verification email. Please try again.";
        header("Location: register.php");
    }
    exit();

} else {
    header("Location: register.php");
    exit();
}
