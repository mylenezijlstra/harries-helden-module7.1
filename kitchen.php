<?php
session_start();
include "includes/lang.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        <?= t('kitchen_title') ?>
    </title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="kitchen-screen">

    <div class="kitchen-header">
        <h1>🍳
            <?= t('kitchen_title') ?>
        </h1>
        <div class="kitchen-clock" id="kitchen-clock"></div>
    </div>

    <div class="kitchen-board">

        <!-- Column: Placed & Paid (status 2) -->
        <div class="kitchen-column column-placed">
            <div class="column-header header-placed">
                <span class="column-icon">🟡</span>
                <h2>
                    <?= t('status_placed') ?>
                </h2>
                <span class="column-count" id="count-placed">0</span>
            </div>
            <div class="column-orders" id="orders-placed"></div>
        </div>

        <!-- Column: Preparing (status 3) -->
        <div class="kitchen-column column-preparing">
            <div class="column-header header-preparing">
                <span class="column-icon">🔵</span>
                <h2>
                    <?= t('status_preparing') ?>
                </h2>
                <span class="column-count" id="count-preparing">0</span>
            </div>
            <div class="column-orders" id="orders-preparing"></div>
        </div>

        <!-- Column: Ready for Pickup (status 4) -->
        <div class="kitchen-column column-ready">
            <div class="column-header header-ready">
                <span class="column-icon">🟢</span>
                <h2>
                    <?= t('status_ready') ?>
                </h2>
                <span class="column-count" id="count-ready">0</span>
            </div>
            <div class="column-orders" id="orders-ready"></div>
        </div>

    </div>

    <script>
        const kitchenTranslations = {
            btn_start: "<?= t('btn_start_preparing') ?>",
            btn_ready: "<?= t('btn_mark_ready') ?>",
            btn_picked: "<?= t('btn_picked_up') ?>",
            time_now: "<?= t('time_just_now') ?>",
            time_min: "<?= t('time_min_ago') ?>"
        };
    </script>
    <script src="assets/js/kitchen.js"></script>

</body>

</html>