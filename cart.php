<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

/* Add to cart logic */
if (isset($_GET['add'])) {
    $id = (int) $_GET['add'];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart - Manakamana Furniture</title>
    <link rel="icon" href="images/icon.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<h1 class="cart-title">Your Cart</h1>

<div class="cart-wrapper">

<?php if (empty($cart)) { ?>
    <p style="text-align:center;">Your cart is empty. <a href="index.php">Go Shopping</a></p>
<?php } else { ?>

<table class="cart-table">
    <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
    </tr>

    <?php
    foreach ($cart as $id => $qty) {
        $res = $conn->query("SELECT * FROM products WHERE id=$id");
        if ($res && $res->num_rows > 0) {
            $p = $res->fetch_assoc();
            $subtotal = $p['price'] * $qty;
            $total += $subtotal;
            echo "
            <tr>
                <td>{$p['name']}</td>
                <td>{$qty}</td>
                <td>Rs. {$subtotal}</td>
            </tr>";
        }
    }
    ?>

    <tr class="total-row">
        <td colspan="2">Total</td>
        <td>Rs. <?php echo $total; ?></td>
    </tr>
</table>

<div class="cart-actions">
    <a href="index.php" class="btn-secondary">Continue Shopping</a>
    <a href="checkout.php" class="btn-primary">Checkout</a>
</div>

<?php } ?>

</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
