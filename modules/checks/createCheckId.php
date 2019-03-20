<?php

require("../../configs/config.php");
if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}
extract($_POST);

//insert the check ids
$insertCheckId = "INSERT INTO master_checks ( name, description, is_active, is_del) 
                       VALUES ('" .  mysqli_escape_string($conn_rw, $_POST['checkName']) . "','" . mysqli_escape_string($conn_rw, $_POST['description']) . "',1,1)";

$exeInsertCheckId = mysqli_query($conn_rw, $insertCheckId);
//link the check with the level here

//get the id of checkid 
$getEnteredCheckId = "SELECT id FROM master_checks 
                        WHERE name ='".mysqli_escape_string($conn_rw,$_POST['checkName'])."' 
                            AND description = '".mysqli_escape_string($conn_rw,$_POST['description'])."'
                                ORDER BY id DESC LIMIT 1";

$getId = comFunctions::getSingleRow($getEnteredCheckId);

$linkNewCheckId ="INSERT INTO mapping_level_checks (level_id, check_id , is_active ,is_del)
                   VALUES ('".$_POST['levelId']."','".$getId['id'] ."',1,1)";
$exeLinkNewCheckId =  mysqli_query($conn_rw, $linkNewCheckId);


if ($exeInsertCheckId && $exeLinkNewCheckId) {
    $_SESSION['successMsg'] = "Check created successfully";
} else {
    $_SESSION ['errMsg'] = "Check  failed to add";
}

include_once '../checks/getCheckList.php';

unset($_SESSION['errMsg']);
unset($_SESSION['successMsg']);
?>
