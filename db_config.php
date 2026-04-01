<?php
// ============================
// DB CONFIG — Health & Wellness
// ============================

// Step 1: Create connection
try {
    $con = mysqli_connect("localhost", "root", "");
    if (!$con) {
        throw new Exception("Connection failed");
    }
} catch (Exception $e) {
    die("Error in connection: " . $e->getMessage());
}

// Step 2: Create database (if not exists)
$create_db = "CREATE DATABASE IF NOT EXISTS health_and_wellness";
mysqli_query($con, $create_db);

// Step 3: Select database
try {
    mysqli_select_db($con, "health_and_wellness");
} catch (Exception $e) {
    die("Error connecting to DB: " . $e->getMessage());
}

// Step 4: Create tables (if not exist)

// Users table
$create_register = "CREATE TABLE IF NOT EXISTS register (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(60) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    mobile BIGINT(10),
    gender CHAR(10),
    profile_picture TEXT DEFAULT 'default.png',
    role VARCHAR(20) DEFAULT 'user',
    status VARCHAR(10) DEFAULT 'Active',
    token VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($con, $create_register);

// Password reset tokens table
$create_password_token = "CREATE TABLE IF NOT EXISTS password_token (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    otp VARCHAR(10) DEFAULT NULL,
    otp_attempts INT DEFAULT 0,
    last_resend DATETIME DEFAULT NULL,
    expires_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($con, $create_password_token);

// Contact messages table
$create_contact = "CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(60) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($con, $create_contact);

// Set timezone
date_default_timezone_set('Asia/Kolkata');
$current_time = date("Y-m-d H:i:s");

// Reset OTP resend attempts after 24 hours
$reset_otp_attempts_query = "UPDATE password_token 
SET otp_attempts = 0 
WHERE last_resend IS NOT NULL 
AND last_resend <= DATE_SUB(NOW(), INTERVAL 24 HOUR)";
mysqli_query($con, $reset_otp_attempts_query);

// Expire OTPs after 2 minutes
$expire_otp_query = "UPDATE password_token SET otp = NULL WHERE expires_at < NOW()";
mysqli_query($con, $expire_otp_query);
?>
