<?php
namespace gameme\PHPGamification;
use Exception;
use gameme\PHPGamification;
use gameme\PHPGamification\Model;
use gameme\PHPGamification\Model\Level;

define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');
$max_levelicon_size = 15000;  // maximum file size for  level icon in bytes
$max_height = 95;
$max_width = 95;
$ds = DIRECTORY_SEPARATOR; 
 if($_SESSION['course_id'] == -1){
    $course_id = "0";
 } else{
    $course_id = $_SESSION['course_id'];
 }
$base_gameme_dir = AT_CONTENT_DIR.$course_id;
$gameme_course_dir = $base_gameme_dir.'/gameme';
$storeFolder = $gameme_course_dir.'/levels';  
$base_store_folder = "content/".$course_id."/gameme/levels"; 

if(!is_dir($base_gameme_dir )){
    mkdir($base_gameme_dir);
}
if(!is_dir($gameme_course_dir)){
    mkdir($gameme_course_dir);
}
if(!is_dir($storeFolder)){
    mkdir($storeFolder);
}

if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];                            
    $targetPath = $storeFolder . $ds;     
    $targetFile =  $targetPath. $_FILES['file']['name'];   
    move_uploaded_file($tempFile,$targetFile);      
}

list($width, $height) = getimagesize($targetFile);

if($height > $max_height || $width > $max_width){
    unset($targetFile);
    $msg->addError('MAX_DIMENSION');
    return false;

} else{
    if($_FILES['file']['size'] < $max_levelicon_size){
        $sql ="UPDATE %sgm_levels set icon ='%s' WHERE id = %d AND course_id=%d";
        queryDB($sql, array(TABLE_PREFIX,$_FILES['file']['name'], $_POST["level_id"], $course_id));
    } else {
        $msg->addError('MAX_FILESESIZE');
        return false;
    }
} 
return true;
?>