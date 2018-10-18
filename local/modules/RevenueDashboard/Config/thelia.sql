
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- wholesale_partner_brand_matching
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `wholesale_partner_brand_matching`;

CREATE TABLE `wholesale_partner_brand_matching`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `brand_intern` INTEGER,
    `brand_extern` VARCHAR(45),
    `partner_id` INTEGER,
    `brand_code` VARCHAR(45),
    PRIMARY KEY (`id`),
    INDEX `FI_wholesale_partner_brand_matching_brand_id` (`brand_intern`),
    CONSTRAINT `fk_wholesale_partner_brand_matching_brand_id`
        FOREIGN KEY (`brand_intern`)
        REFERENCES `brand` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- wholesale_partner_category_matching
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `wholesale_partner_category_matching`;

CREATE TABLE `wholesale_partner_category_matching`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `category_intern_id` INTEGER,
    `category_intern_name` VARCHAR(45),
    `category_extern_id` VARCHAR(45),
    `category_extern_name` VARCHAR(45),
    `partner_id` INTEGER,
    `category_id` VARCHAR(45),
    PRIMARY KEY (`id`),
    INDEX `FI_wholesale_partner_category_matching_category_id` (`category_intern_id`),
    CONSTRAINT `fk_wholesale_partner_category_matching_category_id`
        FOREIGN KEY (`category_intern_id`)
        REFERENCES `category` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- wholesale_partner
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `wholesale_partner`;

CREATE TABLE `wholesale_partner`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `description` VARCHAR(255),
    `comment` VARCHAR(255),
    `priority` INTEGER,
    `address` VARCHAR(255),
    `deposit_address` VARCHAR(255),
    `contact_person` VARCHAR(255),
    `delivery_types` VARCHAR(255),
    `return_policy` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- wholesale_partner_contact_person
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `wholesale_partner_contact_person`;

CREATE TABLE `wholesale_partner_contact_person`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` INTEGER NOT NULL,
    `firstname` VARCHAR(255),
    `lastname` VARCHAR(255),
    `telefon` VARCHAR(255),
    `email` VARCHAR(255),
    `profile_website` VARCHAR(255),
    `position` VARCHAR(255),
    `department` VARCHAR(255),
    `comment` VARCHAR(255),
    `version` INTEGER DEFAULT 0,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`),
    INDEX `FI_wholesale_customer_title_id` (`title`),
    CONSTRAINT `fk_wholesale_customer_title_id`
        FOREIGN KEY (`title`)
        REFERENCES `customer_title` (`id`)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- wholesale_partner_product
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `wholesale_partner_product`;

CREATE TABLE `wholesale_partner_product`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `partner_id` INTEGER,
    `product_id` INTEGER,
    `partner_product_ref` VARCHAR(255),
    `price` DECIMAL(16,2) DEFAULT 0.00,
    `package_size` INTEGER,
    `delivery_cost` DECIMAL(16,2) DEFAULT 0.00,
    `discount` DECIMAL(16,2) DEFAULT 0.00,
    `discount_description` VARCHAR(255),
    `profile_website` VARCHAR(255),
    `position` VARCHAR(255),
    `department` VARCHAR(255),
    `comment` VARCHAR(255),
    `valid_until` DATETIME,
    `version` INTEGER DEFAULT 0,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`),
    INDEX `FI_wholesale_partner_product_product_id` (`product_id`),
    CONSTRAINT `fk_wholesale_partner_product_product_id`
        FOREIGN KEY (`product_id`)
        REFERENCES `product` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- order_product_revenue
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `order_product_revenue`;

CREATE TABLE `order_product_revenue`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `order_id` INTEGER,
    `product_ref` VARCHAR(255),
    `price` DECIMAL(16,2) DEFAULT 0.00,
    `purchase_price` DECIMAL(16,2) DEFAULT 0.00,
    `partner_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `FI_order_product_revenue_order_id` (`order_id`),
    INDEX `FI_order_product_revenue_product_ref` (`product_ref`),
    CONSTRAINT `fk_order_product_revenue_order_id`
        FOREIGN KEY (`order_id`)
        REFERENCES `order` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_order_product_revenue_product_ref`
        FOREIGN KEY (`product_ref`)
        REFERENCES `product` (`ref`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- order_revenue
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `order_revenue`;

CREATE TABLE `order_revenue`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `order_id` INTEGER,
    `delivery_cost` DECIMAL(16,2) DEFAULT 0.00,
    `delivery_method` VARCHAR(255),
    `partner_id` INTEGER,
    `payment_processor_cost` DECIMAL(16,2) DEFAULT 0.00,
    `price` DECIMAL(16,2) DEFAULT 0.00,
    `purchase_price` DECIMAL(16,2) DEFAULT 0.00,
    `total_purchase_price` DECIMAL(16,2) DEFAULT 0.00,
    `revenue` DECIMAL(16,2) DEFAULT 0.00,
    `comment` VARCHAR(255),
    PRIMARY KEY (`id`),
    INDEX `FI_order_revenue_order_id` (`order_id`),
    CONSTRAINT `fk_order_revenue_order_id`
        FOREIGN KEY (`order_id`)
        REFERENCES `order` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- wholesale_partner_version
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `wholesale_partner_version`;

CREATE TABLE `wholesale_partner_version`
(
    `id` INTEGER NOT NULL,
    `name` VARCHAR(255),
    `description` VARCHAR(255),
    `comment` VARCHAR(255),
    `priority` INTEGER,
    `address` VARCHAR(255),
    `deposit_address` VARCHAR(255),
    `contact_person` VARCHAR(255),
    `delivery_types` VARCHAR(255),
    `return_policy` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `wholesale_partner_version_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `wholesale_partner` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- wholesale_partner_contact_person_version
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `wholesale_partner_contact_person_version`;

CREATE TABLE `wholesale_partner_contact_person_version`
(
    `id` INTEGER NOT NULL,
    `title` INTEGER NOT NULL,
    `firstname` VARCHAR(255),
    `lastname` VARCHAR(255),
    `telefon` VARCHAR(255),
    `email` VARCHAR(255),
    `profile_website` VARCHAR(255),
    `position` VARCHAR(255),
    `department` VARCHAR(255),
    `comment` VARCHAR(255),
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `wholesale_partner_contact_person_version_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `wholesale_partner_contact_person` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- wholesale_partner_product_version
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `wholesale_partner_product_version`;

CREATE TABLE `wholesale_partner_product_version`
(
    `id` INTEGER NOT NULL,
    `partner_id` INTEGER,
    `product_id` INTEGER,
    `partner_product_ref` VARCHAR(255),
    `price` DECIMAL(16,2) DEFAULT 0.00,
    `package_size` INTEGER,
    `delivery_cost` DECIMAL(16,2) DEFAULT 0.00,
    `discount` DECIMAL(16,2) DEFAULT 0.00,
    `discount_description` VARCHAR(255),
    `profile_website` VARCHAR(255),
    `position` VARCHAR(255),
    `department` VARCHAR(255),
    `comment` VARCHAR(255),
    `valid_until` DATETIME,
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_by` VARCHAR(100),
    `product_id_version` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `wholesale_partner_product_version_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `wholesale_partner_product` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
