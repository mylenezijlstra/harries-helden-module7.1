<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Taal zetten via URL */
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

/* Standaard NL */
$lang = $_SESSION['lang'] ?? 'nl';

/* Alleen nl of en toestaan */
if ($lang !== 'nl' && $lang !== 'en') {
    $lang = 'nl';
}

/* Vertaalbestand laden */
$translations = require __DIR__ . "/../lang/" . $lang . ".php";

/* Vertaalfunctie */
function t($key) {
    global $translations;
    return $translations[$key] ?? $key;
}

function lang_url($url){
    global $lang;
    return $url . '?lang=' . $lang;
}