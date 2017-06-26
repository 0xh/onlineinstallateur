
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- crawler_product_base
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `crawler_product_base`;

CREATE TABLE `crawler_product_base`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `product_id` INTEGER,
    `active` TINYINT DEFAULT 1 NOT NULL,
    `action_required` TINYINT DEFAULT 0 NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`),
    INDEX `FI_crawler_base_product_id` (`product_id`),
    CONSTRAINT `fk_crawler_base_product_id`
        FOREIGN KEY (`product_id`)
        REFERENCES `product` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- crawler_product_listing
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `crawler_product_listing`;

CREATE TABLE `crawler_product_listing`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `product_base_id` INTEGER,
    `hf_position` INTEGER,
    `hf_price` DECIMAL(16,6) DEFAULT 0.000000 NOT NULL,
    `first_position` INTEGER,
    `first_price` DECIMAL(16,6) DEFAULT 0.000000 NOT NULL,
    `platform` VARCHAR(255),
    `link_platform_product_page` VARCHAR(255),
    `link_hf_product` VARCHAR(255),
    `link_first_product` VARCHAR(255),
    `platform_product_id` VARCHAR(255),
    `hf_product_stock` INTEGER DEFAULT 0,
    `hf_product_stock_order` INTEGER DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`),
    INDEX `FI_crawler_listing_base_id` (`product_base_id`),
    CONSTRAINT `fk_crawler_listing_base_id`
        FOREIGN KEY (`product_base_id`)
        REFERENCES `crawler_product_base` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- crawler_product_base_version
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `crawler_product_base_version`;

CREATE TABLE `crawler_product_base_version`
(
    `id` INTEGER NOT NULL,
    `product_id` INTEGER,
    `active` TINYINT DEFAULT 1 NOT NULL,
    `action_required` TINYINT DEFAULT 0 NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_by` VARCHAR(100),
    `product_id_version` INTEGER DEFAULT 0,
    `crawler_product_listing_ids` TEXT,
    `crawler_product_listing_versions` TEXT,
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `crawler_product_base_version_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `crawler_product_base` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- crawler_product_listing_version
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `crawler_product_listing_version`;

CREATE TABLE `crawler_product_listing_version`
(
    `id` INTEGER NOT NULL,
    `product_base_id` INTEGER,
    `hf_position` INTEGER,
    `hf_price` DECIMAL(16,6) DEFAULT 0.000000 NOT NULL,
    `first_position` INTEGER,
    `first_price` DECIMAL(16,6) DEFAULT 0.000000 NOT NULL,
    `platform` VARCHAR(255),
    `link_platform_product_page` VARCHAR(255),
    `link_hf_product` VARCHAR(255),
    `link_first_product` VARCHAR(255),
    `platform_product_id` VARCHAR(255),
    `hf_product_stock` INTEGER DEFAULT 0,
    `hf_product_stock_order` INTEGER DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    `product_base_id_version` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `crawler_product_listing_version_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `crawler_product_listing` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
