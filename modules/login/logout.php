<?php
require("../../configs/config.php");
$app_name=$_SESSION['application'];
session_destroy();
header('Location:'.'../../../'.$app_name.'/index.php');
?>