<?php
$title = "Premium Memberships";
$css = "register-dashboard.css"; 
ob_start();

require_once("../db_config.php");
$query = "SELECT * FROM memberships WHERE status = 'Active' ORDER BY price ASC";
$result = mysqli_query($con, $query);

// Pre-define styling for specific tiers based on index mapping (simulate Basic/Pro/Elite looks)
$tier_styles = [
    0 => ['theme'=>'#f8fafc', 'border'=>'#e2e8f0', 'text'=>'#1e293b', 'badge'=>''],
    1 => ['theme'=>'#10b981', 'border'=>'#059669', 'text'=>'white', 'badge'=>'Most Popular'],
    2 => ['theme'=>'#0f172a', 'border'=>'#1e293b', 'text'=>'white', 'badge'=>'VIP Access']
];
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container pb-5">
        
        <div class="text-center mb-5 mt-3">
            <span class="badge badge-success mb-2 px-3 py-2" style="border-radius:12px; font-weight:700;">UNLOCK EVERYTHING</span>
            <h1 class="font-weight-bold mb-3" style="color: var(--primary-dark); font-family: 'Outfit', sans-serif; font-size:42px;">Elevate Your Wellness Journey</h1>
            <p class="text-muted" style="font-size:18px; max-width:600px; margin:0 auto;">Get unlimited access to the Private Community, Surprise Rewards, AI Coach, and more. Choose the perfect tier for you.</p>
        </div>

        <div class="row align-items-center justify-content-center">
            <?php 
            $i = 0;
            while($row = mysqli_fetch_assoc($result)): 
                $s = $tier_styles[$i] ?? $tier_styles[0]; // fallback
                $is_featured = ($i === 1);
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow <?php echo $is_featured ? 'shadow-lg' : ''; ?>" style="border-radius: 24px; overflow: hidden; background: <?php echo $s['theme']; ?>; color: <?php echo $s['text']; ?>; border: 1px solid <?php echo $s['border']; ?>; position:relative; <?php if($is_featured) echo 'transform: scale(1.05); z-index:10;'; ?>">
                    
                    <?php if($s['badge']): ?>
                        <div style="position:absolute; top:20px; right:20px; background:rgba(255,255,255,0.2); backdrop-filter:blur(5px); color:<?php echo $s['text']; ?>; font-size:12px; padding:6px 12px; border-radius:30px; font-weight:800; border:1px solid rgba(255,255,255,0.3); text-transform:uppercase; letter-spacing:1px;">
                            <?php echo $s['badge']; ?>
                        </div>
                    <?php endif; ?>

                    <div class="card-body p-5">
                        <h4 class="font-weight-bold mb-1" style="font-family:'Outfit', sans-serif; font-size:24px;"><?php echo htmlspecialchars($row['title']); ?></h4>
                        <p style="opacity:0.8; font-size:14px; min-height:42px;"><?php echo htmlspecialchars($row['description']); ?></p>
                        
                        <div class="my-4">
                            <span style="font-size:46px; font-weight:800; letter-spacing:-1px;">₹<?php echo number_format($row['price']); ?></span>
                            <span style="opacity:0.7; font-weight:600;">/<?php echo $row['duration']; ?></span>
                        </div>

                        <a href="payment.php?membership_id=<?php echo urlencode($row['id']); ?>&price=<?php echo urlencode($row['price']); ?>&title=<?php echo urlencode($row['title']); ?>" 
                           class="btn btn-block py-3 mb-4 font-weight-bold" 
                           style="border-radius:12px; font-size:16px; <?php echo $is_featured ? 'background:white; color:#065f46;' : 'background:linear-gradient(135deg,#059669,#0d9488); color:white;'; ?> box-shadow:0 8px 20px rgba(0,0,0,0.1);">
                           Start <?php echo htmlspecialchars($row['title']); ?>
                        </a>

                        <div>
                            <strong class="d-block mb-3" style="font-size:12px; text-transform:uppercase; letter-spacing:1px; opacity:0.6;">What's Included</strong>
                            <ul class="list-unstyled mb-0" style="font-size:15px; font-weight:500;">
                                <?php 
                                $features = explode(',', $row['features']);
                                foreach($features as $f): 
                                    if(trim($f)):
                                ?>
                                    <li class="mb-3 d-flex align-items-start">
                                        <i class="fa-solid fa-circle-check mt-1 mr-3" style="<?php echo $is_featured ? 'color:white; opacity:0.9;' : 'color:#10b981;'; ?>"></i>
                                        <span style="opacity:0.9;"><?php echo htmlspecialchars(trim($f)); ?></span>
                                    </li>
                                <?php endif; endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            $i++;
            endwhile; 
            ?>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
