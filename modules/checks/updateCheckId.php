<?php

require("../../configs/config.php");
if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}

extract($_POST);
if (!empty($_POST)) {

    //check if checkId exists 

    $getCheckId = "SELECT * FROM tbl_check_value 
                   WHERE check_id ='" . $_POST['check_id'] . "'
                      AND proj_id ='" . $_POST['proj_id'] . "'";
    $exeChkId = comFunctions::getMultiRows($getCheckId);

//if the checkId exists then update that
    if (count($exeChkId) > 0) {
        $updateCheckId = "UPDATE tbl_check_value SET value ='" . $_POST['chkIdValue'] . "'
                        WHERE proj_id ='" . $_POST['proj_id'] . "'
                          AND check_id='" . $_POST['check_id'] . "'";

        $exeInsrtUpdateCheckId = mysqli_query($conn_rw, $updateCheckId);
    }else{
        $insertCheckId =" INSERT INTO tbl_check_value ( proj_id, check_id, value )
                               VALUES ('".$_POST['proj_id']."','".$_POST['check_id']."','".$_POST['chkIdValue']."')";
        $exeInsrtUpdateCheckId = mysqli_query($conn_rw ,$insertCheckId);
    }

    if ($exeInsrtUpdateCheckId) {
        echo "success";
    } else {
        echo "failed" ;
    }
} else {
    echo "no data";
}
?>
