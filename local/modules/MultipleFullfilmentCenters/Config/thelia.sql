
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- fulfilment_center
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fulfilment_center`;

CREATE TABLE `fulfilment_center`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255),
    `gps_lat` DECIMAL(18,14),
    `gps_long` DECIMAL(18,14),
    `stock_limit` INTEGER,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- fulfilment_center_products
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fulfilment_center_products`;

CREATE TABLE `fulfilment_center_products`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `fulfilment_center_id` INTEGER,
    `product_id` INTEGER,
    `product_stock` INTEGER,
    `incoming_stock` INTEGER,
    `outgoing_stock` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `FI_fulfilment_center_products_fulfilment_center_id` (`fulfilment_center_id`),
    INDEX `FI_fulfilment_center_products_product_id` (`product_id`),
    CONSTRAINT `fk_fulfilment_center_products_fulfilment_center_id`
        FOREIGN KEY (`fulfilment_center_id`)
        REFERENCES `fulfilment_center` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `fk_fulfilment_center_products_product_id`
        FOREIGN KEY (`product_id`)
        REFERENCES `product` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- order_local_pickup
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `order_local_pickup`;

CREATE TABLE `order_local_pickup`
(
    `order_id` INTEGER,
    `cart_id` INTEGER NOT NULL,
    `product_id` INTEGER NOT NULL,
    `fulfilment_center_id` INTEGER NOT NULL,
    `quantity` INTEGER NOT NULL,
    PRIMARY KEY (`cart_id`,`product_id`),
    INDEX `FI_order_local_pickup_order_id` (`order_id`),
    CONSTRAINT `fk_order_local_pickup_order_id`
        FOREIGN KEY (`order_id`)
        REFERENCES `order` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_order_local_pickup_product_id`
        FOREIGN KEY (`product_id`)
        REFERENCES `product` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_order_local_pickup_fulfilment_center_id`
        FOREIGN KEY (`fulfilment_center_id`)
        REFERENCES `fulfilment_center` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;


# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
