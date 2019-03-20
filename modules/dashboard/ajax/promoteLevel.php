<?php

require("../../../configs/config.php");
if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}
extract($_POST);
// test($_POST);
// $updated_on = explode(" ",$_POST['updated_on']);
// $fifteenDaysBefore_updated_on = explode(" ",$_POST['fifteenDaysBefore_updated_on']); 
// test("SELECT count(*) as count FROM `tbl_activity_log` WHERE `project_id` = ".$_POST['projectId']." and `updated_on` > $fifteenDaysBefore_updated_on[0] and updated_on < $updated_on[0]");
// $validity = comFunctions::getSingleRow("SELECT count(*) as count FROM `tbl_activity_log` WHERE `project_id` = ".$_POST['projectId']." and `updated_on` > '".$fifteenDaysBefore_updated_on[0]."' and updated_on < '".$updated_on[0]."'");
// test($validity);
if($validity['count'] > 0){
	$_SESSION['validity'] = 1;
}else{
	$_SESSION['validity'] = 0;
}

$promoteStatus = comFunctions::getPromoteStatus($_POST['typeId']);
if (!$promoteStatus) {
    $flag = comFunctions::canPromoteToNextLevel($_POST['projectId']);
}else{
    $flag = true;
}
if ($flag) {



    //GET THE NEXT LEVEL IF NEXT LEVEL IS equal to current level THEN ITS THE LAST LEVEL
    $getNextLevel = comFunctions::getNextLevel($_POST['levelId'], $_POST['typeId']);
    if ($getNextLevel != '0' && $getNextLevel != '' && $getNextLevel != NULL) {

        $updateProject = "UPDATE tbl_projects SET level_id ='" . $getNextLevel . "' 
                            WHERE project_id ='" . $_POST['projectId'] . "'";

        $exeUpdateProject = mysqli_query($conn_rw, $updateProject);
        if ($exeUpdateProject) {
            //delete the old checkids 
            $deleteOldCheckIds = "DELETE FROM tbl_check_value WHERE proj_id= '" . $_POST['projectId'] . "'";
            $deleteOldCheck = mysqli_query($conn_rw, $deleteOldCheckIds);
            //now insert new check_ids according to the level ids with incomplete 
            $nextLevelName = comFunctions::getSingleRow("SELECT name FROM `tbl_levels` WHERE id=$getNextLevel");
            $currentLevelName = comFunctions::getSingleRow("SELECT name FROM `tbl_levels` WHERE id='" . $_POST['levelId'] . "'");
            echo "success::" . $currentLevelName['name'] . "::" . $nextLevelName['name']."::".$_SESSION['validity'];
        } else {
            echo "update failed";
        }
    } else {
        echo "no next level";
    }
} else {
    echo "not allow";
}
?>
