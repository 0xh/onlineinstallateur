DROP TABLE IF EXISTS `plugin_country`;
CREATE TABLE IF NOT EXISTS `plugin_country` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alpha_2` varchar(2) DEFAULT NULL,
  `alpha_3` varchar(3) DEFAULT NULL,
  `status` enum('T','F') NOT NULL DEFAULT 'T',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alpha_2` (`alpha_2`),
  UNIQUE KEY `alpha_3` (`alpha_3`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `plugin_country` (`id`, `alpha_2`, `alpha_3`, `status`) VALUES
(1, 'AF', 'AFG', 'T'),
(2, 'AX', 'ALA', 'T'),
(3, 'AL', 'ALB', 'T'),
(4, 'DZ', 'DZA', 'T'),
(5, 'AS', 'ASM', 'T'),
(6, 'AD', 'AND', 'T'),
(7, 'AO', 'AGO', 'T'),
(8, 'AI', 'AIA', 'T'),
(9, 'AQ', 'ATA', 'T'),
(10, 'AG', 'ATG', 'T'),
(11, 'AR', 'ARG', 'T'),
(12, 'AM', 'ARM', 'T'),
(13, 'AW', 'ABW', 'T'),
(14, 'AU', 'AUS', 'T'),
(15, 'AT', 'AUT', 'T'),
(16, 'AZ', 'AZE', 'T'),
(17, 'BS', 'BHS', 'T'),
(18, 'BH', 'BHR', 'T'),
(19, 'BD', 'BGD', 'T'),
(20, 'BB', 'BRB', 'T'),
(21, 'BY', 'BLR', 'T'),
(22, 'BE', 'BEL', 'T'),
(23, 'BZ', 'BLZ', 'T'),
(24, 'BJ', 'BEN', 'T'),
(25, 'BM', 'BMU', 'T'),
(26, 'BT', 'BTN', 'T'),
(27, 'BO', 'BOL', 'T'),
(28, 'BQ', 'BES', 'T'),
(29, 'BA', 'BIH', 'T'),
(30, 'BW', 'BWA', 'T'),
(31, 'BV', 'BVT', 'T'),
(32, 'BR', 'BRA', 'T'),
(33, 'IO', 'IOT', 'T'),
(34, 'BN', 'BRN', 'T'),
(35, 'BG', 'BGR', 'T'),
(36, 'BF', 'BFA', 'T'),
(37, 'BI', 'BDI', 'T'),
(38, 'KH', 'KHM', 'T'),
(39, 'CM', 'CMR', 'T'),
(40, 'CA', 'CAN', 'T'),
(41, 'CV', 'CPV', 'T'),
(42, 'KY', 'CYM', 'T'),
(43, 'CF', 'CAF', 'T'),
(44, 'TD', 'TCD', 'T'),
(45, 'CL', 'CHL', 'T'),
(46, 'CN', 'CHN', 'T'),
(47, 'CX', 'CXR', 'T'),
(48, 'CC', 'CCK', 'T'),
(49, 'CO', 'COL', 'T'),
(50, 'KM', 'COM', 'T'),
(51, 'CG', 'COG', 'T'),
(52, 'CD', 'COD', 'T'),
(53, 'CK', 'COK', 'T'),
(54, 'CR', 'CRI', 'T'),
(55, 'CI', 'CIV', 'T'),
(56, 'HR', 'HRV', 'T'),
(57, 'CU', 'CUB', 'T'),
(58, 'CW', 'CUW', 'T'),
(59, 'CY', 'CYP', 'T'),
(60, 'CZ', 'CZE', 'T'),
(61, 'DK', 'DNK', 'T'),
(62, 'DJ', 'DJI', 'T'),
(63, 'DM', 'DMA', 'T'),
(64, 'DO', 'DOM', 'T'),
(65, 'EC', 'ECU', 'T'),
(66, 'EG', 'EGY', 'T'),
(67, 'SV', 'SLV', 'T'),
(68, 'GQ', 'GNQ', 'T'),
(69, 'ER', 'ERI', 'T'),
(70, 'EE', 'EST', 'T'),
(71, 'ET', 'ETH', 'T'),
(72, 'FK', 'FLK', 'T'),
(73, 'FO', 'FRO', 'T'),
(74, 'FJ', 'FJI', 'T'),
(75, 'FI', 'FIN', 'T'),
(76, 'FR', 'FRA', 'T'),
(77, 'GF', 'GUF', 'T'),
(78, 'PF', 'PYF', 'T'),
(79, 'TF', 'ATF', 'T'),
(80, 'GA', 'GAB', 'T'),
(81, 'GM', 'GMB', 'T'),
(82, 'GE', 'GEO', 'T'),
(83, 'DE', 'DEU', 'T'),
(84, 'GH', 'GHA', 'T'),
(85, 'GI', 'GIB', 'T'),
(86, 'GR', 'GRC', 'T'),
(87, 'GL', 'GRL', 'T'),
(88, 'GD', 'GRD', 'T'),
(89, 'GP', 'GLP', 'T'),
(90, 'GU', 'GUM', 'T'),
(91, 'GT', 'GTM', 'T'),
(92, 'GG', 'GGY', 'T'),
(93, 'GN', 'GIN', 'T'),
(94, 'GW', 'GNB', 'T'),
(95, 'GY', 'GUY', 'T'),
(96, 'HT', 'HTI', 'T'),
(97, 'HM', 'HMD', 'T'),
(98, 'VA', 'VAT', 'T'),
(99, 'HN', 'HND', 'T'),
(100, 'HK', 'HKG', 'T'),
(101, 'HU', 'HUN', 'T'),
(102, 'IS', 'ISL', 'T'),
(103, 'IN', 'IND', 'T'),
(104, 'ID', 'IDN', 'T'),
(105, 'IR', 'IRN', 'T'),
(106, 'IQ', 'IRQ', 'T'),
(107, 'IE', 'IRL', 'T'),
(108, 'IM', 'IMN', 'T'),
(109, 'IL', 'ISR', 'T'),
(110, 'IT', 'ITA', 'T'),
(111, 'JM', 'JAM', 'T'),
(112, 'JP', 'JPN', 'T'),
(113, 'JE', 'JEY', 'T'),
(114, 'JO', 'JOR', 'T'),
(115, 'KZ', 'KAZ', 'T'),
(116, 'KE', 'KEN', 'T'),
(117, 'KI', 'KIR', 'T'),
(118, 'KP', 'PRK', 'T'),
(119, 'KR', 'KOR', 'T'),
(120, 'KW', 'KWT', 'T'),
(121, 'KG', 'KGZ', 'T'),
(122, 'LA', 'LAO', 'T'),
(123, 'LV', 'LVA', 'T'),
(124, 'LB', 'LBN', 'T'),
(125, 'LS', 'LSO', 'T'),
(126, 'LR', 'LBR', 'T'),
(127, 'LY', 'LBY', 'T'),
(128, 'LI', 'LIE', 'T'),
(129, 'LT', 'LTU', 'T'),
(130, 'LU', 'LUX', 'T'),
(131, 'MO', 'MAC', 'T'),
(132, 'MK', 'MKD', 'T'),
(133, 'MG', 'MDG', 'T'),
(134, 'MW', 'MWI', 'T'),
(135, 'MY', 'MYS', 'T'),
(136, 'MV', 'MDV', 'T'),
(137, 'ML', 'MLI', 'T'),
(138, 'MT', 'MLT', 'T'),
(139, 'MH', 'MHL', 'T'),
(140, 'MQ', 'MTQ', 'T'),
(141, 'MR', 'MRT', 'T'),
(142, 'MU', 'MUS', 'T'),
(143, 'YT', 'MYT', 'T'),
(144, 'MX', 'MEX', 'T'),
(145, 'FM', 'FSM', 'T'),
(146, 'MD', 'MDA', 'T'),
(147, 'MC', 'MCO', 'T'),
(148, 'MN', 'MNG', 'T'),
(149, 'ME', 'MNE', 'T'),
(150, 'MS', 'MSR', 'T'),
(151, 'MA', 'MAR', 'T'),
(152, 'MZ', 'MOZ', 'T'),
(153, 'MM', 'MMR', 'T'),
(154, 'NA', 'NAM', 'T'),
(155, 'NR', 'NRU', 'T'),
(156, 'NP', 'NPL', 'T'),
(157, 'NL', 'NLD', 'T'),
(158, 'NC', 'NCL', 'T'),
(159, 'NZ', 'NZL', 'T'),
(160, 'NI', 'NIC', 'T'),
(161, 'NE', 'NER', 'T'),
(162, 'NG', 'NGA', 'T'),
(163, 'NU', 'NIU', 'T'),
(164, 'NF', 'NFK', 'T'),
(165, 'MP', 'MNP', 'T'),
(166, 'NO', 'NOR', 'T'),
(167, 'OM', 'OMN', 'T'),
(168, 'PK', 'PAK', 'T'),
(169, 'PW', 'PLW', 'T'),
(170, 'PS', 'PSE', 'T'),
(171, 'PA', 'PAN', 'T'),
(172, 'PG', 'PNG', 'T'),
(173, 'PY', 'PRY', 'T'),
(174, 'PE', 'PER', 'T'),
(175, 'PH', 'PHL', 'T'),
(176, 'PN', 'PCN', 'T'),
(177, 'PL', 'POL', 'T'),
(178, 'PT', 'PRT', 'T'),
(179, 'PR', 'PRI', 'T'),
(180, 'QA', 'QAT', 'T'),
(181, 'RE', 'REU', 'T'),
(182, 'RO', 'ROU', 'T'),
(183, 'RU', 'RUS', 'T'),
(184, 'RW', 'RWA', 'T'),
(185, 'BL', 'BLM', 'T'),
(186, 'SH', 'SHN', 'T'),
(187, 'KN', 'KNA', 'T'),
(188, 'LC', 'LCA', 'T'),
(189, 'MF', 'MAF', 'T'),
(190, 'PM', 'SPM', 'T'),
(191, 'VC', 'VCT', 'T'),
(192, 'WS', 'WSM', 'T'),
(193, 'SM', 'SMR', 'T'),
(194, 'ST', 'STP', 'T'),
(195, 'SA', 'SAU', 'T'),
(196, 'SN', 'SEN', 'T'),
(197, 'RS', 'SRB', 'T'),
(198, 'SC', 'SYC', 'T'),
(199, 'SL', 'SLE', 'T'),
(200, 'SG', 'SGP', 'T'),
(201, 'SX', 'SXM', 'T'),
(202, 'SK', 'SVK', 'T'),
(203, 'SI', 'SVN', 'T'),
(204, 'SB', 'SLB', 'T'),
(205, 'SO', 'SOM', 'T'),
(206, 'ZA', 'ZAF', 'T'),
(207, 'GS', 'SGS', 'T'),
(208, 'SS', 'SSD', 'T'),
(209, 'ES', 'ESP', 'T'),
(210, 'LK', 'LKA', 'T'),
(211, 'SD', 'SDN', 'T'),
(212, 'SR', 'SUR', 'T'),
(213, 'SJ', 'SJM', 'T'),
(214, 'SZ', 'SWZ', 'T'),
(215, 'SE', 'SWE', 'T'),
(216, 'CH', 'CHE', 'T'),
(217, 'SY', 'SYR', 'T'),
(218, 'TW', 'TWN', 'T'),
(219, 'TJ', 'TJK', 'T'),
(220, 'TZ', 'TZA', 'T'),
(221, 'TH', 'THA', 'T'),
(222, 'TL', 'TLS', 'T'),
(223, 'TG', 'TGO', 'T'),
(224, 'TK', 'TKL', 'T'),
(225, 'TO', 'TON', 'T'),
(226, 'TT', 'TTO', 'T'),
(227, 'TN', 'TUN', 'T'),
(228, 'TR', 'TUR', 'T'),
(229, 'TM', 'TKM', 'T'),
(230, 'TC', 'TCA', 'T'),
(231, 'TV', 'TUV', 'T'),
(232, 'UG', 'UGA', 'T'),
(233, 'UA', 'UKR', 'T'),
(234, 'AE', 'ARE', 'T'),
(235, 'GB', 'GBR', 'T'),
(236, 'US', 'USA', 'T'),
(237, 'UM', 'UMI', 'T'),
(238, 'UY', 'URY', 'T'),
(239, 'UZ', 'UZB', 'T'),
(240, 'VU', 'VUT', 'T'),
(241, 'VE', 'VEN', 'T'),
(242, 'VN', 'VNM', 'T'),
(243, 'VG', 'VGB', 'T'),
(244, 'VI', 'VIR', 'T'),
(245, 'WF', 'WLF', 'T'),
(246, 'EH', 'ESH', 'T'),
(247, 'YE', 'YEM', 'T'),
(248, 'ZM', 'ZMB', 'T'),
(249, 'ZW', 'ZWE', 'T');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_country_name', 'backend', 'Country plugin / Country name', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Country name', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Country name', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Country name', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_country_alpha_2', 'backend', 'Country plugin / Alpha 2', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Alpha 2', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Alpha 2', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Alpha 2', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_country_alpha_3', 'backend', 'Country plugin / Alpha 3', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Alpha 3', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Alpha 3', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Alpha 3', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_country_status', 'backend', 'Country plugin / Status', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Status', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Status', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Status', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_country_btn_add', 'backend', 'Country plugin / Button Add', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Add +', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Add +', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Add +', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_country_statuses_ARRAY_T', 'arrays', 'Country plugin / Status (active)', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Active', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Active', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Active', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_country_statuses_ARRAY_F', 'arrays', 'Country plugin / Status (inactive)', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Inactive', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Inactive', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Inactive', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_country_btn_save', 'backend', 'Country plugin / Button Save', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Save', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Save', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Save', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_country_btn_cancel', 'backend', 'Country plugin / Button Cancel', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Cancel', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Cancel', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Cancel', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_country_menu_countries', 'backend', 'Country plugin / Menu Countries', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Countries', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Countries', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Countries', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PCY01', 'arrays', 'error_titles_ARRAY_PCY01', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Country updated', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Country updated', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Country updated', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PCY03', 'arrays', 'error_titles_ARRAY_PCY03', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Country added', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Country added', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Country added', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PCY04', 'arrays', 'error_titles_ARRAY_PCY04', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Country failed to add', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Country failed to add', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Country failed to add', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PCY08', 'arrays', 'error_titles_ARRAY_PCY08', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Country not found', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Country not found', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Country not found', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PCY10', 'arrays', 'error_titles_ARRAY_PCY10', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Add country', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Add country', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Add country', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PCY11', 'arrays', 'error_titles_ARRAY_PCY11', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Update country', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Update country', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Update country', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PCY12', 'arrays', 'error_titles_ARRAY_PCY12', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Manage countries', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Manage countries', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Manage countries', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PCY01', 'arrays', 'error_bodies_ARRAY_PCY01', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Country has been updated successfully.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Country has been updated successfully.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Country has been updated successfully.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PCY03', 'arrays', 'error_bodies_ARRAY_PCY03', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Country has been added successfully.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Country has been added successfully.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Country has been added successfully.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PCY04', 'arrays', 'error_bodies_ARRAY_PCY04', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Country has not been added successfully.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Country has not been added successfully.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Country has not been added successfully.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PCY08', 'arrays', 'error_bodies_ARRAY_PCY08', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Country you are looking for has not been found.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Country you are looking for has not been found.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Country you are looking for has not been found.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PCY10', 'arrays', 'error_bodies_ARRAY_PCY10', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Use form below to add a country.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Use form below to add a country.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Use form below to add a country.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PCY11', 'arrays', 'error_bodies_ARRAY_PCY11', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Use form below to update a country.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Use form below to update a country.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Use form below to update a country.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PCY12', 'arrays', 'error_bodies_ARRAY_PCY12', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Use grid below to organize your country list.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Use grid below to organize your country list.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Use grid below to organize your country list.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_country_delete_confirmation', 'backend', 'Country plugin / Delete confirmation', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Are you sure you want to delete selected country?', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Are you sure you want to delete selected country?', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Are you sure you want to delete selected country?', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_country_delete_selected', 'backend', 'Country plugin / Delete selected', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Delete selected', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Delete selected', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Delete selected', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_country_btn_all', 'backend', 'Country plugin / Button All', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'All', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'All', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'All', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_country_btn_search', 'backend', 'Country plugin / Button Search', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Search', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Search', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Search', 'plugin');

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, '1', 'pjCountry', '1', 'name', 'Afghanistan', 'plugin'),
(NULL, '1', 'pjCountry', '2', 'name', 'Afghanistan', 'plugin'),
(NULL, '1', 'pjCountry', '3', 'name', 'Afghanistan', 'plugin'),
(NULL, '2', 'pjCountry', '1', 'name', 'Åland Islands', 'plugin'),
(NULL, '2', 'pjCountry', '2', 'name', 'Åland Islands', 'plugin'),
(NULL, '2', 'pjCountry', '3', 'name', 'Åland Islands', 'plugin'),
(NULL, '3', 'pjCountry', '1', 'name', 'Albania', 'plugin'),
(NULL, '3', 'pjCountry', '2', 'name', 'Albania', 'plugin'),
(NULL, '3', 'pjCountry', '3', 'name', 'Albania', 'plugin'),
(NULL, '4', 'pjCountry', '1', 'name', 'Algeria', 'plugin'),
(NULL, '4', 'pjCountry', '2', 'name', 'Algeria', 'plugin'),
(NULL, '4', 'pjCountry', '3', 'name', 'Algeria', 'plugin'),
(NULL, '5', 'pjCountry', '1', 'name', 'American Samoa', 'plugin'),
(NULL, '5', 'pjCountry', '2', 'name', 'American Samoa', 'plugin'),
(NULL, '5', 'pjCountry', '3', 'name', 'American Samoa', 'plugin'),
(NULL, '6', 'pjCountry', '1', 'name', 'Andorra', 'plugin'),
(NULL, '6', 'pjCountry', '2', 'name', 'Andorra', 'plugin'),
(NULL, '6', 'pjCountry', '3', 'name', 'Andorra', 'plugin'),
(NULL, '7', 'pjCountry', '1', 'name', 'Angola', 'plugin'),
(NULL, '7', 'pjCountry', '2', 'name', 'Angola', 'plugin'),
(NULL, '7', 'pjCountry', '3', 'name', 'Angola', 'plugin'),
(NULL, '8', 'pjCountry', '1', 'name', 'Anguilla', 'plugin'),
(NULL, '8', 'pjCountry', '2', 'name', 'Anguilla', 'plugin'),
(NULL, '8', 'pjCountry', '3', 'name', 'Anguilla', 'plugin'),
(NULL, '9', 'pjCountry', '1', 'name', 'Antarctica', 'plugin'),
(NULL, '9', 'pjCountry', '2', 'name', 'Antarctica', 'plugin'),
(NULL, '9', 'pjCountry', '3', 'name', 'Antarctica', 'plugin'),
(NULL, '10', 'pjCountry', '1', 'name', 'Antigua and Barbuda', 'plugin'),
(NULL, '10', 'pjCountry', '2', 'name', 'Antigua and Barbuda', 'plugin'),
(NULL, '10', 'pjCountry', '3', 'name', 'Antigua and Barbuda', 'plugin'),
(NULL, '11', 'pjCountry', '1', 'name', 'Argentina', 'plugin'),
(NULL, '11', 'pjCountry', '2', 'name', 'Argentina', 'plugin'),
(NULL, '11', 'pjCountry', '3', 'name', 'Argentina', 'plugin'),
(NULL, '12', 'pjCountry', '1', 'name', 'Armenia', 'plugin'),
(NULL, '12', 'pjCountry', '2', 'name', 'Armenia', 'plugin'),
(NULL, '12', 'pjCountry', '3', 'name', 'Armenia', 'plugin'),
(NULL, '13', 'pjCountry', '1', 'name', 'Aruba', 'plugin'),
(NULL, '13', 'pjCountry', '2', 'name', 'Aruba', 'plugin'),
(NULL, '13', 'pjCountry', '3', 'name', 'Aruba', 'plugin'),
(NULL, '14', 'pjCountry', '1', 'name', 'Australia', 'plugin'),
(NULL, '14', 'pjCountry', '2', 'name', 'Australia', 'plugin'),
(NULL, '14', 'pjCountry', '3', 'name', 'Australia', 'plugin'),
(NULL, '15', 'pjCountry', '1', 'name', 'Austria', 'plugin'),
(NULL, '15', 'pjCountry', '2', 'name', 'Austria', 'plugin'),
(NULL, '15', 'pjCountry', '3', 'name', 'Austria', 'plugin'),
(NULL, '16', 'pjCountry', '1', 'name', 'Azerbaijan', 'plugin'),
(NULL, '16', 'pjCountry', '2', 'name', 'Azerbaijan', 'plugin'),
(NULL, '16', 'pjCountry', '3', 'name', 'Azerbaijan', 'plugin'),
(NULL, '17', 'pjCountry', '1', 'name', 'Bahamas', 'plugin'),
(NULL, '17', 'pjCountry', '2', 'name', 'Bahamas', 'plugin'),
(NULL, '17', 'pjCountry', '3', 'name', 'Bahamas', 'plugin'),
(NULL, '18', 'pjCountry', '1', 'name', 'Bahrain', 'plugin'),
(NULL, '18', 'pjCountry', '2', 'name', 'Bahrain', 'plugin'),
(NULL, '18', 'pjCountry', '3', 'name', 'Bahrain', 'plugin'),
(NULL, '19', 'pjCountry', '1', 'name', 'Bangladesh', 'plugin'),
(NULL, '19', 'pjCountry', '2', 'name', 'Bangladesh', 'plugin'),
(NULL, '19', 'pjCountry', '3', 'name', 'Bangladesh', 'plugin'),
(NULL, '20', 'pjCountry', '1', 'name', 'Barbados', 'plugin'),
(NULL, '20', 'pjCountry', '2', 'name', 'Barbados', 'plugin'),
(NULL, '20', 'pjCountry', '3', 'name', 'Barbados', 'plugin'),
(NULL, '21', 'pjCountry', '1', 'name', 'Belarus', 'plugin'),
(NULL, '21', 'pjCountry', '2', 'name', 'Belarus', 'plugin'),
(NULL, '21', 'pjCountry', '3', 'name', 'Belarus', 'plugin'),
(NULL, '22', 'pjCountry', '1', 'name', 'Belgium', 'plugin'),
(NULL, '22', 'pjCountry', '2', 'name', 'Belgium', 'plugin'),
(NULL, '22', 'pjCountry', '3', 'name', 'Belgium', 'plugin'),
(NULL, '23', 'pjCountry', '1', 'name', 'Belize', 'plugin'),
(NULL, '23', 'pjCountry', '2', 'name', 'Belize', 'plugin'),
(NULL, '23', 'pjCountry', '3', 'name', 'Belize', 'plugin'),
(NULL, '24', 'pjCountry', '1', 'name', 'Benin', 'plugin'),
(NULL, '24', 'pjCountry', '2', 'name', 'Benin', 'plugin'),
(NULL, '24', 'pjCountry', '3', 'name', 'Benin', 'plugin'),
(NULL, '25', 'pjCountry', '1', 'name', 'Bermuda', 'plugin'),
(NULL, '25', 'pjCountry', '2', 'name', 'Bermuda', 'plugin'),
(NULL, '25', 'pjCountry', '3', 'name', 'Bermuda', 'plugin'),
(NULL, '26', 'pjCountry', '1', 'name', 'Bhutan', 'plugin'),
(NULL, '26', 'pjCountry', '2', 'name', 'Bhutan', 'plugin'),
(NULL, '26', 'pjCountry', '3', 'name', 'Bhutan', 'plugin'),
(NULL, '27', 'pjCountry', '1', 'name', 'Bolivia, Plurinational State of', 'plugin'),
(NULL, '27', 'pjCountry', '2', 'name', 'Bolivia, Plurinational State of', 'plugin'),
(NULL, '27', 'pjCountry', '3', 'name', 'Bolivia, Plurinational State of', 'plugin'),
(NULL, '28', 'pjCountry', '1', 'name', 'Bonaire, Sint Eustatius and Saba', 'plugin'),
(NULL, '28', 'pjCountry', '2', 'name', 'Bonaire, Sint Eustatius and Saba', 'plugin'),
(NULL, '28', 'pjCountry', '3', 'name', 'Bonaire, Sint Eustatius and Saba', 'plugin'),
(NULL, '29', 'pjCountry', '1', 'name', 'Bosnia and Herzegovina', 'plugin'),
(NULL, '29', 'pjCountry', '2', 'name', 'Bosnia and Herzegovina', 'plugin'),
(NULL, '29', 'pjCountry', '3', 'name', 'Bosnia and Herzegovina', 'plugin'),
(NULL, '30', 'pjCountry', '1', 'name', 'Botswana', 'plugin'),
(NULL, '30', 'pjCountry', '2', 'name', 'Botswana', 'plugin'),
(NULL, '30', 'pjCountry', '3', 'name', 'Botswana', 'plugin'),
(NULL, '31', 'pjCountry', '1', 'name', 'Bouvet Island', 'plugin'),
(NULL, '31', 'pjCountry', '2', 'name', 'Bouvet Island', 'plugin'),
(NULL, '31', 'pjCountry', '3', 'name', 'Bouvet Island', 'plugin'),
(NULL, '32', 'pjCountry', '1', 'name', 'Brazil', 'plugin'),
(NULL, '32', 'pjCountry', '2', 'name', 'Brazil', 'plugin'),
(NULL, '32', 'pjCountry', '3', 'name', 'Brazil', 'plugin'),
(NULL, '33', 'pjCountry', '1', 'name', 'British Indian Ocean Territory', 'plugin'),
(NULL, '33', 'pjCountry', '2', 'name', 'British Indian Ocean Territory', 'plugin'),
(NULL, '33', 'pjCountry', '3', 'name', 'British Indian Ocean Territory', 'plugin'),
(NULL, '34', 'pjCountry', '1', 'name', 'Brunei Darussalam', 'plugin'),
(NULL, '34', 'pjCountry', '2', 'name', 'Brunei Darussalam', 'plugin'),
(NULL, '34', 'pjCountry', '3', 'name', 'Brunei Darussalam', 'plugin'),
(NULL, '35', 'pjCountry', '1', 'name', 'Bulgaria', 'plugin'),
(NULL, '35', 'pjCountry', '2', 'name', 'Bulgaria', 'plugin'),
(NULL, '35', 'pjCountry', '3', 'name', 'Bulgaria', 'plugin'),
(NULL, '36', 'pjCountry', '1', 'name', 'Burkina Faso', 'plugin'),
(NULL, '36', 'pjCountry', '2', 'name', 'Burkina Faso', 'plugin'),
(NULL, '36', 'pjCountry', '3', 'name', 'Burkina Faso', 'plugin'),
(NULL, '37', 'pjCountry', '1', 'name', 'Burundi', 'plugin'),
(NULL, '37', 'pjCountry', '2', 'name', 'Burundi', 'plugin'),
(NULL, '37', 'pjCountry', '3', 'name', 'Burundi', 'plugin'),
(NULL, '38', 'pjCountry', '1', 'name', 'Cambodia', 'plugin'),
(NULL, '38', 'pjCountry', '2', 'name', 'Cambodia', 'plugin'),
(NULL, '38', 'pjCountry', '3', 'name', 'Cambodia', 'plugin'),
(NULL, '39', 'pjCountry', '1', 'name', 'Cameroon', 'plugin'),
(NULL, '39', 'pjCountry', '2', 'name', 'Cameroon', 'plugin'),
(NULL, '39', 'pjCountry', '3', 'name', 'Cameroon', 'plugin'),
(NULL, '40', 'pjCountry', '1', 'name', 'Canada', 'plugin'),
(NULL, '40', 'pjCountry', '2', 'name', 'Canada', 'plugin'),
(NULL, '40', 'pjCountry', '3', 'name', 'Canada', 'plugin'),
(NULL, '41', 'pjCountry', '1', 'name', 'Cape Verde', 'plugin'),
(NULL, '41', 'pjCountry', '2', 'name', 'Cape Verde', 'plugin'),
(NULL, '41', 'pjCountry', '3', 'name', 'Cape Verde', 'plugin'),
(NULL, '42', 'pjCountry', '1', 'name', 'Cayman Islands', 'plugin'),
(NULL, '42', 'pjCountry', '2', 'name', 'Cayman Islands', 'plugin'),
(NULL, '42', 'pjCountry', '3', 'name', 'Cayman Islands', 'plugin'),
(NULL, '43', 'pjCountry', '1', 'name', 'Central African Republic', 'plugin'),
(NULL, '43', 'pjCountry', '2', 'name', 'Central African Republic', 'plugin'),
(NULL, '43', 'pjCountry', '3', 'name', 'Central African Republic', 'plugin'),
(NULL, '44', 'pjCountry', '1', 'name', 'Chad', 'plugin'),
(NULL, '44', 'pjCountry', '2', 'name', 'Chad', 'plugin'),
(NULL, '44', 'pjCountry', '3', 'name', 'Chad', 'plugin'),
(NULL, '45', 'pjCountry', '1', 'name', 'Chile', 'plugin'),
(NULL, '45', 'pjCountry', '2', 'name', 'Chile', 'plugin'),
(NULL, '45', 'pjCountry', '3', 'name', 'Chile', 'plugin'),
(NULL, '46', 'pjCountry', '1', 'name', 'China', 'plugin'),
(NULL, '46', 'pjCountry', '2', 'name', 'China', 'plugin'),
(NULL, '46', 'pjCountry', '3', 'name', 'China', 'plugin'),
(NULL, '47', 'pjCountry', '1', 'name', 'Christmas Island', 'plugin'),
(NULL, '47', 'pjCountry', '2', 'name', 'Christmas Island', 'plugin'),
(NULL, '47', 'pjCountry', '3', 'name', 'Christmas Island', 'plugin'),
(NULL, '48', 'pjCountry', '1', 'name', 'Cocos array(Keeling) Islands', 'plugin'),
(NULL, '48', 'pjCountry', '2', 'name', 'Cocos array(Keeling) Islands', 'plugin'),
(NULL, '48', 'pjCountry', '3', 'name', 'Cocos array(Keeling) Islands', 'plugin'),
(NULL, '49', 'pjCountry', '1', 'name', 'Colombia', 'plugin'),
(NULL, '49', 'pjCountry', '2', 'name', 'Colombia', 'plugin'),
(NULL, '49', 'pjCountry', '3', 'name', 'Colombia', 'plugin'),
(NULL, '50', 'pjCountry', '1', 'name', 'Comoros', 'plugin'),
(NULL, '50', 'pjCountry', '2', 'name', 'Comoros', 'plugin'),
(NULL, '50', 'pjCountry', '3', 'name', 'Comoros', 'plugin'),
(NULL, '51', 'pjCountry', '1', 'name', 'Congo', 'plugin'),
(NULL, '51', 'pjCountry', '2', 'name', 'Congo', 'plugin'),
(NULL, '51', 'pjCountry', '3', 'name', 'Congo', 'plugin'),
(NULL, '52', 'pjCountry', '1', 'name', 'Congo, the Democratic Republic of the', 'plugin'),
(NULL, '52', 'pjCountry', '2', 'name', 'Congo, the Democratic Republic of the', 'plugin'),
(NULL, '52', 'pjCountry', '3', 'name', 'Congo, the Democratic Republic of the', 'plugin'),
(NULL, '53', 'pjCountry', '1', 'name', 'Cook Islands', 'plugin'),
(NULL, '53', 'pjCountry', '2', 'name', 'Cook Islands', 'plugin'),
(NULL, '53', 'pjCountry', '3', 'name', 'Cook Islands', 'plugin'),
(NULL, '54', 'pjCountry', '1', 'name', 'Costa Rica', 'plugin'),
(NULL, '54', 'pjCountry', '2', 'name', 'Costa Rica', 'plugin'),
(NULL, '54', 'pjCountry', '3', 'name', 'Costa Rica', 'plugin'),
(NULL, '55', 'pjCountry', '1', 'name', 'Côte d''Ivoire', 'plugin'),
(NULL, '55', 'pjCountry', '2', 'name', 'Côte d''Ivoire', 'plugin'),
(NULL, '55', 'pjCountry', '3', 'name', 'Côte d''Ivoire', 'plugin'),
(NULL, '56', 'pjCountry', '1', 'name', 'Croatia', 'plugin'),
(NULL, '56', 'pjCountry', '2', 'name', 'Croatia', 'plugin'),
(NULL, '56', 'pjCountry', '3', 'name', 'Croatia', 'plugin'),
(NULL, '57', 'pjCountry', '1', 'name', 'Cuba', 'plugin'),
(NULL, '57', 'pjCountry', '2', 'name', 'Cuba', 'plugin'),
(NULL, '57', 'pjCountry', '3', 'name', 'Cuba', 'plugin'),
(NULL, '58', 'pjCountry', '1', 'name', 'Curaçao', 'plugin'),
(NULL, '58', 'pjCountry', '2', 'name', 'Curaçao', 'plugin'),
(NULL, '58', 'pjCountry', '3', 'name', 'Curaçao', 'plugin'),
(NULL, '59', 'pjCountry', '1', 'name', 'Cyprus', 'plugin'),
(NULL, '59', 'pjCountry', '2', 'name', 'Cyprus', 'plugin'),
(NULL, '59', 'pjCountry', '3', 'name', 'Cyprus', 'plugin'),
(NULL, '60', 'pjCountry', '1', 'name', 'Czech Republic', 'plugin'),
(NULL, '60', 'pjCountry', '2', 'name', 'Czech Republic', 'plugin'),
(NULL, '60', 'pjCountry', '3', 'name', 'Czech Republic', 'plugin'),
(NULL, '61', 'pjCountry', '1', 'name', 'Denmark', 'plugin'),
(NULL, '61', 'pjCountry', '2', 'name', 'Denmark', 'plugin'),
(NULL, '61', 'pjCountry', '3', 'name', 'Denmark', 'plugin'),
(NULL, '62', 'pjCountry', '1', 'name', 'Djibouti', 'plugin'),
(NULL, '62', 'pjCountry', '2', 'name', 'Djibouti', 'plugin'),
(NULL, '62', 'pjCountry', '3', 'name', 'Djibouti', 'plugin'),
(NULL, '63', 'pjCountry', '1', 'name', 'Dominica', 'plugin'),
(NULL, '63', 'pjCountry', '2', 'name', 'Dominica', 'plugin'),
(NULL, '63', 'pjCountry', '3', 'name', 'Dominica', 'plugin'),
(NULL, '64', 'pjCountry', '1', 'name', 'Dominican Republic', 'plugin'),
(NULL, '64', 'pjCountry', '2', 'name', 'Dominican Republic', 'plugin'),
(NULL, '64', 'pjCountry', '3', 'name', 'Dominican Republic', 'plugin'),
(NULL, '65', 'pjCountry', '1', 'name', 'Ecuador', 'plugin'),
(NULL, '65', 'pjCountry', '2', 'name', 'Ecuador', 'plugin'),
(NULL, '65', 'pjCountry', '3', 'name', 'Ecuador', 'plugin'),
(NULL, '66', 'pjCountry', '1', 'name', 'Egypt', 'plugin'),
(NULL, '66', 'pjCountry', '2', 'name', 'Egypt', 'plugin'),
(NULL, '66', 'pjCountry', '3', 'name', 'Egypt', 'plugin'),
(NULL, '67', 'pjCountry', '1', 'name', 'El Salvador', 'plugin'),
(NULL, '67', 'pjCountry', '2', 'name', 'El Salvador', 'plugin'),
(NULL, '67', 'pjCountry', '3', 'name', 'El Salvador', 'plugin'),
(NULL, '68', 'pjCountry', '1', 'name', 'Equatorial Guinea', 'plugin'),
(NULL, '68', 'pjCountry', '2', 'name', 'Equatorial Guinea', 'plugin'),
(NULL, '68', 'pjCountry', '3', 'name', 'Equatorial Guinea', 'plugin'),
(NULL, '69', 'pjCountry', '1', 'name', 'Eritrea', 'plugin'),
(NULL, '69', 'pjCountry', '2', 'name', 'Eritrea', 'plugin'),
(NULL, '69', 'pjCountry', '3', 'name', 'Eritrea', 'plugin'),
(NULL, '70', 'pjCountry', '1', 'name', 'Estonia', 'plugin'),
(NULL, '70', 'pjCountry', '2', 'name', 'Estonia', 'plugin'),
(NULL, '70', 'pjCountry', '3', 'name', 'Estonia', 'plugin'),
(NULL, '71', 'pjCountry', '1', 'name', 'Ethiopia', 'plugin'),
(NULL, '71', 'pjCountry', '2', 'name', 'Ethiopia', 'plugin'),
(NULL, '71', 'pjCountry', '3', 'name', 'Ethiopia', 'plugin'),
(NULL, '72', 'pjCountry', '1', 'name', 'Falkland Islands array(Malvinas)', 'plugin'),
(NULL, '72', 'pjCountry', '2', 'name', 'Falkland Islands array(Malvinas)', 'plugin'),
(NULL, '72', 'pjCountry', '3', 'name', 'Falkland Islands array(Malvinas)', 'plugin'),
(NULL, '73', 'pjCountry', '1', 'name', 'Faroe Islands', 'plugin'),
(NULL, '73', 'pjCountry', '2', 'name', 'Faroe Islands', 'plugin'),
(NULL, '73', 'pjCountry', '3', 'name', 'Faroe Islands', 'plugin'),
(NULL, '74', 'pjCountry', '1', 'name', 'Fiji', 'plugin'),
(NULL, '74', 'pjCountry', '2', 'name', 'Fiji', 'plugin'),
(NULL, '74', 'pjCountry', '3', 'name', 'Fiji', 'plugin'),
(NULL, '75', 'pjCountry', '1', 'name', 'Finland', 'plugin'),
(NULL, '75', 'pjCountry', '2', 'name', 'Finland', 'plugin'),
(NULL, '75', 'pjCountry', '3', 'name', 'Finland', 'plugin'),
(NULL, '76', 'pjCountry', '1', 'name', 'France', 'plugin'),
(NULL, '76', 'pjCountry', '2', 'name', 'France', 'plugin'),
(NULL, '76', 'pjCountry', '3', 'name', 'France', 'plugin'),
(NULL, '77', 'pjCountry', '1', 'name', 'French Guiana', 'plugin'),
(NULL, '77', 'pjCountry', '2', 'name', 'French Guiana', 'plugin'),
(NULL, '77', 'pjCountry', '3', 'name', 'French Guiana', 'plugin'),
(NULL, '78', 'pjCountry', '1', 'name', 'French Polynesia', 'plugin'),
(NULL, '78', 'pjCountry', '2', 'name', 'French Polynesia', 'plugin'),
(NULL, '78', 'pjCountry', '3', 'name', 'French Polynesia', 'plugin'),
(NULL, '79', 'pjCountry', '1', 'name', 'French Southern Territories', 'plugin'),
(NULL, '79', 'pjCountry', '2', 'name', 'French Southern Territories', 'plugin'),
(NULL, '79', 'pjCountry', '3', 'name', 'French Southern Territories', 'plugin'),
(NULL, '80', 'pjCountry', '1', 'name', 'Gabon', 'plugin'),
(NULL, '80', 'pjCountry', '2', 'name', 'Gabon', 'plugin'),
(NULL, '80', 'pjCountry', '3', 'name', 'Gabon', 'plugin'),
(NULL, '81', 'pjCountry', '1', 'name', 'Gambia', 'plugin'),
(NULL, '81', 'pjCountry', '2', 'name', 'Gambia', 'plugin'),
(NULL, '81', 'pjCountry', '3', 'name', 'Gambia', 'plugin'),
(NULL, '82', 'pjCountry', '1', 'name', 'Georgia', 'plugin'),
(NULL, '82', 'pjCountry', '2', 'name', 'Georgia', 'plugin'),
(NULL, '82', 'pjCountry', '3', 'name', 'Georgia', 'plugin'),
(NULL, '83', 'pjCountry', '1', 'name', 'Germany', 'plugin'),
(NULL, '83', 'pjCountry', '2', 'name', 'Germany', 'plugin'),
(NULL, '83', 'pjCountry', '3', 'name', 'Germany', 'plugin'),
(NULL, '84', 'pjCountry', '1', 'name', 'Ghana', 'plugin'),
(NULL, '84', 'pjCountry', '2', 'name', 'Ghana', 'plugin'),
(NULL, '84', 'pjCountry', '3', 'name', 'Ghana', 'plugin'),
(NULL, '85', 'pjCountry', '1', 'name', 'Gibraltar', 'plugin'),
(NULL, '85', 'pjCountry', '2', 'name', 'Gibraltar', 'plugin'),
(NULL, '85', 'pjCountry', '3', 'name', 'Gibraltar', 'plugin'),
(NULL, '86', 'pjCountry', '1', 'name', 'Greece', 'plugin'),
(NULL, '86', 'pjCountry', '2', 'name', 'Greece', 'plugin'),
(NULL, '86', 'pjCountry', '3', 'name', 'Greece', 'plugin'),
(NULL, '87', 'pjCountry', '1', 'name', 'Greenland', 'plugin'),
(NULL, '87', 'pjCountry', '2', 'name', 'Greenland', 'plugin'),
(NULL, '87', 'pjCountry', '3', 'name', 'Greenland', 'plugin'),
(NULL, '88', 'pjCountry', '1', 'name', 'Grenada', 'plugin'),
(NULL, '88', 'pjCountry', '2', 'name', 'Grenada', 'plugin'),
(NULL, '88', 'pjCountry', '3', 'name', 'Grenada', 'plugin'),
(NULL, '89', 'pjCountry', '1', 'name', 'Guadeloupe', 'plugin'),
(NULL, '89', 'pjCountry', '2', 'name', 'Guadeloupe', 'plugin'),
(NULL, '89', 'pjCountry', '3', 'name', 'Guadeloupe', 'plugin'),
(NULL, '90', 'pjCountry', '1', 'name', 'Guam', 'plugin'),
(NULL, '90', 'pjCountry', '2', 'name', 'Guam', 'plugin'),
(NULL, '90', 'pjCountry', '3', 'name', 'Guam', 'plugin'),
(NULL, '91', 'pjCountry', '1', 'name', 'Guatemala', 'plugin'),
(NULL, '91', 'pjCountry', '2', 'name', 'Guatemala', 'plugin'),
(NULL, '91', 'pjCountry', '3', 'name', 'Guatemala', 'plugin'),
(NULL, '92', 'pjCountry', '1', 'name', 'Guernsey', 'plugin'),
(NULL, '92', 'pjCountry', '2', 'name', 'Guernsey', 'plugin'),
(NULL, '92', 'pjCountry', '3', 'name', 'Guernsey', 'plugin'),
(NULL, '93', 'pjCountry', '1', 'name', 'Guinea', 'plugin'),
(NULL, '93', 'pjCountry', '2', 'name', 'Guinea', 'plugin'),
(NULL, '93', 'pjCountry', '3', 'name', 'Guinea', 'plugin'),
(NULL, '94', 'pjCountry', '1', 'name', 'Guinea-Bissau', 'plugin'),
(NULL, '94', 'pjCountry', '2', 'name', 'Guinea-Bissau', 'plugin'),
(NULL, '94', 'pjCountry', '3', 'name', 'Guinea-Bissau', 'plugin'),
(NULL, '95', 'pjCountry', '1', 'name', 'Guyana', 'plugin'),
(NULL, '95', 'pjCountry', '2', 'name', 'Guyana', 'plugin'),
(NULL, '95', 'pjCountry', '3', 'name', 'Guyana', 'plugin'),
(NULL, '96', 'pjCountry', '1', 'name', 'Haiti', 'plugin'),
(NULL, '96', 'pjCountry', '2', 'name', 'Haiti', 'plugin'),
(NULL, '96', 'pjCountry', '3', 'name', 'Haiti', 'plugin'),
(NULL, '97', 'pjCountry', '1', 'name', 'Heard Island and McDonald Islands', 'plugin'),
(NULL, '97', 'pjCountry', '2', 'name', 'Heard Island and McDonald Islands', 'plugin'),
(NULL, '97', 'pjCountry', '3', 'name', 'Heard Island and McDonald Islands', 'plugin'),
(NULL, '98', 'pjCountry', '1', 'name', 'Holy See array(Vatican City State)', 'plugin'),
(NULL, '98', 'pjCountry', '2', 'name', 'Holy See array(Vatican City State)', 'plugin'),
(NULL, '98', 'pjCountry', '3', 'name', 'Holy See array(Vatican City State)', 'plugin'),
(NULL, '99', 'pjCountry', '1', 'name', 'Honduras', 'plugin'),
(NULL, '99', 'pjCountry', '2', 'name', 'Honduras', 'plugin'),
(NULL, '99', 'pjCountry', '3', 'name', 'Honduras', 'plugin'),
(NULL, '100', 'pjCountry', '1', 'name', 'Hong Kong', 'plugin'),
(NULL, '100', 'pjCountry', '2', 'name', 'Hong Kong', 'plugin'),
(NULL, '100', 'pjCountry', '3', 'name', 'Hong Kong', 'plugin'),
(NULL, '101', 'pjCountry', '1', 'name', 'Hungary', 'plugin'),
(NULL, '101', 'pjCountry', '2', 'name', 'Hungary', 'plugin'),
(NULL, '101', 'pjCountry', '3', 'name', 'Hungary', 'plugin'),
(NULL, '102', 'pjCountry', '1', 'name', 'Iceland', 'plugin'),
(NULL, '102', 'pjCountry', '2', 'name', 'Iceland', 'plugin'),
(NULL, '102', 'pjCountry', '3', 'name', 'Iceland', 'plugin'),
(NULL, '103', 'pjCountry', '1', 'name', 'India', 'plugin'),
(NULL, '103', 'pjCountry', '2', 'name', 'India', 'plugin'),
(NULL, '103', 'pjCountry', '3', 'name', 'India', 'plugin'),
(NULL, '104', 'pjCountry', '1', 'name', 'Indonesia', 'plugin'),
(NULL, '104', 'pjCountry', '2', 'name', 'Indonesia', 'plugin'),
(NULL, '104', 'pjCountry', '3', 'name', 'Indonesia', 'plugin'),
(NULL, '105', 'pjCountry', '1', 'name', 'Iran, Islamic Republic of', 'plugin'),
(NULL, '105', 'pjCountry', '2', 'name', 'Iran, Islamic Republic of', 'plugin'),
(NULL, '105', 'pjCountry', '3', 'name', 'Iran, Islamic Republic of', 'plugin'),
(NULL, '106', 'pjCountry', '1', 'name', 'Iraq', 'plugin'),
(NULL, '106', 'pjCountry', '2', 'name', 'Iraq', 'plugin'),
(NULL, '106', 'pjCountry', '3', 'name', 'Iraq', 'plugin'),
(NULL, '107', 'pjCountry', '1', 'name', 'Ireland', 'plugin'),
(NULL, '107', 'pjCountry', '2', 'name', 'Ireland', 'plugin'),
(NULL, '107', 'pjCountry', '3', 'name', 'Ireland', 'plugin'),
(NULL, '108', 'pjCountry', '1', 'name', 'Isle of Man', 'plugin'),
(NULL, '108', 'pjCountry', '2', 'name', 'Isle of Man', 'plugin'),
(NULL, '108', 'pjCountry', '3', 'name', 'Isle of Man', 'plugin'),
(NULL, '109', 'pjCountry', '1', 'name', 'Israel', 'plugin'),
(NULL, '109', 'pjCountry', '2', 'name', 'Israel', 'plugin'),
(NULL, '109', 'pjCountry', '3', 'name', 'Israel', 'plugin'),
(NULL, '110', 'pjCountry', '1', 'name', 'Italy', 'plugin'),
(NULL, '110', 'pjCountry', '2', 'name', 'Italy', 'plugin'),
(NULL, '110', 'pjCountry', '3', 'name', 'Italy', 'plugin'),
(NULL, '111', 'pjCountry', '1', 'name', 'Jamaica', 'plugin'),
(NULL, '111', 'pjCountry', '2', 'name', 'Jamaica', 'plugin'),
(NULL, '111', 'pjCountry', '3', 'name', 'Jamaica', 'plugin'),
(NULL, '112', 'pjCountry', '1', 'name', 'Japan', 'plugin'),
(NULL, '112', 'pjCountry', '2', 'name', 'Japan', 'plugin'),
(NULL, '112', 'pjCountry', '3', 'name', 'Japan', 'plugin'),
(NULL, '113', 'pjCountry', '1', 'name', 'Jersey', 'plugin'),
(NULL, '113', 'pjCountry', '2', 'name', 'Jersey', 'plugin'),
(NULL, '113', 'pjCountry', '3', 'name', 'Jersey', 'plugin'),
(NULL, '114', 'pjCountry', '1', 'name', 'Jordan', 'plugin'),
(NULL, '114', 'pjCountry', '2', 'name', 'Jordan', 'plugin'),
(NULL, '114', 'pjCountry', '3', 'name', 'Jordan', 'plugin'),
(NULL, '115', 'pjCountry', '1', 'name', 'Kazakhstan', 'plugin'),
(NULL, '115', 'pjCountry', '2', 'name', 'Kazakhstan', 'plugin'),
(NULL, '115', 'pjCountry', '3', 'name', 'Kazakhstan', 'plugin'),
(NULL, '116', 'pjCountry', '1', 'name', 'Kenya', 'plugin'),
(NULL, '116', 'pjCountry', '2', 'name', 'Kenya', 'plugin'),
(NULL, '116', 'pjCountry', '3', 'name', 'Kenya', 'plugin'),
(NULL, '117', 'pjCountry', '1', 'name', 'Kiribati', 'plugin'),
(NULL, '117', 'pjCountry', '2', 'name', 'Kiribati', 'plugin'),
(NULL, '117', 'pjCountry', '3', 'name', 'Kiribati', 'plugin'),
(NULL, '118', 'pjCountry', '1', 'name', 'Korea, Democratic People''s Republic of', 'plugin'),
(NULL, '118', 'pjCountry', '2', 'name', 'Korea, Democratic People''s Republic of', 'plugin'),
(NULL, '118', 'pjCountry', '3', 'name', 'Korea, Democratic People''s Republic of', 'plugin'),
(NULL, '119', 'pjCountry', '1', 'name', 'Korea, Republic of', 'plugin'),
(NULL, '119', 'pjCountry', '2', 'name', 'Korea, Republic of', 'plugin'),
(NULL, '119', 'pjCountry', '3', 'name', 'Korea, Republic of', 'plugin'),
(NULL, '120', 'pjCountry', '1', 'name', 'Kuwait', 'plugin'),
(NULL, '120', 'pjCountry', '2', 'name', 'Kuwait', 'plugin'),
(NULL, '120', 'pjCountry', '3', 'name', 'Kuwait', 'plugin'),
(NULL, '121', 'pjCountry', '1', 'name', 'Kyrgyzstan', 'plugin'),
(NULL, '121', 'pjCountry', '2', 'name', 'Kyrgyzstan', 'plugin'),
(NULL, '121', 'pjCountry', '3', 'name', 'Kyrgyzstan', 'plugin'),
(NULL, '122', 'pjCountry', '1', 'name', 'Lao People''s Democratic Republic', 'plugin'),
(NULL, '122', 'pjCountry', '2', 'name', 'Lao People''s Democratic Republic', 'plugin'),
(NULL, '122', 'pjCountry', '3', 'name', 'Lao People''s Democratic Republic', 'plugin'),
(NULL, '123', 'pjCountry', '1', 'name', 'Latvia', 'plugin'),
(NULL, '123', 'pjCountry', '2', 'name', 'Latvia', 'plugin'),
(NULL, '123', 'pjCountry', '3', 'name', 'Latvia', 'plugin'),
(NULL, '124', 'pjCountry', '1', 'name', 'Lebanon', 'plugin'),
(NULL, '124', 'pjCountry', '2', 'name', 'Lebanon', 'plugin'),
(NULL, '124', 'pjCountry', '3', 'name', 'Lebanon', 'plugin'),
(NULL, '125', 'pjCountry', '1', 'name', 'Lesotho', 'plugin'),
(NULL, '125', 'pjCountry', '2', 'name', 'Lesotho', 'plugin'),
(NULL, '125', 'pjCountry', '3', 'name', 'Lesotho', 'plugin'),
(NULL, '126', 'pjCountry', '1', 'name', 'Liberia', 'plugin'),
(NULL, '126', 'pjCountry', '2', 'name', 'Liberia', 'plugin'),
(NULL, '126', 'pjCountry', '3', 'name', 'Liberia', 'plugin'),
(NULL, '127', 'pjCountry', '1', 'name', 'Libya', 'plugin'),
(NULL, '127', 'pjCountry', '2', 'name', 'Libya', 'plugin'),
(NULL, '127', 'pjCountry', '3', 'name', 'Libya', 'plugin'),
(NULL, '128', 'pjCountry', '1', 'name', 'Liechtenstein', 'plugin'),
(NULL, '128', 'pjCountry', '2', 'name', 'Liechtenstein', 'plugin'),
(NULL, '128', 'pjCountry', '3', 'name', 'Liechtenstein', 'plugin'),
(NULL, '129', 'pjCountry', '1', 'name', 'Lithuania', 'plugin'),
(NULL, '129', 'pjCountry', '2', 'name', 'Lithuania', 'plugin'),
(NULL, '129', 'pjCountry', '3', 'name', 'Lithuania', 'plugin'),
(NULL, '130', 'pjCountry', '1', 'name', 'Luxembourg', 'plugin'),
(NULL, '130', 'pjCountry', '2', 'name', 'Luxembourg', 'plugin'),
(NULL, '130', 'pjCountry', '3', 'name', 'Luxembourg', 'plugin'),
(NULL, '131', 'pjCountry', '1', 'name', 'Macao', 'plugin'),
(NULL, '131', 'pjCountry', '2', 'name', 'Macao', 'plugin'),
(NULL, '131', 'pjCountry', '3', 'name', 'Macao', 'plugin'),
(NULL, '132', 'pjCountry', '1', 'name', 'Macedonia, The Former Yugoslav Republic of', 'plugin'),
(NULL, '132', 'pjCountry', '2', 'name', 'Macedonia, The Former Yugoslav Republic of', 'plugin'),
(NULL, '132', 'pjCountry', '3', 'name', 'Macedonia, The Former Yugoslav Republic of', 'plugin'),
(NULL, '133', 'pjCountry', '1', 'name', 'Madagascar', 'plugin'),
(NULL, '133', 'pjCountry', '2', 'name', 'Madagascar', 'plugin'),
(NULL, '133', 'pjCountry', '3', 'name', 'Madagascar', 'plugin'),
(NULL, '134', 'pjCountry', '1', 'name', 'Malawi', 'plugin'),
(NULL, '134', 'pjCountry', '2', 'name', 'Malawi', 'plugin'),
(NULL, '134', 'pjCountry', '3', 'name', 'Malawi', 'plugin'),
(NULL, '135', 'pjCountry', '1', 'name', 'Malaysia', 'plugin'),
(NULL, '135', 'pjCountry', '2', 'name', 'Malaysia', 'plugin'),
(NULL, '135', 'pjCountry', '3', 'name', 'Malaysia', 'plugin'),
(NULL, '136', 'pjCountry', '1', 'name', 'Maldives', 'plugin'),
(NULL, '136', 'pjCountry', '2', 'name', 'Maldives', 'plugin'),
(NULL, '136', 'pjCountry', '3', 'name', 'Maldives', 'plugin'),
(NULL, '137', 'pjCountry', '1', 'name', 'Mali', 'plugin'),
(NULL, '137', 'pjCountry', '2', 'name', 'Mali', 'plugin'),
(NULL, '137', 'pjCountry', '3', 'name', 'Mali', 'plugin'),
(NULL, '138', 'pjCountry', '1', 'name', 'Malta', 'plugin'),
(NULL, '138', 'pjCountry', '2', 'name', 'Malta', 'plugin'),
(NULL, '138', 'pjCountry', '3', 'name', 'Malta', 'plugin'),
(NULL, '139', 'pjCountry', '1', 'name', 'Marshall Islands', 'plugin'),
(NULL, '139', 'pjCountry', '2', 'name', 'Marshall Islands', 'plugin'),
(NULL, '139', 'pjCountry', '3', 'name', 'Marshall Islands', 'plugin'),
(NULL, '140', 'pjCountry', '1', 'name', 'Martinique', 'plugin'),
(NULL, '140', 'pjCountry', '2', 'name', 'Martinique', 'plugin'),
(NULL, '140', 'pjCountry', '3', 'name', 'Martinique', 'plugin'),
(NULL, '141', 'pjCountry', '1', 'name', 'Mauritania', 'plugin'),
(NULL, '141', 'pjCountry', '2', 'name', 'Mauritania', 'plugin'),
(NULL, '141', 'pjCountry', '3', 'name', 'Mauritania', 'plugin'),
(NULL, '142', 'pjCountry', '1', 'name', 'Mauritius', 'plugin'),
(NULL, '142', 'pjCountry', '2', 'name', 'Mauritius', 'plugin'),
(NULL, '142', 'pjCountry', '3', 'name', 'Mauritius', 'plugin'),
(NULL, '143', 'pjCountry', '1', 'name', 'Mayotte', 'plugin'),
(NULL, '143', 'pjCountry', '2', 'name', 'Mayotte', 'plugin'),
(NULL, '143', 'pjCountry', '3', 'name', 'Mayotte', 'plugin'),
(NULL, '144', 'pjCountry', '1', 'name', 'Mexico', 'plugin'),
(NULL, '144', 'pjCountry', '2', 'name', 'Mexico', 'plugin'),
(NULL, '144', 'pjCountry', '3', 'name', 'Mexico', 'plugin'),
(NULL, '145', 'pjCountry', '1', 'name', 'Micronesia, Federated States of', 'plugin'),
(NULL, '145', 'pjCountry', '2', 'name', 'Micronesia, Federated States of', 'plugin'),
(NULL, '145', 'pjCountry', '3', 'name', 'Micronesia, Federated States of', 'plugin'),
(NULL, '146', 'pjCountry', '1', 'name', 'Moldova, Republic of', 'plugin'),
(NULL, '146', 'pjCountry', '2', 'name', 'Moldova, Republic of', 'plugin'),
(NULL, '146', 'pjCountry', '3', 'name', 'Moldova, Republic of', 'plugin'),
(NULL, '147', 'pjCountry', '1', 'name', 'Monaco', 'plugin'),
(NULL, '147', 'pjCountry', '2', 'name', 'Monaco', 'plugin'),
(NULL, '147', 'pjCountry', '3', 'name', 'Monaco', 'plugin'),
(NULL, '148', 'pjCountry', '1', 'name', 'Mongolia', 'plugin'),
(NULL, '148', 'pjCountry', '2', 'name', 'Mongolia', 'plugin'),
(NULL, '148', 'pjCountry', '3', 'name', 'Mongolia', 'plugin'),
(NULL, '149', 'pjCountry', '1', 'name', 'Montenegro', 'plugin'),
(NULL, '149', 'pjCountry', '2', 'name', 'Montenegro', 'plugin'),
(NULL, '149', 'pjCountry', '3', 'name', 'Montenegro', 'plugin'),
(NULL, '150', 'pjCountry', '1', 'name', 'Montserrat', 'plugin'),
(NULL, '150', 'pjCountry', '2', 'name', 'Montserrat', 'plugin'),
(NULL, '150', 'pjCountry', '3', 'name', 'Montserrat', 'plugin'),
(NULL, '151', 'pjCountry', '1', 'name', 'Morocco', 'plugin'),
(NULL, '151', 'pjCountry', '2', 'name', 'Morocco', 'plugin'),
(NULL, '151', 'pjCountry', '3', 'name', 'Morocco', 'plugin'),
(NULL, '152', 'pjCountry', '1', 'name', 'Mozambique', 'plugin'),
(NULL, '152', 'pjCountry', '2', 'name', 'Mozambique', 'plugin'),
(NULL, '152', 'pjCountry', '3', 'name', 'Mozambique', 'plugin'),
(NULL, '153', 'pjCountry', '1', 'name', 'Myanmar', 'plugin'),
(NULL, '153', 'pjCountry', '2', 'name', 'Myanmar', 'plugin'),
(NULL, '153', 'pjCountry', '3', 'name', 'Myanmar', 'plugin'),
(NULL, '154', 'pjCountry', '1', 'name', 'Namibia', 'plugin'),
(NULL, '154', 'pjCountry', '2', 'name', 'Namibia', 'plugin'),
(NULL, '154', 'pjCountry', '3', 'name', 'Namibia', 'plugin'),
(NULL, '155', 'pjCountry', '1', 'name', 'Nauru', 'plugin'),
(NULL, '155', 'pjCountry', '2', 'name', 'Nauru', 'plugin'),
(NULL, '155', 'pjCountry', '3', 'name', 'Nauru', 'plugin'),
(NULL, '156', 'pjCountry', '1', 'name', 'Nepal', 'plugin'),
(NULL, '156', 'pjCountry', '2', 'name', 'Nepal', 'plugin'),
(NULL, '156', 'pjCountry', '3', 'name', 'Nepal', 'plugin'),
(NULL, '157', 'pjCountry', '1', 'name', 'Netherlands', 'plugin'),
(NULL, '157', 'pjCountry', '2', 'name', 'Netherlands', 'plugin'),
(NULL, '157', 'pjCountry', '3', 'name', 'Netherlands', 'plugin'),
(NULL, '158', 'pjCountry', '1', 'name', 'New Caledonia', 'plugin'),
(NULL, '158', 'pjCountry', '2', 'name', 'New Caledonia', 'plugin'),
(NULL, '158', 'pjCountry', '3', 'name', 'New Caledonia', 'plugin'),
(NULL, '159', 'pjCountry', '1', 'name', 'New Zealand', 'plugin'),
(NULL, '159', 'pjCountry', '2', 'name', 'New Zealand', 'plugin'),
(NULL, '159', 'pjCountry', '3', 'name', 'New Zealand', 'plugin'),
(NULL, '160', 'pjCountry', '1', 'name', 'Nicaragua', 'plugin'),
(NULL, '160', 'pjCountry', '2', 'name', 'Nicaragua', 'plugin'),
(NULL, '160', 'pjCountry', '3', 'name', 'Nicaragua', 'plugin'),
(NULL, '161', 'pjCountry', '1', 'name', 'Niger', 'plugin'),
(NULL, '161', 'pjCountry', '2', 'name', 'Niger', 'plugin'),
(NULL, '161', 'pjCountry', '3', 'name', 'Niger', 'plugin'),
(NULL, '162', 'pjCountry', '1', 'name', 'Nigeria', 'plugin'),
(NULL, '162', 'pjCountry', '2', 'name', 'Nigeria', 'plugin'),
(NULL, '162', 'pjCountry', '3', 'name', 'Nigeria', 'plugin'),
(NULL, '163', 'pjCountry', '1', 'name', 'Niue', 'plugin'),
(NULL, '163', 'pjCountry', '2', 'name', 'Niue', 'plugin'),
(NULL, '163', 'pjCountry', '3', 'name', 'Niue', 'plugin'),
(NULL, '164', 'pjCountry', '1', 'name', 'Norfolk Island', 'plugin'),
(NULL, '164', 'pjCountry', '2', 'name', 'Norfolk Island', 'plugin'),
(NULL, '164', 'pjCountry', '3', 'name', 'Norfolk Island', 'plugin'),
(NULL, '165', 'pjCountry', '1', 'name', 'Northern Mariana Islands', 'plugin'),
(NULL, '165', 'pjCountry', '2', 'name', 'Northern Mariana Islands', 'plugin'),
(NULL, '165', 'pjCountry', '3', 'name', 'Northern Mariana Islands', 'plugin'),
(NULL, '166', 'pjCountry', '1', 'name', 'Norway', 'plugin'),
(NULL, '166', 'pjCountry', '2', 'name', 'Norway', 'plugin'),
(NULL, '166', 'pjCountry', '3', 'name', 'Norway', 'plugin'),
(NULL, '167', 'pjCountry', '1', 'name', 'Oman', 'plugin'),
(NULL, '167', 'pjCountry', '2', 'name', 'Oman', 'plugin'),
(NULL, '167', 'pjCountry', '3', 'name', 'Oman', 'plugin'),
(NULL, '168', 'pjCountry', '1', 'name', 'Pakistan', 'plugin'),
(NULL, '168', 'pjCountry', '2', 'name', 'Pakistan', 'plugin'),
(NULL, '168', 'pjCountry', '3', 'name', 'Pakistan', 'plugin'),
(NULL, '169', 'pjCountry', '1', 'name', 'Palau', 'plugin'),
(NULL, '169', 'pjCountry', '2', 'name', 'Palau', 'plugin'),
(NULL, '169', 'pjCountry', '3', 'name', 'Palau', 'plugin'),
(NULL, '170', 'pjCountry', '1', 'name', 'Palestine, State of', 'plugin'),
(NULL, '170', 'pjCountry', '2', 'name', 'Palestine, State of', 'plugin'),
(NULL, '170', 'pjCountry', '3', 'name', 'Palestine, State of', 'plugin'),
(NULL, '171', 'pjCountry', '1', 'name', 'Panama', 'plugin'),
(NULL, '171', 'pjCountry', '2', 'name', 'Panama', 'plugin'),
(NULL, '171', 'pjCountry', '3', 'name', 'Panama', 'plugin'),
(NULL, '172', 'pjCountry', '1', 'name', 'Papua New Guinea', 'plugin'),
(NULL, '172', 'pjCountry', '2', 'name', 'Papua New Guinea', 'plugin'),
(NULL, '172', 'pjCountry', '3', 'name', 'Papua New Guinea', 'plugin'),
(NULL, '173', 'pjCountry', '1', 'name', 'Paraguay', 'plugin'),
(NULL, '173', 'pjCountry', '2', 'name', 'Paraguay', 'plugin'),
(NULL, '173', 'pjCountry', '3', 'name', 'Paraguay', 'plugin'),
(NULL, '174', 'pjCountry', '1', 'name', 'Peru', 'plugin'),
(NULL, '174', 'pjCountry', '2', 'name', 'Peru', 'plugin'),
(NULL, '174', 'pjCountry', '3', 'name', 'Peru', 'plugin'),
(NULL, '175', 'pjCountry', '1', 'name', 'Philippines', 'plugin'),
(NULL, '175', 'pjCountry', '2', 'name', 'Philippines', 'plugin'),
(NULL, '175', 'pjCountry', '3', 'name', 'Philippines', 'plugin'),
(NULL, '176', 'pjCountry', '1', 'name', 'Pitcairn', 'plugin'),
(NULL, '176', 'pjCountry', '2', 'name', 'Pitcairn', 'plugin'),
(NULL, '176', 'pjCountry', '3', 'name', 'Pitcairn', 'plugin'),
(NULL, '177', 'pjCountry', '1', 'name', 'Poland', 'plugin'),
(NULL, '177', 'pjCountry', '2', 'name', 'Poland', 'plugin'),
(NULL, '177', 'pjCountry', '3', 'name', 'Poland', 'plugin'),
(NULL, '178', 'pjCountry', '1', 'name', 'Portugal', 'plugin'),
(NULL, '178', 'pjCountry', '2', 'name', 'Portugal', 'plugin'),
(NULL, '178', 'pjCountry', '3', 'name', 'Portugal', 'plugin'),
(NULL, '179', 'pjCountry', '1', 'name', 'Puerto Rico', 'plugin'),
(NULL, '179', 'pjCountry', '2', 'name', 'Puerto Rico', 'plugin'),
(NULL, '179', 'pjCountry', '3', 'name', 'Puerto Rico', 'plugin'),
(NULL, '180', 'pjCountry', '1', 'name', 'Qatar', 'plugin'),
(NULL, '180', 'pjCountry', '2', 'name', 'Qatar', 'plugin'),
(NULL, '180', 'pjCountry', '3', 'name', 'Qatar', 'plugin'),
(NULL, '181', 'pjCountry', '1', 'name', 'Réunion', 'plugin'),
(NULL, '181', 'pjCountry', '2', 'name', 'Réunion', 'plugin'),
(NULL, '181', 'pjCountry', '3', 'name', 'Réunion', 'plugin'),
(NULL, '182', 'pjCountry', '1', 'name', 'Romania', 'plugin'),
(NULL, '182', 'pjCountry', '2', 'name', 'Romania', 'plugin'),
(NULL, '182', 'pjCountry', '3', 'name', 'Romania', 'plugin'),
(NULL, '183', 'pjCountry', '1', 'name', 'Russian Federation', 'plugin'),
(NULL, '183', 'pjCountry', '2', 'name', 'Russian Federation', 'plugin'),
(NULL, '183', 'pjCountry', '3', 'name', 'Russian Federation', 'plugin'),
(NULL, '184', 'pjCountry', '1', 'name', 'Rwanda', 'plugin'),
(NULL, '184', 'pjCountry', '2', 'name', 'Rwanda', 'plugin'),
(NULL, '184', 'pjCountry', '3', 'name', 'Rwanda', 'plugin'),
(NULL, '185', 'pjCountry', '1', 'name', 'Saint Barthélemy', 'plugin'),
(NULL, '185', 'pjCountry', '2', 'name', 'Saint Barthélemy', 'plugin'),
(NULL, '185', 'pjCountry', '3', 'name', 'Saint Barthélemy', 'plugin'),
(NULL, '186', 'pjCountry', '1', 'name', 'Saint Helena, Ascension and Tristan da Cunha', 'plugin'),
(NULL, '186', 'pjCountry', '2', 'name', 'Saint Helena, Ascension and Tristan da Cunha', 'plugin'),
(NULL, '186', 'pjCountry', '3', 'name', 'Saint Helena, Ascension and Tristan da Cunha', 'plugin'),
(NULL, '187', 'pjCountry', '1', 'name', 'Saint Kitts and Nevis', 'plugin'),
(NULL, '187', 'pjCountry', '2', 'name', 'Saint Kitts and Nevis', 'plugin'),
(NULL, '187', 'pjCountry', '3', 'name', 'Saint Kitts and Nevis', 'plugin'),
(NULL, '188', 'pjCountry', '1', 'name', 'Saint Lucia', 'plugin'),
(NULL, '188', 'pjCountry', '2', 'name', 'Saint Lucia', 'plugin'),
(NULL, '188', 'pjCountry', '3', 'name', 'Saint Lucia', 'plugin'),
(NULL, '189', 'pjCountry', '1', 'name', 'Saint Martin array(French part)', 'plugin'),
(NULL, '189', 'pjCountry', '2', 'name', 'Saint Martin array(French part)', 'plugin'),
(NULL, '189', 'pjCountry', '3', 'name', 'Saint Martin array(French part)', 'plugin'),
(NULL, '190', 'pjCountry', '1', 'name', 'Saint Pierre and Miquelon', 'plugin'),
(NULL, '190', 'pjCountry', '2', 'name', 'Saint Pierre and Miquelon', 'plugin'),
(NULL, '190', 'pjCountry', '3', 'name', 'Saint Pierre and Miquelon', 'plugin'),
(NULL, '191', 'pjCountry', '1', 'name', 'Saint Vincent and the Grenadines', 'plugin'),
(NULL, '191', 'pjCountry', '2', 'name', 'Saint Vincent and the Grenadines', 'plugin'),
(NULL, '191', 'pjCountry', '3', 'name', 'Saint Vincent and the Grenadines', 'plugin'),
(NULL, '192', 'pjCountry', '1', 'name', 'Samoa', 'plugin'),
(NULL, '192', 'pjCountry', '2', 'name', 'Samoa', 'plugin'),
(NULL, '192', 'pjCountry', '3', 'name', 'Samoa', 'plugin'),
(NULL, '193', 'pjCountry', '1', 'name', 'San Marino', 'plugin'),
(NULL, '193', 'pjCountry', '2', 'name', 'San Marino', 'plugin'),
(NULL, '193', 'pjCountry', '3', 'name', 'San Marino', 'plugin'),
(NULL, '194', 'pjCountry', '1', 'name', 'Sao Tome and Principe', 'plugin'),
(NULL, '194', 'pjCountry', '2', 'name', 'Sao Tome and Principe', 'plugin'),
(NULL, '194', 'pjCountry', '3', 'name', 'Sao Tome and Principe', 'plugin'),
(NULL, '195', 'pjCountry', '1', 'name', 'Saudi Arabia', 'plugin'),
(NULL, '195', 'pjCountry', '2', 'name', 'Saudi Arabia', 'plugin'),
(NULL, '195', 'pjCountry', '3', 'name', 'Saudi Arabia', 'plugin'),
(NULL, '196', 'pjCountry', '1', 'name', 'Senegal', 'plugin'),
(NULL, '196', 'pjCountry', '2', 'name', 'Senegal', 'plugin'),
(NULL, '196', 'pjCountry', '3', 'name', 'Senegal', 'plugin'),
(NULL, '197', 'pjCountry', '1', 'name', 'Serbia', 'plugin'),
(NULL, '197', 'pjCountry', '2', 'name', 'Serbia', 'plugin'),
(NULL, '197', 'pjCountry', '3', 'name', 'Serbia', 'plugin'),
(NULL, '198', 'pjCountry', '1', 'name', 'Seychelles', 'plugin'),
(NULL, '198', 'pjCountry', '2', 'name', 'Seychelles', 'plugin'),
(NULL, '198', 'pjCountry', '3', 'name', 'Seychelles', 'plugin'),
(NULL, '199', 'pjCountry', '1', 'name', 'Sierra Leone', 'plugin'),
(NULL, '199', 'pjCountry', '2', 'name', 'Sierra Leone', 'plugin'),
(NULL, '199', 'pjCountry', '3', 'name', 'Sierra Leone', 'plugin'),
(NULL, '200', 'pjCountry', '1', 'name', 'Singapore', 'plugin'),
(NULL, '200', 'pjCountry', '2', 'name', 'Singapore', 'plugin'),
(NULL, '200', 'pjCountry', '3', 'name', 'Singapore', 'plugin'),
(NULL, '201', 'pjCountry', '1', 'name', 'Sint Maarten array(Dutch part)', 'plugin'),
(NULL, '201', 'pjCountry', '2', 'name', 'Sint Maarten array(Dutch part)', 'plugin'),
(NULL, '201', 'pjCountry', '3', 'name', 'Sint Maarten array(Dutch part)', 'plugin'),
(NULL, '202', 'pjCountry', '1', 'name', 'Slovakia', 'plugin'),
(NULL, '202', 'pjCountry', '2', 'name', 'Slovakia', 'plugin'),
(NULL, '202', 'pjCountry', '3', 'name', 'Slovakia', 'plugin'),
(NULL, '203', 'pjCountry', '1', 'name', 'Slovenia', 'plugin'),
(NULL, '203', 'pjCountry', '2', 'name', 'Slovenia', 'plugin'),
(NULL, '203', 'pjCountry', '3', 'name', 'Slovenia', 'plugin'),
(NULL, '204', 'pjCountry', '1', 'name', 'Solomon Islands', 'plugin'),
(NULL, '204', 'pjCountry', '2', 'name', 'Solomon Islands', 'plugin'),
(NULL, '204', 'pjCountry', '3', 'name', 'Solomon Islands', 'plugin'),
(NULL, '205', 'pjCountry', '1', 'name', 'Somalia', 'plugin'),
(NULL, '205', 'pjCountry', '2', 'name', 'Somalia', 'plugin'),
(NULL, '205', 'pjCountry', '3', 'name', 'Somalia', 'plugin'),
(NULL, '206', 'pjCountry', '1', 'name', 'South Africa', 'plugin'),
(NULL, '206', 'pjCountry', '2', 'name', 'South Africa', 'plugin'),
(NULL, '206', 'pjCountry', '3', 'name', 'South Africa', 'plugin'),
(NULL, '207', 'pjCountry', '1', 'name', 'South Georgia and the South Sandwich Islands', 'plugin'),
(NULL, '207', 'pjCountry', '2', 'name', 'South Georgia and the South Sandwich Islands', 'plugin'),
(NULL, '207', 'pjCountry', '3', 'name', 'South Georgia and the South Sandwich Islands', 'plugin'),
(NULL, '208', 'pjCountry', '1', 'name', 'South Sudan', 'plugin'),
(NULL, '208', 'pjCountry', '2', 'name', 'South Sudan', 'plugin'),
(NULL, '208', 'pjCountry', '3', 'name', 'South Sudan', 'plugin'),
(NULL, '209', 'pjCountry', '1', 'name', 'Spain', 'plugin'),
(NULL, '209', 'pjCountry', '2', 'name', 'Spain', 'plugin'),
(NULL, '209', 'pjCountry', '3', 'name', 'Spain', 'plugin'),
(NULL, '210', 'pjCountry', '1', 'name', 'Sri Lanka', 'plugin'),
(NULL, '210', 'pjCountry', '2', 'name', 'Sri Lanka', 'plugin'),
(NULL, '210', 'pjCountry', '3', 'name', 'Sri Lanka', 'plugin'),
(NULL, '211', 'pjCountry', '1', 'name', 'Sudan', 'plugin'),
(NULL, '211', 'pjCountry', '2', 'name', 'Sudan', 'plugin'),
(NULL, '211', 'pjCountry', '3', 'name', 'Sudan', 'plugin'),
(NULL, '212', 'pjCountry', '1', 'name', 'Suriname', 'plugin'),
(NULL, '212', 'pjCountry', '2', 'name', 'Suriname', 'plugin'),
(NULL, '212', 'pjCountry', '3', 'name', 'Suriname', 'plugin'),
(NULL, '213', 'pjCountry', '1', 'name', 'Svalbard and Jan Mayen', 'plugin'),
(NULL, '213', 'pjCountry', '2', 'name', 'Svalbard and Jan Mayen', 'plugin'),
(NULL, '213', 'pjCountry', '3', 'name', 'Svalbard and Jan Mayen', 'plugin'),
(NULL, '214', 'pjCountry', '1', 'name', 'Swaziland', 'plugin'),
(NULL, '214', 'pjCountry', '2', 'name', 'Swaziland', 'plugin'),
(NULL, '214', 'pjCountry', '3', 'name', 'Swaziland', 'plugin'),
(NULL, '215', 'pjCountry', '1', 'name', 'Sweden', 'plugin'),
(NULL, '215', 'pjCountry', '2', 'name', 'Sweden', 'plugin'),
(NULL, '215', 'pjCountry', '3', 'name', 'Sweden', 'plugin'),
(NULL, '216', 'pjCountry', '1', 'name', 'Switzerland', 'plugin'),
(NULL, '216', 'pjCountry', '2', 'name', 'Switzerland', 'plugin'),
(NULL, '216', 'pjCountry', '3', 'name', 'Switzerland', 'plugin'),
(NULL, '217', 'pjCountry', '1', 'name', 'Syrian Arab Republic', 'plugin'),
(NULL, '217', 'pjCountry', '2', 'name', 'Syrian Arab Republic', 'plugin'),
(NULL, '217', 'pjCountry', '3', 'name', 'Syrian Arab Republic', 'plugin'),
(NULL, '218', 'pjCountry', '1', 'name', 'Taiwan, Province of China', 'plugin'),
(NULL, '218', 'pjCountry', '2', 'name', 'Taiwan, Province of China', 'plugin'),
(NULL, '218', 'pjCountry', '3', 'name', 'Taiwan, Province of China', 'plugin'),
(NULL, '219', 'pjCountry', '1', 'name', 'Tajikistan', 'plugin'),
(NULL, '219', 'pjCountry', '2', 'name', 'Tajikistan', 'plugin'),
(NULL, '219', 'pjCountry', '3', 'name', 'Tajikistan', 'plugin'),
(NULL, '220', 'pjCountry', '1', 'name', 'Tanzania, United Republic of', 'plugin'),
(NULL, '220', 'pjCountry', '2', 'name', 'Tanzania, United Republic of', 'plugin'),
(NULL, '220', 'pjCountry', '3', 'name', 'Tanzania, United Republic of', 'plugin'),
(NULL, '221', 'pjCountry', '1', 'name', 'Thailand', 'plugin'),
(NULL, '221', 'pjCountry', '2', 'name', 'Thailand', 'plugin'),
(NULL, '221', 'pjCountry', '3', 'name', 'Thailand', 'plugin'),
(NULL, '222', 'pjCountry', '1', 'name', 'Timor-Leste', 'plugin'),
(NULL, '222', 'pjCountry', '2', 'name', 'Timor-Leste', 'plugin'),
(NULL, '222', 'pjCountry', '3', 'name', 'Timor-Leste', 'plugin'),
(NULL, '223', 'pjCountry', '1', 'name', 'Togo', 'plugin'),
(NULL, '223', 'pjCountry', '2', 'name', 'Togo', 'plugin'),
(NULL, '223', 'pjCountry', '3', 'name', 'Togo', 'plugin'),
(NULL, '224', 'pjCountry', '1', 'name', 'Tokelau', 'plugin'),
(NULL, '224', 'pjCountry', '2', 'name', 'Tokelau', 'plugin'),
(NULL, '224', 'pjCountry', '3', 'name', 'Tokelau', 'plugin'),
(NULL, '225', 'pjCountry', '1', 'name', 'Tonga', 'plugin'),
(NULL, '225', 'pjCountry', '2', 'name', 'Tonga', 'plugin'),
(NULL, '225', 'pjCountry', '3', 'name', 'Tonga', 'plugin'),
(NULL, '226', 'pjCountry', '1', 'name', 'Trinidad and Tobago', 'plugin'),
(NULL, '226', 'pjCountry', '2', 'name', 'Trinidad and Tobago', 'plugin'),
(NULL, '226', 'pjCountry', '3', 'name', 'Trinidad and Tobago', 'plugin'),
(NULL, '227', 'pjCountry', '1', 'name', 'Tunisia', 'plugin'),
(NULL, '227', 'pjCountry', '2', 'name', 'Tunisia', 'plugin'),
(NULL, '227', 'pjCountry', '3', 'name', 'Tunisia', 'plugin'),
(NULL, '228', 'pjCountry', '1', 'name', 'Turkey', 'plugin'),
(NULL, '228', 'pjCountry', '2', 'name', 'Turkey', 'plugin'),
(NULL, '228', 'pjCountry', '3', 'name', 'Turkey', 'plugin'),
(NULL, '229', 'pjCountry', '1', 'name', 'Turkmenistan', 'plugin'),
(NULL, '229', 'pjCountry', '2', 'name', 'Turkmenistan', 'plugin'),
(NULL, '229', 'pjCountry', '3', 'name', 'Turkmenistan', 'plugin'),
(NULL, '230', 'pjCountry', '1', 'name', 'Turks and Caicos Islands', 'plugin'),
(NULL, '230', 'pjCountry', '2', 'name', 'Turks and Caicos Islands', 'plugin'),
(NULL, '230', 'pjCountry', '3', 'name', 'Turks and Caicos Islands', 'plugin'),
(NULL, '231', 'pjCountry', '1', 'name', 'Tuvalu', 'plugin'),
(NULL, '231', 'pjCountry', '2', 'name', 'Tuvalu', 'plugin'),
(NULL, '231', 'pjCountry', '3', 'name', 'Tuvalu', 'plugin'),
(NULL, '232', 'pjCountry', '1', 'name', 'Uganda', 'plugin'),
(NULL, '232', 'pjCountry', '2', 'name', 'Uganda', 'plugin'),
(NULL, '232', 'pjCountry', '3', 'name', 'Uganda', 'plugin'),
(NULL, '233', 'pjCountry', '1', 'name', 'Ukraine', 'plugin'),
(NULL, '233', 'pjCountry', '2', 'name', 'Ukraine', 'plugin'),
(NULL, '233', 'pjCountry', '3', 'name', 'Ukraine', 'plugin'),
(NULL, '234', 'pjCountry', '1', 'name', 'United Arab Emirates', 'plugin'),
(NULL, '234', 'pjCountry', '2', 'name', 'United Arab Emirates', 'plugin'),
(NULL, '234', 'pjCountry', '3', 'name', 'United Arab Emirates', 'plugin'),
(NULL, '235', 'pjCountry', '1', 'name', 'United Kingdom', 'plugin'),
(NULL, '235', 'pjCountry', '2', 'name', 'United Kingdom', 'plugin'),
(NULL, '235', 'pjCountry', '3', 'name', 'United Kingdom', 'plugin'),
(NULL, '236', 'pjCountry', '1', 'name', 'United States', 'plugin'),
(NULL, '236', 'pjCountry', '2', 'name', 'United States', 'plugin'),
(NULL, '236', 'pjCountry', '3', 'name', 'United States', 'plugin'),
(NULL, '237', 'pjCountry', '1', 'name', 'United States Minor Outlying Islands', 'plugin'),
(NULL, '237', 'pjCountry', '2', 'name', 'United States Minor Outlying Islands', 'plugin'),
(NULL, '237', 'pjCountry', '3', 'name', 'United States Minor Outlying Islands', 'plugin'),
(NULL, '238', 'pjCountry', '1', 'name', 'Uruguay', 'plugin'),
(NULL, '238', 'pjCountry', '2', 'name', 'Uruguay', 'plugin'),
(NULL, '238', 'pjCountry', '3', 'name', 'Uruguay', 'plugin'),
(NULL, '239', 'pjCountry', '1', 'name', 'Uzbekistan', 'plugin'),
(NULL, '239', 'pjCountry', '2', 'name', 'Uzbekistan', 'plugin'),
(NULL, '239', 'pjCountry', '3', 'name', 'Uzbekistan', 'plugin'),
(NULL, '240', 'pjCountry', '1', 'name', 'Vanuatu', 'plugin'),
(NULL, '240', 'pjCountry', '2', 'name', 'Vanuatu', 'plugin'),
(NULL, '240', 'pjCountry', '3', 'name', 'Vanuatu', 'plugin'),
(NULL, '241', 'pjCountry', '1', 'name', 'Venezuela, Bolivarian Republic of', 'plugin'),
(NULL, '241', 'pjCountry', '2', 'name', 'Venezuela, Bolivarian Republic of', 'plugin'),
(NULL, '241', 'pjCountry', '3', 'name', 'Venezuela, Bolivarian Republic of', 'plugin'),
(NULL, '242', 'pjCountry', '1', 'name', 'Viet Nam', 'plugin'),
(NULL, '242', 'pjCountry', '2', 'name', 'Viet Nam', 'plugin'),
(NULL, '242', 'pjCountry', '3', 'name', 'Viet Nam', 'plugin'),
(NULL, '243', 'pjCountry', '1', 'name', 'Virgin Islands, British', 'plugin'),
(NULL, '243', 'pjCountry', '2', 'name', 'Virgin Islands, British', 'plugin'),
(NULL, '243', 'pjCountry', '3', 'name', 'Virgin Islands, British', 'plugin'),
(NULL, '244', 'pjCountry', '1', 'name', 'Virgin Islands, U.S.', 'plugin'),
(NULL, '244', 'pjCountry', '2', 'name', 'Virgin Islands, U.S.', 'plugin'),
(NULL, '244', 'pjCountry', '3', 'name', 'Virgin Islands, U.S.', 'plugin'),
(NULL, '245', 'pjCountry', '1', 'name', 'Wallis and Futuna', 'plugin'),
(NULL, '245', 'pjCountry', '2', 'name', 'Wallis and Futuna', 'plugin'),
(NULL, '245', 'pjCountry', '3', 'name', 'Wallis and Futuna', 'plugin'),
(NULL, '246', 'pjCountry', '1', 'name', 'Western Sahara', 'plugin'),
(NULL, '246', 'pjCountry', '2', 'name', 'Western Sahara', 'plugin'),
(NULL, '246', 'pjCountry', '3', 'name', 'Western Sahara', 'plugin'),
(NULL, '247', 'pjCountry', '1', 'name', 'Yemen', 'plugin'),
(NULL, '247', 'pjCountry', '2', 'name', 'Yemen', 'plugin'),
(NULL, '247', 'pjCountry', '3', 'name', 'Yemen', 'plugin'),
(NULL, '248', 'pjCountry', '1', 'name', 'Zambia', 'plugin'),
(NULL, '248', 'pjCountry', '2', 'name', 'Zambia', 'plugin'),
(NULL, '248', 'pjCountry', '3', 'name', 'Zambia', 'plugin'),
(NULL, '249', 'pjCountry', '1', 'name', 'Zimbabwe', 'plugin'),
(NULL, '249', 'pjCountry', '2', 'name', 'Zimbabwe', 'plugin'),
(NULL, '249', 'pjCountry', '3', 'name', 'Zimbabwe', 'plugin');