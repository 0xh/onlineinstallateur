
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- product_amazon
-- ---------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `product_amazon`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `product_id` INTEGER,
    `ref` VARCHAR(255),
    `ean_code` VARCHAR(255),
    `ASIN` VARCHAR(255),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- amazon_orders_products
-- ---------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `amazon_orders_products`
(
    `amazon_order_id` VARCHAR(45) NOT NULL,
    `product_id` INTEGER,
    `ean_code` VARCHAR(255),
    `ASIN` VARCHAR(255),
    PRIMARY KEY (`amazon_order_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- amazon_orders
-- ---------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `amazon_orders`
(
    `id` VARCHAR(45) NOT NULL,
    `seller_order_id` VARCHAR(45),
    `purchase_date` DATETIME,
    `last_update_date` DATETIME,
    `order_status` VARCHAR(45),
    `fulfillment_channel` VARCHAR(45),
    `sales_channel` VARCHAR(45),
    `order_channel` VARCHAR(45),
    `ship_service_level` VARCHAR(45),
    `order_total_currency_code` VARCHAR(45),
    `order_total_amount` DECIMAL(16,2) DEFAULT 0.00 NOT NULL,
    `number_of_items_shipped` FLOAT,
    `number_of_items_unshipped` FLOAT,
    `payment_execution_detail_currency_code` VARCHAR(45),
    `payment_execution_detail_total_amount` DECIMAL(16,2) DEFAULT 0.00 NOT NULL,
    `payment_execution_detail_payment_method` VARCHAR(45),
    `payment_method` VARCHAR(45),
    `payment_method_detail` VARCHAR(45),
    `marketplace_id` VARCHAR(45),
    `buyer_county` VARCHAR(45),
    `buyer_tax_info_company` VARCHAR(45),
    `buyer_tax_info_taxing_region` VARCHAR(45),
    `buyer_tax_info_tax_name` VARCHAR(45),
    `buyer_tax_info_tax_value` VARCHAR(45),
    `shipment_service_level_category` VARCHAR(45),
    `shipped_by_amazon_tfm` TINYINT DEFAULT 0 NOT NULL,
    `tfm_shipment_status` VARCHAR(45),
    `cba_displayable_shipping_label` VARCHAR(45),
    `order_type` VARCHAR(45),
    `earliest_ship_date` DATETIME,
    `latest_ship_date` DATETIME,
    `earliest_delivery_date` DATETIME,
    `latest_delivery_date` DATETIME,
    `is_business_order` TINYINT DEFAULT 0 NOT NULL,
    `purchase_order_number` VARCHAR(45),
    `is_prime` TINYINT DEFAULT 0 NOT NULL,
    `is_premium_order` TINYINT DEFAULT 0 NOT NULL,
    `replaced_order_id` VARCHAR(45),
    `is_replacement_order` TINYINT DEFAULT 0 NOT NULL,
    `order_address_id` INTEGER,
    `customer_id` INTEGER,
    `order_id` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`),
    INDEX `fk_order_address_id` (`order_address_id`),
    INDEX `fk_customer_id` (`customer_id`),
    INDEX `fk_order_id` (`order_id`),
    CONSTRAINT `fk_customer_id`
        FOREIGN KEY (`customer_id`)
        REFERENCES `customer` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_order_address_id`
        FOREIGN KEY (`order_address_id`)
        REFERENCES `order_address` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_order_id`
        FOREIGN KEY (`order_id`)
        REFERENCES `order` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- amazon_orders_version
-- ---------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `amazon_orders_version`
(
    `id` VARCHAR(45) NOT NULL,
    `seller_order_id` VARCHAR(45),
    `purchase_date` DATETIME,
    `last_update_date` DATETIME,
    `order_status` VARCHAR(45),
    `fulfillment_channel` VARCHAR(45),
    `sales_channel` VARCHAR(45),
    `order_channel` VARCHAR(45),
    `ship_service_level` VARCHAR(45),
    `order_total_currency_code` VARCHAR(45),
    `order_total_amount` DECIMAL(16,2) DEFAULT 0.00 NOT NULL,
    `number_of_items_shipped` FLOAT,
    `number_of_items_unshipped` FLOAT,
    `payment_execution_detail_currency_code` VARCHAR(45),
    `payment_execution_detail_total_amount` DECIMAL(16,2) DEFAULT 0.00 NOT NULL,
    `payment_execution_detail_payment_method` VARCHAR(45),
    `payment_method` VARCHAR(45),
    `payment_method_detail` VARCHAR(45),
    `marketplace_id` VARCHAR(45),
    `buyer_county` VARCHAR(45),
    `buyer_tax_info_company` VARCHAR(45),
    `buyer_tax_info_taxing_region` VARCHAR(45),
    `buyer_tax_info_tax_name` VARCHAR(45),
    `buyer_tax_info_tax_value` VARCHAR(45),
    `shipment_service_level_category` VARCHAR(45),
    `shipped_by_amazon_tfm` TINYINT DEFAULT 0 NOT NULL,
    `tfm_shipment_status` VARCHAR(45),
    `cba_displayable_shipping_label` VARCHAR(45),
    `order_type` VARCHAR(45),
    `earliest_ship_date` DATETIME,
    `latest_ship_date` DATETIME,
    `earliest_delivery_date` DATETIME,
    `latest_delivery_date` DATETIME,
    `is_business_order` TINYINT DEFAULT 0 NOT NULL,
    `purchase_order_number` VARCHAR(45),
    `is_prime` TINYINT DEFAULT 0 NOT NULL,
    `is_premium_order` TINYINT DEFAULT 0 NOT NULL,
    `replaced_order_id` VARCHAR(45),
    `is_replacement_order` TINYINT DEFAULT 0 NOT NULL,
    `order_address_id` INTEGER,
    `customer_id` INTEGER,
    `order_id` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    `customer_id_version` INTEGER DEFAULT 0,
    `order_id_version` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `amazon_orders_version_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `amazon_orders` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
