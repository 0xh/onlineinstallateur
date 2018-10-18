
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- sepaimporter_brand_mapping
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sepaimporter_brand_mapping`;

CREATE TABLE `sepaimporter_brand_mapping`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `brand_id` INTEGER NOT NULL,
    `source_brand_name` TEXT,
    `source_name` TEXT,
    PRIMARY KEY (`id`),
    INDEX `FI_sepaimporter_brand_id` (`brand_id`),
    CONSTRAINT `fk_sepaimporter_brand_id`
        FOREIGN KEY (`brand_id`)
        REFERENCES `brand` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
