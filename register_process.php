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

    // Insert user
    // `role` defaults to 'user', `status` defaults to 'Inactive' per schema.
    try {
        $stmt = $con->prepare("INSERT INTO register (name, email, password, mobile, gender, profile_picture) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $password, $phone, $gender, $profile_picture);
        
        if ($stmt->execute()) {
            $_SESSION['auth_flash'] = "Registration successful! Please login.";
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
