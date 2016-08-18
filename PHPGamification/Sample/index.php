<?php
/**
 * Sample file showing how to use PHPGamification
 */
namespace gamify\PHPGamification;

define('AT_INCLUDE_PATH', '../../../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');
$_custom_css = $_base_path . 'mods/hello_world/module.css'; // use a custom stylesheet
require (AT_INCLUDE_PATH.'header.inc.php');



// Set enviroment
use Exception;
use gamify\PHPGamification;
use gamify\PHPGamification\Model;
use gamify\PHPGamification\Model\Event;

//error_reporting(E_ALL ^ E_NOTICE);
//ini_set('display_errors', 'On');

// PHP Gamification require
require_once('../PHPGamification.class.php');

// Some other class used to callback sample
require_once('MyOtherClass.php');

// Creation of gamification engine and DAO
$gamification = new PHPGamification();
$gamification->setDAO(new DAO('localhost', 'atutorgit', 'root', 'root'));

// Reser all data (be careful, only to test purpose)
$truncateDatabaseFull = false; // Will truncate "levels" and "badges" tables, and ALL data (config+user data)
$truncateDatabaseUsers = false; // Will truncate just logs, events and user related data (user data)

    $sql="SELECT * FROM %sgm_events";
    $these_events = queryDB($sql, array(TABLE_PREFIX));
    //debug($these_events);
    $sql="SELECT * FROM %sgm_badges";
    $these_badges = queryDB($sql, array(TABLE_PREFIX));
     //debug($these_badges);
    $sql="SELECT * FROM %sgm_levels";
    $these_levels = queryDB($sql, array(TABLE_PREFIX));
     //debug($these_levels);     
    echo "<br /><br />";

if ($truncateDatabaseFull) {
    /**
     * Rules setup
     */
    $gamification->truncateDatabase(true);
    /** Badges definitions */
    $gamification->addBadge('breath', 'You breath', 'Happy to you are live', 'img/badge0.png');
    $gamification->addBadge('newbee', 'Newbee', 'You logged in, congratulations!', 'img/badge1.png');
    $gamification->addBadge('addict', 'Addict', 'You have logged in 10 times', 'img/badge1.png');
    $gamification->addBadge('king_of_chat', 'King of the Chat', 'You posted 20 messages to the chat', 'img/badge2.png');
    $gamification->addBadge('spreader', 'Blog Spreader', 'You wrote your first post to blog ', 'img/badge3.png');
    $gamification->addBadge('professional_writer', 'Professional Writer', 'You must write a book! 50 posts!!', 'img/badge3.png');
    $gamification->addBadge('five_stars_badge', 'Five Stars', 'You get the Five Stars level', 'img/badge4.png');
    $gamification->addBadge('money_user', 'Rich user', 'You donate some money', 'img/badge5.png');

    /** Levels definitions */
    $gamification->addLevel(0, 'No Star');
    $gamification->addLevel(50, 'One star');
    $gamification->addLevel(200, 'Two stars');
    $gamification->addLevel(500, 'Three stars');
    $gamification->addLevel(1000, 'Five stars', 'grant_five_stars_badge');// Execute event: grant_five_stars_badge
    $gamification->addLevel(2000, '2K points!');


    /** Events definitions */

    // You breath (10 points + badge)
    $event = new Event();
    $event->setAlias('breath')
        ->setEachPointsGranted(10)
        ->setEachBadgeGranted($gamification->getBadgeByAlias('breath'));
    $gamification->addEvent($event);

    // Welcome to our network! (disallow reachRequiredRepetitions)
    $sql="SELECT * FROM %sgm_events";
    $these_events = queryDB($sql, array(TABLE_PREFIX));
    echo "<br /><br />";
    debug($these_events);
    //exit;
    $event = new Event();
    $event->setAlias('join_network')
        ->setEachPointsGranted(10)
        ->setAllowRepetitions(false); // Just one time
    $gamification->addEvent($event);

    // Each Login/Logged in 10 times (25 points each time, 50 points when reach 10 times)
    $event = new Event();
    $event->setAlias('login')
        ->setEachPointsGranted(25)
        ->setEachBadgeGranted($gamification->getBadgeByAlias('newbee'))
        ->setReachRequiredRepetitions(10)
        ->setReachPointsGranted(50)
        ->setReachBadgeGranted($gamification->getBadgeByAlias('addict'));
    $gamification->addEvent($event);

    // Each Post to the chat/Posted 20 messages to the chat (5 points each post, badge when 20 reached)
    $event = new Event();
    $event->setAlias('post_to_chat')
        ->setEachPointsGranted(5)
        ->setReachRequiredRepetitions(20)
        ->setReachBadgeGranted($gamification->getBadgeByAlias('king_of_chat'))
        ->setReachCallback("MyOtherClass::myPostToChatReachCallBackFunction");
    $gamification->addEvent($event);

    // Each post to blog/You wrote 5 post to your blog (100 points each + badge, 1000 points reach)
    $event = new Event();
    $event->setAlias('post_to_blog')
        ->setEachPointsGranted(150)
        ->setEachBadgeGranted($gamification->getBadgeByAlias('spreader'))
        ->setEachCallback("MyOtherClass::myPostToBlogCallBackFunction")
        ->setReachRequiredRepetitions(50)
        ->setReachBadgeGranted($gamification->getBadgeByAlias('professional_writer'));
    $gamification->addEvent($event);

    // When you get the Five Stars level
    $event = new Event();
    $event->setAlias('grant_five_stars_badge')
        ->setEachBadgeGranted($gamification->getBadgeByAlias('five_stars_badge'));
    $gamification->addEvent($event);

    // When you get the Five Stars level
    $event = new Event();
    $event->setAlias('donate_money')
        ->setEachBadgeGranted($gamification->getBadgeByAlias('money_user'));
    $gamification->addEvent($event);

} else if ($truncateDatabaseUsers == true) {
    $gamification->truncateDatabase(false);
}

/**
 * USAGE:
 */

// User who receives gamification events
$gamification->setUserId(1);
// Show user scores before events
echo "<b>Scores before executing events</b>";
//showUserScores($gamification);
showUser($gamification);
echo "<hr>";
/*
try {
    echo "<b>Executing events</b>";
    // Fire a event
    $gamification->executeEvent('breath');
    $gamification->executeEvent('join_network');

    $gamification->executeEvent('login');
    for ($i=0; $i<9; $i++)
        $gamification->executeEvent('login');

    $gamification->executeEvent('post_to_chat', array('additional data sent to callback functions'));
    for ($i=0; $i<19; $i++)
        $gamification->executeEvent('post_to_chat');

    for ($i=0; $i<60; $i++)
        $gamification->executeEvent('post_to_blog', array('YourPostId'=>$i));

    echo "<hr>";
    echo "<b>After execute events</b>";
    // Show all data
    showUser($gamification);

} catch (Exception $e) {
    // Exceptions are not handled in Gamification classes, you need do it be yourself
    echo "Exception: " . $e;
    die();
}
*/
function showUserScores(PHPGamification $gamification)
{
    echo "<h2>getUserScores</h2>";
    $score = $gamification->getUserScores();
    echo "Points: " . $score->getPoints() . " - Id Level: " . $score->getIdLevel() . " - Progress: " . $score->getProgress() . " - Level Name: " . $score->getLevel()->getTitle() . "<br>";
}

function showUser(PHPGamification $gamification)
{
    showUserScores($gamification);
    echo "<h2>getUserEvents</h2>";
    $events = $gamification->getUserEvents();
    foreach ($events as $event) {
//        var_dump($event);
        echo "Event Id: $event[id] - Alias: " . $event['event']->getAlias() . " - Counter: $event[counter]<br>";
        foreach ($event['triggers'] as $k => $trigger)
            echo " &nbsp;  &nbsp; Trigger: $k - Reached: " . ($trigger['reached'] ? "true" : "false") . "<br>";
    }

    //Get user level, badges
    echo "<h2>getUserBadges</h2>";
    $badges = $gamification->getUserBadges();
    if ($badges)
        foreach ($badges as $badge) {
            echo "Badge Id: " . $badge->getIdBadge() . " -  Counter: " . $badge->getBadgeCounter() . " - Alias: " . $badge->getBadge()->getAlias() . " - Description: " . $badge->getBadge()->getDescription() . " <br>";
        }

    echo "<h2>getUserAlerts</h2>";
    $alerts = $gamification->getUserAlerts();
    if ($alerts == null) {
        echo "No level or badge alerts to show<br>";
    } else {
        foreach ($alerts as $alert) {
            if ($alert->getIdBadge())
                echo "Badge: " . $alert->getBadge()->getTitle(). " - Id Badge: ".$alert->getIdBadge();
            if ($alert->getIdLevel())
                echo "Level: " . $alert->getIdLevel() . " - Id Level: " . $alert->getIdLevel();
            echo "<br>";
        }
    }

    echo "<h2>getUserLog</h2>";
    $logs = $gamification->getUserLog();
    if ($logs)
        foreach ($logs as $log) {
            echo "EventDate: " . $log->getEventDate()." - Id Event: " . $log->getIdEvent() . " -  Event: ".$log->getEvent()->getAlias();
            if ($log->getPoints())
                echo " - Points: " . $log->getPoints();
            if ($log->getIdBadge())
                echo " - Badge: " . $log->getBadge()->getTitle(). " - Id Badge: ".$log->getIdBadge();
            if ($log->getIdLevel())
                echo " - Level: " . $log->getIdLevel() . " - Id Level: " . $log->getIdLevel();
            echo "<br>";
        }

    echo "<hr>";
}

require (AT_INCLUDE_PATH.'footer.inc.php'); 