<?php
define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');
admin_authenticate(AT_ADMIN_PRIV_GAMIFY);
$_custom_css = $_base_path . 'mods/gamify/module.css'; // use a custom stylesheet
$_custom_head = '<script type="text/javascript" src="'.$_base_path .'jscripts/lib/jquery.1.10.1.min.js"></script>'."\n";
$_custom_head.= '<script type="text/javascript" src="'.$_base_path .'mods/gamify/gamify.js"></script>'."\n";
$_custom_head .= '<script type="text/javascript" src="'.$_base_path.'mods/gamify/inline_edit/jquery-quickedit.js"></script>'."\n";
$_custom_head .= '<script type="text/javascript" src="'.$_base_path.'mods/gamify/jquery/js.cookie-min.js"></script>'."\n";
$_custom_head .= '<script type="text/javascript" src="'.$_base_path.'mods/gamify/dropzone.js"></script>'."\n";
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
			//$(editableObj).css("background","#FFF url('.$_base_path.'mods/gamify/images/loaderIcon.gif) no-repeat right");
			$.ajax({
				url: "'.$_base_path.'mods/gamify/save_event.php",
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
			$(editableObj).css("background","#FFF url('.$_base_path.'mods/gamify/images/loaderIcon.gif) no-repeat right");
			$.ajax({
				url: "'.$_base_path.'mods/gamify/save_badge.php",
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
			$(editableObj).css("background","#FFF url('.$_base_href.'mods/gamify/images/loaderIcon.gif) no-repeat right");
			$.ajax({
				url: "'.$_base_path.'mods/gamify/save_level.php",
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
Events</li>
<li id="tab2" class="tab" aria-controls="panel2" role="tab"  tabindex="0" aria-selected="false" onclick="javascript:Cookies.set('activetab', 'tab2');">
Badges </li>
<li id="tab3" class="tab" aria-controls="panel3" role="tab"  tabindex="0" aria-selected="false"  onclick="javascript:Cookies.set('activetab', 'tab3');">
Levels </li>
<li id="tab4" class="tab" aria-controls="panel4" role="tab"  tabindex="0" aria-selected="false"  onclick="javascript:Cookies.set('activetab', 'tab4');">
Options </li>
</ul>

<div id="panel1" class="panel" aria-labelledby="tab1" role="tabpanel" aria-hidden="false">
<a href="mods/gamify/edit_event.php" style="float:right;">Add +</a>
<?php
if($_SESSION['inline_edit']){ ?>
    <a href="javascript:;" onclick="" id="inline_edit_toggle">Enable inline edit</a>
<?php } ?>

<h3>Default Events</h3>
<div id="info">Click on a table cells to edit values, click out to save. See the Handbook for more about creating and modifying the system's Default Events.</div>

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
<th>Each Callback</th>
<th>Reach Callback</th>
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
    <td><!--<a href="mods/gamify/edit_event.php?id='.$event['id'].'">edit</a>--> <a href="mods/gamify/delete_event.php?id='.$event['id'].'">delete</a></td>
    </tr>';
    }

?>
</table>
</div>

<div id="panel2" class="panel" aria-labelledby="tab2" role="tabpanel" aria-hidden="true">
<a href="mods/gamify/edit_badge.php" style="float:right;">Add +</a>
<h3>Default Badges</h3>
<div id="info">Drag badges into the Badge dropzone in the first column, or click on a table cells to edits its value, click out to save. See the Handbook for more about creating and modifying the system's Default Badges </div>

<table class="table table-hover table-bordered col-sm-12 data">
<tr>
<th>Badge</th>
<th>ID</th>
<th>Alias</th>
<th>Title</th>
<th>Description</th>
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
        $badge_file = end($content_dir).'/0/gamify/badges/'.end($badge_file_name);
    } else{
        $badge_file = $_base_href.$badge['image_url'];
    }
    echo '<tr>
    <!--<td contenteditable="true" onBlur="saveBadge(this,\'image_url\',\''.$badge['id'].' \')" onClick="showEdit(this);"><img src="'.$badge['image_url'].'" alt="" /></td> -->
    <td contenteditable="true" onClick="showEdit(this);"><form action="'.$_base_href.'mods/gamify/upload_badge.php"
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

    <td><!-- <a href="mods/gamify/edit_badge.php?id='.$badge['id'].'"">edit</a> --><a href="mods/gamify/delete_badge.php?id='.$badge['id'].'">delete</a></td>
    </tr>';
}
?>
</table>
</div>

<div id="panel3" class="panel" aria-labelledby="tab3" role="tabpanel" aria-hidden="true">
<a href="mods/gamify/edit_level.php" style="float:right;">Add +</a>
<h3>Default Levels</h3>
<div id="info">Drag level icons into the Icon dropzone in the first colum, or click on a table cells to edits its value, click out to save. See the Handbook for more about creating and modifying the system's Default Levels </div>

<table class="table table-hover table-bordered col-sm-12 data">
<tr>
<th>Icon</th>
<th>Level Name</th>
<th>Description</th>
<th>Points Threshold</th>
<th></th>
</tr>
<?php
require_once($this_path.'mods/gamify/gamify.lib.php');
$sql = "SELECT * from %sgm_levels ORDER BY points desc";
$all_levels = queryDB($sql, array(TABLE_PREFIX));
foreach($all_levels as $level){
    echo '<tr>
    <td><form action="'.$_base_href.'mods/gamify/upload_level_icon.php"
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
    <td><a href="mods/gamify/delete_level.php?id='.$level['id'].SEP.'course_id=0">delete</a></td>
    </tr>';
}
/*
function showstars_lg($points){
    $sql = "SELECT * FROM %sgm_levels WHERE points = $points";
    $level = queryDB($sql, array(TABLE_PREFIX), TRUE);
    $lg_star = str_replace(".", "_lg.", $level['icon']);
    $stars .= '<img src="'.$_base_href.'mods/gamify/images/'.$level['icon'].'" alt="'.$level['title'].': '.$level['description'].'" title="'.$level['title'].': '.$level['description'].'" style="vertical-align:middle;margin-left:.2em;"/>'; 
    return $stars;
}
*/
?>
</table>
</div>
<div id="panel4" class="panel" aria-labelledby="tab4" role="tabpanel" aria-hidden="true">
<h3>Options</h3>
<div id="info">Most options are managed by instructors at the course level, enabled by default. You may choose to prevent Instructors from modifying game elements by checking the checkbox below, allowing only the default settings to be used. </div>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="checkbox" name="instructor_edit" id="instructor_edit" <?php if($_config['instructor_edit']){echo 'checked="checked"';}?>/>
<label for="instructor_edit">Disallow instructor customizing</label>
<input type="submit" name="submit" value="Update Options" />
</form> 

</div>
<script src="<?php echo $_base_href; ?>mods/gamify/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $_base_path; ?>mods/gamify/inline_edit/jquery-quickedit.js"></script>
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
    
    if(!file_get_contents($_base_href.'mods/gamify/images/'.$level['icon'] )){
            $content_dir = explode('/',AT_CONTENT_DIR);
            array_pop($content_dir);
            if(!file_get_contents(end($content_dir).'/0/gamify/levels/'.$level['icon'])){
                $level_file = end($content_dir).'/0/gamify/levels/'.$level['icon'] ;
            }else{
                $level_file = end($content_dir).'/0/gamify/levels/'.$level['icon'] ;
            }
        } else{
            $level_file = $_base_href.'mods/gamify/images/'.$level['icon'] ;
        }
    return $level_file;
}

?>


<?php require (AT_INCLUDE_PATH.'footer.inc.php'); ?>