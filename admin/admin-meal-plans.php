<?php
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
            <a href="add-plans.php" class="btn btn-success">+ Add New Plan</a>
        </div>

        <div class="row">

            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <!-- CARD -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="meal-plan-card shadow w-100 d-flex flex-column text-center h-100 p-3">
                    <?php $img = !empty($row['image_path']) ? "../".$row['image_path'] : "../meal-plans-images/weight loss.jpg"; ?>
                    <img src="<?php echo htmlspecialchars($img); ?>" class="img-fluid mb-3 meal-img" style="height:200px; object-fit:cover;">
                    <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></p>
                    <p><strong>Calories:</strong> <?php echo htmlspecialchars($row['calories']); ?></p>
                    <p class="font-weight-bold">₹ <?php echo htmlspecialchars($row['price']); ?></p>
                    <hr>
                    <button class="btn btn-success mt-auto">Edit / Delete</button>
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