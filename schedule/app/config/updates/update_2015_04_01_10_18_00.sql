
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'services_required', 'backend', 'Label / Services is required.', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Services is required.', 'script');

COMMIT;