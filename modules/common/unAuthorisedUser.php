<?php
require("../../configs/config.php");

if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}

$smarty->display('common/unAuthorisedUser.tpl');
?>
