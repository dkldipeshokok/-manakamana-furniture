<?php
session_start();
include 'config.php';

/* =========================
   CHECK LOGIN
========================= */
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

/* =========================
   GET CART
========================= */
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    echo '
    <div class="checkout-wrapper" style="text-align:center;">
        <h2 class="checkout-title">Your Cart is Empty</h2>
        <p style="font-size: 18px; margin: 20px 0;">You have not added any products to your cart yet.</p>
        <a href="index.php" class="btn-primary">Go Shopping</a>
    </div>
    ';
    exit;
}

/* =========================
   CALCULATE TOTAL
========================= */
$total = 0;
foreach ($cart as $id => $qty) {
    $id = (int)$id;
    $qty = (int)$qty;

    $res = $conn->query("SELECT price FROM products WHERE id = $id");
    if ($res && $p = $res->fetch_assoc()) {
        $total += ($p['price'] * $qty);
    }
}

/* =========================
   TRANSACTION DATA
========================= */
// Generate a unique transaction UUID for every checkout
$transaction_uuid = uniqid('txn_', true);
$_SESSION['transaction_uuid'] = $transaction_uuid;

$product_code = "EPAYTEST";       // UAT product code

$success_url = "http://localhost:8080/manakamana_furniture/success.php";
$failure_url = "http://localhost:8080/manakamana_furniture/failure.php";

/* =========================
   ESEWA SIGNATURE (UAT)
========================= */
$secret_key = "8gBm/:&EnhH.1/q"; // UAT Secret Key (plain text)

$data = "total_amount={$total},transaction_uuid={$transaction_uuid},product_code={$product_code}";

$hash = hash_hmac('sha256', $data, $secret_key, true);
$signature = base64_encode($hash);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout - Manakamana Furniture</title>
    <link rel="icon" href="images/icon.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<h1 class="checkout-title">Checkout</h1>

<div class="checkout-wrapper">

    <p class="checkout-total">
        Total Amount: <strong>Rs. <?= number_format($total, 2) ?></strong>
    </p>

    <!-- =========================
         eSewa Payment Form
    ========================== -->
    <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">

        <input type="hidden" name="amount" value="<?= $total ?>">
        <input type="hidden" name="tax_amount" value="0">
        <input type="hidden" name="total_amount" value="<?= $total ?>">

        <input type="hidden" name="transaction_uuid" value="<?= $transaction_uuid ?>">
        <input type="hidden" name="product_code" value="<?= $product_code ?>">

        <input type="hidden" name="product_service_charge" value="0">
        <input type="hidden" name="product_delivery_charge" value="0">

        <input type="hidden" name="success_url" value="<?= $success_url ?>">
        <input type="hidden" name="failure_url" value="<?= $failure_url ?>">

        <!-- SIGNATURE -->
        <input type="hidden" name="signed_field_names"
               value="total_amount,transaction_uuid,product_code">

        <input type="hidden" name="signature" value="<?= $signature ?>">

        <input type="submit" value="Pay with eSewa" class="esewa-btn">
    </form>

    <!-- -------------------------------
         Direct / Test Payment Option
    -------------------------------- -->
    <form action="success.php" method="POST" style="margin-top: 20px;">
        <input type="hidden" name="total_amount" value="<?= $total ?>">
        <input type="submit" value="Pay Now (Direct to Success)" class="btn-primary">
    </form>

</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
