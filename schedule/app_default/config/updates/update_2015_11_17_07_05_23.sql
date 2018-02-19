
START TRANSACTION;

INSERT INTO `options` (`foreign_id`, `key`, `tab_id`, `value`, `label`, `type`, `order`, `is_visible`, `style`) VALUES
(1, 'o_booking_earlier', 3, '1', NULL, 'int', 11, 1, NULL),
(1, 'o_cancel_earlier', 3, '2', NULL, 'int', 12, 1, NULL),
(1, 'o_booking_days_earlier', 3, '1', NULL, 'int', 13, 1, NULL);

INSERT INTO `fields` VALUES (NULL, 'opt_o_booking_earlier', 'backend', 'Options / Book X hours earlier', 'script', '2015-11-17 07:11:13');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Book X hours earlier', 'script');

INSERT INTO `fields` VALUES (NULL, 'opt_o_cancel_earlier', 'backend', 'Options / Cancel X hours earlier', 'script', '2015-11-17 07:12:34');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Number of hours before appointment client can not cancel it.', 'script');

INSERT INTO `fields` VALUES (NULL, 'opt_o_booking_days_earlier', 'backend', 'Options / Number of days ahead client can make appointment', 'script', '2015-11-17 07:13:40');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Number of days ahead client can make appointment', 'script');

INSERT INTO `fields` VALUES (NULL, 'cancel_err_ARRAY_6', 'arrays', 'cancel_err_ARRAY_6', 'script', '2015-11-17 15:02:58');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'You need to cancel the booking %s hour(s) before the appointment start.', 'script');

COMMIT;