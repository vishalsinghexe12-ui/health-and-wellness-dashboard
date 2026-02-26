<?php
$title = "My Profile - Health & Wellness";
$css = "register-dashboard.css";

ob_start();
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-lg border-0">
                <div class="card-body p-4">

                    <!-- Profile Header -->
                    <div class="text-center mb-4">

                        <img src="../images/woman-lotus-pose-park.jpg"
                             class="rounded-circle shadow"
                             width="150"
                             height="150"
                             style="object-fit: cover; border:4px solid #198754;">

                        <h4 class="mt-3">Prajakta Sarode</h4>
                        <p class="text-muted">Health Enthusiast</p>

                        <button class="btn btn-success btn-sm"
                                id="editBtn">
                            Edit Profile
                        </button>
                    </div>

                    <hr>

                    <!-- Profile Form -->
                    <form id="profileForm">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>First Name</label>
                                <input type="text"
                                       class="form-control"
                                       value="Prajakta"
                                       disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Last Name</label>
                                <input type="text"
                                       class="form-control"
                                       value="Sarode"
                                       disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email"
                                       class="form-control"
                                       value="prajakta@email.com"
                                       disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Phone</label>
                                <input type="text"
                                       class="form-control"
                                       value="9876543210"
                                       disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Gender</label>
                                <select class="form-control" disabled>
                                    <option selected>Female</option>
                                    <option>Male</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Upload Profile Picture</label>
                                <input type="file"
                                       class="form-control-file"
                                       disabled>
                            </div>

                        </div>

                        <div class="text-center d-none" id="saveSection">
                            <button type="button"
                                    class="btn btn-primary">
                                Save Changes
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.getElementById("editBtn").addEventListener("click", function () {

    let inputs = document.querySelectorAll("#profileForm input, #profileForm select");

    inputs.forEach(input => {
        input.removeAttribute("disabled");
    });

    document.getElementById("saveSection").classList.remove("d-none");
    this.classList.add("d-none");
});
</script>

<?php
$content = ob_get_clean();
include("../includes/layout.php");
?>