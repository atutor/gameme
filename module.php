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
//$this->_pages['mods/gamify/index.php']['icon']      = 'mods/gamify/gamify_sm.jpg';

// Uncomment for big icon for module sublinks "detail view" on course home page
//$this->_pages['mods/gamify/index.php']['img']      = 'mods/gamify/gamify.jpg';

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
if (admin_authenticate(AT_ADMIN_PRIV_GAMIFY, TRUE) || admin_authenticate(AT_ADMIN_PRIV_ADMIN, TRUE)) {
	$this->_pages[AT_NAV_ADMIN] = array('mods/gamify/index_admin.php');
	$this->_pages['mods/gamify/index_admin.php']['title_var'] = 'gamify';
	$this->_pages['mods/gamify/index_admin.php']['parent']    = AT_NAV_ADMIN;
	$this->_pages['mods/gamify/edit_event.php']['title_var'] = 'gamify_edit_event';
	$this->_pages['mods/gamify/edit_event.php']['parent']    = 'mods/gamify/index_admin.php';
	//$this->_pages['mods/gamify/PHPGamification/Sample/index.php']['title_var'] = 'gamify_sample';

}

/*******
 * instructor Manage section:
 */
$this->_pages['mods/gamify/index_instructor.php']['title_var'] = 'gamify';
$this->_pages['mods/gamify/index_instructor.php']['parent']   = 'tools/index.php';
// ** possible alternative: **
// $this->pages['./index_instructor.php']['title_var'] = 'gamify';
// $this->pages['./index_instructor.php']['parent']    = 'tools/index.php';

/*******
 * student page.
 */
$this->_pages['mods/gamify/index.php']['title_var'] = 'gamify';
$this->_pages['mods/gamify/index.php']['img']       = 'mods/gamify/gamify.jpg';

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
$this->_callbacks['gamify'] = 'GamifyCallbacks';

function gamify_get_group_url($group_id) {
	return 'mods/gamify/index.php';
}

// PHP Gamification Block
// Set enviroment

use Exception;
use gamify\PHPGamification;
use gamify\atutorGamify;
use gamify\PHPGamification\Model;
use gamify\PHPGamification\Model\Event;

if(isset($_SESSION['member_id'])){
    global $_base_path;
    // Hack to fix the get.php appending issue
    $this_path =  preg_replace ('#/get.php#','',$_SERVER['DOCUMENT_ROOT'].$_base_path);
    
    require_once($this_path.'mods/gamify/PHPGamification/PHPGamification.class.php');
    $gamification = new PHPGamification();
    $gamification->setDAO(new DAO(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD));
    $gamification->setUserId($_SESSION['member_id']);
    
     ////////
    // LOGIN TO OR ENTER COURSE
    if(strpos($_SERVER['PHP_SELF'], "bounce.php")&& isset($_REQUEST['course'])){
        $_SESSION['course_id'] = $_REQUEST['course'];
        $gamification->executeEvent('login');
    }
    //$_SESSION['referer'] = $_SERVER['HTTP_REFERER'];;
    //echo $_SERVER['PHP_SELF'];
    ////////
    // CONTENT
    // View content page, but prevent reloading for points
    if(strpos($_SERVER['PHP_SELF'], "content.php")&& isset($_REQUEST['cid'])){
        // Prevent points by page reloading
        if($_SESSION['content_id'] != $_REQUEST['cid']){
            $_SESSION['content_id'] = $_REQUEST['cid'];
            $gamification->executeEvent('read_page');
        }
        // Time on page
        if(isset($_SESSION['timer'])){
            $duration = (time() - $_SESSION['timer']);
            // If on a page 30 seconds or more, extra points
            if($duration > 30){
                $gamification->executeEvent('read_time');
            }
            // Reset timer
            $_SESSION['timer'] = time();

        } else {
            // Set new timer
            $_SESSION['timer'] = time();
        }          
    }
    if(!strpos($_SERVER['PHP_SELF'], "content.php")){
        unset( $_SESSION['timer'] );
        unset( $_SESSION['content_id'] );
    }
    
    ///////
    // FORUM
    // Reply to thread
        if(strpos($_SERVER['PHP_SELF'], "forum/new_thread.php") && isset($_POST['body']) && isset($_POST['subject']) && (isset($_POST['parent_id']) && $_POST['parent_id'] > 0)){     
            $gamification->executeEvent('forum_reply');
    // Post new thread
        }else if(strpos($_SERVER['PHP_SELF'], "forum/new_thread.php") && isset($_POST['body']) && isset($_POST['subject'])){     
            $gamification->executeEvent('forum_post');
    // View forum post
        }else  if(strpos($_SERVER['PHP_SELF'], "forum/view.php") && isset($_REQUEST['fid'])){
            $gamification->executeEvent('forum_view');
        }
        
    ////////
    // BLOG
    // Blog posts and comments
    if(strpos($_SERVER['PHP_SELF'], "blogs/add_post.php") && isset($_POST['body']) && isset($_POST['title'])){
            $gamification->executeEvent('blog_add');
    // Comment on a blog post        
    } else if(strpos($_SERVER['PHP_SELF'], "blogs/post.php") && isset($_POST['body']) && isset($_POST['id'])){
        $gamification->executeEvent('blog_comment');
    // View a single blog posts
    } else if(strpos($_SERVER['PHP_SELF'], "blogs/post.php") && isset($_REQUEST['oid']) && isset($_REQUEST['id'])){
        $gamification->executeEvent('blog_post_view');
    // View the full blog postings
    } else if(strpos($_SERVER['PHP_SELF'], "blogs/view.php") && isset($_REQUEST['oid']) && isset($_REQUEST['ot'])){
        // Prevent points by reloading
        if($_SESSION['blog_id'] != $_REQUEST['oid']){
            $_SESSION['blog_id'] = $_REQUEST['oid'];
            $gamification->executeEvent('blog_view');
        }
    }
    if(!strpos($_SERVER['PHP_SELF'], "blogs/view.php")){
        unset( $_SESSION['blog_id'] );
    }
    
    ////////
    // CHAT
    // Login to the chat
    if(strpos($_SERVER['PHP_SELF'], "chat/chat.php") && isset($_REQUEST['firstLoginFlag'])){
        $gamification->executeEvent('chat_login');
    //Post to chat
    } else if(isset($_REQUEST['tempField'])){
        $gamification->executeEvent('chat_post');
    }
    
    /////////
    // LINKS
    // Add link
   if(strpos($_SERVER['PHP_SELF'], "links/add.php") && isset($_POST['title']) && isset($_POST['cat']) && isset($_POST['url']) && isset($_POST['description'])){
        $gamification->executeEvent('link_add');
    // View Link
    } else if(strpos($_SERVER['PHP_SELF'], "links/index.php") && isset($_REQUEST['view'])){
        $gamification->executeEvent('link_view');
    }
    
    ////////
    // POLL
    // Post to a poll
   if(isset($_POST['poll_id']) && isset($_POST['choice'])){
        $gamification->executeEvent('poll_post');
    }    
    
    /////////
    // PHOTO GALLERY
    // Create Album
   if(strpos($_SERVER['PHP_SELF'], "photos/create_album.php") && isset($_POST['album_name']) && isset($_POST['album_type'])){
        $gamification->executeEvent('photo_create_album');
    } 
    // Upload photo, does not consider multiple files can be uploaded at a time. 
    // Should link into the ajax doing the uploading
    if(strpos($_SERVER['PHP_SELF'], "photos/albums.php") && isset($_POST['upload'])){
        $gamification->executeEvent('photo_upload');
    // Comment on Album
    } else if(strpos($_SERVER['HTTP_REFERER'], "photos/albums.php") && strpos($_SERVER['PHP_SELF'], "photos/addComment.php") && isset($_REQUEST['comment'])){
        $gamification->executeEvent('photo_album_comment');
    // View Album
    }else if(strpos($_SERVER['PHP_SELF'], "photos/albums.php") && isset($_REQUEST['id'])){
        // This does not work as expected. unset() below kills the album_viewed session var,
        // even though it does not seem to reach the else condition below, while remaining on albums.php.
        // For now grant points for viewing an album only once per session.
        if($_SESSION['album_viewed'] != $_REQUEST['id']){
                $_SESSION['album_viewed'] =  $_REQUEST['id'];
                $gamification->executeEvent('photo_view_album');
        }
    } 
    // Prevent reloading album for points
    if(!isset($_REQUEST['id'])){
        // why does this unset run when album.php is the active page
        //unset($_SESSION['album_viewed']);
    }
    // Comment on Photo
    if(strpos($_SERVER['HTTP_REFERER'], "photos/photo.php") && strpos($_SERVER['PHP_SELF'], "photos/addComment.php") && isset($_REQUEST['comment'])){
        $gamification->executeEvent('photo_comment');
    } 
     // View Photo
    if(strpos($_SERVER['PHP_SELF'], "photos/photo.php") && isset($_REQUEST['pid']) && isset($_REQUEST['aid'])){
        if($_SESSION['view_photo'] != $_REQUEST['pid']){
            $_SESSION['view_photo'] = $_REQUEST['pid'];
            $gamification->executeEvent('photo_view_photo');
        }
    }
    // Prevent photo reloading for points
    if(!isset($_REQUEST['pid'])){
        unset($_SESSION['view_photo']);
    }
    // Edit photo description and alt text
    if(strpos($_SERVER['PHP_SELF'], "photos/edit_photos.php") && !empty($_POST)){
        foreach($_POST as $key => $value){
            // For each new description, give points
            if(strstr($key, 'description')){
               $this_description = explode("_",$key);
                if(strlen($value) >9){
                    // Check for existing description, points only for new
                    $sql = "SELECT description from %spa_photos WHERE id = %d";
                    $desc_exists = queryDB($sql, array(TABLE_PREFIX, $this_description[1]), TRUE);
                    if($desc_exists['description'] == ''){
                        $gamification->executeEvent('photo_description');
                    }
                }
            }
            // For each new description, give points
            if(strstr($key, 'alt_text')){
                if(strlen($value) >9){
                     // Check for existing alt text, points only for new
                    $sql = "SELECT alt_text from %spa_photos WHERE id = %d";
                    $alt_exists = queryDB($sql, array(TABLE_PREFIX, $this_description[1]), TRUE);
                    if($alt_exists['alt_text'] == ''){
                        $gamification->executeEvent('photo_alt_text');
                    }
                }        
            }
        }
    }
    ////////
    // PROFILE
    // View other's profile
    if(strpos($_SERVER['PHP_SELF'], "profile.php") && !empty($_REQUEST['id'])){
        if($_REQUEST['id'] != $_SESSION['member_id']){
            if($_SESSION['view_profile'] != $_REQUEST['id']){
                $_SESSION['view_profile'] = $_REQUEST['id'];
                $gamification->executeEvent('profile_view');
            }
        }
    }
    // Other's view your profile
    if(strpos($_SERVER['PHP_SELF'], "profile.php") && !empty($_REQUEST['id'])){
        if($_REQUEST['id'] != $_SESSION['member_id']){
            if($_SESSION['profile_viewed'] != $_REQUEST['id']){
                $_SESSION['profile_viewed'] = $_REQUEST['id'];
                // temporarily set user id to that of the profile being viewed
                $gamification->setUserId($_REQUEST['id']);
                $gamification->executeEvent('profile_viewed');
                // Switch back to the session's owner
                $gamification->setUserId($_SESSION['member_id']);
            }
        }
    }
    // Upload a profile picture
     if(!strpos($_SERVER['PHP_SELF'], "profile.php") && !empty($_POST['id']) && !empty($_POST['upload'])){
        $gamification->executeEvent('profile_pic_upload');
     }
    
    // Prevent profile reloading for points
    if(!strpos($_SERVER['PHP_SELF'], "profile_pictures/profile_picture.php") && empty($_REQUEST['id'])){

    }
    
    //////////
    // INBOX
    // private message someone
    if(strpos($_SERVER['PHP_SELF'], "inbox/send_message.php") && !empty($_POST['to']) && !empty($_POST['subject']) && !empty($_POST['message'])){
        $gamification->executeEvent('sent_message');
    }

    //////////
    // READING LIST
    // view reading list details
    if(strpos($_SERVER['PHP_SELF'], "reading_list/display_resource.php") && !empty($_REQUEST['id'])){
        if($_SESSION['read_list_view'] != $_REQUEST['id']){
            $_SESSION['read_list_view'] = $_REQUEST['id'];
            $gamification->executeEvent('read_list_view');
        }
    }
    // Leave this set TRUE to prevent back/forth to generate points
    // Must move between two reading list items to get points again for 
    // one viewed already this session
    //if(!strpos($_SERVER['PHP_SELF'], "reading_list/display_resource.php")){
    //     unset($_SESSION['read_list_view']);
    // }
    
    ///////////
    // PERSONAL PREFERENCES
     if(strpos($_SERVER['PHP_SELF'], "pref_wizard/index.php") && !empty($_POST['done'])){
        $gamification->executeEvent('prefs_update'); 
     }
     
     /////////
     // FILE STORAGE
     // Create folder
     if(strpos($_SERVER['PHP_SELF'], "file_storage/index.php") && !empty($_POST['new_folder_name'])){
        $gamification->executeEvent('new_folder'); 
     }
    // Upload file
     if(strpos($_SERVER['PHP_SELF'], "file_storage/index.php") && !empty($_POST['upload'])){
        $gamification->executeEvent('upload_file'); 
     }
    // Create new file
    if(strpos($_SERVER['PHP_SELF'], "file_storage/new.php") && !empty($_POST['body'])){
        $gamification->executeEvent('create_file'); 
    }
    // Download file NOT WORKING, NO PAGE RELOAD TO TRIGGER
    //if(strpos($_SERVER['PHP_SELF'], "file_storage/index.php") && !empty($_POST['download'])){
    //   $gamification->executeEvent('download_file'); 
    //}
    // File description
    if((strpos($_SERVER['PHP_SELF'], "file_storage/edit.php") || strpos($_SERVER['PHP_SELF'], "file_storage/new.php")) && !empty($_POST['description'])){
        $gamification->executeEvent('file_description'); 
    }   
    // Version comments
    if((strpos($_SERVER['PHP_SELF'], "file_storage/edit.php") || strpos($_SERVER['PHP_SELF'], "file_storage/new.php")) && !empty($_POST['comment'])){
        $gamification->executeEvent('file_description'); 
    }  
    
    ///////////
    // TESTS & SURVEYS
    //
    if((strpos($_SERVER['PHP_SELF'], "tests/take_test.php")) && !empty($_POST['submit']) && !empty($_POST['tid'])){
        $gamification->executeEvent('submit_test'); 
    } 
}

?>