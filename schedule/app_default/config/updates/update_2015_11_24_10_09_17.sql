
START TRANSACTION;

UPDATE `options` SET `value` = '2' WHERE `key` = "o_booking_earlier";
UPDATE `options` SET `value` = '2' WHERE `key` = "o_cancel_earlier";
UPDATE `options` SET `value` = '60' WHERE `key` = "o_booking_days_earlier";

SET @id := (SELECT `id` FROM `fields` WHERE `key` = "opt_o_booking_earlier");
UPDATE `multi_lang` SET `content` = 'Accept bookings X hours before appointment start time' WHERE `foreign_id` = @id AND `model` = "pjField" AND `field` = "title";

SET @id := (SELECT `id` FROM `fields` WHERE `key` = "opt_o_cancel_earlier");
UPDATE `multi_lang` SET `content` = 'Clients can cancel a booking up to X hours before appointment start time' WHERE `foreign_id` = @id AND `model` = "pjField" AND `field` = "title";

SET @id := (SELECT `id` FROM `fields` WHERE `key` = "opt_o_booking_days_earlier");
UPDATE `multi_lang` SET `content` = 'Accept bookings X days ahead' WHERE `foreign_id` = @id AND `model` = "pjField" AND `field` = "title";

COMMIT;