
<?php
$title = "Admin Dashboard";
$css = "admin.css";
ob_start();
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">




        <div class="row mb-5">
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <h6><i class="fa-solid fa-users mr-2"></i>Total Users</h6>
                    <h3>50</h3>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <h6><i class="fa-solid fa-dumbbell mr-2"></i>Total Plans</h6>
                    <h3>4</h3>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <h6><i class="fa-solid fa-envelope mr-2"></i>Total Messages</h6>
                    <h3>12</h3>
                </div>
            </div>
        </div>

        <div class="card shadow-sm p-2">
            <div class="card-body">
                <h4 class="mb-4" style="font-family:'Outfit', sans-serif;">Recent Users</h4>

                <div class="table-responsive">
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
                                <td>Anas</td>
                                <td>anas@email.com</td>
                                <td><span class="badge badge-primary">Inactive</span></td>
                                <td><button class="btn btn-success btn-sm">View</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>