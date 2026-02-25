<?php
header("Content-Type: application/json");
include "../includes/db.php";

$result = $conn->query("SELECT * FROM categories");
$rows = [];

while($r = $result->fetch_assoc()){
    $rows[] = $r;
}

echo json_encode($rows);
