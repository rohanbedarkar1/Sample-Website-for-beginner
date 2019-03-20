<?php


require_once (ABSPATH.'/plugins/Redmine/lib/autoload.php');

#enter url
$url='url;

#enter username

$redmine_user='';

#enter password

$redmine_pass='';

#enter project_id

$redmine_project_id=$_SESSION['redmine_project_id'];

#tracker ID
$redmine_tracker_id=7;

$redmine_client = new Redmine\Client($url,$redmine_user,$redmine_pass);
$redmine_client->setCheckSslCertificate(true);
$redmine_assignee=$redmine_client->api('membership')->all($redmine_project_id,array("offset"=>0, "limit"=>100));

?>
