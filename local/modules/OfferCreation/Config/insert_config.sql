INSERT INTO `config` (`name`, `value`, `secured`, `hidden`, `created_at`, `updated_at`) 
VALUES ( 'pdf_invoice_file_offer', 'invoiceoffer', 0, 0, NOW(), NOW())
ON DUPLICATE KEY UPDATE id = id;

INSERT INTO `config` (`name`, `value`, `secured`, `hidden`, `created_at`, `updated_at`) 
VALUES ( 'pdf_delivery_file_offer', 'deliveryoffer', 0, 0, NOW(), NOW())
ON DUPLICATE KEY UPDATE id = id;