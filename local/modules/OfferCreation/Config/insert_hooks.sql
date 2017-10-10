SET FOREIGN_KEY_CHECKS = 0;
INSERT INTO `thelia`.`hook` 
( `code`, `type`, `by_module`, `activate`, `created_at`, `updated_at`) 
VALUES ( "offer.creation.employee-notice",2, 0, 1, now(), now())
ON DUPLICATE KEY UPDATE id = id;

INSERT INTO `thelia`.`hook` 
( `code`, `type`, `by_module`, `activate`, `created_at`, `updated_at`) 
VALUES ( "offer.creation.product-price",2, 0, 1, now(), now())
ON DUPLICATE KEY UPDATE id = id;

INSERT INTO `thelia`.`hook` 
( `code`, `type`, `by_module`, `activate`, `created_at`, `updated_at`) 
VALUES ( "offer.listing.offers",2, 0, 1, now(), now())
ON DUPLICATE KEY UPDATE id = id;
SET FOREIGN_KEY_CHECKS = 1;