<?php

require("../../configs/config.php");
extract($_POST);
if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}
//test($_POST);
$getOldChecksQuery = "SELECT mc.id ,mlc.is_active
                        FROM master_checks mc 
                        INNER JOIN mapping_level_checks mlc ON mlc.check_id = mc.id
                        INNER JOIN tbl_levels tl ON tl.id = mlc.level_id
                        WHERE tl.id ='" . $_POST['levelId'] . "' ";

$getOldChecks = comFunctions::getMultiRows($getOldChecksQuery);
//test($getOldChecks);
if (!empty($_POST['check'])) {                   //if the list has some new and old checks
    $checks = $_POST['check'];
    //now get the old checks list

    if (!empty($getOldChecks)) {
        //if the old checks and new checks are the same then do not do any operation
        //creating a temp array for compare
        $oldCheckArray = array();
        $compareCheck = array();
        foreach ($getOldChecks as $newCheck) {
            if ($newCheck['is_active'] == 1) {
                array_push($oldCheckArray, $newCheck['id']);
            } else {
                continue;
            }
        }

        if (count($oldCheckArray) > count($checks)) {
            $compareCheck = array_diff($oldCheckArray, $checks);
        } else {
            $compareCheck = array_diff($checks, $oldCheckArray);
        }

        if (empty($compareCheck)) {
            $_SESSION['successMsg'] = "Successfully saved all the checks ";
            header("Location:" . SITEROOT . '/settings/setting/');
            exit();
        }



        foreach ($getOldChecks as $oldCheck) {
            //if check active 
            if ($oldCheck['is_active'] == 1) {

                if (!in_array($oldCheck['id'], $checks)) {
                    //now get the id id of this check id
                    // $getId = comFunctions::getAllRecord("master_checks", "id", "check_id='" . $oldCheck['check_id'] . "'");
                    //if old check not in new array it means it has been deleted
                    $deactivateOldCheck = "UPDATE  mapping_level_checks  SET is_active = 0
                                    WHERE level_id ='" . $_POST['levelId'] . "'
                                    AND check_id ='" . $oldCheck['id'] . "'";

                    $exeDeactivateOldCheck = mysqli_query($conn_rw, $deactivateOldCheck);
                }
            } else if ($oldCheck['is_active'] == 0) {

                if (in_array($oldCheck['id'], $checks)) {

                    $activateOldCheck = "UPDATE  mapping_level_checks  SET is_active = 1
                                    WHERE level_id ='" . $_POST['levelId'] . "'
                                    AND check_id ='" . $oldCheck['id'] . "'";

                    $exeActivateOldCheck = mysqli_query($conn_rw, $activateOldCheck);
                }
            }
        }
    }
    //---------------finished deleting old checks
    if (!empty($checks)) {
        //now insert the new checks
        $i = 0;
        $j = 0;
        foreach ($getOldChecks as $oldCheckIds) { //preparing temporary oldcheckIds list
            $oldCheckIdList[$j] = $oldCheckIds['id'];
            $j++;
        }
//        test($oldCheckIdList);
        foreach ($checks as $check) {

            if (!in_array($check, $oldCheckIdList)) {
                //now insert the check
                // $getId = comFunctions::getAllRecord("master_checks", "id", "check_id='" . $check . "'");
                $insertNewCheck = "INSERT INTO mapping_level_checks( level_id, check_id) 
                            VALUES ('" . $_POST['levelId'] . "','" . $check . "')";
                $exeInsertNewCheck = mysqli_query($conn_rw, $insertNewCheck);
            }
        }
    }

    if ((isset($exeInsertNewCheck) && $exeInsertNewCheck) || isset($exeDeactivateOldCheck) && $exeDeactivateOldCheck || isset($exeActivateOldCheck) && $exeActivateOldCheck) {
        $_SESSION['successMsg'] = "Successfully linked checks with stages";
        header("Location:" . SITEROOT . '/settings/setting/');
//        header("Location:" . SITEROOT);
        exit();
    } else {
        $_SESSION['errMsg'] = "Something went wrong , checks not updated";
        header("Location:" . SITEROOT . '/settings/setting/');
        exit();
    }
} else {

    //if all the checks are deleted then the  pipeline level has to delete its old all the checks
    //check if it had old checks if yes then delete that checks

    if (!empty($getOldChecks)) {
        $deleteOldChecks = "UPDATE mapping_level_checks SET is_active = 0 WHERE level_id ='" . $_POST['levelId'] . "'";
        $exeDeleteAllChecks = mysqli_query($conn_rw, $deleteOldChecks);


        if ($exeDeleteAllChecks) {

            $_SESSION['successMsg'] = "Successfully unlinked all the checks";
            header("Location:" . SITEROOT . '/settings/setting/');
            exit();
        }
    }
}
?>
