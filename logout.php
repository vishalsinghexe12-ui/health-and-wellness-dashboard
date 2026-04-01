<?php
session_start();

if (isset($_SESSION['user_id'])) {
    require_once("db_config.php");
    $stmt = $con->prepare("UPDATE register SET token = NULL WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
}

if (isset($_COOKIE['remember_login'])) {
    setcookie('remember_login', '', time() - 3600, "/");
}

session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
