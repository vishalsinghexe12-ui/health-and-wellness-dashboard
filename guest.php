<?php
$title = "Health & Wellness - Home";
$css = "guest.css"; 

require_once("db_config.php");

// Fetch dynamic guest content
$content_query = "SELECT * FROM guest_content WHERE is_active = 1 ORDER BY sort_order ASC";
$content_res = mysqli_query($con, $content_query);

$b_title = "Stay Fit, Stay Healthy!";
$b_sub   = "Enjoy fitness, meal plans, and Wellness Boosts designed to help you live your best life.";
$b_btn   = "Get Started Today";
$b_url   = "register.php";

$tips_cards = [];

while($row = mysqli_fetch_assoc($content_res)) {
    if ($row['section'] == 'banner') {
        $b_title = $row['title'];
        $b_sub   = $row['subtitle'];
        if (!empty($row['button_text'])) $b_btn = $row['button_text'];
        if (!empty($row['button_url']))  $b_url = $row['button_url'];
    } elseif ($row['section'] == 'tip_card') {
        $tips_cards[] = $row;
    }
}

ob_start();
?>

<div class="guest-banner-container">
    <div class="guest-banner-content">
        <h1 class="guest-banner-heading"><?php echo htmlspecialchars($b_title); ?></h1>
        <p class="guest-banner-paragraph"><?php echo htmlspecialchars($b_sub); ?></p>
        <button class="get-started-button shadow-lg" onclick="window.location.href='<?php echo htmlspecialchars($b_url); ?>'"><?php echo htmlspecialchars($b_btn); ?></button>
    </div>
</div>

<?php 
$active_offers_query = "SELECT * FROM offers_discounts WHERE status = 'Active' AND valid_until >= CURDATE() ORDER BY created_at DESC LIMIT 3";
$active_offers_result = mysqli_query($con, $active_offers_query);

if (mysqli_num_rows($active_offers_result) > 0): ?>
<div class="special-offers-section py-5" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <h2 class="font-weight-bold" style="color: var(--text-main); font-size: 32px; font-family: 'Outfit', sans-serif;">Special Offers & Discounts</h2>
                <p class="text-muted" style="font-size: 18px;">Grab these exclusive deals before they expire!</p>
            </div>
            <div class="col-md-4 text-md-right">
                <a href="plans.php" class="btn btn-outline-success px-4 py-2" style="border-radius: 12px; font-weight: 600;">View All Plans</a>
            </div>
        </div>
        <div class="row">
            <?php while($offer = mysqli_fetch_assoc($active_offers_result)): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="offer-card h-100 shadow-sm" style="border-radius: 20px; border: none; overflow: hidden; background: white; transition: all 0.3s ease; position: relative;" onmouseover="this.style.transform='translateY(-10px)';this.style.boxShadow='0 15px 30px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 5px 15px rgba(0,0,0,0.05)'">
                    <div class="offer-image" style="height: 200px; position: relative; overflow: hidden;">
                        <?php $offer_img = !empty($offer['image_path']) ? $offer['image_path'] : "images/offer-placeholder.jpg"; ?>
                        <img src="<?php echo htmlspecialchars($offer_img); ?>" class="w-100 h-100" style="object-fit: cover;" alt="<?php echo htmlspecialchars($offer['title']); ?>">
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(0deg, rgba(0,0,0,0.4), transparent);"></div>
                        <div style="position: absolute; top: 15px; left: 15px;">
                            <span class="badge badge-danger px-3 py-2" style="border-radius: 10px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);">
                                -<?php echo $offer['discount_percentage']; ?>% OFF
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="font-weight-bold mb-2" style="font-family: 'Outfit', sans-serif; color: #1e293b;"><?php echo htmlspecialchars($offer['title']); ?></h4>
                        <p class="text-muted small mb-3" style="line-height: 1.6; height: 48px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                            <?php echo htmlspecialchars($offer['description']); ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="text-muted" style="font-size: 13px;">
                                <i class="fa-regular fa-clock mr-1 text-danger"></i> 
                                Expires: <?php echo date('M j, Y', strtotime($offer['valid_until'])); ?>
                            </span>
                            <a href="register.php?offer_id=<?php echo $offer['id']; ?>" class="btn btn-success btn-sm px-3" style="border-radius: 8px; font-weight: 600;">
                                <i class="fa-solid fa-bolt mr-1"></i> Claim Offer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="guest-card-container py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-5 text-center">
                <h1 class="guest-bottom-heading">Daily Health Tips</h1>
                <hr class="heading-hr mx-auto">
            </div>

            <?php foreach($tips_cards as $idx => $card): ?>
            <!-- Card: <?php echo htmlspecialchars($card['title']); ?> -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="guest-card" data-toggle="modal" data-target="#modalTip<?php echo $card['id']; ?>">
                    <img class="w-100" src="<?php echo htmlspecialchars($card['image_path']); ?>" alt="<?php echo htmlspecialchars($card['title']); ?>" style="height:200px; object-fit:cover; border-radius:12px 12px 0 0; margin-bottom:15px;"/>
                    <h2 class="guest-card-heading"><?php echo htmlspecialchars($card['title']); ?></h2>
                    <p class="guest-card-paragraph" style="display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;"><?php echo htmlspecialchars($card['subtitle']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>

<!-- ================= MODALS ================= -->

<?php foreach($tips_cards as $card): ?>
<!-- Modal: <?php echo htmlspecialchars($card['title']); ?> -->
<div class="modal fade" id="modalTip<?php echo $card['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius:20px; overflow:hidden;">
      <div class="modal-header" style="background:#f8fafc;">
        <h5 class="modal-title font-weight-bold" style="color:#047857;"><?php echo htmlspecialchars($card['title']); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <img src="<?php echo htmlspecialchars($card['image_path']); ?>" class="w-100 mb-4" alt="<?php echo htmlspecialchars($card['title']); ?>" style="border-radius:12px; max-height:400px; object-fit:cover;">
        <div style="font-size:16px; color:#475569; line-height:1.7;">
            <?php echo nl2br(htmlspecialchars($card['body'])); ?>
        </div>
        
        <?php if(!empty($card['button_url'])): ?>
        <div class="text-center mt-4">
            <a href="<?php echo htmlspecialchars($card['button_url']); ?>" class="btn btn-success px-4 py-2" style="border-radius:10px; font-weight:600;"><?php echo !empty($card['button_text']) ? htmlspecialchars($card['button_text']) : 'Learn More'; ?></a>
        </div>
        <?php endif; ?>
      </div>
      <div class="modal-footer" style="border-top:1px solid #f1f5f9;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius:8px;">Close</button>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
