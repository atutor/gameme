<?php
namespace gamify\PHPGamification;
use Exception;
use gamify\PHPGamification;
use gamify\PHPGamification\Model;
use gamify\PHPGamification\Model\Level;

define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');
admin_authenticate(AT_ADMIN_PRIV_GAMIFY);
$_custom_css = $_base_path . 'mods/gamify/module.css'; // use a custom stylesheet
$_custom_head ='<script type="text/javascript" src="'.$_base_path .'jscripts/lib/jquery.1.10.1.min.js"></script>'."\n";
$_custom_head.='<script type="text/javascript" src="'.$_base_path .'mods/gamify/gamify.js"></script>'."\n";
 $_custom_head.='  
	<script type="text/javascript">
	//<!--
	jQuery.noConflict();
	//-->
	</script>';
	
//debug($_POST);
if($_POST['cancel']){
$msg->addFeedback('cancelled');
header('Location:'.$_base_href.'mods/gamify/index_admin.php?tab=3');
exit;
}
if($_POST['submit']){
    global $_base_path;
    // this line is a hack
    $this_path =  preg_replace ('#/get.php#','',$_SERVER['DOCUMENT_ROOT'].$_base_path);
    require_once($this_path.'mods/gamify/gamify.lib.php');
    require_once($this_path.'mods/gamify/PHPGamification/PHPGamification.class.php');
    $gamification = new PHPGamification();
    $gamification->setDAO(new DAO(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD));
    
        
    if($_POST['id']){
        $gamification->addLevel(0, 'No Star');
    } else {
        $gamification->addLevel(0, 'No Star');
    }

    $msg->addFeedback('success');
    header('Location:'.$_base_href.'mods/gamify/index_admin.php?tab=3');
    exit;
}
require (AT_INCLUDE_PATH.'header.inc.php');
$sql = "SELECT * FROM %sgm_evels WHERE id = %d";
$this_level = queryDB($sql, array(TABLE_PREFIX, $_GET['id']), TRUE);

?>
<h2> Edit Level</h3>
<form name="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<input type="hidden" id="id" name="id" value="<?php echo $this_level['id']; ?>" />
<div class="input-form">
<fieldset class="group_form">
<legend class="group_form">Edit Level</legend>
<label for>Alias</label><br />
<?php
if(!isset($_GET['id'])){?>
    <input type="text" id="title" name="title" value="<?php echo $this_level['title']; ?>" />
<?php } else { ?>
    <strong><?php echo $this_level['title']; ?></strong>
    <input type="hidden" id="title" name="title" value="<?php echo $this_level['title']; ?>" />
<?php } ?>

<br /><br />
<label for="alias">Description</label><br />
<input type="text" id="description" name="description" value="<?php echo $this_level['description']; ?>"  size="48"/><br />
<label for="points">Points Reached</label> (Point scored to reach level)<br />
<input type="text" id="points" name="points" value="<?php echo $this_level['points']; ?>" maxlength="8" size="8" /><br />

<input type="submit" name="submit" value="Update Level"/><input type="submit" name="cancel" value="Cancel"/>
</fieldset>
</div>
</form>

<?php require (AT_INCLUDE_PATH.'footer.inc.php'); ?>