
START TRANSACTION;

SET @id := (SELECT `id` FROM `fields` WHERE `key` = "service_tip_employees");

UPDATE `multi_lang` SET `content` = 'Select employee(s) who can do this service.' WHERE `foreign_id` = @id AND `model` = "pjField" AND `field` = "title";

COMMIT;