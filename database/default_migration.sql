-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'account'
--
-- ---

DROP TABLE IF EXISTS `account`;

CREATE TABLE account (
                         `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT DEFAULT NULL,
                         `id_owner` INTEGER NOT NULL,
                         `updated_at` TIMESTAMP NULL DEFAULT NULL,
                         `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                         FOREIGN KEY (id_owner) REFERENCES `user` (`id`)
);

-- ---
-- Table 'user'
--
-- ---

DROP TABLE IF EXISTS `user`;

CREATE TABLE "user" (
                        "id"	INTEGER NOT NULL,
                        "name"	VARCHAR(255) NOT NULL,
                        "mail"	VARCHAR(255) DEFAULT NULL,
                        "id_role"	INTEGER NOT NULL DEFAULT NULL,
                        "admin"	bit NOT NULL DEFAULT 0,
                        "id_account"	INTEGER DEFAULT NULL,
                        "updated_at"	TIMESTAMP DEFAULT NULL,
                        "created_at"	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY("id_account") REFERENCES "account"("id"),
                        FOREIGN KEY("id_role") REFERENCES "role"("id"),
                        PRIMARY KEY("id" AUTOINCREMENT)
);

-- ---
-- Table 'account_movement'
--
-- ---

DROP TABLE IF EXISTS `account_movement`;

CREATE TABLE `account_movement` (
                                    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT DEFAULT NULL,
                                    `id_account` INTEGER NOT NULL DEFAULT NULL,
                                    `amount` INTEGER NOT NULL,
                                    `is_deposit` bit NOT NULL DEFAULT 1,
                                    `comment` VARCHAR(255) NULL DEFAULT NULL,
                                    `updated_at` TIMESTAMP NULL DEFAULT NULL,
                                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                    FOREIGN KEY (id_account) REFERENCES `account` (`id`)
);

-- ---
-- Table 'role'
--
-- ---

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
                        `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT DEFAULT NULL,
                        `name` VARCHAR(255) NOT NULL,
                        `updated_at` TIMESTAMP NULL DEFAULT NULL,
                        `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

);

-- ---
-- Table 'drink_type'
--
-- ---

DROP TABLE IF EXISTS `drink_type`;

CREATE TABLE `drink_type` (
                              `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                              `name` VARCHAR(255) NOT NULL,
                              `price` INTEGER NOT NULL,
                              `updated_at` TIMESTAMP NULL DEFAULT NULL,
                              `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

);

-- ---
-- Table 'beverage'
--
-- ---

DROP TABLE IF EXISTS `beverage`;

CREATE TABLE `beverage` (
                            `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                            `id_drink_type` INTEGER NOT NULL,
                            `name` VARCHAR(255) NOT NULL,
                            `size` SMALLINT NOT NULL DEFAULT 0, -- 'drink size in milliliters',
                            `calories` INTEGER NOT NULL DEFAULT 0,
                            `alcohol` SMALLINT NOT NULL DEFAULT 0, -- '%vol for alcohol',
                            `updated_at` TIMESTAMP NULL DEFAULT NULL,
                            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                            FOREIGN KEY (id_drink_type) REFERENCES `drink_type` (`id`)
);

-- ---
-- Table 'beverage_movement'
--
-- ---

DROP TABLE IF EXISTS `beverage_movement`;

CREATE TABLE `beverage_movement` (
                                     `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                                     `id_user` INTEGER NOT NULL,
                                     `id_beverage` INTEGER NOT NULL,
                                     `quantity` TINYINT NOT NULL DEFAULT 1,
                                     `updated_at` TIMESTAMP NULL DEFAULT NULL,
                                     `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                                     FOREIGN KEY (id_user) REFERENCES `user` (`id`),
                                     FOREIGN KEY (id_beverage) REFERENCES `beverage` (`id`)
);

-- ---
-- Table 'distributor'
--
-- ---

DROP TABLE IF EXISTS `distributor`;

CREATE TABLE `distributor` (
                               `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                               `name` VARCHAR(255) NOT NULL,
                               `phone` VARCHAR(255) NOT NULL,
                               `mail` VARCHAR(255) NULL,
                               `availability_times` MEDIUMTEXT NULL DEFAULT NULL,
                               `delivery_times` MEDIUMTEXT NULL DEFAULT NULL,
                               `updated_at` TIMESTAMP NULL DEFAULT NULL,
                               `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

);

-- ---
-- Table 'warehouse_payment'
--
-- ---

DROP TABLE IF EXISTS `warehouse_payment`;

CREATE TABLE `warehouse_payment` (
                                     `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                                     `id_distributor` INTEGER NOT NULL,
                                     `id_user` INTEGER NOT NULL,
                                     `filename` VARCHAR(255) NULL DEFAULT NULL,
                                     `price` INTEGER NOT NULL,
                                     `is_paid` bit NOT NULL DEFAULT 0,
                                     `is_deposit` bit NOT NULL DEFAULT 0,
                                     `comment` VARCHAR(255) NULL DEFAULT NULL,
                                     `updated_at` TIMESTAMP NULL DEFAULT NULL,
                                     `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                     FOREIGN KEY (id_distributor) REFERENCES `distributor` (`id`),
                                     FOREIGN KEY (id_user) REFERENCES `user` (`id`)
);

-- ---
-- Table 'warehouse_movement'
--
-- ---

DROP TABLE IF EXISTS `warehouse_movement`;

CREATE TABLE `warehouse_movement` (
                                      `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                                      `id_user` INTEGER NOT NULL,
                                      `id_warehouse_payment` INTEGER NOT NULL,
                                      `id_beverage` INTEGER NOT NULL,
                                      `quantity` SMALLINT NOT NULL,
                                      `is_deposit` bit NOT NULL DEFAULT 1,
                                      `price` INTEGER NULL DEFAULT NULL,
                                      `comment` VARCHAR(255) NULL DEFAULT NULL,
                                      `updated_at` TIMESTAMP NULL DEFAULT NULL,
                                      `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                      FOREIGN KEY (id_user) REFERENCES `user` (`id`),
                                      FOREIGN KEY (id_warehouse_payment) REFERENCES `warehouse_payment` (`id`),
                                      FOREIGN KEY (id_beverage) REFERENCES `beverage` (`id`)
);

-- ---
-- Foreign Keys
-- ---

-- ---
-- Table Properties
-- ---

-- ALTER TABLE `account` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `user` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `account_movement` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `role` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `drink_type` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `beverage` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `beverage_movement` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `distributor` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `warehouse_payment` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `warehouse_movement` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---

-- INSERT INTO `account` (`id`,`id_owner`,`updated_at`,`created_at`) VALUES
-- ('','','','');
-- INSERT INTO `user` (`id`,`name`,`mail`,`id_role`,`admin`,`id_owner`,`updated_at`,`created_at`) VALUES
-- ('','','','','','','','');
-- INSERT INTO `account_movement` (`id`,`id_account`,`amount`,`is_deposit`,`comment`,`updated_at`,`created_at`) VALUES
-- ('','','','','','','');
-- INSERT INTO `role` (`id`,`name`,`updated_at`,`created_at`) VALUES
-- ('','','','');
-- INSERT INTO `drink_type` (`id`,`name`,`price`,`updated_at`,`created_at`) VALUES
-- ('','','','','');
-- INSERT INTO `beverage` (`id`,`id_drink_type`,`name`,`size`,`calories`,`alcohol`,`updated_at`,`created_at`) VALUES
-- ('','','','','','','','');
-- INSERT INTO `beverage_movement` (`id`,`id_user`,`id_beverage`,`quantity`,`updated_at`,`created_at`) VALUES
-- ('','','','','','');
-- INSERT INTO `distributor` (`id`,`name`,`phone`,`mail`,`availability_times`,`delivery_times`,`updated_at`,`created_at`) VALUES
-- ('','','','','','','','');
-- INSERT INTO `warehouse_payment` (`id`,`id_distributor`,`id_user`,`filename`,`price`,`is_paid`,`is_deposit`,`comment`,`updated_at`,`created_at`) VALUES
-- ('','','','','','','','','','');
-- INSERT INTO `warehouse_movement` (`id`,`id_user`,`id_warehouse_payment`,`id_beverage`,`quantity`,`is_deposit`,`price`,`comment`,`updated_at`,`created_at`) VALUES
-- ('','','','','','','','','','');