<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}
require_once("../db_config.php");

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? '';
$user_email = $_SESSION['user_email'] ?? '';

$msg = "";
if (isset($_SESSION['support_flash'])) {
    $msg = $_SESSION['support_flash'];
    unset($_SESSION['support_flash']);
}

// Fetch user's past tickets
$stmt = $con->prepare("SELECT id, subject, status, admin_reply, created_at FROM contact_messages WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$tickets = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$title = "Support";
$css = "register-dashboard.css"; 

ob_start();
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);">Customer Support</h2>
            <p class="text-muted">We're here to help you on your journey 24/7.</p>
        </div>

        <?php if (!empty($msg)): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4" style="border-radius: 12px;">
            <i class="fa-solid fa-circle-check mr-2"></i><?php echo htmlspecialchars($msg); ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif; ?>
        
        <div class="row g-4">
            <!-- Support Form -->
            <div class="col-lg-8 mb-4">
                <div class="stat-card p-5">
                    <h4 class="font-weight-bold mb-4"><i class="fa-solid fa-paper-plane mr-2 text-success"></i>Send us a Message</h4>
                    <form method="POST" action="support-process.php" id="supportForm">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Full Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user_name); ?>" required minlength="2" style="border-radius: 8px;">
                                <small class="text-danger d-none" id="nameErr">Name must be at least 2 characters.</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Email Address</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user_email); ?>" required style="border-radius: 8px;">
                                <small class="text-danger d-none" id="emailErr">Please enter a valid email.</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="How can we help?" required minlength="3" style="border-radius: 8px;">
                            <small class="text-danger d-none" id="subjectErr">Subject must be at least 3 characters.</small>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Message</label>
                            <textarea name="message" class="form-control" rows="5" placeholder="Write your message here..." required minlength="10" style="border-radius: 8px;"></textarea>
                            <small class="text-danger d-none" id="messageErr">Message must be at least 10 characters.</small>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg btn-block font-weight-bold mt-4" style="border-radius: 10px;">
                            <i class="fa-solid fa-paper-plane mr-2"></i>Submit Ticket
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="stat-card p-4 mb-4">
                    <h5 class="font-weight-bold mb-3"><i class="fa-solid fa-phone mr-2 text-success"></i> Call Support</h5>
                    <p class="text-muted mb-0">+91 98765 43210</p>
                    <small>Mon - Fri, 9AM - 6PM IST</small>
                </div>
                <div class="stat-card p-4 mb-4">
                    <h5 class="font-weight-bold mb-3"><i class="fa-solid fa-envelope mr-2 text-success"></i> Email Support</h5>
                    <p class="text-muted mb-0">support@healthdash.com</p>
                    <small>Available 24/7</small>
                </div>
            </div>
        </div>

        <!-- Previous Tickets -->
        <?php if (count($tickets) > 0): ?>
        <div class="mt-5">
            <h4 class="font-weight-bold mb-4"><i class="fa-solid fa-ticket mr-2 text-success"></i>My Tickets</h4>
            <div class="row">
                <?php foreach ($tickets as $ticket): ?>
                <div class="col-lg-6 mb-3">
                    <div class="stat-card p-4" style="border-left: 4px solid <?php echo $ticket['status'] === 'replied' ? '#10b981' : ($ticket['status'] === 'new' ? '#f59e0b' : '#3b82f6'); ?>;">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="font-weight-bold m-0"><?php echo htmlspecialchars($ticket['subject']); ?></h6>
                            <?php if ($ticket['status'] === 'replied'): ?>
                                <span class="badge badge-success p-1 px-2">Replied</span>
                            <?php elseif ($ticket['status'] === 'new'): ?>
                                <span class="badge badge-warning p-1 px-2">New</span>
                            <?php else: ?>
                                <span class="badge badge-primary p-1 px-2"><?php echo ucfirst($ticket['status']); ?></span>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted d-block mb-2"><?php echo date('M j, Y \a\t g:i A', strtotime($ticket['created_at'])); ?></small>
                        <?php if (!empty($ticket['admin_reply'])): ?>
                        <div style="background: rgba(16,185,129,0.06); border-radius: 10px; padding: 12px; margin-top: 8px; border: 1px solid rgba(16,185,129,0.15);">
                            <small class="font-weight-bold text-success d-block mb-1"><i class="fa-solid fa-reply mr-1"></i>Admin Reply:</small>
                            <p class="m-0" style="font-size: 14px;"><?php echo htmlspecialchars($ticket['admin_reply']); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<script>
document.getElementById('supportForm').addEventListener('submit', function(e) {
    var valid = true;
    var name = this.querySelector('[name="name"]');
    var email = this.querySelector('[name="email"]');
    var subject = this.querySelector('[name="subject"]');
    var message = this.querySelector('[name="message"]');

    document.querySelectorAll('.text-danger').forEach(function(el) { el.classList.add('d-none'); });

    if (name.value.trim().length < 2) {
        document.getElementById('nameErr').classList.remove('d-none');
        valid = false;
    }
    if (!email.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
        document.getElementById('emailErr').classList.remove('d-none');
        valid = false;
    }
    if (subject.value.trim().length < 3) {
        document.getElementById('subjectErr').classList.remove('d-none');
        valid = false;
    }
    if (message.value.trim().length < 10) {
        document.getElementById('messageErr').classList.remove('d-none');
        valid = false;
    }

    if (!valid) e.preventDefault();
});
</script>

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
