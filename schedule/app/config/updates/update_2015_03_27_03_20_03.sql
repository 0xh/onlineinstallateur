
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'lblNotifications', 'backend', 'Label / Notifications', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Notifications', 'script');

INSERT INTO `fields` VALUES (NULL, 'booking_client', 'backend', 'Label / Client', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Client', 'script');

INSERT INTO `fields` VALUES (NULL, 'lblEmailPhone', 'backend', 'Label / Email & Phone', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Email & Phone', 'script');

INSERT INTO `fields` VALUES (NULL, 'tabEmailNotifications', 'backend', 'Tab / Email Notifications', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Email Notifications', 'script');

INSERT INTO `fields` VALUES (NULL, 'notify_arr_ARRAY_confirm', 'arrays', 'notify_arr_ARRAY_confirm', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Client - booking confirmation email', 'script');

INSERT INTO `fields` VALUES (NULL, 'notify_arr_ARRAY_payment', 'arrays', 'notify_arr_ARRAY_payment', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Client - payment confirmation email', 'script');

INSERT INTO `fields` VALUES (NULL, 'notify_arr_ARRAY_cancel', 'arrays', 'notify_arr_ARRAY_cancel', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Client - booking cancellation email', 'script');

INSERT INTO `fields` VALUES (NULL, 'notify_arr_ARRAY_confirm_admin', 'arrays', 'notify_arr_ARRAY_confirm_admin', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Admin - booking confirmation email', 'script');

INSERT INTO `fields` VALUES (NULL, 'notify_arr_ARRAY_payment_admin', 'arrays', 'notify_arr_ARRAY_payment_admin', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Admin - payment confirmation email', 'script');

INSERT INTO `fields` VALUES (NULL, 'notify_arr_ARRAY_cancel_admin', 'arrays', 'notify_arr_ARRAY_cancel_admin', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Admin - booking cancellation email', 'script');

INSERT INTO `fields` VALUES (NULL, 'notify_arr_ARRAY_confirm_employee', 'arrays', 'notify_arr_ARRAY_confirm_employee', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Employee - booking confirmation email', 'script');

INSERT INTO `fields` VALUES (NULL, 'notify_arr_ARRAY_payment_employee', 'arrays', 'notify_arr_ARRAY_payment_employee', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Employee - payment confirmation email', 'script');

INSERT INTO `fields` VALUES (NULL, 'notify_arr_ARRAY_cancel_employee', 'arrays', 'notify_arr_ARRAY_cancel_employee', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Employee - booking cancellation email', 'script');

COMMIT;