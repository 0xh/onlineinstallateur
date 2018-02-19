
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'btnCancelAppointment', 'frontend', 'Button / Cancel Appointment', 'script', '2015-11-12 02:22:52');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Cancel Appointment', 'script');

COMMIT;