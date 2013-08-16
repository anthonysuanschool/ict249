
CREATE DATABASE `rake`;

USE `rake`;

/*Table structure for table `scraper_meta` */

CREATE TABLE `scraper_meta` (
  `scraper_meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `scraper_id` int(11) DEFAULT NULL,
  `scraper_meta_key` varchar(100) DEFAULT NULL,
  `scraper_meta_value` text,
  PRIMARY KEY (`scraper_meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `scraper_users` */

CREATE TABLE `scraper_users` (
  `scraper_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `scraper_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `scraper_user_date_started` datetime DEFAULT NULL,
  `scraper_user_rating` int(11) DEFAULT NULL,
  PRIMARY KEY (`scraper_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `scrapers` */

CREATE TABLE `scrapers` (
  `scraper_id` int(11) NOT NULL AUTO_INCREMENT,
  `scraper_author` int(11) DEFAULT NULL,
  `scraper_url` varchar(1000) DEFAULT NULL,
  `scraper_encoding` varchar(50) DEFAULT NULL,
  `scraper_global_search_pattern` text,
  `scraper_item_search_pattern` text,
  `scraper_privacy` enum('public','private','draft') DEFAULT NULL,
  `scraper_description` text,
  `scraper_date_created` datetime DEFAULT NULL,
  `scraper_last_edited` datetime DEFAULT NULL,
  `scraper_thumnail_url` varchar(1000) DEFAULT NULL,
  `scraper_nicename` varbinary(200) DEFAULT NULL,
  `scraper_output_template` text,
  PRIMARY KEY (`scraper_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `settings` */

CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) DEFAULT NULL,
  `setting_value` text,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `user_meta` */


CREATE TABLE `user_meta` (
  `user_meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_meta_key` varchar(100) DEFAULT NULL,
  `user_meta_value` text,
  PRIMARY KEY (`user_meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `users` */


CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) DEFAULT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `user_active` enum('pending','active','deactivated') DEFAULT NULL,
  `user_registered` datetime DEFAULT NULL,
  `user_last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

