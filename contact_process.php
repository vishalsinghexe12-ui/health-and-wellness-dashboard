<?php
session_start();
// Dummy contact form logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simulate setting a success message
    $_SESSION['flash_message'] = "Thank you for contacting us! We'll reply shortly.";
    
    header("Location: contact.php?msg=sent");
    exit();
} else {
    header("Location: contact.php");
    exit();
}
?>
