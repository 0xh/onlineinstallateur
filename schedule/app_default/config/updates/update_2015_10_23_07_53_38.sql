
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'front_selected_date', 'frontend', 'Label / Selected date', 'script', '2015-10-23 06:55:04');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Selected date', 'script');

INSERT INTO `fields` VALUES (NULL, 'btnAddBooking', 'backend', 'Button / + Add booking', 'script', '2015-10-23 07:04:39');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', '+ Add booking', 'script');

INSERT INTO `fields` VALUES (NULL, 'btnAddEmployee', 'backend', 'Button / + Add employee', 'script', '2015-10-23 07:12:26');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', '+ Add employee', 'script');

INSERT INTO `fields` VALUES (NULL, 'btnAddService', 'backend', 'Button / + Add service', 'script', '2015-10-23 07:16:39');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', '+ Add service', 'script');

INSERT INTO `fields` VALUES (NULL, 'btnAddUser', 'backend', 'Button / + Add user', 'script', '2015-10-23 07:20:33');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', '+ Add user', 'script');

INSERT INTO `fields` VALUES (NULL, 'infoUsersTitle', 'backend', 'Infobox / List of users', 'script', '2015-10-23 07:21:48');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'List of users', 'script');

INSERT INTO `fields` VALUES (NULL, 'infoUsersDesc', 'backend', 'Infobox / List of users', 'script', '2015-10-23 07:22:47');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Below you can see users who have access to the Appointment Scheduler administration pages. Click on "+ Add user" button to add a new user.', 'script');

INSERT INTO `fields` VALUES (NULL, 'infoAddUserTitle', 'backend', 'Infobox / Add user', 'script', '2015-10-23 07:24:00');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Add user', 'script');

INSERT INTO `fields` VALUES (NULL, 'infoAddUserDesc', 'backend', 'Infobox / Add user', 'script', '2015-10-23 07:26:22');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Fill in the form below and click "Save" button to add new user. You can decide whether user to receive notifications or not by checking on the check-box "Notifications".', 'script');

INSERT INTO `fields` VALUES (NULL, 'infoUpdateUserTitle', 'backend', 'Infobox / Update user', 'script', '2015-10-23 07:26:53');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Update user', 'script');

INSERT INTO `fields` VALUES (NULL, 'infoUpdateUserDesc', 'backend', 'Infobox / Update user', 'script', '2015-10-23 07:27:42');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'You can make any changes on the form below and click "Save" button to update user information.', 'script');

COMMIT;