<?php

require("../../configs/config.php");
if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}

extract($_POST);
//testR($_FILES);
//test($_POST);
//here we update the the pipeline level and type

$setValues = array();

//add attachment to the project
if (isset($_FILES['ideaAttachment']) && $_FILES['ideaAttachment']['name'] != '') {
    $uploads_dir = ABSPATH . "/uploads";
    $tmp_name = $_FILES["ideaAttachment"]["tmp_name"];
    $name = date("YmdHis") . str_replace(" ", "_", $_FILES["ideaAttachment"]["name"]);
    if (!move_uploaded_file($tmp_name, "$uploads_dir/$name")) {
        echo "error upload";
        exit;
    }
    array_push($setValues, "upload_file_name =concat('" . mysqli_escape_string($conn_rw, $name) . "::',upload_file_name)");
}

//$personResponsible = $_POST['Person_Responsible'];
//$personResponsibleArr = explode("<", $personResponsible);

//$ctoSpoc = $_POST['CTO_SPOC'];
//$ctoSpocArr = explode("<", $ctoSpoc);

if (isset($_POST['Project_Name'])) {
    array_push($setValues, "project_name ='" . mysqli_escape_string($conn_rw, $_POST['Project_Name']) . "'");
}
if (isset($_POST['Person_Responsible'])) {
    array_push($setValues, "person_responsible ='" . mysqli_escape_string($conn_rw, $_POST['Person_Responsible']) . "'");
}
if (isset($_POST['edit_person_responsible_email'])){
    array_push($setValues, "person_responsible_mail ='" . mysqli_escape_string($conn_rw,$_POST['edit_person_responsible_email']) . "'");
}
if (isset($_POST['CTO_SPOC'])) {
    array_push($setValues, "cto_spoc ='" . mysqli_escape_string($conn_rw, $_POST['CTO_SPOC']) . "'");
}
if(isset($_POST['edit_cto_spoc_email'])){
    array_push($setValues, "cto_spoc_mail ='" . mysqli_escape_string($conn_rw, $_POST['edit_cto_spoc_email']) . "'");
}
if (isset($_POST['Area'])) {
    array_push($setValues, "area ='" . mysqli_escape_string($conn_rw, $_POST['Area']) . "'");
}
if (isset($_POST['SAM'])) {
    array_push($setValues, "sam ='" . $_POST['SAM'] . "'");
}
if (isset($_POST['TAM'])) {
    array_push($setValues, "tam ='" . $_POST['TAM'] . "'");
}
if (isset($_POST['edit_sam_currency'])) {
    array_push($setValues, "sam_currency ='" . $_POST['edit_sam_currency'] . "'");
}
if (isset($_POST['edit_tam_currency'])) {
    array_push($setValues, "tam_currency ='" . $_POST['edit_tam_currency'] . "'");
}
if (isset($_POST['Current_Level'])) {
    array_push($setValues, "level_id ='" . mysqli_escape_string($conn_rw, $_POST['Current_Level']) . "'");
}
if (isset($_POST['edit_visible_to'])) {
    array_push($setValues, "visible_to ='" . $_POST['edit_visible_to'] . "'");
}
if (isset($_POST['Date_Created'])) {
    $date_created = date('Y-m-d', strtotime($_POST['Date_Created']));
    array_push($setValues, "date_created ='" . $date_created . "'");
}
if (isset($_POST['is_active'])) {
    array_push($setValues, "is_active ='" . $_POST['is_active'] . "'");
}


$setString = implode(",", $setValues);

$setString . "<br/>";
if (isset($setString)) {

    $updatePipelineOfProjectQuery = "UPDATE tbl_projects SET " . $setString . " WHERE project_id='" . $_POST['edit_project_id'] . "'";
//    echo $updatePipelineOfProjectQuery;
    
    $updatePipelineOfProject = mysqli_query($conn_rw, $updatePipelineOfProjectQuery);

    $getLevelOfProject = comFunctions::getSingleRow("SELECT `project_name`,`level_id` FROM `tbl_projects` WHERE project_id='" . $_POST['edit_project_id'] . "'");

    if ($updatePipelineOfProject) {
        echo "success::" . $getLevelOfProject['level_id'] . "::" . $getLevelOfProject['project_name'];
        //now update the checks of project
    } else {
        echo "failure";
    }
}
?>