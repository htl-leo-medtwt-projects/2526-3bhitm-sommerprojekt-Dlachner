-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db_server
-- Erstellungszeit: 15. Jun 2026 um 15:09
-- Server-Version: 9.4.0
-- PHP-Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `produkt_db`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `accessories`
--

CREATE TABLE `accessories` (
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `accessories`
--

INSERT INTO `accessories` (`product_id`) VALUES
(86),
(87),
(88),
(89),
(90),
(91);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bearings`
--

CREATE TABLE `bearings` (
  `product_id` int NOT NULL,
  `material` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `bearings`
--

INSERT INTO `bearings` (`product_id`, `material`) VALUES
(61, 'Bearings Steel'),
(62, 'Bearings Steel'),
(63, 'Bearings Steel'),
(64, 'Bearings Steel'),
(65, 'Bearings Steel'),
(66, 'Bearings Steel'),
(67, 'Ceramic'),
(68, 'Ceramic'),
(69, 'Ceramic'),
(70, 'Ceramic'),
(71, 'Ceranium'),
(72, 'Bearings Steel');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellung`
--

CREATE TABLE `bestellung` (
  `bestellung_id` int NOT NULL,
  `user_id` int NOT NULL,
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gesamtpreis` decimal(10,2) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'offen'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `bestellung`
--

INSERT INTO `bestellung` (`bestellung_id`, `user_id`, `datum`, `gesamtpreis`, `status`) VALUES
(1, 2, '2026-06-11 05:53:50', 139.90, 'offen'),
(2, 2, '2026-06-11 05:55:42', 74.95, 'offen'),
(3, 5, '2026-06-15 14:40:05', 239.75, 'offen'),
(4, 5, '2026-06-15 14:41:06', 567.55, 'offen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellung_position`
--

CREATE TABLE `bestellung_position` (
  `position_id` int NOT NULL,
  `bestellung_id` int NOT NULL,
  `product_id` int NOT NULL,
  `menge` int NOT NULL,
  `preis_damals` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `bestellung_position`
--

INSERT INTO `bestellung_position` (`position_id`, `bestellung_id`, `product_id`, `menge`, `preis_damals`) VALUES
(1, 1, 4, 1, 74.95),
(2, 1, 5, 1, 64.95),
(3, 2, 3, 1, 74.95),
(4, 3, 56, 5, 47.95),
(5, 4, 8, 1, 89.95),
(6, 4, 76, 1, 19.95),
(7, 4, 55, 1, 37.95),
(8, 4, 28, 6, 69.95);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `deck`
--

CREATE TABLE `deck` (
  `product_id` int NOT NULL,
  `length` decimal(4,2) NOT NULL,
  `width` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `deck`
--

INSERT INTO `deck` (`product_id`, `length`, `width`) VALUES
(1, 32.00, 8.50),
(3, 31.80, 8.25),
(4, 32.20, 8.50),
(5, 31.50, 8.00),
(6, 32.00, 8.25),
(7, 32.20, 8.50),
(8, 32.20, 8.50),
(9, 32.00, 8.38),
(10, 31.60, 8.00),
(11, 32.25, 8.50),
(12, 31.85, 8.25),
(13, 31.85, 8.25),
(14, 32.30, 8.50),
(15, 31.44, 8.00),
(16, 32.30, 8.50),
(17, 31.83, 8.38),
(18, 31.90, 8.25),
(19, 31.88, 8.50),
(20, 32.30, 8.50),
(21, 32.30, 8.50),
(22, 31.90, 8.25),
(23, 32.25, 8.50),
(24, 31.90, 8.25);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `griptape`
--

CREATE TABLE `griptape` (
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `griptape`
--

INSERT INTO `griptape` (`product_id`) VALUES
(73),
(74),
(75),
(76),
(77),
(78),
(79),
(80),
(81),
(82),
(83),
(84),
(85);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `picture`
--

CREATE TABLE `picture` (
  `pictureid` int NOT NULL,
  `bildpfad` varchar(100) NOT NULL,
  `product_product_id` int NOT NULL,
  `ismain` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `picture`
--

INSERT INTO `picture` (`pictureid`, `bildpfad`, `product_product_id`, `ismain`) VALUES
(26, 'images/decks/product_1_69ecb75884d04.webp', 1, '1'),
(27, 'images/decks/product_1_69ecb780b3caa.webp', 1, '0'),
(28, 'images/decks/product_1_69ecb78a9e730.webp', 1, '0'),
(29, 'images/decks/product_3_69ece1b5bd0a6.webp', 3, '1'),
(30, 'images/decks/product_3_69ece1c79f5a8.webp', 3, '0'),
(31, 'images/decks/product_3_69ece1ee718a2.webp', 3, '0'),
(32, 'images/decks/product_4_69ece238d6b5d.webp', 4, '1'),
(33, 'images/decks/product_4_69ece240b4671.webp', 4, '0'),
(34, 'images/decks/product_4_69ece2463ed8f.webp', 4, '0'),
(35, 'images/decks/product_5_69ece259c9869.webp', 5, '1'),
(36, 'images/decks/product_5_69ece260bc3d7.webp', 5, '0'),
(37, 'images/decks/product_5_69ece2682935a.webp', 5, '0'),
(38, 'images/decks/product_6_69ece277f1d87.webp', 6, '1'),
(39, 'images/decks/product_6_69ece27f9b765.webp', 6, '0'),
(40, 'images/decks/product_6_69ece2852e997.webp', 6, '0'),
(41, 'images/decks/product_7_69ece2923a7fc.webp', 7, '1'),
(42, 'images/decks/product_7_69ece29893276.webp', 7, '0'),
(43, 'images/decks/product_7_69ece29dd0d26.webp', 7, '0'),
(44, 'images/decks/product_8_69ece2ad727ea.webp', 8, '1'),
(45, 'images/decks/product_8_69ece2b3d91d5.webp', 8, '0'),
(46, 'images/decks/product_8_69ece2bae4ca3.webp', 8, '0'),
(47, 'images/decks/product_9_69ece2c700ec1.webp', 9, '1'),
(48, 'images/decks/product_10_69edc44376a8d.webp', 10, '1'),
(49, 'images/decks/product_10_69edc450ed22e.webp', 10, '0'),
(50, 'images/decks/product_10_69edc45aaff56.webp', 10, '0'),
(51, 'images/decks/product_11_69edc46eafd1e.webp', 11, '1'),
(52, 'images/decks/product_12_69edc47f841d7.webp', 12, '1'),
(53, 'images/decks/product_12_69edc484a6ccd.webp', 12, '0'),
(54, 'images/decks/product_12_69edc48d262b0.webp', 12, '0'),
(55, 'images/decks/product_13_69edc4a15dcac.webp', 13, '1'),
(56, 'images/decks/product_14_69edc4b4e15e1.webp', 14, '1'),
(57, 'images/decks/product_14_69edc4bcab0ac.webp', 14, '0'),
(58, 'images/decks/product_14_69edc4c4bb7aa.webp', 14, '0'),
(59, 'images/decks/product_15_69edc4d65926e.webp', 15, '1'),
(60, 'images/decks/product_15_69edc4e19758c.webp', 15, '0'),
(61, 'images/decks/product_16_69edc4f41969b.webp', 16, '1'),
(62, 'images/decks/product_16_69edc4fa66b6e.webp', 16, '0'),
(63, 'images/decks/product_16_69edc50139891.jpg', 16, '0'),
(64, 'images/decks/product_17_69edc513da7f7.webp', 17, '1'),
(65, 'images/decks/product_17_69edc51a52956.webp', 17, '0'),
(66, 'images/decks/product_17_69edc524dca8f.webp', 17, '0'),
(67, 'images/decks/product_18_69edc5361db08.webp', 18, '1'),
(68, 'images/decks/product_19_69edc5439fa58.webp', 19, '1'),
(69, 'images/decks/product_19_69edc5498196a.webp', 19, '0'),
(70, 'images/decks/product_19_69edc55219954.webp', 19, '0'),
(71, 'images/decks/product_20_69edc56a119da.webp', 20, '1'),
(72, 'images/decks/product_20_69edc57201a88.webp', 20, '0'),
(73, 'images/decks/product_20_69edc57a116f0.webp', 20, '0'),
(74, 'images/decks/product_21_69edc58a5901a.webp', 21, '1'),
(75, 'images/decks/product_21_69edc5929e8b4.webp', 21, '0'),
(76, 'images/decks/product_21_69edc599830d4.webp', 21, '0'),
(77, 'images/decks/product_22_69edc5a0b489c.webp', 22, '1'),
(78, 'images/decks/product_22_69edc5a6f20ba.webp', 22, '0'),
(79, 'images/decks/product_22_69edc5aca83f7.webp', 22, '0'),
(80, 'images/decks/product_23_69edc5b2cc60d.webp', 23, '1'),
(81, 'images/decks/product_23_69edc5ba6743b.webp', 23, '0'),
(82, 'images/decks/product_24_69edc5c8ed979.webp', 24, '1'),
(83, 'images/wheels/product_25_69ef160eb49d0.webp', 25, '1'),
(84, 'images/wheels/product_25_69ef1619d8b38.webp', 25, '0'),
(85, 'images/wheels/product_26_69ef1624acf47.webp', 26, '1'),
(86, 'images/wheels/product_27_69ef1633cc58c.webp', 27, '1'),
(87, 'images/wheels/product_28_69ef164e94ee6.webp', 28, '1'),
(88, 'images/wheels/product_28_69ef1656d1804.webp', 28, '0'),
(89, 'images/wheels/product_29_69ef16614ae7e.webp', 29, '1'),
(90, 'images/wheels/product_30_69ef167ba89a6.webp', 30, '1'),
(91, 'images/wheels/product_30_69ef1686a49a3.webp', 30, '0'),
(92, 'images/wheels/product_30_69ef168de8490.webp', 30, '0'),
(98, 'images/wheels/product_31_69ef18110831f.webp', 31, '1'),
(99, 'images/wheels/product_31_69ef1818565b0.webp', 31, '0'),
(100, 'images/wheels/product_32_69ef18247f8a0.webp', 32, '1'),
(101, 'images/wheels/product_32_69ef182bc465f.webp', 32, '0'),
(102, 'images/wheels/product_33_69ef18366afc4.webp', 33, '1'),
(103, 'images/wheels/product_33_69ef183be8f86.webp', 33, '0'),
(104, 'images/wheels/product_34_69ef1841d383f.webp', 34, '1'),
(105, 'images/wheels/product_34_69ef1847b018c.webp', 34, '0'),
(106, 'images/wheels/product_34_69ef184f8f218.webp', 34, '0'),
(107, 'images/wheels/product_36_69ef48fdb28b3.webp', 36, '1'),
(108, 'images/wheels/product_36_69ef4908c4aa1.webp', 36, '0'),
(109, 'images/wheels/product_36_69ef4910a9626.webp', 36, '0'),
(110, 'images/wheels/product_37_69ef49305832b.webp', 37, '1'),
(111, 'images/wheels/product_37_69ef493c301f9.webp', 37, '0'),
(112, 'images/wheels/product_37_69ef49440adad.webp', 37, '0'),
(113, 'images/wheels/product_37_69ef494c4beef.webp', 37, '0'),
(114, 'images/wheels/product_38_69ef497deba1d.webp', 38, '1'),
(115, 'images/wheels/product_38_69ef4985484de.webp', 38, '0'),
(116, 'images/wheels/product_38_69ef498b59275.webp', 38, '0'),
(117, 'images/wheels/product_38_69ef4991d6eea.webp', 38, '0'),
(118, 'images/wheels/product_39_69ef56a45e4fc.webp', 39, '1'),
(119, 'images/wheels/product_39_69ef56ad427b9.webp', 39, '0'),
(120, 'images/wheels/product_40_69ef56c29dd10.webp', 40, '1'),
(121, 'images/wheels/product_40_69ef56cbe6eda.webp', 40, '0'),
(122, 'images/wheels/product_40_69ef56d633a9b.webp', 40, '0'),
(123, 'images/wheels/product_41_69ef56e18d199.webp', 41, '1'),
(124, 'images/wheels/product_41_69ef56ea2d713.webp', 41, '0'),
(125, 'images/wheels/product_41_69ef56f353e50.webp', 41, '0'),
(126, 'images/wheels/product_42_69ef56fe3fff4.webp', 42, '1'),
(127, 'images/wheels/product_42_69ef570639f83.webp', 42, '0'),
(128, 'images/wheels/product_43_69ef571c0688f.webp', 43, '1'),
(129, 'images/wheels/product_44_69ef572ec5cdf.webp', 44, '1'),
(130, 'images/wheels/product_45_69ef5739b4e33.webp', 45, '1'),
(131, 'images/wheels/product_46_69ef5754634e0.webp', 46, '1'),
(132, 'images/wheels/product_47_69ef575fa93d2.webp', 47, '1'),
(133, 'images/wheels/product_48_69ef576a3031f.webp', 48, '1'),
(134, 'images/wheels/product_49_69ef5773d1f39.webp', 49, '1'),
(135, 'images/wheels/product_50_69ef577fd483a.webp', 50, '1'),
(136, 'images/wheels/product_51_69ef578f06c5c.webp', 51, '1'),
(137, 'images/wheels/product_52_69ef579978988.webp', 52, '1'),
(138, 'images/wheels/product_53_69ef57a590fec.webp', 53, '1'),
(139, 'images/trucks/product_54_6a1e7d9f6b8b0.webp', 54, '1'),
(140, 'images/trucks/product_54_6a1e7daadcdbd.webp', 54, '0'),
(141, 'images/trucks/product_55_6a1e7dc619404.webp', 55, '1'),
(142, 'images/trucks/product_55_6a1e7dcddede3.webp', 55, '0'),
(143, 'images/trucks/product_55_6a1e7dd4e98bc.webp', 55, '0'),
(144, 'images/trucks/product_55_6a1e7ddc7872c.webp', 55, '0'),
(145, 'images/trucks/product_55_6a1e7de5bc37c.webp', 55, '0'),
(146, 'images/trucks/product_56_6a1e7df736326.webp', 56, '1'),
(147, 'images/trucks/product_56_6a1e7dff76b29.webp', 56, '0'),
(148, 'images/trucks/product_57_6a1e7e0d5ea5f.webp', 57, '1'),
(149, 'images/trucks/product_57_6a1e7e168659c.webp', 57, '0'),
(150, 'images/trucks/product_57_6a1e7e1e77146.webp', 57, '0'),
(151, 'images/trucks/product_57_6a1e7e2804463.webp', 57, '0'),
(152, 'images/trucks/product_58_6a1e7e31e7f64.webp', 58, '1'),
(153, 'images/trucks/product_58_6a1e7e3971cd9.webp', 58, '0'),
(154, 'images/trucks/product_58_6a1e7e40bf0f3.webp', 58, '0'),
(155, 'images/trucks/product_58_6a1e7e487a24b.webp', 58, '0'),
(156, 'images/trucks/product_58_6a1e7e5069bc8.webp', 58, '0'),
(157, 'images/trucks/product_59_6a1e7e5ca259c.webp', 59, '1'),
(158, 'images/trucks/product_59_6a1e7e653caef.webp', 59, '0'),
(159, 'images/trucks/product_59_6a1e7e6caebae.webp', 59, '0'),
(160, 'images/trucks/product_59_6a1e7e7552343.webp', 59, '0'),
(161, 'images/trucks/product_59_6a1e7e7e147c4.webp', 59, '0'),
(162, 'images/trucks/product_60_6a1e7e874d3c5.webp', 60, '1'),
(163, 'images/trucks/product_60_6a1e7e8fcf4e3.webp', 60, '0'),
(164, 'images/trucks/product_60_6a1e7e96bb290.webp', 60, '0'),
(165, 'images/trucks/product_60_6a1e7e9db2544.webp', 60, '0'),
(166, 'images/trucks/product_60_6a1e7ea4ed59c.webp', 60, '0'),
(167, 'images/bearings/product_61_6a1e83f96e770.webp', 61, '1'),
(168, 'images/bearings/product_61_6a1e84014780a.webp', 61, '0'),
(169, 'images/bearings/product_61_6a1e8408c94de.webp', 61, '0'),
(170, 'images/bearings/product_62_6a1e84190e8ad.webp', 62, '1'),
(171, 'images/bearings/product_62_6a1e842002945.webp', 62, '0'),
(172, 'images/bearings/product_62_6a1e842b3b845.webp', 62, '0'),
(173, 'images/bearings/product_62_6a1e8432a4b1e.webp', 62, '0'),
(174, 'images/bearings/product_63_6a1e844ff3f0d.webp', 63, '1'),
(175, 'images/bearings/product_64_6a1e846297ae9.webp', 64, '1'),
(176, 'images/bearings/product_65_6a1e8484d56fa.webp', 65, '1'),
(177, 'images/bearings/product_66_6a1e848b165d2.webp', 66, '1'),
(178, 'images/bearings/product_67_6a1e849c84981.webp', 67, '1'),
(179, 'images/bearings/product_67_6a1e84a496cde.webp', 67, '0'),
(180, 'images/bearings/product_68_6a1e84aeac7e6.webp', 68, '1'),
(181, 'images/bearings/product_68_6a1e84b72210c.webp', 68, '0'),
(182, 'images/bearings/product_69_6a1e84bfe0bba.webp', 69, '1'),
(183, 'images/bearings/product_70_6a1e84cae958a.webp', 70, '1'),
(184, 'images/bearings/product_70_6a1e84d2a852d.webp', 70, '0'),
(185, 'images/bearings/product_70_6a1e84d9b4832.webp', 70, '0'),
(186, 'images/bearings/product_71_6a1e84e452ad4.webp', 71, '1'),
(187, 'images/bearings/product_71_6a1e84ef360e4.webp', 71, '0'),
(188, 'images/bearings/product_71_6a1e84f6873e4.webp', 71, '0'),
(189, 'images/bearings/product_72_6a1e850c72d13.webp', 72, '1'),
(190, 'images/griptape/product_73_6a1e88cf9cbca.webp', 73, '1'),
(191, 'images/griptape/product_73_6a1e88d60b5f1.webp', 73, '0'),
(192, 'images/griptape/product_74_6a1e88e30ad63.webp', 74, '1'),
(193, 'images/griptape/product_75_6a1e88ef37bfe.webp', 75, '1'),
(194, 'images/griptape/product_76_6a1e88fb3f804.webp', 76, '1'),
(195, 'images/griptape/product_77_6a1e8904b14a4.webp', 77, '1'),
(196, 'images/griptape/product_78_6a1e890c67c93.webp', 78, '1'),
(197, 'images/griptape/product_79_6a1e89171a14a.webp', 79, '1'),
(198, 'images/griptape/product_80_6a1e89216c40f.webp', 80, '1'),
(199, 'images/griptape/product_81_6a1e892995826.webp', 81, '1'),
(200, 'images/griptape/product_82_6a1e8935c149a.webp', 82, '1'),
(201, 'images/griptape/product_83_6a1e893fb9463.webp', 83, '1'),
(202, 'images/griptape/product_84_6a1e89486544a.webp', 84, '1'),
(203, 'images/griptape/product_85_6a1e89513f051.webp', 85, '1'),
(204, 'images/accessories/product_86_6a1e96cbbf2c8.webp', 86, '1'),
(205, 'images/accessories/product_87_6a1e96d325fd4.webp', 87, '1'),
(206, 'images/accessories/product_88_6a1e96da35cff.webp', 88, '1'),
(207, 'images/accessories/product_89_6a1e96e2150df.webp', 89, '1'),
(208, 'images/accessories/product_90_6a1e9713890e1.webp', 90, '1'),
(209, 'images/accessories/product_90_6a1e971ae434f.webp', 90, '0'),
(210, 'images/accessories/product_91_6a1e9725142d2.webp', 91, '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `product`
--

CREATE TABLE `product` (
  `product_id` int NOT NULL,
  `beschreibung` varchar(200) NOT NULL,
  `preis` decimal(10,2) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `kategorie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `product`
--

INSERT INTO `product` (`product_id`, `beschreibung`, `preis`, `brand`, `kategorie`) VALUES
(1, 'Brand Logo 8.5\" Skateboard Deck', 94.95, 'Baker', 'deck'),
(3, 'Razor Dot 8.25″ Skateboard Deck', 74.95, 'Santa_Cruz', 'deck'),
(4, 'Cut Collage 8.5″ Skateboard Deck', 74.95, 'Santa_Cruz', 'deck'),
(5, 'Hawk Spiral 8″ Skateboard Deck', 64.95, 'Birdhouse', 'deck'),
(6, 'Team Logo 8.25″ Skateboard Deck', 59.95, 'Birdhouse', 'deck'),
(7, 'Crowded Hand 8.5″ Skateboard Deck', 89.95, 'Santa_Cruz', 'deck'),
(8, 'Heavens (Gold Foil) 8.5″ Skateboard Deck', 89.95, 'DGK', 'deck'),
(9, 'Spellcaster Mazzari 8.38″ Skateboard Deck', 89.95, 'DGK', 'deck'),
(10, 'Single Skull 8.0″ Skateboard Deck', 74.95, 'Zero', 'deck'),
(11, 'Misfits Fiend Skull Gitd 8.5″ Skateboard Deck', 84.95, 'Zero', 'deck'),
(12, 'Cold Pressed Boo 8.25″ Skateboard Deck', 84.95, 'DGK', 'deck'),
(13, 'Gernika 8.25″x31.85″ LC Skateboard Deck', 59.95, 'Jart', 'deck'),
(14, 'Blood Skull 8.25″ Skateboard Deck', 79.95, 'Zero', 'deck'),
(15, 'Stay High 8.0″x31.44″ HC Skateboard Deck', 59.95, 'Jart', 'deck'),
(16, 'Blood Skull 8.5″ Skateboard Deck', 79.95, 'Zero', 'deck'),
(17, 'Classic Dot 8.375″ Skateboard Deck', 79.95, 'Santa_Cruz', 'deck'),
(18, 'Misfits Zero Business Gitd 8.25″ Skateboard Deck', 84.95, 'Zero', 'deck'),
(19, 'Malto 93 Til Khaki 8.5″ Skateboard Deck', 79.95, 'Girl', 'deck'),
(20, 'Single Skull 8.5″ Skateboard Deck', 74.95, 'Zero', 'deck'),
(21, 'Bold Black 8.5″ Skateboard Deck', 74.95, 'Zero', 'deck'),
(22, 'Bold Black 8.25″ Skateboard Deck', 74.95, 'Zero', 'deck'),
(23, 'Burleigh Fright Night 8.5″ Skateboard Deck', 79.95, 'Zero', 'deck'),
(24, 'X Pleasures Reaper 8.25″ Skateboard Deck', 84.95, 'Zero', 'deck'),
(25, 'Dragons 93A V4 Medium Ride 54mm Rollen', 69.95, 'Powell_Peralta', 'wheels'),
(26, '100s Originals V4 Wide 53mm Rollen', 69.95, 'Bones_Wheels', 'wheels'),
(27, 'Dragons 93A V1 Narrow Ride 52mm Rollen', 69.95, 'Powell_Peralta', 'wheels'),
(28, 'Dragons 93A V6 Medium Ride 56mm Rollen', 69.95, 'Powell_Peralta', 'wheels'),
(29, 'Dragons Nano Rat 93A AA2 Wide Ride 54mm Rollen', 69.95, 'Powell_Peralta', 'wheels'),
(30, 'Originals 100A V5 Sidecut 53mm Rollen', 44.95, 'Bones_Wheels', 'wheels'),
(31, 'Dragons 88A V6 Medium Ride 56mm Rollen', 69.95, 'Powell_Peralta', 'wheels'),
(32, 'Orbs Apparitions 53mm Rollen', 34.95, 'Welcome', 'wheels'),
(33, 'X Thrasher Classic Flame F499 52mm Rollen', 74.95, 'Spitfire', 'wheels'),
(34, 'Orbs Specters Swirls 99A 56mm Rollen', 34.95, 'Welcome', 'wheels'),
(36, 'Black Sabbath Paranoid Chubbies 99a 56mm Rollen', 51.95, 'OJ_Wheels', 'wheels'),
(37, 'Orbs Apparitions 52mm Rollen', 34.95, 'Welcome', 'wheels'),
(38, 'Orbs Apparitions 56mm Rollen', 34.95, 'Welcome', 'wheels'),
(39, 'X Thrasher TrashBurn 80HD CF 56mm Rollen', 71.95, 'Spitfire', 'wheels'),
(40, 'Orbs Specters 53mm Rollen', 34.95, 'Spitfire', 'wheels'),
(41, 'Orbs Apparitions 52mm Rollen', 34.95, 'Spitfire', 'wheels'),
(42, 'X Thrasher Oath F499 Radial Full 58mm Rollen', 74.95, 'Spitfire', 'wheels'),
(43, 'Uproar 54mmx34mm 84a Rollen', 46.95, 'Jart', 'wheels'),
(44, 'Gernika 53mm 99A Classic Shape Rollen', 34.95, 'Jart', 'wheels'),
(45, 'Uproar 56mmx34mm 84a Rollen', 46.95, 'Jart', 'wheels'),
(46, 'Squirt 58mm 84A Black Rollen', 34.95, 'Cruzade', 'wheels'),
(47, 'Skeletons 54mm 99A Rollen', 46.95, 'Jart', 'wheels'),
(48, 'Gernika 51mm 99A Classic Shape Rollen', 34.95, 'Jart', 'wheels'),
(49, 'Foo Fighters 51mm 99A Rollen', 46.95, 'Jart', 'wheels'),
(50, 'Skeletons 52mm 99A Rollen', 46.95, 'Jart', 'wheels'),
(51, 'Skeletons 55mm 99A Rollen', 46.95, 'Jart', 'wheels'),
(52, 'Foo Fighters 53mm 99A Rollen', 46.95, 'Jart', 'wheels'),
(53, 'Squirt 56mm 84A Black Rollen', 34.95, 'Cruzade', 'wheels'),
(54, 'Polished Hollow Lights Hi 148 II Achse', 47.95, 'Thunder', 'trucks'),
(55, '149 Stage 11 Polished Standard Achse', 37.95, 'Independent', 'trucks'),
(56, 'Polished Hollow Lights Hi 149 II Achse', 47.95, 'Thunder', 'trucks'),
(57, 'Polished Hollow Lights Hi 149 II Achse', 37.95, 'Independent', 'trucks'),
(58, '144 Stage 11 Forged Hollow Standard Achse', 44.95, 'Independent', 'trucks'),
(59, '139 Stage 11 Forged Hollow Standard Achse', 44.95, 'Independent', 'trucks'),
(60, '149 Stage 11 Forged Hollow Standard Achse', 44.95, 'Independent', 'trucks'),
(61, 'Reds Kugellager', 24.95, 'Bones_Bearings', 'bearings'),
(62, 'Super Reds Kugellager', 39.95, 'Bones_Bearings', 'bearings'),
(63, 'Super Swiss 6 Balls Kugellager', 94.95, 'Bones_Bearings', 'bearings'),
(64, 'Reds Big Balls Kugellager', 31.95, 'Bones_Bearings', 'bearings'),
(65, 'Classics Kugellager', 19.95, 'Spitfire', 'bearings'),
(66, 'Burners Kugellager', 34.95, 'Spitfire', 'bearings'),
(67, 'Ceramic Sarmiento Kugellager', 71.95, 'Mosaic', 'bearings'),
(68, 'Ceramic Surrey Kugellager', 71.95, 'Mosaic', 'bearings'),
(69, 'Ceramic Kremer Kugellager', 71.95, 'Mosaic', 'bearings'),
(70, 'Ceramic Penny Kugellager', 71.95, 'Mosaic', 'bearings'),
(71, 'Ceranium Kugellager', 77.95, 'Mosaic', 'bearings'),
(72, 'G2 Kugellager', 24.95, 'Bronson', 'bearings'),
(73, 'Black 9″x33″ Griptape', 9.95, 'MOB_Grip', 'griptape'),
(74, 'Ultra Griptape', 5.95, 'Jessup', 'griptape'),
(75, 'G5 Galaxy G5 Griptape', 9.95, 'Pepper_Grip', 'griptape'),
(76, 'Black Sabbath Master of Reality 10″x33″ Griptape', 19.95, 'MOB_Grip', 'griptape'),
(77, 'Tie Dye Griptape', 7.95, 'Blue_Tomato', 'griptape'),
(78, 'Tie Dye 9″ Griptape', 6.95, 'Blue_Tomato', 'griptape'),
(79, 'Thrasher Gonz Mag Griptape', 17.95, 'MOB_Grip', 'griptape'),
(80, 'Big Smile Griptape', 14.95, 'Grizzly', 'griptape'),
(81, 'Neon Yellow Griptape', 10.95, 'Jessup', 'griptape'),
(82, 'Forestry Griptape', 14.95, 'Grizzly', 'griptape'),
(83, 'Trasher Big Destroy Griptape', 15.95, 'MOB_Grip', 'griptape'),
(84, 'Monster Flame 9″ Griptape', 17.95, 'MOB_Grip', 'griptape'),
(85, 'School Of Happiness Griptape', 14.95, 'Grizzly', 'griptape'),
(86, 'Grip Cleaner Griptape', 10.95, 'MOB_Grip', 'accessories'),
(87, 'Grease Skate Wachs', 7.95, 'Grizzly', 'accessories'),
(88, 'Curb Killer Wax', 12.95, 'Independent', 'accessories'),
(89, 'Bearing Cleaning Unit', 13.95, 'Bronson', 'accessories'),
(90, 'Bearing Cleaning Unit', 19.95, 'Bones_Bearings', 'accessories'),
(91, '1/8″ Riser Pads', 4.95, 'Independent', 'accessories');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `trucks`
--

CREATE TABLE `trucks` (
  `product_id` int NOT NULL,
  `height` varchar(10) DEFAULT NULL,
  `width` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `trucks`
--

INSERT INTO `trucks` (`product_id`, `height`, `width`) VALUES
(54, 'Medium', 8.25),
(55, 'High', 8.50),
(56, 'Medium', 8.50),
(57, 'High', 8.25),
(58, 'High', 8.25),
(59, 'High', 8.00),
(60, 'High', 8.50);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `vorname` varchar(50) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `passwort` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`user_id`, `vorname`, `nachname`, `email`, `passwort`) VALUES
(1, 'David', 'Lachner', 'd.l@gmail.com', '$2y$10$QNHQij0FTeStGrvtfF8aBeVCsTlfNMkfIzQu.urIjOzVd8dXB6FdK'),
(2, 'Test', 'Test', 'test@gmail.com', '$2y$10$6jUG4L8d7Zt9YXU5I2Qhyu6N1pNTIhdpegKC.nvCPHgbKBxbRRq4O'),
(3, 'test1', 'test1', 'test1@gmail.com', '$2y$10$8uWtuwUCF/WkYs/72OcUnustd4a2TOCEyZj2hnnk4qqExRO0ZvARG'),
(4, 'Roland', 'Bauer', 'skibidi@gmail.com', '$2y$10$WgbJgW9rPMdPNXYPzRYHZOgwz/0j4BIU2P..AWEohc7lsgVF1baWi'),
(5, 'Max', 'Mustermann', 'max.mustermann@gmail.com', '$2y$10$xGXIVWfHLaRvHUkYLzlJFuSwB7CQ5jTxcw6vBPERWOCEBkqcpmjZa');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `warenkorb`
--

CREATE TABLE `warenkorb` (
  `warenkorb_id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `menge` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `wheels`
--

CREATE TABLE `wheels` (
  `product_id` int NOT NULL,
  `width` int NOT NULL,
  `durchmesser` int NOT NULL,
  `typ` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `wheels`
--

INSERT INTO `wheels` (`product_id`, `width`, `durchmesser`, `typ`) VALUES
(25, 17, 54, '93A'),
(26, 21, 53, '100A'),
(27, 15, 52, '93A'),
(28, 17, 56, '93A'),
(29, 18, 54, '93A'),
(30, 17, 53, '100A'),
(31, 17, 56, '88A'),
(32, 19, 53, '99A'),
(33, 16, 52, '99A'),
(34, 20, 56, '99A'),
(36, 24, 56, '99A'),
(37, 20, 52, '99A'),
(38, 22, 56, '99A'),
(39, 25, 56, '88HD'),
(40, 22, 53, '99A'),
(41, 20, 52, '99A'),
(42, 25, 58, '99A'),
(43, 20, 54, '84A'),
(44, 17, 53, '99A'),
(45, 20, 56, '84A'),
(46, 22, 58, '84A'),
(47, 20, 54, '99A'),
(48, 16, 51, '99A'),
(49, 18, 51, '99A'),
(50, 18, 52, '99A'),
(51, 18, 55, '99A'),
(52, 18, 53, '99A'),
(53, 20, 56, '84A');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `wunschliste`
--

CREATE TABLE `wunschliste` (
  `wunschliste_id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `wunschliste`
--

INSERT INTO `wunschliste` (`wunschliste_id`, `user_id`, `product_id`) VALUES
(9, 4, 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`product_id`);

--
-- Indizes für die Tabelle `bearings`
--
ALTER TABLE `bearings`
  ADD PRIMARY KEY (`product_id`);

--
-- Indizes für die Tabelle `bestellung`
--
ALTER TABLE `bestellung`
  ADD PRIMARY KEY (`bestellung_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `bestellung_position`
--
ALTER TABLE `bestellung_position`
  ADD PRIMARY KEY (`position_id`),
  ADD KEY `bestellung_id` (`bestellung_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indizes für die Tabelle `deck`
--
ALTER TABLE `deck`
  ADD PRIMARY KEY (`product_id`);

--
-- Indizes für die Tabelle `griptape`
--
ALTER TABLE `griptape`
  ADD PRIMARY KEY (`product_id`);

--
-- Indizes für die Tabelle `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`pictureid`),
  ADD KEY `product_product_id` (`product_product_id`);

--
-- Indizes für die Tabelle `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indizes für die Tabelle `trucks`
--
ALTER TABLE `trucks`
  ADD PRIMARY KEY (`product_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indizes für die Tabelle `warenkorb`
--
ALTER TABLE `warenkorb`
  ADD PRIMARY KEY (`warenkorb_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indizes für die Tabelle `wheels`
--
ALTER TABLE `wheels`
  ADD PRIMARY KEY (`product_id`);

--
-- Indizes für die Tabelle `wunschliste`
--
ALTER TABLE `wunschliste`
  ADD PRIMARY KEY (`wunschliste_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bestellung`
--
ALTER TABLE `bestellung`
  MODIFY `bestellung_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `bestellung_position`
--
ALTER TABLE `bestellung_position`
  MODIFY `position_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `picture`
--
ALTER TABLE `picture`
  MODIFY `pictureid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT für Tabelle `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `warenkorb`
--
ALTER TABLE `warenkorb`
  MODIFY `warenkorb_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT für Tabelle `wunschliste`
--
ALTER TABLE `wunschliste`
  MODIFY `wunschliste_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `accessories`
--
ALTER TABLE `accessories`
  ADD CONSTRAINT `accessories_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints der Tabelle `bearings`
--
ALTER TABLE `bearings`
  ADD CONSTRAINT `bearings_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints der Tabelle `bestellung`
--
ALTER TABLE `bestellung`
  ADD CONSTRAINT `bestellung_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints der Tabelle `bestellung_position`
--
ALTER TABLE `bestellung_position`
  ADD CONSTRAINT `bestellung_position_ibfk_1` FOREIGN KEY (`bestellung_id`) REFERENCES `bestellung` (`bestellung_id`),
  ADD CONSTRAINT `bestellung_position_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints der Tabelle `deck`
--
ALTER TABLE `deck`
  ADD CONSTRAINT `deck_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints der Tabelle `griptape`
--
ALTER TABLE `griptape`
  ADD CONSTRAINT `griptape_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints der Tabelle `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `picture_ibfk_1` FOREIGN KEY (`product_product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints der Tabelle `trucks`
--
ALTER TABLE `trucks`
  ADD CONSTRAINT `trucks_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints der Tabelle `warenkorb`
--
ALTER TABLE `warenkorb`
  ADD CONSTRAINT `warenkorb_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `warenkorb_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints der Tabelle `wheels`
--
ALTER TABLE `wheels`
  ADD CONSTRAINT `wheels_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints der Tabelle `wunschliste`
--
ALTER TABLE `wunschliste`
  ADD CONSTRAINT `wunschliste_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `wunschliste_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
