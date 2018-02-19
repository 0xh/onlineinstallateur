
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'front_about_employee', 'frontend', 'Label / About employee', 'script', '2015-04-14 10:06:43');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'About {EMPLOYEE}', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_reason_for_appointment', 'frontend', 'Label / Reason for Appointment', 'script', '2015-04-15 05:46:44');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Reason for Appointment', 'script');

COMMIT;