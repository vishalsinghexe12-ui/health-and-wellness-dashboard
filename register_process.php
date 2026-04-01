<?php
session_start();
require_once("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $name = trim($firstName . ' ' . $lastName);
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? ''; 
    $gender = $_POST['gender'] ?? '';
    
    // Default image
    $profile_picture = "default.png";

    // Handle Image Upload
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

    // Include the email helper
    require_once("includes/send_email.php");

    // Generate Verification Token
    $token = bin2hex(random_bytes(16));

    // Insert user
    // `role` defaults to 'user', `status` defaults to 'Inactive' per schema.
    try {
        $stmt = $con->prepare("INSERT INTO register (name, email, password, mobile, gender, profile_picture, token) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $email, $password, $phone, $gender, $profile_picture, $token);
        
        if ($stmt->execute()) {
            // Build the verify URL (assuming Laragon root)
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $domain = $_SERVER['HTTP_HOST'];
            $app_path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $verifyUrl = "{$protocol}://{$domain}{$app_path}/verify.php?token={$token}";

            // Email body
            $subject = "Verify Your Account - Health & Wellness";
            $message = "
                <h3>Welcome to Health & Wellness Dashboard, {$firstName}!</h3>
                <p>Please click the link below to verify your email address and activate your account:</p>
                <a href='{$verifyUrl}'>{$verifyUrl}</a>
                <p>If you didn't request this, you can ignore this email.</p>
            ";

            // Send Email
            if (send_email($email, $subject, $message)) {
                $_SESSION['auth_flash'] = "Registration successful! Check your email to verify your account.";
            } else {
                $_SESSION['auth_flash'] = "Registered but failed to send verification email.";
            }
            header("Location: login.php?msg=registered");
            exit();
        } else {
            $_SESSION['auth_flash'] = "Registration Failed: " . $stmt->error;
            header("Location: register.php?error=failed");
            exit();
        }
    } catch(Exception $e) {
        $_SESSION['auth_flash'] = "Error: Email may already exist.";
        header("Location: register.php?error=email_exists");
        exit();
    }
} else {
    header("Location: register.php");
    exit();
}
?>
