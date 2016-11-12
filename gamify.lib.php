<?php
namespace gameme;

/* Get a list of gameme leaders in a course
* @$gamificaiton - a PHPGamifcations object
* @$leader_depth - the number of leaders to display
*/
function getLeaders(PHPGamification $gamification, $leader_depth){
    echo "<h3>"._AT('gm_leaders_top', $leader_depth)."</h3>";
    $leaders = $gamification->getUsersPointsRanking($leader_depth);
    $sql = "SELECT member_id FROM %scourses WHERE course_id = %d";
    $instructor = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id']), TRUE);
    $count = 0;
    $leader_board = '<table 
        style="
        width:95%; 
        border-top:1px solid #ded29e;
        border-bottom:1px solid #ded29e;
        text-align:center;"><tr><th>#</th><th>'._AT('gm_id').'</th><th>'._AT('gm_points').'</th><th>'._AT('gm_level').'</th></tr>';
   if(!empty($leaders)){
    foreach($leaders as $key=>$leader){
        // don't display instructor on leader board
            if($instructor['member_id'] == $leader->id_user){
                if(show_instructor() == 1){
                    $login_name = getLoginName($leader->id_user);
                    $count++;
                    $leader_board .= '<tr>
                    <td>'.$count.'</td>
                    <td>'.$login_name.'</td>
                    <td>'.$leader->points.'</td>
                    <td>'.$leader->id_level.'</td>
                    </tr>'."\n"; 
                }
            } else if($instructor['member_id'] != $leader->id_user){
                $login_name = getLoginName($leader->id_user);
                $count++;
                $leader_board .= '<tr>
                <td>'.$count.'</td>
                <td>'.$login_name.'</td>
                <td>'.$leader->points.'</td>
                <td>'.$leader->id_level.'</td>
                </tr>'."\n"; 
                }
            }  
    }
    $leader_board .='</table>';
    echo $leader_board;
}  
/*


*/
function getLoginName($mid){
    $sql = "SELECT login FROM %smembers WHERE member_id=%d";
    $member_login = queryDB($sql, array(TABLE_PREFIX, $mid), TRUE);
    return $member_login['login'];
}
/*


*/
function yourPosition($mid){
    $sql = "SELECT * FROM %sgm_user_scores WHERE course_id = %d ORDER BY points DESC";
    $leaders_desc = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id']));
    
    $sql = "SELECT member_id FROM %scourses WHERE course_id = %d";
    $instructor = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id']), TRUE);
    
    $count = 0;
    foreach($leaders_desc as $leader){
            // remove instructor from leader board
            if($leader['id_user'] != $instructor['member_id']){
                $count++;
                if($leader['id_user'] == $_SESSION['member_id'] && !$_SESSION['is_admin']){
                    echo "<p>"._AT('gm_in_position' , $count)."</p>"."\n";
                }
            }
    }
    return $member_login['login'];
}
/*


*/
function showUserScores(PHPGamification $gamification){
    echo "<h3>"._AT('gm_levels_awarded')."</h3>";
    $score = $gamification->getUserScores();
    echo "<table class='data'>";
    echo "<tr>
    <th>&nbsp;</th>
    <th>"._AT('gm_level')."</th>
    <th>"._AT('gm_description')."</th>
    </tr>"."\n";
    echo showstars($score->getPoints());
    echo "</table>";
}
/*


*/  
function showUserScore(PHPGamification $gamification, $courseId){
    $score = $gamification->getUserScores();
    if($score->getPoints() == 0){
        echo '<div style="text-align:center;">'._AT('gm_login_for_points').'</div>';
    }
    echo "<div style=' 
    width:80%;
    font-size:2em;
    text-align:center;
    margin-top:.5em;
    margin-left:auto;
    margin-right:auto;   
    border: 1px solid green;
    box-shadow: .1em .1em .1em;#666666;
    background-color: #e9fbe9;
    border-radius:.3em;
    padding:.2em;'
    >"._AT('gm_points').": " . $score->getPoints() . " </div><br /><hr />";
}
/*


*/ 
function showUserLevels(PHPGamification $gamification, $course_id)
{
    $score = $gamification->getUserScores();
    echo "<h3>"._AT('gm_your_levels_reached')."</h3>";
    if ($score){
        $sql = "SELECT `value` from %sgm_options WHERE `course_id`=%d AND `option`='%s'";
        if($level_max = queryDB($sql, array(TABLE_PREFIX, $course_id, "level_count"),TRUE)){
            if($level_max['value']  >0){
                $limit = " LIMIT ".$level_max['value'];
            }
        }

        echo "<table class='data'>
        <tr>
        <th>"._AT('gm_level')."</th>
        <th>"._AT('gm_title')."</th>
        <th>"._AT('gm_description')."</th>
        <th>"._AT('gm_points')."</th>
        </tr>";
        // get a list of course level ids
        $sql = "SELECT id FROM %sgm_levels WHERE course_id=%d";
        $course_levels = queryDB($sql, array(TABLE_PREFIX, $course_id));

        $sql = "SELECT * FROM %sgm_levels WHERE points < %d ORDER BY points asc $limit ";
        $my_levels = queryDB($sql, array(TABLE_PREFIX, $score->getPoints()));

        foreach($my_levels as $level){
            // check if a level id exists in the list of course level ids, if not then echo default level
            if(!in_array($level['id'], $course_levels) && $level['course_id'] ==0){
                echo "<tr>";
                echo "<td>".showstar($level['points'])."</td>";
                echo "<td>".$level['title']."</td>";
                echo "<td>".$level['description']."</td>";
                echo "<td>".$level['points']."</td>";            
                echo "</tr>"."\n";
            }
            $count++;
        }
        echo "</table>";
    }
}

/*


*/
function showUserLevel(PHPGamification $gamification, $courseId){
$score = $gamification->getUserScores();
echo "<h3>"._AT('gm_levels_awarded')."</h3>
    <div style='background-color:#f6f6f6; width:100%; padding:.2em;margin-left:auto;margin-right:auto;' >".showstars($score->getPoints())."</div>";
    
}

/*


*/
function showUserProgress(PHPGamification $gamification, $courseId){
$score = $gamification->getUserScores();
 return "<br >"._AT('gm_progress_to_next', $score->getProgress())."<hr />";
}

/*


*/
function showstars($points){
    global $_base_href;
    
    $sql = "SELECT `value` from %sgm_options WHERE `course_id`=%d AND `option`='%s'";
        if($level_max = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id'], "level_count"),TRUE)){
            if($level_max['value']  >0){
                $limit = " LIMIT ".$level_max['value'];
            }
        }
    $sql = "SELECT * FROM %sgm_levels WHERE course_id = %d AND points <= %d ORDER BY id asc $limit";
    $levels = queryDB($sql, array(TABLE_PREFIX, 0, $points));
    
    $sql = "SELECT id FROM %sgm_levels WHERE course_id = %d AND points <= %d ORDER BY id asc $limit";
    $course_levels = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id'], $points));
    
    $this_levels = array();
    foreach($course_levels as $course_level){
        array_push($this_levels, $course_level['id']);
    }
    $content_dir = explode('/',AT_CONTENT_DIR);
    array_pop($content_dir);
    foreach($levels as $level){
        $sql = "SELECT icon, title, description FROM %sgm_levels WHERE id=%d AND course_id=%d";
        $level_image = queryDB($sql, array(TABLE_PREFIX, $level['id'],$_SESSION['course_id']), TRUE);

        if(!empty($level_image['icon'])){
            if(file_get_contents($_base_href.end($content_dir).'/'.$_SESSION['course_id'].'/gameme/levels/'.$level_image['icon'])){
                $level_file =  $_base_href.end($content_dir).'/'.$_SESSION['course_id'].'/gameme/levels/'.$level_image['icon'];
            }else if(file_get_contents($_base_href.'content/0/gameme/levels/'.$level_image['icon'])){
                $level_file =$_base_href.'content/0/gameme/levels/'.$level_image['icon'];
            }else {
                $level_file = $_base_href.'mods/gameme/images/'.$level_image['icon'];
            }
        } else {
            if(!in_array($level['id'] , $course_levels)){
            $sql = "SELECT icon, title, description FROM %sgm_levels WHERE id=%d AND course_id=%d";
            $level_image = queryDB($sql, array(TABLE_PREFIX, $level['id'],0), TRUE);
            
            if(!file_get_contents($_base_href.'content/0/gameme/levels/'.$level_image['icon'])){
                $level_file = $_base_href.'mods/gameme/images/'.$level_image['icon'];
            } else {
                $content_dir = explode('/',AT_CONTENT_DIR);
                array_pop($content_dir);
                $level_file = $_base_href.end($content_dir).'/0/gameme/levels/'.$level_image['icon'];
            }
            }
        }
        $stars .= '<img src="'.$level_file.'" alt="'.$level_image['title'].'" title="'.$level_image['title'].' '.$level_image['description'].'" style="margin:.2em;"/>'."\n";
    }
    
    return $stars;
}
function showstar($points){
    global $_base_href;
    $sql = "SELECT * FROM %sgm_levels WHERE course_id = %d AND points = %d";
    $level = queryDB($sql, array(TABLE_PREFIX, 0, $points), TRUE);
    
    $sql = "SELECT id FROM %sgm_levels WHERE course_id = %d AND points = %d";
    $course_levels = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id'], $points), TRUE);
    
    $content_dir = explode('/',AT_CONTENT_DIR);
    array_pop($content_dir);
    
    $sql = "SELECT icon, title, description FROM %sgm_levels WHERE id=%d AND course_id=%d";
    $level_image = queryDB($sql, array(TABLE_PREFIX, $level['id'],$_SESSION['course_id']), TRUE);
    
    // this chunk doubles the page load time
    if(!empty($level_image['icon'])){
        if(file_get_contents($_base_href.end($content_dir).'/'.$_SESSION['course_id'].'/gameme/levels/'.$level_image['icon'])){
            $level_file =  $_base_href.end($content_dir).'/'.$_SESSION['course_id'].'/gameme/levels/'.$level_image['icon'];
        }else if(file_get_contents($_base_href.end($content_dir).'/0/gameme/levels/'.$level_image['icon'])){
            $level_file =$_base_href.end($content_dir).'/0/gameme/levels/'.$level_image['icon'];
        }else {
            $level_file = $_base_href.'mods/gameme/images/'.$level_image['icon'];
        }
    } else {
        if(!in_array($level['id'] , $course_levels)){
        $sql = "SELECT icon, title, description FROM %sgm_levels WHERE id=%d AND course_id=%d";
        $level_image = queryDB($sql, array(TABLE_PREFIX, $level['id'],0), TRUE);
        if(!file_get_contents($_base_href.end($content_dir).'/0/gameme/levels/'.$level_image['icon'])){
            $level_file = $_base_href.'mods/gameme/images/'.$level_image['icon'];
        } else {
            $content_dir = explode('/',AT_CONTENT_DIR);
            array_pop($content_dir);
            $level_file = $_base_href.end($content_dir).'/0/gameme/levels/'.$level_image['icon'];
        }
        }
    }

    $star .= '<img src="'.$level_file.'" alt="'.$level['title'].'" title="'.$level_image['title'].' '.$level_image['description'].'" style="margin:.2em;"/>'."\n";

    return $star;
}

/*
*
*
*/
function showUserBadges(PHPGamification $gamification)
{
    echo "<h3>"._AT('gm_manage_badges')."</h3>";
    $badges = $gamification->getUserBadges();
    if ($badges){
        echo "<table class='data'>
        <tr>
        <th>&nbsp;</th>
        <th>"._AT('gm_badge_id')."</th>
        <th>"._AT('gm_counter')."</th>
        <th>"._AT('gm_alias')."</th>
        <th>"._AT('gm_description')."</th>
        </tr>";
        foreach ($badges as $badge) {
            echo "<tr>";
            echo "<td>".getBadgeImage( $gamification, $badge->getIdBadge())."</td>";
            echo "<td>".$badge->getIdBadge()."</td>";
            echo "<td>".$badge->getBadgeCounter()."</td>";
            echo "<td>".$badge->getBadge()->getAlias()."</td>";
            echo "<td>".$badge->getBadge()->getDescription()."</td>";            
            echo "</tr>"."\n";
        }
        echo "</table>";
    }
}
function showUserBadgesStudents(PHPGamification $gamification)
{
    echo "<h3>"._AT('gm_your_badges')."</h3>";
    $badges = $gamification->getUserBadges();
    if ($badges){
        echo "<table class='data'>
        <tr>
        <th>&nbsp;</th>
        <!--<th>"._AT('gm_counter')."</th>-->
        <th>"._AT('gm_title')."</th>
        <th>"._AT('gm_description')."</th>
        </tr>";
        foreach ($badges as $badge) {
            echo "<tr>";
            echo "<td>".getBadgeImage( $gamification, $badge->getIdBadge())."</td>";;
            //echo "<td>".$badge->getBadgeCounter()."</td>";
            echo "<td>".$badge->getBadge()->getTitle()."</td>";
            echo "<td>".$badge->getBadge()->getDescription()."</td>";            
            echo "</tr>"."\n";
        }
        echo "</table>";
    }
}
/*
*
*
*/
function showUserBadge(PHPGamification $gamification, $course_id)
{
    echo "<h3>"._AT('gm_your_badges')."</h3>";
    $badges = $gamification->getUserBadges();
    if ($badges){
        foreach ($badges as $badge) {
            echo getBadgeImage( $gamification, $badge->getIdBadge(), $course_id);

        }
    }
    echo "<hr />";
}
/*
*
*
*/
function getBadgeImage(PHPGamification $gamification, $badge_id){
    global $_base_href; 
    $sql = "SELECT image_url, description FROM %sgm_badges WHERE id=%d AND course_id=%d";
    $badge_image = queryDB($sql, array(TABLE_PREFIX, $badge_id,$_SESSION['course_id']), TRUE);
    if(empty($badge_image)){
        $sql = "SELECT image_url, description FROM %sgm_badges WHERE id=%d AND course_id=%d";
        $badge_image = queryDB($sql, array(TABLE_PREFIX, $badge_id,0), TRUE);
        $badge_file = $_base_href.$badge_image['image_url'];
    }
    else{
        $badge_file = $_base_href.$badge_image['image_url'];
    }
    
    return '<img src="'.$badge_file.'" alt="'.$badge_image['description'].'" title="'.$badge_image['description'].'" style="margin:.2em;"/>'."\n"; 
}
/*
*
*
*/
function showUserEvents(PHPGamification $gamification){
    echo "<h2>"._AT('gm_events')."</h2>";
    $events = $gamification->getUserEvents();
    echo "<ul style='margin-left:1em;line-height:1.8em;'>"."\n";
    foreach ($events as $event) {
        echo '<li><strong>'.$event['event']->getDescription(). '</strong> - '._AT('gm_count').'('.$event[counter].')<br />';
        echo $event['event']->getReachMessage();      
    }
    echo "</ul>"."\n";
}
/*
*
*
*/
function showUserAlerts(PHPGamification $gamification){
 echo "<h3>"._AT('gm_your_alert')."</h3>"."\n";
    $alerts = $gamification->getUserAlerts();
    if ($alerts == null) {
        echo _AT('gm_no_alerts')."<br/>";
    } else {
        foreach ($alerts as $alert) {
            if ($alert->getIdBadge())
                echo _AT('gm_badge').": " . $alert->getBadge()->getTitle();
            if ($alert->getIdLevel())
            echo _AT('gm_level').": " . $alert->getIdLevel();
            echo "<br>"."\n";
        }
    }
}
/*
*
*
*/
function showUserLog(PHPGamification $gamification){
 echo "<h2>"._AT('gm_your_activity_log')."</h2>";
    $logs = $gamification->getUserLog();
    if ($logs)
        echo "<table class='data'>
        <tr>
        <th>"._AT('gm_event_date')."</th>
        <th>"._AT('gm_event')."</th>
        <th>"._AT('gm_points')."</th>
        <th>"._AT('gm_badge')."</th>
        <th>"._AT('gm_level')."</th>
        </tr>";
        foreach ($logs as $log) {
            echo "<tr>";
            echo "<td>".$log->getEventDate()."</td><td>".$log->getEvent()->getAlias()."</td>";
            if ($log->getPoints()){
                echo "<td>".$log->getPoints()."</td>";
            }else{
                echo "<td>&nbsp</td>";
            }
            if ($log->getIdBadge()){
                echo "<td>".$log->getBadge()->getTitle()."</td>";
            }else{
                echo "<td>&nbsp</td>";
            }
            if ($log->getIdLevel()){
                echo "<td>".$log->getIdLevel()."</td>";
            }else{
                echo "<td>&nbsp</td>";
            }
            echo "</tr>"."\n";
        }
        echo "</table>";
}
function get_leader_count(){
        $sql = "SELECT * FROM %sgm_options WHERE `course_id`=%d and `option` = 'showleader_count'";
        $this_count = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id']), TRUE);
        return $this_count['value'];
}        
function show_instructor(){
    $sql = 'SELECT value FROM %sgm_options WHERE `option` = "%s" AND `course_id` = %d';
    $show_instructor = queryDB($sql, array(TABLE_PREFIX, 'showinstructor', $_SESSION['course_id']), TRUE);
    return $show_instructor['value'];
}  

/* Gets the reach message from the database, either
* 1. a message created by the instructor for a particular course
* 2. or the default message that come with the module
* -in that order, whichever come first-
* @$alias the alias for the event defined in the gm_events table, 
* and passed from the events.php file 
*/
function get_reach_message($alias){
         if($_SESSION['course_id'] > 0){
            $is_course = " AND course_id=".$_SESSION['course_id'];
        } else{
            $is_course = " AND course_id=0";
        }
        
        //$is_course = " AND course_id=".$_SESSION['course_id'];
        $sql = "SELECT reach_message from %sgm_events WHERE alias = '%s' $is_course";
        
        if($reach_message = queryDB($sql, array(TABLE_PREFIX, $alias), TRUE)){
            // all good
        }else{
            // reach message does not exist so get the system default
            $sql = "SELECT reach_message from %sgm_events WHERE alias = '%s' AND course_id=0";
            $reach_message = queryDB($sql, array(TABLE_PREFIX, $alias), TRUE);
        }
        return $reach_message['reach_message'];
    }
?>