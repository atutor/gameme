<?php
/*
* Rename the function to match the name of the module. Names of all news functions must be unique
* across all modules installed on a system. Return a variable called $news
*/

function helloworld_news() {
	global $db, $enrolled_courses, $system_courses;
	$news = array();

	if ($enrolled_courses == ''){
		return $news;
	} 

	$sql = "SELECT * FROM %snews WHERE course_id IN '%s' ORDER BY date DESC";
	$result = queryDB($sql, array(TABLE_PREFIX, $enrolled_courses));
	
	if(count($result) > 0){
	    foreach($result as $row){
			$news[] = array('time'=>$row['date'], 
							'object'=>$row, 
							'alt'=>_AT('announcements'),
							'course'=>$system_courses[$row['course_id']]['title'],
							'thumb'=>'images/flag_blue.png',
							'link'=>$row['body']);
		}
	}
	return $news;
}

?>
