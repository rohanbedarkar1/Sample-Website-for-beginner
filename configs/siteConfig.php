<?php
session_start();

//define("TRANSFER_PROTOCOL", $_SERVER['REQUEST_SCHEME'] . "://");
define("TRANSFER_PROTOCOL", "https://");
define("SITEROOT", TRANSFER_PROTOCOL . $_SERVER['SERVER_NAME'] . "/serverName");
define("ABSPATH", $_SERVER['DOCUMENT_ROOT'] . "/stages");
define("SITETITLE", SITEROOT);
define("SITEIMG", SITEROOT . "/images");
define("SITEJS", SITEROOT . "/js");
define("SITECSS", SITEROOT . "/css");


require (ABSPATH . '/libs/Smarty.class.php');
$smarty = new Smarty;

function test($arr) {
    echo "<pre>";
    $varType = gettype($arr);
    printTypeWise($varType, $arr);
    exit();
}

function testR($arr) {
    echo "<pre>";
    $varType = gettype($arr);
    printTypeWise($varType, $arr);
}

function printTypeWise($varType, $arr) {
    switch($varType) {
        case "array":
            print_r($arr);
            break;
        case "string":
        case "integer":
        case "double":
        case "boolean":
            echo $arr;
            break;
        default:
            echo "Invalid argument passed";
            break;
    }
}

$smarty->assign("siteroot", SITEROOT);
$smarty->assign("abspath", ABSPATH);
$smarty->assign("siteimg", SITEROOT . "/images");
$smarty->assign("sitejs", SITEROOT . "/js");
$smarty->assign("sitecss", SITEROOT . "/css");
$smarty->assign("sitetitle", SITETITLE);

$smarty->assign("header1", "common/header1.tpl");
$smarty->assign("header2", "common/header2.tpl");
$smarty->assign("footer", "common/footer.tpl");
$smarty->assign("sidepanel", "common/sidepanel.tpl");

?>
