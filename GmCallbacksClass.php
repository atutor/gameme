<?php
namespace gamify;
use gamify\PHPGamification\DAO;

class GmCallbacksClass
{
    static function ReadPageCallback($params)
    {
        if ($params['badges']){                       
            $message .='<div style="width:97%;padding-left: 2em;border:1px solid #cccccc;background-color:#f6f4da;"><h2>'.$_SESSION['course_title'].'</h2></div>';
            $message .= '<p> Hi '.$params['firstname']."!</p>\n\n";
            $message .= "<p>Congratulations, you have received a new badge. Here are the badges you have earned in this course so far.<br /></p>" ;
            $message .= '<table style="border:1px solid #eeeeee;">';
            foreach ($params['badges'] as $badge) {
                $sql = "SELECT image_url FROM %sgm_badges WHERE id =%d";
                $badge_image = queryDB($sql, array(TABLE_PREFIX, $badge->getIdBadge()), TRUE);
                $message .=  '<tr><td style="background-color:#eeeee;"><img src="'.AT_BASE_HREF.$badge_image['image_url'].'" alt="" style="vertical-align:top"/></td>';
                $message .=  '<td style="background-color:#efefef; padding:.3em;"><strong>'.$badge->getBadge()->getTitle()."</strong><br/>".$badge->getBadge()->getDescription()."</td></tr>";
            }
            $message .= "<table>";
        } 
        self::SendMail($params, $message);
        return true;
    }
    static function WelcomeCallback($params)
    {
        if ($params['firstname']){                       
            $message .='<div style="width:97%;padding-left: 2em;border:1px solid #cccccc;background-color:#f6f4da;"><h2>'.$_SESSION['course_title'].'</h2></div>';
            $message .= '<p> Hi '.$params['firstname']."!</p>\n\n";
            $message .= "<p>Welcome to the course. You have earned your first badge by successfully logging in. Continue earning badges by using the features in the course, and partcipating in course activities.<br /><br />By participating in the course you can also earn points and advance through levels as your points grow. Follow the leader board to see your position compared to others in the course.<br></p>" ;
        } 
        self::SendMail($params, $message);
        return true;
    }
    static function LoginReachCallback($params)
    {
        if ($params['badges']){                       
            $message .='<div style="width:97%;padding-left: 2em;border:1px solid #cccccc;background-color:#f6f4da;"><h2>'.$_SESSION['course_title'].'</h2></div>';
            $message .= '<p> Hi '.$params['firstname']."!</p>\n\n";
            $message .= "<p>Congratulations, you have received a new badge for logging into the course many times. Here are the badges you have earned in this course so far.<br /></p>" ;
            $message .= '<table style="border:1px solid #eeeeee;">';
            foreach ($params['badges'] as $badge) {
                $sql = "SELECT image_url FROM %sgm_badges WHERE id =%d";
                $badge_image = queryDB($sql, array(TABLE_PREFIX, $badge->getIdBadge()), TRUE);
                $message .=  '<tr><td style="background-color:#eeeee;"><img src="'.AT_BASE_HREF.$badge_image['image_url'].'" alt="" style="vertical-align:top"/></td>';
                $message .=  '<td style="background-color:#efefef; padding:.3em;"><strong>'.$badge->getBadge()->getTitle()."</strong><br/>".$badge->getBadge()->getDescription()."</td></tr>";
            }
            $message .= "<table>";
        } 
        self::SendMail($params, $message);
        return true;
    }
    static function LogoutReachCallback($params)
    {
        if ($params['badges']){                       
            $message .='<div style="width:97%;padding-left: 2em;border:1px solid #cccccc;background-color:#f6f4da;"><h2>'.$_SESSION['course_title'].'</h2></div>';
            $message .= '<p> Hi '.$params['firstname']."!</p>\n\n";
            $message .= "<p>Congratulations, you have received a new badge for logging out properly, instead of leaving or letting your session timeout, maintaining your privacy and security. Here are the badges you have earned in this course so far.<br /></p>" ;
            $message .= '<table style="border:1px solid #eeeeee;">';
            foreach ($params['badges'] as $badge) {
                $sql = "SELECT image_url FROM %sgm_badges WHERE id =%d";
                $badge_image = queryDB($sql, array(TABLE_PREFIX, $badge->getIdBadge()), TRUE);
                $message .=  '<tr><td style="background-color:#eeeee;"><img src="'.AT_BASE_HREF.$badge_image['image_url'].'" alt="" style="vertical-align:top"/></td>';
                $message .=  '<td style="background-color:#efefef; padding:.3em;"><strong>'.$badge->getBadge()->getTitle()."</strong><br/>".$badge->getBadge()->getDescription()."</td></tr>";
            }
            $message .= "<table>";
        } 
        self::SendMail($params, $message);
        return true;
    }
    static function PhotoAlbumCallback($params)
    {
        //global $_base_path, $gamification;
        //global $_base_path, $gamification;
        //$this_path =  preg_replace ('#/get.php#','',$_SERVER['DOCUMENT_ROOT'].$_base_path);
        //require_once($this_path.'mods/gamify/gamify.lib.php');
        //var_dump($params['badges']);
        if ($params['badges']){                       
            $message .='<div style="width:97%;padding-left: 2em;border:1px solid #cccccc;background-color:#f6f4da;"><h2>'.$_SESSION['course_title'].'</h2></div>';
            $message .= '<p> Hi '.$params['firstname']."!</p>\n\n";
            $message .= "<p>Congratulations, you have received a new badge for creating a photo album. Continue adding photos to earn more points and badges.<br /><br /> Here are the badges you have earned in this course so far.<br /></p>" ;
            //$message .= showUserBadgesStudents($gamification);
            $message .= '<table style="border:1px solid #eeeeee;">';
            foreach ($params['badges'] as $badge) {
                $sql = "SELECT image_url FROM %sgm_badges WHERE id =%d";
                $badge_image = queryDB($sql, array(TABLE_PREFIX, $badge->getIdBadge()), TRUE);
                $message .=  '<tr><td style="background-color:#eeeee;"><img src="'.AT_BASE_HREF.$badge_image['image_url'].'" alt="" style="vertical-align:top"/></td>';
                $message .=  '<td style="background-color:#efefef; padding:.3em;"><strong>'.$badge->getBadge()->getTitle()."</strong><br/>".$badge->getBadge()->getDescription()."</td></tr>";
            }
            $message .= "<table>";
            //var_dump($message);
            //exit;
            
        } 
        self::SendMail($params, $message);
        return true;
    }
    static function SendMail($params, $message){
            global $_config, $_base_path,$msg;
            if(!isset($params['email'])){
                $sql = "SELECT email FROM %smembers WHERE member_id =%d";
                $user_email = queryDB($sql, array(TABLE_PREFIX, $_SESSION['member_id']), TRUE);
                $to_email = $user_email['email'];
            } else {
                $to_email = $params['email'];
            }
            
            $root_path =  preg_replace ('#/get.php#','',$_base_path);
            $this_path =  preg_replace ('#/get.php#','',$_SERVER['DOCUMENT_ROOT'].$root_path);
            require_once($this_path.'mods/gamify/gamify.lib.php');
            $from_email = $_config['contact_email'];
        
        if ($to_email != '') {
				$tmp_message = $message;
				require($this_path.'mods/gamify/atutormailer.class.php');
				//debug_to_log($this_path.'mods/gamify/atutormailer.class.php');
				//require(AT_INCLUDE_PATH . 'classes/phpmailer/atutormailer.class.php');

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