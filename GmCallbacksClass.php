<?php


class GmCallbacksClass
{

	/*
	* Event callback functions send an email to a badge recipient with the new badge, 
	* and a list of badges earned so far
	* @params are defined the events.php file in the call to each executeEvent()
	*/
    static function ReadPageCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for getting a good amount of course reading done. ";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function WelcomeCallback($params)
    {
        if ($params['firstname']){                        
            $feedback = "Welcome to the course. You have earned your first badge by successfully logging in. Continue earning badges by using the features in the course, and participating in course activities.<br /><br />By participating in the course you can also earn points and advance through levels as your points grow. Follow the leader board to see your position among others in the course. Watch for hints after earning a badge, for earning additional badges and bonus points.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function LoginReachCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for logging into the course many times. You can also earn points by logging out of the course properly, clicking the logout link, instead of just leaving or letting your session timeout.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function LogoutReachCallback($params)
    {   
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for logging out properly, instead of leaving or letting your session timeout, maintaining your privacy and security. ";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function ProfilePictureCallback($params)
    { 
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for updating you profile picture. Updating your profile picture now and again earns you bonus points. ";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function ProfileViewReachCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for getting to know your classmates by viewing their profiles. You can earn additional points by sending a private message to a person through their profile page.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function ProfileViewedReachCallback($params)
    {
    	if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge because lots of people have been viewing your profile. ";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function ProfilePicUploadCallback($params)
    {      
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for adding a profile picture. Update your profile picture occassionally to receive additional points ";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function PreferencesUpdateCallback($params)
    { 
       if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for updating your personal preference. ";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function FileStorageFolderCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for learning how to create folders to organize your files. You can also earn points and badges by adding files to those folders";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function UploadFilesCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for learning how to use file storage to store your files. Create additional folders to organize your files for additional points and badges.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    } 
    static function CreateFilesCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for learning how to create new files in file storage.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }  
    static function ForumViewCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for keeping up with reading forum posts. Continue reading forum posts, start new threads, and reply to others posts to earn additional points and badges.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }  
    static function ForumPostsCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for contributing new threads to the discussion forums. Continue reading forum posts, start new threads, and reply to others posts to earn additional points and badges.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    } 
    static function ForumReplyCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for contributing good feedback to discussion forums. Continue reading forum posts, start new threads, and reply to others posts to earn additional points and badges.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    } 
    static function BlogAddCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for contributing a good collection of blog posts. Continue adding to your blog, and comments on others' blogs to earn additional points and badges.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }   
    static function BlogCommentsCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for contributing a good feedback, and commenting on blog posts. Continue posting to your blog, and commenting on others' blog posts to earn additional points.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    } 
    static function ChatLoginCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for logging into the chat regularly. Just using the chat helps accumulate points.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function ChatPostCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for keeping conversation going in the chat room. Returning to the chat room regularly earns additional points.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function LinkAddCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for making a good contribution to the course links. View links others have posted to earn additional points.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function PhotoAlbumCallback($params)
    { 
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for creating a photo album. Continue adding photos to earn more points and badges. ";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function PhotoAlbumsCallback($params)
    {
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for creating multiple photo albums to organize your photos. Continue adding photos to them to earn more points. ";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        }
        return true;
    }
    static function PhotoUploadCallback($params)
    {
        //global $msg;
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for uploading a good collection of photos. Continue adding photos to earn more points. Create additional albums to organize your photos for bonus points.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	self::SendMail($params, $message);
        	//$msg->addfeedback('Congratulations, you have received a new badge for uploading a good collection of photos. Continue adding photos to earn more points. Create additional folders to organize your photos for ponus points.');
        }
        return true;
    }
    static function PhotoAlbumCommentCallback($params)
    {
        global $msg;
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for providing comments on your's, and other's albums. Continue commenting about albums for additional points.";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	
        	$badge_file= '<img src="'.self::getBadgeFile($params['alias']).'" style="float:left;text-align:top;"/>';
        	//$msg->addFeedback('Congratulations, you have received a new badge for uploading a good collection of photos. Continue adding photos to earn more points. Create additional folders to organize your photos for ponus points.');
        	$msg->addFeedback(array('GM_PA_COMMENTS', $badge_file));
            self::SendMail($params, $message);
        }
        return true;
    }
    static function PhotoDescriptionCallback($params)
    {
        global $msg;
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for providing descriptions for your photos. Add alternative text to make your photos accessible to blind classmates, and earn bonus points and a badge";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	
        	//debug_to_log($params);
        	//$badge_file= '<img src="'.self::getBadgeFile($params['alias']).'" style="float:left;text-align:top;"/>';
        	//debug_to_log($badge_file);
        	//$msg->addFeedback('Congratulations, you have received a new badge for uploading a good collection of photos. Continue adding photos to earn more points. Create additional folders to organize your photos for ponus points.');
        	//$msg->addFeedback(array('GM_PA_COMMENTS', $badge_file));
        	//debug_to_log($badge_file);
            self::SendMail($params, $message);
        }
        return true;
    }
    static function PhotoAltTextCallback($params)
    {
        global $msg;
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for providing alternative text for your photos. This makes photos accessible to blind classmates using a screen reader to access the course. Providing descriptions for your photos can also earn points, and a badge. ";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	
        	//debug_to_log($params);
        	//$badge_file= '<img src="'.self::getBadgeFile($params['alias']).'" style="float:left;text-align:top;"/>';
        	//debug_to_log($badge_file);
        	//$msg->addFeedback('Congratulations, you have received a new badge for uploading a good collection of photos. Continue adding photos to earn more points. Create additional folders to organize your photos for ponus points.');
        	//$msg->addFeedback(array('GM_PA_COMMENTS', $badge_file));
        	//debug_to_log($badge_file);
            self::SendMail($params, $message);
        }
        return true;
    }
    static function PhotoCommentCallback($params)
    {
        global $msg;
        if ($params['badges']){                        
            $feedback = "Congratulations, you have received a new badge for providing comments on yours, and others photos. Continue commenting to earn additional points. You can also comment on photo albums as a whole, to earn bonus points. ";
            $message .= self::getNewBadge($params, $feedback);
            $message .= self::getCurrentBadges($params['badges']);
        } 
        if(!empty($message)){
        	
        	//debug_to_log($params);
        	//$badge_file= '<img src="'.self::getBadgeFile($params['alias']).'" style="float:left;text-align:top;"/>';
        	//debug_to_log($badge_file);
        	//$msg->addFeedback('Congratulations, you have received a new badge for uploading a good collection of photos. Continue adding photos to earn more points. Create additional folders to organize your photos for ponus points.');
        	//$msg->addFeedback(array('GM_PA_COMMENTS', $badge_file));
        	//debug_to_log($badge_file);
            self::SendMail($params, $message);
        }
        return true;
    }
    /*
    * Helper functions used in the Callback functions above, to gather
    * badge details, and to send the email.
    * @$params are passed from the events.php file to the callback, fowarded 
    * to the SendMail method along with a matching feedback message
    */
    public static function SendMail($params, $message){
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
            require_once($this_path.'mods/gameme/gamify.lib.php');
            $from_email = $_config['contact_email'];
        
        if ($to_email != '') {
				$tmp_message = $message;
				require($this_path.'mods/gameme/atutormailer.class.php');

				$mail = new ATutorMailer;
                $mail->IsHTML(true);
				$mail->From = $from_email;
				$mail->AddAddress($to_email);
				$mail->Subject = "ATutor GameMe Notification";
				$mail->Body    = $tmp_message;

				if(!$mail->Send()) {
					//echo 'There was an error sending the message';
				   $msg->printErrors('SENDING_ERROR');
				   exit;
				} else{
				 //debug_to_log('send success');
				}
				unset($mail);

			} else {
			    $msg->addError('no email provided');
			}
	return true;
    
    }
    
    /* Gets a list of the badges a user has already earned
    * @$badges is an array of badges passed from events.php, to the callback,
    * forwarded to this funciton to turn into a table of badges to be 
    * sent in the email
    */
    public static function getCurrentBadges($badges){
    	if(!empty($badges)){
    		$current_badges .='<h3>Your other badges earned so far</h3>'."\n";                  
            $current_badges .= '<table style="border:1px solid #eeeeee;width:97%;">';     
            foreach ($badges as $badge) {
                $sql = "SELECT image_url FROM %sgm_badges WHERE id=%d";
                $badge_image = queryDB($sql, array(TABLE_PREFIX, $badge->getIdBadge()), TRUE);
                $current_badges .=  '<tr><td style="background-color:#eeeee;"><img src="'.AT_BASE_HREF.$badge_image['image_url'].'" alt="'.$badge->getBadge()->getTitle().'" style="vertical-align:top"/></td>';
                $current_badges .=  '<td style="background-color:#efefef; padding:.3em;"><strong>'.$badge->getBadge()->getTitle().'</strong><br/>'.$badge->getBadge()->getDescription().'</td></tr>'."\n";
            }
            $current_badges .= "</table>";
    	}
    	return $current_badges;
    }
    /* Gets the details for the badge just earned
    * @$params bassed from events.php, to the callback, forwared to this function
    * @$feedback a feedback message to be sent along in the email, defined in the 
    * callback functions above.
    */
    public static function getNewBadge($params, $feedback){
    		$earned_badge = self::getBadge($params['alias']);
        	$new_badge .='<div style="width:97%;padding-left: 2em;border:1px solid #cccccc;background-color:#f6f4da;"><h2>'.$_SESSION['course_title'].'</h2></div>';
            $new_badge .= '<p> Hi '.$params['firstname']."!</p>\n\n";
            $new_badge .= "<p>".$feedback." <br /></p>" ;
            
            $new_badge .= '<table  style="border:1px solid #eeeeee;width:97%;">'."\n";
            $new_badge .= '<tr><td style="background-color:#eeeee;"><img src="'.$earned_badge['image_url'].'" alt ="'.$earned_badge['title'].'" /></td>
                    <td style="background-color:#efefef; padding:.3em;"><strong>'.$earned_badge['title'].'</strong><br/>'.$earned_badge['description'].'</td></tr>'."\n";
            $new_badge.='</table><br /><br />'."\n"; 
            
            return $new_badge;
    }
    
    /* Figures out where to get the badge image from, either 
    * 1. a custom badge created by the instructor
    * 2. a custom badge created by the administrator
    * 3. the default badge that comes with the module
    * -in that order, whichever come first-
    * @$alias the alias for the badge defined in the gm_badges table, 
    * and passed from the events.php file 
    */    
    public static function getBadgeFile($alias){
        global $_base_href;
        if($_SESSION['course_id'] > 0){
            $is_course = " AND course_id=".$_SESSION['course_id'];
        } else{
            $is_course = " AND course_id=0";
        }
        
        $sql = "SELECT * from %sgm_badges WHERE alias = '%s' $is_course";
        if($badge = queryDB($sql, array(TABLE_PREFIX, $alias), TRUE)){
            // all good
        }else{
            // course badge does not exist so get the system default
            $sql = "SELECT * from %sgm_badges WHERE alias = '%s' AND course_id=0";
            $badge = queryDB($sql, array(TABLE_PREFIX, $alias), TRUE);
        }

        if(!file_get_contents($_base_href.$badge['image_url'])){
            $content_dir = explode('/',AT_CONTENT_DIR);
            array_pop($content_dir);
            $badge_file_name = explode("/",$badge['image_url']);
            $badge_file = end($content_dir).'/0/gameme/badges/'.end($badge_file_name);
        } else{
            $badge_file = $_base_href.$badge['image_url'];
        }
            return $badge_file;
    }
    
    /* Gets the badge details from the database, either
    * 1. a badge created by the instructor for a particular course
    * 2. a custom badge create by the administrator
    * 3. the default badge that come with the module
    * -in that order, whichever come first-
    * @$alias the alias for the badge defined in the gm_badges table, 
    * and passed from the events.php file 
    */
    public static function getBadge($alias){
        if($_SESSION['course_id'] > 0){
            $is_course = " AND course_id=".$_SESSION['course_id'];
        } else{
            $is_course = " AND course_id=0";
        }
        $sql = "SELECT * from %sgm_badges WHERE alias = '%s' $is_course";
        if($badge = queryDB($sql, array(TABLE_PREFIX, $alias), TRUE)){
            // all good
        }else{
            // course badge does not exist so get the system default
            $sql = "SELECT * from %sgm_badges WHERE alias = '%s' AND course_id=0";
            $badge = queryDB($sql, array(TABLE_PREFIX, $alias), TRUE);
        }
        $badge['image_url']= self::getBadgeFile($badge['alias']);
        return $badge;
    }
    
    static function myPostToChatReachCallBackFunction(){
        //echo "<br><i>Posted to chat so many times and granted a Badge! Send some email or call an API endpoint...</i>";
        // IT MUST RETURN TRUE to gamification continue to flow.
        // Returning true it will give the points and badges like setup
        // Returning false it will don't give any points of badges for that event
        return true;
    }
}