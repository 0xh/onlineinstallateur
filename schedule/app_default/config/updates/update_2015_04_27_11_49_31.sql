
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'lblInstallSeo_4', 'backend', 'Install / SEO Step 1', 'script', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '1', 'title', 'Step 4. (CROSS-DOMAIN INSTALL ONLY) Create .htaccess file (or update existing one) in the folder where your web page is and put the data below in it', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = "lblInstallSeo_3");

UPDATE `multi_lang` SET `content` = 'Step 3. (SAME DOMAIN INSTALL ONLY) Create .htaccess file (or update existing one) in the folder where your web page is and put the data below in it' WHERE `foreign_id` = @id AND `model` = "pjField" AND `field` = "title";

COMMIT;