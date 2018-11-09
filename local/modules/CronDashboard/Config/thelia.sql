
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

-- ---------------------------------------------------------------------
-- cron_dashboard_process_log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cron_dashboard_process_log`;

CREATE TABLE `cron_dashboard_process_log`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `linux_user` VARCHAR(255),
    `linux_PID` INTEGER,
    `process_name` VARCHAR(255),
    `cpu` VARCHAR(25),
    `mem` VARCHAR(25),
    `vsz` VARCHAR(25),
    `tty` VARCHAR(25),
    `stat` VARCHAR(25),
    `start` VARCHAR(25),
    `time` VARCHAR(25),
    `command` VARCHAR(255),
    `thelia_user_name` VARCHAR(255),
    `thelia_user_id` INTEGER,
    `action_triggered` VARCHAR(25),
    `trigger_time` DATETIME,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
