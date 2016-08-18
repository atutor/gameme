<?php

if (!defined('AT_INCLUDE_PATH')) { exit; }

/*****
* Free form PHP can appear here to retreive current information
* from the module, or a text description of the module where there is
* not current information
*****/

global $db;

$link_limit = 3;		// Number of links to be displayed on "detail view" box

$sql = "SELECT hello_world_id, value FROM %shello_world WHERE course_id=%d ORDER BY value LIMIT %d";
$result = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id'], $link_limit));

if(count($result) > 0){
    foreach($result as $row){
		/****
		* SUBLINK_TEXT_LEN, VALIDATE_LENGTH_FOR_DISPLAY are defined in include/lib/constance.lib.inc
		* SUBLINK_TEXT_LEN determins the maxium length of the string to be displayed on "detail view" box.
		*****/
		$list[] = '<a href="'.AT_BASE_HREF.url_rewrite('mods/hello_world/index.php?id='. $row['hello_world_id']).'"'.
		          (strlen($row['value']) > SUBLINK_TEXT_LEN ? ' title="'.$row['value'].'"' : '') .'>'. 
		          validate_length($row['value'], SUBLINK_TEXT_LEN, VALIDATE_LENGTH_FOR_DISPLAY) .'</a>';
	}
	return $list;	
} else {
	return 0;
}

?>