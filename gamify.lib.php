<?php
namespace gamify;

function getLeaders(PHPGamification $gamification, $leader_depth){
    echo "<h3>Leaders</h3>";
    $sql = "SELECT member_id FROM %scourses WHERE course_id = %d";
    $instructor = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id']), TRUE);
    $leaders = $gamification->getUsersPointsRanking($leader_depth);
    $count = 0;
    $leader_board = '<table 
        style="
        width:95%; 
        border-top:1px solid #ded29e;
        border-bottom:1px solid #ded29e;
        text-align:center;"><tr><th>#</th><th>ID</th><th>Points</th><th>Level</th></tr>';
   if(!empty($leaders)){
    foreach($leaders as $key=>$leader){
        // don't display instructor on leader board
        if($instructor['member_id'] != $leader->id_user){
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
function getLoginName($mid){
    $sql = "SELECT login FROM %smembers WHERE member_id=%d";
    $member_login = queryDB($sql, array(TABLE_PREFIX, $mid), TRUE);
    return $member_login['login'];
}
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
                    echo "<p>You are in position: ".$count."</p>";
                }
            }
    }
    return $member_login['login'];
}
function getBadgeImage(PHPGamification $gamification, $badge_id){
    global $_base_href;
    //$badges = $gamification->getUserBadges();   
    $sql = "SELECT image_url, description FROM %sgm_badges WHERE id=%d";
    $badge_image = queryDB($sql, array(TABLE_PREFIX, $badge_id), TRUE);
    return '<img src="'.$_base_href.$badge_image['image_url'].'" alt="'.$badge_image['description'].'" title="'.$badge_image['description'].'" style="margin:.2em;"/>'; 
}

function showUserScores(PHPGamification $gamification){
    echo "<h3>Levels Awarded</h3>";
    $score = $gamification->getUserScores();
    echo showstars_lg($score->getPoints());
    echo "Points: " . $score->getPoints() . " - Id Level: " . $score->getIdLevel() . " - Progress: " . $score->getProgress() . " - Level Name: " . $score->getLevel()->getTitle() . "<br>";
}

function showUserScore(PHPGamification $gamification, $courseId){
    //echo "<h3>Your Scores</h3>";
    $score = $gamification->getUserScores();
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
    >Points: " . $score->getPoints() . " </div><br /><hr />
    
<h3>Levels Awarded</h3>
    <div style='background-color:#eeeeee; width:100%;height:1.8em; padding:.2em;margin-left:auto;margin-right:auto;box-shadow: .1em .1em .1em;#666666;' >".showstars($score->getPoints())."<br />".showUserProgress($gamification, $_SESSION['course_id'])."</div><br /><br /><hr />";
}
function showUserProgress(PHPGamification $gamification, $courseId){
$score = $gamification->getUserScores();
 return "<br >Progess to next level: ".$score->getProgress() ."/100";
}
function showstars($points){
    global $_base_href;
    $sql = "SELECT * FROM %sgm_levels ORDER BY id desc";
    $levels = queryDB($sql, array(TABLE_PREFIX));
        foreach($levels as $level){
            if($points >=$level['points'] ){
                $stars .= '<img src="'.$_base_href.'mods/gamify/images/'.$level['icon'].'" alt="'.$level['title'].': '.$level['description'].'" title="'.$level['title'].': '.$level['description'].'" style="height:1.8em;width:1.8em;vertical-align:middle;margin-right:.2em;"/>';
            }  
        }
    
    return $stars;
}
function showstars_lg($points){
$sql = "SELECT * FROM %sgm_levels ORDER BY id desc";
    $levels = queryDB($sql, array(TABLE_PREFIX));
    if(strpos($_SERVER['PHP_SELF'], "gamify/index.php")){
        $stars .= "<ul>";
        foreach($levels as $level){
            if($points >=$level['points'] ){
                $lg_star = str_replace(".", "_lg.", $level['icon']);
                $stars .= '<li style="list-style-type:none;"><img src="'.$_base_href.'mods/gamify/images/'.$lg_star.'" alt="'.$level['title'].': '.$level['description'].'" title="'.$level['title'].': '.$level['description'].'" style="vertical-align:middle;margin-left:.2em;"/>'.$level['title'].': '.$level['description'].'</li>';
            }  
        $stars .= "</ul>";
        }
    }
    return $stars;
}
function showUserBadges(PHPGamification $gamification)
{
    echo "<h3>Your Badges</h3>";
    $badges = $gamification->getUserBadges();
    if ($badges){
        foreach ($badges as $badge) {
            echo getBadgeImage( $gamification, $badge->getIdBadge());
            echo "Badge Id: " . $badge->getIdBadge() . " -  Counter: " . $badge->getBadgeCounter() . " - Alias: " .     $badge->getBadge()->getAlias() . " - Description: " . $badge->getBadge()->getDescription() . " <br>";
        }
    }
}
function showUserBadge(PHPGamification $gamification)
{
    echo "<h3>Your Badges</h3>";
    $badges = $gamification->getUserBadges();
    if ($badges){
        foreach ($badges as $badge) {
            echo getBadgeImage( $gamification, $badge->getIdBadge());

        }
    }
    echo "<hr />";
}
function showUserEvents(PHPGamification $gamification){
    echo "<h2>Events</h2>";
    $events = $gamification->getUserEvents();
    echo "<ul style='margin-left:1em;line-height:1.8em;'>";
    foreach ($events as $event) {
//        var_dump($event);
        echo "<li>".$event['event']->getDescription(). " - Counter: $event[counter]";
        //echo "Event Id: $event[id] - Alias: " . $event['event']->getAlias() . " - Counter: $event[counter]<br>";
        foreach ($event['triggers'] as $k => $trigger)
            echo " &nbsp;  &nbsp; Trigger: $k - Reached: " . ($trigger['reached'] ? "true" : "false") . "</li>";
    }
    echo "</ul>";
}
function showUserAlerts(PHPGamification $gamification){
 echo "<h3>Your Alerts</h3>";
    $alerts = $gamification->getUserAlerts();
    if ($alerts == null) {
        echo "No level or badge alerts to show<br>";
    } else {
        foreach ($alerts as $alert) {
            if ($alert->getIdBadge())
                echo "Badge: " . $alert->getBadge()->getTitle(). " - Id Badge: ".$alert->getIdBadge();
            if ($alert->getIdLevel())
                echo "Level: " . $alert->getIdLevel() . " - Id Level: " . $alert->getIdLevel();
            echo "<br>";
        }
    }
}

function showUserLog(PHPGamification $gamification){
 echo "<h2>Your Activity Log</h2>";
    $logs = $gamification->getUserLog();
    if ($logs)
        foreach ($logs as $log) {
            echo "EventDate: " . $log->getEventDate()." - Id Event: " . $log->getIdEvent() . " -  Event: ".$log->getEvent()->getAlias();
            if ($log->getPoints())
                echo " - Points: " . $log->getPoints();
            if ($log->getIdBadge())
                echo " - Badge: " . $log->getBadge()->getTitle(). " - Id Badge: ".$log->getIdBadge();
            if ($log->getIdLevel())
                echo " - Level: " . $log->getIdLevel() . " - Id Level: " . $log->getIdLevel();
            echo "<br>";
        }
}
?>