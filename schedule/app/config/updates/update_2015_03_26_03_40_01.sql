
START TRANSACTION;

ALTER TABLE `users` ADD `is_notify` enum('T','F') NOT NULL DEFAULT 'T' AFTER `status`;

COMMIT;