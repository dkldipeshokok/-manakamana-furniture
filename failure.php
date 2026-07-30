<?php
session_start();
include 'config.php';

/* Clear the cart on failed payment */
unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Failed - Manakamana Furniture</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="checkout-wrapper">
    <h1 class="checkout-title" style="color: #dc3545;">Payment Failed!</h1>
    <p style="font-size: 18px; margin: 20px 0;">Your payment was not completed. Please try again.</p>
    <a href="index.php" class="btn-primary">Back to Home</a>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
