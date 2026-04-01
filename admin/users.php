<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

// Handle user status toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_user_id'])) {
    $toggle_id = (int)$_POST['toggle_user_id'];
    $new_status = $_POST['new_status'];
    $stmt = $con->prepare("UPDATE register SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $toggle_id);
    $stmt->execute();
    header("Location: users.php");
    exit();
}

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $del_id = (int)$_POST['delete_user_id'];
    $stmt = $con->prepare("DELETE FROM register WHERE id = ? AND role = 'user'");
    $stmt->bind_param("i", $del_id);
    $stmt->execute();
    header("Location: users.php");
    exit();
}

// Fetch all users (excluding admins)
$users = mysqli_query($con, "SELECT id, name, email, mobile, gender, status, profile_picture FROM register WHERE role = 'user' ORDER BY id DESC");
$total = mysqli_num_rows($users);

// Stats
$active_count = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as c FROM register WHERE role='user' AND status='Active'"))['c'];
$inactive_count = $total - $active_count;

$title = "Users - Admin";
$css = "admin.css";
ob_start();
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">

        <div class="text-center mb-4">
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);">Manage Users</h2>
            <p class="text-muted">View and manage all registered users</p>
        </div>

        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stat-card text-center" style="border-radius: 14px; border-top: 4px solid #10b981;">
                    <h3 class="font-weight-bold m-0" style="color:#10b981;"><?php echo $total; ?></h3>
                    <p class="text-muted m-0">Total Users</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-card text-center" style="border-radius: 14px; border-top: 4px solid #3b82f6;">
                    <h3 class="font-weight-bold m-0" style="color:#3b82f6;"><?php echo $active_count; ?></h3>
                    <p class="text-muted m-0">Active Users</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-card text-center" style="border-radius: 14px; border-top: 4px solid #f59e0b;">
                    <h3 class="font-weight-bold m-0" style="color:#f59e0b;"><?php echo $inactive_count; ?></h3>
                    <p class="text-muted m-0">Inactive Users</p>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="font-weight-bold m-0">All Users</h5>
            <input type="text" id="searchInput" class="form-control" style="max-width: 250px; border-radius: 8px;" placeholder="Search users...">
        </div>

        <!-- Users Table -->
        <div class="card shadow-sm" style="border: none; border-radius: 14px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="usersTable">
                        <thead style="background: #f1f5f9;">
                            <tr>
                                <th style="padding: 15px;">ID</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($total > 0): ?>
                                <?php while ($u = mysqli_fetch_assoc($users)): ?>
                                <tr>
                                    <td style="padding: 15px;"><?php echo $u['id']; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($u['profile_picture'])): ?>
                                                <img src="../<?php echo htmlspecialchars($u['profile_picture']); ?>" style="width:35px; height:35px; border-radius:50%; object-fit:cover; margin-right:10px;">
                                            <?php else: ?>
                                                <div style="width:35px; height:35px; border-radius:50%; background:rgba(16,185,129,0.1); display:flex; align-items:center; justify-content:center; margin-right:10px; color:#10b981; font-weight:700;">
                                                    <?php echo strtoupper(substr($u['name'], 0, 1)); ?>
                                                </div>
                                            <?php endif; ?>
                                            <strong><?php echo htmlspecialchars($u['name']); ?></strong>
                                        </div>
                                    </td>
                                    <td class="text-muted"><?php echo htmlspecialchars($u['email']); ?></td>
                                    <td><?php echo htmlspecialchars($u['mobile'] ?? '—'); ?></td>
                                    <td><?php echo htmlspecialchars($u['gender'] ?? '—'); ?></td>
                                    <td>
                                        <?php if ($u['status'] === 'Active'): ?>
                                            <span class="badge badge-success p-1 px-2">Active</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary p-1 px-2"><?php echo htmlspecialchars($u['status']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <!-- Toggle Status -->
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="toggle_user_id" value="<?php echo $u['id']; ?>">
                                            <?php if ($u['status'] === 'Active'): ?>
                                                <input type="hidden" name="new_status" value="Inactive">
                                                <button type="submit" class="btn btn-sm btn-outline-warning" style="border-radius:6px;" title="Deactivate">
                                                    <i class="fa-solid fa-ban"></i>
                                                </button>
                                            <?php else: ?>
                                                <input type="hidden" name="new_status" value="Active">
                                                <button type="submit" class="btn btn-sm btn-outline-success" style="border-radius:6px;" title="Activate">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            <?php endif; ?>
                                        </form>
                                        <!-- Delete -->
                                        <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            <input type="hidden" name="delete_user_id" value="<?php echo $u['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:6px;" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-users mb-3" style="font-size: 40px; opacity:0.4;"></i>
                                        <p class="m-0">No registered users yet.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.getElementById("searchInput").addEventListener("keyup", function () {
    var filter = this.value.toLowerCase();
    var rows = document.querySelectorAll("#usersTable tbody tr");
    rows.forEach(function(row) {
        row.style.display = row.innerText.toLowerCase().includes(filter) ? "" : "none";
    });
});
</script>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>