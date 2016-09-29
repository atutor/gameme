<?php
define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');
admin_authenticate(AT_ADMIN_PRIV_GAMIFY);
$_custom_css = $_base_path . 'mods/gamify/module.css'; // use a custom stylesheet
$_custom_head ='<script type="text/javascript" src="'.$_base_path .'jscripts/lib/jquery.1.10.1.min.js"></script>'."\n";
$_custom_head.='<script type="text/javascript" src="'.$_base_path .'mods/gamify/gamify.js"></script>'."\n";
$_custom_head .= '<script type="text/javascript" src="'.$_base_path.'mods/gamify/inline_edit/jquery-quickedit.js"></script>'."\n";
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
		</script>';
require (AT_INCLUDE_PATH.'header.inc.php');
global $_base_path;
$this_path =  preg_replace ('#/get.php#','',$_SERVER['DOCUMENT_ROOT'].$_base_path);

//$active = " active";
?>

<ul class="tablist " role="tablist" id="subnavlist">
<li id="tab1" class="tab" aria-controls="panel1" aria-selected="true" tabindex="0" role="tab">
Events</li>
<li id="tab2" class="tab" aria-controls="panel2" role="tab"  tabindex="0" aria-selected="false">
Badges </li>
<li id="tab3" class="tab" aria-controls="panel3" role="tab"  tabindex="0" aria-selected="false">
Levels </li>
</ul>


<div id="panel1" class="panel" aria-labelledby="tab1" role="tabpanel" aria-hidden="false">
<a href="mods/gamify/edit_event.php">Add +</a>
<?php
if($_SESSION['inline_edit']){ ?>
    <a href="javascript:;" onclick="" id="inline_edit_toggle">Enable inline edit</a>
<?php } ?>

<h3>Events</h3>
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
  //  if(!isset($_SESSION['gamify_edit'])){
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
    <td><a href="mods/gamify/edit_event.php?id='.$event['id'].'">edit</a> <a href="">delete</a></td>
    </tr>';
    }
    
    /*else{
        echo '<tr>
    <td>'.$event['alias'].'</td>
    <td>'.$event['description'].'</td>
    
    <td style="text-align:center;">'.$event['allow_repetitions'].'</td>
    <td style="text-align:center;">'.$event['reach_required_repetitions'].'</td>
    <td style="text-align:center;">'.$event['max_points'].'</td>
    <td style="text-align:center;">'.$event['id_each_badge'].'</td>
    <td style="text-align:center;">'.$event['id_reach_badge'].'</td>
    <td style="text-align:center;">'.$event['each_points'].'</td>
    <td style="text-align:center;">'.$event['reach_points'].'</td>
    <td>'.$event['each_callback'].'</td>
    <td>'.$event['reach_callback'].'</td>
    <td><a href="mods/gamify/edit_event.php?id='.$event['id'].'">edit</a> <a href="">delete</a></td>
    </tr>';
    }
  
}  */
?>
</table>
</div>

<div id="panel2" class="panel" aria-labelledby="tab2" role="tabpanel" aria-hidden="true">
<h3>Badges</h3>
<table>
<tr>
<th></th>
<th>Alias</th>
<th>Title</th>
<th>Description</th>
<th></th>

</tr>
<?php
$sql = "SELECT * from %sgm_badges";
$all_badges = queryDB($sql, array(TABLE_PREFIX));
foreach($all_badges as $badge){
    echo '<tr>
    <td><img src="'.$badge['image_url'].'" alt="" /></td>
    <td>'.$badge['alias'].'</td>
    <td>'.$badge['title'].'</td>
    <td>'.$badge['description'].'</td>

    <td><a href="">edit</a> <a href="">delete</a></td>
    </tr>';
}
?>
</table>
</div>

<div id="panel3" class="panel" aria-labelledby="tab2" role="tabpanel" aria-hidden="true">
<h3>Levels</h3>
<table>
<?php
require_once($this_path.'mods/gamify/gamify.lib.php');
$sql = "SELECT * from %sgm_levels";
$all_levels = queryDB($sql, array(TABLE_PREFIX));
foreach($all_levels as $level){
    echo '<tr>
    <td>'.showstars_lg($level['points']).'</td>
    <td>'.$level['title'].'</td>
    <td>'.$level['description'].'</td>
    <td>'.$level['points'].'</td>
    <td><a href="">edit</a> <a href="">delete</a></td>
    </tr>';
}
function showstars_lg($points){
    $sql = "SELECT * FROM %sgm_levels WHERE points = $points";
    $level = queryDB($sql, array(TABLE_PREFIX), TRUE);
    $lg_star = str_replace(".", "_lg.", $level['icon']);
    $stars .= '<img src="'.$_base_href.'mods/gamify/images/'.$lg_star.'" alt="'.$level['title'].': '.$level['description'].'" title="'.$level['title'].': '.$level['description'].'" style="vertical-align:middle;margin-left:.2em;"/>'; 
    return $stars;
}
?>
</table>
</div>
<script src="<?php echo $_base_href; ?>mods/gamify/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $_base_path; ?>mods/gamify/inline_edit/jquery-quickedit.js"></script>
<?php
if(!empty($_POST)){
    $json = json_encode($_POST);
}


?>


<?php require (AT_INCLUDE_PATH.'footer.inc.php'); ?>