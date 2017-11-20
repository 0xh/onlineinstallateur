INSERT INTO `hook` 
( `code`, `type`, `by_module`, `activate`, `created_at`, `updated_at`) 
VALUES ( "existing_order_message", 1, 0, 1, now(), now())
ON DUPLICATE KEY UPDATE id = id;
