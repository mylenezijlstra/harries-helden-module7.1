<?php
session_start();
include "includes/lang.php";
include "includes/db.php";

if(empty($_SESSION['cart'])){
    header("Location: " . lang_url("menu.php"));
    exit();
}

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= t('review_order') ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="review-screen">

<?php include "includes/language_switch.php"; ?>

<div class="review-container">

    <h1><?= t('review_your_order') ?></h1>

    <div class="review-list">

    <?php foreach($_SESSION['cart'] as $id):

        $id = (int)$id;

        $r = $conn->query("
            SELECT p.*, i.filename 
            FROM products p
            LEFT JOIN images i ON p.image_id = i.image_id
            WHERE p.product_id = $id
        ");

        $p = $r->fetch_assoc();
        if(!$p) continue;

        $total += $p['price'];
    ?>

        <div class="review-item">
            <img src="<?= htmlspecialchars($p['filename']) ?>" 
                 alt="<?= htmlspecialchars($p['name']) ?>">

            <div class="review-info">
                <h3><?= htmlspecialchars($p['name']) ?></h3>
                <p>€<?= number_format($p['price'],2) ?></p>
            </div>
        </div>

    <?php endforeach; ?>

    </div>

    <div class="review-total">
        <h2><?= t('total') ?></h2>
        <h2>€<?= number_format($total,2) ?></h2>
    </div>

    <div class="review-actions">
        <form action="<?= lang_url('confirm.php') ?>" method="POST">
            <button class="confirm-btn"><?= t('confirm_order') ?></button>
        </form>

        <a href="<?= lang_url('menu.php') ?>" class="back-btn">
            <?= t('add_more_items') ?>
        </a>
    </div>

</div>

</body>
</html>