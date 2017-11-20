INSERT INTO `hook` 
( `code`, `type`, `by_module`, `activate`, `created_at`, `updated_at`) 
VALUES ( "product.order-email-fulfilment-center-address", 4, 0, 1, now(), now())
ON DUPLICATE KEY UPDATE id = id;
	
INSERT INTO `hook` 
( `code`, `type`, `by_module`, `activate`, `created_at`, `updated_at`) 
VALUES ( "product.order-pdf-fulfilment-center-address", 3, 0, 1, now(), now())
ON DUPLICATE KEY UPDATE id = id;

INSERT INTO `hook` 
( `code`, `type`, `by_module`, `activate`, `created_at`, `updated_at`) 
VALUES ( "product.order-fulfilment-center-address", 2, 0, 1, now(), now())
ON DUPLICATE KEY UPDATE id = id;

INSERT INTO `hook` 
( `code`, `type`, `by_module`, `activate`, `created_at`, `updated_at`) 
VALUES ( "product.fulfilment-center-address", 1, 0, 1, now(), now())
ON DUPLICATE KEY UPDATE id = id;

INSERT INTO `hook` 
( `code`, `type`, `by_module`, `activate`, `created_at`, `updated_at`) 
VALUES ( "product.fulfilment-center", 1, 0, 1, now(), now())
ON DUPLICATE KEY UPDATE id = id;
