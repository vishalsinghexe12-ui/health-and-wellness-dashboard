<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
$title = "Manage Offers";
$css = "admin.css"; 
ob_start();

require_once("../db_config.php");
$query = "SELECT * FROM offers_discounts ORDER BY created_at DESC";
$result = mysqli_query($con, $query);
?>

<div class="manage-offers-container py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="font-weight-bold m-0" style="color: var(--text-main);">Offers & Discounts</h2>
                <p class="text-muted m-0 mt-1">Manage promotional deals and seasonal discounts.</p>
            </div>
            <a href="add-offer.php" class="btn btn-success px-4 py-2" style="border-radius: 10px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                <i class="fa-solid fa-plus mr-2"></i>Create New Offer
            </a>
        </div>

        <?php if (isset($_SESSION['offer_success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                <i class="fa-solid fa-circle-check mr-2"></i> <?php echo $_SESSION['offer_success']; unset($_SESSION['offer_success']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['offer_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                <i class="fa-solid fa-circle-exclamation mr-2"></i> <?php echo $_SESSION['offer_error']; unset($_SESSION['offer_error']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; overflow: hidden; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="position: relative;">
                            <?php $img = !empty($row['image_path']) ? "../".$row['image_path'] : "../images/offer-placeholder.jpg"; ?>
                            <img src="<?php echo htmlspecialchars($img); ?>" class="card-img-top" style="height: 180px; object-fit: cover;" alt="<?php echo htmlspecialchars($row['title']); ?>">
                            <div style="position: absolute; top: 15px; right: 15px;">
                                <span class="badge <?php echo $row['status'] === 'Active' ? 'badge-success' : 'badge-secondary'; ?> p-2 px-3" style="border-radius: 8px; font-weight: 600; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                    <?php echo $row['status']; ?>
                                </span>
                            </div>
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(0deg, rgba(0,0,0,0.7), transparent); padding: 20px 15px 10px;">
                                <h3 class="text-white m-0" style="font-weight: 800;"><?php echo $row['discount_percentage']; ?>% OFF</h3>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="font-weight-bold mb-2"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="text-muted small flex-grow-1"><?php echo htmlspecialchars($row['description']); ?></p>
                            
                            <div class="d-flex align-items-center mb-3">
                                <i class="fa-regular fa-calendar-check text-success mr-2"></i>
                                <span class="text-muted small">Valid until: <strong class="text-dark"><?php echo date('M j, Y', strtotime($row['valid_until'])); ?></strong></span>
                            </div>

                            <div class="d-flex" style="gap: 10px;">
                                <a href="add-offer.php?edit_id=<?php echo $row['id']; ?>" class="btn btn-outline-success flex-grow-1" style="border-radius: 10px; font-weight: 600;">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                </a>
                                <form action="delete_offer_process.php" method="POST" class="flex-grow-1" onsubmit="return confirm('Are you sure you want to delete this offer?');">
                                    <input type="hidden" name="offer_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-outline-danger w-100" style="border-radius: 10px; font-weight: 600;">
                                        <i class="fa-solid fa-trash mr-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <img src="../images/no-offers.svg" alt="No Offers" style="width: 200px; opacity: 0.5; margin-bottom: 20px;">
                    <h4 class="text-muted">No offers yet.</h4>
                    <p class="text-muted">Start by creating your first promotional deal!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>
