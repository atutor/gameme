<?php
namespace gamify\PHPGamification;

/*******
 * doesn't allow this file to be loaded with a browser.
 */
if (!defined('AT_INCLUDE_PATH')) { exit; }

/******
 * this file must only be included within a Module obj
 */
if (!isset($this) || (isset($this) && (strtolower(get_class($this)) != 'module'))) { exit(__FILE__ . ' is not a Module'); }

/*******
 * assign the instructor and admin privileges to the constants.
 */
define('AT_PRIV_GAMIFY',       $this->getPrivilege());
define('AT_ADMIN_PRIV_GAMIFY', $this->getAdminPrivilege());

/*******
 * create a side menu box/stack.
 */
$this->_stacks['gamify'] = array('title_var'=>'gamify', 'file'=>AT_INCLUDE_PATH.'../mods/gamify/side_menu.inc.php');
// ** possible alternative: **
// $this->addStack('gamify', array('title_var' => 'gamify', 'file' => './side_menu.inc.php');

/*******
 * create optional sublinks for module "detail view" on course home page
 * when this line is uncommented, "mods/gamify/sublinks.php" need to be created to return an array of content to be displayed
 */
//$this->_list['gamify'] = array('title_var'=>'gamify','file'=>'mods/gamify/sublinks.php');

// Uncomment for tiny list bullet icon for module sublinks "icon view" on course home page
//$this->_pages['mods/gamify/index.php']['icon']      = 'mods/gamify/gamify.png';

// Uncomment for big icon for module sublinks "detail view" on course home page
$this->_pages['mods/gamify/index.php']['img']      = 'mods/gamify/gamify.png';

// ** possible alternative: **
// the text to display on module "detail view" when sublinks are not available
$this->_pages['mods/gamify/index.php']['text']      = _AT('gamify_text');

/*******
 * if this module is to be made available to students on the Home or Main Navigation.
 */
$_group_tool = $_student_tool = 'mods/gamify/index.php';

/*******
 * add the admin pages when needed.
 */
if (admin_authenticate(AT_ADMIN_PRIV_GAMIFY, TRUE)) {
	$this->_pages[AT_NAV_ADMIN] = array('mods/gamify/index_admin.php');
	$this->_pages['mods/gamify/index_admin.php']['title_var'] = 'gamify';
	$this->_pages['mods/gamify/index_admin.php']['parent']    = AT_NAV_ADMIN;
	$this->_pages['mods/gamify/index_admin.php']['guide'] = 'mods/gamify/admin_handbook.php';
	$this->_pages['mods/gamify/edit_event.php']['title_var'] = 'gamify_edit_event';
	$this->_pages['mods/gamify/edit_event.php']['parent']    = 'mods/gamify/index_admin.php';
	$this->_pages['mods/gamify/edit_event.php']['guide'] = 'mods/gamify/admin_handbook.php';
	$this->_pages['mods/gamify/edit_level.php']['title_var'] = 'edit_level';
    $this->_pages['mods/gamify/edit_level.php']['parent']   = 'mods/gamify/index_admin.php';
    $this->_pages['mods/gamify/edit_badge.php']['title_var'] = 'edit_badge';
    $this->_pages['mods/gamify/edit_badge.php']['parent']   = 'mods/gamify/index_admin.php';
	$this->_pages['mods/gamify/delete_event.php']['title_var'] = 'gamify_delete_event';
	$this->_pages['mods/gamify/delete_event.php']['parent']    = 'mods/gamify/index_admin.php';
    $this->_pages['mods/gamify/delete_badge.php']['title_var'] = 'delete_badge';
    $this->_pages['mods/gamify/delete_badget.php']['parent']   = 'mods/gamify/index_admin.php';    
	$this->_pages['mods/gamify/delete_level.php']['title_var'] = 'delete_level';
    $this->_pages['mods/gamify/delete_level.php']['parent']   = 'mods/gamify/index_admin.php';
	//$this->_pages['mods/gamify/PHPGamification/Sample/index.php']['title_var'] = 'gamify_sample';

}

/*******
 * instructor Manage section:
 */
 if (authenticate(AT_PRIV_GAMIFY, TRUE)) {
$this->_pages['mods/gamify/index_instructor.php']['title_var'] = 'gamify';
$this->_pages['mods/gamify/index_instructor.php']['parent']   = 'tools/index.php';
$this->_pages['mods/gamify/index_instructor.php']['guide'] = 'mods/gamify/instructor_handbook.php';
$this->_pages['mods/gamify/delete_event.php']['title_var'] = 'delete_event';
$this->_pages['mods/gamify/delete_event.php']['parent']   = 'mods/gamify/index_instructor.php';
$this->_pages['mods/gamify/edit_event.php']['title_var'] = 'edit_event';
$this->_pages['mods/gamify/edit_event.php']['parent']   = 'mods/gamify/index_instructor.php';
$this->_pages['mods/gamify/edit_level.php']['title_var'] = 'edit_level';
$this->_pages['mods/gamify/edit_level.php']['parent']   = 'mods/gamify/index_instructor.php';
$this->_pages['mods/gamify/copy_event.php']['title_var'] = 'edit_event';
$this->_pages['mods/gamify/copy_event.php']['parent']   = 'mods/gamify/index_instructor.php';
$this->_pages['mods/gamify/copy_badge.php']['title_var'] = 'copy_badge';
$this->_pages['mods/gamify/copy_badge.php']['parent']   = 'mods/gamify/index_instructor.php';
$this->_pages['mods/gamify/delete_badge.php']['title_var'] = 'delete_badge';
$this->_pages['mods/gamify/delete_badget.php']['parent']   = 'mods/gamify/index_instructor.php';
$this->_pages['mods/gamify/delete_level.php']['title_var'] = 'delete_level';
$this->_pages['mods/gamify/delete_level.php']['parent']   = 'mods/gamify/index_instructor.php';
$this->_pages['mods/gamify/game_options.php']['title_var'] = 'game_options';
$this->_pages['mods/gamify/game_options.php']['parent']   = 'mods/gamify/index_instructor.php';
$this->_pages['mods/gamify/index_instructor.php']['img']    = 'mods/gamify/images/gamify.png';
}
// ** possible alternative: **
// $this->pages['./index_instructor.php']['title_var'] = 'gamify';
// $this->pages['./index_instructor.php']['parent']    = 'tools/index.php';

/*******
 * student page.
 */
$this->_pages['mods/gamify/index.php']['title_var'] = 'gamify';
$this->_pages['mods/gamify/index.php']['img']       = 'mods/gamify/gamify.png';

/* public pages */
//$this->_pages[AT_NAV_PUBLIC] = array('mods/gamify/index_public.php');
//$this->_pages['mods/gamify/index_public.php']['title_var'] = 'gamify';
//$this->_pages['mods/gamify/index_public.php']['parent'] = AT_NAV_PUBLIC;

/* my start page pages */
$this->_pages[AT_NAV_START]  = array('mods/gamify/index_mystart.php');
$this->_pages['mods/gamify/index_mystart.php']['title_var'] = 'gamify';
$this->_pages['mods/gamify/index_mystart.php']['parent'] = AT_NAV_START;

/*******
 * Use the following array to define a tool to be added to the Content Editor's icon toolbar. 
 * id = a unique identifier to be referenced by javascript or css, prefix with the module name
 * class = reference to a css class in the module.css or the primary theme styles.css to style the tool icon etc
 * src = the src attribute for an HTML img element, referring to the icon to be embedded in the Content Editor toolbar
 * title = reference to a language token rendered as an HTML img title attribute
 * alt = reference to a language token rendered as an HTML img alt attribute
 * text = reference to a language token rendered as the text of a link that appears below the tool icon
 * js = reference to the script that provides the tool's functionality
 */
/*
$this->_content_tools[] = array("id"=>"helloworld_tool", 
                                "class"=>"fl-col clickable", 
                                "src"=>AT_BASE_HREF."mods/gamify/gamify.jpg",
                                "title"=>_AT('gamify_tool'),
                                "alt"=>_AT('gamify_tool'),
                                "text"=>_AT('gamify'), 
                                "js"=>AT_BASE_HREF."mods/gamify/content_tool_action.js");
*/
/*******
 * Register the entry of the callback class. Make sure the class name is properly namespaced, 
 * for instance, prefixed with the module name, to enforce its uniqueness.
 * This class must be defined in "ModuleCallbacks.class.php".
 * This class is an API that contains the static methods to act on core functions.
 */
//$this->_callbacks['gamify'] = 'GmCallbacks';

//function gamify_get_group_url($group_id) {
//	return 'mods/gamify/index.php';
//}
// Run gamify events if a valid user is logged in
if($_SESSION['valid_user'] == 1 && $_SESSION['valid_user'] >0){
    global $_base_path;
    // Hack to fix the get.php appending issue
    $root_path =  preg_replace ('#/get.php#','',$_base_path);
    include($_SERVER['DOCUMENT_ROOT'].$root_path.'/mods/gamify/events.php');
}
// Check course gamify options, and warn if not set
if($_SESSION['is_admin'] == 1){
    //check if gamify is enabled
    $sql = "SELECT home_links, main_links, side_menu FROM %scourses WHERE course_id = %d";
    $gamify_elements = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id']), TRUE);
    
    foreach($gamify_elements as $gamify_element){
        if(preg_match('/gamify/',$gamify_element)){
            $gamify_enabled = TRUE;
            //var_dump($gamify_enabled);
            
        }
    }
    if($_SESSION['course_id']>0 && $gamify_enabled === TRUE){
        $sql = "SELECT * from %sgm_options WHERE course_id=%d";
        $has_options = queryDB($sql, array(TABLE_PREFIX, $_SESSION['course_id']));
        if(empty($has_options[0])){
            global $msg;
            $msg->addWarning("Gamify options must be set in this course. Under the Manage tab, open Gamify and select the Option tab.");
        }
    }
}
?>