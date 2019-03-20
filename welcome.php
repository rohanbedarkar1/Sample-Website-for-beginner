<?php
require("configs/config.php");

if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
    exit();
}


header('Location: ' . SITEROOT . '/dashboard/dashboard');
?>
