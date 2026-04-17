<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}
require_once("../db_config.php");

$purchase_id = isset($_GET['purchase_id']) ? (int)$_GET['purchase_id'] : 0;
$user_id     = $_SESSION['user_id'];
$user_name   = $_SESSION['user_name'] ?? 'User';

if (!$purchase_id) {
    header("Location: manage-plans.php");
    exit();
}

// Fetch purchase — must belong to this user
$stmt = $con->prepare("SELECT * FROM user_purchases WHERE id = ? AND user_id = ? LIMIT 1");
$stmt->bind_param("ii", $purchase_id, $user_id);
$stmt->execute();
$purchase = $stmt->get_result()->fetch_assoc();

if (!$purchase) {
    header("Location: manage-plans.php");
    exit();
}

$original_price  = $purchase['price'];
$discount_pct    = (int)($purchase['offer_discount'] ?? 0);
$saved_amount    = 0;
$pre_disc_price  = $original_price;

if ($discount_pct > 0) {
    // Reverse-calculate original price from discounted price
    $pre_disc_price = round($original_price / (1 - $discount_pct / 100));
    $saved_amount   = $pre_disc_price - $original_price;
}

$bill_no = 'HW-' . str_pad($purchase_id, 6, '0', STR_PAD_LEFT);
$date    = date('d M Y', strtotime($purchase['purchase_date']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill #<?php echo $bill_no; ?> — Health &amp; Wellness</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 40px 20px;
            min-height: 100vh;
        }
        .bill-wrapper {
            width: 100%;
            max-width: 700px;
        }
        .btn-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
        }
        .btn-print {
            padding: 12px 28px;
            background: linear-gradient(135deg, #059669, #0d9488);
            color: white;
            border: none;
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(5,150,105,0.3);
            transition: all 0.25s;
        }
        .btn-print:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(5,150,105,0.35); }
        .btn-back {
            padding: 12px 24px;
            background: white;
            color: #475569;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s;
        }
        .btn-back:hover { border-color: #059669; color: #059669; }
        .bill {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        }
        .bill-header {
            background: linear-gradient(135deg, #065f46 0%, #047857 60%, #0d9488 100%);
            padding: 40px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .brand-name {
            font-family: 'Outfit', sans-serif;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .brand-sub { font-size: 13px; opacity: 0.75; margin-top: 4px; }
        .bill-label {
            text-align: right;
        }
        .bill-label h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 2px;
        }
        .bill-label p { font-size: 13px; opacity: 0.8; margin-top: 4px; }
        .bill-body { padding: 36px 40px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px; }
        .info-box label { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        .info-box p { font-size: 15px; font-weight: 600; color: #1e293b; margin-top: 4px; }
        .divider { border: none; border-top: 2px dashed #e2e8f0; margin: 24px 0; }
        .line-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 15px;
        }
        .line-item:last-child { border-bottom: none; }
        .line-item .label { color: #475569; }
        .line-item .amount { font-weight: 600; color: #1e293b; }
        .line-item.discount .amount { color: #059669; }
        .line-item.total {
            padding: 18px 20px;
            background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
            border-radius: 12px;
            margin-top: 12px;
            border: 1px solid #bbf7d0;
        }
        .line-item.total .label { font-size: 17px; font-weight: 700; color: #064e3b; }
        .line-item.total .amount { font-size: 22px; font-weight: 800; color: #047857; }
        .savings-badge {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 700;
            margin-top: 16px;
        }
        .bill-footer {
            background: #f8fafc;
            padding: 24px 40px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .bill-footer p { font-size: 13px; color: #94a3b8; }
        .status-badge {
            background: #dcfce7;
            color: #166534;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
        }
        @media print {
            body { background: white; padding: 0; }
            .btn-bar { display: none !important; }
            .bill { box-shadow: none; border-radius: 0; }
        }
    </style>
</head>
<body>

<div class="bill-wrapper">
    <div class="btn-bar">
        <button onclick="window.print()" class="btn-print">
            🖨️ Print Bill
        </button>
        <a href="manage-plans.php" class="btn-back">← Back to My Plans</a>
    </div>

    <div class="bill">
        <!-- Header -->
        <div class="bill-header">
            <div>
                <div class="brand-name">🌿 Health &amp; Wellness</div>
                <div class="brand-sub">Your trusted wellness partner</div>
            </div>
            <div class="bill-label">
                <h2>INVOICE</h2>
                <p>#<?php echo $bill_no; ?></p>
                <p><?php echo $date; ?></p>
            </div>
        </div>

        <!-- Body -->
        <div class="bill-body">
            <div class="info-grid">
                <div class="info-box">
                    <label>Billed To</label>
                    <p><?php echo htmlspecialchars($user_name); ?></p>
                </div>
                <div class="info-box">
                    <label>Payment Status</label>
                    <p style="color:#059669;">✔ Paid</p>
                </div>
                <div class="info-box">
                    <label>Plan Purchased</label>
                    <p><?php echo htmlspecialchars($purchase['plan_name']); ?></p>
                </div>
                <div class="info-box">
                    <label>Duration</label>
                    <p><?php echo htmlspecialchars($purchase['duration'] ?? '3 Months'); ?></p>
                </div>
            </div>

            <hr class="divider">

            <!-- Line Items -->
            <div>
                <div class="line-item">
                    <span class="label"><?php echo htmlspecialchars($purchase['plan_name']); ?> (Base Price)</span>
                    <span class="amount">₹ <?php echo number_format($pre_disc_price); ?></span>
                </div>

                <?php if ($discount_pct > 0): ?>
                <div class="line-item discount">
                    <span class="label">🎁 Offer Discount (<?php echo $discount_pct; ?>% OFF)</span>
                    <span class="amount">- ₹ <?php echo number_format($saved_amount); ?></span>
                </div>
                <?php endif; ?>

                <div class="line-item">
                    <span class="label">Taxes &amp; Platform Fees</span>
                    <span class="amount">₹ 0</span>
                </div>

                <div class="line-item total">
                    <span class="label">Total Paid</span>
                    <span class="amount">₹ <?php echo number_format($original_price); ?></span>
                </div>

                <?php if ($discount_pct > 0): ?>
                <div class="text-center">
                    <span class="savings-badge">🎉 You saved ₹<?php echo number_format($saved_amount); ?> with this offer!</span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer -->
        <div class="bill-footer">
            <p>Thank you for choosing Health &amp; Wellness. Stay fit, stay healthy!</p>
            <span class="status-badge">✔ PAID</span>
        </div>
    </div>
</div>

</body>
</html>
