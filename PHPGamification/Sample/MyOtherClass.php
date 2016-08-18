<?php
class MyOtherClass
{
    static function myPostToBlogCallBackFunction($params)
    {
        echo "<br><i>Posted one more time to blog! <b>Post id: ".$params['YourPostId']."</b>. Great! Send some email or call an API endpoint...</i>";
        // IT MUST RETURN TRUE to gamification continue to flow.
        // Returning true it will give the points and badges like setup
        // Returning false it will don't give any points of badges for that event
        return true;
    }

    static function myPostToChatReachCallBackFunction(){
        echo "<br><i>Posted to chat so many times and granted a Badge! Send some email or call an API endpoint...</i>";
        // IT MUST RETURN TRUE to gamification continue to flow.
        // Returning true it will give the points and badges like setup
        // Returning false it will don't give any points of badges for that event
        return true;
    }
}