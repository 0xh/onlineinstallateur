
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'buttons_ARRAY_delete', 'arrays', 'buttons_ARRAY_delete', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Delete', 'script');

INSERT INTO `fields` VALUES (NULL, 'buttons_ARRAY_send', 'arrays', 'buttons_ARRAY_send', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Send', 'script');

INSERT INTO `fields` VALUES (NULL, 'buttons_ARRAY_export', 'arrays', 'buttons_ARRAY_export', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Export', 'script');

INSERT INTO `fields` VALUES (NULL, 'buttons_ARRAY_yes', 'arrays', 'buttons_ARRAY_yes', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Yes', 'script');

INSERT INTO `fields` VALUES (NULL, 'buttons_ARRAY_no', 'arrays', 'buttons_ARRAY_no', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'No', 'script');

INSERT INTO `fields` VALUES (NULL, 'buttons_ARRAY_close', 'arrays', 'buttons_ARRAY_close', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Close', 'script');

COMMIT;