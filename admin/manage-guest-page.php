<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
$title = "Manage Guest Page";
$css = "admin.css"; 
ob_start();

require_once("../db_config.php");
$query = "SELECT * FROM guest_content ORDER BY section, sort_order ASC";
$result = mysqli_query($con, $query);

$sections = [];
while($row = mysqli_fetch_assoc($result)) {
    $sections[$row['section']][] = $row;
}
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="font-weight-bold m-0" style="color: var(--text-main);">Manage Guest Page</h2>
                <p class="text-muted m-0 mt-1">Control the content shown to logged-out users on the home page.</p>
            </div>
            <a href="edit-guest-section.php" class="btn btn-success px-4 py-2" style="border-radius: 10px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                <i class="fa-solid fa-plus mr-2"></i>Add New Section
            </a>
        </div>

        <?php if (isset($_SESSION['guest_success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                <i class="fa-solid fa-circle-check mr-2"></i> <?php echo $_SESSION['guest_success']; unset($_SESSION['guest_success']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['guest_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                <i class="fa-solid fa-circle-exclamation mr-2"></i> <?php echo $_SESSION['guest_error']; unset($_SESSION['guest_error']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Banner Section -->
        <h4 class="font-weight-bold mb-3 border-bottom pb-2">Top Banner</h4>
        <div class="row mb-5">
            <?php 
            if(!empty($sections['banner'])): 
                foreach($sections['banner'] as $row): 
            ?>
            <div class="col-md-12 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #3b82f6 !important;">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge badge-primary mb-2">Banner</span>
                            <h5 class="font-weight-bold mb-1"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="text-muted small mb-0"><?php echo htmlspecialchars($row['subtitle']); ?></p>
                        </div>
                        <div class="d-flex" style="gap:10px;">
                            <a href="edit-guest-section.php?id=<?php echo $row['id']; ?>" class="btn btn-light"><i class="fa-solid fa-pen-to-square text-primary"></i> Edit</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            else: 
            ?>
            <div class="col-12 text-muted">No banner found.</div>
            <?php endif; ?>
        </div>

        <!-- Tip Cards Section -->
        <h4 class="font-weight-bold mb-3 border-bottom pb-2">Health Tips (Cards)</h4>
        <div class="row">
            <?php 
            if(!empty($sections['tip_card'])): 
                foreach($sections['tip_card'] as $row): 
            ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-top: 4px solid #10b981 !important; position:relative;">
                    <?php if($row['is_active'] == 0): ?>
                        <div style="position:absolute; top:10px; right:10px; background:#ef4444; color:white; font-size:11px; padding:3px 8px; border-radius:6px; font-weight:700; z-index:2;">INACTIVE</div>
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                            <i class="fa-solid fa-file-lines text-success mr-2" style="font-size:24px;"></i>
                            <div>
                                <h6 class="font-weight-bold mb-0"><?php echo htmlspecialchars($row['title']); ?></h6>
                                <small class="text-muted">Order: <?php echo $row['sort_order']; ?></small>
                            </div>
                        </div>
                        <p class="text-muted small mb-3 flex-grow-1" style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                            <?php echo htmlspecialchars($row['subtitle']); ?>
                        </p>
                        <div class="d-flex" style="gap:10px;">
                            <a href="edit-guest-section.php?id=<?php echo $row['id']; ?>" class="btn btn-light btn-sm flex-grow-1 font-weight-bold"><i class="fa-solid fa-pen text-success mr-1"></i> Edit</a>
                            <form action="delete-guest-section-process.php" method="POST" class="flex-grow-1" onsubmit="return confirm('Are you sure you want to permanently delete this card?');">
                                <input type="hidden" name="section_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-light btn-sm w-100 font-weight-bold"><i class="fa-solid fa-trash text-danger mr-1"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                endforeach; 
            else: 
            ?>
            <div class="col-12 text-muted">No tip cards found.</div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>
