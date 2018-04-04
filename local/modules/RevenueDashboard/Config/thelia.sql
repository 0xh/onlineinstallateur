
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- brand_matching_partners
-- ---------------------------------------------------------------------

CREATE TABLE if not exists `brand_matching_partners`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `brand_intern` INTEGER,
    `brand_extern` VARCHAR(45),
    `partner_id` INTEGER,
    `brand_code` VARCHAR(45),
    PRIMARY KEY (`id`),
    INDEX `FI_brand_intern` (`brand_intern`),
    CONSTRAINT `fk_brand_intern`
        FOREIGN KEY (`brand_intern`)
        REFERENCES `brand` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
