<?php
session_start();
header("Content-Type: application/json");

if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$data = json_decode(file_get_contents("php://input"), true);

if(isset($data['product_id'])){
    $_SESSION['cart'][] = $data['product_id'];
}

echo json_encode([
    "count" => count($_SESSION['cart']),
    "cart" => $_SESSION['cart']
]);
