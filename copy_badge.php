<?php
namespace gamify\PHPGamification;
use Exception;
use gamify\PHPGamification;
use gamify\PHPGamification\Model;
use gamify\PHPGamification\Model\Event;
use gamify\PHPGamification\Model\Badge;

define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');

$_GET["id"] = intval($_GET["id"]);

if($_GET["id"]!= ''){
    global $_base_path;
    $course_id = $_SESSION['course_id'];
    $this_path =  preg_replace ('#/get.php#','',$_SERVER['DOCUMENT_ROOT'].$_base_path);
    $sql = "SELECT * FROM %sgm_badges WHERE id=%d AND course_id=%d";
    $default_badge = queryDB($sql, array(TABLE_PREFIX, $_GET["id"], 0), TRUE);

        require_once($this_path.'mods/gamify/gamify.lib.php');
        require_once($this_path.'mods/gamify/PHPGamification/PHPGamification.class.php');
        $gamification = new PHPGamification();
        $gamification->setDAO(new DAO(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD));

if($gamification->copyBadge($default_badge['id'], 
        $default_badge['alias'], 
        $default_badge['title'], 
        $default_badge['description'], 
        $default_badge['image_url'])){
            $msg->addFeedback('BADGE_COPIED');
            header("Location: ".AT_BASE_HREF."mods/gamify/index_instructor.php");
            exit;
       } else{
            $msg->addError('BADGE_COPY_FAILED');
            header("Location: ".AT_BASE_HREF."mods/gamify/index_instructor.php");
            exit;
       }
}

?>