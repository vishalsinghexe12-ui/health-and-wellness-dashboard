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

    $membership_id  = (int)($_POST['membership_id'] ?? 0);

    // Fetch duration from plans table
    $duration   = "3 Months";
    $get_dur    = $con->prepare("SELECT duration FROM plans WHERE title = ? LIMIT 1");
    $get_dur->bind_param("s", $plan_name);
    $get_dur->execute();
    $res = $get_dur->get_result();
    if ($row = $res->fetch_assoc()) {
        if (!empty($row['duration'])) $duration = $row['duration'];
    } else if ($membership_id > 0) {
        $get_m_dur = $con->prepare("SELECT duration FROM memberships WHERE id = ? LIMIT 1");
        $get_m_dur->bind_param("i", $membership_id);
        $get_m_dur->execute();
        $res_m = $get_m_dur->get_result();
        if ($row_m = $res_m->fetch_assoc()) {
            if (!empty($row_m['duration'])) $duration = $row_m['duration'];
        }
    }

    // Calculate new start/end dates and status
    $duration_calc = strToLower($duration);
    
    $status = 'Active';
    $start_date_ts = time();
    $start_date = date('Y-m-d H:i:s', $start_date_ts);

    if ($membership_id > 0) {
        $chk_active = $con->prepare("SELECT end_date FROM user_memberships WHERE user_id = ? AND membership_id = ? AND (status = 'Active' OR status = 'Queued') ORDER BY end_date DESC LIMIT 1");
        $chk_active->bind_param("ii", $user_id, $membership_id);
    } else {
        $chk_active = $con->prepare("SELECT end_date FROM user_purchases WHERE user_id = ? AND plan_name = ? AND (status = 'Active' OR status = 'Queued') ORDER BY end_date DESC LIMIT 1");
        $chk_active->bind_param("is", $user_id, $plan_name);
    }
    
    $chk_active->execute();
    $res_active = $chk_active->get_result();

    if ($res_active->num_rows > 0) {
        $row_active = $res_active->fetch_assoc();
        if(!empty($row_active['end_date'])) {
            $latest_end_date = strtotime($row_active['end_date']);
            if ($latest_end_date > $start_date_ts) {
                // Queue the new plan after the latest one ends
                $start_date_ts = $latest_end_date;
                $start_date = date('Y-m-d H:i:s', $start_date_ts);
                $status = 'Queued';
            }
        }
    }

    $end_date_ts = strtotime("+ " . $duration_calc, $start_date_ts);
    if (!$end_date_ts) {
        $end_date_ts = strtotime("+ 1 month", $start_date_ts);
    }
    $end_date = date('Y-m-d H:i:s', $end_date_ts);

    // Insert into user_purchases
    $stmt = $con->prepare("INSERT INTO user_purchases (user_id, plan_name, price, duration, offer_discount, status, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isisisss", $user_id, $plan_name, $final_price, $duration, $offer_discount, $status, $start_date, $end_date);

    header('Content-Type: application/json');
    if ($stmt->execute()) {
        $purchase_id = $con->insert_id;
        
        // Insert into user_memberships if applicable
        if ($membership_id > 0) {
            $mbr_stmt = $con->prepare("INSERT INTO user_memberships (user_id, membership_id, start_date, end_date, status) VALUES (?, ?, ?, ?, ?)");
            $mbr_stmt->bind_param("iisss", $user_id, $membership_id, $start_date, $end_date, $status);
            $mbr_stmt->execute();
        }
        
        echo json_encode(['status' => 'SUCCESS', 'purchase_id' => $purchase_id]);
    } else {
        echo json_encode(['status' => 'ERROR', 'message' => $stmt->error]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ERROR', 'message' => 'Unauthorized']);
}
?>
