SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `mythicalpics_apikeys` (
  `id` int(11) NOT NULL,
  `api_key` text NOT NULL,
  `owner_api_key` text NOT NULL,
  `name` text NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mythicalpics_domains` (
  `id` int(11) NOT NULL,
  `domain` text DEFAULT NULL,
  `description` text NOT NULL DEFAULT 'The default description of the domain',
  `ownerkey` text DEFAULT NULL,
  `created-date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mythicalpics_imgs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `owner_key` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `storage_folder` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mythicalpics_nodes` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `host` text NOT NULL,
  `auth_key` text NOT NULL,
  `created-date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mythicalpics_settings` (
  `id` int(11) NOT NULL,
  `app_name` text NOT NULL DEFAULT '\'MythicalSystems\'',
  `app_logo` text NOT NULL DEFAULT 'https://avatars.githubusercontent.com/u/117385445',
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
  `version` text NOT NULL DEFAULT '\'1.4.1\''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mythicalpics_users` (
  `id` int(11) NOT NULL,
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
  `domain` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `mythicalpics_apikeys`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mythicalpics_domains`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mythicalpics_imgs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mythicalpics_nodes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mythicalpics_settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mythicalpics_users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `mythicalpics_apikeys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mythicalpics_domains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mythicalpics_imgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mythicalpics_nodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mythicalpics_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mythicalpics_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
