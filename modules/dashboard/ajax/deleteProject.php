<?php

require("../../../configs/config.php");


if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}

extract($_POST);
$deleteProjectQuery = "UPDATE tbl_projects SET is_active = 0 WHERE project_id ='" . $_POST['deleteProjectId'] . "'";
$deleteProject = mysqli_query($conn_rw, $deleteProjectQuery);

if ($deleteProject) {
    echo "success";
} else {
    echo "failed";
}

?>
