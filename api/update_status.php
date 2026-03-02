<?php
header("Content-Type: application/json");
include "../includes/db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['order_id']) || !isset($data['new_status_id'])) {
    echo json_encode(["error" => "Missing order_id or new_status_id"]);
    exit;
}

$orderId = intval($data['order_id']);
$newStatus = intval($data['new_status_id']);

// Only allow valid status transitions: 2->3, 3->4, 4->5
$allowed = [2 => 3, 3 => 4, 4 => 5];

// Get current status
$result = $conn->query("SELECT order_status_id FROM orders WHERE order_id = $orderId");
$order = $result->fetch_assoc();

if (!$order) {
    echo json_encode(["error" => "Order not found"]);
    exit;
}

$currentStatus = (int) $order['order_status_id'];

if (!isset($allowed[$currentStatus]) || $allowed[$currentStatus] !== $newStatus) {
    echo json_encode(["error" => "Invalid status transition"]);
    exit;
}

$conn->query("UPDATE orders SET order_status_id = $newStatus WHERE order_id = $orderId");

echo json_encode(["success" => true, "order_id" => $orderId, "new_status_id" => $newStatus]);
