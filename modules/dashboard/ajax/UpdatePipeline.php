<?php

require("../../../configs/config.php");


if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}

extract($_POST);

//here we update the the pipeline level and type

$updatePipelineOfProjectQuery = "UPDATE tbl_projects SET level_id ='" . $_POST['levelToBeUpdated'] .
        "',type_id ='" . $_POST['typeId'] . "' WHERE project_id='" . $_POST['dragId'] . "'";
$updatePipelineOfProject = mysqli_query($conn_rw, $updatePipelineOfProjectQuery);

$getNewPipeLineName = comFunctions::getMultiRows("SELECT name 
                                                FROM `master_types`
                                                WHERE id ='".$_POST['typeId']."'");
$getOldPipeLineName = comFunctions::getMultiRows("SELECT name 
                                                FROM `master_types`
                                                WHERE id ='".$_POST['oldPipe']."'");
//testR($getNewPipeLineName);
//testR($getOldPipeLineName);
if ($updatePipelineOfProject) {
    echo "success"."::".$getNewPipeLineName[0]['name']."::".$getOldPipeLineName[0]['name'];
    exit;
    //now update the checks of project
    
} else {
    echo "failure";
}
?>
