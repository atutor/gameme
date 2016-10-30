<?php
namespace gameme\PHPGamification;

define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');

//foreach()
//$sql = "REPLACE into %sgm_options "
global $_base_href;
array_pop($_POST );
$sql = "DELETE from %sgm_options WHERE course_id=%d";
queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id']));
foreach($_POST as $option=>$value){
    if($value == 'on'){
        $value = 1;
    } else if($value == 'off'){
        $value = 0;
    }
    $sql = "INSERT into %sgm_options(`id`,`course_id`, `option`, `value`) VALUES ('',%d, '%s',%d)";
    queryDB($sql, array(TABLE_PREFIX,$_SESSION['course_id'], $option, $value));
}

$msg->addFeedback('UPDATED_OPTIONS');
header('Location: '.$_base_href.'mods/gameme/index_instructor.php');
exit;

?>