<?php
namespace gamify\PHPGamification;
use Exception;
use gamify\PHPGamification;
use gamify\PHPGamification\Model;
use gamify\PHPGamification\Model\Event;

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
header('Location:'.$_base_href.'mods/gamify/index_admin.php');
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
debug($_POST);
    $event = new Event();
    if($_POST['id']){
        $event->setId($_POST['id']);
    }
    $event->setAlias($_POST['alias']);
//    debug($event);
//    exit;

    if(!empty($_POST['description'])){
        $event->setDescription($_POST['description']);
     }
     if(!empty($_POST['reach_required_repetitions'])){
        $event->setReachRequiredRepetitions($_POST['reach_required_repetitions']);
     }
     if(!empty($_POST['each_points'])){
        $event->setEachPointsGranted($_POST['each_points']);
     }
     if(!empty($_POST['reach_points'])){
        $event->setReachPointsGranted($_POST['reach_points']);
     }    
     if(!empty($_POST['id_each_badge'])){
        $sql = "SELECT alias FROM %sgm_badges WHERE id = %d";
        $this_alias = queryDB($sql, array(TABLE_PREFIX, $_POST['id_each_badge']), TRUE);
        $event->setEachBadgeGranted($gamification->getBadgeByAlias($this_alias['alias']));
     }
    if(!empty($_POST['id_reach_badge'])){
        $sql = "SELECT alias FROM %sgm_badges WHERE id = %d";
        $this_alias = queryDB($sql, array(TABLE_PREFIX, $_POST['id_reach_badge']), TRUE);
        $event->setReachBadgeGranted($gamification->getBadgeByAlias($this_alias['alias']));
     }
      if(!empty($_POST['each_callback'])){
        $event->setEachCallback($_POST['each_callback']);
     }
     if(!empty($_POST['reach_callback'])){
        $event->setReachCallback($_POST['reach_callback']);
     }     
    ////debug($event);
    //exit;
    
    $gamification->addEvent($event);
    $msg->addFeedback('success');
    header('Location:'.$_base_href.'mods/gamify/index_admin.php');
    exit;
}
require (AT_INCLUDE_PATH.'header.inc.php');
$sql = "SELECT * FROM %sgm_events WHERE id = %d";
$this_event = queryDB($sql, array(TABLE_PREFIX, $_GET['id']), TRUE);

?>
<h2> Edit Event</h3>
<form name="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<input type="hidden" id="id" name="id" value="<?php echo $this_event['id']; ?>" />
<div class="input-form">
<fieldset class="group_form">
<legend class="group_form">Edit Event</legend>
<label for>Alias</label><br />
<?php
if(!isset($_GET['id'])){?>
    <input type="text" id="alias" name="alias" value="<?php echo $this_event['alias']; ?>" />
<?php } else { ?>
    <strong><?php echo $this_event['alias']; ?></strong>
    <input type="hidden" id="alias" name="alias" value="<?php echo $this_event['alias']; ?>" />
<?php } ?>

<br /><br />
<label for="alias">Description</label><br />
<input type="text" id="description" name="description" value="<?php echo $this_event['description']; ?>"  size="48"/><br />
<label for="alias">Allow Repetition</label>(Can this event repeat, or is it a one time occurence)<br />
<select name="allow_repetitions" id="allow_repetitions">
<option value="0" <?php if($this_event['allow_repetition'] ==0){ echo ' selected="selected"';} ?>>Yes</option>
<option value="1" <?php if($this_event['allow_repetition'] ==1){ echo ' selected="selected"';} ?>>No</option>
</select><br />
<label for="reach_required_repetitions">Reach required repetitions</label> (Repetitions required to trigger reach event)<br />
<input type="text" id="reach_required_repetitions" name="reach_required_repetitions" value="<?php echo $this_event['reach_required_repetitions']; ?>" maxlength="3" size="3" /><br />
<label for="max_points">Maximum points allowed</label> (Maximum points that can be scored for this event)<br />
<input type="text" id="max_points" name="max_points" value="<?php echo $this_event['max_points']; ?>"  maxlength="5" size="5"/><br />
<label for="id_each_badge">Badge ID each event</label> (When event occurs, issue this badge)<br />
<input type="text" id="id_each_badge" name="id_each_badge" value="<?php echo $this_event['id_each_badge']; ?>" maxlength="3" size="3"/><br />
<label for="id_reach_badge">Badge ID reach event</label> (When event repetitions is reach, issue this badge)<br />
<input type="text" id="id_reach_badge" name="id_reach_badge" value="<?php echo $this_event['id_reach_badge']; ?>"maxlength="3" size="3" /><br />
<label for="each_points">Points for each event</label> (Point awarded for each occurance of this event)<br />
<input type="text" id="each_points" name="each_points" value="<?php echo $this_event['each_points']; ?>" maxlength="4" size="4"/><br />
<label for="reach_points">Points increased to for reach event</label> (Points increase to this amount after reach event occurs)<br />
<input type="text" id="reach_points" name="reach_points" value="<?php echo $this_event['reach_points']; ?>"maxlength="5" size="5" /><br />
<label for="each_callback">Each callback function</label> (When event occurs, run this file)<br />
<input type="text" id="each_callback"  name="each_callback" value="<?php echo $this_event['each_callback']; ?>"  size="35"/><br />
<label for="reach_callback">Reach callback function</label> (When event repetitions is reached, run this file)<br />
<input type="text" id="reach_callback"  name="reach_callback" value="<?php echo $this_event['reach_callback']; ?>" size="35" /><br />
<input type="submit" name="submit" value="Update Event"/><input type="submit" name="cancel" value="Cancel"/>
</fieldset>
</div>
</form>

<?php require (AT_INCLUDE_PATH.'footer.inc.php'); ?>