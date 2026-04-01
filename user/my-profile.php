<?php
require_once("../includes/user_auth.php");
require_once("../db_config.php");

$user_id = $_SESSION['user_id'];
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $name = trim($firstName . ' ' . $lastName);
    $phone = $_POST['phone'] ?? '';
    $gender = $_POST['gender'] ?? '';

    $profile_picture = "";
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
        $ext = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
        $new_name = time() . "_" . uniqid() . "." . $ext;
        
        $upload_dir = "../images/uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $dest = $upload_dir . $new_name;
        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $dest)) {
            $profile_picture = "images/uploads/" . $new_name;
            $_SESSION['profile_picture'] = $profile_picture;
        }
    }

    if (!empty($profile_picture)) {
        $stmt = $con->prepare("UPDATE register SET name=?, mobile=?, gender=?, profile_picture=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $phone, $gender, $profile_picture, $user_id);
    } else {
        $stmt = $con->prepare("UPDATE register SET name=?, mobile=?, gender=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $phone, $gender, $user_id);
    }

    if ($stmt->execute()) {
        $msg = "<div class='alert alert-success alert-dismissible fade show'>Profile updated successfully! <button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
        $_SESSION['user_name'] = $name;
    } else {
        $msg = "<div class='alert alert-danger'>Error updating profile.</div>";
    }
}

$stmt = $con->prepare("SELECT name, email, mobile, gender, profile_picture FROM register WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$name_parts = explode(" ", $user['name'] ?? '', 2);
$first_name = $name_parts[0] ?? '';
$last_name = $name_parts[1] ?? '';

$pic = $user['profile_picture'] ?? 'default.png';
if ($pic == 'default.png' || empty($pic)) {
    $pic_src = "../images/woman-lotus-pose-park.jpg";
} else {
    $pic_src = "../" . $pic;
}

$title = "My Profile - Health & Wellness";
$css = "register-dashboard.css";

ob_start();
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <?php if(!empty($msg)) echo $msg; ?>

            <div class="card shadow-lg border-0">
                <div class="card-body p-4">

                    <!-- Profile Header -->
                    <div class="text-center mb-4">

                        <img src="<?php echo htmlspecialchars($pic_src); ?>"
                             class="rounded-circle shadow"
                             width="150"
                             height="150"
                             style="object-fit: cover; border:4px solid #198754;">

                        <h4 class="mt-3"><?php echo htmlspecialchars($user['name']); ?></h4>
                        <p class="text-muted">Health Enthusiast</p>

                        <button class="btn btn-success btn-sm"
                                id="editBtn">
                            Edit Profile
                        </button>
                        <a href="change-password.php" class="btn btn-outline-success btn-sm ms-2">
                            <i class="fas fa-lock me-1"></i> Change Password
                        </a>
                    </div>

                    <hr>

                    <!-- Profile Form -->
                    <form id="profileForm" method="POST" action="" enctype="multipart/form-data">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>First Name</label>
                                <input type="text"
                                       name="firstName"
                                       class="form-control"
                                       value="<?php echo htmlspecialchars($first_name); ?>"
                                       disabled required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Last Name</label>
                                <input type="text"
                                       name="lastName"
                                       class="form-control"
                                       value="<?php echo htmlspecialchars($last_name); ?>"
                                       disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email"
                                       class="form-control"
                                       value="<?php echo htmlspecialchars($user['email']); ?>"
                                       disabled readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Phone</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="<?php echo htmlspecialchars($user['mobile'] ?? ''); ?>"
                                       disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Gender</label>
                                <select class="form-control" name="gender" disabled>
                                    <option value="Female" <?php echo ($user['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                    <option value="Male" <?php echo ($user['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Upload Profile Picture</label>
                                <input type="file"
                                       name="profileImage"
                                       class="form-control-file"
                                       accept="image/*"
                                       disabled>
                            </div>

                        </div>

                        <div class="text-center d-none" id="saveSection">
                            <button type="submit"
                                    name="update_profile"
                                    class="btn btn-primary">
                                Save Changes
                            </button>
                            <button type="button" class="btn btn-secondary ms-2" onclick="location.reload()">Cancel</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.getElementById("editBtn").addEventListener("click", function () {

    let inputs = document.querySelectorAll("#profileForm input:not([readonly]), #profileForm select");

    inputs.forEach(input => {
        input.removeAttribute("disabled");
    });

    document.getElementById("saveSection").classList.remove("d-none");
    this.classList.add("d-none");
});
</script>

<?php
$content = ob_get_clean();
include("../includes/registered_layout.php");
?>