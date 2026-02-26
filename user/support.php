<?php
$title = "Support - Health & Wellness";
$css = "support.css";
ob_start();
?>

<div class="support-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 support-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-success">Need Help?</h2>
                            <p class="text-muted">Our team is here to assist you.</p>
                        </div>

                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Select Category
                                </label>
                                <select class="form-control" name="subject" required>
                                    <option value="">Choose Option</option>
                                    <option>Workout Plan Issue</option>
                                    <option>Meal Plan Issue</option>
                                    <option>Account Problem</option>
                                    <option>Billing Support</option>
                                    <option>Other</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Message</label>
                                <textarea class="form-control" name="message" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100 support-btn">Send Message</button>
                        </form>
                        <div class="text-center mt-4 support-info">
                            <p>📧 support@healthwellness.com</p>
                            <p>📞 +91 1234567890</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/registered_layout.php");
?>