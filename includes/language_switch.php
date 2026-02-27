<?php
$currentLang = $_SESSION['lang'] ?? 'nl';
?>

<div class="lang-switch">
    <a href="?lang=nl"
       class="lang-btn <?= $currentLang === 'nl' ? 'active' : '' ?>">
        NL
    </a>

    <a href="?lang=en"
       class="lang-btn <?= $currentLang === 'en' ? 'active' : '' ?>">
        EN
    </a>
</div>