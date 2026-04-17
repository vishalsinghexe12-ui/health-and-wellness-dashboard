<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id > 0) {
    if(mysqli_query($con, "DELETE FROM memberships WHERE id=$id")) {
        $_SESSION['mem_success'] = "Membership tier successfully deleted.";
    } else {
        $_SESSION['mem_success'] = "Database Error: " . mysqli_error($con);
    }
}
header("Location: manage-memberships.php");
exit();
?>
