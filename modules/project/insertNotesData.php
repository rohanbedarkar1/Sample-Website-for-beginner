<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require("../../configs/config.php");
if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}
extract($_POST);

if($_POST && isset($_POST['notes'])){
    $insertNotesQuery= "UPDATE `tbl_projects` SET `notes`='".mysqli_escape_string($conn_rw,$_POST['notes'])."' WHERE project_id='".$_POST['project_id']."'";
    $insertNotes=  mysqli_query($conn_rw, $insertNotesQuery);
    if(empty($insertNotes)){
        echo "error";
    }else{
        echo "success";
    }
}
exit;
?>
