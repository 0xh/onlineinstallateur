
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'front_service_required', 'frontend', 'Label / Reason for Appointment is required.', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Reason for appointment is required.', 'script');

COMMIT;