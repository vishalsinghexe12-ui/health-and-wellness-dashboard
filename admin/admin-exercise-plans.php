<?php
$title = "Exercise Plans";
$css = "admin.css"; 
ob_start();

require_once("../db_config.php");
$query = "SELECT * FROM plans WHERE type = 'Exercise'";
$result = mysqli_query($con, $query);
?>

<div class="exercise-plan-container py-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="font-weight-bold">Exercise Plans</h3>
            <a href="add-plans.php" class="btn btn-success">+ Add New Plan</a>
        </div>
        
        <div class="row">

            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <!-- Card -->
            <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                <div class="exercise-plan-card shadow w-100 d-flex flex-column text-center h-100 p-3">
                    <?php $img = !empty($row['image_path']) ? "../".$row['image_path'] : "../Exercise-Images/Beginner Fitness.jpg"; ?>
                    <img src="<?php echo htmlspecialchars($img); ?>" class="img-fluid exercise-img mb-3" style="height:200px; object-fit:cover;">
                    <h3 class="exercise-plan-title mt-3" style="font-size: 1.5rem;"><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p class="exercise-plan-description flex-grow-1">
                        <?php echo htmlspecialchars($row['description']); ?>
                    </p>
                    <p class="exercise-plan-category m-0"><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></p>
                    <p class="exercise-plan-duration m-0"><strong>Duration:</strong> <?php echo htmlspecialchars($row['duration']); ?></p>
                    <p class="exercise-plan-price font-weight-bold mt-2">₹ <?php echo htmlspecialchars($row['price']); ?></p>
                    <hr>
                    <button class="btn btn-success btn-block mt-auto">Edit / Delete</button>
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