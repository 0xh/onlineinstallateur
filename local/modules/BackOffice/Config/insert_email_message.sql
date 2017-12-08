INSERT INTO `message` (`name`, `secured`, `text_layout_file_name`, `text_template_file_name`, `html_layout_file_name`, `html_template_file_name`, `created_at`, `updated_at`) VALUES
('order_failed', NULL, NULL, 'order_failed.txt', NULL, 'order_failed.html', NOW(), NOW());

INSERT INTO `message_i18n` (`id`,`locale`, `title`, `subject`) VALUES
('25','en_US','Message sent to the shop owner when a order failed', 'Payment error for order Nº {$id}');

INSERT INTO `message_i18n` (`id`,`locale`, `title`, `subject`) VALUES
('25','de_DE','Message sent to the shop owner when a order failed', 'Zahlungsfehler bei Bestellung Nr. {$id}');