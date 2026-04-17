<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

$is_edit = false;
$id = isset($_GET['edit_id']) ? (int)$_GET['edit_id'] : 0;

$mem = [
    'title'       => '',
    'description' => '',
    'price'       => '',
    'duration'    => '1 Month',
    'status'      => 'Active',
    'features'    => ''
];

if($id > 0) {
    $res = mysqli_query($con, "SELECT * FROM memberships WHERE id = $id");
    if($r = mysqli_fetch_assoc($res)) {
        $mem = $r;
        $is_edit = true;
    }
}

$title = $is_edit ? "Edit Membership" : "Add Membership";
$css = "admin.css";
ob_start();
?>
<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="d-flex align-items-center mb-4">
                    <a href="manage-memberships.php" class="btn btn-link text-dark p-0 mr-3" style="font-size: 24px;">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div>
                        <h2 class="font-weight-bold m-0" style="color: var(--text-main);"><?php echo $title; ?></h2>
                        <p class="text-muted m-0">Define tier pricing and premium features.</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                    <form action="add-membership-process.php" method="POST">
                        <input type="hidden" name="mem_id" value="<?php echo $id; ?>">
                        
                        <div class="card-body p-4 p-md-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold">Membership Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="e.g. Pro Access" value="<?php echo htmlspecialchars($mem['title']); ?>" required style="border-radius: 10px; padding: 22px 15px;">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold">Price (₹)</label>
                                        <input type="number" name="price" class="form-control" placeholder="e.g. 500" value="<?php echo htmlspecialchars($mem['price']); ?>" required style="border-radius: 10px; padding: 22px 15px;">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold">Duration</label>
                                        <select name="duration" class="form-control" style="border-radius: 10px; padding: 12px 15px; height: auto;">
                                            <option value="1 Week" <?php echo $mem['duration']=='1 Week'?'selected':'';?>>1 Week</option>
                                            <option value="1 Month" <?php echo $mem['duration']=='1 Month'?'selected':'';?>>1 Month</option>
                                            <option value="3 Months" <?php echo $mem['duration']=='3 Months'?'selected':'';?>>3 Months</option>
                                            <option value="6 Months" <?php echo $mem['duration']=='6 Months'?'selected':'';?>>6 Months</option>
                                            <option value="1 Year" <?php echo $mem['duration']=='1 Year'?'selected':'';?>>1 Year</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold">Short Description</label>
                                        <textarea name="description" class="form-control" rows="2" placeholder="Brief summary of this tier" style="border-radius: 10px; padding: 15px;"><?php echo htmlspecialchars($mem['description']); ?></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold">Included Features <small class="text-muted">(Comma separated)</small></label>
                                        <textarea name="features" class="form-control" rows="4" placeholder="e.g. Private Community Access, Surprise Rewards System, Downloadable Resources" style="border-radius: 10px; padding: 15px;"><?php echo htmlspecialchars($mem['features']); ?></textarea>
                                        <small class="text-info mt-1 d-block"><i class="fa-solid fa-circle-info mr-1"></i> These must match gated page names to clearly communicate access.</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold">Status</label>
                                        <select name="status" class="form-control" style="border-radius: 10px; padding: 12px 15px; height: auto;">
                                            <option value="Active" <?php echo $mem['status']=='Active'?'selected':'';?>>Active (Visible)</option>
                                            <option value="Inactive" <?php echo $mem['status']=='Inactive'?'selected':'';?>>Inactive (Hidden)</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer bg-white p-4 d-flex justify-content-end border-0" style="gap: 15px;">
                            <a href="manage-memberships.php" class="btn btn-light px-4" style="border-radius: 10px; font-weight: 600;">Cancel</a>
                            <button type="submit" class="btn btn-success px-4" style="border-radius: 10px; font-weight: 600;">Save Membership</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>
