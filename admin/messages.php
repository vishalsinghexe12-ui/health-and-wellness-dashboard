<?php
$title = "Admin";
$css = "admin.css";
ob_start();
?>

<!--sidebar -->

<div class="container-fluid ">
  <div class="row" style="height:100vh;">
    <!-- Sidebar -->
        <div class="col-2 bg-success">
          <div class="sticky-top"> 
            <nav class="nav flex-column mt-3 sidebar">

            <a class="nav-link active sidebar-link" style="white-space: nowrap;" href="admin.php">
              <i class="fa-solid fa-gauge mr-2"></i> <span class="d-none d-sm-inline ms-2" >Dashboard</span>
            </a>

            <hr class="sidebar-divider">

            <a class="nav-link sidebar-link" style="white-space: nowrap;" href="users.php">
              <i class="fa-solid fa-user mr-2"></i> <span class="d-none d-sm-inline ms-2">Users</span>
            </a>

            <a class="nav-link sidebar-link" style="white-space: nowrap;" href="plans.php">
              <i class="fa-solid fa-dumbbell mr-2"></i> <span class="d-none d-sm-inline ms-2">Plans</span>
            </a>

            <a class="nav-link sidebar-link" style="white-space: nowrap;" href="messages.php">
              <i class="fa-solid fa-envelope mr-2"></i> <span class="d-none d-sm-inline ms-2">Messages</span>
            </a>

            <a class="nav-link sidebar-link" style="white-space: nowrap;" href="../login.php">
              <i class="fa-solid fa-right-from-bracket mr-2"></i> <span class="d-none d-sm-inline ms-2" >Logout</span>
            </a>

          </nav>
          </div>
        </div>
    


        <!--main content-->
<div class="container-fluid mt-4 col-10">

    <!-- Header + Search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Messages</h4>

        <input type="text" id="searchInput"
               class="form-control w-25"
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

                    <textarea class="form-control mb-2"
                              placeholder="Type reply here..."></textarea>

                    <button class="btn btn-success btn-sm">
                        Send Reply
                    </button>

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
</div>
</div>
<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>