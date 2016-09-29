<?php
namespace gamify\PHPGamification;
use Exception;
use gamify\PHPGamification;
use gamify\PHPGamification\Model;
use gamify\PHPGamification\Model\Event;

define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');
$_POST["editval"] = str_replace("\n", "", $_POST["editval"]);
$_POST["editval"] = str_replace("\r", "", $_POST["editval"]);

if($_POST["editval"] == ''){
    $sql = 'UPDATE %sgm_events set %s = NULL WHERE  id=%d';
    queryDB($sql, array(TABLE_PREFIX, $_POST["column"], $_POST["id"]));
}else{
    if(is_int($_POST["editval"]) ){
        $sql = "UPDATE %sgm_events set %s = %d WHERE  id=%d";
    }else{
        $sql = "UPDATE %sgm_events set %s = '%s' WHERE  id=%d";
    }
    $result = queryDB($sql, array(TABLE_PREFIX, $_POST["column"], $_POST["editval"], $_POST["id"]));
}
if(!empty($result)){
    return true;
    }
?>