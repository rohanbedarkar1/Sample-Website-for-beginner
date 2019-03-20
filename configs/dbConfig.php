<?php
if($_SESSION['username'] !="" && $_POST['dbName'] !=""){
    session_destroy();
    session_start();
    $_SESSION["TestSession"] = $_POST['dbName'];
}

if (isset($_POST['dbName'])) {
    $_SESSION["TestSession"] = $_POST['dbName'];
    $_SESSION["application"] = $_POST['application'];
    $_SESSION["redmine_project_id"] = $_POST['redmine_project_id'];
    setcookie("TestCookie", $_POST['dbName']);
}

if ($_POST) {
    file_put_contents("login.txt", serialize($_POST));
}
if($_GET['dbName'] !=""){
    $dbName=$_GET['dbName'];
}else{
    $dbName=$_SESSION['TestSession'];
}
#enter host
$host = "localhost";
#enter database name
$dbname   =  $dbName;
#enter username
$username = "";
# enter password
$password = "";

$conn_rw = mysqli_connect($host, $username, $password);
if (!$conn_rw) {
    die("Connection failed: " . mysqli_error($conn_rw));
}

mysqli_select_db($conn_rw, $dbname) or DIE('Database name is not available!'.MYSQL_ERROR());
?>
