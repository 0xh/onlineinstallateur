
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'uuid_used', 'backend', 'Label / Unique ID was used.', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Unique ID was used.', 'script');

COMMIT;