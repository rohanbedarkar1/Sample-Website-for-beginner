<?php

require ("../configs/config.php");

$details = pipeLineFunctions::getOutdatedProj();
//test($details);
for ($i = 0; $i < count($details); $i++) {
    if ($details[$i]['notifi_required'] != 0) {
        sendNotificationMail($details[$i]);
    }
}

function mailHeader() {

    $style = 'font-family: "Segoe UI","sans-serif"; font-size:13px';
    $msg = "<html><head><title>" . SITETITLE . "</title></head><body style='$style'>";

    return $msg;
}

function mailfooter() {

    $msg = "";

   // $msg .= $autoMsg;
    $msg .= "</body></html>";
    return $msg;
}

function sendMail($to, $subject, $msg, $header = "") {
    $ret = mail($to, $subject, $msg);
    if ($ret) {
        echo "success";
    } else {
        echo "fail";
    }
}

function sendNotificationMail($details) {


// 		test(count($details));
    if (count($details) > 1) {


        $mailHeader = mailHeader();
        $mailFooter = mailfooter();

        $msg = $mailHeader;
        $msg .= "Hello,<br /><br />";
        $msg .= "No activity is logged on the " . $details['project_name'] . " since " . $details['latest_activity'] . " days.";
        $msg .= "<br />This notification is for your action.";
        $msg .= "<br /><br />
					<table border='1'>

					<thead>
						<th>Name</th>
						<th>Pipeline</th>
						<th>Stage</th>
						<th>Person Responsible</th>
						<th>Area</th>
						<th>CTO SPOC</th>
						<th>TAM</th>
						<th>SAM</th>
					</thead>

					<tbody>
						<tr>
							<td> " . $details['project_name'] . "  </td>
							<td> " . $details['pipeName'] . "  </td>
							<td> " . $details['level_name'] . "  </td>
							<td> " . $details['person_responsible'] . "  </td>
							<td> " . $details['area'] . "  </td>
							<td> " . $details['cto_spoc'] . "  </td>
							<td> " . $details['tam'] . "-" . $details['tam_currency'] . "  </td>
							<td> " . $details['sam'] . "-" . $details['sam_currency'] . "  </td>
						</tr>

					</tbody>
					</table>
					";
        $msg .= "<br />Regards, <br>Stages-Admin";
        $msg .= "<br /><br />";
        $msg .= "<br><pre style='font-size:9px;'>*This is an auto generated email. Kindly do not reply.</pre>";

        $msg .= $mailFooter;

        $message = html_entity_decode($msg);
// 			test($message);


        require(ABSPATH . "/util/smtpDetails.php");
        $mail->setFrom("donotreply@example.com", "Stages-Admin");
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
        if ($details['person_responsible_mail'] != '') {
            $mail->addAddress($details['person_responsible_mail']);
// 				$mail->addAddress("first.last@example.com");
// 				$toArray = explode(",",$details['person_responsible_mail']);
// 				if(count($toArray) > 0) {
// 					foreach($toArray as $key=>$value) {
// 						$mail->addAddress($value);
// 					}
// 				}
        }


        if ($details['cto_spoc_mail'] != '') {
            $mail->addCC($details['cto_spoc_mail']);
        }

        $mail->addBCC('first@example.com');
        $mail->addBCC('second@example.com');

        //Set the subject line

        $mail->Subject = "No activity logged on " . $details['project_name'];

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML($message);
        //Replace the plain text body with one created manually
        //$mail->AltBody = 'Lo ho gaya';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        //send the message, check for errors
        $mail->send();
        echo "mail sent successfully";
    }
}

?>
