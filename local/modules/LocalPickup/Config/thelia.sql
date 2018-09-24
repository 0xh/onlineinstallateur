
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- local_pickup_shipping
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `local_pickup_shipping`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `price` DOUBLE NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- local_pickup
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `local_pickup`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `address` VARCHAR(255),
    `gps_lat` DECIMAL(18,14),
    `gps_long` DECIMAL(18,14),
    `hint` LONGTEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- order_local_pickup_address
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `order_local_pickup_address`
(
    `order_id` INTEGER,
    `cart_id` INTEGER NOT NULL,
    `local_pickup_id` INTEGER NOT NULL,
    PRIMARY KEY (`cart_id`),
    INDEX `FI_order_local_pickup_address_local_pickup_id` (`local_pickup_id`),
    INDEX `FI_order_local_pickup_address_order_id` (`order_id`),
    CONSTRAINT `fk_order_local_pickup_address_local_pickup_id`
        FOREIGN KEY (`local_pickup_id`)
        REFERENCES `local_pickup` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_order_local_pickup_address_order_id`
        FOREIGN KEY (`order_id`)
        REFERENCES `order` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
