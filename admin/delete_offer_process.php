<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['offer_id'])) {
    $offer_id = mysqli_real_escape_string($con, $_POST['offer_id']);

    // Fetch image path for deletion
    $res = mysqli_query($con, "SELECT image_path FROM offers_discounts WHERE id='$offer_id'");
    if ($row = mysqli_fetch_assoc($res)) {
        if (!empty($row['image_path']) && file_exists("../" . $row['image_path'])) {
            unlink("../" . $row['image_path']);
        }
    }

    $query = "DELETE FROM offers_discounts WHERE id = '$offer_id'";
    if (mysqli_query($con, $query)) {
        $_SESSION['offer_success'] = "Offer deleted successfully!";
    } else {
        $_SESSION['offer_error'] = "Error deleting offer: " . mysqli_error($con);
    }
}
header("Location: manage-offers.php");
exit();
?>
