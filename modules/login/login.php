<?php
require("../../configs/config.php");

if (isset($_SESSION['username'])) {
    header('Location: '.SITEROOT.'/dashboard/dashboard');
}
$smarty->assign('dbName',$_SESSION['TestSession']);
$smarty->assign('app',$_SESSION['application']);
$smarty->assign('redmine_project_id',$_SESSION['redmine_project_id']);
$smarty->display('modules/login/login.tpl');
unset($_SESSION['errMsg']);
?>