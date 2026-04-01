<?php
// verify.php
session_start();
require_once("db_config.php");

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify if token exists
    $stmt = $con->prepare("SELECT id, name FROM register WHERE token = ? LIMIT 1");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Update user status to Active and clear the token
        $updateStmt = $con->prepare("UPDATE register SET status = 'Active', token = NULL WHERE id = ?");
        $updateStmt->bind_param("i", $user['id']);
        
        if ($updateStmt->execute()) {
            $_SESSION['auth_flash'] = "Email verified successfully! You can now login.";
        } else {
            $_SESSION['auth_flash'] = "Error verifying email: " . $updateStmt->error;
        }
    } else {
        $_SESSION['auth_flash'] = "Invalid or expired token.";
    }
} else {
    $_SESSION['auth_flash'] = "No token provided.";
}

header("Location: login.php");
exit();
?>
