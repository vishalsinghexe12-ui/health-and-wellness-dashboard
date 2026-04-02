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
$create_table = "CREATE TABLE IF NOT EXISTS register(
id int auto_increment primary key, 
name varchar(100), 
email varchar(100) UNIQUE, 
password varchar(255),
mobile varchar(15) UNIQUE,
gender char(10), 
profile_picture text,
role char(20) default 'user',
status char(10) default 'Inactive',
token varchar(255) default null,
otp varchar(10) default null)";
mysqli_query($con, $create_table);

// Subscribers table
$create_subscribers = "CREATE TABLE IF NOT EXISTS subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($con, $create_subscribers);

// Seed default Admin and User with HASHED passwords
$admin_email = 'admin@admin.com';
$admin_pass = 'Admin@123';
$admin_hash = password_hash($admin_pass, PASSWORD_DEFAULT);

$user_email = 'user@user.com';
$user_pass = 'User@123';
$user_hash = password_hash($user_pass, PASSWORD_DEFAULT);

// Update existing if they are still plaintext (Admin)
$check_admin = mysqli_query($con, "SELECT password FROM register WHERE email = '$admin_email'");
if ($row = mysqli_fetch_assoc($check_admin)) {
    if (!password_get_info($row['password'])['algo']) {
        // It's plaintext, update to hash
        $upd = "UPDATE register SET password = '$admin_hash' WHERE email = '$admin_email'";
        mysqli_query($con, $upd);
    }
} else {
    // Insert new
    $seed_admin = "INSERT INTO register (name, email, password, role, status) VALUES ('Admin', '$admin_email', '$admin_hash', 'admin', 'Active')";
    mysqli_query($con, $seed_admin);
}

// Update existing if they are still plaintext (User)
$check_user = mysqli_query($con, "SELECT password FROM register WHERE email = '$user_email'");
if ($row = mysqli_fetch_assoc($check_user)) {
    if (!password_get_info($row['password'])['algo']) {
        $upd = "UPDATE register SET password = '$user_hash' WHERE email = '$user_email'";
        mysqli_query($con, $upd);
    }
} else {
    $seed_user = "INSERT INTO register (name, email, password, role, status) VALUES ('User', '$user_email', '$user_hash', 'user', 'Active')";
    mysqli_query($con, $seed_user);
}

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
    user_id INT DEFAULT NULL,
    admin_reply TEXT DEFAULT NULL,
    replied_at TIMESTAMP NULL DEFAULT NULL,
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

// User Purchases table
$create_purchases = "CREATE TABLE IF NOT EXISTS user_purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    plan_name VARCHAR(255) NOT NULL,
    price INT,
    duration VARCHAR(50) DEFAULT '3 Months',
    status VARCHAR(50) DEFAULT 'Active',
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) engine=InnoDB";
mysqli_query($con, $create_purchases);

// Safely add duration column for existing installations
$chk_purch_dur = mysqli_query($con, "SHOW COLUMNS FROM user_purchases LIKE 'duration'");
if (mysqli_num_rows($chk_purch_dur) == 0) {
    mysqli_query($con, "ALTER TABLE user_purchases ADD COLUMN duration VARCHAR(50) DEFAULT '3 Months' AFTER price");
}

// Bulk update existing plans to have a 3-month duration if they're empty
mysqli_query($con, "UPDATE plans SET duration = '3 Months' WHERE duration IS NULL OR duration = ''");

// User Wellness Profiles table (for personalized recommendations)
$create_wellness = "CREATE TABLE IF NOT EXISTS user_wellness_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    fitness_goal VARCHAR(100),
    diet_preference VARCHAR(100),
    activity_level VARCHAR(50),
    age INT,
    weight DECIMAL(5,1),
    height DECIMAL(5,1),
    bmi DECIMAL(4,1),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($con, $create_wellness);
