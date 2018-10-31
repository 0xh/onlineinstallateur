
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- cron_jobs
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cron_jobs`;

CREATE TABLE `cron_jobs`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `visible` TINYINT NOT NULL,
    `title` VARCHAR(255),
    `command` TEXT,
    `schedule` TEXT,
    `runflag` TINYINT,
    `lastrun` DATETIME,
    `nextrun` DATETIME,
    `position` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
