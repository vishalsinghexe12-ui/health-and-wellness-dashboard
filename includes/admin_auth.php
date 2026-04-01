<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) && isset($_COOKIE['remember_login'])) {
    require_once(__DIR__ . "/../db_config.php");
    $token = $_COOKIE['remember_login'];
    $stmt = $con->prepare("SELECT id, name, email, role, profile_picture FROM register WHERE token = ? AND role = 'admin'");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['profile_picture'] = $row['profile_picture'];
        $_SESSION['logged_in'] = true;
    }
}

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
