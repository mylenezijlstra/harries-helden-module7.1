<?php
session_start();
header("Content-Type: application/json");
include "../includes/db.php";

if(empty($_SESSION['cart'])){
    echo json_encode(["error" => "Cart is empty"]);
    exit();
}

$items = [];
$total = 0;

foreach($_SESSION['cart'] as $id){
    $r = $conn->query("SELECT * FROM products WHERE product_id=$id");
    $p = $r->fetch_assoc();
    $items[] = $p;
    $total += $p['price'];
}

echo json_encode([
    "items" => $items,
    "total" => $total
]);
