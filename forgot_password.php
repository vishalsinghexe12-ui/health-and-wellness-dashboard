<?php
$title = "Forgot Password - Health & Wellness";
$css = "guest.css";
ob_start();
session_start();
?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card border-0 shadow-lg">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success">Forgot Password</h2>
                    <p class="text-muted">Enter your email to receive an OTP.</p>
                </div>
                
                <?php if(isset($_SESSION['auth_flash'])): ?>
                    <div class="alert alert-warning text-center">
                        <?php 
                        echo $_SESSION['auth_flash']; 
                        unset($_SESSION['auth_flash']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="forgot_password_process.php" method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your registered email" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Send OTP</button>
                    <div class="text-center mt-3">
                        <a href="login.php" class="text-success text-decoration-none">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
