<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require("../../configs/config.php");
if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}
extract($_POST);
//test($_POST);
$smarty->assign("redmine_assignee", $redmine_assignee['memberships']);

if (isset($_POST['project_id'])) {

    $issueArray = $redmine_client->api('issue')->all(array(
        'project_id' => $redmine_project_id,
        'cf_59' => $_POST['project_id'],
    ));
    $getProjectDetailsAction = comFunctions::getSingleRow("SELECT tp.*
                                                     FROM `tbl_projects` tp
                                                     where project_id = " . $_POST['project_id'] . " limit 1");


    $smarty->assign('getProjectDetailsAction',$getProjectDetailsAction);
//    $smarty->assign("actionItemDetails", "modules/project/actionItemDetails.tpl");
    $smarty->assign("viewActionPopupTable", "modules/action/viewActionPopupTable.tpl");
    $smarty->assign("issueArray", $issueArray['issues']);
    $smarty->display('modules/project/actionItemDetails.tpl');
}
?>
