
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- order_credit
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `order_credit`;

CREATE TABLE `order_credit`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `order_credit_id` INTEGER,
    `order_credit_ref` VARCHAR(45),
    `order_id` INTEGER,
    `order_ref` VARCHAR(45),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
