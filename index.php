<?php
session_start();
include "includes/lang.php";

/* Maak array met 1 t/m 25 */
$images = range(1, 25);

/* Shuffle voor random volgorde */
shuffle($images);

/* Pak eerste 6 voor slideshow */
$images = array_slice($images, 0, 6);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Happy Herbivore</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="start-screen">

<?php include "includes/language_switch.php"; ?>

<!-- SLIDESHOW -->
<div class="slideshow">
    <?php foreach ($images as $index => $num): ?>
        <div class="slide <?= $index === 0 ? 'active' : '' ?>">
            <img src="assets/img/eten<?= $num; ?>.png" alt="Eten">
        </div>
    <?php endforeach; ?>
</div>

<!-- CONTENT -->
<div class="start-container">
    <img src="./assets/img/logo (2).png" class="logo" alt="Happy Herbivore Logo">

    <h1><?= t('welcome') ?></h1>
    <h2><?= t('healthy') ?></h2>

    <a href="<?= lang_url('keuze.php') ?>" class="start-button">
        <?= t('touch_order') ?>
    </a>

   <p class="tagline"><?= t('tagline') ?></p>
</div>

<!-- SLIDESHOW SCRIPT -->
<script>
let slides = document.querySelectorAll(".slide");
let current = 0;

if (slides.length > 1) {
    setInterval(() => {
        slides[current].classList.remove("active");
        current = (current + 1) % slides.length;
        slides[current].classList.add("active");
    }, 4000);
}
</script>

</body>
</html>