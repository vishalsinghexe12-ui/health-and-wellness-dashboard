<?php
$title = "Verify OTP - Health & Wellness";
$css = "guest.css";
ob_start();
session_start();

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}
?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card border-0 shadow-lg">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success">Enter OTP</h2>
                    <p class="text-muted">An OTP has been sent to <?php echo htmlspecialchars($_SESSION['reset_email']); ?>.</p>
                </div>
                
                <?php if(isset($_SESSION['auth_flash'])): ?>
                    <div class="alert alert-info text-center">
                        <?php 
                        echo $_SESSION['auth_flash']; 
                        unset($_SESSION['auth_flash']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="verify_otp_process.php" method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">OTP</label>
                        <input type="text" class="form-control text-center" name="otp" placeholder="123456" maxlength="6" required style="letter-spacing: 5px; font-size: 20px;">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Verify OTP</button>
                    <div class="text-center mt-3">
                        <a href="forgot_password.php" class="text-success text-decoration-none">Resend OTP</a>
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
