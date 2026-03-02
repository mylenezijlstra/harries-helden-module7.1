<?php
header("Content-Type: application/json");
include "../includes/db.php";

// Fetch today's orders with their products and status
$date = date("Y-m-d");

$sql = "
SELECT 
    o.order_id,
    o.pickup_number,
    o.price_total,
    o.datetime,
    o.order_status_id,
    os.description AS status_name
FROM orders o
JOIN order_status os ON o.order_status_id = os.order_status_id
WHERE DATE(o.datetime) = '$date'
AND o.order_status_id IN (2, 3, 4, 5)
ORDER BY o.datetime ASC
";

$result = $conn->query($sql);
$orders = [];

while ($row = $result->fetch_assoc()) {
    $orderId = $row['order_id'];

    // Fetch products for this order
    $prodSql = "
    SELECT p.name, op.price
    FROM order_product op
    JOIN products p ON op.product_id = p.product_id
    WHERE op.order_id = $orderId
    ";
    $prodResult = $conn->query($prodSql);
    $products = [];
    while ($p = $prodResult->fetch_assoc()) {
        $products[] = $p;
    }

    $row['products'] = $products;
    $orders[] = $row;
}

echo json_encode($orders);
