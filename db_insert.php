<?php
// ============================
// DB INSERT — Seed Admin User
// ============================
include_once "db_config.php";

// Check if admin already exists
$check = mysqli_query($con, "SELECT id FROM register WHERE email = 'admin@healthwellness.com'");

if (mysqli_num_rows($check) == 0) {
    $token = bin2hex(random_bytes(15));
    $hashed_password = password_hash("Admin@1234", PASSWORD_DEFAULT);

    $insert_admin = "INSERT INTO register (name, email, password, mobile, gender, profile_picture, role, status, token) 
    VALUES ('Admin', 'admin@healthwellness.com', '$hashed_password', 9876543210, 'male', 'default.png', 'admin', 'Active', '$token')";

    if (mysqli_query($con, $insert_admin)) {
        echo "<h3 style='color:green;'>✅ Admin user created successfully!</h3>";
        echo "<p><strong>Email:</strong> admin@healthwellness.com</p>";
        echo "<p><strong>Password:</strong> Admin@1234</p>";
    } else {
        echo "<h3 style='color:red;'>❌ Error creating admin: " . mysqli_error($con) . "</h3>";
    }
} else {
    echo "<h3 style='color:orange;'>⚠️ Admin user already exists.</h3>";
}

// Insert a sample test user
$check_user = mysqli_query($con, "SELECT id FROM register WHERE email = 'prajakta@email.com'");

if (mysqli_num_rows($check_user) == 0) {
    $token2 = bin2hex(random_bytes(15));
    $hashed_password2 = password_hash("Prajakta@1234", PASSWORD_DEFAULT);

    $insert_user = "INSERT INTO register (name, email, password, mobile, gender, profile_picture, role, status, token) 
    VALUES ('Prajakta Sarode', 'prajakta@email.com', '$hashed_password2', 9876543210, 'female', 'default.png', 'user', 'Active', '$token2')";

    if (mysqli_query($con, $insert_user)) {
        echo "<h3 style='color:green;'>✅ Test user created successfully!</h3>";
        echo "<p><strong>Email:</strong> prajakta@email.com</p>";
        echo "<p><strong>Password:</strong> Prajakta@1234</p>";
    } else {
        echo "<h3 style='color:red;'>❌ Error creating user: " . mysqli_error($con) . "</h3>";
    }
} else {
    echo "<h3 style='color:orange;'>⚠️ Test user already exists.</h3>";
}

echo "<br><a href='login.php'>Go to Login →</a>";
?>
