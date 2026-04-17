<?php
session_start();
require_once("db_config.php");

$token = $_GET['token'] ?? '';

if (empty($token)) {
    $_SESSION['auth_flash'] = "Invalid activation link.";
    header("Location: register.php");
    exit();
}

$token_escaped = mysqli_real_escape_string($con, $token);

// Find user with matching token that hasn't expired
$res = mysqli_query($con, "SELECT id, name, email FROM register WHERE token = '$token_escaped' AND status = 'Inactive' AND token_expires > NOW() LIMIT 1");

if (!$res || mysqli_num_rows($res) === 0) {
    // Token invalid or expired
    $title = "Link Expired - Health & Wellness";
    $css   = "guest.css";
    ob_start();
    ?>
    <div style="min-height:calc(100vh - 130px); display:flex; align-items:center; justify-content:center; padding:40px 15px;">
        <div style="max-width:480px; width:100%; text-align:center;">
            <div class="card border-0 shadow-lg" style="border-radius:24px; overflow:hidden; padding:50px 40px;">
                <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#ef4444,#dc2626);display:flex;align-items:center;justify-content:center;margin:0 auto 24px; box-shadow:0 8px 24px rgba(239,68,68,0.3);">
                    <i class="fa-solid fa-link-slash" style="font-size:36px; color:white;"></i>
                </div>
                <h3 class="font-weight-bold mb-3" style="color:#dc2626; font-family:'Outfit',sans-serif;">Link Expired or Invalid</h3>
                <p class="text-muted mb-4">This activation link has expired or already been used. Please register again or request a new link.</p>
                <a href="register.php" class="btn btn-success btn-block" style="border-radius:10px; font-weight:600; padding:12px;">Register Again</a>
            </div>
        </div>
    </div>
    <?php
    $content = ob_get_clean();
    include("includes/layout.php");
    exit();
}

$user = mysqli_fetch_assoc($res);

// Activate the account
mysqli_query($con, "UPDATE register SET status='Active', token=NULL, token_expires=NULL WHERE id='{$user['id']}'");

// Clean up session
unset($_SESSION['pending_email'], $_SESSION['pending_firstName']);

$_SESSION['auth_flash'] = "🎉 Email verified! Your account has been activated. You can now log in.";
header("Location: login.php?msg=verified");
exit();
?>
