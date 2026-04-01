<?php
session_start();
require_once("../db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $plan_name = $_POST['plan_name'] ?? '';
    // Strip everything except numbers from price if someone passed "1,999" or format
    $price_clean = preg_replace("/[^0-9]/", "", $_POST['price'] ?? '0');
    $price = (int)$price_clean;
    $user_id = $_SESSION['user_id'];

    // Fetch duration from plans table
    $duration = "3 Months"; // Default
    $get_duration = $con->prepare("SELECT duration FROM plans WHERE title = ? LIMIT 1");
    $get_duration->bind_param("s", $plan_name);
    $get_duration->execute();
    $res = $get_duration->get_result();
    if($row = $res->fetch_assoc()){
        if(!empty($row['duration'])) $duration = $row['duration'];
    }

    $stmt = $con->prepare("INSERT INTO user_purchases (user_id, plan_name, price, duration, status) VALUES (?, ?, ?, ?, 'Active')");
    $stmt->bind_param("isis", $user_id, $plan_name, $price, $duration);
    
    if($stmt->execute()){
        echo "SUCCESS";
    } else {
        echo "ERROR";
    }
}
?>
