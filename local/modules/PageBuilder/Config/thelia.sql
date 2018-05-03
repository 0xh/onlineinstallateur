
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- page_builder
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `page_builder`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `visible` TINYINT NOT NULL,
    `position` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- page_builder_product
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `page_builder_product`
(
    `page_builder_id` INTEGER NOT NULL,
    `product_id` INTEGER NOT NULL,
    `position` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`page_builder_id`,`product_id`),
    INDEX `FI_page_builder_product_product_id` (`product_id`),
    CONSTRAINT `fk_page_builder_product_product_id`
        FOREIGN KEY (`product_id`)
        REFERENCES `product` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_page_builder_product_page_builder_id`
        FOREIGN KEY (`page_builder_id`)
        REFERENCES `page_builder` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- page_builder_content
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `page_builder_content`
(
    `page_builder_id` INTEGER NOT NULL,
    `content_id` INTEGER NOT NULL,
    `position` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`page_builder_id`,`content_id`),
    INDEX `FI_page_builder_content_content_id` (`content_id`),
    CONSTRAINT `fk_page_builder_content_content_id`
        FOREIGN KEY (`content_id`)
        REFERENCES `content` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_page_builder_content_page_builder_id`
        FOREIGN KEY (`page_builder_id`)
        REFERENCES `page_builder` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- page_builder_image
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `page_builder_image`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `page_builder_id` INTEGER NOT NULL,
    `file` VARCHAR(255) NOT NULL,
    `visible` TINYINT DEFAULT 1 NOT NULL,
    `position` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_page_builder_image_page_builder_id` (`page_builder_id`),
    CONSTRAINT `fk_page_builder_image_page_builder_id`
        FOREIGN KEY (`page_builder_id`)
        REFERENCES `page_builder` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- page_builder_i18n
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `page_builder_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `title` VARCHAR(255),
    `header` VARCHAR(255),
    `footer` VARCHAR(255),
    `chapo` VARCHAR(255),
    `postscriptum` VARCHAR(255),
    `meta_title` VARCHAR(255),
    `meta_description` TEXT,
    `meta_keywords` TEXT,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `page_builder_i18n_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `page_builder` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- page_builder_image_i18n
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `page_builder_image_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `page_builder_image_i18n_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `page_builder_image` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
