<?php

require("../../configs/config.php");
// test($_SESSION);

if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}

//all the redmine assignees
//test($redmine_assignee['memberships']);
$smarty->assign("redmine_assignee", $redmine_assignee['memberships']);

$pipeId = getFirstPipelineId();

extract($_POST);
extract($_GET);
//test($_GET);
if ($_POST && isset($_POST['pipeId'])) {
    $pipeId = $_POST['pipeId'];
}
if (isset($_GET['id'])) {
    $pipeId = base64_decode($id);  //check .htaccess for more info
    //set the selected pipeline name here
}

$projectsArr = array();
$pipeLineArr = array();
$headerArr = array();
$levelsArr = array();
$levelIdsArr = array();
$stagesArr = array();
$getChangePipelineDetails = array();
$pipeLineName = "";

if ($pipeId != '') {

    if ($pipeId != 'NoPipeline') {
        $isActive = 1;
        $condPerson = "";
        if (isset($_POST['filterValue'])) {
            $resp_pers = explode(":", $_POST['filterValue']);

            if (isset($resp_pers[0]) && $resp_pers[0] == 'U') {
                $condPerson = " AND tp.person_responsible = '" . $resp_pers[1] . "' ";
            }
            if (isset($resp_pers[1]) &&$resp_pers[1] == 'deletedDeals') {
                $isActive = 0;
            }
        }
        $projectsArr = pipeLineFunctions::getProjectDetails($pipeId, $isActive, $condPerson);
        $pipeLineArr = getPipeline();
//        test($pipeLineArr);
        $pipeLineName = getPipeLineName($pipeId);
        $headerArr = getHeader($pipeId);
//        test($projectsArr);
        /*
         * as it is dealing 3 arrays we are writing code here itself
         */
        $changePipelineQuery = "SELECT mt.name,mt.id as pipe_id,GROUP_CONCAT(tl.name ORDER BY mtl.stage_order ASC) as stages ,
                            GROUP_CONCAT(tl.alias ORDER BY mtl.stage_order ASC) as levels ,
                            GROUP_CONCAT(tl.id ORDER BY mtl.stage_order ASC) as level_ids ,
                            GROUP_CONCAT(mtl.stage_order ORDER BY mtl.stage_order ASC)
                            FROM `mapping_type_levels` mtl 
                            INNER JOIN master_types mt ON mt.id=mtl.type_id 
                            INNER JOIN tbl_levels tl ON tl.id =mtl.level_id 
                            WHERE mt.is_active =1
                            GROUP BY (mt.id)";

        $getChangePipelineDetails = comFunctions::getMultiRows($changePipelineQuery);
        $tempCnt = 0;
        if (!empty($getChangePipelineDetails)) {
            foreach ($getChangePipelineDetails as $detail) {
                $levelsArr[$tempCnt] = explode(',', $detail['levels']);
                $levelIdsArr[$tempCnt] = explode(',', $detail['level_ids']);
                $stagesArr[$tempCnt] = explode(',', $detail['stages']);
                $tempCnt++;
            }
        }
    }
    $smarty->assign("isActive", $isActive);
}
if (isset($_POST['pipeId'])) {
    if (empty($projectsArr)) {
        $dataAvailable = "No Data";
    } else {
        $dataAvailable = "Data";
    }
}
if (empty($projectsArr)) {
    $dataAvailable = "No Data";
} else {
    $dataAvailable = "Data";
}
if($isActive == 0){
    $smarty->assign("deletedDeal",true);
}else{
    $smarty->assign("deletedDeal",false);
}
$smarty->assign('promoteStatus',comFunctions::getPromoteStatus($pipeId));

include ("./responsiblePerson.php");

$smarty->assign("resp_person", "modules/dashboard/responsiblePerson.tpl");
$getCheckIdDetilsQuery = "SELECT * FROM `master_checks` WHERE 1";
$getCheckDetails = comFunctions::getMultiRows($getCheckIdDetilsQuery);
for ($i = 0; $i < count($getCheckDetails); $i++) {
    $getCheckDetails[$i]['onhover'] = $getCheckDetails[$i]['name'] . ': ' . $getCheckDetails[$i]['description'];
}
//test(json_encode($getCheckDetails));
$checkDescription = str_replace("'", Constants::SINGLE_CHAR_CONSTANT, json_encode($getCheckDetails));
$smarty->assign('getCheckDetails', $checkDescription);
//test($getChangePipelineDetails);
// testR($headerArr);
// test($projectsArr);

// $dateAvailable = comFunctions::getSingleRow("SELECT count(*) FROM `tbl_activity_log` WHERE `project_id` = 49 and `updated_on` BETWEEN '2016-06-16' and '2016-06-01'");

// $getValidActivityLog = comFunctions::getMultiRows("SELECT `project_id`,`updated_on` FROM `tbl_activity_log` WHERE `comments` LIKE '%User promoted%'");
// // test($getValidActivityLog);
// for($i = 0; $i<count($getValidActivityLog); $i++){
// 	$promotedDate = explode(" ",$getValidActivityLog[$i]['updated_on']);
// 	$date=strtotime($promotedDate[0]);
// 	$validityDate =  date("Y-m-d", strtotime('-15 days',$date));
// 	$dateAvailable = comFunctions::getSingleRow("SELECT count(`updated_on`) FROM `tbl_activity_log` WHERE `project_id` = 49 and `updated_on` BETWEEN '2016-06-16' and '2016-06-01'");
// 	if($date)	
// 	echo "==".$promotedDate[0]."==".$validityDate;
// 	exit;
// }

$smarty->assign("projectDetails", $projectsArr);
$smarty->assign("headerDetails", $headerArr);
$smarty->assign("getPipeLine", $pipeLineArr);
$smarty->assign("pipeId", $pipeId);

$smarty->assign("pipeLineName", $pipeLineName);
$smarty->assign("levels", $levelsArr);
$smarty->assign("levelIds", $levelIdsArr);
$smarty->assign("stages", $stagesArr);

$smarty->assign('dataAvailable', $dataAvailable);
$smarty->assign("createProjectPopup", "modules/project/createProjectPopup.tpl");
$smarty->assign("createActionPopUp", "modules/action/createActionPopUp.tpl");
$smarty->assign("viewActionPopup", "modules/action/viewActionPopup.tpl");
$smarty->assign("changePipeline", "modules/pipeline/changePipeline.tpl");
$smarty->assign("mainTable", 'modules/dashboard/mainTable.tpl');

//test($headerArr);
$smarty->assign("getChangePipelineDetails", $getChangePipelineDetails);

if (isset($_POST['pipeId']) || isset($_POST['filterValue'])) {
    if (empty($projectsArr)) {
        echo "No data";
    } else {
        $smarty->display('modules/dashboard/mainTable.tpl');
    }
} else {
    $smarty->display('modules/dashboard/dashboard.tpl');
}
unset($_SESSION['errMsg']);
unset($_SESSION['successMsg']);

function getHeader($pipeId) {
    $getHeaderQuery = "SELECT tl.id as level_id,tl.name as level_name ,tl.alias as level
                FROM tbl_levels tl
                LEFT JOIN mapping_type_levels mtl ON mtl.level_id=tl.id
                INNER JOIN master_types mt ON mt.id=mtl.type_id
                AND mt.id=$pipeId 
                ORDER BY `mtl`.`stage_order`  ASC";
//    echo $getHeaderQuery;
    $getHeader = comFunctions::getMultiRows($getHeaderQuery);
    return $getHeader;
}

function getPipeline() {
    $getPipeQuery = "SELECT trim(mt.name) as name,mt.id as pipeId,GROUP_CONCAT(tl.name ORDER BY mtl.stage_order ASC) as levels,
                        GROUP_CONCAT(tl.id ORDER BY mtl.stage_order ASC) as level_id
                        FROM `master_types` mt
                        LEFT JOIN mapping_type_levels mtl ON mtl.type_id=mt.id
                        LEFT JOIN tbl_levels tl ON tl.id=mtl.level_id
                        WHERE mt.is_active = 1
                        GROUP BY mt.id";

    $getPipeLine = comFunctions::getMultiRows($getPipeQuery);

    $i = 0;
    if (!empty($getPipeLine)) {
        foreach ($getPipeLine as $pipe) {
            $getPipeLine[$i]['levels'] = explode(',', $pipe['levels']);
            $getPipeLine[$i]['level_id'] = explode(',', $pipe['level_id']);
            $getPipeLine[$i]['firstLevel'] = $getPipeLine[$i]['levels'][0];
            $getPipeLine[$i]['firstLevelId'] = $getPipeLine[$i]['level_id'][0];
            $i++;
        }
    }

//    test($getPipeLine);
    return $getPipeLine;
}

function getFirstPipelineId() {
    $getFirstPipelineIdQuery = "SELECT id 
                                    FROM master_types 
                                    WHERE is_active = 1
                                    ORDER BY id ASC LIMIT 1";
    $getFirstPipelineId = comFunctions::getSingleRow($getFirstPipelineIdQuery);

    return $getFirstPipelineId['id'];
}

function getPipeLineName($pipeId) {
    $getPipelineNameQuery = "SELECT name 
                                    FROM master_types 
                                    WHERE id=$pipeId";
    $getPipelineName = comFunctions::getSingleRow($getPipelineNameQuery);

    return $getPipelineName['name'];
}

?>