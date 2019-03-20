<?php

if (isset($_POST['ajax_call']) && $_POST['ajax_call'] == 'yes') {
    require("../../configs/config.php");
    extract($_POST);
}


if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}

$sqlGetPeople = "SELECT DISTINCT(person_responsible) as person_responsible FROM tbl_projects WHERE type_id = '$pipeId'";
$exeGetPeople = mysqli_query($conn_rw, $sqlGetPeople);
$i = 0;
$person_responsible = array();

while ($fetGetPeople = mysqli_fetch_assoc($exeGetPeople)) {
    $person_responsible[$i] = $fetGetPeople['person_responsible'];
    $i++;
}

$smarty->assign("person_responsible", $person_responsible);
if (isset($_POST['ajax_call']) && $_POST['ajax_call'] == 'yes') {
    $smarty->display('modules/dashboard/responsiblePerson.tpl');
}
?>