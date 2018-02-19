
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'positive_number', 'backend', 'Label / Please enter positive number', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Please enter positive number', 'script');

COMMIT;