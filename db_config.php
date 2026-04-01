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
$create_table = "create table register(
id int auto_increment primary key, 
name char(30), email varchar(20), 
password varchar(20),
mobile bigint(10),
gender char(10), 
profile_picture text,
role char(20) default 'user',
status char(10) default 'Inactive',
token varchar(255) default null)";
mysqli_query($con, $create_table);

// Plans table
$create_plans = "CREATE TABLE IF NOT EXISTS plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    duration VARCHAR(100),
    calories VARCHAR(100),
    intensity VARCHAR(100),
    price INT,
    image_path VARCHAR(255),
    status VARCHAR(20) DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($con, $create_plans);

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
