<?php
session_start();
include "includes/lang.php";
$_SESSION['cart'][] = $_GET['id'];
?>
