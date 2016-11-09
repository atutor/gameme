<?php
define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');
admin_authenticate(AT_ADMIN_PRIV_GAMEME);
$_custom_css = $_base_path . 'mods/gameme/module.css'; // use a custom stylesheet
$_custom_head = '<script type="text/javascript" src="'.$_base_path .'jscripts/lib/jquery.1.10.1.min.js"></script>'."\n";
$_custom_head.= '<script type="text/javascript" src="'.$_base_path .'mods/gameme/gamify.js"></script>'."\n";
$_custom_head .= '<script type="text/javascript" src="'.$_base_path.'mods/gameme/inline_edit/jquery-quickedit.js"></script>'."\n";
$_custom_head .= '<script type="text/javascript" src="'.$_base_path.'mods/gameme/jquery/js.cookie-min.js"></script>'."\n";
$_custom_head .= '<script type="text/javascript" src="'.$_base_path.'mods/gameme/dropzone.js"></script>'."\n";
 $_custom_head.='  
	<script type="text/javascript">
	//<!--
	jQuery.noConflict();
	//-->
		function showEdit(editableObj) {
			//$(editableObj).css("background","#eee");
		} 
		
		function saveEvent(editableObj,column,id) {
		cellvalue = editableObj.innerText;
		cellvalue = cellvalue.replace(/<br>/g,"");
			//$(editableObj).css("background","#FFF url('.$_base_path.'mods/gameme/images/loaderIcon.gif) no-repeat right");
			$.ajax({
				url: "'.$_base_path.'mods/gameme/save_event.php",
				type: "POST",
				data:"column="+column+"&editval="+cellvalue+"&id="+id,
				success: function(data){
					$(editableObj).css("background","#FDFDFD");
				},
				error: function(data){
				    //console.log(data);
				}        
		   });
		}
		function saveBadge(editableObj,column,id) {
		cellvalue = editableObj.innerText;
		cellvalue = cellvalue.replace(/<br>/g,"");
			$(editableObj).css("background","#FFF url('.$_base_path.'mods/gameme/images/loaderIcon.gif) no-repeat right");
			$.ajax({
				url: "'.$_base_path.'mods/gameme/save_badge.php",
				type: "POST",
				data:"column="+column+"&editval="+cellvalue+"&id="+id,
				success: function(data){
					$(editableObj).css("background","#FDFDFD");
				},
				error: function(data){
				    //console.log(data);
				}        
		   });
		}
        function saveLevel(editableObj,column,id) {
		cellvalue = editableObj.innerText;
		cellvalue = cellvalue.replace(/<br>/g,"");
			$(editableObj).css("background","#FFF url('.$_base_href.'mods/gameme/images/loaderIcon.gif) no-repeat right");
			$.ajax({
				url: "'.$_base_path.'mods/gameme/save_level.php",
				type: "POST",
				data:"column="+column+"&editval="+cellvalue+"&id="+id,
				success: function(data){
					$(editableObj).css("background","#FDFDFD");
				},
				error: function(data){
				    //console.log(data);
				}        
		   });
		}
		</script>';
		if(isset($_POST['submit'])){
            if (isset($_POST['instructor_edit']) && ($stripslashes($_POST['instructor_edit']) != $value)) {
				$sql = 'REPLACE INTO %sconfig VALUES ("%s", "%s")';
				$num_rows = queryDB($sql, array(TABLE_PREFIX, 'instructor_edit', $_POST['instructor_edit']));
				write_to_log(AT_ADMIN_LOG_REPLACE, 'config', $num_rows, $sqlout);
				$msg->addFeedback('CONFIG_UPDATED');
				header('Location:'.$_SERVER['PHP_SELF']);
				exit;

			} else if (!isset($_POST['instructor_edit'])) {
				$sql = "DELETE FROM %sconfig WHERE name='%s'";
				$num_rows = queryDB($sql, array(TABLE_PREFIX, 'instructor_edit'));
				write_to_log(AT_ADMIN_LOG_DELETE, 'config', $num_rows, $sqlout);
				$msg->addFeedback('CONFIG_UPDATED');
			    header('Location:'.$_SERVER['PHP_SELF']);
				exit;
			}
		}
require (AT_INCLUDE_PATH.'header.inc.php');
global $_base_path;
$this_path =  preg_replace ('#/get.php#','',$_SERVER['DOCUMENT_ROOT'].$_base_path);

//$active = " active";
?>

<ul class="tablist " role="tablist" id="subnavlist">
<li id="tab1" class="tab" aria-controls="panel1" aria-selected="true" tabindex="0" role="tab"  onclick="javascript:Cookies.set('activetab', 'tab1');">
<?php echo _AT('gm_events'); ?></li>
<li id="tab2" class="tab" aria-controls="panel2" role="tab"  tabindex="0" aria-selected="false" onclick="javascript:Cookies.set('activetab', 'tab2');">
<?php echo _AT('gm_badges'); ?></li>
<li id="tab3" class="tab" aria-controls="panel3" role="tab"  tabindex="0" aria-selected="false"  onclick="javascript:Cookies.set('activetab', 'tab3');">
<?php echo _AT('gm_levels'); ?></li>
<li id="tab4" class="tab" aria-controls="panel4" role="tab"  tabindex="0" aria-selected="false"  onclick="javascript:Cookies.set('activetab', 'tab4');">
<?php echo _AT('gm_options'); ?></li>
</ul>

<div id="panel1" class="panel" aria-labelledby="tab1" role="tabpanel" aria-hidden="false">
<a href="mods/gameme/edit_event.php" style="float:right;"><?php echo _AT('gm_addplus'); ?></a>
<?php
if($_SESSION['inline_edit']){ ?>
    <a href="javascript:;" onclick="" id="inline_edit_toggle"><?php echo _AT('gm_enable_edit'); ?></a>
<?php } ?>

<h3><?php echo _AT('gm_default_events'); ?></h3>
<?php $msg->printInfos('GM_ENABLE_EDIT_TEXT'); ?>
<?php require_once($this_path.'mods/gameme/gamify.lib.php'); ?>
<table class="table table-hover table-bordered col-sm-12 data" >
<tr>
<th><?php echo _AT('gm_alias'); ?></th>
<th><?php echo _AT('gm_description'); ?></th>
<th><?php echo _AT('gm_repetition'); ?></th>
<th><?php echo _AT('gm_reach_reps'); ?></th>
<th><?php echo _AT('gm_max_points'); ?></th>
<th><?php echo _AT('gm_each_badge'); ?></th>
<th><?php echo _AT('gm_reach_badge'); ?></th>
<th><?php echo _AT('gm_each_points'); ?></th>
<th><?php echo _AT('gm_reach_points'); ?></th>
<th><?php echo _AT('gm_each_callback'); ?></th>
<th><?php echo _AT('gm_reach_callback'); ?></th>
<th><?php echo _AT('gm_reach_message'); ?></th>
<th></th>
</tr>

<?php
$sql = "SELECT * from %sgm_events";
$all_events = queryDB($sql, array(TABLE_PREFIX));
$count = 0;
foreach($all_events as $key=>$event){
    echo '<tr>
    <td contenteditable="true" onBlur="saveEvent(this,\'alias\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['alias'].'</td>
    <td contenteditable="true" onBlur="saveEvent(this,\'description\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['description'].'</td>
    
    <td style="text-align:center;" contenteditable="true" onBlur="saveEvent(this,\'allow_repetitions\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['allow_repetitions'].'</td>
    <td style="text-align:center;" contenteditable="true" onBlur="saveEvent(this,\'reach_required_repetitions\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['reach_required_repetitions'].'</td>
    <td style="text-align:center;" contenteditable="true" onBlur="saveEvent(this,\'max_points\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['max_points'].'</td>
    <td style="text-align:center;" contenteditable="true" onBlur="saveEvent(this,\'id_each_badge\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['id_each_badge'].'</td>
    <td style="text-align:center;" contenteditable="true" onBlur="saveEvent(this,\'id_reach_badge\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['id_reach_badge'].'</td>
    <td style="text-align:center;" contenteditable="true" onBlur="saveEvent(this,\'each_points\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['each_points'].'</td>
    <td style="text-align:center;" contenteditable="true" onBlur="saveEvent(this,\'reach_points\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['reach_points'].'</td>
    <td  contenteditable="true" onBlur="saveEvent(this,\'each_callback\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['each_callback'].'</td>
    <td contenteditable="true" onBlur="saveEvent(this,\'reach_callback\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['reach_callback'].'</td>
    <td contenteditable="true" onBlur="saveEvent(this,\'reach_message\',\''.$event['id'].' \')" onClick="showEdit(this);">'.get_reach_message($event['alias']).'</td>
    <td><!--<a href="mods/gameme/edit_event.php?id='.$event['id'].'">'._AT('gm_edit').'</a>--> <a href="mods/gameme/delete_event.php?id='.$event['id'].'">'._AT('gm_delete').'</a></td>
    </tr>';
    }

?>
</table>
</div>

<div id="panel2" class="panel" aria-labelledby="tab2" role="tabpanel" aria-hidden="true">
<a href="mods/gameme/edit_badge.php" style="float:right;"><?php echo _AT('gm_addplus'); ?></a>
<h3><?php echo _AT('gm_default_badges'); ?></h3>
<?php $msg->printInfos('GM_EDIT_BADGE_TEXT'); ?>
<table class="table table-hover table-bordered col-sm-12 data">
<tr>
<th><?php echo _AT('gm_badge'); ?></th>
<th><?php echo _AT('gm_id'); ?></th>
<th><?php echo _AT('gm_alias'); ?></th>
<th><?php echo _AT('gm_title'); ?></th>
<th><?php echo _AT('gm_description'); ?></th>
<th></th>

</tr>
<?php
$sql = "SELECT * from %sgm_badges WHERE course_id = 0";
$all_badges = queryDB($sql, array(TABLE_PREFIX));
foreach($all_badges as $badge){
    if(!file_get_contents($_base_href.$badge['image_url'])){
        $content_dir = explode('/',AT_CONTENT_DIR);
        array_pop($content_dir);
        $badge_file_name = explode("/",$badge['image_url']);
        $badge_file = end($content_dir).'/0/gameme/badges/'.end($badge_file_name);
    } else{
        $badge_file = $_base_href.$badge['image_url'];
    }
    echo '<tr>
    <!--<td contenteditable="true" onBlur="saveBadge(this,\'image_url\',\''.$badge['id'].' \')" onClick="showEdit(this);"><img src="'.$badge['image_url'].'" alt="" /></td> -->
    <td contenteditable="true" onClick="showEdit(this);"><form action="'.$_base_href.'mods/gameme/upload_badge.php"
      class="dropzone"
      id="my-awesome-dropzone"  style="background-image:url('.$badge_file.');background-repeat:no-repeat;" method="post">
      <input type="hidden" name="course_id" value="0" /> 
      <input type="hidden" name="badge_id" value="'.$badge['id'].' " />
      <div class="fallback">
        <input name="file" type="file" />
        </div>
        </form></td>
    <td>'.$badge['id'].'</td>
    <td contenteditable="true" onBlur="saveBadge(this,\'alias\',\''.$badge['id'].' \')" onClick="showEdit(this);">'.$badge['alias'].'</td>
    <td contenteditable="true" onBlur="saveBadge(this,\'title\',\''.$badge['id'].' \')" onClick="showEdit(this);">'.$badge['title'].'</td>
    <td contenteditable="true" onBlur="saveBadge(this,\'description\',\''.$badge['id'].' \')" onClick="showEdit(this);">'.$badge['description'].'</td>

    <td><!-- <a href="mods/gameme/edit_badge.php?id='.$badge['id'].'">'._AT('gm_edit').'</a> --><a href="mods/gameme/delete_badge.php?id='.$badge['id'].'">'._AT('gm_delete').'</a></td>
    </tr>';
}
?>
</table>
</div>

<div id="panel3" class="panel" aria-labelledby="tab3" role="tabpanel" aria-hidden="true">
<a href="mods/gameme/edit_level.php" style="float:right;"><?php echo _AT('gm_addplus'); ?></a>
<h3><?php echo _AT('gm_default_levels'); ?></h3>
<?php $msg->printInfos('GM_LEVELS_TEXT'); ?>
<table class="table table-hover table-bordered col-sm-12 data">
<tr>
<th><?php echo _AT('gm_icon'); ?></th>
<th><?php echo _AT('gm_level_name'); ?></th>
<th><?php echo _AT('gm_description'); ?></th>
<th><?php echo _AT('gm_points_threshold'); ?></th>
<th></th>
</tr>
<?php
require_once($this_path.'mods/gameme/gamify.lib.php');
$sql = "SELECT * from %sgm_levels ORDER BY points desc";
$all_levels = queryDB($sql, array(TABLE_PREFIX));
foreach($all_levels as $level){
    echo '<tr>
    <td><form action="'.$_base_href.'mods/gameme/upload_level_icon.php"
          class="dropzone"
          id="level'.$level['id'].'"  style="background-image:url('.star_file($level['id']).');background-repeat:no-repeat;background-position: center; " method="post"  tabindex="0">
        <input type="hidden" name="course_id" value="0" /> 
        <input type="hidden" name="level_id" value="'.$level['id'].' " />
        <div class="fallback">
            <input name="file" type="file" id="theFile" onclick="performKeyPress(\'theFile\')";/>
            
        </div>
        </form></td>
    <td contenteditable="true" onBlur="saveLevel(this,\'title\',\''.$level['id'].' \')" onClick="showEdit(this);">'.$level['title'].'</td>
    <td contenteditable="true" onBlur="saveLevel(this,\'description\',\''.$level['id'].' \')" onClick="showEdit(this);">'.$level['description'].'</td>
    <td contenteditable="true" onBlur="saveLevel(this,\'points\',\''.$level['id'].' \')" onClick="showEdit(this);">'.$level['points'].'</td>
    <td><a href="mods/gameme/delete_level.php?id='.$level['id'].SEP.'course_id=0">'._AT('gm_delete').'</a></td>
    </tr>';
}
/*
function showstars_lg($points){
    $sql = "SELECT * FROM %sgm_levels WHERE points = $points";
    $level = queryDB($sql, array(TABLE_PREFIX), TRUE);
    $lg_star = str_replace(".", "_lg.", $level['icon']);
    $stars .= '<img src="'.$_base_href.'mods/gameme/images/'.$level['icon'].'" alt="'.$level['title'].': '.$level['description'].'" title="'.$level['title'].': '.$level['description'].'" style="vertical-align:middle;margin-left:.2em;"/>'; 
    return $stars;
}
*/
?>
</table>
</div>
<div id="panel4" class="panel" aria-labelledby="tab4" role="tabpanel" aria-hidden="true">
<h3><?php echo _AT('gm_options'); ?></h3>
<?php $msg->printInfos('GM_OPTIONS_TEXT'); ?>
<br style="clear:both;" />
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="checkbox" name="instructor_edit" id="instructor_edit" <?php if($_config['instructor_edit']){echo 'checked="checked"';}?>/>
<label for="instructor_edit"><?php echo _AT('gm_disallow_instructors'); ?></label>
<input type="submit" name="submit" value="<?php echo _AT('gm_update_options'); ?>" />
</form> 

</div>
<script src="<?php echo $_base_href; ?>mods/gameme/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $_base_path; ?>mods/gameme/inline_edit/jquery-quickedit.js"></script>
<?php
if(!empty($_POST)){
    $json = json_encode($_POST);
}
/*


*/
function star_file($id){
    global $_base_href;
    $sql = "SELECT * FROM %sgm_levels WHERE id = %d AND course_id=%d";
    if($_SESSION['course_id'] >0){
        $level = queryDB($sql, array(TABLE_PREFIX, $id, 0), TRUE);
        if(empty($level)){
            $level = queryDB($sql, array(TABLE_PREFIX, $id, 0), TRUE);
        }
    }else{
        $level = queryDB($sql, array(TABLE_PREFIX, $id, 0), TRUE);
    }
    
    if(!file_get_contents($_base_href.'mods/gameme/images/'.$level['icon'] )){
            $content_dir = explode('/',AT_CONTENT_DIR);
            array_pop($content_dir);
            if(!file_get_contents(end($content_dir).'/0/gameme/levels/'.$level['icon'])){
                $level_file = end($content_dir).'/0/gameme/levels/'.$level['icon'] ;
            }else{
                $level_file = end($content_dir).'/0/gameme/levels/'.$level['icon'] ;
            }
        } else{
            $level_file = $_base_href.'mods/gameme/images/'.$level['icon'] ;
        }
    return $level_file;
}
/* Gets the reach message from the database, either
* 1. a message created by the instructor for a particular course
* 2. a custom message created by the administrator
* 3. or the default message that come with the module
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


<?php require (AT_INCLUDE_PATH.'footer.inc.php'); ?>