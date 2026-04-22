<?php
$title = "Plans - Health & Wellness";
$css = "guest.css"; 
ob_start();

require_once("db_config.php");

$page_query = "SELECT PageTitle, PageDescription FROM tblpage WHERE PageType = 'plans'";
$page_result = mysqli_query($con, $page_query);
$page_data = mysqli_fetch_assoc($page_result);
$page_title = $page_data['PageTitle'] ?? 'Our Wellness Plans';
$page_desc = $page_data['PageDescription'] ?? '';

$query = "SELECT * FROM plans WHERE type = 'Wellness' AND status = 'Active'";
$result = mysqli_query($con, $query);
?>

<div class="guest-plans-container py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-5 text-center">
                <h1 class="guest-bottom-heading"><?php echo htmlspecialchars($page_title); ?></h1>
                <?php if(!empty($page_desc)): ?>
                    <p class="text-muted mt-2 mx-auto" style="max-width: 600px; font-size: 16px;"><?php echo nl2br(htmlspecialchars($page_desc)); ?></p>
                <?php endif; ?>
                <hr class="heading-hr mx-auto mt-4">
            </div>
            
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <!-- Plan Card -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="plan-card text-center h-100 d-flex flex-column">
                    <?php $img = !empty($row['image_path']) ? $row['image_path'] : "images/beautiful-girls-are-playing-yoga-park.jpg"; ?>
                    <img src="<?php echo htmlspecialchars($img); ?>" class="w-100 plan-img mb-3" style="height:250px; object-fit:cover;" alt="<?php echo htmlspecialchars($row['title']); ?>"/>
                    <h2 class="guest-card-heading"><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p class="guest-card-paragraph mt-3 flex-grow-1"><?php echo htmlspecialchars($row['description']); ?></p>
                    <p class="guest-card-paragraph text-primary font-weight-bold">Duration: <?php echo htmlspecialchars($row['duration']); ?></p>
                    <p class="guest-card-paragraph mb-4">Goal: <?php echo htmlspecialchars($row['category']); ?></p>
                    <a href="user/payment.php?plan=<?php echo urlencode($row['title']); ?>&price=<?php echo urlencode($row['price']); ?>" class="get-started-button d-inline-block text-decoration-none mt-auto">Buy Now (₹<?php echo htmlspecialchars($row['price']); ?>)</a>
                </div>
            </div>
            <?php endwhile; ?>

        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
