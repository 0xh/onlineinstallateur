INSERT INTO `hook` 
( `code`, `type`, `by_module`, `activate`, `created_at`, `updated_at`) 
VALUES ( "configurator.description", 1, 0, 1, now(), now())
ON DUPLICATE KEY UPDATE id = id;
	
INSERT INTO `hook` 
( `code`, `type`, `by_module`, `activate`, `created_at`, `updated_at`) 
VALUES ( "configurator.filters", 1, 0, 1, now(), now())
ON DUPLICATE KEY UPDATE id = id;