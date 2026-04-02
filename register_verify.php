<?php
session_start();
$title = "Verify Email - Health & Wellness";
$css = "guest.css";

if (!isset($_SESSION['pending_registration'])) {
    header("Location: register.php");
    exit();
}

$pending_user = $_SESSION['pending_registration'];
$email = $pending_user['email'];

ob_start();
?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card border-0 shadow-lg" style="border-radius: 20px;">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fa-solid fa-envelope-circle-check text-success" style="font-size: 60px;"></i>
                    </div>
                    <h2 class="fw-bold text-success">Verify Your Email</h2>
                    <p class="text-muted">A 6-digit verification code has been sent to <br><strong><?php echo htmlspecialchars($email); ?></strong></p>
                </div>
                
                <?php if(isset($_SESSION['auth_flash'])): ?>
                    <div class="alert alert-info text-center border-0 shadow-sm" style="border-radius: 12px; background-color: #f0fdf4; color: #166534;">
                        <?php 
                        echo $_SESSION['auth_flash']; 
                        unset($_SESSION['auth_flash']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="register_verify_process.php" method="POST">
                    <div class="mb-4 text-center">
                        <label class="form-label fw-semibold mb-3">Enter Verification Code</label>
                        <div class="d-flex justify-content-center gap-2">
                             <input type="text" class="form-control text-center" name="otp" placeholder="123456" maxlength="6" required style="letter-spacing: 12px; font-size: 28px; font-weight: 800; border-radius: 12px; border: 2px solid #e2e8f0; height: 70px;">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100 btn-lg shadow-sm" style="border-radius: 12px; padding: 15px; font-weight: 700; transition: all 0.3s ease;">Verify & Create Account</button>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted small">Didn't receive the code? 
                            <a href="resend_otp.php" class="text-success text-decoration-none font-weight-bold">Resend OTP</a>
                        </p>
                        <p class="text-muted" style="font-size: 12px;"><i class="fa-solid fa-clock mr-1"></i> Code expires in 10 minutes</p>
                        <hr class="my-4" style="opacity: 0.1;">
                        <a href="register.php" class="text-muted small text-decoration-none"><i class="fa-solid fa-arrow-left mr-2"></i> Back to Registration</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
}
input:focus {
    border-color: #10b981 !important;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1) !important;
}
</style>

<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
