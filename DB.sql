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
    FOREIGN KEY `users` (`referrer_id`) REFERENCES `users` (`id`) ON UPDATE SET NULL ON DELETE SET NULL
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
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
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
        FOREIGN KEY (`draw_id`) REFERENCES `draws` (`id`) ON UPDATE SET NULL ON DELETE SET NULL;

ALTER TABLE `draws`
    ADD COLUMN `description` TEXT AFTER `title`;

ALTER TABLE `draws`
    ADD COLUMN `prize` BIGINT UNSIGNED AFTER `active`;

ALTER TABLE `users`
    ADD COLUMN `active` BOOLEAN DEFAULT 1 AFTER `token`;

CREATE TABLE `mailing`
(
    `id`        INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `users`     VARCHAR(255),
    `language`  VARCHAR(255),
    `text`      TEXT,
    `image`     VARCHAR(255),
    `added`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `start`     DATETIME,
    `completed` DATETIME,
    `min_id`    INT UNSIGNED DEFAULT 0
);

ALTER TABLE `draws`
    MODIFY COLUMN `prize` FLOAT;

ALTER TABLE `draws`
    ADD COLUMN `hash` VARCHAR(255) AFTER `active`;

ALTER TABLE `draws`
    ADD COLUMN `winners` INT UNSIGNED AFTER `prize`;

ALTER TABLE `draws`
    ADD COLUMN `status` ENUM ('IN PROGRESS', 'DETERMINING WINNERS', 'COMPLETED', 'PAYOUT', 'CANCELED')
        DEFAULT 'IN PROGRESS' AFTER `winners`;

ALTER TABLE `draws`
    ADD COLUMN `updated` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `added`;

ALTER TABLE `users`
    ADD INDEX (`token`);
ALTER TABLE `draws`
    ADD INDEX (`hash`);

CREATE TABLE `winners`
(
    `id`       INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `draw_id`  INT UNSIGNED,
    `user_id`  INT UNSIGNED,
    `prize`    FLOAT    DEFAULT 0,
    `paid_out` BOOLEAN  DEFAULT 0,
    `added`    DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated`  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`draw_id`) REFERENCES `draws` (`id`) ON UPDATE SET NULL ON DELETE SET NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE SET NULL ON DELETE SET NULL
);

INSERT INTO `settings` (`key`, value, type)
VALUES ('percentage_referrer', 50, 'number');

ALTER TABLE `winners`
    ADD COLUMN `prize_referrer` FLOAT DEFAULT 0 AFTER `prize`;
ALTER TABLE `winners`
    ADD COLUMN `coefficient` FLOAT DEFAULT 0 AFTER `prize_referrer`;
ALTER TABLE `winners`
    ADD COLUMN `percentage_referrer` INT UNSIGNED DEFAULT 0 AFTER `coefficient`;

CREATE TABLE `participants`
(
    `id`      INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT UNSIGNED,
    `draw_id` INT UNSIGNED,
    `added`   DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE SET NULL ON DELETE SET NULL,
    FOREIGN KEY (`draw_id`) REFERENCES `draws` (`id`) ON UPDATE SET NULL ON DELETE SET NULL,
    INDEX (`user_id`),
    INDEX (`draw_id`)
);

ALTER TABLE `channels`
    ADD COLUMN `type` ENUM ('channel', 'group') AFTER `draw_id`;

CREATE TABLE `wallets`
(
    `id`      INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `json`    BLOB,
    `address` TEXT,
    `updated` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `added`   DATETIME DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE `wallets`
    ADD COLUMN `user_id` INT UNSIGNED REFERENCES `users` (`id`) ON UPDATE SET NULL ON DELETE SET NULL AFTER `id`;

ALTER TABLE `draws`
    ADD COLUMN `conditions` TEXT AFTER `description`;

ALTER TABLE `draws`
    ADD COLUMN `sponsor_title` TEXT AFTER `conditions`;

ALTER TABLE `draws`
    ADD COLUMN `sponsor_url` TEXT AFTER `sponsor_title`;

CREATE TABLE `airdrops`
(
    `id`    INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `title` TEXT
);