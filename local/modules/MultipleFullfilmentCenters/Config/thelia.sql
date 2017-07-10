
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

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
    CONSTRAINT `fk_fulfilment_center_id`
        FOREIGN KEY (`fulfilment_center_id`)
        REFERENCES `fulfilment_center` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
     CONSTRAINT `fk_center_product_id`
        FOREIGN KEY (`product_id`)
        REFERENCES `product` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- fulfilment_center
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `fulfilment_center`;

CREATE TABLE `fulfilment_center`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `address` VARCHAR(255),
    `gps_lat` decimal(18,14),
    `gps_long` decimal(18,14),
    `stock_limit` INTEGER,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;


# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
