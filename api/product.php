<?php
header("Content-Type: application/json");
include "../includes/db.php";

$id = intval($_GET['id']);

$sql = "
    SELECT product_id, name, kcal, price, ingredienten, image_id
    FROM products
    WHERE product_id = $id
";

$q = $conn->query($sql);

if (!$q) {
    echo json_encode([
        "error" => true,
        "message" => $conn->error,
        "sql" => $sql
    ]);
    exit;
}

$product = $q->fetch_assoc();

// afbeelding ophalen
$img = $conn->query("SELECT filename FROM images WHERE image_id = " . $product['image_id']);
$image = $img ? $img->fetch_assoc() : null;

$product['filename'] = $image ? $image['filename'] : null;

echo json_encode($product);
