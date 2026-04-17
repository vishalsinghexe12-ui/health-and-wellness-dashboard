<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
$title = "Manage Memberships";
$css = "admin.css"; 
ob_start();

require_once("../db_config.php");
$query = "SELECT * FROM memberships ORDER BY price ASC";
$result = mysqli_query($con, $query);
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="font-weight-bold m-0" style="color: var(--text-main);">Manage Memberships</h2>
                <p class="text-muted m-0 mt-1">Create and manage premium subscription tiers.</p>
            </div>
            <a href="add-membership.php" class="btn btn-success px-4 py-2" style="border-radius: 10px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                <i class="fa-solid fa-plus mr-2"></i>Add Membership
            </a>
        </div>

        <?php if (isset($_SESSION['mem_success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" style="border-radius:12px;">
                <i class="fa-solid fa-circle-check mr-2"></i> <?php echo $_SESSION['mem_success']; unset($_SESSION['mem_success']); ?>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php 
            if(mysqli_num_rows($result) > 0):
                while($row = mysqli_fetch_assoc($result)): 
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden; position:relative;">
                    <div style="background: linear-gradient(135deg, #1f2937, #111827); padding:25px; color:white; text-align:center;">
                        <?php if($row['status'] == 'Inactive'): ?>
                            <div style="position:absolute; top:10px; right:10px; background:#ef4444; color:white; font-size:11px; padding:3px 8px; border-radius:6px; font-weight:700;">INACTIVE</div>
                        <?php endif; ?>
                        <h4 class="font-weight-bold mb-1" style="font-family:'Outfit', sans-serif;"><?php echo htmlspecialchars($row['title']); ?></h4>
                        <div style="font-size:32px; font-weight:800; color:#10b981;">₹<?php echo number_format($row['price']); ?><span style="font-size:14px; font-weight:400; color:#9ca3af;">/<?php echo $row['duration']; ?></span></div>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <p class="text-muted small mb-3 flex-grow-1"><?php echo htmlspecialchars($row['description']); ?></p>
                        
                        <div class="mb-4">
                            <strong class="small text-dark mb-2 d-block">Features Included:</strong>
                            <ul class="list-unstyled mb-0 m-0" style="font-size:13px; color:#4b5563;">
                                <?php 
                                $features = explode(',', $row['features']);
                                foreach($features as $f): 
                                    if(trim($f)):
                                ?>
                                    <li class="mb-1"><i class="fa-solid fa-check text-success mr-2"></i><?php echo htmlspecialchars(trim($f)); ?></li>
                                <?php endif; endforeach; ?>
                            </ul>
                        </div>

                        <div class="d-flex" style="gap:10px;">
                            <a href="add-membership.php?edit_id=<?php echo $row['id']; ?>" class="btn btn-light btn-sm flex-grow-1 font-weight-bold" style="border-radius:8px;">
                                <i class="fa-solid fa-pen text-success mr-1"></i> Edit
                            </a>
                            <a href="delete-membership-process.php?id=<?php echo $row['id']; ?>" class="btn btn-light btn-sm flex-grow-1 font-weight-bold" style="border-radius:8px;" onclick="return confirm('Are you sure you want to delete this membership plan? Active users will lose access.');">
                                <i class="fa-solid fa-trash text-danger mr-1"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                endwhile;
            else:
            ?>
            <div class="col-12 text-center text-muted py-5">
                <i class="fa-solid fa-crown fa-3x mb-3" style="opacity:0.2;"></i>
                <h5>No Membership Plans Found</h5>
                <p>Click "Add Membership" to create your first tier.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>
