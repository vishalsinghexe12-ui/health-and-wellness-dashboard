<?php
$title = "Exercise Plans";
$css = "register-dashboard.css"; 
ob_start();

require_once("../db_config.php");
$query = "SELECT * FROM plans WHERE type = 'Exercise' AND status = 'Active'";
$result = mysqli_query($con, $query);

// Check if an offer is being claimed
$active_offer = null;
if (!empty($_GET['offer_id'])) {
    $oid = (int)$_GET['offer_id'];
    $offer_res = mysqli_query($con, "SELECT * FROM offers_discounts WHERE id = $oid AND status = 'Active' AND valid_until >= CURDATE() LIMIT 1");
    if ($offer_res && mysqli_num_rows($offer_res) > 0) {
        $active_offer = mysqli_fetch_assoc($offer_res);
    }
}
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="font-weight-bold mb-2" style="color: var(--primary-dark);">Fitness Exercise Plans</h2>
            <p class="text-muted">Expertly designed workout routines for maximum results.</p>
        </div>

        <?php if ($active_offer): ?>
        <!-- Offer Banner -->
        <div class="alert border-0 shadow-sm mb-5 d-flex align-items-center" style="border-radius: 16px; background: linear-gradient(135deg, #065f46, #047857); color: white; padding: 20px 25px;">
            <div style="width:55px; height:55px; border-radius:12px; background:rgba(255,255,255,0.15); display:flex; align-items:center; justify-content:center; margin-right:18px; flex-shrink:0;">
                <i class="fa-solid fa-tag" style="font-size:24px;"></i>
            </div>
            <div class="flex-grow-1">
                <h5 class="font-weight-bold mb-1">🎉 <?php echo htmlspecialchars($active_offer['title']); ?> Applied!</h5>
                <p class="mb-0" style="opacity:0.9;"><?php echo htmlspecialchars($active_offer['description']); ?> &mdash; <strong><?php echo $active_offer['discount_percentage']; ?>% OFF</strong> on all plans below.</p>
                <small style="opacity:0.7;">Valid until: <?php echo date('M j, Y', strtotime($active_offer['valid_until'])); ?></small>
            </div>
            <span class="badge" style="background:rgba(255,255,255,0.2); font-size:18px; font-weight:800; padding:10px 18px; border-radius:10px; white-space:nowrap;">
                -<?php echo $active_offer['discount_percentage']; ?>% OFF
            </span>
        </div>
        <?php endif; ?>
        
        <div class="row g-4">
            <?php while($row = mysqli_fetch_assoc($result)): 
                $original_price = (int)$row['price'];
                $display_price = $original_price;
                if ($active_offer) {
                    $display_price = round($original_price * (1 - $active_offer['discount_percentage'] / 100));
                }
                $offer_param = $active_offer ? '&offer_id=' . $active_offer['id'] : '';
            ?>
            <!-- Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="stat-card h-100 d-flex flex-column" style="padding: 15px; position:relative;">
                    <?php if ($active_offer): ?>
                    <div style="position:absolute; top:10px; right:10px; background:#ef4444; color:white; border-radius:8px; padding:4px 10px; font-size:12px; font-weight:700; z-index:2;">
                        -<?php echo $active_offer['discount_percentage']; ?>%
                    </div>
                    <?php endif; ?>
                    <?php $img = !empty($row['image_path']) ? "../".$row['image_path'] : "../Exercise-Images/Weight loss fitness.jpg"; ?>
                    <img src="<?php echo htmlspecialchars($img); ?>" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">
                    <h4 class="font-weight-bold" style="color: var(--text-main);"><?php echo htmlspecialchars($row['title']); ?></h4>
                    <p class="text-muted flex-grow-1" style="font-size:14px;"><?php echo htmlspecialchars($row['description']); ?></p>
                    <div class="d-flex justify-content-between text-muted mb-2 font-weight-bold" style="font-size:13px;">
                        <span>Intensity: <?php echo htmlspecialchars($row['intensity']); ?></span>
                        <span><?php echo htmlspecialchars($row['duration']); ?></span>
                    </div>
                    <div class="text-center mb-3">
                        <?php if ($active_offer): ?>
                            <span class="text-muted" style="text-decoration:line-through; font-size:14px;">₹ <?php echo number_format($original_price); ?></span>
                            <div class="buy-amoount" style="color:#ef4444;">₹ <?php echo number_format($display_price); ?></div>
                        <?php else: ?>
                            <div class="buy-amoount">₹ <?php echo htmlspecialchars($row['price']); ?></div>
                        <?php endif; ?>
                    </div>
                    <a href="payment.php?plan=<?php echo urlencode($row['title']); ?>&price=<?php echo urlencode($row['price']); ?><?php echo $offer_param; ?>" class="btn btn-success btn-block text-white" style="border-radius: 8px;">Buy Now</a>
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
