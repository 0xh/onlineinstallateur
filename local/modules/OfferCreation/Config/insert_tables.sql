# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS `offer`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `ref` VARCHAR(45),
    `order_id` INTEGER,
    `order_ref` VARCHAR(45),
    `customer_id` INTEGER NOT NULL,
    `employee_id` INTEGER NOT NULL,
    `invoice_order_address_id` INTEGER NOT NULL,
    `delivery_order_address_id` INTEGER NOT NULL,
    `invoice_date` DATETIME,
    `currency_id` INTEGER NOT NULL,
    `currency_rate` FLOAT NOT NULL,
    `transaction_ref` VARCHAR(100) COMMENT 'transaction reference - usually use to identify a transaction with banking modules',
    `delivery_ref` VARCHAR(100) COMMENT 'delivery reference - usually use to identify a delivery progress on a distant delivery tracker website',
    `invoice_ref` VARCHAR(100) COMMENT 'the invoice reference',
    `discount` DECIMAL(16,6) DEFAULT 0.000000,
    `postage` DECIMAL(16,6) DEFAULT 0.000000 NOT NULL,
    `postage_tax` DECIMAL(16,6) DEFAULT 0.000000 NOT NULL,
    `postage_tax_rule_title` VARCHAR(255),
    `payment_module_id` INTEGER NOT NULL,
    `delivery_module_id` INTEGER NOT NULL,
    `status_id` INTEGER NOT NULL,
    `lang_id` INTEGER NOT NULL,
    `cart_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    `note_employee` LONGTEXT,
    `chat_id` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `ref_UNIQUE` (`ref`),
    INDEX `idx_order_currency_id` (`currency_id`),
    INDEX `idx_order_customer_id` (`customer_id`),
    INDEX `idx_order_invoice_order_address_id` (`invoice_order_address_id`),
    INDEX `idx_order_delivery_order_address_id` (`delivery_order_address_id`),
    INDEX `idx_order_status_id` (`status_id`),
    INDEX `fk_order_payment_module_id_idx` (`payment_module_id`),
    INDEX `fk_order_delivery_module_id_idx` (`delivery_module_id`),
    INDEX `fk_order_lang_id_idx` (`lang_id`),
    INDEX `idx_order_cart_fk` (`cart_id`),
    CONSTRAINT `fk_offer_order_id`
        FOREIGN KEY (`order_id`)
        REFERENCES `order` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_offer_order_ref`
        FOREIGN KEY (`order_ref`)
        REFERENCES `order` (`ref`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_offer_currency_id`
        FOREIGN KEY (`currency_id`)
        REFERENCES `currency` (`id`)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT `fk_offer_customer_id`
        FOREIGN KEY (`customer_id`)
        REFERENCES `customer` (`id`)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
	CONSTRAINT `fk_offer_employee_id`
        FOREIGN KEY (`employee_id`)
        REFERENCES `admin` (`id`)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT `fk_offer_invoice_order_address_id`
        FOREIGN KEY (`invoice_order_address_id`)
        REFERENCES `order_address` (`id`)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT `fk_offer_delivery_order_address_id`
        FOREIGN KEY (`delivery_order_address_id`)
        REFERENCES `order_address` (`id`)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT `fk_offer_status_id`
        FOREIGN KEY (`status_id`)
        REFERENCES `order_status` (`id`)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT `fk_offer_payment_module_id`
        FOREIGN KEY (`payment_module_id`)
        REFERENCES `module` (`id`)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT `fk_offer_delivery_module_id`
        FOREIGN KEY (`delivery_module_id`)
        REFERENCES `module` (`id`)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT `fk_offer_lang_id`
        FOREIGN KEY (`lang_id`)
        REFERENCES `lang` (`id`)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT `fk_offer_chat_id`
        FOREIGN KEY (`chat_id`)
        REFERENCES `offer_chat` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';


CREATE TABLE IF NOT EXISTS  `offer_version`
(
    `id` INTEGER NOT NULL,
    `ref` VARCHAR(45),
    `order_id` INTEGER,
    `order_ref` VARCHAR(45),
    `customer_id` INTEGER NOT NULL,
    `employee_id` INTEGER NOT NULL,
    `invoice_order_address_id` INTEGER NOT NULL,
    `delivery_order_address_id` INTEGER NOT NULL,
    `invoice_date` DATETIME,
    `currency_id` INTEGER NOT NULL,
    `currency_rate` FLOAT NOT NULL,
    `transaction_ref` VARCHAR(100) COMMENT 'transaction reference - usually use to identify a transaction with banking modules',
    `delivery_ref` VARCHAR(100) COMMENT 'delivery reference - usually use to identify a delivery progress on a distant delivery tracker website',
    `invoice_ref` VARCHAR(100) COMMENT 'the invoice reference',
    `discount` DECIMAL(16,6) DEFAULT 0.000000,
    `postage` DECIMAL(16,6) DEFAULT 0.000000 NOT NULL,
    `postage_tax` DECIMAL(16,6) DEFAULT 0.000000 NOT NULL,
    `postage_tax_rule_title` VARCHAR(255),
    `payment_module_id` INTEGER NOT NULL,
    `delivery_module_id` INTEGER NOT NULL,
    `status_id` INTEGER NOT NULL,
    `lang_id` INTEGER NOT NULL,
    `cart_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    `note_employee` LONGTEXT,
    `chat_id` INTEGER,
    `customer_id_version` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `offer_version_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `offer` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';


CREATE TABLE IF NOT EXISTS  `offer_chat`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `message` LONGTEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';


CREATE TABLE IF NOT EXISTS `offer_product`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `offer_id` INTEGER NOT NULL,
    `product_ref` VARCHAR(255) NOT NULL,
    `product_sale_elements_ref` VARCHAR(255) NOT NULL,
    `product_sale_elements_id` INTEGER,
    `title` VARCHAR(255),
    `chapo` TEXT,
    `description` LONGTEXT,
    `postscriptum` TEXT,
    `quantity` FLOAT NOT NULL,
    `price` DECIMAL(16,6) DEFAULT 0.000000 NOT NULL,
    `promo_price` DECIMAL(16,6) DEFAULT 0.000000,
    `was_new` TINYINT NOT NULL,
    `was_in_promo` TINYINT NOT NULL,
    `weight` VARCHAR(45),
    `ean_code` VARCHAR(255),
    `tax_rule_title` VARCHAR(255),
    `tax_rule_description` LONGTEXT,
    `parent` INTEGER COMMENT 'not managed yet',
    `virtual` TINYINT DEFAULT 0 NOT NULL,
    `virtual_document` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `idx_offer_product_order_id` (`offer_id`),
    CONSTRAINT `fk_offer_product_order_id`
        FOREIGN KEY (`offer_id`)
        REFERENCES `offer` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';


CREATE TABLE IF NOT EXISTS `offer_product_tax`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `offer_product_id` INTEGER NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` LONGTEXT,
    `amount` DECIMAL(16,6) DEFAULT 0.000000 NOT NULL,
    `promo_amount` DECIMAL(16,6) DEFAULT 0.000000,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `idx_offer_product_tax_offer_product_id` (`offer_product_id`),
    CONSTRAINT `fk_offer_product_tax_offer_product_id`
        FOREIGN KEY (`offer_product_id`)
        REFERENCES `offer_product` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
