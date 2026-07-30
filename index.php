<?php include 'includes/header.php'; ?>
<?php
session_start();
include 'config.php';
if(!isset($_SESSION['user'])) header("Location: login.php");

$products = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
<title>Manakamana Furniture</title>
<link rel="icon" href="images/icon.png">
<link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Our Products</h1>
<div class="products">
<?php while($row = $products->fetch_assoc()){ ?>
<div class="product-card">
<img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
<h3><?php echo $row['name']; ?></h3>
<p><?php echo $row['description']; ?></p>
<p>Price: Rs. <?php echo $row['price']; ?></p>
<button onclick="location.href='cart.php?add=<?php echo $row['id']; ?>'">
    Add to Cart
</button>
</div>
<?php } ?>
</div>
</body>
</html>
<?php include 'includes/footer.php'; ?>