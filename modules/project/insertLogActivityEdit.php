<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require("../../configs/config.php");
extract($_POST);
//echo "check";
//exit;
if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}

if($_POST && isset($_POST['editLogStatement'])){
    
    $userFullname = comFunctions::getSingleRow("SELECT full_name FROM `tbl_users` WHERE username='".$_SESSION['username']."'");
    $insertLogQuery="INSERT INTO `tbl_activity_log`(`project_id`, `comments`, `level_id`, `by_user`) 
                     VALUES ('".$_POST['project_id']."','".mysqli_escape_string($conn_rw,nl2br($_POST['editLogStatement']))."','".$_POST['level_id']."','".$userFullname['full_name']."')";
    
    $insertLog=  mysqli_query($conn_rw, $insertLogQuery);
    if(empty($insertLog)){
        echo "error";
    }else{
        echo "success";
    }
}

?>
