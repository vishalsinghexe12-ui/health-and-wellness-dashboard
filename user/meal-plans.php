<?php
$title = "Meal Plans";
$css = "register-dashboard.css"; 
ob_start();

require_once("../db_config.php");
$query = "SELECT * FROM plans WHERE type = 'Meal' AND status = 'Active'";
$result = mysqli_query($con, $query);
?>
    
<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);">Nutrition Meal Plans</h2>
            <p class="text-muted">Scientifically crafted meal plans to accelerate your health journey.</p>
        </div>
        
        <div class="row g-4">
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <!-- Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px;">
                    <?php $img = !empty($row['image_path']) ? "../".$row['image_path'] : "../meal-plans-images/weight loss.jpg"; ?>
                    <img src="<?php echo htmlspecialchars($img); ?>" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);"><?php echo htmlspecialchars($row['title']); ?></h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;"><?php echo htmlspecialchars($row['description']); ?></p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Goal: <?php echo htmlspecialchars($row['category']); ?></span>
                        <span><?php echo htmlspecialchars($row['calories']); ?></span>
                    </div>
                    <?php if (!empty($row['duration'])): ?>
                    <div class="text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <i class="fa-solid fa-clock mr-1"></i> <?php echo htmlspecialchars($row['duration']); ?>
                    </div>
                    <?php endif; ?>
                    <div class="buy-amoount text-center mb-3">₹ <?php echo htmlspecialchars($row['price']); ?></div>
                    <a href="payment.php?plan=<?php echo urlencode($row['title']); ?>&price=<?php echo urlencode($row['price']); ?>" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>     

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
