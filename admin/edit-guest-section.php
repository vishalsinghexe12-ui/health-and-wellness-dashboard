<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

$is_edit = false;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sec = [
    'section'     => 'tip_card',
    'sort_order'  => 0,
    'title'       => '',
    'subtitle'    => '',
    'body'        => '',
    'image_path'  => '',
    'button_text' => '',
    'button_url'  => '',
    'is_active'   => 1
];

if($id > 0) {
    $res = mysqli_query($con, "SELECT * FROM guest_content WHERE id = $id");
    if($r = mysqli_fetch_assoc($res)) {
        $sec = $r;
        $is_edit = true;
    }
}

$title = $is_edit ? "Edit Content Section" : "Add Content Section";
$css = "admin.css";
ob_start();
?>
<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center mb-4">
                    <a href="manage-guest-page.php" class="btn btn-link text-dark p-0 mr-3" style="font-size:24px;">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div>
                        <h2 class="font-weight-bold m-0"><?php echo $title; ?></h2>
                        <p class="text-muted m-0">Fill in the details for the public guest page.</p>
                    </div>
                </div>

                <form action="save-guest-section-process.php" method="POST" enctype="multipart/form-data" class="card border-0 shadow-sm" style="border-radius:20px; overflow:hidden;">
                    <input type="hidden" name="section_id" value="<?php echo $id; ?>">
                    
                    <div class="card-body p-4 p-md-5">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold">Section Type</label>
                                    <select name="section" class="form-control" style="border-radius:10px; padding:10px 15px; height:auto;">
                                        <option value="banner" <?php echo $sec['section']=='banner'?'selected':'';?>>Top Banner</option>
                                        <option value="tip_card" <?php echo $sec['section']=='tip_card'?'selected':'';?>>Health Tip Card</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold">Sort Order</label>
                                    <input type="number" name="sort_order" class="form-control" value="<?php echo $sec['sort_order']; ?>" style="border-radius:10px; padding:22px 15px;">
                                </div>
                            </div>

                            <div class="col-12 text-center mb-4">
                                <div id="imgPreviewCont" style="width:100%; height:200px; background:#f1f5f9; border:2px dashed #cbd5e1; border-radius:15px; margin-bottom:10px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                                    <?php if(!empty($sec['image_path'])): ?>
                                        <img id="preview" src="../<?php echo $sec['image_path']; ?>" style="width:100%; height:100%; object-fit:cover;">
                                    <?php else: ?>
                                        <img id="preview" src="" style="width:100%; height:100%; object-fit:cover; display:none;">
                                        <div id="placeholder" class="text-muted"><i class="fa-solid fa-image fa-2x mb-2"></i><br>No image</div>
                                    <?php endif; ?>
                                </div>
                                <label class="btn btn-success px-4" style="border-radius:10px;">
                                    <i class="fa-solid fa-cloud-arrow-up mr-2"></i>Upload Image
                                    <input type="file" name="sec_image" style="display:none;" onchange="previewImage(this)">
                                </label>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold">Title / Heading</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($sec['title']); ?>" style="border-radius:10px; padding:22px 15px;" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold">Subtitle / Short Description</label>
                                    <textarea name="subtitle" class="form-control" rows="2" style="border-radius:10px; padding:15px;"><?php echo htmlspecialchars($sec['subtitle']); ?></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold">Body Context (For Modals)</label>
                                    <textarea name="body" class="form-control" rows="4" style="border-radius:10px; padding:15px;"><?php echo htmlspecialchars($sec['body']); ?></textarea>
                                    <small class="text-muted">Will be shown when clicking a tip card.</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold">Button Text (Optional)</label>
                                    <input type="text" name="button_text" class="form-control" value="<?php echo htmlspecialchars($sec['button_text']); ?>" style="border-radius:10px;">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold">Button Link (Optional)</label>
                                    <input type="text" name="button_url" class="form-control" value="<?php echo htmlspecialchars($sec['button_url']); ?>" style="border-radius:10px;">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="isActiveSwitch" name="is_active" value="1" <?php echo $sec['is_active']==1?'checked':''; ?>>
                                        <label class="custom-control-label font-weight-bold" for="isActiveSwitch">Set as Active</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer bg-white p-4 border-0 d-flex justify-content-end" style="gap:15px;">
                        <a href="manage-guest-page.php" class="btn btn-light px-4" style="border-radius:10px; font-weight:600;">Cancel</a>
                        <button type="submit" class="btn btn-success px-5" style="border-radius:10px; font-weight:600;">Save Content</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script>
function previewImage(input) {
    if(input.files && input.files[0]) {
        var r = new FileReader();
        r.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('preview').style.display = 'block';
            if(document.getElementById('placeholder')) document.getElementById('placeholder').style.display = 'none';
        }
        r.readAsDataURL(input.files[0]);
    }
}
</script>
<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>
