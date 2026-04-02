<?php
$title = "Register - Health & Wellness";
$css = "guest.css";

ob_start();
?>
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-8">
        <div class="card border-0 shadow-lg">
            <div class="card-body p-5">
                <!-- Heading -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success">Create Account</h2>
                    <p class="text-muted">Join Health & Wellness today</p>
                </div>

                <?php if(isset($_SESSION['auth_flash'])): ?>
                    <div class="alert alert-info text-center border-0 shadow-sm" style="border-radius: 12px; background-color: #f0fdf4; color: #166534;">
                        <?php 
                        echo $_SESSION['auth_flash']; 
                        unset($_SESSION['auth_flash']);
                        ?>
                    </div>
                <?php endif; ?>


                <!-- Form Start -->
                <form action="register_process.php" method="POST" id="regform" enctype="multipart/form-data">

                    <!-- First Name and Last Name -->
                    <div class="row">

                        <!-- First Name -->
                        <div class="col-lg-6 mb-4">
                            <label class="form-label fw-semibold">First Name</label>
                            <input type="text" class="form-control"name="firstName" placeholder="John" data-validation="required min" data-min="2">
                            <span id="firstName_error"></span>
                        </div>


                        <!-- Last Name -->
                        <div class="col-lg-6 mb-4">
                            <label class="form-label fw-semibold">Last Name</label>

                            <input
                                type="text"
                                class="form-control"
                                name="lastName"
                                placeholder="Doe"
                                data-validation="required min"
                                data-min="2"
                            >

                            <span id="lastName_error"></span>

                        </div>

                    </div>


                    <!-- Email -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Email
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="email"
                            placeholder="john@email.com"
                            data-validation="required email"
                        >

                        <span id="email_error"></span>

                    </div>


                    <!-- Phone -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Phone
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="phone"
                            data-validation="required number min max"
                            data-min="10"
                            data-max="10"
                        >

                        <span id="phone_error"></span>

                    </div>


                    <!-- Password -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Password
                        </label>

                        <div class="input-group">
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                data-validation="required strongPassword"
                            >
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" style="cursor: pointer; background: white;">
                                    <i class="fa-solid fa-eye text-muted"></i>
                                </span>
                            </div>
                        </div>
                        <span id="password_error"></span>

                    </div>


                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Confirm Password
                        </label>
                        <div class="input-group">
                            <input
                                type="password"
                                class="form-control"
                                id="confirmPassword"
                                name="confirmPassword"
                                data-validation="required confirmPassword">
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" style="cursor: pointer; background: white;">
                                    <i class="fa-solid fa-eye text-muted"></i>
                                </span>
                            </div>
                        </div>
                        <span id="confirmPassword_error"></span>
                    </div>


                    <!-- Gender -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Gender</label>

                        <select class="form-control" name="gender" data-validation="required select">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <span id="gender_error"></span>
                    </div>

                    <div class="mb-4">
                        <label>Upload Profile Picture (Optional, Max 10MB)</label>
                        <input type="file" name="profileImage" class="form-control-file" data-validation="fileSize fileType"  data-filesize="10240" data-filetype="jpg,jpeg,png">   
                        <span id="profileImage_error"></span> 
                    </div>

                    <!-- Terms -->
                    <div class="mb-4">
                        <input type="checkbox" name="terms" data-validation="required"> I agree to Terms<span id="terms_error"></span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success w-100">Create Account
                    </button>


                    <!-- Login Link -->
                    <div class="text-center mt-3">
                        <a href="login.php" class="text-success">Already have account? Login </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/validate.js?v=<?php echo time(); ?>"></script>
<script>
$(document).ready(function() {
    $('.toggle-password').click(function() {
        let input = $(this).closest('.input-group').find('input');
        let icon = $(this).find('i');
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});
</script>
<?php
$content = ob_get_clean();
include("includes/layout.php");
?>

