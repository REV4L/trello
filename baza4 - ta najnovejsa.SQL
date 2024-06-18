/*
Created: 5/7/2024
Modified: 6/12/2024
Model: MySQL 8.0
Database: MySQL 8.0
*/

-- Create tables section -------------------------------------------------

-- Table boards

CREATE TABLE `boards`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `title` Varchar(20),
  `description` Text,
  `date_added` Timestamp NULL,
  `data` Varchar(1000),
  PRIMARY KEY (`id`)
)
;

-- Table permissions

CREATE TABLE `permissions`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `name` Varchar(20),
  PRIMARY KEY (`id`)
)
;

-- Table users

CREATE TABLE `users`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `username` Varchar(40),
  `name` Varchar(40),
  `surname` Varchar(40),
  `email` Varchar(40),
  `pasw` Varchar(1000),
  `user_type_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship17` ON `users` (`user_type_id`)
;

-- Table tasks

CREATE TABLE `tasks`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `name` Char(100),
  `list_id` Int,
  `description` Text,
  `complete` Int(11),
  `date_added` Timestamp NULL,
  `color_id` Int,
  `order` Int,
  `data` Varchar(1000),
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship14` ON `tasks` (`color_id`)
;

CREATE INDEX `IX_Relationship18` ON `tasks` (`list_id`)
;

-- Table tags

CREATE TABLE `tags`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `name` Varchar(20),
  PRIMARY KEY (`id`)
)
;

-- Table lists

CREATE TABLE `lists`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `name` Varchar(20),
  `date_added` Timestamp NULL,
  `board_id` Int,
  `color_id` Int,
  `order` Int,
  `data` Varchar(1000),
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship13` ON `lists` (`board_id`)
;

CREATE INDEX `IX_Relationship15` ON `lists` (`color_id`)
;

-- Table boards_users

CREATE TABLE `boards_users`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `user_id` Int,
  `board_id` Int,
  `permissions_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship1` ON `boards_users` (`user_id`)
;

CREATE INDEX `IX_Relationship4` ON `boards_users` (`board_id`)
;

CREATE INDEX `IX_Relationship16` ON `boards_users` (`permissions_id`)
;

-- Table tasks_users

CREATE TABLE `tasks_users`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `user_id` Int,
  `task_id` Int,
  `deadline` Timestamp NULL,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship5` ON `tasks_users` (`user_id`)
;

CREATE INDEX `IX_Relationship6` ON `tasks_users` (`task_id`)
;

-- Table tags_tasks

CREATE TABLE `tags_tasks`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `tag_id` Int,
  `task_id` Int,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship7` ON `tags_tasks` (`tag_id`)
;

CREATE INDEX `IX_Relationship8` ON `tags_tasks` (`task_id`)
;

-- Table colors

CREATE TABLE `colors`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `color` Varchar(100),
  PRIMARY KEY (`id`)
)
;

-- Table user_types

CREATE TABLE `user_types`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `name` Varchar(20),
  PRIMARY KEY (`id`)
)
;

-- Create foreign keys (relationships) section -------------------------------------------------

ALTER TABLE `boards_users` ADD CONSTRAINT `Relationship1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `boards_users` ADD CONSTRAINT `Relationship4` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `tasks_users` ADD CONSTRAINT `Relationship5` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `tasks_users` ADD CONSTRAINT `Relationship6` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `tags_tasks` ADD CONSTRAINT `Relationship7` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `tags_tasks` ADD CONSTRAINT `Relationship8` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `lists` ADD CONSTRAINT `Relationship13` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `tasks` ADD CONSTRAINT `Relationship14` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `lists` ADD CONSTRAINT `Relationship15` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `boards_users` ADD CONSTRAINT `Relationship16` FOREIGN KEY (`permissions_id`) REFERENCES `permissions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `users` ADD CONSTRAINT `Relationship17` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `tasks` ADD CONSTRAINT `Relationship18` FOREIGN KEY (`list_id`) REFERENCES `lists` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;


