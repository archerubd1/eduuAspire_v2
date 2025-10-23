<?php
// ------------------------------
// CONFIG FILE
// ------------------------------

// Detect if running on localhost
$is_localhost = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) 
    || strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;

// Base URL and path depending on environment
if ($is_localhost) {
    // ✅ Adjust these according to your folder name and DB name
    $base_url  = 'http://localhost/eduuAspire_v2';           // For local development
    $base_path = $_SERVER['DOCUMENT_ROOT'] . '/eduuAspire_v2'; // Correct local path
    $db_host   = 'localhost';
    $db_name   = 'eduuaspire';                               // ✅ New DB name
    $db_user   = 'root';
    $db_pass   = 'root';                                          // Usually blank on UwAmp/XAMPP
} else {
    // ✅ Live server details
    $base_url  = 'https://www.eduuaspire.online';
    $base_path = $_SERVER['DOCUMENT_ROOT'];
    $db_host   = 'localhost';
    $db_name   = 'eduuaspire';                               // ✅ Same DB name live
    $db_user   = 'reLxpAdmin';
    $db_pass   = 'Relxp@1111#';
}

// ------------------------------
// Canonical URL (auto-generate if not set)
// ------------------------------
if (!isset($canonical_url)) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host     = $_SERVER['HTTP_HOST'];
    $uri      = $_SERVER['REQUEST_URI'];
    $canonical_url = $protocol . $host . strtok($uri, '?'); // remove query params
}

// ------------------------------
// Database connection
// ------------------------------
$coni = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$coni) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// ------------------------------
// Timezone
// ------------------------------
date_default_timezone_set("Asia/Kolkata");
?>
