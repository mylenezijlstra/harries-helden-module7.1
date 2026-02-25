<?php
session_start();
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="menu-screen">



<div class="sidebar">

    <div class="logo">
        <img src="assets/img/logo (2).png" alt="Logo">
    </div>

    <h3>Categories</h3>
    <div id="category-list"></div>

</div>

<div class="products" id="product-list"></div>

<div class="bottom-bar">
    <div id="cart-info">
        <strong>0 items</strong> €0.00
    </div>

    <a href="review.php" class="review-order">Review Order</a>
</div>

<script src="assets/js/app.js"></script>

<div id="popup-overlay" class="popup-overlay" style="display:none;">
    <div id="popup" class="popup"></div>
</div>


</body>
</html>
