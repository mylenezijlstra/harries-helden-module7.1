<?php
session_start();
include "includes/lang.php";
include "includes/db.php";

if (empty($_SESSION['cart'])) {
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

            <?php foreach ($_SESSION['cart'] as $id):

                $id = (int) $id;

                $r = $conn->query("
            SELECT p.*, i.filename 
            FROM products p
            LEFT JOIN images i ON p.image_id = i.image_id
            WHERE p.product_id = $id
        ");

                $p = $r->fetch_assoc();
                if (!$p)
                    continue;

                $total += $p['price'];
                ?>

                <div class="review-item">
                    <img src="<?= htmlspecialchars($p['filename']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">

                    <div class="review-info">
                        <h3><?= htmlspecialchars($p['name']) ?></h3>
                        <p>€<?= number_format($p['price'], 2) ?></p>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

        <div class="review-total">
            <h2><?= t('total') ?></h2>
            <h2 id="display-total">€<?= number_format($total, 2) ?></h2>
        </div>

        <!-- DONATION SECTION -->
        <div class="donation-section">
            <h2><?= t('donation_title') ?></h2>
            <p><?= t('donation_description') ?></p>

            <div class="donation-options">

                <label class="donation-card" data-amount="0.50">
                    <input type="radio" name="donation" value="0.50">
                    <span class="donation-icon">🌱</span>
                    <span class="donation-label"><?= t('donation_charity') ?></span>
                    <span class="donation-price">+ €0,50</span>
                </label>

                <label class="donation-card" data-amount="1.00">
                    <input type="radio" name="donation" value="1.00">
                    <span class="donation-icon">🌍</span>
                    <span class="donation-label"><?= t('donation_eco') ?></span>
                    <span class="donation-price">+ €1,00</span>
                </label>

                <label class="donation-card selected" data-amount="0">
                    <input type="radio" name="donation" value="0" checked>
                    <span class="donation-icon">😊</span>
                    <span class="donation-label"><?= t('donation_none') ?></span>
                    <span class="donation-price">€0,00</span>
                </label>

            </div>
        </div>

        <div class="review-actions">
            <form action="<?= lang_url('confirm.php') ?>" method="POST">
                <input type="hidden" name="donation_amount" id="donation-amount" value="0">
                <button class="confirm-btn"><?= t('confirm_order') ?></button>
            </form>

            <a href="<?= lang_url('menu.php') ?>" class="back-btn">
                <?= t('add_more_items') ?>
            </a>
        </div>

    </div>

    <script>
        const baseTotal = <?= $total ?>;
        const cards = document.querySelectorAll('.donation-card');
        const displayTotal = document.getElementById('display-total');
        const donationInput = document.getElementById('donation-amount');

        cards.forEach(card => {
            card.addEventListener('click', () => {
                cards.forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                card.querySelector('input').checked = true;

                const donation = parseFloat(card.dataset.amount);
                donationInput.value = donation;
                const newTotal = baseTotal + donation;
                displayTotal.textContent = '€' + newTotal.toFixed(2);
            });
        });
    </script>

</body>

</html>