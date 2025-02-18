CREATE TABLE `users`
(
    `id`            INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `chat_id`       VARCHAR(255),
    `username`      VARCHAR(255),
    `first_name`    VARCHAR(255),
    `last_name`     VARCHAR(255),
    `language_code` VARCHAR(255),
    `photo_url`     VARCHAR(255),
    `token`         VARCHAR(255),
    `added`         DATETIME          DEFAULT CURRENT_TIMESTAMP,
    `referrer_id`   INT UNSIGNED NULL DEFAULT NULL,
    FOREIGN KEY `users` (`referrer_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `draws`
(
    `id`     INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `title`  TEXT,
    `date`   DATETIME,
    `active` BOOLEAN  DEFAULT 0,
    `added`  DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `coefficients`
(
    `id`                INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `user_id`           INT UNSIGNED,
    `coefficient`       FLOAT,
    `coefficient_admin` FLOAT    DEFAULT 0,
    `updated`           DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `settings`
(
    `id`    INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `key`   VARCHAR(255),
    `value` VARCHAR(255),
    `type`  ENUM ('text', 'number', 'textarea')
);

INSERT INTO `settings` (`key`, `value`, `type`)
VALUES ('coefficient', '1', 'number');

INSERT INTO `settings` (`key`, `value`, `type`)
VALUES ('coefficient_first_level', '0.5', 'text'),
       ('coefficient_second_level', '0.25', 'text');


CREATE TABLE `bot_messages`
(
    `id`         INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `chat_id`    VARCHAR(255),
    `message_id` VARCHAR(255),
    `updated`    DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `channels`
(
    `id`       INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `title`    TEXT,
    `chat_id`  VARCHAR(255),
    `url`      VARCHAR(255),
    `language` VARCHAR(255),
    `updated`  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

ALTER TABLE `channels`
    ADD COLUMN `draw_id` INT UNSIGNED AFTER `language`;

ALTER TABLE `channels`
    ADD CONSTRAINT `fk_draw_id`
        FOREIGN KEY (`draw_id`) REFERENCES `draws` (`id`);

ALTER TABLE `draws`
    ADD COLUMN `description` TEXT AFTER `title`;

ALTER TABLE `draws`
    ADD COLUMN `prize` BIGINT UNSIGNED AFTER `active`;

ALTER TABLE `draws`
    ADD COLUMN `translations` TEXT AFTER `prize`;

ALTER TABLE `users`
    ADD COLUMN `active` BOOLEAN DEFAULT 1 AFTER `token`;