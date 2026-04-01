<?php
session_start();
// Dummy registration logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Optionally set a flash message
    $_SESSION['auth_flash'] = "Registration successful! Please login.";
    
    // Redirect to login page
    header("Location: login.php?msg=registered");
    exit();
} else {
    header("Location: register.php");
    exit();
}
?>
