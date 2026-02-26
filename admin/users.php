<?php
$title = "Admin";
$css = "admin.css";
ob_start();
?>
<div class="container-fluid">
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

    <!-- Main Content -->
    <div class="col-lg-10 p-3">
      <div class="row mb-4">
        
        <div class="card shadow-sm mt-4 pl-3">
        <div class="card-body ">

        <h5 class="mb-3">Total Users</h5>

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>1</td>
                    <td>Prajakta</td>
                    <td>prajakta@email.com</td>
                    <td><span class="badge badge-success">Active</span></td>
                    <td><button class="btn btn-success btn-sm">View</button></td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Vishal</td>
                    <td>vishal@email.com</td>
                    <td><span class="badge badge-success">Active</span></td>
                    <td><button class="btn btn-success btn-sm">View</button></td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>Anjali</td>
                    <td>anjali@email.com</td>
                    <td><span class="badge badge-primary">Inactive</span></td>
                    <td><button class="btn btn-success btn-sm">View</button></td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>Anas</td>
                    <td>anas@email.com</td>
                    <td><span class="badge badge-warning">Blocked</span></td>
                    <td><button class="btn btn-success btn-sm">View</button></td>
                </tr>
            </tbody>
        </table>

      </div>
    </div>
    


  </div>
</div>
<script type="text/javascript" src="https://new-assets.ccbp.in/frontend/content/static-ccbp-ui-kit/static-ccbp-ui-kit.js"></script>
</body>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>