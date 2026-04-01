<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plan_id'])) {
    $id = (int)$_POST['plan_id'];
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price = (int)($_POST['price'] ?? 0);
    $duration = trim($_POST['duration'] ?? '');
    $calories = trim($_POST['calories'] ?? '');
    $intensity = trim($_POST['intensity'] ?? '');
    $status = $_POST['status'] ?? 'Active';
    $redirect = $_POST['redirect'] ?? 'plans.php';

    if (!empty($title)) {
        $stmt = $con->prepare("UPDATE plans SET title=?, description=?, category=?, price=?, duration=?, calories=?, intensity=?, status=? WHERE id=?");
        $stmt->bind_param("sssissssi", $title, $description, $category, $price, $duration, $calories, $intensity, $status, $id);
        $stmt->execute();
    }

    header("Location: $redirect");
    exit();
}

header("Location: plans.php");
exit();
?>
