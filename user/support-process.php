<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}
require_once("../db_config.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: support.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// Server-side validation
$errors = [];
if (strlen($name) < 2) $errors[] = 'Name must be at least 2 characters.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email.';
if (strlen($subject) < 3) $errors[] = 'Subject must be at least 3 characters.';
if (strlen($message) < 10) $errors[] = 'Message must be at least 10 characters.';

if (!empty($errors)) {
    $_SESSION['support_flash'] = implode(' ', $errors);
    header("Location: support.php");
    exit();
}

// Insert into contact_messages table
$stmt = $con->prepare("INSERT INTO contact_messages (user_id, name, email, subject, message, status) VALUES (?, ?, ?, ?, ?, 'new')");
$stmt->bind_param("issss", $user_id, $name, $email, $subject, $message);

if ($stmt->execute()) {
    $_SESSION['support_flash'] = "Your support ticket has been submitted successfully! Our team will get back to you soon.";
} else {
    $_SESSION['support_flash'] = "Error submitting your ticket. Please try again.";
}

header("Location: support.php");
exit();
?>
