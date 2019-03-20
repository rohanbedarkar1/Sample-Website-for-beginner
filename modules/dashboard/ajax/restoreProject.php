<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require("../../../configs/config.php");


if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}

extract($_POST);
$restoreProjectQuery = "UPDATE tbl_projects SET is_active = 1 WHERE project_id ='" . $_POST['projectId'] . "'";
$restoreProject = mysqli_query($conn_rw, $restoreProjectQuery);

if ($restoreProject) {
    echo "success";
} else {
    echo "failed";
}
?>
