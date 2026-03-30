<?php
session_start();
// Dummy processing logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect email and set dummy session
    $_SESSION['user_email'] = isset($_POST['email']) ? $_POST['email'] : 'user@example.com';
    $_SESSION['logged_in'] = true;
    
    // Redirect to the user dashboard
    header("Location: user/register-dashboard.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>
