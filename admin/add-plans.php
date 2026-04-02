<?php
$title = "Add Plan";
$css = "admin.css";

ob_start();
?>

<div class="py-5" style="background-color: #ecfdf5; min-height: calc(100vh - 70px);">
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-8 col-lg-8">
        <div class="card border-0 shadow-lg" style="border-radius: 20px;">
            <div class="card-body p-5">
                <!-- Heading -->
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-success">Add New Plan</h2>
                    <p class="text-muted">Fill in the details below to create a new wellness or fitness plan.</p>
                </div>


                <!-- Form Start -->
                <form action="add_plan_process.php" method="POST" id="regform" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-7 mb-4">
                            <label class="form-label fw-semibold">Plan Title</label>
                            <input type="text" class="form-control" name="planTitle" placeholder="e.g. 30 Day Yoga Challenge" data-validation="required min" data-min="5">
                            <span id="planTitle_error"></span>
                        </div>
                        <div class="col-md-5 mb-4">
                            <label class="form-label fw-semibold">Plan Type</label>
                             <select name="type" class="form-control" data-validation="required select">
                                <option value="">Select Type</option>
                                <option value="Exercise">Exercise Plan</option>
                                <option value="Meal">Meal Plan</option>
                                <option value="Wellness">Wellness Plan</option>
                            </select>
                            <span id="type_error"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">Category / Goal</label>
                            <input type="text" class="form-control" name="category" placeholder="e.g. Weight Loss, Strength" data-validation="required">
                            <span id="category_error"></span>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">Duration (Months)</label>
                            <input type="number" class="form-control" name="duration" min="1" max="24" placeholder="e.g. 3" data-validation="required number">
                            <span id="duration_error"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-semibold">Price (₹)</label>
                            <input type="number" class="form-control" name="price" placeholder="500" data-validation="required number">
                            <span id="price_error"></span>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-semibold">Calories (Approx)</label>
                            <input type="text" class="form-control" name="calories" placeholder="e.g. 500 kcal" data-validation="required">
                            <span id="calories_error"></span>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-semibold">Intensity</label>
                            <select name="intensity" class="form-control" data-validation="required select">
                                <option value="">Select</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                            <span id="intensity_error"></span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Plan Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Describe the benefits and steps of this plan" data-validation="required min" data-min="20"></textarea>
                        <span id="description_error"></span>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">Card Display Image</label>
                            <input type="file" name="image" class="form-control-file" data-validation="required fileType" data-filetype="jpg,jpeg,png">   
                            <small class="text-muted">This image will be shown on the plan card.</small>
                            <span id="image_error"></span>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-success w-100 btn-lg shadow-sm mt-4" style="border-radius: 12px; font-weight: 700;">+ Create Plan </button>

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
