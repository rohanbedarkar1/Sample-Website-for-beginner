<?php

require("../../configs/config.php");

if (!isset($_SESSION['username'])) {
    header('Location: ' . SITEROOT . '/login');
}

extract($_GET);

$pipeId = $_GET['id'];
$filterValue = $_GET['id1'];

$isActive = 1;
$condPerson = "";
if (isset($filterValue)) {
    if ($filterValue != 'nofilter') {
        $resp_pers = explode(":", $filterValue);
        if (count($resp_pers) === 2) {
            if ($resp_pers[0] == 'U') {
                $condPerson = " AND tp.person_responsible = '" . $resp_pers[1] . "' ";
            }

            if ($resp_pers[1] == 'deletedDeals') {
                $isActive = 0;
            }
        }
    }
}

$projectsArr = pipeLineFunctions::getProjectDetails($pipeId, $isActive, $condPerson);

$header = "<table border='1' cellspacing='0' cellpadding='0' align='center'><tr><th>Idea</th><th>Stage</th><th>Person Responsible</th><th> Area</th><th> CTO SPOC</th><th> TAM</th><th> SAM</th><th> Date created</th></tr>";

$row = "";
$rowVal = "";

foreach ($projectsArr as $keyProj => $valueProj) {
    foreach ($valueProj as $keyIdea => $valueIdea) {
        $row = "<tr><td>".$valueIdea['project_name'] . "</td><td>" . $valueIdea['level_name'] . "</td><td>" . $valueIdea['person_name'] . "</td><td>" . $valueIdea['area'];
        $row .= "</td><td>" . $valueIdea['cto_spoc'] . "</td><td>" . $valueIdea['tam'] . "</td><td>" . $valueIdea['sam'] . "</td><td>" . date("d-M-Y", strtotime($valueIdea['date_created']))."</td></tr>";

        //$rowVal .= trim($row) . "\n";
        $rowVal .= $row;
    }
}
//$rowVal = str_replace("\r", "", $rowVal);
$rowVal = $rowVal."</table>";

//create a file and send to browser for user to download
header("Content-type: application/vnd.ms-excel");
//header("Content-disposition: csv" . date("Y-m-d") . ".csv");
$allocationReport = "pipeReport" . date("YmdHis");
header("Content-disposition: filename=" . $allocationReport . ".xls");
echo "$header\n$rowVal";
exit;
?>