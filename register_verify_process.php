<?php
session_start();
require_once("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION['pending_registration'])) {
        header("Location: register.php");
        exit();
    }

    $entered_otp = $_POST['otp'] ?? '';
    $pending_user = $_SESSION['pending_registration'];

    // Check expiration
    if (time() > $pending_user['expires']) {
        $_SESSION['auth_flash'] = "Verification code expired. Please register again.";
        unset($_SESSION['pending_registration']);
        header("Location: register.php");
        exit();
    }

    // Check OTP
    if ($entered_otp === $pending_user['otp']) {
        // Correct OTP! Complete registration
        $name = $pending_user['name'];
        $email = $pending_user['email'];
        $phone = $pending_user['phone'];
        $password = $pending_user['password'];
        $gender = $pending_user['gender'];
        $profile_picture = $pending_user['profile_picture'];

        // Securely hash the password before saving to DB
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $stmt = $con->prepare("INSERT INTO register (name, email, password, mobile, gender, profile_picture, status) VALUES (?, ?, ?, ?, ?, ?, 'Active')");
        $stmt->bind_param("ssssss", $name, $email, $hashed_password, $phone, $gender, $profile_picture);
        
        if ($stmt->execute()) {
            // Clear session
            unset($_SESSION['pending_registration']);
            $_SESSION['auth_flash'] = "Email verified! Registration successful. You can now login.";
            header("Location: login.php?msg=verified");
            exit();
        } else {
            $_SESSION['auth_flash'] = "Database error: " . $stmt->error;
            header("Location: register_verify.php");
            exit();
        }
    } else {
        // Incorrect OTP
        $_SESSION['auth_flash'] = "Invalid verification code. Please try again.";
        header("Location: register_verify.php");
        exit();
    }

} else {
    header("Location: register_verify.php");
    exit();
}
