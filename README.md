# ATutor Gamification Module
This module provides tools for creating gamification elements, adding them to courses, and monitoring student behaviour. It can be used to motivate students, as they collect points and badges, with tailored rewards for actions taken and milestone accomplishments met.

## Gamification Base

PHPGamification

Cloned from: https://github.com/TiagoGouvea/PHPGamification.git

## Module Code

ATutor module repository: gamify

https://github.com/atutor/gamify
## Features
### Admin

* Create and maintain game elements: levels, events, and badges
* Enable/Disable instructor game element creation
* Review user and course level partcipation and accomplishments

### Instructor

* Create and maintain course level game elements: levels, events, and badges (if enabled)
* Enable/Disable game elements within their courses
* Review user participation and accomplishments

### Student

#### Collect badges for accomplishments per course
* 1 profile_view_badge  reach10  
* 2 profile_viewed_badge reach 25 
* 3 profile_pic_upload_badge reach 1
* 4 prefs_update_badge each 1
* 5 read_page_badge reach 25
* 6 new_folder_badge reach 5
* 7 upload_file_badge reach 5
* 8 create_file_badge reach 2
* 9 forum_view_badge reach 50
* 10 forum_post_badge reach 10
* 11 forum_reply_badge reach 10
* 12 blog_add_badge reach 10
* 13 blog_comment_badge reach 5
* 14 chat_login_badge reach 10 
* 15 chat_post_badge reach 10
* 16 link_add_badge reach 5
* 17 photo_create_album_badge each 1
* 18 photo_create_album_badge reach 3
* 19 photo_upload_badge reach 15
* 20 photo_comment_badge reach 5
* 21 photo_album_comment reach 5
* 22 photo_description_badge reach 5
* 23 photo_alt_text reach 5
* 24 login_badge reach 25
* 25 logout_badge reach 5
* 26 welcome_badge reach 1

#### Advance through levels with course participation
* logins  DONE
* logouts  DONE
* forum views DONE
* forum posts DONE
* forum replies DONE
* blog posts DONE
* blog comment DONE
* blog view DONE
* content page views DONE
* content page duration DONE
* chat login DONE
* chat post DONE
* link add  DONE
* link view DONE
* poll responses  DONE
* photo gallery create album DONE
* photo gallery view album  DONE
* photo gallery view image  DONE
* photo gallery view image   DONE
* photo gallery add photo comment   DONE
* photo gallery add photo alt text   DONE
* photo gallery add photo description   DONE
* photo gallery add album comment DONE (one comment per session only)
* calendar events added XXXXX (Waiting on Herat)
* profile views of others DONE
* others view of your profile DONE
* add a profile picture DONE
* private messages send (inbox) DONE
* view reading list item DONE
* files uploaded to file storage DONE
* new file created with file storage DONE
* comment on file in file storage DONE
* file descriptioon for file in file storage DONE
* update personal preferences DONE

#### See who are the most active, and most accomplished
* leaderboard showing the top contributors (sidemenu, progress tab) DONE

#### See your progress to the next level (sidemenu, progress tab) DONE

#### Badge and level icon default max file sizes
$max_levelicon_size = 15000;  // maximum file size for  level icon in bytes
$max_height = 95;
$max_width = 95;

#### Monitor personal activity and accomplishments (sidemenu, progress tab)
* numbers displayed the available activities and accomplishments (profile page)
* badges collected.
