<?php

class pipeLineFunctions extends comFunctions {

    public static function  getProjectDetails($pipeId, $isActive, $condPerson = "") {

        $getFinalProjectDetails = array();

        $getProjectQuery = "SELECT tp.project_id,tp.cto_spoc,tp.project_name,mt.name,mt.id as pipe_id,tl.id as level_id, 
                        tp.tam_currency,tp.sam,tp.sam_currency,tp.date_created,
                        tl.alias,tl.name as level_name,GROUP_CONCAT(mlc.check_id ORDER BY mlc.check_id ASC) as check_id ,
                        group_concat(IFNULL(tcv.value, 'NULL') ORDER BY mlc.check_id ASC) as value,
                        tp.tam,tp.tam_currency,tp.area,tp.person_responsible,mtl.stage_order,
                        tl.validity,DATEDIFF(now(),temp.updated_on) as latest_activity,
                        (SELECT count(*) FROM `tbl_activity_log` where `updated_on` >= (SELECT DATE_ADD(NOW(), INTERVAL -15 DAY)) and updated_on <= NOW() and project_id = tp.project_id  and `comments` LIKE '%User Promoted%') as count 
                        FROM tbl_levels tl
                        LEFT JOIN tbl_projects tp ON tl.id=tp.level_id 
                        AND tp.type_id =$pipeId
                        AND tp.is_active = $isActive
                        $condPerson
                        LEFT JOIN mapping_level_checks mlc ON mlc.level_id=tl.id AND mlc.is_active =1 AND mlc.is_del=1
                        LEFT JOIN tbl_check_value tcv ON tp.project_id =tcv.proj_id AND mlc.check_id=tcv.check_id 
                        LEFT JOIN mapping_type_levels mtl ON tl.id=mtl.level_id
                        LEFT JOIN (SELECT m1.*
                        FROM tbl_activity_log m1 LEFT JOIN tbl_activity_log m2
                        ON (m1.project_id = m2.project_id AND m1.id < m2.id)
                        WHERE m2.id IS NULL) as temp ON temp.project_id=tp.project_id
                        INNER JOIN master_types mt ON mt.id=mtl.type_id
                        AND mt.id=$pipeId
                        Group by tp.project_id,tl.id 
                        ORDER BY `mtl`.`stage_order` ASC";
//    echo $getProjectQuery;
//    exit();
        $i = 0;
        $tempCntr = 0;
        $phase = '';
        $proj_id = '';
        $getProjectDetails = parent::getMultiRows($getProjectQuery);


        if ($getProjectDetails != NULL) {
            foreach ($getProjectDetails as $check) {

                if ($phase != $getProjectDetails[$tempCntr]['level_id']) {
                    $phase = $getProjectDetails[$tempCntr]['level_id'];
                    $proj_id = $getProjectDetails[$tempCntr]['project_id'];
                    $i = 0;
                }

                $getFinalProjectDetails[$phase][$i] = $check;
                $getFinalProjectDetails[$phase][$i]['check_id'] = explode(',', $check['check_id']);
                $getFinalProjectDetails[$phase][$i]['value'] = explode(',', $check['value']);
                $getFinalProjectDetails[$phase][$i]['canPromote'] = parent::canPromoteToNextLevel($check['project_id']);



                $nextLevel = parent::getNextLevel($check['level_id'], $check['pipe_id']);

                if ($nextLevel != '0' && $nextLevel != '' && $nextLevel != NULL) {
                    $getFinalProjectDetails[$phase][$i]['hasNextLevel'] = true;
                } else {
                    $getFinalProjectDetails[$phase][$i]['hasNextLevel'] = false;
                }
                $getFinalProjectDetails[$phase][$i]['tam'] = str_replace(',', '', $getFinalProjectDetails[$phase][$i]['tam']);
                $getFinalProjectDetails[$phase][$i]['sam'] = str_replace(',', '', $getFinalProjectDetails[$phase][$i]['sam']);
                $getFinalProjectDetails[$phase][$i]['person_name'] = $getFinalProjectDetails[$phase][$i]['person_responsible'];
                $getFinalProjectDetails[$phase][$i]['person_responsible'] = explode(' ',$getFinalProjectDetails[$phase][$i]['person_responsible'])[0];
                
                $i++;
                $tempCntr++;
            }
        }
//        test($getFinalProjectDetails);
        return $getFinalProjectDetails;
    }
    
    public static function getOutdatedProj(){
    	
    	$sql = "SELECT tp.project_id,tp.cto_spoc,tp.cto_spoc_mail,tp.project_name,mt.name as pipeName, tl.id as level_id, tp.tam_currency,
    			tp.sam,tp.sam_currency,tp.date_created, tl.alias,tl.name as level_name, tp.tam,tp.tam_currency,
    			tp.area,tp.person_responsible,tp.person_responsible_mail,mtl.stage_order, tl.validity,
    			DATEDIFF(now(),temp.updated_on) as latest_activity,mt.notifi_required 
    			FROM tbl_levels tl INNER JOIN tbl_projects tp ON tl.id=tp.level_id AND tp.is_active = 1 
    			LEFT JOIN mapping_type_levels mtl ON tl.id=mtl.level_id 
    			LEFT JOIN master_types mt on mt.id=tp.type_id AND mt.is_active=1
    			LEFT JOIN (SELECT m1.* FROM tbl_activity_log m1 LEFT JOIN tbl_activity_log m2 ON (m1.project_id = m2.project_id AND m1.id < m2.id) 
    			WHERE m2.id IS NULL) as temp ON temp.project_id=tp.project_id 
    			WHERE tl.validity < DATEDIFF(now(),temp.updated_on) 
    			Group by tp.project_id
    			Order By tp.project_id DESC ";
    	
    	$getProjectDetails = parent::getMultiRows($sql);
    	
//     	test($getProjectDetails);
    	return $getProjectDetails;
    }

}

?>