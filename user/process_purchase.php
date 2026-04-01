<?php
session_start();
require_once("../db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $plan_name = $_POST['plan_name'] ?? '';
    // Strip everything except numbers from price if someone passed "1,999" or format
    $price_clean = preg_replace("/[^0-9]/", "", $_POST['price'] ?? '0');
    $price = (int)$price_clean;
    $user_id = $_SESSION['user_id'];

    $stmt = $con->prepare("INSERT INTO user_purchases (user_id, plan_name, price, status) VALUES (?, ?, ?, 'Active')");
    $stmt->bind_param("isi", $user_id, $plan_name, $price);
    
    if($stmt->execute()){
        echo "SUCCESS";
    } else {
        echo "ERROR";
    }
}
?>
