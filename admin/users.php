<?php
$title = "Users - Admin";
$css = "admin.css";
ob_start();
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);">Manage Users</h2>
            <p class="text-muted">View and manage all registered users</p>
        </div>
        
        <div class="card shadow-sm p-2">
            <div class="card-body">
                <h5 class="mb-3">Total Users</h5>

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
                                <td>Anjali</td>
                                <td>anjali@email.com</td>
                                <td><span class="badge badge-primary">Inactive</span></td>
                                <td><button class="btn btn-success btn-sm">View</button></td>
                            </tr>
                            <tr>
                                <td>4</td>
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
</div>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>