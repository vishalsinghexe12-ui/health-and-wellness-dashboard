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

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);">Support Tickets</h2>
            <p class="text-muted">View and reply to user support messages</p>
        </div>

        <!-- Header + Search -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="font-weight-bold">All Messages (<?php echo mysqli_num_rows($result); ?>)</h5>
            <input type="text" id="searchInput"
                   class="form-control" style="max-width: 250px; border-radius: 8px;"
                   placeholder="Search messages...">
        </div>

        <div class="row">

            <!-- LEFT SIDE - TABLE -->
            <div class="col-md-7" id="tableSection">
                <div class="card shadow-sm" style="border-radius: 12px; border: none;">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="messageTable">
                                <thead style="background: #f1f5f9;">
                                    <tr>
                                        <th style="padding: 15px;">#</th>
                                        <th>Name</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($result) > 0): ?>
                                        <?php $i = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td style="padding: 15px;"><?php echo $i++; ?></td>
                                            <td class="font-weight-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                            <td>
                                                <?php if ($row['status'] === 'new'): ?>
                                                    <span class="badge badge-warning p-1 px-2">New</span>
                                                <?php elseif ($row['status'] === 'replied'): ?>
                                                    <span class="badge badge-success p-1 px-2">Replied</span>
                                                <?php else: ?>
                                                    <span class="badge badge-primary p-1 px-2"><?php echo ucfirst($row['status']); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><small class="text-muted"><?php echo date('M j, g:i A', strtotime($row['created_at'])); ?></small></td>
                                            <td>
                                                <button class="btn btn-sm btn-success viewBtn"
                                                    data-id="<?php echo $row['id']; ?>"
                                                    data-name="<?php echo htmlspecialchars($row['name']); ?>"
                                                    data-email="<?php echo htmlspecialchars($row['email']); ?>"
                                                    data-subject="<?php echo htmlspecialchars($row['subject']); ?>"
                                                    data-message="<?php echo htmlspecialchars($row['message']); ?>"
                                                    data-status="<?php echo $row['status']; ?>"
                                                    data-reply="<?php echo htmlspecialchars($row['admin_reply'] ?? ''); ?>"
                                                    data-date="<?php echo date('M j, Y \a\t g:i A', strtotime($row['created_at'])); ?>"
                                                    style="border-radius: 6px;">
                                                    <i class="fa-solid fa-eye mr-1"></i>View
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fa-solid fa-inbox mb-3" style="font-size: 40px; opacity:0.4;"></i>
                                                <p class="m-0">No support tickets yet.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE - MESSAGE PANEL -->
            <div class="col-md-5 d-none" id="messagePanel">
                <div class="card shadow-sm" style="border-radius: 12px; border: none;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="font-weight-bold m-0">Ticket Details</h5>
                            <button class="btn btn-sm btn-outline-danger" id="closePanel" style="border-radius: 6px;"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        
                        <div class="mb-3" style="background: #f8fafc; border-radius: 10px; padding: 15px;">
                            <p class="m-0 mb-1"><strong>From:</strong> <span id="msgName"></span></p>
                            <p class="m-0 mb-1"><strong>Email:</strong> <span id="msgEmail" class="text-primary"></span></p>
                            <p class="m-0"><strong>Date:</strong> <span id="msgDate" class="text-muted"></span></p>
                        </div>

                        <h6 class="font-weight-bold" id="msgSubject"></h6>
                        <p id="msgContent" style="background: rgba(59,130,246,0.05); border-radius: 10px; padding: 15px; border-left: 3px solid #3b82f6;"></p>

                        <!-- Existing Reply -->
                        <div id="existingReply" class="d-none mb-3" style="background: rgba(16,185,129,0.06); border-radius: 10px; padding: 15px; border-left: 3px solid #10b981;">
                            <small class="font-weight-bold text-success d-block mb-1"><i class="fa-solid fa-reply mr-1"></i>Your Reply:</small>
                            <p class="m-0" id="existingReplyText"></p>
                        </div>

                        <hr>
                        
                        <!-- Reply Form -->
                        <form method="POST" action="messages.php" id="replyForm">
                            <input type="hidden" name="reply_to_id" id="replyToId">
                            <div class="form-group">
                                <label class="font-weight-bold">Reply to User</label>
                                <textarea class="form-control" name="admin_reply" rows="4" placeholder="Type your reply here..." required style="border-radius: 10px;"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success btn-block" style="border-radius: 8px;">
                                <i class="fa-solid fa-paper-plane mr-2"></i>Send Reply
                            </button>
                        </form>
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
        row.style.display = row.innerText.toLowerCase().includes(filter) ? "" : "none";
    });
});

/* VIEW BUTTON */
document.querySelectorAll(".viewBtn").forEach(function(btn) {
    btn.addEventListener("click", function () {
        document.getElementById("msgName").innerText = this.getAttribute("data-name");
        document.getElementById("msgEmail").innerText = this.getAttribute("data-email");
        document.getElementById("msgSubject").innerText = this.getAttribute("data-subject");
        document.getElementById("msgContent").innerText = this.getAttribute("data-message");
        document.getElementById("msgDate").innerText = this.getAttribute("data-date");
        document.getElementById("replyToId").value = this.getAttribute("data-id");

        var existingReply = this.getAttribute("data-reply");
        if (existingReply && existingReply.trim() !== '') {
            document.getElementById("existingReplyText").innerText = existingReply;
            document.getElementById("existingReply").classList.remove("d-none");
        } else {
            document.getElementById("existingReply").classList.add("d-none");
        }

        document.getElementById("messagePanel").classList.remove("d-none");
        document.getElementById("tableSection").className = "col-md-7";
    });
});

/* CLOSE PANEL */
document.getElementById("closePanel").addEventListener("click", function () {
    document.getElementById("messagePanel").classList.add("d-none");
    document.getElementById("tableSection").className = "col-md-7";
});
</script>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>