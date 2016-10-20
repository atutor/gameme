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
} else if (isset($_POST['submit_yes']) || isset($_POST['level_id'])) {
    if($_SESSION['course_id'] > 0){
        $course_id = $_SESSION['course_id'];
    }else{
        $course_id=0;
    }
    // remove the level icon file
    $sql = "SELECT icon FROM %sgm_levels WHERE course_id = %d AND id=%d";
    $level_file = queryDB($sql, array(TABLE_PREFIX,  $course_id, $_POST['level_id']), TRUE);
    unlink($_SERVER["DOCUMENT_ROOT"].$_base_path.'content/'.$course_id.'/gamify/levels/'.$level_file['icon']);
    
    $sql = "DELETE FROM %sgm_levels WHERE id=%d AND course_id = %d LIMIT 1";
    queryDB($sql, array(TABLE_PREFIX, $_POST['level_id'], $course_id));
    $msg->addFeedback('LEVEL_REMOVED');
    
    if($_SESSION['is_admin'] >0){
	    header("Location: ".AT_BASE_HREF."mods/gamify/index_instructor.php");
	}else{
	    header("Location: ".AT_BASE_HREF."mods/gamify/index_admin.php");
	}
	exit;
}
require (AT_INCLUDE_PATH.'header.inc.php');

unset($hidden_vars);
$hidden_vars['level_id'] = intval($_GET['id']);
//$hidden_vars['course_id'] = intval($_SESSION['course_id']);

$msg->addConfirm(array('DELETE_LEVEL'), $hidden_vars);

$msg->printConfirm();

require (AT_INCLUDE_PATH.'footer.inc.php'); ?>