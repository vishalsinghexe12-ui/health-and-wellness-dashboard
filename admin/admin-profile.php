<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

$admin_id = $_SESSION['user_id'];
$query = "SELECT * FROM register WHERE id = ? AND role = 'admin'";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();

if (!$admin) {
    echo "Admin not found.";
    exit();
}

$title = "My Profile - Admin";
$css = "admin.css";
ob_start();
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <?php if (isset($_SESSION['profile_msg'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                    <i class="fa-solid fa-circle-check mr-2"></i> <?php echo $_SESSION['profile_msg']; unset($_SESSION['profile_msg']); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-body p-5">

                    <!-- Profile Header -->
                    <div class="text-center mb-5">
                        <div class="position-relative d-inline-block">
                            <?php 
                                $pic = !empty($admin['profile_picture']) ? "../" . $admin['profile_picture'] : "../images/default-admin.jpg";
                            ?>
                            <img src="<?php echo htmlspecialchars($pic); ?>" 
                                 class="rounded-circle shadow-sm" 
                                 width="150" height="150" 
                                 style="object-fit: cover; border: 5px solid #f8fafc;">
                            <label for="profilePicInput" class="btn btn-sm btn-success position-absolute" style="bottom: 5px; right: 5px; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                <i class="fa-solid fa-camera"></i>
                            </label>
                        </div>
                        <h3 class="mt-3 font-weight-bold" style="color: var(--primary-dark);"><?php echo htmlspecialchars($admin['name']); ?></h3>
                        <p class="text-muted text-uppercase tracking-wider" style="font-size: 13px; font-weight: 600;">System Administrator</p>
                    </div>

                    <!-- Profile Form -->
                    <form id="profileForm" action="update-profile-process.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="profile_picture" id="profilePicInput" class="d-none" onchange="previewImage(this)">
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="font-weight-bold text-muted small text-uppercase">Full Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0" style="border-radius: 10px 0 0 10px;"><i class="fa-solid fa-user text-muted"></i></span>
                                    </div>
                                    <input type="text" name="name" class="form-control border-left-0" value="<?php echo htmlspecialchars($admin['name']); ?>" required style="border-radius: 0 10px 10px 0; padding: 25px 15px;">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="font-weight-bold text-muted small text-uppercase">Email Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0" style="border-radius: 10px 0 0 10px;"><i class="fa-solid fa-envelope text-muted"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control border-left-0" value="<?php echo htmlspecialchars($admin['email']); ?>" required style="border-radius: 0 10px 10px 0; padding: 25px 15px;">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="font-weight-bold text-muted small text-uppercase">Mobile Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0" style="border-radius: 10px 0 0 10px;"><i class="fa-solid fa-phone text-muted"></i></span>
                                    </div>
                                    <input type="text" name="mobile" class="form-control border-left-0" value="<?php echo htmlspecialchars($admin['mobile']); ?>" style="border-radius: 0 10px 10px 0; padding: 25px 15px;">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="font-weight-bold text-muted small text-uppercase">Gender</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0" style="border-radius: 10px 0 0 10px;"><i class="fa-solid fa-venus-mars text-muted"></i></span>
                                    </div>
                                    <select name="gender" class="form-control border-left-0" style="border-radius: 0 10px 10px 0; height: 52px;">
                                        <option value="Male" <?php echo $admin['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?php echo $admin['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                        <option value="Other" <?php echo $admin['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4 pt-4 border-top">
                            <div class="row align-items-center">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <a href="change-password.php" class="text-success font-weight-bold"><i class="fas fa-lock mr-2"></i> Change Password</a>
                                </div>
                                <div class="col-sm-6 text-sm-right">
                                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm" style="border-radius: 10px;">Save Profile</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('.rounded-circle').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>