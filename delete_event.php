<?php
namespace gamify;
use gamify\PHPGamification\DAO;

global $_base_path;
$_user_location	= 'admin';
define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');
$_custom_css = $_base_path . 'mods/hello_world/module.css'; // use a custom stylesheet

if (isset($_POST['submit_no'])) {
	$msg->addFeedback('CANCELLED');
    if($_SESSION['is_admin'] >0){
	    header("Location: ".AT_BASE_HREF."mods/gamify/index_instructor.php");
	}else{
	    header("Location: ".AT_BASE_HREF."mods/gamify/index_admin.php");
	}
	exit;
} else if (isset($_POST['submit_yes'])) {
    if($_SESSION['course_id'] > 0){
        $course_id = $_SESSION['course_id'];
    }else{
        $course_id=0;
    }
    $sql = "DELETE FROM %sgm_events WHERE id=%d AND course_id = %d LIMIT 1";
    queryDB($sql, array(TABLE_PREFIX, $_POST['event_id'], $course_id));
    $msg->addFeedback('EVENT_REMOVED');
    if($_SESSION['is_admin'] >0){
	    header("Location: ".AT_BASE_HREF."mods/gamify/index_instructor.php");
	}else{
	    header("Location: ".AT_BASE_HREF."mods/gamify/index_admin.php");
	}
	exit;
}
require (AT_INCLUDE_PATH.'header.inc.php');

unset($hidden_vars);
$hidden_vars['event_id'] = intval($_GET['id']);
$msg->addConfirm(array('DELETE_EVENT'), $hidden_vars);

$msg->printConfirm();

require (AT_INCLUDE_PATH.'footer.inc.php'); ?>