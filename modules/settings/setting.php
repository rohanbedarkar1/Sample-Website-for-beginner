<?php

require("../../configs/config.php");
if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}
//test($_POST);
comFunctions::isAccess($_SESSION['role']);

if (isset($_POST['reload']) == 'yes') {
    $addStage = FALSE; //if page reload then then dont add stage
} else {
    $addStage = TRUE;
}

$getPipelineNames = array();
$pipeLevel = array();
//get the pipeline names
$getPipelineNamesQuery = "SELECT  rs.id,rs.type_name, GROUP_CONCAT(rs.level_ids ORDER BY rs.type_id, rs.stage_order) as levels, rs.type_id,
                            GROUP_CONCAT(rs.level_name ORDER BY rs.type_id, rs.stage_order) as stage_names,rs.type_id,rs.stage_order
                            FROM (
                                    SELECT mt.id,mt.name as type_name, tl.id as level_ids,mtl.stage_order,
                                    mt.id as type_id,
                                    tl.name as level_name
                                    FROM master_types mt 
                                    LEFT JOIN mapping_type_levels mtl ON mt.id=mtl.type_id 
                                    LEFT JOIN tbl_levels tl ON tl.id=mtl.level_id
                                    WHERE is_active = 1
                                    ORDER BY mtl.type_id, mtl.stage_order
                                 ) as rs group by rs.type_id";

$getPipelineNames = comFunctions::getMultiRows($getPipelineNamesQuery);
//get the levels of each pipeline

$i = 0;
if (!empty($getPipelineNames)) {
    foreach ($getPipelineNames as $level) {

        $pipeLevel[$i]['stage'] = explode(',', $level['stage_names']);
        $pipeLevel[$i]['level'] = explode(',', $level['levels']);
        array_push($getPipelineNames[$i], $pipeLevel[$i]);
        $i++;
    }
}
//test($getPipelineNames);
$smarty->assign("getPipelineNames", $getPipelineNames);
$smarty->assign("pipeLevel", $pipeLevel);
$smarty->assign("createNewPipeLine", 'modules/pipeline/addPipeLine.tpl');
$smarty->assign("createStage", 'modules/stage/createStage.tpl');
$smarty->assign("createChecks", 'modules/checks/createCheckId.tpl');
if(isset($_POST['activeTabId'])){
    $activeTab = $_POST['activeTabId'];
}else{
    $activeTab = 0;
}
if (isset($_POST['submit']) == 'submit') {
//    echo "hello";
//    $smarty->assign("activeTabId", $activeTabId);
    //purpose fully displaying all the tpls so that they are also reloaded
    $smarty->display('modules/pipeline/pipelineTabs.tpl');
    $smarty->display('modules/pipeline/addPipeLine.tpl');  
    $smarty->display('modules/stage/createStage.tpl');
    $smarty->display('modules/checks/createCheckId.tpl');
    unset($_SESSION['errMsgPipeLine']);
    unset($_SESSION['successMsgPipeLine']);
    exit();
} else {
    $activeTabId = 0;
    $smarty->assign("activeTabId", $activeTabId);
    $smarty->assign("pipeLineTabs", 'modules/pipeline/pipelineTabs.tpl');
    $smarty->display("modules/settings/setting.tpl");
}

unset($_SESSION['errMsg']);
unset($_SESSION['successMsg']);
?>
