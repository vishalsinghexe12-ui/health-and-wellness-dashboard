<?php
session_start();
require_once("../db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $plan_name      = $_POST['plan_name'] ?? '';
    $price_raw      = preg_replace("/[^0-9]/", "", $_POST['price'] ?? '0');
    $price          = (int)$price_raw;
    $final_price    = (int)preg_replace("/[^0-9]/", "", $_POST['final_price'] ?? $price_raw);
    $offer_id       = (int)($_POST['offer_id'] ?? 0);
    $offer_discount = (int)($_POST['offer_discount'] ?? 0);
    $user_id        = $_SESSION['user_id'];

    // Fetch duration from plans table
    $duration   = "3 Months";
    $get_dur    = $con->prepare("SELECT duration FROM plans WHERE title = ? LIMIT 1");
    $get_dur->bind_param("s", $plan_name);
    $get_dur->execute();
    $res = $get_dur->get_result();
    if ($row = $res->fetch_assoc()) {
        if (!empty($row['duration'])) $duration = $row['duration'];
    }

    // Use the discounted price as the stored price
    $stmt = $con->prepare("INSERT INTO user_purchases (user_id, plan_name, price, duration, offer_discount, status) VALUES (?, ?, ?, ?, ?, 'Active')");
    $stmt->bind_param("isisi", $user_id, $plan_name, $final_price, $duration, $offer_discount);

    header('Content-Type: application/json');
    if ($stmt->execute()) {
        echo json_encode(['status' => 'SUCCESS', 'purchase_id' => $con->insert_id]);
    } else {
        echo json_encode(['status' => 'ERROR', 'message' => $stmt->error]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ERROR', 'message' => 'Unauthorized']);
}
?>
