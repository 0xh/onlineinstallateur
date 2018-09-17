
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- configurator
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `configurator`;

CREATE TABLE `configurator`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `parameters` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- configurator_hook
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `configurator_hook`;

CREATE TABLE `configurator_hook`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `configurator_id` INTEGER,
    `hook_id` INTEGER,
    `hook_code` VARCHAR(255),
    PRIMARY KEY (`id`),
    INDEX `FI_configurator_hook` (`configurator_id`),
    INDEX `FI_configurator_hook_id` (`hook_id`),
    CONSTRAINT `fk_configurator_hook`
        FOREIGN KEY (`configurator_id`)
        REFERENCES `configurator` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_configurator_hook_id`
        FOREIGN KEY (`hook_id`)
        REFERENCES `hook` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- configurator_email
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `configurator_email`;

CREATE TABLE `configurator_email`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `with_search_result` TINYINT DEFAULT 0 NOT NULL,
    `id_category_search` INTEGER DEFAULT 1 NOT NULL,
    `visible_form_contact` TINYINT DEFAULT 1 NOT NULL,
    `required_vorname` TINYINT DEFAULT 1 NOT NULL,
    `visible_vorname` TINYINT DEFAULT 1 NOT NULL,
    `required_nachname` TINYINT DEFAULT 1 NOT NULL,
    `visible_nachname` TINYINT DEFAULT 1 NOT NULL,
    `required_str` TINYINT DEFAULT 1 NOT NULL,
    `visible_str` TINYINT DEFAULT 1 NOT NULL,
    `required_plz` TINYINT DEFAULT 1 NOT NULL,
    `visible_plz` TINYINT DEFAULT 1 NOT NULL,
    `required_ort` TINYINT DEFAULT 1 NOT NULL,
    `visible_ort` TINYINT DEFAULT 1 NOT NULL,
    `required_telefon` TINYINT DEFAULT 1 NOT NULL,
    `visible_telefon` TINYINT DEFAULT 1 NOT NULL,
    `required_email` TINYINT DEFAULT 1 NOT NULL,
    `visible_email` TINYINT DEFAULT 1 NOT NULL,
    `required_terms` TINYINT DEFAULT 1 NOT NULL,
    `visible_terms` TINYINT DEFAULT 1 NOT NULL,
    `required_send` TINYINT DEFAULT 1 NOT NULL,
    `visible_send` TINYINT DEFAULT 1 NOT NULL,
    `send_email` TINYINT DEFAULT 1 NOT NULL,
    `template_email_name_customer` VARCHAR(255),
    `template_email_name_admin` VARCHAR(255),
    `template_redirect_search` VARCHAR(255),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- configurator_elements
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `configurator_elements`;

CREATE TABLE `configurator_elements`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `configurator_id` INTEGER NOT NULL,
    `visible` TINYINT DEFAULT 1 NOT NULL,
    `question` VARCHAR(255),
    `type` VARCHAR(10),
    `parameters` TEXT,
    PRIMARY KEY (`id`,`configurator_id`),
    INDEX `FI_configurator` (`configurator_id`),
    CONSTRAINT `fk_configurator`
        FOREIGN KEY (`configurator_id`)
        REFERENCES `configurator` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
