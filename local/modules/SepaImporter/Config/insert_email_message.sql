INSERT INTO `message` (`name`, `secured`, `text_layout_file_name`, `text_template_file_name`, `html_layout_file_name`, `html_template_file_name`, `created_at`, `updated_at`) VALUES
('customer_traking_order', NULL, NULL,NULL, NULL, 'customer_traking_order.html', NOW(), NOW());

SET @last_id_in_message = LAST_INSERT_ID();

INSERT INTO `message_i18n` (`id`,`locale`, `title`, `subject`) VALUES
(@last_id_in_message,'en_US','Customer tracking order', 'Your{config key="store_name"} order {$order_ref} was delivered!');

INSERT INTO `message_i18n` (`id`,`locale`, `title`, `subject`) VALUES
(@last_id_in_message,'de_DE','Customer tracking order', 'Ihre {config key="store_name"} Bestellung  {$order_ref} wurde versandt!');