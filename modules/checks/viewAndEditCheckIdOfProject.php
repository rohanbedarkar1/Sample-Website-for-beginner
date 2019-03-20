<?php

require("../../configs/config.php");
extract($_POST);
if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}
//test($_POST);
if (!empty($_POST)) {
    //check if the data for this project and check id is present or not

    $recievedcheckId = sprintf("%02d", $_POST['check_id']);
    $dbCheckId = "ck" . $recievedcheckId;
//   echo "<br/>";
    $chkData = "SELECT tcv.check_id ,tcv.proj_id ,tcv.value ,tp.project_name,tp.level_id,mc.name,mc.description
               FROM tbl_check_value tcv 
               INNER JOIN tbl_projects tp ON tp.project_id =tcv.proj_id
               INNER JOIN master_checks mc ON mc.id ='" . $_POST['check_id'] . "'
               WHERE tcv.proj_id ='" . $_POST['project_id'] . "' 
                   AND tcv.check_id ='" . $_POST['check_id'] . "';";
    
    $exeChkData = comFunctions::getSingleRow($chkData);
//    test($exeChkData);
    if (count($exeChkData) > 0) {
        //i.e data is present and it needs to be edited
        $smarty->assign("chkData", $exeChkData);
    } else {
        //if no data then get only desciption and project name
        $getProjectName =  comFunctions::getAllRecord("tbl_projects", "project_name", "project_id='".$_POST['project_id']."'");
        $getLevelId =  comFunctions::getAllRecord("tbl_projects", "level_id", "project_id='".$_POST['project_id']."'");
        $getChkIdInfo = comFunctions::getAllRecord("master_checks", "description", "id='" . $_POST['check_id'] . "'");
        $getChkIdName = comFunctions::getAllRecord("master_checks", "name", "id='" . $_POST['check_id'] . "'");
        
        $exeChkData['check_id'] = $_POST['check_id'];
        $exeChkData['proj_id'] = $_POST['project_id'];
        $exeChkData['description'] = $getChkIdInfo[0]['description'];
        $exeChkData['name'] = $getChkIdName[0]['name'];
        $exeChkData['project_name'] = $getProjectName[0]['project_name'];
        $exeChkData['level_id'] = $getLevelId[0]['level_id'];
        $exeChkData['value'] = "";
        $smarty->assign("chkData", $exeChkData);
    }
    $smarty->assign("pipeId",$_POST['pipe_id']);
    $smarty->display('modules/checks/viewAndEditCheckIdOfProject.tpl');
}
?>
