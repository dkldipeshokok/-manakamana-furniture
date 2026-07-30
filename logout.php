<?php
session_start();

/* Clear cart */
unset($_SESSION['cart']); // <-- This resets the cart

/* Destroy all session data */
session_destroy();

/* Redirect to home or login page */
header("Location: index.php");
exit;
