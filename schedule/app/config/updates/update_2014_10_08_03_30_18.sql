
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'error_titles_ARRAY_AE12', 'arrays', 'error_titles_ARRAY_AE12', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Picture size is too large', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_bodies_ARRAY_AE12', 'arrays', 'error_bodies_ARRAY_AE12', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'New employee could not be added because picture size is too large and your server cannot upload it. Maximum allowed size is {SIZE}. Please, upload smaller picture.', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_titles_ARRAY_AE13', 'arrays', 'error_titles_ARRAY_AE13', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Picture size exceeded', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_bodies_ARRAY_AE13', 'arrays', 'error_bodies_ARRAY_AE13', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'New employee has been added, but picture could not be uploaded as its size exceeds the maximum allowed file upload size.', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_titles_ARRAY_AE14', 'arrays', 'error_titles_ARRAY_AE14', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Wrong file type', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_bodies_ARRAY_AE14', 'arrays', 'error_bodies_ARRAY_AE14', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'You uploaded picture is not allowed to upload because it''s in wrong content type. Please check the actual type of the file.', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_titles_ARRAY_AE15', 'arrays', 'error_titles_ARRAY_AE15', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Picture size is too large', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_bodies_ARRAY_AE15', 'arrays', 'error_bodies_ARRAY_AE15', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Employee could not be updated because picture size is too large and your server cannot upload it. Maximum allowed size is {SIZE}. Please, upload smaller picture.', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_titles_ARRAY_AE16', 'arrays', 'error_titles_ARRAY_AE16', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Picture size exceeded', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_bodies_ARRAY_AE16', 'arrays', 'error_bodies_ARRAY_AE16', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Employee information has been updated, but picture could not be uploaded as its size exceeds the maximum allowed file upload size.', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_titles_ARRAY_AE17', 'arrays', 'error_titles_ARRAY_AE17', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Wrong file type', 'script');

INSERT INTO `fields` VALUES (NULL, 'error_bodies_ARRAY_AE17', 'arrays', 'error_bodies_ARRAY_AE17', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'You uploaded picture is not allowed to upload because it''s in wrong content type. Please check the actual type of the file.', 'script');

COMMIT;