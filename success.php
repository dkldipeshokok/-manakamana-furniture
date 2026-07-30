<?php
session_start();
include 'config.php';

/* Clear the cart after successful payment */
unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful - Manakamana Furniture</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="checkout-wrapper">
    <h1 class="checkout-title" style="color: #28a745;">Payment Successful!</h1>
    <p style="font-size: 18px; margin: 20px 0;">Thank you for purchasing from Manakamana Furniture.</p>
    <a href="index.php" class="btn-primary">Back to Home</a>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
