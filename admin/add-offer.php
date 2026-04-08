<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

$edit_mode = false;
$offer = [
    'id' => '',
    'title' => '',
    'description' => '',
    'discount_percentage' => '',
    'valid_until' => '',
    'status' => 'Active',
    'image_path' => ''
];

if (isset($_GET['edit_id'])) {
    $edit_mode = true;
    $edit_id = mysqli_real_escape_with_entities($con, $_GET['edit_id']);
    $res = mysqli_query($con, "SELECT * FROM offers_discounts WHERE id = '$edit_id'");
    if ($row = mysqli_fetch_assoc($res)) {
        $offer = $row;
    }
}

// Function to safely escape string (redundant but safe)
function mysqli_real_escape_with_entities($con, $str) {
    return mysqli_real_escape_string($con, $str);
}

$title = $edit_mode ? "Edit Offer" : "Add New Offer";
$css = "admin.css";
ob_start();
?>

<div class="add-offer-container py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="d-flex align-items-center mb-4">
                    <a href="manage-offers.php" class="btn btn-link text-dark p-0 mr-3" style="font-size: 24px;">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div>
                        <h2 class="font-weight-bold m-0"><?php echo $title; ?></h2>
                        <p class="text-muted m-0">Fill in the details to <?php echo $edit_mode ? 'update' : 'create'; ?> a promotional offer.</p>
                    </div>
                </div>

                <form action="add_offer_process.php" method="POST" enctype="multipart/form-data" class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                    <?php if ($edit_mode): ?>
                        <input type="hidden" name="offer_id" value="<?php echo $offer['id']; ?>">
                    <?php endif; ?>

                    <div class="card-body p-4 p-md-5">
                        <div class="row">
                            <div class="col-12 mb-4 text-center">
                                <div class="image-preview-container mx-auto mb-3" style="width: 100%; height: 250px; border-radius: 15px; background: #f1f5f9; border: 2px dashed #cbd5e1; overflow: hidden; position: relative; display: flex; align-items: center; justify-content: center;">
                                    <?php if (!empty($offer['image_path'])): ?>
                                        <img id="preview" src="../<?php echo $offer['image_path']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else: ?>
                                        <img id="preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                        <div id="placeholder" class="text-center">
                                            <i class="fa-solid fa-cloud-arrow-up text-muted mb-2" style="font-size: 40px;"></i>
                                            <p class="text-muted small m-0">Click 'Upload Image' to preview</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <label class="btn btn-success px-4" style="border-radius: 10px; cursor: pointer;">
                                    <i class="fa-solid fa-image mr-2"></i>Upload Image
                                    <input type="file" name="offer_image" id="offer_image" style="display: none;" onchange="previewImage(this)">
                                </label>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold" style="color: var(--text-main);">Offer Title</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($offer['title']); ?>" placeholder="e.g. Summer Special 25% Off" required style="border-radius: 10px; padding: 12px 15px; border: 1.5px solid #e2e8f0;">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold" style="color: var(--text-main);">Description</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Describe the offer details..." required style="border-radius: 10px; padding: 12px 15px; border: 1.5px solid #e2e8f0;"><?php echo htmlspecialchars($offer['description']); ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold" style="color: var(--text-main);">Discount (%)</label>
                                    <div class="input-group">
                                        <input type="number" name="discount_percentage" class="form-control" value="<?php echo $offer['discount_percentage']; ?>" placeholder="e.g. 25" required style="border-radius: 10px 0 0 10px; padding: 12px 15px; border: 1.5px solid #e2e8f0;">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-light" style="border-radius: 0 10px 10px 0; border: 1.5px solid #e2e8f0; border-left: none;">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold" style="color: var(--text-main);">Valid Until</label>
                                    <input type="date" name="valid_until" class="form-control" value="<?php echo $offer['valid_until']; ?>" required style="border-radius: 10px; padding: 12px 15px; border: 1.5px solid #e2e8f0;">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold" style="color: var(--text-main);">Status</label>
                                    <select name="status" class="form-control" style="border-radius: 10px; padding: 12px 15px; border: 1.5px solid #e2e8f0; height: auto;">
                                        <option value="Active" <?php echo $offer['status'] === 'Active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="Inactive" <?php echo $offer['status'] === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white p-4 d-flex justify-content-end border-0" style="gap: 15px;">
                        <a href="manage-offers.php" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 10px; font-weight: 600;">Cancel</a>
                        <button type="submit" class="btn btn-success px-5 py-2" style="border-radius: 10px; font-weight: 600; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                            <i class="fa-solid fa-check mr-2"></i><?php echo $edit_mode ? 'Update Offer' : 'Publish Offer'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('preview').style.display = 'block';
            document.getElementById('placeholder').style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>
