<?php
class GmCallbacksClass
{
    static function ReadPageCallback($params)
    {
        global $config;
        $to_email = $params['email'];
        if ($to_email != '') {
                $tmp_message  = get_display_name($params['user_id']);",\n\n";
			    $tmp_message .= "...this email is from gamify.";
				require(AT_INCLUDE_PATH . 'classes/phpmailer/atutormailer.class.php');

				$mail = new ATutorMailer;

				$mail->From = $_config['contact_email'];
				$mail->AddAddress($to_email);
				$mail->Subject = "Gamify Notification";
				$mail->Body    = $tmp_message;

				if(!$mail->Send()) {
					//echo 'There was an error sending the message';
				   $msg->printErrors('SENDING_ERROR');
				   exit;
				}
				unset($mail);

			} else {
			    $msg->addError('no email provided');
			}

        return true;
    }

    static function myPostToChatReachCallBackFunction(){
        //echo "<br><i>Posted to chat so many times and granted a Badge! Send some email or call an API endpoint...</i>";
        // IT MUST RETURN TRUE to gamification continue to flow.
        // Returning true it will give the points and badges like setup
        // Returning false it will don't give any points of badges for that event
        return true;
    }
}