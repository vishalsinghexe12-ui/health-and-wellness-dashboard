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


                <!-- Form Start -->
                <form action="register_process.php" method="POST" id="regform">

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

                        <input
                            type="password"
                            class="form-control"
                            name="password"
                            data-validation="required strongPassword"
                        >

                        <span id="password_error"></span>

                    </div>


                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Confirm Password
                        </label>
                        <input
                            type="password"
                            class="form-control"
                            name="confirmPassword"
                            data-validation="required confirmPassword">
                        <span id="confirmPassword_error"></span>
                    </div>


                    <!-- Gender -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Gender
                        </label>

                        <select
                            class="form-control"
                            name="gender"
                            data-validation="required select"
                        >

                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>

                        </select>

                        <span id="gender_error"></span>

                    </div>


                    <!-- Terms -->
                    <div class="mb-4">
                        <input type="checkbox" name="terms" data-validation="required">I agree to Terms<span id="terms_error"></span>
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

<script src="js/validate.js"></script>
<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
