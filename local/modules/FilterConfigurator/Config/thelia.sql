
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- filterconfigurator_configurator
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `filterconfigurator_configurator`;

CREATE TABLE `filterconfigurator_configurator`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `category_id` INTEGER,
    `visible` TINYINT DEFAULT 0 NOT NULL,
    `position` INTEGER DEFAULT 0 NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_filterconfigurator_configurator_category` (`category_id`),
    CONSTRAINT `fk_filterconfigurator_configurator_category`
        FOREIGN KEY (`category_id`)
        REFERENCES `category` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- filterconfigurator_configurator_hook
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `filterconfigurator_configurator_hook`;

CREATE TABLE `filterconfigurator_configurator_hook`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `filter_configurator_id` INTEGER,
    `hook_id` INTEGER,
    `hook_code` VARCHAR(255),
    PRIMARY KEY (`id`),
    INDEX `FI_filter_configurator_hook` (`filter_configurator_id`),
    INDEX `FI_filter_configurator_hook_id` (`hook_id`),
    CONSTRAINT `fk_filter_configurator_hook`
        FOREIGN KEY (`filter_configurator_id`)
        REFERENCES `filterconfigurator_configurator` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_filter_configurator_hook_id`
        FOREIGN KEY (`hook_id`)
        REFERENCES `hook` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- filterconfigurator_configurator_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `filterconfigurator_configurator_i18n`;

CREATE TABLE `filterconfigurator_configurator_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `fk_filterconfigurator_configurator_i18n`
        FOREIGN KEY (`id`)
        REFERENCES `filterconfigurator_configurator` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- filterconfigurator_configurator_image
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `filterconfigurator_configurator_image`;

CREATE TABLE `filterconfigurator_configurator_image`
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
    CONSTRAINT `fk_filterconfigurator_configurator_image_id`
        FOREIGN KEY (`configurator_id`)
        REFERENCES `filterconfigurator_configurator` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- filterconfigurator_configurator_image_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `filterconfigurator_configurator_image_i18n`;

CREATE TABLE `filterconfigurator_configurator_image_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `fk_filterconfigurator_configurator_image_i18n_id`
        FOREIGN KEY (`id`)
        REFERENCES `filterconfigurator_configurator_image` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- filterconfigurator_configurator_features
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `filterconfigurator_configurator_features`;

CREATE TABLE `filterconfigurator_configurator_features`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `configurator_id` INTEGER,
    `feature_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `FI_filterconfigurator_conf_configurator_id` (`configurator_id`),
    INDEX `FI_filterconfigurator_conf_feature_id` (`feature_id`),
    CONSTRAINT `fk_filterconfigurator_conf_configurator_id`
        FOREIGN KEY (`configurator_id`)
        REFERENCES `filterconfigurator_configurator` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_filterconfigurator_conf_feature_id`
        FOREIGN KEY (`feature_id`)
        REFERENCES `feature` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
