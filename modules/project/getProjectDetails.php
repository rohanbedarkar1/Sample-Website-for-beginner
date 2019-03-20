<?php

require("../../configs/config.php");
if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}
extract($_POST);
//test($_POST);
if (!empty($_POST)) {

    $getAssignedChecks = array();
    $getProjectDetails = array();
    //get the project details
    $getProjectDetails = comFunctions::getSingleRow("SELECT tp.*,tl.name as level_name 
                                                     FROM `tbl_projects` tp
                                                     inner join tbl_levels tl on tp.level_id = tl.id 
                                                     where project_id = " . $_POST['project_id'] . " limit 1");

    
    $getProjectDetails['upload_file_name']=  explode('::',$getProjectDetails['upload_file_name']);
    $userFullname = comFunctions::getSingleRow("SELECT full_name FROM `tbl_users` WHERE username='" . $_SESSION['username'] . "'");

    if (isset($_POST['logTextArea'])) {
        if ($_POST['logTextArea'] != NULL) {
            $insertLogActivityQuery = "INSERT INTO `tbl_activity_log`(`project_id`, `comments`, `level_id`,`by_user`) 
                                VALUES ('" . $_POST['project_id'] . "','" .mysqli_escape_string($conn_rw,nl2br($_POST['logTextArea'])) . "','" . $_POST['levelId'] . "','" . $userFullname['full_name'] . "')";
            $insertLogActivity = mysqli_query($conn_rw, $insertLogActivityQuery);
            if (empty($insertLogActivity)) {
                exit;
            }
        }
    }

    if (isset($_POST['levelId'])) {
        $getAssignedChecksQuery = "SELECT mlc.check_id, mc.description ,mlc.* 
                                FROM `mapping_level_checks` mlc 
                                INNER JOIN master_checks mc ON mc.id=mlc.check_id
                                AND mc.is_del=1
                                WHERE mlc.level_id = '" . $_POST['levelId'] . "'";
        $getAssignedChecks = comFunctions::getMultiRows($getAssignedChecksQuery);
        $comments = comFunctions::getMultiRows("SELECT comments,by_user,updated_on FROM `tbl_activity_log` 
                                            WHERE project_id='" . $_POST['project_id'] . "'
                                            ORDER BY `tbl_activity_log`.`id` DESC");

        $smarty->assign("levelIDForLog", $_POST['levelId']);
        $smarty->assign("comments", $comments);
    }

    $levels = comFunctions::getMultiRows("select tl.id as level_id,tl.name as level_name 
                                           from tbl_levels tl 
                                           inner join mapping_type_levels mtl on mtl.level_id =tl.id 
                                           INNER JOIN tbl_projects tp on tp.type_id = mtl.type_id and tp.project_id = " . $_POST['project_id']);

    if ($_POST['action'] == 'info' || $_POST['action'] == 'log') {
        $getProjectDetails['tam'] = str_replace(",", "", $getProjectDetails['tam']);
        $getProjectDetails['sam'] = str_replace(",", "", $getProjectDetails['sam']);
    }
//    test($getProjectDetails);
   
    $smarty->assign("levels", $levels);

    $smarty->assign("getAssignedChecks", $getAssignedChecks);
    $smarty->assign("getProjectDetails", $getProjectDetails);
    $smarty->assign("pipeLineId", $_POST['pipeLineId']);
    $smarty->assign("actionItemDetails", "modules/project/actionItemDetails.tpl");
    $smarty->assign("viewActionPopupTable", "modules/action/viewActionPopupTable.tpl");

    if ($_POST['action'] == 'info' || $_POST['action'] == 'log') {
        $smarty->display('modules/project/getProjectDetails.tpl');
    } else if ($_POST['action'] == 'edit') {
        $smarty->display('modules/project/editProjectDetails.tpl');
    }
}
?>
