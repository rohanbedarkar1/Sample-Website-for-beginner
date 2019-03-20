<?php

require("../../configs/config.php");
if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}
//test($_SESSION);
comFunctions::isAccessPermission($_SESSION['role']);
if ($_POST && isset($_POST['deleteFlag']) && $_POST['deleteFlag'] != NULL) {
    $deleteUserQuery = "UPDATE `tbl_users` SET `is_active`=0 WHERE user_id='" . $_POST['userId'] . "'";
    $deleteUser = mysqli_query($conn_rw, $deleteUserQuery);
}

if (isset($_POST['submit']) == 'submit') {

    extract($_POST);
    $userDetailsReq = '';

    $checkUserHistoryQuery = "SELECT * from tbl_users where user_id='" . $_POST['userId'] . "'";
    $checkUserHistory = comFunctions::getSingleRow($checkUserHistoryQuery);
    if (!empty($checkUserHistory)) {
        //check user status
        $userStatus = comFunctions::getSingleRow("SELECT is_active FROM tbl_users where user_id='" . $_POST['userId'] . "'");
        if ($userStatus['is_active'] == 1) {
            $full_name = $checkUserHistory['full_name'];
            $_SESSION['errMsg'] = "$full_name is already added to user's list.";
        } else {
            $updateUserQuery = "UPDATE `tbl_users` SET `is_active`= 1 WHERE user_id='" . $_POST['userId'] . "'";
            $updateUser = mysqli_query($conn_rw, $updateUserQuery);
            if (empty($updateUser)) {
                $_SESSION['errMsg'] = "User Addition failed";
            } else {
                $updateUserRoleQuery = "UPDATE `tbl_user_roles` SET `role_id`='" . $_POST['roleId'] . "' WHERE user_id='" . $_POST['userId'] . "'";
                $updateUserRole = mysqli_query($conn_rw, $updateUserRoleQuery);
                if (empty($updateUserRole)) {
                    $_SESSION['errMsg'] = "User Added but assigning role failed";
                } else {
                    $_SESSION['successMsg'] = "User added and assigned role  successfully";
                }
            }
        }
    } else {
        # LDAP Authentication Starts
        $ldap_host = "";
        $base_dn = "DC=domain,DC=com";

        $ldap_user = $_SESSION['username'] . "@domain";
        $ldap_pass = comFunctions::getDecrptPass($_SESSION['password']);
        $connect = ldap_connect($ldap_host);
        if ($connect === FALSE) {
            $_SESSION['errMsg'] = "Could not connect to LDAP";
            header('Location:' . SITEROOT . '/userPermission/userPermissions/');
            exit();
        }
        ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
        $bind = ldap_bind($connect, $ldap_user, $ldap_pass); // or exit(">>Could not bind to $ldap_host<<");
        if ($bind === FALSE) {
            $_SESSION['errMsg'] = "Invalid Credentials";
            header('Location:' . SITEROOT . '/userPermission/userPermissions/');
            exit();
        }
        # LDAP Authentication Ends
        # LDAP Search Starts
        $filter = "(&(objectClass=user)(title=" . $_POST['userId'] . "))";
        $searchReturn = array("title", "someotherAccuntName", "l", "cn");
        $read = ldap_search($connect, $base_dn, $filter, $searchReturn) or exit(">>Unable to search ldap server<<");
        $info = ldap_get_entries($connect, $read);
        # LDAP Search Ends


        if ($info['count'] == 1) {
            $username = $info[0]['someotherAccuntName'][0];
            $fullname = $info[0]['cn'][0];
            $_SESSION['fullname'] = $fullname;
            //insert into tbl_users
            $insertUser = "INSERT INTO tbl_users (user_id ,username, full_name ,is_active)
                    VALUES ('" . $_POST['userId'] . "','$username','$fullname',1)";

            $exeInsertUser = mysqli_query($conn_rw, $insertUser);


            if ($exeInsertUser) {
                $insertRole = "INSERT INTO tbl_user_roles ( 	user_id	, role_id)
                            VALUES ('" . $_POST['userId'] . "','" . $_POST['roleId'] . "')";
                $exeInsertRole = mysqli_query($conn_rw, $insertRole);

                if ($exeInsertRole) {
                    $_SESSION['successMsg'] = "User added and assigned role  successfully";
                } else {
                    $_SESSION['errMsg'] = "User Added but assigning role failed";
                }
            } else {
                $_SESSION['errMsg'] = "User Addition failed";
            }
        } else {
            $_SESSION['errMsg'] = "Invalid user id(KPID)";
        }
    }
    header("Location:" . SITEROOT . '/userPermission/userPermissions/');
    exit();
}



$getAllRoles = comFunctions::getAllRecord("master_roles");

$getUsersQuery = "SELECT DISTINCT(tu.full_name) ,mr.role_name ,mr.id ,tu.user_id
                FROM tbl_users tu
                LEFT JOIN `tbl_user_roles` tur ON tur.user_id =tu.user_id
                LEFT JOIN master_roles mr ON mr.id=tur.role_id
                WHERE tu.is_active = 1";

$getUsers = comFunctions::getMultiRows($getUsersQuery);


//test($getUsers);
$smarty->assign("getUsers", $getUsers);
$smarty->assign("getAllRoles", $getAllRoles);
$smarty->assign('userDisplayTable', 'modules/userPermission/userDisplayTable.tpl');
if ($_POST && isset($_POST['deleteFlag']) && $_POST['deleteFlag'] != NULL) {
    $smarty->display('modules/userPermission/userDisplayTable.tpl');
} else {
    $smarty->display('modules/userPermission/userPermissions.tpl');
}
unset($_SESSION['successMsg']);
unset($_SESSION['errMsg']);
?>
