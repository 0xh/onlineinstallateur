
START TRANSACTION;

ALTER TABLE `services` ADD COLUMN `image` varchar(255) DEFAULT NULL AFTER `total`;

INSERT INTO `fields` VALUES (NULL, 'front_service_employee', 'frontend', 'Service/employee', 'script', '2015-04-13 03:42:38');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Service/employee', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_date_time', 'frontend', 'Label / Date and time', 'script', '2015-04-13 03:45:00');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Date and time', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_tax', 'frontend', 'Label / Tax', 'script', '2015-04-13 05:58:13');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Tax', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_total', 'frontend', 'Label / Total', 'script', '2015-04-13 05:58:33');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Total', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_deposit', 'frontend', 'Label / Deposit', 'script', '2015-04-13 05:58:53');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Deposit', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_close', 'frontend', 'Label / Close', 'script', '2015-04-13 07:26:43');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Close', 'script');

INSERT INTO `fields` VALUES (NULL, 'front_start_over', 'frontend', 'Label / Start over', 'script', '2015-04-13 09:16:29');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Start over', 'script');

INSERT INTO `fields` VALUES (NULL, 'service_image', 'backend', 'Label / Image', 'script', '2015-04-13 09:38:24');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Image', 'script');


INSERT INTO `fields` VALUES (NULL, 'error_titles_ARRAY_AS12', 'arrays', 'error_titles_ARRAY_AS12', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Picture size is too large', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_bodies_ARRAY_AS12', 'arrays', 'error_bodies_ARRAY_AS12', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'New service could not be added because picture size is too large and your server cannot upload it. Maximum allowed size is {SIZE}. Please, upload smaller picture.', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_titles_ARRAY_AS13', 'arrays', 'error_titles_ARRAY_AS13', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Picture size exceeded', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_bodies_ARRAY_AS13', 'arrays', 'error_bodies_ARRAY_AS13', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'New service has been added, but picture could not be uploaded as its size exceeds the maximum allowed file upload size.', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_titles_ARRAY_AS14', 'arrays', 'error_titles_ARRAY_AS14', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Wrong file type', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_bodies_ARRAY_AS14', 'arrays', 'error_bodies_ARRAY_AS14', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'You uploaded picture is not allowed to upload because it''s in wrong content type. Please check the actual type of the file.', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_titles_ARRAY_AS15', 'arrays', 'error_titles_ARRAY_AS15', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Picture size is too large', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_bodies_ARRAY_AS15', 'arrays', 'error_bodies_ARRAY_AS15', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Service could not be updated because picture size is too large and your server cannot upload it. Maximum allowed size is {SIZE}. Please, upload smaller picture.', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_titles_ARRAY_AS16', 'arrays', 'error_titles_ARRAY_AS16', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Picture size exceeded', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_bodies_ARRAY_AS16', 'arrays', 'error_bodies_ARRAY_AS16', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Service information has been updated, but picture could not be uploaded as its size exceeds the maximum allowed file upload size.', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_titles_ARRAY_AS17', 'arrays', 'error_titles_ARRAY_AS17', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Wrong file type', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_bodies_ARRAY_AS17', 'arrays', 'error_bodies_ARRAY_AS17', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'You uploaded picture is not allowed to upload because it''s in wrong content type. Please check the actual type of the file.', 'script');

COMMIT;