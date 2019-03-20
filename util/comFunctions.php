<?php

class comFunctions {

    public static $conn;

    static function getSingleRow($sqlQuery) {
        $exeQuery = mysqli_query(self::$conn, $sqlQuery) or die("Couldn't execute query:$sqlQuery" . mysqli_error(self::$conn));
        $rsQuery = mysqli_fetch_assoc($exeQuery);
        return $rsQuery;
    }

    static function init() {
        include_once($_SERVER['DOCUMENT_ROOT'] . '/stages/configs/config.php');
        self::$conn = $GLOBALS['conn_rw'];
    }

    static function getMultiRows($sqlQuery) {
        $exeQuery = mysqli_query(self::$conn, $sqlQuery) or die("Couldn't execute query:$sqlQuery" . mysqli_error(self::$conn));

        while ($fetQuery = @mysqli_fetch_assoc($exeQuery)) {
            $rsQuery[] = $fetQuery;
        }
        return @$rsQuery;
    }

    static function getAllRecord($table, $column = FALSE, $where = FALSE, $print = FALSE) {
        $selCol = ($column !== FALSE) ? $column : "*";
        $whrClause = ($where !== FALSE) ? " $where" : "1";
        $sqlQuery = "SELECT $selCol FROM $table WHERE $whrClause";

        if ($print === TRUE)
            echo $sqlQuery . "<br/>";

        return $getAllRecord = self::getMultiRows($sqlQuery);
    }

    static function getCurrentStageOrder($pipelineId) {
        $getCurrentStageOrderQuery = "SELECT IFNULL(max(stage_order) ,0)  as stage_order
                                            FROM `mapping_type_levels` mtl
                                            INNER JOIN tbl_levels tl ON tl.id =mtl.level_id
                                            WHERE type_id=" . $pipelineId . "";

        $getCurrentStageOrder = self::getSingleRow($getCurrentStageOrderQuery);
        return $getCurrentStageOrder['stage_order'];
    }

    static function getNextLevel($levelId, $typeId) {
        $getNextLevelQuery = "SELECT tl.id
                                FROM tbl_levels tl
                                INNER JOIN mapping_type_levels mtl ON mtl.level_id=tl.id
                                WHERE mtl.stage_order >(  SELECT stage_order
                                                            FROM mapping_type_levels
                                                            WHERE level_id='$levelId' and type_id = '$typeId'
                                                            )
                                                     AND mtl.type_id = $typeId
                              ORDER BY mtl.stage_order ASC LIMIT 1";
        $getNextLevel = self::getSingleRow($getNextLevelQuery);

        return $getNextLevel['id'];
    }

    static function isAccess($role) {
        if ($role != 'Admin' && $role != 'Collaborator') {
            header('Location:' . SITEROOT . '/common/unAuthorisedUser/');
            exit();
        }
    }

    static function isAccessPermission($role) {
        if ($role != 'Admin') {
            header('Location:' . SITEROOT . '/common/unAuthorisedUser/');
            exit();
        }
    }

    static function canPromoteToNextLevel($projectId) {


        $getProjectQuery = "SELECT tp.project_id,tp.project_name,tl.id as level_id, GROUP_CONCAT(mlc.check_id ORDER BY mlc.check_id ASC) as check_id ,group_concat(IFNULL(tcv.value, 'NULL') ORDER BY mlc.check_id ASC) as value
                    FROM tbl_projects tp
                    INNER JOIN tbl_levels tl ON tl.id=tp.level_id
                    LEFT JOIN mapping_level_checks mlc ON mlc.level_id=tl.id AND mlc.is_del=1
                    LEFT JOIN tbl_check_value tcv ON tp.project_id =tcv.proj_id AND mlc.check_id=tcv.check_id
                    WHERE tp.project_id='" . $projectId . "'";

        $getDetails = mysqli_query(self::$conn, $getProjectQuery);
        $i = 0;
        $data = NULL;
        while ($details = mysqli_fetch_assoc($getDetails)) {
            $data[$i] = $details;

            $data[$i]['check_id'] = explode(',', $data[$i]['check_id']);
            $data[$i]['value'] = explode(',', $data[$i]['value']);

            $i++;
        }

        $flag = true;

        for ($i = 0; $i < count($data[0]['check_id']); $i++) {

            if ($data[0]['value'][$i] != 'Complete') {
                $flag = false;
                break;
            }
        }
        return $flag;
    }

    static private function mailHeader() {
        $msg = "<html lang='en'><head><title>" . SITETITLE . "</title>";
        $msg .= "<style>";
        $msg .= ".footerLink {font-size: 9.0pt; font-family: 'Segoe UI','sans-serif';color: #595959;}";
        $msg .= ".web {font-size:9.0pt; font-family:'Segoe UI','sans-serif'; color:#5959FF}";
        $msg .= ".example {font-size:12.0pt; font-family:'Segoe UI','sans-serif'; color:#5959FF}";
        $msg .= ".exampleDash {font-size:12.0pt; font-family:'Segoe UI','sans-serif'; color:#7F7F7F}";
        $msg .= ".exampleCss {border-bottom: 10px solid #D7DF23; background-color: #4DB5E5; color: #FFFFFF;font-family:'Segoe UI','sans-serif';}";
        $msg .= ".bodyCss {border:1px #D7DF23 solid; font-family:'Segoe UI','sans-serif';}";
        $msg .= ".marLeft5 {margin-left:5px}";

        $msg .= "</style>";
        $msg .= "</head><body class='bodyCss'>";
        $msg .= "<div id='wrapper'>";
        $msg .= "<div class='exampleCss'>";
        $msg .= "<div>";
        $msg .= "<a class='navbar-brand' href='" . SITEROOT . "'><img src='" . SITEIMG . "/logo.png' alt='logo' height='50' width='136' style='margin-top:10px'/></a>";
        $msg .= "</div></div><div class='marLeft5'>";

        //$msg = "<html><head><title>HTML email</title></head><body>";

        return $msg;
    }

    static private function mailfooter() {
        $msg = "";

        $msg .= "<br/><br/>";
        $msg .= "<table style='border-top: 1px solid #E1DF23;'>";
        $msg .= "<tr>";
        $msg .= "<td>";
        $msg .= "<b class='example'>example</b> <i class='exampleDash '>|</i> ";
        $msg .= "<b>Web:</b><a href='http://www.example.com/' target='_blank' class='web'>http://www.example.com</a>";
        $msg .= "  ";
        $msg .= "<b>Social: </b> <a href='http://www.example.com/facebook' target='_blank' class='footerLink'>Facebook</a>|";
        $msg .= "<a href='http://www.example.com/twitter' target='_blank'  class='footerLink'>Twitter</a>|";
        $msg .= "<a href='http://www.example.com/linkedin' target='_blank'  class='footerLink'>Linkedin</a>|";
        $msg .= "<a href='http://www.example.com/youtube' target='_blank'  class='footerLink'>Youtube</a>";
        $msg .= "</td>";
        $msg .= "</tr>";
        $msg .= "</table>";

        $msg .= "</div></body></html>";
        return $msg;
        //return $msg = "</body></html>";
    }

    static public function getDecrptPass($password) {

        $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

        $ciphertext_dec = base64_decode($password);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv_dec = substr($ciphertext_dec, 0, $iv_size);
        $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);

        return rtrim((string) substr($plaintext_dec, -16), "\0");
    }

    //pipeId and typeId is the same thing levelId is diffrent
    static public function getPromoteStatus($type_id) {
        if ($type_id !="") {
            $promoteStatus = comFunctions::getSingleRow("SELECT check_required
                                                        FROM master_types
                                                        WHERE is_active = 1
                                                        AND id=$type_id
                                                        ORDER BY id ASC LIMIT 1");
            if ($promoteStatus['check_required'] == 1) {
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

}

comFunctions::init();
?>
