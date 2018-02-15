INSERT INTO `message` (`name`, `secured`, `text_layout_file_name`, `text_template_file_name`, `html_layout_file_name`, `html_template_file_name`, `created_at`, `updated_at`) VALUES
('order_failed', NULL, NULL, 'order_failed.txt', NULL, 'order_failed.html', NOW(), NOW());

SET @last_id_in_message = LAST_INSERT_ID();

INSERT INTO `message_i18n` (`id`,`locale`, `title`, `subject`) VALUES
(@last_id_in_message,'en_US','Message sent to the shop owner when a order failed', 'Payment error for order Nº {$order_id}');

INSERT INTO `message_i18n` (`id`,`locale`, `title`, `subject`) VALUES
(@last_id_in_message,'de_DE','Message sent to the shop owner when a order failed', 'Zahlungsfehler bei Bestellung Nr. {$order_id}');

INSERT INTO `config` (`name`, `value`, `secured`, `hidden`, `created_at`, `updated_at`) VALUES ('pdf_orders_file', 'orders', '0', '0', '2018-02-05 15:17:47', '2018-02-05 15:17:47');

INSERT INTO `message` (`name`, `secured`, `text_layout_file_name`, `text_template_file_name`, `html_layout_file_name`, `html_template_file_name`, `created_at`, `updated_at`) VALUES
('pickup_order', NULL, NULL, 'pickup_order.txt', NULL, 'pickup_order.html', NOW(), NOW());

SET @last_id_in_message = LAST_INSERT_ID();

INSERT INTO `message_i18n` (`id`,`locale`, `title`, `subject`) VALUES
(@last_id_in_message,'en_US','Message sent to the customer when the order can be picked up', 'Your order {$order_ref} is ready for pickup');

INSERT INTO `message_i18n` (`id`,`locale`, `title`, `subject`) VALUES
(@last_id_in_message,'de_DE','Message sent to the customer when the order can be picked up', 'Ihre Bestellung {$order_ref} ist abholbereit');
