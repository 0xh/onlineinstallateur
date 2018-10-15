INSERT INTO `hook` 
( `code`, `type`, `by_module`, `activate`, `created_at`, `updated_at`) 
VALUES ( "selection-wish-list.wish-button", 1, 0, 1, now(), now())
ON DUPLICATE KEY UPDATE id = id;

INSERT INTO `hook` 
( `code`, `type`, `by_module`, `activate`, `created_at`, `updated_at`) 
VALUES ( "selection-wish-list-selection.wish-button", 1, 0, 1, now(), now())
ON DUPLICATE KEY UPDATE id = id;
