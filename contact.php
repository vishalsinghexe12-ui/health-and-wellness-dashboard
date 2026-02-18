<?php
$title = "Contact Us - Health & Wellness";
$css = "guest.css";

ob_start();
?>

<div class="container mt-5 mb-5">
    <!-- Heading -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 font-weight-bold text-success">Get In Touch</h1>
            <p class="lead text-muted">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <h3 class="font-weight-bold mb-4 text-success">Send us a Message</h3>
                    <form action="contact_process.php" method="POST">
                        <div class="row">

                            <!-- Name -->
                            <div class="col-md-6 mb-4">
                                <label class="font-weight-bold">Your Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    data-validation="required min"
                                    data-min="2"
                                >
                                <span id="name_error" class="text-danger"></span>
                            </div>


                            <!-- Email -->
                            <div class="col-md-6 mb-4">
                                <label class="font-weight-bold">Email</label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="email"
                                    data-validation="required email"
                                >
                                <span id="email_error" class="text-danger"></span>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="mb-4">
                            <label class="font-weight-bold">Subject</label>
                            <input
                                type="text"
                                class="form-control"
                                name="subject"
                                data-validation="required min"
                                data-min="3"
                            >
                            <span id="subject_error" class="text-danger"></span>
                        </div>

                        <!-- Message -->
                        <div class="mb-4">
                            <label class="font-weight-bold">Message</label>
                            <textarea
                                class="form-control"
                                name="message"
                                rows="5"
                                data-validation="required min"
                                data-min="10"
                            ></textarea>

                            <span id="message_error" class="text-danger"></span>
                        </div>


                        <!-- Submit -->
                        <button type="submit"class="btn btn-success btn-lg w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>


        <!-- Contact Info -->
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-lg bg-success text-white">
                <div class="card-body p-5">
                    <h3 class="font-weight-bold mb-4">Contact Info</h3>
                    <p class="mb-4">Our team will respond within 24 hours.</p>
                    <h5 class="font-weight-bold">Address</h5>
                    <p class="mb-3">RK University, Rajkot, Gujarat, India</p>
                    <h5 class="font-weight-bold">Phone</h5>
                    <p class="mb-3">+91 12345 67890 </p>
                    <h5 class="font-weight-bold">Email </h5>
                    <p>support@healthwellness.com</p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Include validation -->
<script src="../assets/js/validation.js"></script>


<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
