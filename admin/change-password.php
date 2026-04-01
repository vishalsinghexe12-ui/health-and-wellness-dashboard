<?php
$title = "Change Password - Admin Panel";
$css = "admin.css";

ob_start();
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">

                <!-- Card Accent Top Bar -->
                <div style="height: 5px; background: linear-gradient(90deg, #059669, #0d9488);"></div>

                <div class="card-body p-4 p-md-5">

                    <!-- Header -->
                    <div class="text-center mb-4">
                        <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #059669, #0d9488); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);">
                            <i class="fas fa-user-shield" style="font-size: 32px; color: white;"></i>
                        </div>
                        <h3 style="font-family: 'Outfit', sans-serif; font-weight: 800; color: #111827;">Change Admin Password</h3>
                        <p class="text-muted" style="font-size: 15px;">Keep your admin account secure with a strong password</p>
                    </div>

                    <!-- Flash Message -->
                    <?php
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    if (isset($_SESSION['pwd_flash'])) {
                        $flash_type = $_SESSION['pwd_flash_type'] ?? 'danger';
                        echo '<div class="alert alert-' . $flash_type . ' alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; font-weight: 500;">
                                <i class="fas ' . ($flash_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle') . ' me-2"></i>'
                                . $_SESSION['pwd_flash'] .
                                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                              </div>';
                        unset($_SESSION['pwd_flash']);
                        unset($_SESSION['pwd_flash_type']);
                    }
                    ?>

                    <!-- Change Password Form -->
                    <form action="../change_password_process.php" method="POST" id="changePasswordForm">
                        <input type="hidden" name="panel" value="admin">

                        <div class="mb-4">
                            <label class="form-label" style="font-family: 'Outfit', sans-serif; font-weight: 600; color: #374151; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                                <i class="fas fa-key me-1" style="color: #059669;"></i> Old Password
                            </label>
                            <div class="input-group">
                                <input type="password"
                                       class="form-control"
                                       name="old_password"
                                       id="oldPassword"
                                       placeholder="Enter your current password"
                                       required
                                       style="border-right: none;">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="oldPassword"
                                        style="border: 1px solid #e5e7eb; border-left: none; background: #f9fafb; border-radius: 0 8px 8px 0;">
                                    <i class="fas fa-eye" style="color: #6b7280;"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="font-family: 'Outfit', sans-serif; font-weight: 600; color: #374151; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                                <i class="fas fa-lock me-1" style="color: #059669;"></i> New Password
                            </label>
                            <div class="input-group">
                                <input type="password"
                                       class="form-control"
                                       name="new_password"
                                       id="newPassword"
                                       placeholder="Enter new password"
                                       required
                                       minlength="4"
                                       maxlength="20"
                                       style="border-right: none;">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="newPassword"
                                        style="border: 1px solid #e5e7eb; border-left: none; background: #f9fafb; border-radius: 0 8px 8px 0;">
                                    <i class="fas fa-eye" style="color: #6b7280;"></i>
                                </button>
                            </div>
                            <!-- Strength indicator -->
                            <div class="mt-2" id="strengthBar" style="display: none;">
                                <div style="height: 4px; background: #e5e7eb; border-radius: 4px; overflow: hidden;">
                                    <div id="strengthFill" style="height: 100%; width: 0%; transition: all 0.3s ease; border-radius: 4px;"></div>
                                </div>
                                <small id="strengthText" style="font-size: 12px; font-weight: 600; margin-top: 4px; display: block;"></small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="font-family: 'Outfit', sans-serif; font-weight: 600; color: #374151; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                                <i class="fas fa-check-double me-1" style="color: #059669;"></i> Confirm New Password
                            </label>
                            <div class="input-group">
                                <input type="password"
                                       class="form-control"
                                       name="confirm_password"
                                       id="confirmPassword"
                                       placeholder="Re-enter new password"
                                       required
                                       style="border-right: none;">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirmPassword"
                                        style="border: 1px solid #e5e7eb; border-left: none; background: #f9fafb; border-radius: 0 8px 8px 0;">
                                    <i class="fas fa-eye" style="color: #6b7280;"></i>
                                </button>
                            </div>
                            <small id="matchMsg" style="display: none; font-size: 12px; font-weight: 600; margin-top: 6px;"></small>
                        </div>

                        <button type="submit"
                                class="btn btn-success w-100 py-3 mt-2"
                                id="submitBtn"
                                style="font-size: 16px; letter-spacing: 0.5px;">
                            <i class="fas fa-shield-alt me-2"></i> Update Password
                        </button>

                        <div class="text-center mt-3">
                            <a href="admin-profile.php" style="color: #059669; font-weight: 600; text-decoration: none; font-family: 'Outfit', sans-serif;">
                                <i class="fas fa-arrow-left me-1"></i> Back to Profile
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
// Toggle password visibility
document.querySelectorAll('.toggle-password').forEach(btn => {
    btn.addEventListener('click', function () {
        const target = document.getElementById(this.dataset.target);
        const icon = this.querySelector('i');
        if (target.type === 'password') {
            target.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            target.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
});

// Password strength indicator
const newPwd = document.getElementById('newPassword');
const strengthBar = document.getElementById('strengthBar');
const strengthFill = document.getElementById('strengthFill');
const strengthText = document.getElementById('strengthText');

newPwd.addEventListener('input', function () {
    const val = this.value;
    strengthBar.style.display = val.length > 0 ? 'block' : 'none';

    let score = 0;
    if (val.length >= 4) score++;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
        { width: '20%', color: '#ef4444', text: 'Very Weak' },
        { width: '40%', color: '#f97316', text: 'Weak' },
        { width: '60%', color: '#eab308', text: 'Fair' },
        { width: '80%', color: '#22c55e', text: 'Strong' },
        { width: '100%', color: '#059669', text: 'Very Strong' }
    ];
    const level = levels[Math.min(score, 4)];
    strengthFill.style.width = level.width;
    strengthFill.style.background = level.color;
    strengthText.textContent = level.text;
    strengthText.style.color = level.color;

    checkMatch();
});

// Confirm password match
const confirmPwd = document.getElementById('confirmPassword');
const matchMsg = document.getElementById('matchMsg');

confirmPwd.addEventListener('input', checkMatch);

function checkMatch() {
    if (confirmPwd.value.length === 0) {
        matchMsg.style.display = 'none';
        return;
    }
    matchMsg.style.display = 'block';
    if (newPwd.value === confirmPwd.value) {
        matchMsg.textContent = '✓ Passwords match';
        matchMsg.style.color = '#059669';
    } else {
        matchMsg.textContent = '✗ Passwords do not match';
        matchMsg.style.color = '#ef4444';
    }
}

// Auto-dismiss alert after 5 seconds
const alert = document.querySelector('.alert');
if (alert) {
    setTimeout(() => {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    }, 5000);
}
</script>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>
