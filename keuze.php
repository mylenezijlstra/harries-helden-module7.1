<?php
session_start();
include "includes/lang.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= t('make_choice') ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="keuze-page">

<?php include "includes/language_switch.php"; ?>

    <img src="assets/img/logo (2).png" class="keuze-logo" alt="Logo">

    <h1><?= t('make_choice') ?></h1>

    <div class="keuze-container">
        <button class="keuze-btn"
            onclick="window.location.href='<?= lang_url("menu.php?type=hier") ?>'">
            <?= t('eat_here') ?>
        </button>

        <button class="keuze-btn"
            onclick="window.location.href='<?= lang_url("menu.php?type=meenemen") ?>'">
            <?= t('take_away') ?>
        </button>
    </div>

</body>
</html>