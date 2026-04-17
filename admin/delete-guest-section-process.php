<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['section_id']) ? (int)$_POST['section_id'] : 0;
    
    if($id > 0) {
        $del = $con->prepare("DELETE FROM guest_content WHERE id = ?");
        $del->bind_param("i", $id);
        if($del->execute()) {
            $_SESSION['guest_success'] = "Section deleted successfully.";
        } else {
            $_SESSION['guest_error'] = "Failed to delete: " . $con->error;
        }
    }
    header("Location: manage-guest-page.php");
    exit();
}
?>
