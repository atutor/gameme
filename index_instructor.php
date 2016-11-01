<?php
namespace gameme;
use gameme\PHPGamification\DAO;

define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');
authenticate(AT_PRIV_GAMEME);
global $_base_path;
$_custom_css = $_base_path . 'mods/gameme/module.css'; // use a custom stylesheet
$_custom_head.= '<script type="text/javascript" src="'.$_base_path .'mods/gameme/gamify.js"></script>'."\n";
$_custom_head .= '<script type="text/javascript" src="'.$_base_path.'mods/gameme/inline_edit/jquery-quickedit.js"></script>'."\n";
$_custom_head .= '<script type="text/javascript" src="'.$_base_path.'mods/gameme/jquery/js.cookie-min.js"></script>'."\n";
$_custom_head .= '<script type="text/javascript" src="'.$_base_path.'mods/gameme/dropzone.js"></script>'."\n";
$_custom_head .= '<script type="text/javascript" src="'. $_base_path.'mods/gameme/inline_edit/jquery-quickedit.js"></script>'."\n";

 $_custom_head.='  
	<script type="text/javascript">
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
			$(editableObj).css("background","#FFF url('.$_base_path.'mods/gameme/images/loaderIcon.gif) no-repeat right");
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
        function performKeyPress(elemId) {
           var elem = document.getElementById(elemId);
           if(elem && document.createEvent) {
              var evt = document.createEvent("KeyboardEvent");
              evt.initEvent("keypress", true, false);
              elem.dispatchEvent(evt);
           }
           
        }
		</script>';
require (AT_INCLUDE_PATH.'header.inc.php');
global $_base_path;
$this_path =  preg_replace ('#/get.php#','',$_SERVER['DOCUMENT_ROOT'].$_base_path);

//$active = " active";
?>

<ul class="tablist " role="tablist" id="subnavlist">
<li id="tab1" class="tab" aria-controls="panel1" aria-selected="true" tabindex="0" role="tab"  onclick="javascript:Cookies.set('activetab', 'tab1');">
Events</li>
<li id="tab2" class="tab" aria-controls="panel2" role="tab"  tabindex="0" aria-selected="false" onclick="javascript:Cookies.set('activetab', 'tab2');">
Badges </li>
<li id="tab3" class="tab" aria-controls="panel3" role="tab"  tabindex="0" aria-selected="false"  onclick="javascript:Cookies.set('activetab', 'tab3');">
Levels </li>
<li id="tab4" class="tab" aria-controls="panel4" role="tab"  tabindex="0" aria-selected="false"  onclick="javascript:Cookies.set('activetab', 'tab4');">
Options </li>
<li id="tab5" class="tab" aria-controls="panel5" role="tab"  tabindex="0" aria-selected="false"  onclick="javascript:Cookies.set('activetab', 'tab5');">
Progress </li>
</ul>


<div id="panel1" class="panel" aria-labelledby="tab1" role="tabpanel" aria-hidden="false">
<?php  if(!$_config['instructor_edit']){ ?>
<div id="info">Copy Default Events to modify them. </div>
<h3>Course Events</h3>
<table class="table table-hover table-bordered col-sm-12 data">
<tr>
<th>Alias</th>
<th>Description</th>
<th>Repetition</th>
<th>Reach Reps</th>
<th>Max Points</th>
<th>Each Badge</th>
<th>Reach Badge</th>
<th>Each Point</th>
<th>Reach Points</th>
<!--<th>Each Callback</th>
<th>Reach Callback</th> -->
<th></th>
</tr>
<?php
$sql = "SELECT * from %sgm_events WHERE course_id = %d";
$all_crs_events = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id']));

foreach($all_crs_events as $key=>$event){
    echo '<tr>
    <td>'.$event['alias'].'</td>
    <td contenteditable="true" onBlur="saveEvent(this,\'description\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['description'].'</td>
    
    <td style="text-align:center;" contenteditable="true" onBlur="saveEvent(this,\'allow_repetitions\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['allow_repetitions'].'</td>
    <td style="text-align:center;" contenteditable="true" onBlur="saveEvent(this,\'reach_required_repetitions\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['reach_required_repetitions'].'</td>
    <td style="text-align:center;" contenteditable="true" onBlur="saveEvent(this,\'max_points\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['max_points'].'</td>
    <td style="text-align:center;" contenteditable="true" onBlur="saveEvent(this,\'id_each_badge\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['id_each_badge'].'</td>
    <td style="text-align:center;" contenteditable="true" onBlur="saveEvent(this,\'id_reach_badge\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['id_reach_badge'].'</td>
    <td style="text-align:center;" contenteditable="true" onBlur="saveEvent(this,\'each_points\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['each_points'].'</td>
    <td style="text-align:center;" contenteditable="true" onBlur="saveEvent(this,\'reach_points\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['reach_points'].'</td>
    <!--<td  contenteditable="true" onBlur="saveEvent(this,\'each_callback\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['each_callback'].'</td>
    <td contenteditable="true" onBlur="saveEvent(this,\'reach_callback\',\''.$event['id'].' \')" onClick="showEdit(this);">'.$event['reach_callback'].'</td>-->
    <td><!--<a href="mods/gameme/edit_event.php?id='.$event['id'].SEP.'course_id = '.$_SESSION['course_id'].'">edit</a>--> 
    <a href="mods/gameme/delete_event.php?id='.$event['id'].SEP.'course_id='.$_SESSION['course_id'].'">remove</a></td>
    </tr>'."\n";
    }
?>
</table>
<?php } else {
    echo '<div id="info">Editing has been disabled. Contact your administrator to have editing turned on.</div>';
    
}?>
<h3>Default Events</h3>
<table class="table table-hover table-bordered col-sm-12 data">
<tr>
<th>Alias</th>
<th>Description</th>
<th>Repetition</th>
<th>Reach Reps</th>
<th>Max Points</th>
<th>Each Badge</th>
<th>Reach Badge</th>
<th>Each Point</th>
<th>Reach Points</th>
<!-- <th>Each Callback</th>
<th>Reach Callback</th> -->
<?php  if(!$_config['instructor_edit']){ ?>
<th></th>
<?php } ?>
</tr>

<?php
$sql = "SELECT * from %sgm_events WHERE course_id=0";
$all_events = queryDB($sql, array(TABLE_PREFIX));
$count = 0;
foreach($all_events as $key=>$event){
    $sql = "SELECT * from %sgm_events WHERE id = %d AND course_id=%d";
    $events_crs_exists = queryDB($sql, array(TABLE_PREFIX, $event['id'], $_SESSION['course_id']));
    if(empty($events_crs_exists)){
        echo '<tr>
        <td>'.$event['alias'].'</td>
        <td>'.$event['description'].'</td>
        <td style="text-align:center;">'.$event['allow_repetitions'].'</td>
        <td style="text-align:center;">'.$event['reach_required_repetitions'].'</td>
        <td style="text-align:center;">'.$event['max_points'].'</td>
        <td style="text-align:center;">'.$event['id_each_badge'].'</td>
        <td style="text-align:center;">'.$event['id_reach_badge'].'</td>
        <td style="text-align:center;">'.$event['each_points'].'</td>
        <td style="text-align:center;">'.$event['reach_points'].'</td>';
         if(!$_config['instructor_edit']){ 
        echo '<td><a href="mods/gameme/copy_event.php?id='.$event['id'].SEP.'course_id = '.$_SESSION['course_id'].'">copy</a></td>'."\n";
        }
    }
    echo'    </tr>';    
}
?>
</table>
</div>

<div id="panel2" class="panel" aria-labelledby="tab2" role="tabpanel" aria-hidden="true">
<?php
if(!$_config['instructor_edit']){
?>
<div id="info">Copy Default Badges to modify them. </div>
<h3>Course Badges</h3>
<table class="table table-hover table-bordered col-sm-12 data" style="max-width:100%;">
<tr>
<th>Badge</th>
<th>ID</th>
<th>Alias</th>
<th>Title</th>
<th>Description</th>
<th></th>

</tr>
<?php
$sql = "SELECT * from %sgm_badges WHERE course_id=%d";
$all_badges = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id']));
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
    <td contenteditable="true" onClick="showEdit(this);"><form action="'.$_base_href.'mods/gameme/upload_badge.php"
      class="dropzone"
      id="badge'.$badge['id'].'"  style="background-image:url('.$badge_file.');background-repeat:no-repeat;" method="post" tabindex="0">
      <input type="hidden" name="course_id" value="'.$_SESSION['course_id'].'" /> 
      <input type="hidden" name="badge_id" value="'.$badge['id'].' " />
      <div class="fallback">
        <input name="file" type="file" />
        </div>
        </form></td>
    <td>'.$badge['id'].'</td>
    <td>'.$badge['alias'].'</td>
    <td contenteditable="true" onBlur="saveBadge(this,\'title\',\''.$badge['id'].' \')" onClick="showEdit(this);">'.$badge['title'].'</td>
    <td contenteditable="true" onBlur="saveBadge(this,\'description\',\''.$badge['id'].' \')" onClick="showEdit(this);">'.$badge['description'].'</td>

    <td> <a href="mods/gameme/delete_badge.php?id='.$badge['id'].SEP.'course_id='.$_SESSION['course_id'].'">remove</a></td></td>
    </tr>'."\n";
}
?>
</table>
<?php } else {
    echo '<div id="info">Editing has been disabled. Contact your administrator to have editing turned on.</div>';
    
}?>

<h3>Default Badges</h3>
<table class="table table-hover table-bordered col-sm-12 data" style="max-width:100%;">
<tr>
<th>Badge</th>
<th>ID</th>
<th>Alias</th>
<th>Title</th>
<th>Description</th>
<?php
         if(!$_config['instructor_edit']){ ?>
<th></th>
<?php } ?>
</tr>
<?php
$sql = "SELECT * from %sgm_badges WHERE course_id=0";
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
    $sql = "SELECT * from %sgm_badges WHERE id = %d AND course_id=%d";
    $badges_crs_exists = queryDB($sql, array(TABLE_PREFIX, $badge['id'], $_SESSION['course_id']));
    if(empty($badges_crs_exists)){
    echo '<tr>
        <td><img src="'.$badge['image_url'].'" alt="" /></td>
        <td>'.$badge['id'].'</td>
        <td>'.$badge['alias'].'</td>
        <td>'.$badge['title'].'</td>
        <td>'.$badge['description'].'</td>';
         if(!$_config['instructor_edit']){ 
        echo '<td><a href="mods/gameme/copy_badge.php?id='.$badge['id'].SEP.'course_id = '.$_SESSION['course_id'].'">copy</a></td>';
        }
        echo '</tr>'."\n";
    }
}
?>
</table>
</div>

<div id="panel3" class="panel" aria-labelledby="tab3" role="tabpanel" aria-hidden="true">
<?php
if(!$_config['instructor_edit']){ ?>
<div id="info">Copy Default Levels to modify them. </div>
<h3>Course Levels</h3>
<table class="table table-hover table-bordered col-sm-12 data">
<tr>
<th>Icon</th>
<th>Level Name</th>
<th>Description</th>
<th>Points Threshold</th>
<th></th>

</tr>
<?php
require_once($this_path.'mods/gameme/gamify.lib.php');
$sql = "SELECT * from %sgm_levels WHERE course_id=%d";
$all_levels = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id']));
foreach($all_levels as $level){
    echo '<tr>
    <td><form action="'.$_base_href.'mods/gameme/upload_level_icon.php"
          class="dropzone"
          id="level'.$level['id'].'"  style="background-image:url('.star_file($level['id']).');background-repeat:no-repeat;background-position: center; " method="post"  tabindex="0">
        <input type="hidden" name="course_id" value="'.$_SESSION['course_id'].'" /> 
        <input type="hidden" name="level_id" value="'.$level['id'].' " />
        <div class="fallback">
            <input name="file" type="file" id="theFile" onclick="performKeyPress(\'theFile\')";/>
            
        </div>
        </form></td>
    <td contenteditable="true" onBlur="saveLevel(this,\'title\',\''.$level['id'].' \')" onClick="showEdit(this);">'.$level['title'].'</td>
    <td contenteditable="true" onBlur="saveLevel(this,\'description\',\''.$level['id'].' \')" onClick="showEdit(this);">'.$level['description'].'</td>
    <td contenteditable="true" onBlur="saveLevel(this,\'points\',\''.$level['id'].' \')" onClick="showEdit(this);">'.$level['points'].'</td>
    <td><a href="mods/gameme/delete_level.php?id='.$level['id'].SEP.'course_id = '.$_SESSION['course_id'].'">remove</a></td>
    </tr>'."\n";
}
?>
</table>
<?php } else {
    echo '<div id="info">Editing has been disabled. Contact your administrator to have editing turned on.</div>';
    
}?>
<h3>Default Levels</h3>

<table class="table table-hover table-bordered col-sm-12 data">
<tr>
<th>Icon</th>
<th>Level Name</th>
<th>Description</th>
<th>Points Threshold</th>
<th></th>

</tr>
<?php
require_once($this_path.'mods/gameme/gamify.lib.php');
$sql = "SELECT `value` from %sgm_options WHERE `course_id`=%d AND `option`='%s'";
if($level_max = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id'], "level_count"),TRUE)){
    if($level_max['value']  >0){
        $limit = " LIMIT ".$level_max['value'];
    }
}

$sql = "SELECT * from %sgm_levels WHERE course_id =%d $limit";
$all_levels = queryDB($sql, array(TABLE_PREFIX, 0));

foreach($all_levels as $level){
    $levels_crs_exists ='';
    if(!file_get_contents($_base_href.'mods/gameme/image/'.$level['icon'])){
        $content_dir = explode('/',AT_CONTENT_DIR);
        array_pop($content_dir);
        $level_file_name = explode("/",$level['icon']);
        $level_file = end($content_dir).'/0/gameme/levels/'.end($level_file_name);
    } else{
        $level_file = $_base_href.'mods/gameme/image/'.$level['icon'];
    }
    $sql = "SELECT * from %sgm_levels WHERE id = %d AND course_id=%d";
    $level_crs_exists = queryDB($sql, array(TABLE_PREFIX, $level['id'], $_SESSION['course_id']), TRUE);

    if(empty($level_crs_exists)){
    echo '<tr>
        <td>'.showstars_lg($level['points']).'</td>
        <td>'.$level['title'].'</td>
        <td>'.$level['description'].'</td>
        <td>'.$level['points'].'</td>';
    if(!$_config['instructor_edit']){ ?>
        <td><a href="mods/gameme/copy_level.php?id=<?php echo $level['id'].SEP;?>course_id =<?php echo $_SESSION['course_id']; ?>">copy</a></td>
    <?php }
        echo '</tr>'."\n";
    }
}
?>
</table>
</div>

<div id="panel4" class="panel" aria-labelledby="tab4" role="tabpanel" aria-hidden="true">
    <div id="info">Set game elements to display to students. </div> 
    <br style="clear:both;">
    <form action="<?php echo  $_base_href; ?>mods/gameme/game_options.php" method="post">
        <input type="checkbox" name="showpoints" id="showpoints" <?php if(get_option('showpoints', $_SESSION['course_id'])){ echo 'checked = "checked"';}?>/>
        <label for="showpoints">Show Points</label><br />
        <input type="checkbox" name="showlog" id="showlog" <?php if(get_option('showlog', $_SESSION['course_id'])){ echo 'checked = "checked"';}?>/>
        <label for="showlog">Show Log</label><br />
        <input type="checkbox" name="showlevels" id="showlevels" <?php if(get_option('showlevels', $_SESSION['course_id'])){ echo 'checked = "checked"';}?>/>
        <label for="showlevels">Show Levels</label><br />
        <input type="checkbox" name="showprogress" id="showprogress" <?php if(get_option('showprogress', $_SESSION['course_id'])){ echo 'checked = "checked"';}?>/>
        <label for="showprogress">Show progress to next level</label><br />
        <input type="checkbox" name="showposition" id="showposition" <?php if(get_option('showposition', $_SESSION['course_id'])){ echo 'checked = "checked"';}?>/>
        <label for="showposition">Show position relative to others</label><br />
        <input type="checkbox" name="showbadges" id="showbadges" <?php if(get_option('showbadges', $_SESSION['course_id'])){ echo 'checked = "checked"';}?>/>
        <label for="showbadges">Show Badges</label><br />
        <input type="checkbox" name="showleaders" id="showleaders" <?php if(get_option('showleaders', $_SESSION['course_id'])){ echo 'checked = "checked"';}?>/>
        <label for="showleaders">Show Leader Board</label><br />
        <input type="checkbox" name="showinstructor" id="showinstructor" <?php if(get_option('showinstructor', $_SESSION['course_id'])){ echo 'checked = "checked"';}?>/>
        <label for="showinstructor">Show instructor in leader board</label><br />
        <input type="checkbox" name="showalerts" id="showalerts" <?php if(get_option('showalerts', $_SESSION['course_id'])){ echo 'checked = "checked"';}?>/>
        <label for="showalerts">Show Alerts</label><br />
        <select name="showleader_count" id="showleader_count">
        <?php
            // create an array with possible leader board lengths
            $leader_counts = array('1','3','5','10','15','20','25');
            $sql = "SELECT * from %sgm_options WHERE course_id=%d";
            $gm_course_options = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id']));

            foreach($gm_course_options as $option=>$value){
                if($value['option'] == "showleader_count"){
                    $option_selected = $value['value'];
                }
            }
            foreach($leader_counts as $leader_count){
                if($leader_count == $option_selected){
                    echo '<option value="'.$leader_count.'" selected="selected">'.$leader_count.'</option>';
                }else{
                    echo '<option value="'.$leader_count.'">'.$leader_count.'</option>';
                }
            }
        ?>
        </select>
        <label for="show_leaders">Leader board length</label><br />
        <select name="level_count" id="level_count">
        <?php
            $level_counts = array('1','2','3','4','5','6','7','8','9','10', '11');
            $sql = "SELECT * from %sgm_options WHERE course_id=%d";
            $gm_course_options = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id']));
            
            foreach($gm_course_options as $option=>$value){
                if($value['option'] == "level_count"){
                    $option_selected = $value['value'];
                }
            }
            foreach($level_counts as $level_count){
                if($level_count == $option_selected){
                    echo '<option value="'.$level_count.'" selected="selected">'.$level_count.'</option>';
                }else{
                    echo '<option value="'.$level_count.'">'.$level_count.'</option>';
                }
            }
        ?>
        </select>
        
        <label for="level_count">Number of levels (max 11)</label></br />
        <input type="submit" name="submit" value="Update Options">
    </form>
    </div>
<?php
function get_option($option, $course_id){
    $sql = "SELECT * FROM %sgm_options WHERE `course_id` = %d AND `option` = '%s'";
    $option_set = queryDB($sql, array(TABLE_PREFIX, $course_id, $option), TRUE);
    
    if(!empty($option_set) && $option_set['value'] >0){
        return true;
    }else{
        return false;
    }
}
?>
<div id="panel5" class="panel" aria-labelledby="tab5" role="tabpanel" aria-hidden="true">
<h3>Progress</h3>
<?php
$sql = "SELECT %scourse_enrollment.member_id, %smembers.login 
            FROM %scourse_enrollment 
            INNER JOIN %smembers on %scourse_enrollment.member_id = %smembers.member_id 
            WHERE %scourse_enrollment.course_id = %d";
$students = queryDB($sql, array(TABLE_PREFIX, TABLE_PREFIX, TABLE_PREFIX, TABLE_PREFIX, TABLE_PREFIX,TABLE_PREFIX,TABLE_PREFIX,$_SESSION['course_id']));

?>
<div id="info">Select a user from the menu below to view that person's progress. </div>     
<hr style="clear:both; width:99%;" />
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="input-form">
<select name="member_id">
<?php
foreach($students as $student){
    $selected='';
    if($student['member_id'] == $_POST['member_id']){
        $selected = ' selected="selected"';
    } 
    echo '<option value="'.$student['member_id'].'" '.$selected.'>'.$student['login'].'</option>'."\n";
}
?>
</select>
<input type="submit" name="submit" value="view" />
</form>


<?php
if(!empty($_POST['member_id'])){

    echo '<h3>Progress for '.get_display_name($_POST['member_id']).'</h3>';
    global $_base_path;
    $sql = "SELECT * FROM %sgm_options WHERE course_id=%d";
    $gm_options = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id']));

    $count = 0;
    foreach($gm_options as $option => $value){
        $enabled_options[$count] = $value['option'];
        $count++;
    }
    $this_path =  preg_replace ('#/get.php#','',$_SERVER['DOCUMENT_ROOT'].$_base_path);
    require_once($this_path.'mods/gameme/gamify.lib.php');
    require_once($this_path.'mods/gameme/PHPGamification/PHPGamification.class.php');
    $course_game = new PHPGamification();
    $course_game->setDAO(new DAO(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD));
    $course_game->setUserId($_POST['member_id']);

    if(in_array('showpoints',$enabled_options)){
        showUserScore($course_game, $_SESSION['course_id']);
    }
    if(in_array('showlevels',$enabled_options)){
        showUserLevel($course_game, $_SESSION['course_id']);
    }
    if(in_array('showprogress',$enabled_options)){
        echo showUserProgress($course_game, $_SESSION['course_id']);
    }
    if(in_array('showbadges',$enabled_options)){
        echo showUserBadge($course_game, $_SESSION['course_id']);
    }
    if(in_array('showleaders',$enabled_options)){
        echo getLeaders($course_game, get_leader_count());
    }
    if(in_array('showposition',$enabled_options)){
        echo yourPosition($_POST['member']);
    }

}

?>
</div>
<?php


/*


*/

function showstars_lg($points){
    global $_base_href;
    $sql = "SELECT * FROM %sgm_levels WHERE points = %d AND course_id=%d";
    if($_SESSION['course_id'] >0){
        $level = queryDB($sql, array(TABLE_PREFIX, $points, $_SESSION['course_id']), TRUE);
        if(empty($level)){
            $level = queryDB($sql, array(TABLE_PREFIX, $points, 0), TRUE);
        }
    }else{
        $level = queryDB($sql, array(TABLE_PREFIX, $points, 0), TRUE);
    }
    
    $lg_star = str_replace(".", "_lg.", $level['icon']);
    
    if(!file_get_contents($_base_href.'mods/gameme/images/'.$level['icon'] )){
        $content_dir = explode('/',AT_CONTENT_DIR);
        array_pop($content_dir);
        $level_file = end($content_dir).'/0/gameme/levels/'.$level['icon'] ;
    } else{
        $level_file = $_base_href.'mods/gameme/images/'.$level['icon'] ;
    }
    $stars .= '<img src="'.$level_file.'" alt="'.$level['title'].': '.$level['description'].'" title="'.$level['title'].': '.$level['description'].'" style="vertical-align:middle;margin-left:.2em;"/>'; 
    return $stars;
}
/*


*/
function star_file($id){
    global $_base_href;
    $sql = "SELECT * FROM %sgm_levels WHERE id = %d AND course_id=%d";
    if($_SESSION['course_id'] >0){
        $level = queryDB($sql, array(TABLE_PREFIX, $id, $_SESSION['course_id']), TRUE);
        if(empty($level)){
            $level = queryDB($sql, array(TABLE_PREFIX, $points, 0), TRUE);
        }
    }else{
        $level = queryDB($sql, array(TABLE_PREFIX, $points, 0), TRUE);
    }
    
    if(!file_get_contents($_base_href.'mods/gameme/images/'.$level['icon'] )){
            $content_dir = explode('/',AT_CONTENT_DIR);
            array_pop($content_dir);
            if(!file_get_contents(end($content_dir).'/0/gameme/levels/'.$level['icon'])){
                $level_file = end($content_dir).'/'.$_SESSION['course_id'].'/gameme/levels/'.$level['icon'] ;
            }else{
                $level_file = end($content_dir).'/0/gameme/levels/'.$level['icon'] ;
            }
        } else{
            $level_file = $_base_href.'mods/gameme/images/'.$level['icon'] ;
        }
    return $level_file;
    //return $stars;
}

if(!empty($_POST)){
    $json = json_encode($_POST);
}


?>


<?php require (AT_INCLUDE_PATH.'footer.inc.php'); ?>