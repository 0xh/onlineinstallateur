
START TRANSACTION;

UPDATE `options` SET `label`='Layout 1 - Employees list|Layout 2 - Services list' WHERE `key`='o_layout';  

COMMIT;