# sql file for the Gamify module


INSERT INTO `language_text` VALUES ('en', '_module','gamify','Gamify',NOW(),'');

-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Sep 30, 2016 at 12:47 AM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `atutorgit`
--

-- --------------------------------------------------------

--
-- Table structure for table `gm_badges`
--

CREATE TABLE `gm_badges` (
`id` int(11) NOT NULL,
  `alias` varchar(32) NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` text,
  `image_url` varchar(96) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gm_badges`
--

INSERT INTO `gm_badges` (`id`, `alias`, `title`, `description`, `image_url`) VALUES
(1, 'firsttime', 'Newbee', 'Just for showing up to the course, you get a badge.', 'mods/gamify/images/badges/acorn.png'),
(2, 'newbee', 'Newbee', 'You logged in, congratulations!', 'mods/gamify/images/badges/bronze.png'),
(3, 'addict', 'Addict', 'You have logged in 10 times', 'mods/gamify/images/badges/silver.png'),
(4, 'king_of_chat', 'King of the Chat', 'You posted 20 messages to the chat', 'mods/gamify/images/badges/gold.png'),
(5, 'spreader', 'Blog Spreader', 'You wrote your first post to blog ', 'mods/gamify/images/badges/like.png'),
(6, 'professional_writer', 'Professional Writer', 'You must write a book! 50 posts!!', 'mods/gamify/images/badges/pencil.png'),
(7, 'five_stars_badge', 'Five Stars', 'You get the Five Stars level', 'mods/gamify/images/badges/tick.png'),
(8, 'money_user', 'Rich user', 'You donate some money', 'mods/gamify/images/badges/badge.png');

-- --------------------------------------------------------

--
-- Table structure for table `gm_events`
--

CREATE TABLE `gm_events` (
`id` int(11) NOT NULL,
  `alias` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `description` text CHARACTER SET utf8,
  `allow_repetitions` tinyint(1) DEFAULT '1',
  `reach_required_repetitions` int(11) DEFAULT NULL,
  `max_points` int(11) DEFAULT NULL,
  `id_each_badge` int(11) DEFAULT NULL COMMENT '	',
  `id_reach_badge` int(11) DEFAULT NULL,
  `each_points` int(11) DEFAULT NULL,
  `reach_points` int(11) DEFAULT NULL,
  `each_callback` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `reach_callback` varchar(64) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1 COMMENT='event_callback';

--
-- Dumping data for table `gm_events`
--

INSERT INTO `gm_events` (`id`, `alias`, `description`, `allow_repetitions`, `reach_required_repetitions`, `max_points`, `id_each_badge`, `id_reach_badge`, `each_points`, `reach_points`, `each_callback`, `reach_callback`) VALUES
(1, 'login', 'Login', 0, 2, NULL, 1, 2, 10, 0, NULL, NULL),
(2, 'profile_view', 'Profile view other''s', 0, 10, NULL, NULL, NULL, 10, 25, NULL, NULL),
(3, 'profile_viewed', 'Profile viewed by others', 0, 10, NULL, NULL, NULL, 25, 50, NULL, NULL),
(4, 'sent_message', 'Send a private message', 0, 10, NULL, 0, NULL, 25, 50, NULL, NULL),
(5, 'profile_pic_upload', 'Upload a profile picture', 0, 1, NULL, NULL, NULL, 100, 200, NULL, NULL),
(6, 'read_list_view', 'View reading list details', 0, 15, NULL, NULL, NULL, 25, 50, NULL, NULL),
(7, 'prefs_update', 'Update personal preferences', 1, NULL, NULL, NULL, NULL, 100, NULL, NULL, NULL),
(8, 'read_page', 'Pages viewed', 0, 5, NULL, 2, 3, 10, 25, NULL, NULL),
(9, 'new_folder', 'Create file storage folder', 0, 5, NULL, NULL, NULL, 50, 100, NULL, NULL),
(10, 'upload_file', 'Upload to file storage', 0, 5, NULL, NULL, NULL, 25, 50, NULL, NULL),
(11, 'create_file', 'Create file in file storage', 0, 5, NULL, NULL, NULL, 50, 100, NULL, NULL),
(12, 'file_comment', 'Comment on a file storage file', 0, 5, NULL, NULL, NULL, 25, 50, NULL, NULL),
(13, 'file_description', 'Provide description for file storage file', 0, 5, NULL, NULL, NULL, 50, 100, NULL, NULL),
(14, 'forum_view', 'Forum discussions viewed', 0, 50, NULL, 2, 3, 25, 50, NULL, NULL),
(15, 'forum_post', 'Forum posts', 0, 10, NULL, NULL, 4, 50, 100, NULL, NULL),
(16, 'forum_reply', 'Forum replies', 0, 10, NULL, 4, 5, 75, 150, NULL, NULL),
(17, 'read_time', 'Page view time', 0, 10, NULL, NULL, NULL, 100, 200, NULL, NULL),
(18, 'blog_add', 'Blob posts', 0, 5, NULL, 3, 2, 25, 100, NULL, NULL),
(19, 'blog_comment', 'Blog comments', 0, 5, NULL, 1, 3, 25, 100, NULL, NULL),
(20, 'blog_view', 'Blog views', 0, 5, NULL, 1, 2, 15, 50, NULL, NULL),
(21, 'blog_post_view', 'Blog posts viewed', 0, 10, NULL, 6, 6, 10, 25, NULL, NULL),
(22, 'chat_login', 'Chat login', 0, 10, NULL, 1, 6, 5, 100, NULL, NULL),
(23, 'chat_post', 'Chat posts', 0, 5, NULL, 1, 6, 5, 100, NULL, NULL),
(24, 'link_add', 'Links added', 0, 5, NULL, NULL, 5, 25, 50, NULL, NULL),
(25, 'link_view', 'Links followed', 0, 15, NULL, NULL, NULL, 10, 25, NULL, NULL),
(26, 'poll_post', 'Polls posted', 0, 2, NULL, NULL, NULL, 25, 75, NULL, NULL),
(27, 'photo_create_album', 'Photo albums created', 5, 2, NULL, NULL, NULL, 50, 100, NULL, NULL),
(28, 'photo_upload', 'Photo uploads', 0, 10, NULL, NULL, 8, 25, 50, NULL, NULL),
(29, 'photo_view_album', 'View photo album', 0, 5, NULL, NULL, NULL, 10, 30, NULL, NULL),
(30, 'photo_view_photo', 'View photo', 0, 25, NULL, NULL, NULL, 10, 25, NULL, NULL),
(31, 'photo_comment', 'Comment on a photo', 0, 5, NULL, NULL, NULL, 25, 75, NULL, NULL),
(32, 'photo_album_comment', 'Comment on an album', 0, 5, NULL, NULL, NULL, 50, 150, NULL, NULL),
(33, 'photo_description', 'Photo descriptions provided', 0, 5, NULL, NULL, NULL, 25, 150, NULL, NULL),
(34, 'photo_alt_text', 'Photo Alt texts provided', 0, 5, NULL, NULL, NULL, 50, 250, NULL, NULL),
(35, 'submit_test', 'Submit a test or quiz', 0, 5, NULL, NULL, NULL, 100, 250, NULL, NULL),
(39, 'test', 'test', 0, 2, NULL, NULL, NULL, 5, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gm_levels`
--

CREATE TABLE `gm_levels` (
`id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` text,
  `points` int(11) NOT NULL,
  `icon` varchar(25) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gm_levels`
--

INSERT INTO `gm_levels` (`id`, `title`, `description`, `points`, `icon`) VALUES
(1, 'Level 0', 'Welcome to the course. ', 0, 'star_empty.png'),
(2, 'Level 1', '250 points passed', 250, 'star_white.png'),
(3, 'Level 2', '500 points passed', 500, 'star_yellow.png'),
(4, 'Level 3', '1000 points passed', 1000, 'star_red.png'),
(5, 'Level 4', '1500 points passed', 1500, 'star_green.png'),
(6, 'Level 5', '2000 points passed: ', 2000, 'star_blue.png'),
(7, 'Level 6', '3000 points passed', 3000, 'star_black.png'),
(8, 'Level 7', '5000 points passed: Accomplished status, Bronze Badge', 5000, 'star_bronze.png'),
(9, 'Level 8', '7500 point passed: Intermediate status, Silver Badge', 7500, 'star_silver.png'),
(10, 'Level 9', '10000 points passed: Advanced status: Gold Badge', 10000, 'star_gold.png'),
(11, 'Level 10', '15000 point passed: Highest Honor: Platinum Badge', 15000, 'star_platinum.png');

-- --------------------------------------------------------

--
-- Table structure for table `gm_user_alerts`
--

CREATE TABLE `gm_user_alerts` (
  `id_user` int(10) unsigned NOT NULL,
  `id_badge` int(10) unsigned DEFAULT NULL,
  `id_level` int(10) unsigned DEFAULT NULL,
  `course_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `gm_user_badges`
--

CREATE TABLE `gm_user_badges` (
  `id_user` int(10) unsigned NOT NULL,
  `id_badge` int(10) unsigned NOT NULL,
  `badges_counter` int(10) unsigned NOT NULL,
  `grant_date` datetime NOT NULL,
  `course_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `gm_user_events`
--

CREATE TABLE `gm_user_events` (
  `id_user` int(10) unsigned NOT NULL,
  `id_event` int(10) unsigned NOT NULL,
  `event_counter` int(10) unsigned NOT NULL,
  `points_counter` int(10) unsigned NOT NULL,
  `course_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Table structure for table `gm_user_logs`
--

CREATE TABLE `gm_user_logs` (
  `id_user` int(10) unsigned NOT NULL,
  `id_event` int(10) unsigned DEFAULT NULL,
  `event_date` datetime NOT NULL,
  `id_badge` int(10) unsigned DEFAULT NULL,
  `id_level` int(10) unsigned DEFAULT NULL,
  `points` int(10) unsigned DEFAULT NULL,
  `course_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `gm_user_scores`
--

CREATE TABLE `gm_user_scores` (
  `id_user` int(10) unsigned NOT NULL,
  `points` int(10) unsigned NOT NULL,
  `id_level` int(10) unsigned NOT NULL,
  `course_id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `gm_badges`
--
ALTER TABLE `gm_badges`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gm_events`
--
ALTER TABLE `gm_events`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gm_levels`
--
ALTER TABLE `gm_levels`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gm_user_alerts`
--
ALTER TABLE `gm_user_alerts`
 ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `gm_user_badges`
--
ALTER TABLE `gm_user_badges`
 ADD PRIMARY KEY (`id_user`,`id_badge`,`course_id`);

--
-- Indexes for table `gm_user_events`
--
ALTER TABLE `gm_user_events`
 ADD PRIMARY KEY (`id_user`,`id_event`,`course_id`);

--
-- Indexes for table `gm_user_logs`
--
ALTER TABLE `gm_user_logs`
 ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `gm_user_scores`
--
ALTER TABLE `gm_user_scores`
 ADD PRIMARY KEY (`id_user`,`course_id`);


--
-- AUTO_INCREMENT for table `gm_badges`
--
ALTER TABLE `gm_badges`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `gm_events`
--
ALTER TABLE `gm_events`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `gm_levels`
--
ALTER TABLE `gm_levels`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;