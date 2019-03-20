<?php

require("../../configs/config.php");
if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}

extract($_POST);
// test($_POST);
if (!empty($_POST)) {
    $date_created = date('y-m-d');
    $template_file = fopen('../../configs/template.txt', "r");
    $file_data = fread($template_file, filesize('../../configs/template.txt'));
    fclose($template_file);
    $name="";
    //get attachment file details
    if (isset($_FILES['ideaAttachment']) && $_FILES['ideaAttachment']['name'] != '') {
        $uploads_dir = ABSPATH . "/uploads";
        $tmp_name = $_FILES["ideaAttachment"]["tmp_name"];
        $name = date("YmdHis") . str_replace(" ","_",$_FILES["ideaAttachment"]["name"]);
        if(!move_uploaded_file($tmp_name, "$uploads_dir/$name")){
            echo "error upload";
            exit;
        }
    }
	
//    $personResponsible = $_POST['personResponsible'];
//    $personResponsibleArr = explode("<", $personResponsible);
//    
//    $ctoSpoc = $_POST['ctoSpoc'];
//    $ctoSpocArr = explode("<", $ctoSpoc);
    
    //insert the project details here
    $insertProject = "INSERT INTO tbl_projects ( project_name, person_responsible, person_responsible_mail, cto_spoc, cto_spoc_mail, area, 
                                                    sam, tam,tam_currency,sam_currency, level_id, visible_to,type_id, date_created,last_stage_change,is_active,notes,upload_file_name)
                      VALUES ('" . mysqli_escape_string($conn_rw, $_POST['projectName']) . "','" .
            mysqli_escape_string($conn_rw, $_POST['personResponsible']) . "','" .
            mysqli_escape_string($conn_rw, $_POST['personResponsible_email']) . "','" .
            mysqli_escape_string($conn_rw, $_POST['ctoSpoc']) . "','" .
            mysqli_escape_string($conn_rw, $_POST['ctoSpoc_email']) . "','" .
            mysqli_escape_string($conn_rw, $_POST['area']) . "','" .
            mysqli_escape_string($conn_rw, $_POST['sam']) . "','" .
            mysqli_escape_string($conn_rw, $_POST['tam']) . "','" .
            $_POST['tamCurrency'] . "','" .
            $_POST['samCurrency'] . "','" .
            $_POST['levelId'] . "','" .
            $_POST['visibleTo'] . "','" .
            $_POST['pipelineId'] . "','" .
            $date_created . "','" .
            $date_created . "',1,'" . 
            mysqli_escape_string($conn_rw, $file_data) . "','".
            mysqli_escape_string($conn_rw, $name)."')";

//    echo $insertProject;exit;
    $exeInsertProject = mysqli_query($conn_rw, $insertProject);
    if ($exeInsertProject) {
        echo "success";
        // $_SESSION['successMsg'] ="Project Created successfully";
    } else {
        echo "error";
        //$_SESSION['errMsg'] ="Something went wrong ,Project creation failed";
    }
} else {
    echo "no data";
}
?>
