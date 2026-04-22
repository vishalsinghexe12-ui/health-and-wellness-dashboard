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
    schedule_data TEXT DEFAULT NULL,
    status VARCHAR(20) DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($con, $create_plans);

// Safely add schedule_data column for existing installations
$chk_plan_sched = mysqli_query($con, "SHOW COLUMNS FROM plans LIKE 'schedule_data'");
if (mysqli_num_rows($chk_plan_sched) == 0) {
    mysqli_query($con, "ALTER TABLE plans ADD COLUMN schedule_data TEXT DEFAULT NULL AFTER image_path");
}

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

// Safely add start_date and end_date for upcoming queuing
$chk_purch_start = mysqli_query($con, "SHOW COLUMNS FROM user_purchases LIKE 'start_date'");
if (mysqli_num_rows($chk_purch_start) == 0) {
    mysqli_query($con, "ALTER TABLE user_purchases ADD COLUMN start_date DATETIME NULL AFTER purchase_date");
    mysqli_query($con, "ALTER TABLE user_purchases ADD COLUMN end_date DATETIME NULL AFTER start_date");
    
    // Backfill logic for existing active purchases
    // Simplistic interpolation: '1 Month' adds 1 month, others default to 3 months for existing DB fixes if any
    mysqli_query($con, "
        UPDATE user_purchases 
        SET start_date = purchase_date, 
            end_date = CASE 
                WHEN LOWER(duration) LIKE '%1 month%' THEN DATE_ADD(purchase_date, INTERVAL 1 MONTH)
                ELSE DATE_ADD(purchase_date, INTERVAL 3 MONTH)
            END
        WHERE start_date IS NULL
    ");
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

// Offers & Discounts table
$create_offers = "CREATE TABLE IF NOT EXISTS offers_discounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    discount_percentage INT,
    image_path VARCHAR(255),
    valid_until DATE,
    status VARCHAR(20) DEFAULT 'Active',
    plan_type VARCHAR(20) DEFAULT 'Both',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($con, $create_offers);

// Safely add plan_type column for existing installations
$chk_offer_type = mysqli_query($con, "SHOW COLUMNS FROM offers_discounts LIKE 'plan_type'");
if (mysqli_num_rows($chk_offer_type) == 0) {
    mysqli_query($con, "ALTER TABLE offers_discounts ADD COLUMN plan_type VARCHAR(20) DEFAULT 'Both' AFTER status");
}

// Safely add offer_discount column to user_purchases
$chk_offer_disc = mysqli_query($con, "SHOW COLUMNS FROM user_purchases LIKE 'offer_discount'");
if (mysqli_num_rows($chk_offer_disc) == 0) {
    mysqli_query($con, "ALTER TABLE user_purchases ADD COLUMN offer_discount INT DEFAULT 0 AFTER duration");
}

// Safely add token_expires column to register
$chk_token_exp = mysqli_query($con, "SHOW COLUMNS FROM register LIKE 'token_expires'");
if (mysqli_num_rows($chk_token_exp) == 0) {
    mysqli_query($con, "ALTER TABLE register ADD COLUMN token_expires DATETIME DEFAULT NULL AFTER token");
}

// Guest Page Content table
$create_guest_content = "CREATE TABLE IF NOT EXISTS guest_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section VARCHAR(50) NOT NULL,
    sort_order INT DEFAULT 0,
    title VARCHAR(255),
    subtitle TEXT,
    body TEXT,
    image_path VARCHAR(255),
    button_text VARCHAR(100),
    button_url VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($con, $create_guest_content);

// Seed default guest page content if table is empty
$check_seed = mysqli_query($con, "SELECT COUNT(*) as cnt FROM guest_content");
$seed_row = mysqli_fetch_assoc($check_seed);
if ($seed_row['cnt'] == 0) {
    $seeds = [
        ["section"=>"banner", "sort_order"=>0, "title"=>"Stay Fit, Stay Healthy!", "subtitle"=>"Enjoy fitness, meal plans, and Wellness Boosts designed to help you live your best life.", "body"=>"", "image_path"=>"", "button_text"=>"Get Started Today", "button_url"=>"register.php"],
        ["section"=>"tip_card", "sort_order"=>1, "title"=>"Stay Hydrated", "subtitle"=>"Drink at least 8 glasses of water a day to keep your body hydrated and functioning properly.", "body"=>"Proper hydration keeps your body functioning efficiently and boosts daily performance. Water is essential for almost every function in the human body. It helps regulate body temperature, supports digestion, transports nutrients, and removes waste through urine and sweat. Staying properly hydrated improves concentration, prevents fatigue, and keeps your skin healthy. Experts generally recommend consuming 7-8 glasses of water per day.", "image_path"=>"images/get-hydrated.jpeg", "button_text"=>"", "button_url"=>""],
        ["section"=>"tip_card", "sort_order"=>2, "title"=>"Enough Sleep", "subtitle"=>"Get 7-9 hours of quality sleep each night to support overall health and energy levels.", "body"=>"Sleep plays a vital role in maintaining both physical and mental health. During sleep, the body repairs damaged tissues, strengthens the immune system, and restores energy levels. It also supports brain function by enhancing memory, learning ability, and emotional balance. Adults generally require 7-9 hours of quality sleep per night for optimal performance.", "image_path"=>"images/enough-sleep.jpeg", "button_text"=>"", "button_url"=>""],
        ["section"=>"tip_card", "sort_order"=>3, "title"=>"Manage Stress", "subtitle"=>"Practice relaxation techniques like meditation and deep breathing to reduce stress.", "body"=>"Stress is a natural response to challenging situations, but prolonged stress can negatively impact health. Chronic stress can lead to headaches, digestive problems, sleep disturbances, and even heart-related issues. Techniques such as deep breathing exercises, meditation, yoga, and mindfulness can help calm the mind and reduce anxiety.", "image_path"=>"images/manage-stress.jpeg", "button_text"=>"", "button_url"=>""],
        ["section"=>"tip_card", "sort_order"=>4, "title"=>"Eat More Greens", "subtitle"=>"Add more green vegetables to your meals for better immunity and overall health.", "body"=>"Green vegetables are one of the most powerful natural sources of essential nutrients. They are rich in vitamins A, C, and K, along with iron, calcium, and antioxidants that help strengthen the immune system. Leafy greens such as spinach, kale, broccoli, and lettuce also contain high fiber content, which improves digestion and promotes gut health.", "image_path"=>"Images/Eat More Greens.jpeg", "button_text"=>"", "button_url"=>""],
        ["section"=>"tip_card", "sort_order"=>5, "title"=>"Regular Exercise", "subtitle"=>"Daily physical activity strengthens your body and reduces disease risk.", "body"=>"Regular exercise is one of the most effective ways to maintain a healthy lifestyle. Physical activity strengthens the heart, improves blood circulation, builds muscle, and increases flexibility. Exercise has significant mental health benefits as well. Physical activity releases endorphins which help reduce stress, anxiety, and depression.", "image_path"=>"Images/Regular Exercise.jpeg", "button_text"=>"", "button_url"=>""],
        ["section"=>"tip_card", "sort_order"=>6, "title"=>"Healthy Snacks", "subtitle"=>"Choose nutritious snacks to maintain energy and avoid unhealthy cravings.", "body"=>"Snacking is a common habit, but choosing the right snacks makes a big difference in overall health. Healthy snacks provide essential nutrients and sustained energy without causing sudden spikes in blood sugar levels. Options such as fruits, nuts, yogurt, boiled eggs, and whole-grain snacks are excellent choices.", "image_path"=>"Images/Healthy Snacks.jpeg", "button_text"=>"", "button_url"=>""]
    ];
    foreach ($seeds as $s) {
        $sec = mysqli_real_escape_string($con, $s['section']);
        $ord = (int)$s['sort_order'];
        $tit = mysqli_real_escape_string($con, $s['title']);
        $sub = mysqli_real_escape_string($con, $s['subtitle']);
        $bod = mysqli_real_escape_string($con, $s['body']);
        $img = mysqli_real_escape_string($con, $s['image_path']);
        $btn = mysqli_real_escape_string($con, $s['button_text']);
        $bur = mysqli_real_escape_string($con, $s['button_url']);
        mysqli_query($con, "INSERT INTO guest_content (section, sort_order, title, subtitle, body, image_path, button_text, button_url) VALUES ('$sec', $ord, '$tit', '$sub', '$bod', '$img', '$btn', '$bur')");
    }
}

// Memberships Table
$create_memberships = "CREATE TABLE IF NOT EXISTS memberships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    price INT NOT NULL,
    duration VARCHAR(50) DEFAULT '1 Month',
    features TEXT,
    status VARCHAR(20) DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($con, $create_memberships);

// Seed Default Memberships if empty
$chk_mbr = mysqli_query($con, "SELECT COUNT(*) as cnt FROM memberships");
$mbr_row = mysqli_fetch_assoc($chk_mbr);
if ($mbr_row['cnt'] == 0) {
    mysqli_query($con, "INSERT INTO memberships (title, description, price, duration, features, status) VALUES 
        ('Basic Community', 'Join our private forum and track your progress.', 499, '1 Month', 'Private Community Access,Surprise Rewards System', 'Active'),
        ('Pro Access', 'Everything in Basic plus downloadable diet recipes and workout templates.', 899, '1 Month', 'Private Community Access,Surprise Rewards System,Downloadable Resources', 'Active'),
        ('Elite Coaching', 'Full suite! Priority expert support and live AI fitness assistance.', 1999, '3 Months', 'Private Community Access,Surprise Rewards System,Downloadable Resources,Priority Expert Help,AI Fitness Assistant', 'Active')
    ");
}

// User Memberships Table tracking active subscriptions
$create_user_memberships = "CREATE TABLE IF NOT EXISTS user_memberships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    membership_id INT NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    streak_days INT DEFAULT 0,
    last_login DATE NULL,
    status VARCHAR(20) DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES register(id) ON DELETE CASCADE,
    FOREIGN KEY (membership_id) REFERENCES memberships(id) ON DELETE CASCADE
)";
mysqli_query($con, $create_user_memberships);

// Pages content table for Guest Pages
$create_pages = "CREATE TABLE IF NOT EXISTS tblpage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    PageType VARCHAR(100) NOT NULL,
    PageTitle VARCHAR(255) NOT NULL,
    PageDescription TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysqli_query($con, $create_pages);

// Seed default dynamic pages if table is empty
$chk_pages = mysqli_query($con, "SELECT COUNT(*) as cnt FROM tblpage");
$page_row = mysqli_fetch_assoc($chk_pages);
if ($page_row['cnt'] == 0) {
    $seed_p = $con->prepare("INSERT INTO tblpage (PageType, PageTitle, PageDescription) VALUES (?, ?, ?)");
    
    // aboutus
    $pt = 'aboutus'; $t = 'About Health & Wellness'; $d = 'Health & Wellness was created to help individuals take control of their physical and mental well-being.';
    $seed_p->bind_param("sss", $pt, $t, $d); $seed_p->execute();
    
    // contactus
    $pt = 'contactus'; $t = 'Get In Touch'; $d = "We'd love to hear from you. Send us a message and we'll respond as soon as possible.";
    $seed_p->bind_param("sss", $pt, $t, $d); $seed_p->execute();

    // plans
    $pt = 'plans'; $t = 'Our Wellness Plans'; $d = 'Explore our comprehensive wellness plans tailored for your unique fitness goals.';
    $seed_p->bind_param("sss", $pt, $t, $d); $seed_p->execute();

    // gallery
    $pt = 'gallery'; $t = 'Gallery'; $d = 'A collection of visual inspirations for your wellness journey.';
    $seed_p->bind_param("sss", $pt, $t, $d); $seed_p->execute();
}

