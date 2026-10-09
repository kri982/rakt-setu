<?php
/* ============================================================
   RAKT SETU  |  Database Connection
   File: config/db.php
   ============================================================ */

define('DB_HOST', 'sql210.infinityfree.com');
define('DB_USER', 'if0_43131601');
define('DB_PASS', 'krishnqwe');
define('DB_NAME', 'if0_43131601_raktsetu_db');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
date_default_timezone_set('Asia/Kolkata');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
