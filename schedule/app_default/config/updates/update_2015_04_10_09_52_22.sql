
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'front_filter', 'frontend', 'Label / Filter', 'script', '2015-04-08 06:24:39');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Filter', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_all', 'frontend', 'Label / All', 'script', '2015-04-08 06:40:26');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'All', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_appointment', 'frontend', 'Label / appointment', 'script', '2015-04-08 06:44:03');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'appointment', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_appointments', 'frontend', 'Label / appointments', 'script', '2015-04-08 06:44:20');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'appointments', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_no_employees_found', 'frontend', 'Label / No employees found', 'script', '2015-04-08 06:59:13');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'No employees found', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_select_service', 'frontend', 'Frontend / Select service', 'script', '2015-04-08 08:44:56');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Select service', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_no_services_found', 'frontend', 'Label / No services found', 'script', '2015-04-08 08:49:24');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'No services found', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_duration', 'frontend', 'Label / Duration', 'script', '2015-04-08 08:54:47');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Duration', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_back', 'frontend', 'Label / back', 'script', '2015-04-08 10:11:12');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'back', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_phone', 'frontend', 'Label / Phone', 'script', '2015-04-08 10:28:10');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Phone', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_email', 'frontend', 'Label / Email', 'script', '2015-04-08 10:29:25');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Email', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_select_date_time', 'frontend', 'Label / Select date and time', 'script', '2015-04-08 10:45:06');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Select date and time', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_choose_date', 'frontend', 'Label / Choose date', 'script', '2015-04-08 10:47:53');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Choose date', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_time', 'frontend', 'Label / Time', 'script', '2015-04-09 10:41:27');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Time', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_date_off', 'frontend', 'Label / Selected date is a day off.', 'script', '2015-04-10 05:38:42');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Selected date is a day off.', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_select_date_time_employee', 'frontend', 'Label / Select date and time & employee', 'script', '2015-04-10 08:06:32');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Select date and time & employee', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_employees_not_avaiable', 'frontend', 'Label / Employees not available', 'script', '2015-04-10 08:29:15');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'No employees available for this service.', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_choose', 'frontend', 'Label / Choose', 'script', '2015-04-10 08:34:14');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Choose', 'script');

COMMIT;