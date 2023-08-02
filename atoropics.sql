


DROP TABLE IF EXISTS `atoropics_apikeys`;
CREATE TABLE `atoropics_apikeys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api_key` text NOT NULL,
  `owner_api_key` text NOT NULL,
  `name` text NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


LOCK TABLES `atoropics_apikeys` WRITE;
UNLOCK TABLES;


DROP TABLE IF EXISTS `atoropics_domains`;
CREATE TABLE `atoropics_domains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` text DEFAULT NULL,
  `description` text NOT NULL DEFAULT 'The default description of the domain',
  `ownerkey` text DEFAULT NULL,
  `created-date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


LOCK TABLES `atoropics_domains` WRITE;
UNLOCK TABLES;


DROP TABLE IF EXISTS `atoropics_imgs`;
CREATE TABLE `atoropics_imgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `owner_key` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `storage_folder` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


LOCK TABLES `atoropics_imgs` WRITE;
UNLOCK TABLES;

DROP TABLE IF EXISTS `atoropics_settings`;
CREATE TABLE `atoropics_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_name` text NOT NULL DEFAULT 'AtoroPics',
  `app_logo` text NOT NULL DEFAULT 'https://avatars.githubusercontent.com/u/118304455',
  `app_maintenance` enum('false','true') NOT NULL DEFAULT 'false',
  `app_proto` varchar(255) NOT NULL,
  `app_url` varchar(255) NOT NULL,
  `enable_registration` enum('true','false') NOT NULL,
  `enable_rechapa2` enum('false','true') NOT NULL,
  `rechapa2_site_key` text DEFAULT NULL,
  `rechapa2_site_secret` text DEFAULT NULL,
  `discord` varchar(255) NOT NULL,
  `enable_smtp` enum('false','true') NOT NULL,
  `smtp_host` varchar(255) NOT NULL,
  `smtp_port` varchar(255) NOT NULL,
  `smtp_user` varchar(255) NOT NULL,
  `smtp_password` varchar(255) NOT NULL,
  `smtp_from` varchar(255) NOT NULL,
  `smtp_from_name` varchar(255) NOT NULL,
  `discord_webhook` varchar(255) NOT NULL,
  `version` text NOT NULL DEFAULT '1.3.6',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


LOCK TABLES `atoropics_settings` WRITE;
UNLOCK TABLES;


DROP TABLE IF EXISTS `atoropics_users`;
CREATE TABLE `atoropics_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `code` text NOT NULL,
  `last_ip` text DEFAULT 'localhost',
  `register_ip` text DEFAULT 'localhost',
  `api_key` text NOT NULL,
  `admin` enum('false','true') NOT NULL DEFAULT 'false',
  `embed_title` text DEFAULT NULL,
  `embed_small_title` text DEFAULT NULL,
  `embed_desc` text DEFAULT NULL,
  `embed_theme` text DEFAULT NULL,
  `embed_domain` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


LOCK TABLES `atoropics_users` WRITE;
UNLOCK TABLES;


