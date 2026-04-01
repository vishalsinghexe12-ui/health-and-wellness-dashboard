
<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

// Fetch stats
$total_users = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as c FROM register WHERE role = 'user'"))['c'];
$active_users = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as c FROM register WHERE role = 'user' AND status = 'Active'"))['c'];
$total_plans = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as c FROM plans"))['c'];
$total_messages = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as c FROM contact_messages"))['c'];
$new_messages = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as c FROM contact_messages WHERE status = 'new'"))['c'];
$total_purchases = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as c FROM user_purchases"))['c'];
$total_revenue = mysqli_fetch_assoc(mysqli_query($con, "SELECT COALESCE(SUM(price), 0) as c FROM user_purchases"))['c'];

// Recent users (last 5)
$recent_users = mysqli_query($con, "SELECT id, name, email, status, role FROM register WHERE role = 'user' ORDER BY id DESC LIMIT 5");

// Recent support tickets (last 5)
$recent_tickets = mysqli_query($con, "SELECT id, name, subject, status, created_at FROM contact_messages ORDER BY created_at DESC LIMIT 5");

// Recent purchases (last 5)
$recent_purchases = mysqli_query($con, "SELECT up.plan_name, up.price, up.purchase_date, r.name as user_name FROM user_purchases up LEFT JOIN register r ON up.user_id = r.id ORDER BY up.purchase_date DESC LIMIT 5");

$title = "Admin Dashboard";
$css = "admin.css";
ob_start();
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">
        <?php if (isset($_SESSION['login_success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                <i class="fa-solid fa-circle-check mr-2"></i> <?php echo $_SESSION['login_success']; unset($_SESSION['login_success']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Greeting -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="font-weight-bold m-0" style="color: var(--text-main);">Admin Dashboard</h2>
                <p class="text-muted m-0 mt-1">Overview of your platform's performance.</p>
            </div>
            <span class="text-muted"><?php echo date('l, F j, Y'); ?></span>
        </div>

        <!-- Stat Cards -->
        <div class="row mb-5">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card" style="border-left: 4px solid #10b981; border-radius: 14px;">
                    <div class="d-flex align-items-center">
                        <div style="width:50px; height:50px; border-radius:14px; background:rgba(16,185,129,0.1); display:flex; align-items:center; justify-content:center; margin-right:15px;">
                            <i class="fa-solid fa-users" style="font-size:22px; color:#10b981;"></i>
                        </div>
                        <div>
                            <p class="text-muted m-0" style="font-size:13px;">Total Users</p>
                            <h3 class="m-0 font-weight-bold"><?php echo $total_users; ?></h3>
                        </div>
                    </div>
                    <small class="text-success mt-2 d-block"><i class="fa-solid fa-circle-check mr-1"></i><?php echo $active_users; ?> active</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card" style="border-left: 4px solid #3b82f6; border-radius: 14px;">
                    <div class="d-flex align-items-center">
                        <div style="width:50px; height:50px; border-radius:14px; background:rgba(59,130,246,0.1); display:flex; align-items:center; justify-content:center; margin-right:15px;">
                            <i class="fa-solid fa-dumbbell" style="font-size:22px; color:#3b82f6;"></i>
                        </div>
                        <div>
                            <p class="text-muted m-0" style="font-size:13px;">Total Plans</p>
                            <h3 class="m-0 font-weight-bold"><?php echo $total_plans; ?></h3>
                        </div>
                    </div>
                    <a href="plans.php" class="text-primary mt-2 d-block" style="font-size:13px;">Manage plans →</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card" style="border-left: 4px solid #f59e0b; border-radius: 14px;">
                    <div class="d-flex align-items-center">
                        <div style="width:50px; height:50px; border-radius:14px; background:rgba(245,158,11,0.1); display:flex; align-items:center; justify-content:center; margin-right:15px;">
                            <i class="fa-solid fa-envelope" style="font-size:22px; color:#f59e0b;"></i>
                        </div>
                        <div>
                            <p class="text-muted m-0" style="font-size:13px;">Support Tickets</p>
                            <h3 class="m-0 font-weight-bold"><?php echo $total_messages; ?></h3>
                        </div>
                    </div>
                    <?php if ($new_messages > 0): ?>
                        <small class="text-warning mt-2 d-block"><i class="fa-solid fa-bell mr-1"></i><?php echo $new_messages; ?> new</small>
                    <?php else: ?>
                        <small class="text-success mt-2 d-block"><i class="fa-solid fa-check mr-1"></i>All replied</small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card" style="border-left: 4px solid #8b5cf6; border-radius: 14px;">
                    <div class="d-flex align-items-center">
                        <div style="width:50px; height:50px; border-radius:14px; background:rgba(139,92,246,0.1); display:flex; align-items:center; justify-content:center; margin-right:15px;">
                            <i class="fa-solid fa-cart-shopping" style="font-size:22px; color:#8b5cf6;"></i>
                        </div>
                        <div>
                            <p class="text-muted m-0" style="font-size:13px;">Total Purchases</p>
                            <h3 class="m-0 font-weight-bold"><?php echo $total_purchases; ?></h3>
                        </div>
                    </div>
                    <small class="text-muted mt-2 d-block">₹<?php echo number_format($total_revenue); ?> revenue</small>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Recent Users -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm" style="border: none; border-radius: 14px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="font-weight-bold m-0"><i class="fa-solid fa-user-group mr-2 text-success"></i>Recent Users</h5>
                            <a href="users.php" class="btn btn-outline-success btn-sm" style="border-radius: 8px;">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background: #f8fafc;">
                                    <tr><th>Name</th><th>Email</th><th>Status</th></tr>
                                </thead>
                                <tbody>
                                    <?php while ($u = mysqli_fetch_assoc($recent_users)): ?>
                                    <tr>
                                        <td class="font-weight-bold"><?php echo htmlspecialchars($u['name']); ?></td>
                                        <td class="text-muted"><?php echo htmlspecialchars($u['email']); ?></td>
                                        <td>
                                            <?php if ($u['status'] === 'Active'): ?>
                                                <span class="badge badge-success p-1 px-2">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary p-1 px-2"><?php echo htmlspecialchars($u['status']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Tickets -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm" style="border: none; border-radius: 14px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="font-weight-bold m-0"><i class="fa-solid fa-ticket mr-2 text-warning"></i>Recent Tickets</h5>
                            <a href="messages.php" class="btn btn-outline-success btn-sm" style="border-radius: 8px;">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background: #f8fafc;">
                                    <tr><th>User</th><th>Subject</th><th>Status</th><th>Date</th></tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($recent_tickets) > 0): ?>
                                        <?php while ($t = mysqli_fetch_assoc($recent_tickets)): ?>
                                        <tr>
                                            <td class="font-weight-bold"><?php echo htmlspecialchars($t['name']); ?></td>
                                            <td><?php echo htmlspecialchars($t['subject']); ?></td>
                                            <td>
                                                <?php if ($t['status'] === 'new'): ?>
                                                    <span class="badge badge-warning p-1 px-2">New</span>
                                                <?php elseif ($t['status'] === 'replied'): ?>
                                                    <span class="badge badge-success p-1 px-2">Replied</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><small class="text-muted"><?php echo date('M j', strtotime($t['created_at'])); ?></small></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr><td colspan="4" class="text-center text-muted py-4">No tickets yet.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Purchases -->
        <div class="card shadow-sm mb-4" style="border: none; border-radius: 14px;">
            <div class="card-body">
                <h5 class="font-weight-bold mb-3"><i class="fa-solid fa-bag-shopping mr-2 text-primary"></i>Recent Purchases</h5>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #f8fafc;">
                            <tr><th>User</th><th>Plan</th><th>Price</th><th>Date</th></tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($recent_purchases) > 0): ?>
                                <?php while ($p = mysqli_fetch_assoc($recent_purchases)): ?>
                                <tr>
                                    <td class="font-weight-bold"><?php echo htmlspecialchars($p['user_name'] ?? 'Unknown'); ?></td>
                                    <td><?php echo htmlspecialchars($p['plan_name']); ?></td>
                                    <td class="font-weight-bold" style="color: var(--primary-dark);">₹<?php echo number_format($p['price']); ?></td>
                                    <td><small class="text-muted"><?php echo date('M j, Y g:i A', strtotime($p['purchase_date'])); ?></small></td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center text-muted py-4">No purchases yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-md-3 mb-3">
                <a href="users.php" class="d-block text-decoration-none">
                    <div class="stat-card text-center" style="border-radius: 14px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fa-solid fa-users mb-2" style="font-size:30px; color:#10b981;"></i>
                        <h6 class="font-weight-bold text-dark">Manage Users</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="plans.php" class="d-block text-decoration-none">
                    <div class="stat-card text-center" style="border-radius: 14px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fa-solid fa-clipboard-list mb-2" style="font-size:30px; color:#3b82f6;"></i>
                        <h6 class="font-weight-bold text-dark">Manage Plans</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="messages.php" class="d-block text-decoration-none">
                    <div class="stat-card text-center" style="border-radius: 14px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fa-solid fa-envelope mb-2" style="font-size:30px; color:#f59e0b;"></i>
                        <h6 class="font-weight-bold text-dark">Support Tickets</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="add-plans.php" class="d-block text-decoration-none">
                    <div class="stat-card text-center" style="border-radius: 14px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fa-solid fa-plus-circle mb-2" style="font-size:30px; color:#8b5cf6;"></i>
                        <h6 class="font-weight-bold text-dark">Add New Plan</h6>
                    </div>
                </a>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>