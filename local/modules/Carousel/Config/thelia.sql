
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- carousel
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `carousel`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `carousel_id` INTEGER NOT NULL,
    `visible` TINYINT DEFAULT 1 NOT NULL,
    `file` VARCHAR(255),
    `position` INTEGER,
    `url` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`),
    INDEX `carousel_I_1` (`carousel_id`),
    CONSTRAINT `fk_carousel_name_id`
        FOREIGN KEY (`carousel_id`)
        REFERENCES `carousel_name` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- carousel_hook
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `carousel_hook`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `carousel_id` INTEGER,
    `hook_id` INTEGER,
    `hook_code` VARCHAR(255),
    PRIMARY KEY (`id`),
    INDEX `FI_carousel_id` (`carousel_id`),
    INDEX `FI_carousel_hook_id` (`hook_id`),
    CONSTRAINT `fk_carousel_id`
        FOREIGN KEY (`carousel_id`)
        REFERENCES `carousel_name` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_carousel_hook_id`
        FOREIGN KEY (`hook_id`)
        REFERENCES `hook` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- carousel_name
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `carousel_name`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `template` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- carousel_i18n
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `carousel_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `alt` VARCHAR(255),
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `carousel_i18n_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `carousel` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- carousel_version
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `carousel_version`
(
    `id` INTEGER NOT NULL,
    `carousel_id` INTEGER NOT NULL,
    `visible` TINYINT DEFAULT 1 NOT NULL,
    `file` VARCHAR(255),
    `position` INTEGER,
    `url` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    `carousel_id_version` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `carousel_version_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `carousel` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- carousel_name_version
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `carousel_name_version`
(
    `id` INTEGER NOT NULL,
    `name` VARCHAR(255),
    `template` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    `carousel_ids` TEXT,
    `carousel_versions` TEXT,
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `carousel_name_version_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `carousel_name` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
