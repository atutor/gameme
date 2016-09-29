<?php 
namespace gamify;
use gamify\PHPGamification\DAO;
/* start output buffering: */
global $savant;
ob_start(); ?>

<?php
global $_base_path;
// this line is a hack
$this_path =  preg_replace ('#/get.php#','',$_SERVER['DOCUMENT_ROOT'].$_base_path);
require_once($this_path.'mods/gamify/gamify.lib.php');
require_once($this_path.'mods/gamify/PHPGamification/PHPGamification.class.php');
$gamification = new PHPGamification();
$gamification->setDAO(new DAO(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD));
$gamification->setUserId($_SESSION['member_id']);
showUserScore($gamification, $_SESSION['course_id']);
showUserBadge($gamification);
echo getLeaders($gamification, 5);
//echo getUserPointsRanking($gamification, 5);
echo yourPosition($_SESSION['member_id']);
$savant->assign('dropdown_contents', ob_get_contents());
ob_end_clean();

$savant->assign('title', _AT('gamify')); // the box title
$savant->display('include/box.tmpl.php');
?>