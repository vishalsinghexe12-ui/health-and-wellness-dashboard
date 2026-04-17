<?php
session_start();
$title = "Check Your Email - Health & Wellness";
$css   = "guest.css";

$email = $_SESSION['pending_email'] ?? null;
$firstName = $_SESSION['pending_firstName'] ?? 'there';

if (!$email) {
    header("Location: register.php");
    exit();
}

ob_start();
?>
<div style="min-height: calc(100vh - 130px); display:flex; align-items:center; justify-content:center; background: linear-gradient(135deg,#f0fdf4,#ecfdf5,#f0f9ff); padding: 40px 15px;">
    <div style="width:100%; max-width:500px;">
        <div class="card border-0 shadow-lg" style="border-radius: 24px; overflow:hidden;">
            <!-- Green top bar -->
            <div style="height:6px; background:linear-gradient(90deg,#059669,#0d9488);"></div>
            <div class="card-body p-5 text-center">
                <!-- Envelope icon with animation -->
                <div style="width:90px;height:90px;border-radius:24px;background:linear-gradient(135deg,#065f46,#047857);display:flex;align-items:center;justify-content:center;margin:0 auto 24px; box-shadow:0 12px 30px rgba(5,150,105,0.3);">
                    <i class="fa-solid fa-envelope-circle-check" style="font-size:44px; color:white;"></i>
                </div>

                <h2 class="font-weight-bold mb-2" style="color:#065f46; font-family:'Outfit',sans-serif; font-size:26px;">Check Your Email!</h2>
                <p class="text-muted mb-4" style="font-size:15px; line-height:1.7;">
                    Hi <strong><?php echo htmlspecialchars($firstName); ?></strong>! We've sent an activation link to<br>
                    <strong style="color:#047857;"><?php echo htmlspecialchars($email); ?></strong>
                </p>

                <?php if (isset($_SESSION['auth_flash'])): ?>
                <div class="alert border-0 mb-4" style="border-radius:12px; background:#f0fdf4; color:#166534; border:1px solid #bbf7d0;">
                    <i class="fa-solid fa-circle-check mr-2"></i>
                    <?php echo $_SESSION['auth_flash']; unset($_SESSION['auth_flash']); ?>
                </div>
                <?php endif; ?>

                <!-- Steps -->
                <div class="text-left mb-4" style="background:#f8fafc; border-radius:14px; padding:20px;">
                    <p class="font-weight-bold mb-3" style="color:#1e293b;">Next Steps:</p>
                    <div class="d-flex align-items-start mb-3">
                        <div style="width:30px;height:30px;border-radius:50%;background:#059669;color:white;font-weight:700;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;margin-right:12px;margin-top:2px;">1</div>
                        <p class="m-0 text-muted" style="font-size:14px;">Open your inbox for <strong><?php echo htmlspecialchars($email); ?></strong></p>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <div style="width:30px;height:30px;border-radius:50%;background:#059669;color:white;font-weight:700;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;margin-right:12px;margin-top:2px;">2</div>
                        <p class="m-0 text-muted" style="font-size:14px;">Find the email from <strong>Health &amp; Wellness</strong></p>
                    </div>
                    <div class="d-flex align-items-start">
                        <div style="width:30px;height:30px;border-radius:50%;background:#059669;color:white;font-weight:700;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;margin-right:12px;margin-top:2px;">3</div>
                        <p class="m-0 text-muted" style="font-size:14px;">Click <strong>"Activate My Account"</strong> to complete registration</p>
                    </div>
                </div>

                <p class="text-muted small mb-3"><i class="fa-solid fa-clock mr-1"></i> The link expires in <strong>1 hour</strong>. Check your spam folder too.</p>

                <a href="resend_otp.php" class="btn btn-outline-success btn-block mb-3" style="border-radius:10px; font-weight:600; padding:12px;">
                    <i class="fa-solid fa-rotate-right mr-2"></i> Resend Activation Link
                </a>
                <a href="register.php" class="text-muted" style="font-size:13px; text-decoration:none;">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Back to Registration
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
