<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

// Handle reply submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_to_id'])) {
    $ticket_id = (int)$_POST['reply_to_id'];
    $reply = trim($_POST['admin_reply'] ?? '');

    if (!empty($reply) && $ticket_id > 0) {
        $stmt = $con->prepare("UPDATE contact_messages SET admin_reply = ?, status = 'replied', replied_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $reply, $ticket_id);
        $stmt->execute();
    }
    header("Location: messages.php");
    exit();
}

// Fetch all messages
$result = mysqli_query($con, "SELECT * FROM contact_messages ORDER BY created_at DESC");

$title = "Messages - Admin";
$css = "admin.css";
ob_start();
?>

<div class="py-5" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); min-height: calc(100vh - 70px);">
    <div class="container-fluid px-4">

        <div class="mb-5 text-center">
            <h2 class="font-weight-bold mb-2" style="font-size: 32px; color: #1e293b; letter-spacing: -0.5px;">Support Tickets</h2>
            <p class="text-muted" style="font-size: 16px;">Manage user concerns and provide real-time assistance.</p>
        </div>

        <div class="row">
            <!-- LEFT SIDE - LIST -->
            <div class="col-lg-7 mb-4" id="tableSection">
                <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px);">
                    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="font-weight-bold m-0" style="color: #334155;">Active Threads <span class="badge badge-soft-success ml-2" style="background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 20px; padding: 5px 12px; font-size: 12px;"><?php echo mysqli_num_rows($result); ?> total</span></h5>
                        <div class="position-relative">
                            <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left: 15px; top: 12px;"></i>
                            <input type="text" id="searchInput" class="form-control pl-5" style="border-radius: 30px; background: #f8fafc; border: 1px solid #e2e8f0; font-size: 14px; width: 250px;" placeholder="Search support lines...">
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="messageTable" style="border-collapse: separate; border-spacing: 0;">
                                <thead style="background: #f8fafc; color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">
                                    <tr>
                                        <th class="border-0 py-3 px-4">User</th>
                                        <th class="border-0 py-3">Subject</th>
                                        <th class="border-0 py-3">Status</th>
                                        <th class="border-0 py-3 text-right px-4">Received</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($result) > 0): ?>
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr class="viewBtn cursor-pointer" 
                                            data-id="<?php echo $row['id']; ?>"
                                            data-name="<?php echo htmlspecialchars($row['name']); ?>"
                                            data-email="<?php echo htmlspecialchars($row['email']); ?>"
                                            data-subject="<?php echo htmlspecialchars($row['subject']); ?>"
                                            data-message="<?php echo htmlspecialchars($row['message']); ?>"
                                            data-status="<?php echo $row['status']; ?>"
                                            data-reply="<?php echo htmlspecialchars($row['admin_reply'] ?? ''); ?>"
                                            data-date="<?php echo date('M j, Y \a\t g:i A', strtotime($row['created_at'])); ?>"
                                            style="cursor: pointer; transition: all 0.2s;">
                                            <td class="py-3 px-4 border-top-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm mr-3" style="width: 35px; height: 35px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #475569; font-size: 13px;">
                                                        <?php echo strtoupper(substr($row['name'], 0, 1)); ?>
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold" style="color: #1e293b; font-size: 14px;"><?php echo htmlspecialchars($row['name']); ?></div>
                                                        <div class="text-muted" style="font-size: 12px;"><?php echo htmlspecialchars($row['email']); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3 border-top-0">
                                                <div class="text-truncate" style="max-width: 200px; color: #475569; font-size: 14px;"><?php echo htmlspecialchars($row['subject']); ?></div>
                                            </td>
                                            <td class="py-3 border-top-0">
                                                <?php if ($row['status'] === 'new'): ?>
                                                    <span style="background: rgba(245, 158, 11, 0.1); color: #d97706; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700;">NEW</span>
                                                <?php else: ?>
                                                    <span style="background: rgba(16, 185, 129, 0.1); color: #059669; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700;">REPLIED</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-3 text-right px-4 border-top-0">
                                                <span class="text-muted" style="font-size: 12px;"><?php echo date('M j', strtotime($row['created_at'])); ?></span>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="py-4">
                                                    <i class="fa-solid fa-inbox mb-3" style="font-size: 48px; color: #cbd5e1;"></i>
                                                    <h6 class="text-muted">No support tickets at the moment</h6>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE - CONVERSATION -->
            <div class="col-lg-5 d-none mb-4" id="messagePanel">
                <div class="card border-0 shadow-lg h-100" style="border-radius: 20px; background: #ffffff;">
                    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="font-weight-bold m-0" style="color: #334155;">Ticket Details</h5>
                        <button class="btn btn-sm btn-light border-0" id="closePanel" style="border-radius: 50%; width: 32px; height: 32px;"><i class="fa-solid fa-xmark text-muted"></i></button>
                    </div>
                    
                    <div class="card-body px-4 pt-0">
                        <div class="p-4 mb-4" style="background: #f8fafc; border-radius: 16px;">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="font-weight-bold mb-1" id="msgSubjectDetail" style="color: #1e293b; font-size: 18px;"></h6>
                                    <div class="d-flex align-items-center">
                                        <span class="text-muted small" id="msgDateDetail"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="message-content p-3 mb-2" id="msgContentDetail" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 14px; line-height: 1.6; color: #334155;">
                            </div>
                            <div class="small text-muted">From: <strong id="msgNameDetail"></strong> (<span id="msgEmailDetail"></span>)</div>
                        </div>

                        <div id="existingReplySection" class="d-none">
                            <div class="ml-4 p-4 mb-4" style="background: rgba(16, 185, 129, 0.04); border-left: 4px solid #10b981; border-radius: 0 16px 16px 0;">
                                <div class="font-weight-bold text-success small mb-2 text-uppercase"><i class="fa-solid fa-reply mr-1"></i> Admin Response</div>
                                <p class="m-0" id="existingReplyTextDetail" style="font-size: 14px; color: #064e3b;"></p>
                            </div>
                        </div>

                        <!-- Reply Form -->
                        <div id="replyFormContainer">
                            <form method="POST" action="messages.php">
                                <input type="hidden" name="reply_to_id" id="replyToIdDetail">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold small text-uppercase text-muted" style="letter-spacing: 1px;">Quick Response</label>
                                    <textarea class="form-control border-0" name="admin_reply" rows="5" placeholder="Write your answer here..." required style="background: #f1f5f9; border-radius: 16px; padding: 15px; font-size: 14px; resize: none;"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg btn-block shadow-sm" style="border-radius: 12px; font-weight: 600; background: linear-gradient(135deg, #10b981, #059669); border: none;">
                                    <i class="fa-solid fa-paper-plane mr-2"></i>Send Response
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
/* SEARCH */
document.getElementById("searchInput").addEventListener("keyup", function () {
    var filter = this.value.toLowerCase();
    var rows = document.querySelectorAll("#messageTable tbody tr");
    rows.forEach(function(row) {
        if (!row.classList.contains('viewBtn')) return;
        row.style.display = row.innerText.toLowerCase().includes(filter) ? "" : "none";
    });
});

/* VIEW BUTTON */
document.querySelectorAll(".viewBtn").forEach(function(btn) {
    btn.addEventListener("click", function () {
        // Highlight active row
        document.querySelectorAll(".viewBtn").forEach(r => r.style.background = "transparent");
        this.style.background = "rgba(59, 130, 246, 0.05)";

        // Set Details
        document.getElementById("msgNameDetail").innerText = this.getAttribute("data-name");
        document.getElementById("msgEmailDetail").innerText = this.getAttribute("data-email");
        document.getElementById("msgSubjectDetail").innerText = this.getAttribute("data-subject");
        document.getElementById("msgContentDetail").innerText = this.getAttribute("data-message");
        document.getElementById("msgDateDetail").innerText = this.getAttribute("data-date");
        document.getElementById("replyToIdDetail").value = this.getAttribute("data-id");

        var existingReply = this.getAttribute("data-reply");
        if (existingReply && existingReply.trim() !== '') {
            document.getElementById("existingReplyTextDetail").innerText = existingReply;
            document.getElementById("existingReplySection").classList.remove("d-none");
            document.getElementById("replyFormContainer").classList.add("d-none");
        } else {
            document.getElementById("existingReplySection").classList.add("d-none");
            document.getElementById("replyFormContainer").classList.remove("d-none");
        }

        document.getElementById("messagePanel").classList.remove("d-none");
        document.getElementById("tableSection").className = "col-lg-7";
    });
});

/* CLOSE PANEL */
document.getElementById("closePanel").addEventListener("click", function () {
    document.getElementById("messagePanel").classList.add("d-none");
    document.getElementById("tableSection").className = "col-lg-12";
    document.querySelectorAll(".viewBtn").forEach(r => r.style.background = "transparent");
});
</script>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>