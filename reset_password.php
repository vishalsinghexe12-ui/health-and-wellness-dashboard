<?php
$title = "Reset Password - Health & Wellness";
$css = "guest.css";
ob_start();
session_start();
require_once("db_config.php");

if (!isset($_SESSION['reset_email']) || !isset($_SESSION['otp_verified'])) {
    header("Location: forgot_password.php");
    exit();
}

$email = $_SESSION['reset_email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($password) || empty($confirm)) {
        $_SESSION['auth_flash'] = "Please fill completely.";
    } elseif ($password !== $confirm) {
        $_SESSION['auth_flash'] = "Passwords do not match!";
    } else {
        // Validation for strong password if you wish (skipping back-end regex for simplicity right now)
        
        // Securely hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Update user database
        $stmt = $con->prepare("UPDATE register SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        
        if ($stmt->execute()) {
            // Nullify token
            $nullToken = $con->prepare("UPDATE password_token SET otp = NULL, expires_at = NULL WHERE email = ?");
            $nullToken->bind_param("s", $email);
            $nullToken->execute();

            // Clear sessions
            unset($_SESSION['reset_email']);
            unset($_SESSION['otp_verified']);

            $_SESSION['auth_flash'] = "Password reset successfully! Please log in.";
            header("Location: login.php?msg=reset_success");
            exit();
        } else {
            $_SESSION['auth_flash'] = "An error occurred updating your password.";
        }
    }
}
?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card border-0 shadow-lg">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success">New Password</h2>
                    <p class="text-muted">Enter a new password for <?php echo htmlspecialchars($email); ?>.</p>
                </div>
                
                <?php if(isset($_SESSION['auth_flash'])): ?>
                    <div class="alert alert-warning text-center">
                        <?php 
                        echo $_SESSION['auth_flash']; 
                        unset($_SESSION['auth_flash']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="reset_password.php" method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">New Password</label>
                        <input type="password" class="form-control" name="new_password" placeholder="Min 8 chars, 1 Upper, 1 Special" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" placeholder="Repeat new password" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Set New Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
