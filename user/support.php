<?php
$title = "Support";
$css = "register-dashboard.css"; 

ob_start();
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">
        <!-- Back Button from remote -->
        <div class="mb-4">
            <a href="register-dashboard.php" class="btn btn-outline-success d-inline-flex align-items-center" style="border-radius: 20px; padding: 5px 20px;">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                <span>Back to Dashboard</span>
            </a>
        </div>

        <div class="text-center mb-5">
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);">Customer Support</h2>
            <p class="text-muted">We're here to help you on your journey 24/7.</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <div class="col-lg-8">
                <div class="stat-card p-5">
                    <h4 class="font-weight-bold mb-4">Send us a Message</h4>
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Full Name</label>
                                <input type="text" class="form-control" placeholder="Your Name" style="border-radius: 8px;">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Email Address</label>
                                <input type="email" class="form-control" placeholder="Your Email" style="border-radius: 8px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Subject</label>
                            <input type="text" class="form-control" placeholder="How can we help?" style="border-radius: 8px;">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Message</label>
                            <textarea class="form-control" rows="5" placeholder="Write your message here..." style="border-radius: 8px;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg btn-block font-weight-bold mt-4" style="border-radius: 10px;">Submit Ticket</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="stat-card p-4 mb-4">
                    <h5 class="font-weight-bold mb-3"><i class="fa-solid fa-phone mr-2 text-success"></i> Call Support</h5>
                    <p class="text-muted mb-0">+91 98765 43210</p>
                    <small>Mon - Fri, 9AM - 6PM IST</small>
                </div>
                <div class="stat-card p-4">
                    <h5 class="font-weight-bold mb-3"><i class="fa-solid fa-envelope mr-2 text-success"></i> Email Support</h5>
                    <p class="text-muted mb-0">support@healthdash.com</p>
                    <small>Available 24/7</small>
                </div>
            </div>
        </div>
    </div>
</div>     

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
