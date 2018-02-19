
START TRANSACTION;

UPDATE `options` SET `value`=NULL WHERE `key`='o_authorize_hash';  
UPDATE `options` SET `value`=NULL WHERE `key`='o_authorize_key'; 
UPDATE `options` SET `value`=NULL WHERE `key`='o_authorize_mid'; 

SET @id := (SELECT `id` FROM `fields` WHERE `key` = "lblInstallJs1_1");
UPDATE `multi_lang` SET `content` = 'Install Code' WHERE `foreign_id` = @id AND `model` = "pjField" AND `field` = "title";

SET @id := (SELECT `id` FROM `fields` WHERE `key` = "error_bodies_ARRAY_AO30");
UPDATE `multi_lang` SET `content` = 'To better optimize your appointment scheduler please follow the steps below.' WHERE `foreign_id` = @id AND `model` = "pjField" AND `field` = "title";

SET @id := (SELECT `id` FROM `fields` WHERE `key` = "lblInstallJs1_body");
UPDATE `multi_lang` SET `content` = 'In order to install the script on your website copy the code below and add it to your web page.' WHERE `foreign_id` = @id AND `model` = "pjField" AND `field` = "title";

UPDATE `options` SET `is_visible`=0 WHERE `key`='o_accept_bookings';
UPDATE `options` SET `is_visible`=0 WHERE `key`='o_hide_prices';

COMMIT;