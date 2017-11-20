
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- configurator
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `configurator`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `visible` TINYINT DEFAULT 0 NOT NULL,
    `position` INTEGER DEFAULT 0 NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- configurator_i18n
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `configurator_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `fk_configurator_i18n`
        FOREIGN KEY (`id`)
        REFERENCES `configurator` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- configurator_image
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `configurator_image`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `configurator_id` INTEGER NOT NULL,
    `file` VARCHAR(255) NOT NULL,
    `visible` TINYINT DEFAULT 1 NOT NULL,
    `position` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `idx_configurator_image_id` (`configurator_id`),
    CONSTRAINT `fk_configurator_image_id`
        FOREIGN KEY (`configurator_id`)
        REFERENCES `configurator` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- configurator_image_i18n
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `configurator_image_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `fk_configurator_image_i18n_id`
        FOREIGN KEY (`id`)
        REFERENCES `configurator_image` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- configurator_features
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `configurator_features`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `configurator_id` INTEGER,
    `feature_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `FI_conf_configurator_id` (`configurator_id`),
    INDEX `FI_conf_feature_id` (`feature_id`),
    CONSTRAINT `fk_conf_configurator_id`
        FOREIGN KEY (`configurator_id`)
        REFERENCES `configurator` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_conf_feature_id`
        FOREIGN KEY (`feature_id`)
        REFERENCES `feature` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- configurator_version
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `configurator_version`
(
    `id` INTEGER NOT NULL,
    `visible` TINYINT DEFAULT 0 NOT NULL,
    `position` INTEGER DEFAULT 0 NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `configurator_version_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `configurator` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
