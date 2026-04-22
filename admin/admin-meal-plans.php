<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
$title = "Meal Plans";
$css = "admin.css"; 
ob_start();

require_once("../db_config.php");
$query = "SELECT * FROM plans WHERE type = 'Meal'";
$result = mysqli_query($con, $query);
?>

<div class="meal-plan-container py-5">
    <div class="container">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="font-weight-bold">Meal Plans</h3>
            <a href="add-plans.php" class="btn btn-success" style="border-radius: 8px;">+ Add New Plan</a>
        </div>

        <div class="row">

            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <!-- CARD -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="meal-plan-card shadow w-100 d-flex flex-column text-center h-100 p-3" style="border-radius: 14px; position: relative;">
                    <?php $img = !empty($row['image_path']) ? "../".$row['image_path'] : "../meal-plans-images/weight loss.jpg"; ?>
                    <img src="<?php echo htmlspecialchars($img); ?>" class="img-fluid mb-3 meal-img" style="height:200px; object-fit:cover; border-radius: 10px;">
                    
                    <!-- Status Badge -->
                    <span class="badge <?php echo $row['status'] === 'Active' ? 'badge-success' : 'badge-secondary'; ?> p-1 px-2" style="position:absolute; top:15px; right:15px;"><?php echo $row['status']; ?></span>
                    
                    <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                    <p class="text-muted"><?php echo htmlspecialchars($row['description']); ?></p>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></p>
                    <p><strong>Calories:</strong> <?php echo htmlspecialchars($row['calories']); ?></p>
                    <?php if (!empty($row['duration'])): ?>
                    <p><strong>Duration:</strong> <?php echo htmlspecialchars($row['duration']); ?></p>
                    <?php endif; ?>
                    <p class="font-weight-bold" style="font-size: 20px; color: var(--primary-dark);">₹ <?php echo htmlspecialchars($row['price']); ?></p>
                    <hr>
                    <div class="d-flex mt-auto" style="gap: 8px;">
                        <a href="manage-plan-schedule.php?plan_id=<?php echo $row['id']; ?>" class="btn btn-outline-primary flex-grow-1" style="border-radius: 8px; font-size: 14px;" title="Manage Schedule">
                            <i class="fa-solid fa-calendar"></i>
                        </a>
                        <button class="btn btn-outline-success flex-grow-1" style="border-radius: 8px; font-size: 14px;" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>" title="Edit Plan">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <form method="POST" action="delete_plan_process.php" class="flex-grow-1" onsubmit="return confirm('Delete this plan?');">
                            <input type="hidden" name="plan_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="redirect" value="admin-meal-plans.php">
                            <button type="submit" class="btn btn-outline-danger btn-block" style="border-radius: 8px; font-size: 14px;" title="Delete Plan">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius: 16px; border: none;">
                  <form method="POST" action="edit_plan_process.php">
                    <input type="hidden" name="plan_id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="redirect" value="admin-meal-plans.php">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title font-weight-bold">Edit: <?php echo htmlspecialchars($row['title']); ?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold">Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($row['title']); ?>" required style="border-radius: 8px;">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Description</label>
                            <textarea name="description" class="form-control" rows="3" style="border-radius: 8px;"><?php echo htmlspecialchars($row['description']); ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Category</label>
                                    <input type="text" name="category" class="form-control" value="<?php echo htmlspecialchars($row['category']); ?>" style="border-radius: 8px;">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Price (₹)</label>
                                    <input type="number" name="price" class="form-control" value="<?php echo $row['price']; ?>" style="border-radius: 8px;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Calories</label>
                                    <input type="text" name="calories" class="form-control" value="<?php echo htmlspecialchars($row['calories']); ?>" style="border-radius: 8px;">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Status</label>
                                    <select name="status" class="form-control" style="border-radius: 8px;">
                                        <option value="Active" <?php echo $row['status'] === 'Active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="Inactive" <?php echo $row['status'] !== 'Active' ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Duration</label>
                                    <input type="text" name="duration" class="form-control" value="<?php echo htmlspecialchars($row['duration']); ?>" placeholder="e.g. 3 Months" style="border-radius: 8px;">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">&nbsp;</label>
                                    <p class="text-muted m-0 mt-2" style="font-size:12px;">Enter like: 1 Month, 3 Months</p>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="intensity" value="<?php echo htmlspecialchars($row['intensity']); ?>">
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                        <button type="submit" class="btn btn-success" style="border-radius: 8px;"><i class="fa-solid fa-check mr-1"></i>Save Changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php endwhile; ?>

        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>