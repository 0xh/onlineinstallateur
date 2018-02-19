
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'lblSelectLayoutTheme', 'backend', 'Label / Select layout & theme', 'script', '2015-06-26 04:32:27');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Select layout & theme', 'script');

INSERT INTO `fields` VALUES (NULL, 'lblSelectTheme', 'backend', 'Label / Select theme', 'script', '2015-06-26 04:36:03');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Select theme', 'script');

INSERT INTO `fields` VALUES (NULL, 'lblSelectLayout', 'backend', 'Label / Select layout', 'script', '2015-06-26 04:37:00');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Select layout', 'script');

COMMIT;