<?php
$title = "Add Plan";
$css = "admin.css";

ob_start();
?>

<div class="py-5" style="background-color: #ecfdf5; min-height: calc(100vh - 70px);">
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <div class="card border-0 shadow-lg">
            <div class="card-body p-5">
                <!-- Heading -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success">Add New Plan</h2>
                    <p class="text-muted">You can add the details of the new plan below.</p>
                </div>


                <!-- Form Start -->
                <form action="add_plan_process.php" method="POST" id="regform" enctype="multipart/form-data">

                    <div class=" mb-4">
                        <label class="form-label fw-semibold">Plan Title</label>
                        <input type="text" class="form-control" name="planTitle" placeholder="Title of the plan" data-validation="required min" data-min="5">
                        <span id="planTitle_error"></span>
                    </div>

                    <!-- plan type -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Plan Type</label>
                         <select name="type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option>Exercise plan</option>
                            <option>Meal Plan</option>
                        </select>
                    </div>


                    <!-- duration -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Duration (Weeks)</label>
                        <input type="number" class="form-control" required>
                    </div>


                    <!-- Password -->
                    <div class="mb-4">
                        <label>Price (₹)</label>
                        <input type="number" class="form-control" name="price" required>
                    </div>


                    <!-- descpription -->
                    <div class="mb-4">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>


                    <!-- status -->
                    <div class="mb-4">
                        <label>Status</label>
                            <select name="status" class="form-control">
                                <option>Active</option>
                                <option>Inactive</option>
                            </select>
                    </div>


                    <!-- image -->
                    <div class="mb-4">
                        <label>Upload Image</label>
                        <input type="file" name="image" class="form-control-file" required>    
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-success w-100">+ Add Plan </button>

                </form>
            </div>
        </div>
    </div>
    </div>
</div>
</div>

<script src="../js/validate.js"></script>
<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>
