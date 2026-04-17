<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}
require_once("../db_config.php");

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Restrict Access to Active Members Only
$check_membership = $con->prepare("SELECT * FROM user_memberships WHERE user_id = ? AND end_date > NOW() AND status = 'Active'");
$check_membership->bind_param("i", $user_id);
$check_membership->execute();
$mbr_result = $check_membership->get_result();

if ($mbr_result->num_rows == 0) {
    $_SESSION['login_error'] = "This is a premium feature. Please upgrade your membership to access Priority Support.";
    header("Location: memberships.php");
    exit();
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_priority'])) {
    $subject = "[PRIORITY PRO] " . mysqli_real_escape_string($con, $_POST['subject']);
    $message = mysqli_real_escape_string($con, $_POST['message']);
    
    // Fetch user email
    $q_user = $con->prepare("SELECT email FROM register WHERE id = ?");
    $q_user->bind_param("i", $user_id);
    $q_user->execute();
    $u_email = $q_user->get_result()->fetch_assoc()['email'];

    $ins = $con->prepare("INSERT INTO contact_messages (name, email, subject, message, user_id) VALUES (?, ?, ?, ?, ?)");
    $ins->bind_param("ssssi", $user_name, $u_email, $subject, $message, $user_id);
    
    if ($ins->execute()) {
        $msg = "<div class='alert alert-success' style='border-radius:12px;'><i class='fa-solid fa-circle-check mr-2'></i> Your priority message has been sent to the elite coaches. Expect a response within 12 hours.</div>";
    } else {
        $msg = "<div class='alert alert-danger' style='border-radius:12px;'>Failed to send message.</div>";
    }
}

$title = "Priority Expert Help";
$css = "register-dashboard.css"; 
ob_start();
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container pb-5">
        
        <div class="row align-items-center mb-5">
            <div class="col-lg-8">
                <span class="badge badge-warning text-dark px-3 py-2 mb-2" style="border-radius: 8px;"><i class="fa-solid fa-crown mr-1"></i> Premium Feature</span>
                <h2 class="font-weight-bold m-0" style="color: var(--text-main); font-family: 'Outfit', sans-serif; font-size:36px;">Priority Expert Help</h2>
                <p class="text-muted m-0" style="font-size: 18px;">Skip the line. Speak directly with our master trainers and certified nutritionists.</p>
            </div>
            <div class="col-lg-4 text-lg-right mt-3 mt-lg-0">
                <div class="p-3" style="background: white; border-radius: 16px; display: inline-block; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; text-align: left;">
                    <div class="d-flex align-items-center">
                        <div class="mr-3" style="width: 40px; height: 40px; border-radius: 50%; background: #10b981; color: white; display:flex; align-items:center; justify-content:center;">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <h6 class="m-0 font-weight-bold">Guaranteed Response</h6>
                            <small class="text-muted">Under 12 Hours</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 20px; border: 1px solid #e2e8f0;">
                    <div class="card-body p-5">
                        <h4 class="font-weight-bold mb-4">Ask a Master Trainer</h4>
                        <?php echo $msg; ?>
                        <form method="post" action="">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-muted">Topic / Subject</label>
                                <select name="subject" class="form-control form-control-lg" style="border-radius: 12px; background: #f8fafc; border: 1px solid #e2e8f0;" required>
                                    <option value="">Select a topic...</option>
                                    <option value="Form Check">Exercise Form Review</option>
                                    <option value="Diet Adjustments">Diet & Macros Adjustments</option>
                                    <option value="Injury / Pain">Training around an injury</option>
                                    <option value="Plateau">Breaking a plateau</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-muted">Your Question</label>
                                <textarea name="message" class="form-control" rows="6" placeholder="Provide as much detail as possible. You can include links to videos of your form if necessary." style="border-radius: 12px; background: #f8fafc; border: 1px solid #e2e8f0;" required></textarea>
                            </div>
                            <button type="submit" name="submit_priority" class="btn btn-block py-3 font-weight-bold" style="background: linear-gradient(135deg, #059669, #10b981); color: white; border-radius: 12px; font-size: 16px; box-shadow: 0 8px 15px rgba(16,185,129,0.2);">
                                <i class="fa-solid fa-paper-plane mr-2"></i> Send Priority Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 20px; border: 1px solid #e2e8f0; background: linear-gradient(135deg, #0f172a, #1e293b); color: white;">
                    <div class="card-body p-5">
                        <h4 class="font-weight-bold mb-4">Meet Your Elite Team</h4>
                        
                        <div class="d-flex align-items-center mb-4">
                            <div class="mr-3" style="width: 60px; height: 60px; border-radius: 50%; overflow: hidden; background: white;">
                                <i class="fa-solid fa-user-doctor text-dark w-100 h-100 d-flex align-items-center justify-content-center" style="font-size: 24px;"></i>
                            </div>
                            <div>
                                <h6 class="m-0 font-weight-bold">Dr. Amanda Hayes</h6>
                                <small style="color: rgba(255,255,255,0.7);">Lead Nutritionist</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-4">
                            <div class="mr-3" style="width: 60px; height: 60px; border-radius: 50%; overflow: hidden; background: white;">
                                <i class="fa-solid fa-dumbbell text-dark w-100 h-100 d-flex align-items-center justify-content-center" style="font-size: 24px;"></i>
                            </div>
                            <div>
                                <h6 class="m-0 font-weight-bold">Coach Marcus</h6>
                                <small style="color: rgba(255,255,255,0.7);">Strength & Conditioning Master</small>
                            </div>
                        </div>

                        <div class="p-4 mt-5" style="background: rgba(255,255,255,0.05); border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);">
                            <h6 class="font-weight-bold mb-2"><i class="fa-solid fa-shield-halved text-success mr-2"></i> Private & Confidential</h6>
                            <p class="m-0" style="font-size: 13px; color: rgba(255,255,255,0.6);">All communication between you and our coaches is strictly confidential. Your health data is safe with us.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
