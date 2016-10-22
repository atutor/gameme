<?php
//namespace gamify;

class GmCallbacksClass
{
    static function ReadPageCallback($params)
    {
        global $_config, $_base_path;
        $root_path =  preg_replace ('#/get.php#','',$_base_path);
        $this_path =  preg_replace ('#/get.php#','',$_SERVER['DOCUMENT_ROOT'].$root_path);
        require($this_path.'mods/gamify/gamify.lib.php');

        $to_email = $params['email'];
        $from_email = $params['contact_email'];
 if ($params['badges']){
        $message .= "<table>";
        foreach ($params['badges'] as $badge) {
            $sql = "SELECT image_url FROM %sgm_badges WHERE id =%d";
            $badge_image = queryDB($sql, array(TABLE_PREFIX, $badge->getIdBadge()), TRUE);
            //$message .= "Badge Id: " . $badge->getIdBadge()."\n\n";
            $message .=  '<tr><td><img src="'.AT_BASE_HREF.$badge_image['image_url'].'" alt="" style="vertical-align:top"/></td>';
            $message .=  '<td>'.$badge->getBadge()->getTitle()."<br/>".$badge->getBadge()->getDescription()."</td></tr>";
            //$message .=  '<img src="'.AT_BASE_HREF.$badge_image['image_url'].'" />'."<br '>";
            //$message .=  $badge->getBadgeImage($params['badge'], $badge->getIdBadge());
            }
        $message .= "<table>";
        } 
        
        if ($to_email != '') {
                $tmp_message .='<h2>'.$_SESSION['course_title'].'</h2>';
                $tmp_message .= '<p>'.get_display_name($params['user_id'])."</p>\n\n";
			    $tmp_message .= "<p><br />Congratulations, you have received a new badge. Here are the badges you have earned in this course so far.<br /></p>" ;
				$tmp_message .= $message;
				require(AT_INCLUDE_PATH . 'classes/phpmailer/atutormailer.class.php');

				$mail = new ATutorMailer;
                $mail->IsHTML(true);
				$mail->From = $from_email;
				$mail->AddAddress($to_email);
				$mail->Subject = "ATutor Gamify Notification";
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