<?php

require("../../configs/config.php");
//test($_POST);

if (isset($_POST['submit']) == 'submit') {


    //check wheather the role exists or not if not then insert

    $checkRoleExistsQuery = "SELECT * FROM tbl_user_roles WHERE user_id ='" . $_POST['userId'] . "'";
    $checkRoleExists = comFunctions::getSingleRow($checkRoleExistsQuery);

    if (count($checkRoleExists) > 0) {
        //update the 
        $updateRoleQuery = "UPDATE tbl_user_roles tur SET role_id ='" . $_POST['roleId'] . "' 
                            WHERE user_id = '" . $_POST['userId'] . "'";
        $exeUpdateRole = mysqli_query($conn_rw, $updateRoleQuery);
        if ($exeUpdateRole) {
            $_SESSION['successMsg'] = "Role updated  successfully";
        } else {
            $_SESSION['errMsg'] = "Role updation failed";
        }
    } else {
        //insert the role_id
        $insertRoleQuery = "INSERT INTO tbl_user_roles (user_id,role_id) 
                            VALUES ('" . $_POST['userId'] . "','" . $_POST['roleId'] . "')";
        $exeInsertRole = mysqli_query($conn_rw, $insertRoleQuery);

        if ($exeInsertRole) {
            $_SESSION['successMsg'] = "Role added successfully";
        } else {
            $_SESSION['errMsg'] = "Role addition failed";
        }
    }
    header("Location:" . SITEROOT . '/userPermission/userPermissions/');
    exit();
}




$getUserDetail = array();
$getUserDetailsQuery = "SELECT mr.id  ,tu.full_name ,mr.role_name ,tu.user_id
                        FROM tbl_users tu
                        LEFT JOIN tbl_user_roles tur   ON tu.user_id =tur.user_id  
                        LEFT JOIN master_roles mr  ON  tur.role_id =mr.id
                       WHERE tu.user_id ='" . $_POST['userId'] . "'";
$getUserDetail = comFunctions::getSingleRow($getUserDetailsQuery);

$getAllRoles = comFunctions::getAllRecord("master_roles");
$smarty->assign("getAllRoles", $getAllRoles);
$smarty->assign("getUserDetail", $getUserDetail);
$smarty->display('modules/userPermission/editPermission.tpl');
?>
