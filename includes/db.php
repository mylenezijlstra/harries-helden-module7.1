<?php
$host = "localhost";
$user = "u240381_kiosk";
$pass = "EphKV8PcGPQzH64r3KtY";
$dbname = "u240381_kiosk";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
