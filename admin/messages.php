<?php
$title = "Messages - Admin";
$css = "admin.css";
ob_start();
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);">Messages</h2>
            <p class="text-muted">View and reply to user messages</p>
        </div>

        <!-- Header + Search -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="font-weight-bold">All Messages</h5>
            <input type="text" id="searchInput"
                   class="form-control" style="max-width: 250px;"
                   placeholder="Search messages...">
        </div>

        <div class="row">

            <!-- LEFT SIDE - TABLE -->
            <div class="col-md-8" id="tableSection">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="messageTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Prajakta</td>
                                        <td>Diet Plan Query</td>
                                        <td><span class="badge badge-warning">New</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-success viewBtn"
                                                data-name="Prajakta"
                                                data-email="prajakta@email.com"
                                                data-message="I need help with weight loss plan.">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Vishal</td>
                                        <td>Workout Issue</td>
                                        <td><span class="badge badge-primary">Pending</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-success viewBtn"
                                                data-name="Vishal"
                                                data-email="vishal@email.com"
                                                data-message="My workout schedule is not loading.">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Anjali</td>
                                        <td>Meal Plan Change</td>
                                        <td><span class="badge badge-success">Resolved</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-success viewBtn"
                                                data-name="Anjali"
                                                data-email="anjali@email.com"
                                                data-message="Can I change my vegetarian meal plan?">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE - MESSAGE PANEL -->
            <div class="col-md-4 d-none" id="messagePanel">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Message Details</h5>
                            <button class="btn btn-sm btn-danger" id="closePanel">X</button>
                        </div>
                        <p><strong>Name:</strong> <span id="msgName"></span></p>
                        <p><strong>Email:</strong> <span id="msgEmail"></span></p>
                        <hr>
                        <p id="msgContent"></p>
                        <hr>
                        <textarea class="form-control mb-2" placeholder="Type reply here..."></textarea>
                        <button class="btn btn-success btn-sm">Send Reply</button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
/* SEARCH FUNCTION */
document.getElementById("searchInput").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#messageTable tbody tr");

    rows.forEach(row => {
        row.style.display =
            row.innerText.toLowerCase().includes(filter)
                ? ""
                : "none";
    });
});

/* VIEW BUTTON CLICK */
document.querySelectorAll(".viewBtn").forEach(btn => {
    btn.addEventListener("click", function () {

        document.getElementById("msgName").innerText =
            this.getAttribute("data-name");

        document.getElementById("msgEmail").innerText =
            this.getAttribute("data-email");

        document.getElementById("msgContent").innerText =
            this.getAttribute("data-message");

        document.getElementById("messagePanel").classList.remove("d-none");

        document.getElementById("tableSection")
            .classList.remove("col-md-8");

        document.getElementById("tableSection")
            .classList.add("col-md-7");
    });
});

/* CLOSE PANEL */
document.getElementById("closePanel").addEventListener("click", function () {
    document.getElementById("messagePanel").classList.add("d-none");

    document.getElementById("tableSection")
        .classList.remove("col-md-7");

    document.getElementById("tableSection")
        .classList.add("col-md-8");
});
</script>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>