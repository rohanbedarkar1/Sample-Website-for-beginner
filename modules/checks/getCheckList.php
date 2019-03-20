<?php

require_once ("../../configs/config.php");
if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}
extract($_POST);
//test($_POST);
if ($_POST && isset($_POST['checkedValues']) && $_POST['checkedValues'] != NULL) {
    $checkedValue = implode(',', $_POST['checkedValues']);
    $deleteCheckQuery = "UPDATE `master_checks` SET `is_del`=0 WHERE id in ($checkedValue)";
    $deleteCheck = mysqli_query($conn_rw, $deleteCheckQuery);
    $deleteCheckMappingQuery="UPDATE `mapping_level_checks` SET `is_del`=0 WHERE check_id in ($checkedValue)";
    $deleteCheckMapping = mysqli_query($conn_rw, $deleteCheckMappingQuery);
}

$getcheckList = array();
$freeCheckList = array();
$getcheckListQuery = "SELECT mc.id , mc.description ,mlc.is_active ,mc.name
                    FROM `tbl_levels` tl  
                    INNER JOIN  mapping_level_checks mlc ON mlc.level_id = tl.id
                    INNER JOIN master_checks mc ON mc.id = mlc.check_id 
                    WHERE tl.id='" . $_POST['levelId'] . "' 
                    AND mc.is_del = 1
                    ORDER BY is_active DESC ";

$getcheckList = comFunctions::getMultiRows($getcheckListQuery);

//test($getcheckList);
if (!empty($getcheckList)) {
    $temp = 0;
    foreach ($getcheckList as $mainCheck) {
        if ($getcheckList[$temp]['is_active'] == '1') {
            $getcheckList[$temp]['checked'] = 'Yes';
        } else {
            $getcheckList[$temp]['checked'] = 'No';
        }
        $temp++;
    }
}
//test($getcheckList);
$smarty->assign("getcheckList", $getcheckList);
if (isset($_POST['pipelineId'])) {
    $smarty->assign("pipelineId", $_POST['pipelineId']);
}
if (isset($_POST['levelId'])) {
    $smarty->assign("levelId", $_POST['levelId']);
}
$smarty->assign("freeCheckList", $freeCheckList);
$smarty->display('modules/checks/getCheckList.tpl');
?>
