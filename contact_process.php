<?php
session_start();

function redirectContact(string $query = '') {
    $location = 'contact.php';
    if ($query !== '') {
        $location .= '?' . $query;
    }
    header('Location: ' . $location);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectContact('error=invalid_request');
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

$errors = [];
if (strlen($name) < 2) {
    $errors[] = 'Name must be at least 2 characters.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}
if (strlen($subject) < 3) {
    $errors[] = 'Subject must be at least 3 characters.';
}
if (strlen($message) < 10) {
    $errors[] = 'Message must be at least 10 characters.';
}

$_SESSION['contact_form'] = [
    'name' => htmlspecialchars($name, ENT_QUOTES),
    'email' => htmlspecialchars($email, ENT_QUOTES),
    'subject' => htmlspecialchars($subject, ENT_QUOTES),
    'message' => htmlspecialchars($message, ENT_QUOTES),
];

if (!empty($errors)) {
    $_SESSION['flash_message'] = implode(' ', $errors);
    redirectContact('error=validation');
}

// Save message to local JSON store.
$dataFile = __DIR__ . '/messages_data.json';
$messages = [];
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $messages = json_decode($json, true) ?: [];
    if (!is_array($messages)) {
        $messages = [];
    }
}

$messages[] = [
    'id' => uniqid('msg_', true),
    'name' => $name,
    'email' => $email,
    'subject' => $subject,
    'message' => $message,
    'status' => 'new',
    'created_at' => date('Y-m-d H:i:s'),
];

file_put_contents($dataFile, json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

$_SESSION['flash_message'] = 'Thank you for contacting us! Your message has been submitted successfully.';
unset($_SESSION['contact_form']);

redirectContact('msg=sent');
?>
