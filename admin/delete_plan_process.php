<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plan_id'])) {
    $id = (int)$_POST['plan_id'];
    $redirect = $_POST['redirect'] ?? 'plans.php';

    $stmt = $con->prepare("DELETE FROM plans WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: $redirect");
    exit();
}

header("Location: plans.php");
exit();
?>
