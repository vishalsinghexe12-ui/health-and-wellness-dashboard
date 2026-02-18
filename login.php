<?php
$title = "Login";
$css = "guest.css"; 

ob_start();
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">

                    <!-- Heading -->
                    <div class="text-center mb-4">
                        <h2 class="font-weight-bold text-success">Welcome Back</h2>
                        <p class="text-muted">Login to Health & Wellness</p>
                    </div>


                    <!-- Login Form -->
                    <form action="login_process.php" method="POST">

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Email Address</label>
                            <input type="text" class="form-control" id="email" name="email" data-validation="required email" placeholder="Enter your email">
                            <span id="email_error"></span>
                        </div>


                        <!-- Password -->
                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Password</label>
                            <input type="password" class="form-control" id="password" name="password" data-validation="required strongPassword" placeholder="Enter your password">
                            <span id="password_error"></span>
                        </div>


                        <!-- Remember + Forgot -->
                        <div class="mb-4 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" required>
                                <label class="form-check-label">Remember me</label>
                            </div>
                            <a href="#" class="text-success">Forgot Password?</a>
                        </div>


                        <!-- Login Button -->
                        <button type="button" class="btn btn-success w-100 btn-lg mb-3" onclick="window.location.href='user/register.php'">Login </button>


                        <!-- Register -->
                        <div class="text-center">
                            <p class="text-muted mb-0"> Don't have an account?
                                <a href="register.php" class="text-success font-weight-bold">Sign Up</a>
                            </p>
                        </div>
                    </form>


                    <!-- Social login -->
                    <div class="text-center mt-4">
                        <p class="text-muted mb-3">Or login with</p>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-outline-secondary mr-2">Google </button>
                            <button class="btn btn-outline-secondary mr-2">Facebook</button>
                            <button class="btn btn-outline-secondary">GitHub</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/validate.js"></script>

<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
