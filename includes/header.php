<?php
if(!isset($pageTitle)) {
    $pageTitle = "Happy Herbivore";
}
?>

<div class="kiosk-header">

    <div class="header-left">
        <img src="./assets/img/logo.png" class="header-logo">
    </div>

    <div class="header-center">
        <h1><?= $pageTitle ?></h1>
    </div>

    <div class="header-right">
        <button class="lang-btn">NL</button>
        <a href="index.php" class="cancel-btn">Cancel</a>
    </div>

</div>
