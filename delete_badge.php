<?php
namespace gameme;
use gameme\PHPGamification\DAO;

global $_base_path;
$_user_location	= 'admin';
define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');

if (isset($_POST['submit_no'])) {
	$msg->addFeedback('CANCELLED');
    if($_SESSION['is_admin'] >0){
	    header("Location: ".AT_BASE_HREF."mods/gameme/index_instructor.php");
	}else{
	    header("Location: ".AT_BASE_HREF."mods/gameme/index_admin.php");
	}
	exit;
} else if (isset($_POST['submit_yes'])) {
    if($_SESSION['course_id'] > 0){
        $course_id = $_SESSION['course_id'];
    }else{
        $course_id=0;
    }
    // remove the badge file
    $sql = "SELECT image_url FROM %sgm_badges WHERE course_id = %d AND id=%d";
    $badge_file = queryDB($sql, array(TABLE_PREFIX,  $course_id, $_POST['badge_id']), TRUE);
    unlink($_SERVER["DOCUMENT_ROOT"].$_base_path.$badge_file['image_url']);
    // remove the badge from the DB
    $sql = "DELETE FROM %sgm_badges WHERE id=%d AND course_id = %d LIMIT 1";
    queryDB($sql, array(TABLE_PREFIX, $_POST['badge_id'], $course_id));
    
    $msg->addFeedback('GM_BADGE_REMOVED');
    
    if($_SESSION['is_admin'] >0){
	    header("Location: ".AT_BASE_HREF."mods/gameme/index_instructor.php");
	}else{
	    header("Location: ".AT_BASE_HREF."mods/gameme/index_admin.php");
	}
	exit;
}
require (AT_INCLUDE_PATH.'header.inc.php');

unset($hidden_vars);
$hidden_vars['badge_id'] = intval($_GET['id']);
//$hidden_vars['course_id'] = intval($_SESSION['course_id']);

$msg->addConfirm(array('GM_DELETE_BADGE'), $hidden_vars);

$msg->printConfirm();

require (AT_INCLUDE_PATH.'footer.inc.php'); ?>