
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'front_unavailable_making_appiontment', 'frontend', 'Label / The selected date is unavaiable for making appioinment', 'script', '2015-11-23 17:48:34');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'The selected date is unavailable for making appointment. Please select another date.', 'script');

COMMIT;