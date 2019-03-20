<?php

// Include database connection settings
require("../../configs/config.php");
$_SESSION['application']=$_POST['app'];
$_SESSION['redmine_project_id']=$_POST['redmine_project_id'];
$login = 0;

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $ldap_server = "ldap://portal address";
    $auth_user = $_POST['username'] . '@domain';
    $auth_pass = $_POST['password'];
    // Set the base dn to search the entire directory.
    $base_dn = "DC=domain, DC=com";

    // Show only user persons
    $filter = "(&(objectClass=user)(domainAccountObjectName=userName)(cn=*))";

    // connect to server
    if (!($connect = ldap_connect($ldap_server))) {
        $_SESSION['errMsg'] = "Could not connect to LDAP";
        header('Location:' . SITEROOT . '/login');
        exit();
        //die("Could not connect to ldap server");
    }

    // bind to server
    if (!($bind = ldap_bind($connect, $auth_user, $auth_pass))) {
        $_SESSION['errMsg'] = "Invalid crendentials";
        header('Location:' . SITEROOT . '/login');
        exit();
    } else {
        $exeUser = mysqli_query($conn_rw, "SELECT username, user_id FROM tbl_users WHERE (username = '" . mysqli_real_escape_string($conn_rw, $_POST['username']) . "') AND is_active=1");
        if (mysqli_num_rows($exeUser) == 1) {
            $userDetails = mysqli_fetch_assoc($exeUser);
            $_SESSION['username'] = $userDetails['username'];
            $_SESSION['user_id'] = $userDetails['user_id'];
            $_SESSION['user_type'] = 'user';
            $_SESSION['password'] = getEncryptPass($_POST['password']);
            $getRoleQuery = "SELECT mr.role_name FROM `tbl_user_roles` tur INNER JOIN master_roles mr ON mr.id=tur.role_id WHERE tur.user_id = '" . $userDetails['user_id'] . "'";
            $getRole = comFunctions::getSingleRow($getRoleQuery);
            if (count($getRole) > 0) {
                $role = $getRole['role_name'];
            } else {
                $role = "No Role";
            }
            $_SESSION['role'] = $role;
            header('Location:' . SITEROOT);
            exit();
        } else {
            $_SESSION['errMsg'] = "Sorry, you are not authorized user";
            header('Location:' . SITEROOT . '/login');
            exit();
        }
    }
} else {
    $_SESSION['errMsg'] = "Please enter username & password";
    header('Location:' . SITEROOT . '/login');
    exit();
}

function getEncryptPass($password) {
    $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $password, MCRYPT_MODE_CBC, $iv);
    $ciphertext = $iv . $ciphertext;
    $ciphertext_base64 = base64_encode($ciphertext);
    return $ciphertext_base64;
}

?>
