
START TRANSACTION;

UPDATE `options` SET `value` = '1|2|3::3' WHERE `foreign_id` = 1 AND `key` = "o_bf_address_1";
UPDATE `options` SET `value` = '1|2|3::2' WHERE `foreign_id` = 1 AND `key` = "o_bf_address_2";

COMMIT;