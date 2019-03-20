<?php

require("../../configs/config.php");

if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}
extract($_POST);
//test($_POST);
$rsPartSearch = array();
$i = 0;
# LDAP Authentication Starts
$ldap_host = "";
$base_dn = "DC=,DC=";

$ldap_user = $_SESSION['username'] . "@domain";
$ldap_pass = comFunctions::getDecrptPass($_SESSION['password']);
$connect = ldap_connect($ldap_host);
if ($connect === FALSE) {
    $_SESSION['errMsg'] = "Could not connect to LDAP";
    header('Location:' . SITEROOT . '/dashboard/dashboard/');
    exit();
}
ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
$bind = ldap_bind($connect, $ldap_user, $ldap_pass); // or exit(">>Could not bind to $ldap_host<<");
if ($bind === FALSE) {
    $_SESSION['errMsg'] = "Invalid Credentials";
    header('Location:' . SITEROOT . '/dashboard/dashboard/');
    exit();
}
# LDAP Authentication Ends
# LDAP Search Starts
$filter = "(&(objectClass=user)(name=" . $_POST['searchParam'] . "*))";
$searchReturn = array("title", "sAMAccountName", "l", "cn", "mail");
$read = ldap_search($connect, $base_dn, $filter, $searchReturn) or exit(">>Unable to search ldap server<<");
$info = ldap_get_entries($connect, $read);
# LDAP Search Ends
$rsPersonSearch = array();
$i = 0;
foreach ($info as $key => $value) {
    if ($value['cn'][0] != '') {
        $rsPersonSearch[$i]['name'] = $value['cn'][0];
        $rsPersonSearch[$i]['mail'] = $value['mail'][0];
        $i++;
    }
}

echo json_encode($rsPersonSearch);
?>
