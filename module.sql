REPLACE INTO `language_text` VALUES ('en', '_module', 'gamify', 'Gamify', '2016-09-25 15:59:56', 'gamification mod');

CREATE TABLE `gm_badges` (
`id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL DEFAULT '0',
  `alias` varchar(32) CHARACTER SET latin1 NOT NULL,
  `title` varchar(64) CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1,
  `image_url` varchar(96) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `gm_badges` (`id`, `course_id`, `alias`, `title`, `description`, `image_url`) VALUES
(7, 0, 'upload_file_badge', 'Good use of File Storage', 'You have figured out how to upload files into the course.', 'mods/gamify/images/badges/arrow.png'),
(8, 0, 'create_file_badge', 'Create your own files', 'You learned how to create new files in File Storage.', 'mods/gamify/images/badges/doc.png'),
(2, 0, 'profile_viewed_badge', 'You''re getting noticed', '25 people have viewed your profile', 'mods/gamify/images/badges/eye.png'),
(1, 0, 'profile_view_badge', 'You know your classmates', 'You have viewed 25 of your classmates'' profiles', 'mods/gamify/images/badges/id.png'),
(4, 0, 'prefs_update_badge', 'You found your settings', 'You know how to update your personal preference, and configure ATutor to your liking. ', 'mods/gamify/images/badges/mixer.png'),
(3, 0, 'profile_pic_upload_badge', 'You have a profile pic', 'People are more likely to interact when you have a profile picture.', 'mods/gamify/images/badges/adduser.png'),
(5, 0, 'read_page_badge', 'You are well on your way', 'You have read 25 pages in the course. Keep going!', 'mods/gamify/images/badges/silver.png'),
(6, 0, 'new_folder_badge', 'You''re organized', 'You know how to create folder in File Storage to organize your files.', 'mods/gamify/images/badges/folder.png'),
(9, 0, 'forum_view_badge', 'Discussion Reader', 'You are doing a great job reading through discussion posts in the forums.', 'mods/gamify/images/badges/bronze.png'),
(10, 0, 'forum_post_badge', 'Discussion Poster', 'You have been a great contributor in the discussion forums.', 'mods/gamify/images/badges/gold.png'),
(11, 0, 'forum_reply_badge', 'Great Feedback', 'You have been replying to others posts in the discussion forums', 'mods/gamify/images/badges/conversation.png'),
(12, 0, 'blog_add_badge', 'Blog Poster', 'You''re making great use of the course blog. Keep on posting!', 'mods/gamify/images/badges/email.png'),
(13, 0, 'blog_comment_badge', 'Blog Commenter', 'You have been commenting on other (or your own) blog posts. Keep on commenting.', 'mods/gamify/images/badges/lightbulb.png'),
(14, 0, 'chat_login_badge', 'Chat Login', 'You are making good use of the ATutor chat, a great place to interact live with your classmates', 'mods/gamify/images/badges/chat.png'),
(15, 0, 'chat_post_badge', 'Chat Contributor', 'You are posting message to the chat. Keep on chatting!', 'mods/gamify/images/badges/bolt.png'),
(16, 0, 'link_add_badge', 'Link Poster', 'You''ve been adding links to the course resources. Keep adding!', 'mods/gamify/images/badges/link.png'),
(17, 0, 'photo_create_album_badge', 'Create Album', 'You learned how to create an album in the Photo Gallery. Keep creating albums to share.', 'mods/gamify/images/badges/news.png'),
(18, 0, 'photo_create_album_badge', 'Create Albums', 'You have created several photo albums. Perhaps photograhpy is your calling!', 'mods/gamify/images/badges/brush.png'),
(19, 0, 'photo_upload_badge', 'Photo Uploader', 'You have been uploading photos into your photo gallery. Keep adding.', 'mods/gamify/images/badges/picture.png'),
(20, 0, 'photo_comment_badge', 'Photo comments', 'You have been commenting you yours and others photos. Keep commenting for bonus points;', 'mods/gamify/images/badges/like.png'),
(21, 0, 'photo_album_comment', 'Album Comment', 'Most people comment on photo, but you commenteed on an album for bonus points.', 'mods/gamify/images/badges/cards.png'),
(22, 0, 'photo_description_badge', 'Photo Describer', 'Exellent job providing descriptions for you photos. ', 'mods/gamify/images/badges/feather.png'),
(23, 0, 'photo_alt_text', 'Accessibility Aware', 'Its great you are providing Alt text for you image, to make them accessible to people with disabilities. Secret bonus points if you continue adding Alt text to new images in you gallery.', 'mods/gamify/images/badges/heart.png'),
(24, 0, 'login_badge reach', 'Returning Visitor', 'You come back quite a few times now. Keep on visiting the course for bonus points.', 'mods/gamify/images/badges/hot.png'),
(25, 0, 'logout_badge', 'Security Conscious', 'You have been loggin out, rather than leaving or allowing your session to time out. This helps improve security.', 'mods/gamify/images/badges/lock.png'),
(26, 0, 'welcome_badge', 'Welcome', 'Welcome to the course. Finding your way here earned you your first badge. Get busy with the course to earn points and collect more badges.', 'mods/gamify/images/badges/acorn.png');

CREATE TABLE `gm_events` (
`id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL DEFAULT '0',
  `alias` varchar(32) NOT NULL DEFAULT '',
  `description` text,
  `allow_repetitions` tinyint(1) DEFAULT '1',
  `reach_required_repetitions` int(11) DEFAULT NULL,
  `max_points` int(11) DEFAULT NULL,
  `id_each_badge` int(11) DEFAULT NULL COMMENT '	',
  `id_reach_badge` int(11) DEFAULT NULL,
  `each_points` int(11) DEFAULT NULL,
  `reach_points` int(11) DEFAULT NULL,
  `each_callback` varchar(64) DEFAULT NULL,
  `reach_callback` varchar(64) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `gm_events` (`id`, `course_id`, `alias`, `description`, `allow_repetitions`, `reach_required_repetitions`, `max_points`, `id_each_badge`, `id_reach_badge`, `each_points`, `reach_points`, `each_callback`, `reach_callback`) VALUES
(1, 0, 'login', 'Login', 0, NULL, NULL, 1, NULL, 10, 25, NULL, NULL),
(2, 0, 'profile_view', 'Profile view other''s', 0, 10, NULL, NULL, 1, 10, 25, NULL, NULL),
(3, 0, 'profile_viewed', 'Profile viewed by others', 0, 25, NULL, NULL, 2, 25, 50, NULL, NULL),
(4, 0, 'sent_message', 'Send a private message', 0, 10, NULL, NULL, NULL, 25, 50, NULL, NULL),
(5, 0, 'profile_pic_upload', 'Upload a profile picture', 0, 1, NULL, NULL, 3, 100, 200, NULL, NULL),
(6, 0, 'read_list_view', 'View reading list details', 0, 15, NULL, NULL, NULL, 25, 50, NULL, NULL),
(7, 0, 'prefs_update', 'Update personal preferences', 1, 1, NULL, 4, NULL, 250, NULL, '', NULL),
(8, 0, 'read_page', 'Pages viewed', 0, 25, NULL, NULL, 5, 10, 25, NULL, NULL),
(9, 0, 'new_folder', 'Create file storage folder', 0, 5, NULL, NULL, 6, 50, 100, NULL, NULL),
(10, 0, 'upload_file', 'Upload to file storage', 0, 5, NULL, NULL, 7, 25, 50, NULL, NULL),
(11, 0, 'create_file', 'Create file in file storage', 0, 2, NULL, NULL, 8, 50, 100, NULL, NULL),
(12, 0, 'file_comment', 'Comment on a file storage file', 0, 5, NULL, NULL, NULL, 25, 50, NULL, NULL),
(13, 0, 'file_description', 'Provide description for file storage file', 0, 5, NULL, NULL, NULL, 50, 100, NULL, NULL),
(14, 0, 'forum_view', 'Forum discussions viewed', 0, 50, NULL, NULL, 9, 25, 50, NULL, NULL),
(15, 0, 'forum_post', 'Forum posts', 0, 10, NULL, NULL, 10, 50, 100, NULL, NULL),
(16, 0, 'forum_reply', 'Forum replies', 0, 10, NULL, NULL, 11, 75, 150, NULL, NULL),
(17, 0, 'read_time', 'Page view time', 0, 10, NULL, NULL, NULL, 100, 200, NULL, NULL),
(18, 0, 'blog_add', 'Blob posts', 0, 10, NULL, NULL, 12, 25, 100, NULL, NULL),
(19, 0, 'blog_comment', 'Blog comments', 0, 5, NULL, NULL, 13, 25, 100, NULL, NULL),
(20, 0, 'blog_view', 'Blog views', 0, 15, NULL, NULL, NULL, 15, 50, NULL, NULL),
(21, 0, 'blog_post_view', 'Blog posts viewed', 0, 10, NULL, NULL, NULL, 10, 25, NULL, NULL),
(22, 0, 'chat_login', 'Chat login', 0, 10, NULL, NULL, 14, 5, 100, NULL, NULL),
(23, 0, 'chat_post', 'Chat posts', 0, 10, NULL, NULL, 15, 5, 100, NULL, NULL),
(24, 0, 'link_add', 'Links added', 0, 5, NULL, NULL, 16, 25, 50, NULL, NULL),
(25, 0, 'link_view', 'Links followed', 0, 15, NULL, NULL, NULL, 10, 25, NULL, NULL),
(26, 0, 'poll_post', 'Polls posted', 0, 2, NULL, NULL, NULL, 25, 75, NULL, NULL),
(27, 0, 'photo_create_album', 'Photo albums created', 0, 3, NULL, 17, 18, 50, 100, NULL, NULL),
(28, 0, 'photo_upload', 'Photo uploads', 0, 15, NULL, NULL, 19, 25, 50, NULL, NULL),
(29, 0, 'photo_view_album', 'View photo album', 0, 5, NULL, NULL, NULL, 10, 30, NULL, NULL),
(30, 0, 'photo_view_photo', 'View photo', 0, 25, NULL, NULL, NULL, 10, 25, NULL, NULL),
(31, 0, 'photo_comment', 'Comment on a photo', 0, 5, NULL, NULL, 20, 25, 75, NULL, NULL),
(32, 0, 'photo_album_comment', 'Comment on an album', 0, 5, NULL, NULL, 21, 50, 150, NULL, NULL),
(33, 0, 'photo_description', 'Photo descriptions provided', 0, 5, NULL, NULL, 22, 25, 150, NULL, NULL),
(34, 0, 'photo_alt_text', 'Photo Alt texts provided', 0, 5, NULL, NULL, 23, 50, 250, NULL, NULL),
(35, 0, 'submit_test', 'Submit a test or quiz', 0, 5, NULL, NULL, NULL, 100, 250, NULL, NULL),
(38, 0, 'logout', 'Logout (not timeout)', 0, 5, 250, NULL, 25, 10, 25, NULL, NULL),
(39, 0, 'welcome', 'First course login', 1, 1, NULL, NULL, 26, 250, NULL, NULL, NULL);

CREATE TABLE `gm_levels` (
`id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(64) CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1,
  `points` int(11) NOT NULL,
  `icon` varchar(25) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `gm_levels` (`id`, `course_id`, `title`, `description`, `points`, `icon`) VALUES
(1, 0, 'Level 0', 'Welcome to the course', 0, 'star_empty_lg.png'),
(2, 0, 'Level 1', '250 points passed', 250, 'star_white_lg.png'),
(3, 0, 'Level 2', '500 points passed', 500, 'star_yellow_lg.png'),
(4, 0, 'Level 3', '1000 points passed', 1000, 'star_red_lg.png'),
(5, 0, 'Level 4', '1500 points passed', 1500, 'star_green_lg.png'),
(6, 0, 'Level 5', '2000 points passed: ', 2000, 'star_blue_lg.png'),
(7, 0, 'Level 6', '3000 points passed', 3000, 'star_black_lg.png'),
(8, 0, 'Level 7', '5000 points passed: Accomplished status, Bronze Badge', 5000, 'star_bronze_lg.png'),
(9, 0, 'Level 8', '7500 point passed: Intermediate status, Silver Badge', 7500, 'star_silver_lg.png'),
(10, 0, 'Level 9', '10000 points passed: Advanced status: Gold Badge', 10000, 'star_gold_lg.png'),
(11, 0, 'Level 10', '15000 point passed: Highest Honor: Platinum Badge', 15000, 'star_platinum_lg.png');

CREATE TABLE `gm_options` (
`id` int(11) unsigned NOT NULL,
  `course_id` int(11) unsigned NOT NULL,
  `option` varchar(25) NOT NULL DEFAULT '',
  `value` int(11) unsigned DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `gm_user_alerts` (
  `id_user` int(10) unsigned NOT NULL,
  `course_id` int(10) unsigned DEFAULT NULL,
  `id_badge` int(10) unsigned DEFAULT NULL,
  `id_level` int(10) unsigned DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `gm_user_badges` (
  `id_user` int(10) unsigned NOT NULL,
  `id_badge` int(10) unsigned NOT NULL,
  `badges_counter` int(10) unsigned NOT NULL,
  `grant_date` datetime NOT NULL,
  `course_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `gm_user_events` (
  `id_user` int(10) unsigned NOT NULL,
  `id_event` int(10) unsigned NOT NULL,
  `event_counter` int(10) unsigned NOT NULL,
  `points_counter` int(10) unsigned NOT NULL,
  `course_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `gm_user_logs` (
  `id_user` int(10) unsigned NOT NULL,
  `course_id` int(10) unsigned DEFAULT NULL,
  `id_event` int(10) unsigned DEFAULT NULL,
  `event_date` datetime NOT NULL,
  `id_badge` int(10) unsigned DEFAULT NULL,
  `id_level` int(10) unsigned DEFAULT NULL,
  `points` int(10) unsigned DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `gm_user_scores` (
  `id_user` int(10) unsigned NOT NULL,
  `points` int(10) unsigned NOT NULL,
  `id_level` int(10) unsigned NOT NULL,
  `course_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `gm_badges`
 ADD PRIMARY KEY (`id`,`course_id`);

ALTER TABLE `gm_events`
 ADD PRIMARY KEY (`id`,`course_id`);

ALTER TABLE `gm_levels`
 ADD PRIMARY KEY (`id`,`course_id`);

ALTER TABLE `gm_options`
 ADD PRIMARY KEY (`course_id`,`option`), ADD KEY `id` (`id`);

ALTER TABLE `gm_user_badges`
 ADD PRIMARY KEY (`id_user`,`id_badge`,`course_id`);

ALTER TABLE `gm_user_events`
 ADD PRIMARY KEY (`id_user`,`id_event`,`course_id`);

ALTER TABLE `gm_user_logs`
 ADD KEY `id_user` (`id_user`);

ALTER TABLE `gm_user_scores`
 ADD PRIMARY KEY (`id_user`,`course_id`);

ALTER TABLE `gm_badges`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;

ALTER TABLE `gm_events`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;

ALTER TABLE `gm_levels`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;

ALTER TABLE `gm_options`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=410;