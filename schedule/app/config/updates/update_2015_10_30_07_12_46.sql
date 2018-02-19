
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'lblInstallServicesProfessionals', 'backend', 'Label / Services & Professionals', 'script', '2015-10-30 06:25:08');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Services & Professionals', 'script');

INSERT INTO `fields` VALUES (NULL, 'install_opt_ARRAY_both', 'arrays', 'install_opt_ARRAY_both', 'script', '2015-10-30 06:25:53');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Both', 'script');

INSERT INTO `fields` VALUES (NULL, 'install_opt_ARRAY_service', 'arrays', 'install_opt_ARRAY_service', 'script', '2015-10-30 06:26:30');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Services only', 'script');

INSERT INTO `fields` VALUES (NULL, 'install_opt_ARRAY_professional', 'arrays', 'install_opt_ARRAY_professional', 'script', '2015-10-30 06:27:20');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Professionals only', 'script');

INSERT INTO `fields` VALUES (NULL, 'lblInstallCode', 'backend', 'Label / Install code', 'script', '2015-10-30 06:27:53');

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Install code', 'script');

COMMIT;