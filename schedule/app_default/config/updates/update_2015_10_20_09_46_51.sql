
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'front_browse_services', 'frontend', 'Label / Browse Services', 'script', '2015-10-20 03:55:03');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Browse Services', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_browse_professionalists', 'frontend', 'Label / Browse Professionalists', 'script', '2015-10-20 03:43:02');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Browse Professionalists', 'script');

COMMIT;