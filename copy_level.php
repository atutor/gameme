<?php
namespace gameme\PHPGamification;
use Exception;
use gameme\PHPGamification;
use gameme\PHPGamification\Model;
use gameme\PHPGamification\Model\Level;

define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');

$_GET["id"] = intval($_GET["id"]);

if($_GET["id"]!= ''){
    global $_base_path;
    $course_id = $_SESSION['course_id'];
    $this_path =  preg_replace ('#/get.php#','',$_SERVER['DOCUMENT_ROOT'].$_base_path);
    $sql = "SELECT * FROM %sgm_levels WHERE id=%d AND course_id=%d";
    $default_level = queryDB($sql, array(TABLE_PREFIX, $_GET["id"], 0), TRUE);
    require_once($this_path.'mods/gameme/gamify.lib.php');
    require_once($this_path.'mods/gameme/PHPGamification/PHPGamification.class.php');
    $gamification = new PHPGamification();
    $gamification->setDAO(new DAO(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD));

    $gamification->copyLevel(
        $default_level['id'], 
        $default_level['title'], 
        $default_level['description'],
        $default_level['points'],
        $default_level['icon']
        //str_replace(".", "_lg.", $default_level['icon'])
        );
    $msg->addFeedback('LEVEL_COPIED');
    header("Location: ".AT_BASE_HREF."mods/gameme/index_instructor.php");
    exit;
}

?>