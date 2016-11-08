-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 26, 2013 at 05:32 AM
-- Server version: 5.1.40
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vezuviy`
--

-- --------------------------------------------------------

--
-- Table structure for table `avatar_categories`
--

CREATE TABLE IF NOT EXISTS `avatar_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `src` text NOT NULL,
  `title` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `avatar_categories`
--

INSERT INTO `avatar_categories` (`id`, `src`, `title`) VALUES
(2, 'icon_2.swf', 'tit_2'),
(1, 'icon_1.swf', 'title_1'),
(6, 'icon_6.swf', 'game_title'),
(5, 'icon_5.swf', 'game_title'),
(4, 'icon_4.swf', 'game_title'),
(3, 'icon_3.swf', 'game_title'),
(7, 'icon_7.swf', 'game_title');

-- --------------------------------------------------------

--
-- Table structure for table `avatar_user`
--

CREATE TABLE IF NOT EXISTS `avatar_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `src` text,
  `mode` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `sort` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `avatar_user`
--

INSERT INTO `avatar_user` (`id`, `name`, `src`, `mode`, `sort`) VALUES
(1, NULL, '1.swf', 1, 1),
(2, NULL, '2.swf', 1, 2),
(3, NULL, '3.swf', 1, 3),
(4, NULL, '4.swf', 1, 4),
(5, NULL, '5.swf', 1, 5),
(6, NULL, '6.swf', 1, 6),
(7, NULL, '7.swf', 1, 7),
(8, NULL, '8.swf', 1, 8),
(9, NULL, 'g1.swf', 2, 1),
(10, NULL, 'g2.swf', 2, 2),
(11, NULL, 'g3.swf', 2, 3),
(12, NULL, 'g4.swf', 2, 4),
(13, NULL, '9.swf', 1, 9),
(14, NULL, '10.swf', 1, 10),
(15, NULL, '11.swf', 1, 11),
(16, NULL, '12.swf', 1, 12),
(17, NULL, '13.swf', 1, 13),
(18, NULL, '14.swf', 1, 14),
(19, NULL, '15.swf', 1, 15),
(20, NULL, '16.swf', 1, 16),
(21, NULL, '17.swf', 1, 17),
(22, NULL, '18.swf', 1, 18),
(23, NULL, '19.swf', 1, 19),
(24, NULL, '20.swf', 1, 20),
(25, NULL, '21.swf', 1, 21),
(26, NULL, '22.swf', 1, 22),
(27, NULL, '23.swf', 1, 23),
(28, NULL, '24.swf', 1, 24),
(29, NULL, '25.swf', 1, 25),
(30, NULL, '26.swf', 1, 26),
(31, NULL, 'g5.swf', 2, 5),
(32, NULL, 'g6.swf', 2, 6),
(33, NULL, 'g7.swf', 2, 7),
(34, NULL, 'g8.swf', 2, 8),
(35, NULL, 'g9.swf', 2, 9),
(36, NULL, '27.swf', 1, 27);

-- --------------------------------------------------------

--
-- Table structure for table `banking`
--

CREATE TABLE IF NOT EXISTS `banking` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('game','profit','jackpot') NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `balance` double unsigned NOT NULL,
  `changed` int(10) unsigned NOT NULL DEFAULT '0',
  `is_default` tinyint(2) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=22 ;

--
-- Dumping data for table `banking`
--

INSERT INTO `banking` (`id`, `type`, `title`, `balance`, `changed`, `is_default`) VALUES
(4, 'game', '', 0, 1261250904, 1),
(3, 'jackpot', '', 0, 1260194279, 1),
(5, 'profit', '', 0, 1261056868, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bonus`
--

CREATE TABLE IF NOT EXISTS `bonus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(20) unsigned DEFAULT NULL,
  `code` text,
  `amount` float unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `changed` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `bonus`
--


-- --------------------------------------------------------

--
-- Table structure for table `bonus_collection`
--

CREATE TABLE IF NOT EXISTS `bonus_collection` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `bonus_collection`
--

INSERT INTO `bonus_collection` (`id`, `title`) VALUES
(6, 'Бонусы при регистрации');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `title` text,
  `avatar_id` int(11) DEFAULT NULL,
  `sort` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `title`, `avatar_id`, `sort`) VALUES
(1, 'Сards', 'Карты', 1, 1),
(2, 'Roulette', 'Рулетка', 2, 2),
(3, 'Slots_9_Bonus', 'Слот 9 Бонус', 3, 3),
(4, 'Slots_9_Free', 'Слот 9 Free', 4, 4),
(10, 'Slots_9_x2', 'Слот 9 х2', 5, 5),
(11, 'Video_Poker', 'Видео покер', 6, 6),
(12, 'Slots_3', 'Слот 3', 7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `content_menu`
--

CREATE TABLE IF NOT EXISTS `content_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` int(10) unsigned NOT NULL,
  `name` text,
  `src` text,
  `position` int(8) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `content_menu`
--

INSERT INTO `content_menu` (`id`, `type_id`, `name`, `src`, `position`) VALUES
(1, 1, 'cash', '/event/cash', 1),
(2, 1, 'rules', '/content/rules', 2),
(3, 1, 'help', '/content/help', 3),
(4, 2, 'terms', '/content/use', 1),
(5, 2, 'license', '/content/license', 2);

-- --------------------------------------------------------

--
-- Table structure for table `content_menu_type`
--

CREATE TABLE IF NOT EXISTS `content_menu_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `content_menu_type`
--

INSERT INTO `content_menu_type` (`id`, `title`) VALUES
(1, 'header'),
(2, 'footer');

-- --------------------------------------------------------

--
-- Table structure for table `content_news`
--

CREATE TABLE IF NOT EXISTS `content_news` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `body` text,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `content_news`
--

INSERT INTO `content_news` (`id`, `title`, `body`, `date`) VALUES
(1, 'Hello', 'Hello word.', 1248348146),
(2, 'Two', 'Legal busnes', 1248348146);

-- --------------------------------------------------------

--
-- Table structure for table `controllers_gauge_couns`
--

CREATE TABLE IF NOT EXISTS `controllers_gauge_couns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bet_number` int(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL DEFAULT '',
  `value_from` int(10) unsigned NOT NULL DEFAULT '0',
  `value_till` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`bet_number`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=90 ;

--
-- Dumping data for table `controllers_gauge_couns`
--

INSERT INTO `controllers_gauge_couns` (`id`, `bet_number`, `name`, `value_from`, `value_till`) VALUES
(1, 1, '', 1, 20),
(2, 1, '', 20, 50),
(3, 1, '', 50, 100),
(4, 1, '', 100, 400),
(1, 2, '', 1, 40),
(2, 2, '', 40, 100),
(3, 2, '', 100, 200),
(4, 2, '', 200, 600),
(1, 3, '', 1, 60),
(2, 3, '', 60, 150),
(3, 3, '', 100, 300),
(4, 3, '', 300, 800),
(1, 4, '', 1, 80),
(2, 4, '', 80, 200),
(3, 4, '', 150, 400),
(4, 4, '', 400, 1000),
(1, 5, '', 1, 100),
(2, 5, '', 100, 250),
(3, 5, '', 200, 500),
(4, 5, '', 500, 2000),
(1, 6, '', 1, 120),
(2, 6, '', 120, 300),
(3, 6, '', 250, 600),
(4, 6, '', 600, 3000),
(1, 7, '', 1, 140),
(2, 7, '', 140, 350),
(3, 7, '', 300, 700),
(4, 7, '', 700, 4000),
(1, 8, '', 1, 160),
(2, 8, '', 160, 400),
(3, 8, '', 350, 800),
(4, 8, '', 800, 5000),
(1, 9, '', 1, 180),
(2, 9, '', 180, 450),
(3, 9, '', 400, 900),
(4, 9, '', 900, 6000),
(1, 10, '', 1, 200),
(2, 10, '', 200, 500),
(3, 10, '', 450, 1000),
(4, 10, '', 1000, 7000),
(1, 11, '', 1, 220),
(2, 11, '', 220, 550),
(3, 11, '', 500, 1100),
(4, 11, '', 1100, 8000),
(1, 12, '', 1, 240),
(2, 12, '', 240, 600),
(3, 12, '', 550, 1200),
(4, 12, '', 1200, 9000),
(1, 13, '', 1, 260),
(2, 13, '', 260, 650),
(3, 13, '', 600, 1300),
(4, 13, '', 1300, 10000),
(1, 14, '', 1, 280),
(2, 14, '', 280, 700),
(3, 14, '', 650, 1400),
(4, 14, '', 1400, 11000),
(1, 15, '', 1, 300),
(2, 15, '', 300, 750),
(3, 15, '', 700, 1500),
(4, 15, '', 1500, 12000),
(1, 16, '', 1, 320),
(2, 16, '', 320, 800),
(3, 16, '', 750, 1600),
(4, 16, '', 1600, 13000),
(1, 17, '', 1, 340),
(2, 17, '', 340, 850),
(3, 17, '', 800, 1700),
(4, 17, '', 1700, 14000),
(1, 18, '', 1, 360),
(2, 18, '', 360, 900),
(3, 18, '', 850, 1800),
(4, 18, '', 1800, 15000),
(1, 19, '', 1, 380),
(2, 19, '', 380, 950),
(3, 19, '', 800, 1900),
(4, 19, '', 1900, 16000),
(1, 20, '', 1, 400),
(2, 20, '', 400, 1000),
(3, 20, '', 950, 2000),
(4, 20, '', 2000, 17000),
(1, 21, '', 1, 420),
(2, 21, '', 420, 1050),
(3, 21, '', 1000, 2100),
(4, 21, '', 2100, 18000),
(1, 22, '', 1, 450),
(2, 22, '', 450, 1100),
(3, 22, '', 1050, 2200),
(4, 22, '', 2200, 19000);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  `merchant_id` int(8) unsigned NOT NULL DEFAULT '1',
  `src` text NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `sort` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `title`, `merchant_id`, `src`, `active`, `sort`) VALUES
(1, 'Visa', 3, 'visa', 1, 1),
(2, 'Mastercard', 3, 'mastercard', 1, 2),
(3, 'Unicarta', 3, 'unicarta', 1, 3),
(4, 'Paypal', 3, 'paypal', 1, 4),
(5, 'Web money', 3, 'webmoney', 1, 5),
(6, 'Yandex money', 3, 'yandexmoney', 1, 6),
(7, 'RBK money', 3, 'rbkmoney', 1, 7),
(8, 'Zpayment', 3, 'zpayment', 1, 8),
(9, 'Money mail', 3, 'moneymail', 1, 9),
(10, 'Easy pay', 3, 'easypay', 1, 10),
(11, 'Web creds', 3, 'webcreds', 1, 11),
(12, 'Liq pay', 3, 'liqpay', 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `media_id` bigint(20) unsigned NOT NULL,
  `categories_id` bigint(20) unsigned NOT NULL,
  `current_profile_id` int(10) unsigned NOT NULL DEFAULT '1',
  `view` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `sort` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `controllers_id` (`media_id`),
  KEY `categories_id` (`categories_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=57 ;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `title`, `media_id`, `categories_id`, `current_profile_id`, `view`, `sort`) VALUES
(1, 'LasVegas', 1, 10, 1, 1, 36),
(2, 'Captain-cavern', 2, 10, 1, 1, 37),
(4, 'Crazy Doctor', 3, 10, 1, 1, 38),
(5, 'London', 4, 10, 1, 1, 39),
(6, 'New-York', 5, 10, 1, 1, 40),
(7, 'Paris', 6, 10, 1, 1, 41),
(8, 'Rue Commerce', 7, 10, 1, 1, 42),
(9, 'Sergent pepper', 8, 10, 1, 1, 43),
(10, 'Shinobi', 9, 10, 1, 1, 44),
(11, 'Tokyo', 10, 10, 1, 1, 45),
(12, 'Cartoons', 11, 4, 1, 1, 21),
(13, 'Happy Christmas', 13, 4, 1, 1, 22),
(14, 'Indiana Croft', 14, 4, 1, 1, 23),
(15, 'James Band', 15, 4, 1, 1, 24),
(16, 'Jules Verne', 16, 4, 1, 1, 25),
(17, 'Just Married', 17, 4, 1, 1, 26),
(18, 'Mah Jong', 18, 4, 1, 1, 27),
(19, 'New Year Eve', 19, 4, 1, 1, 28),
(20, 'Pantheon', 20, 4, 1, 1, 29),
(21, 'Royal Fruit', 21, 4, 1, 1, 30),
(22, 'Safari', 22, 4, 1, 1, 31),
(23, 'Space Runners', 23, 4, 1, 1, 32),
(24, 'Super Heroes', 24, 4, 1, 1, 33),
(25, 'World Cup', 25, 4, 1, 1, 34),
(26, 'Davinci', 26, 4, 1, 1, 35),
(27, 'Atlantis', 27, 3, 1, 1, 6),
(28, 'Dartagnan', 28, 3, 1, 1, 7),
(29, 'Dracula', 29, 3, 1, 1, 8),
(30, 'Gladiator', 30, 3, 1, 1, 9),
(31, 'Happy Farm', 31, 3, 1, 1, 10),
(32, 'Jungle Jimmy', 32, 3, 1, 1, 11),
(33, 'Jurassic World', 33, 3, 1, 1, 12),
(34, 'Lucky Luke', 34, 3, 1, 1, 13),
(35, 'Luna Park', 35, 3, 1, 1, 14),
(36, 'Mafia', 36, 3, 1, 1, 15),
(37, 'Mont-blanc', 37, 3, 1, 1, 16),
(38, 'Navy', 38, 3, 1, 1, 17),
(39, 'Numbers', 39, 3, 1, 1, 18),
(40, 'Small life', 40, 3, 1, 1, 19),
(41, 'Zorro', 41, 3, 1, 1, 20),
(42, 'Candies', 42, 12, 1, 1, 47),
(43, 'Corona', 43, 12, 1, 1, 48),
(44, 'Grizzly', 44, 12, 1, 1, 49),
(45, 'Liberty bell', 45, 12, 1, 1, 50),
(46, 'Marilyn', 46, 12, 1, 1, 51),
(47, 'Devils Bikers', 47, 3, 1, 1, 5),
(48, 'Roulette Silver', 48, 2, 1, 1, 4),
(50, 'Black Jack Diamond', 50, 1, 1, 1, 1),
(51, 'Black Jack Gold', 51, 1, 1, 1, 2),
(52, 'Black Jack Silver', 52, 1, 1, 1, 3),
(54, 'Jacks or Better', 54, 11, 1, 1, 46);

-- --------------------------------------------------------

--
-- Table structure for table `games_banking`
--

CREATE TABLE IF NOT EXISTS `games_banking` (
  `games_id` bigint(20) unsigned NOT NULL,
  `profiles_id` int(10) unsigned NOT NULL DEFAULT '1',
  `banking_id` bigint(20) unsigned NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT '',
  `percent` double unsigned NOT NULL,
  PRIMARY KEY (`games_id`,`type`),
  KEY `banks_id` (`banking_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `games_banking`
--

INSERT INTO `games_banking` (`games_id`, `profiles_id`, `banking_id`, `type`, `percent`) VALUES
(1, 1, 3, 'jackpot', 5),
(2, 1, 3, 'jackpot', 5),
(4, 1, 3, 'jackpot', 5),
(5, 1, 3, 'jackpot', 5),
(6, 1, 4, 'game', 0),
(6, 1, 5, 'profit', 20),
(7, 1, 4, 'game', 0),
(7, 1, 5, 'profit', 20),
(8, 1, 4, 'game', 0),
(8, 1, 5, 'profit', 20),
(9, 1, 4, 'game', 0),
(9, 1, 5, 'profit', 20),
(10, 1, 4, 'game', 0),
(10, 1, 5, 'profit', 20),
(49, 1, 4, 'game', 0),
(49, 1, 5, 'profit', 20),
(50, 1, 4, 'game', 0),
(50, 1, 5, 'profit', 90),
(51, 1, 4, 'game', 0),
(51, 1, 5, 'profit', 90),
(52, 1, 4, 'game', 0),
(52, 1, 5, 'profit', 90),
(48, 1, 4, 'game', 0),
(48, 1, 5, 'profit', 90),
(1, 1, 4, 'game', 0),
(1, 1, 5, 'profit', 30),
(2, 1, 4, 'game', 0),
(2, 1, 5, 'profit', 10),
(4, 1, 4, 'game', 0),
(4, 1, 5, 'profit', 10),
(5, 1, 4, 'game', 0),
(5, 1, 5, 'profit', 10),
(6, 1, 3, 'jackpot', 10),
(7, 1, 3, 'jackpot', 10),
(8, 1, 3, 'jackpot', 10),
(9, 1, 3, 'jackpot', 10),
(10, 1, 3, 'jackpot', 10),
(11, 1, 4, 'game', 0),
(11, 1, 5, 'profit', 30),
(11, 1, 3, 'jackpot', 5),
(12, 1, 4, 'game', 0),
(12, 1, 5, 'profit', 50),
(12, 1, 3, 'jackpot', 1),
(13, 1, 4, 'game', 0),
(13, 1, 5, 'profit', 20),
(13, 1, 3, 'jackpot', 10),
(14, 1, 4, 'game', 0),
(14, 1, 5, 'profit', 20),
(14, 1, 3, 'jackpot', 10),
(15, 1, 4, 'game', 0),
(15, 1, 5, 'profit', 20),
(15, 1, 3, 'jackpot', 10),
(16, 1, 4, 'game', 0),
(16, 1, 5, 'profit', 20),
(16, 1, 3, 'jackpot', 10),
(17, 1, 4, 'game', 0),
(17, 1, 5, 'profit', 20),
(17, 1, 3, 'jackpot', 10),
(18, 1, 4, 'game', 0),
(18, 1, 5, 'profit', 20),
(18, 1, 3, 'jackpot', 10),
(19, 1, 4, 'game', 0),
(19, 1, 5, 'profit', 20),
(19, 1, 3, 'jackpot', 10),
(20, 1, 4, 'game', 0),
(20, 1, 5, 'profit', 20),
(20, 1, 3, 'jackpot', 10),
(21, 1, 4, 'game', 0),
(21, 1, 5, 'profit', 20),
(21, 1, 3, 'jackpot', 10),
(22, 1, 4, 'game', 0),
(22, 1, 5, 'profit', 20),
(22, 1, 3, 'jackpot', 10),
(24, 1, 4, 'game', 0),
(24, 1, 5, 'profit', 20),
(24, 1, 3, 'jackpot', 10),
(23, 1, 4, 'game', 0),
(23, 1, 5, 'profit', 20),
(23, 1, 3, 'jackpot', 10),
(25, 1, 4, 'game', 0),
(25, 1, 5, 'profit', 20),
(25, 1, 3, 'jackpot', 10),
(26, 1, 4, 'game', 0),
(26, 1, 5, 'profit', 20),
(26, 1, 3, 'jackpot', 10),
(27, 1, 4, 'game', 0),
(27, 1, 5, 'profit', 95),
(27, 1, 3, 'jackpot', 1),
(28, 1, 4, 'game', 0),
(28, 1, 5, 'profit', 20),
(28, 1, 3, 'jackpot', 10),
(29, 1, 4, 'game', 0),
(29, 1, 5, 'profit', 20),
(29, 1, 3, 'jackpot', 10),
(30, 1, 4, 'game', 0),
(30, 1, 5, 'profit', 20),
(30, 1, 3, 'jackpot', 10),
(31, 1, 4, 'game', 0),
(31, 1, 5, 'profit', 20),
(31, 1, 3, 'jackpot', 10),
(32, 1, 4, 'game', 0),
(32, 1, 5, 'profit', 20),
(32, 1, 3, 'jackpot', 10),
(33, 1, 4, 'game', 0),
(33, 1, 5, 'profit', 20),
(33, 1, 3, 'jackpot', 10),
(34, 1, 4, 'game', 0),
(34, 1, 5, 'profit', 20),
(34, 1, 3, 'jackpot', 10),
(35, 1, 4, 'game', 0),
(35, 1, 5, 'profit', 20),
(35, 1, 3, 'jackpot', 10),
(36, 1, 4, 'game', 0),
(36, 1, 5, 'profit', 20),
(36, 1, 3, 'jackpot', 10),
(37, 1, 4, 'game', 0),
(37, 1, 5, 'profit', 20),
(37, 1, 3, 'jackpot', 10),
(38, 1, 4, 'game', 0),
(38, 1, 5, 'profit', 20),
(38, 1, 3, 'jackpot', 10),
(39, 1, 4, 'game', 0),
(39, 1, 5, 'profit', 20),
(39, 1, 3, 'jackpot', 10),
(40, 1, 4, 'game', 0),
(40, 1, 5, 'profit', 20),
(40, 1, 3, 'jackpot', 10),
(41, 1, 4, 'game', 0),
(41, 1, 5, 'profit', 20),
(41, 1, 3, 'jackpot', 10),
(42, 1, 4, 'game', 0),
(42, 1, 5, 'profit', 50),
(43, 1, 4, 'game', 0),
(43, 1, 5, 'profit', 20),
(45, 1, 4, 'game', 0),
(45, 1, 5, 'profit', 20),
(46, 1, 4, 'game', 0),
(46, 1, 5, 'profit', 20),
(44, 1, 4, 'game', 0),
(44, 1, 5, 'profit', 20),
(47, 1, 4, 'game', 0),
(47, 1, 5, 'profit', 20),
(47, 1, 3, 'jackpot', 10),
(54, 1, 4, 'game', 0),
(54, 1, 5, 'profit', 20),
(56, 1, 4, 'game', 1),
(56, 1, 5, 'profit', 20),
(56, 1, 3, 'jackpot', 10);

-- --------------------------------------------------------

--
-- Table structure for table `games_setting`
--

CREATE TABLE IF NOT EXISTS `games_setting` (
  `games_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `profiles_id` int(10) unsigned NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL DEFAULT '',
  `value` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`games_id`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=57 ;

--
-- Dumping data for table `games_setting`
--

INSERT INTO `games_setting` (`games_id`, `profiles_id`, `name`, `value`) VALUES
(1, 1, 'wildchar_win_multiplication', '2'),
(1, 1, 'double_4_chance', '5'),
(1, 1, 'double_2_chance', '5'),
(1, 1, 'bonus_chance', '5'),
(1, 1, 'win_chance', '4'),
(1, 1, 'coin_size', '1'),
(1, 1, 'win_coins_super', '15'),
(1, 1, 'win_coins_big', '30'),
(1, 1, 'win_coins_avg', '40'),
(1, 1, 'win_coins_small', '15'),
(2, 1, 'wildchar_win_multiplication', '2'),
(2, 1, 'double_4_chance', '8'),
(2, 1, 'double_2_chance', '8'),
(2, 1, 'bonus_chance', '99'),
(2, 1, 'win_chance', '4'),
(2, 1, 'coin_size', '1'),
(2, 1, 'win_coins_super', '9'),
(2, 1, 'win_coins_big', '1'),
(2, 1, 'win_coins_avg', '20'),
(2, 1, 'win_coins_small', '70'),
(4, 1, 'wildchar_win_multiplication', '2'),
(4, 1, 'double_4_chance', '8'),
(4, 1, 'double_2_chance', '8'),
(4, 1, 'bonus_chance', '6'),
(4, 1, 'win_chance', '5'),
(4, 1, 'coin_size', '1'),
(4, 1, 'win_coins_super', '1'),
(4, 1, 'win_coins_big', '9'),
(4, 1, 'win_coins_avg', '40'),
(4, 1, 'win_coins_small', '40'),
(5, 1, 'wildchar_win_multiplication', '2'),
(5, 1, 'double_4_chance', '3'),
(5, 1, 'double_2_chance', '3'),
(5, 1, 'bonus_chance', '2'),
(5, 1, 'win_chance', '2'),
(5, 1, 'coin_size', '1'),
(5, 1, 'win_coins_super', '20'),
(5, 1, 'win_coins_big', '40'),
(5, 1, 'win_coins_avg', '30'),
(5, 1, 'win_coins_small', '10'),
(6, 1, 'wildchar_win_multiplication', '2'),
(6, 1, 'double_4_chance', '8'),
(6, 1, 'double_2_chance', '8'),
(6, 1, 'bonus_chance', '99'),
(6, 1, 'win_chance', '10'),
(6, 1, 'coin_size', '1'),
(6, 1, 'win_coins_super', '10'),
(6, 1, 'win_coins_big', '5'),
(6, 1, 'win_coins_avg', '20'),
(6, 1, 'win_coins_small', '65'),
(7, 1, 'wildchar_win_multiplication', '2'),
(7, 1, 'double_4_chance', '2'),
(7, 1, 'double_2_chance', '2'),
(7, 1, 'bonus_chance', '3'),
(7, 1, 'win_chance', '2'),
(7, 1, 'coin_size', '1'),
(7, 1, 'win_coins_super', '30'),
(7, 1, 'win_coins_big', '40'),
(7, 1, 'win_coins_avg', '20'),
(7, 1, 'win_coins_small', '10'),
(8, 1, 'wildchar_win_multiplication', '2'),
(8, 1, 'double_4_chance', '4'),
(8, 1, 'double_2_chance', '2'),
(8, 1, 'bonus_chance', '99'),
(8, 1, 'win_chance', '2'),
(8, 1, 'coin_size', '1'),
(8, 1, 'win_coins_super', '1'),
(8, 1, 'win_coins_big', '4'),
(8, 1, 'win_coins_avg', '15'),
(8, 1, 'win_coins_small', '80'),
(9, 1, 'wildchar_win_multiplication', '2'),
(9, 1, 'double_4_chance', '8'),
(9, 1, 'double_2_chance', '2'),
(9, 1, 'bonus_chance', '6'),
(9, 1, 'win_chance', '4'),
(9, 1, 'coin_size', '1'),
(9, 1, 'win_coins_super', '11'),
(9, 1, 'win_coins_big', '9'),
(9, 1, 'win_coins_avg', '50'),
(9, 1, 'win_coins_small', '30'),
(10, 1, 'wildchar_win_multiplication', '2'),
(10, 1, 'double_4_chance', '8'),
(10, 1, 'double_2_chance', '8'),
(10, 1, 'bonus_chance', '2'),
(10, 1, 'win_chance', '6'),
(10, 1, 'coin_size', '1'),
(10, 1, 'win_coins_super', '30'),
(10, 1, 'win_coins_big', '40'),
(10, 1, 'win_coins_avg', '20'),
(10, 1, 'win_coins_small', '10'),
(11, 1, 'wildchar_win_multiplication', '2'),
(11, 1, 'double_4_chance', '8'),
(11, 1, 'double_2_chance', '8'),
(11, 1, 'bonus_chance', '3'),
(11, 1, 'win_chance', '3'),
(11, 1, 'coin_size', '1'),
(11, 1, 'win_coins_super', '40'),
(11, 1, 'win_coins_big', '40'),
(11, 1, 'win_coins_avg', '10'),
(11, 1, 'win_coins_small', '10'),
(12, 1, 'wildchar_win_multiplication', '4'),
(12, 1, 'onfree_win_multiplication', '3'),
(12, 1, 'onfree_win_chance', '6'),
(12, 1, 'onfree_free_game_chance', '12'),
(12, 1, 'win_chance', '1'),
(12, 1, 'free_game_chance', '5'),
(12, 1, 'coin_size', '1'),
(12, 1, 'win_coins_super', '1'),
(12, 1, 'win_coins_big', '9'),
(12, 1, 'win_coins_avg', '20'),
(12, 1, 'win_coins_small', '70'),
(27, 1, 'coin_size', '1.00'),
(27, 1, 'win_chance', '15'),
(27, 1, 'bonus1_chance', '15'),
(27, 1, 'bonus2_chance', '15'),
(27, 1, 'win_coins_super', '1'),
(27, 1, 'win_coins_big', '1'),
(27, 1, 'win_coins_avg', '1'),
(27, 1, 'win_coins_small', '1'),
(42, 1, 'coin_size', '1'),
(42, 1, 'mode', '1'),
(42, 1, 'win_chance', '2'),
(49, 1, 'player_win_chance', '5'),
(49, 1, 'banker_win_chance', '6'),
(49, 1, 'tie_win_chance', '9'),
(50, 1, 'win_chance', '9'),
(51, 1, 'win_chance', '9'),
(52, 1, 'win_chance', '9'),
(13, 1, 'wildchar_win_multiplication', '4'),
(13, 1, 'onfree_win_multiplication', '3'),
(13, 1, 'onfree_win_chance', '6'),
(13, 1, 'onfree_free_game_chance', '12'),
(13, 1, 'win_chance', '4'),
(13, 1, 'free_game_chance', '5'),
(13, 1, 'win_coins_super', '1'),
(13, 1, 'win_coins_big', '9'),
(13, 1, 'win_coins_avg', '70'),
(13, 1, 'win_coins_small', '20'),
(14, 1, 'wildchar_win_multiplication', '4'),
(14, 1, 'onfree_win_multiplication', '3'),
(14, 1, 'onfree_win_chance', '6'),
(14, 1, 'onfree_free_game_chance', '12'),
(14, 1, 'win_chance', '4'),
(14, 1, 'free_game_chance', '5'),
(14, 1, 'win_coins_super', '1'),
(14, 1, 'win_coins_big', '9'),
(14, 1, 'win_coins_avg', '70'),
(14, 1, 'win_coins_small', '20'),
(15, 1, 'wildchar_win_multiplication', '4'),
(15, 1, 'onfree_win_multiplication', '3'),
(15, 1, 'onfree_win_chance', '6'),
(15, 1, 'onfree_free_game_chance', '12'),
(15, 1, 'win_chance', '4'),
(15, 1, 'free_game_chance', '5'),
(15, 1, 'win_coins_super', '1'),
(15, 1, 'win_coins_big', '9'),
(15, 1, 'win_coins_avg', '70'),
(15, 1, 'win_coins_small', '20'),
(16, 1, 'wildchar_win_multiplication', '4'),
(16, 1, 'onfree_win_multiplication', '3'),
(16, 1, 'onfree_win_chance', '6'),
(16, 1, 'onfree_free_game_chance', '12'),
(16, 1, 'win_chance', '4'),
(16, 1, 'free_game_chance', '5'),
(16, 1, 'win_coins_super', '1'),
(16, 1, 'win_coins_big', '9'),
(16, 1, 'win_coins_avg', '70'),
(16, 1, 'win_coins_small', '20'),
(17, 1, 'wildchar_win_multiplication', '4'),
(17, 1, 'onfree_win_multiplication', '3'),
(17, 1, 'onfree_win_chance', '6'),
(17, 1, 'onfree_free_game_chance', '6'),
(17, 1, 'win_chance', '2'),
(17, 1, 'free_game_chance', '5'),
(17, 1, 'win_coins_super', '1'),
(17, 1, 'win_coins_big', '9'),
(17, 1, 'win_coins_avg', '70'),
(17, 1, 'win_coins_small', '20'),
(18, 1, 'wildchar_win_multiplication', '4'),
(18, 1, 'onfree_win_multiplication', '3'),
(18, 1, 'onfree_win_chance', '6'),
(18, 1, 'onfree_free_game_chance', '12'),
(18, 1, 'win_chance', '4'),
(18, 1, 'free_game_chance', '5'),
(18, 1, 'win_coins_super', '1'),
(18, 1, 'win_coins_big', '9'),
(18, 1, 'win_coins_avg', '70'),
(18, 1, 'win_coins_small', '20'),
(19, 1, 'wildchar_win_multiplication', '4'),
(19, 1, 'onfree_win_multiplication', '3'),
(19, 1, 'onfree_win_chance', '6'),
(19, 1, 'onfree_free_game_chance', '12'),
(19, 1, 'win_chance', '4'),
(19, 1, 'free_game_chance', '5'),
(19, 1, 'win_coins_super', '1'),
(19, 1, 'win_coins_big', '9'),
(19, 1, 'win_coins_avg', '70'),
(19, 1, 'win_coins_small', '20'),
(20, 1, 'wildchar_win_multiplication', '2'),
(20, 1, 'onfree_win_multiplication', '1'),
(20, 1, 'onfree_win_chance', '2'),
(20, 1, 'onfree_free_game_chance', '2'),
(20, 1, 'win_chance', '2'),
(20, 1, 'free_game_chance', '2'),
(20, 1, 'win_coins_super', '40'),
(20, 1, 'win_coins_big', '40'),
(20, 1, 'win_coins_avg', '10'),
(20, 1, 'win_coins_small', '10'),
(21, 1, 'wildchar_win_multiplication', '4'),
(21, 1, 'onfree_win_multiplication', '3'),
(21, 1, 'onfree_win_chance', '6'),
(21, 1, 'onfree_free_game_chance', '12'),
(21, 1, 'win_chance', '4'),
(21, 1, 'free_game_chance', '5'),
(21, 1, 'win_coins_super', '1'),
(21, 1, 'win_coins_big', '9'),
(21, 1, 'win_coins_avg', '70'),
(21, 1, 'win_coins_small', '20'),
(22, 1, 'wildchar_win_multiplication', '4'),
(22, 1, 'onfree_win_multiplication', '3'),
(22, 1, 'onfree_win_chance', '6'),
(22, 1, 'onfree_free_game_chance', '12'),
(22, 1, 'win_chance', '4'),
(22, 1, 'free_game_chance', '5'),
(22, 1, 'win_coins_super', '1'),
(22, 1, 'win_coins_big', '9'),
(22, 1, 'win_coins_avg', '50'),
(22, 1, 'win_coins_small', '40'),
(23, 1, 'wildchar_win_multiplication', '4'),
(23, 1, 'onfree_win_multiplication', '3'),
(23, 1, 'onfree_win_chance', '6'),
(23, 1, 'onfree_free_game_chance', '12'),
(23, 1, 'win_chance', '4'),
(23, 1, 'free_game_chance', '5'),
(23, 1, 'win_coins_super', '1'),
(23, 1, 'win_coins_big', '9'),
(23, 1, 'win_coins_avg', '50'),
(23, 1, 'win_coins_small', '40'),
(24, 1, 'wildchar_win_multiplication', '4'),
(24, 1, 'onfree_win_multiplication', '3'),
(24, 1, 'onfree_win_chance', '6'),
(24, 1, 'onfree_free_game_chance', '12'),
(24, 1, 'win_chance', '4'),
(24, 1, 'free_game_chance', '5'),
(24, 1, 'win_coins_super', '1'),
(24, 1, 'win_coins_big', '9'),
(24, 1, 'win_coins_avg', '50'),
(24, 1, 'win_coins_small', '40'),
(25, 1, 'wildchar_win_multiplication', '4'),
(25, 1, 'onfree_win_multiplication', '3'),
(25, 1, 'onfree_win_chance', '6'),
(25, 1, 'onfree_free_game_chance', '12'),
(25, 1, 'win_chance', '4'),
(25, 1, 'free_game_chance', '5'),
(25, 1, 'win_coins_super', '1'),
(25, 1, 'win_coins_big', '9'),
(25, 1, 'win_coins_avg', '50'),
(25, 1, 'win_coins_small', '40'),
(26, 1, 'wildchar_win_multiplication', '4'),
(26, 1, 'onfree_win_multiplication', '3'),
(26, 1, 'onfree_win_chance', '6'),
(26, 1, 'onfree_free_game_chance', '12'),
(26, 1, 'win_chance', '4'),
(26, 1, 'free_game_chance', '5'),
(26, 1, 'win_coins_super', '1'),
(26, 1, 'win_coins_big', '9'),
(26, 1, 'win_coins_avg', '50'),
(26, 1, 'win_coins_small', '40'),
(13, 1, 'coin_size', '1'),
(14, 1, 'coin_size', '1'),
(15, 1, 'coin_size', '1'),
(16, 1, 'coin_size', '1'),
(17, 1, 'coin_size', '1'),
(18, 1, 'coin_size', '1'),
(19, 1, 'coin_size', '1'),
(20, 1, 'coin_size', '5'),
(21, 1, 'coin_size', '1'),
(22, 1, 'coin_size', '1'),
(23, 1, 'coin_size', '1'),
(24, 1, 'coin_size', '1'),
(25, 1, 'coin_size', '1'),
(26, 1, 'coin_size', '1'),
(28, 1, 'coin_size', '1'),
(28, 1, 'win_chance', '3'),
(28, 1, 'bonus1_chance', '5'),
(28, 1, 'bonus2_chance', '4'),
(28, 1, 'win_coins_super', '1'),
(28, 1, 'win_coins_big', '9'),
(28, 1, 'win_coins_avg', '50'),
(28, 1, 'win_coins_small', '40'),
(29, 1, 'coin_size', '1'),
(29, 1, 'win_chance', '4'),
(29, 1, 'bonus1_chance', '5'),
(29, 1, 'bonus2_chance', '4'),
(29, 1, 'win_coins_super', '1'),
(29, 1, 'win_coins_big', '9'),
(29, 1, 'win_coins_avg', '50'),
(29, 1, 'win_coins_small', '40'),
(30, 1, 'coin_size', '1'),
(30, 1, 'win_chance', '4'),
(30, 1, 'bonus1_chance', '4'),
(30, 1, 'bonus2_chance', '4'),
(30, 1, 'win_coins_super', '1'),
(30, 1, 'win_coins_big', '9'),
(30, 1, 'win_coins_avg', '50'),
(30, 1, 'win_coins_small', '40'),
(32, 1, 'coin_size', '1'),
(32, 1, 'win_chance', '4'),
(32, 1, 'bonus1_chance', '5'),
(32, 1, 'bonus2_chance', '4'),
(32, 1, 'win_coins_super', '1'),
(32, 1, 'win_coins_big', '9'),
(32, 1, 'win_coins_avg', '40'),
(32, 1, 'win_coins_small', '50'),
(33, 1, 'coin_size', '1'),
(33, 1, 'win_chance', '3'),
(33, 1, 'bonus1_chance', '4'),
(33, 1, 'bonus2_chance', '5'),
(33, 1, 'win_coins_super', '1'),
(33, 1, 'win_coins_big', '9'),
(33, 1, 'win_coins_avg', '40'),
(33, 1, 'win_coins_small', '50'),
(34, 1, 'coin_size', '1'),
(34, 1, 'win_chance', '3'),
(34, 1, 'bonus1_chance', '4'),
(34, 1, 'bonus2_chance', '5'),
(34, 1, 'win_coins_super', '1'),
(34, 1, 'win_coins_big', '9'),
(34, 1, 'win_coins_avg', '40'),
(34, 1, 'win_coins_small', '50'),
(35, 1, 'coin_size', '1'),
(35, 1, 'win_chance', '3'),
(35, 1, 'bonus1_chance', '4'),
(35, 1, 'bonus2_chance', '5'),
(35, 1, 'win_coins_super', '1'),
(35, 1, 'win_coins_big', '9'),
(35, 1, 'win_coins_avg', '40'),
(35, 1, 'win_coins_small', '50'),
(36, 1, 'coin_size', '1'),
(36, 1, 'win_chance', '4'),
(36, 1, 'bonus1_chance', '5'),
(36, 1, 'bonus2_chance', '5'),
(36, 1, 'win_coins_super', '1'),
(36, 1, 'win_coins_big', '9'),
(36, 1, 'win_coins_avg', '40'),
(36, 1, 'win_coins_small', '50'),
(37, 1, 'coin_size', '1'),
(37, 1, 'win_chance', '4'),
(37, 1, 'bonus1_chance', '4'),
(37, 1, 'bonus2_chance', '5'),
(37, 1, 'win_coins_super', '1'),
(37, 1, 'win_coins_big', '9'),
(37, 1, 'win_coins_avg', '40'),
(37, 1, 'win_coins_small', '50'),
(38, 1, 'coin_size', '1'),
(38, 1, 'win_chance', '4'),
(38, 1, 'bonus1_chance', '4'),
(38, 1, 'bonus2_chance', '5'),
(38, 1, 'win_coins_super', '1'),
(38, 1, 'win_coins_big', '9'),
(38, 1, 'win_coins_avg', '40'),
(38, 1, 'win_coins_small', '50'),
(39, 1, 'coin_size', '1'),
(39, 1, 'win_chance', '4'),
(39, 1, 'bonus1_chance', '4'),
(39, 1, 'bonus2_chance', '5'),
(39, 1, 'win_coins_super', '1'),
(39, 1, 'win_coins_big', '9'),
(39, 1, 'win_coins_avg', '40'),
(39, 1, 'win_coins_small', '50'),
(40, 1, 'coin_size', '1'),
(40, 1, 'win_chance', '4'),
(40, 1, 'bonus1_chance', '5'),
(40, 1, 'bonus2_chance', '5'),
(40, 1, 'win_coins_super', '1'),
(40, 1, 'win_coins_big', '9'),
(40, 1, 'win_coins_avg', '40'),
(40, 1, 'win_coins_small', '50'),
(41, 1, 'coin_size', '1'),
(41, 1, 'win_chance', '4'),
(41, 1, 'bonus1_chance', '5'),
(41, 1, 'bonus2_chance', '5'),
(41, 1, 'win_coins_super', '1'),
(41, 1, 'win_coins_big', '9'),
(41, 1, 'win_coins_avg', '40'),
(41, 1, 'win_coins_small', '50'),
(47, 1, 'coin_size', '1.08'),
(47, 1, 'win_chance', '3'),
(47, 1, 'bonus1_chance', '3'),
(47, 1, 'bonus2_chance', '3'),
(47, 1, 'win_coins_super', '1'),
(47, 1, 'win_coins_big', '9'),
(47, 1, 'win_coins_avg', '30'),
(47, 1, 'win_coins_small', '60'),
(43, 1, 'coin_size', '1'),
(43, 1, 'win_chance', '4'),
(43, 1, 'mode', '1'),
(44, 1, 'coin_size', '1'),
(44, 1, 'win_chance', '4'),
(44, 1, 'mode', '1'),
(45, 1, 'coin_size', '1'),
(45, 1, 'win_chance', '4'),
(45, 1, 'mode', '1'),
(46, 1, 'coin_size', '1'),
(46, 1, 'win_chance', '4'),
(46, 1, 'mode', '1'),
(54, 1, 'win_chance', '4'),
(56, 1, 'wildchar_win_multiplication', '4'),
(56, 1, 'onfree_win_multiplication', '12'),
(56, 1, 'onfree_win_chance', '3'),
(56, 1, 'onfree_free_game_chance', '12'),
(56, 1, 'win_chance', '3'),
(56, 1, 'free_game_chance', '3'),
(56, 1, 'win_coins_super', '1'),
(56, 1, 'win_coins_big', '9'),
(56, 1, 'win_coins_avg', '30'),
(56, 1, 'win_coins_small', '60'),
(56, 1, 'coin_size', '1'),
(48, 1, 'coin_size', '1.00'),
(48, 1, 'win_chance', '5'),
(31, 1, 'win_coins_small', '50'),
(31, 1, 'win_coins_avg', '40'),
(31, 1, 'win_coins_big', '9'),
(31, 1, 'win_coins_super', '1'),
(31, 1, 'bonus2_chance', '4'),
(31, 1, 'bonus1_chance', '5'),
(31, 1, 'win_chance', '4'),
(31, 1, 'coin_size', '1');

-- --------------------------------------------------------

--
-- Table structure for table `jackpot`
--

CREATE TABLE IF NOT EXISTS `jackpot` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  `amount` double DEFAULT NULL,
  `default` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jackpot`
--

INSERT INTO `jackpot` (`id`, `title`, `amount`, `default`) VALUES
(1, 'Jackpot', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `controllers_id` bigint(20) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `controllers_id` (`controllers_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=57 ;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `controllers_id`, `name`) VALUES
(1, 1, 'lasvegas'),
(2, 1, 'captaincavern'),
(3, 1, 'crazydoctors'),
(4, 1, 'london'),
(5, 1, 'new_york'),
(6, 1, 'paris'),
(7, 1, 'rue_commerce'),
(8, 1, 'sergent_pepper'),
(9, 1, 'shinobi'),
(10, 1, 'tokyo'),
(11, 1, 'cartoons'),
(13, 1, 'happy_christmas'),
(14, 1, 'indiana_croft'),
(15, 1, 'james_band'),
(16, 1, 'jules_verne'),
(17, 1, 'just_married'),
(18, 1, 'mah_jong'),
(19, 1, 'new_year_eve'),
(20, 1, 'pantheon'),
(21, 1, 'royal_fruit'),
(22, 1, 'safari'),
(23, 1, 'space_runners'),
(24, 1, 'super_heroes'),
(25, 1, 'world_cup'),
(26, 1, 'davinci'),
(27, 1, 'atlantis'),
(28, 1, 'dartagnan'),
(29, 1, 'dracula'),
(30, 1, 'gladiator'),
(31, 1, 'happy_farm'),
(32, 1, 'jungle_jimmy'),
(33, 1, 'jurassic_world'),
(34, 1, 'lucky_luke'),
(35, 1, 'luna_park'),
(36, 1, 'mafia_boss'),
(37, 1, 'mont_blanc'),
(38, 1, 'navy'),
(39, 1, 'numbers'),
(40, 1, 'small_life'),
(41, 1, 'zorro'),
(42, 1, 'candies'),
(43, 1, 'corona'),
(44, 1, 'grizzly'),
(45, 1, 'liberty_bell'),
(46, 1, 'marilyn'),
(47, 1, 'devils_bikers'),
(48, 1, 'roulette_silver'),
(49, 1, 'baccarat'),
(50, 1, 'black_jack_diamond'),
(51, 1, 'black_jack_gold'),
(52, 1, 'black_jack_silver'),
(53, 1, 'caribbean_poker'),
(54, 1, 'jacks_or_better');

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE IF NOT EXISTS `merchant` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `form` text NOT NULL,
  `secret_key` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`id`, `name`, `form`, `secret_key`) VALUES
(3, 'w1', '<form name="paymentform" method="post" action="/pay/w1/w1.php?prepare=1">\r\n <input type="hidden" name="w1_sum" value="%s">\r\n <input type="hidden" name="w1_num" value="%s">\r\n <input type="submit" />\r\n</form>', '   '),
(5, 'w1', '<?\r\nerror_reporting(0) ;\r\n//вытаскиваем общее количество платежей \r\n $query = mysql_query("SELECT COUNT(*) from stat_pay "); \r\n $spShopPaymentId = mysql_result($query, 0);\r\n  mysql_free_result($query);\r\n $spShopPaymentId += 1 ;// номер платежа, опцианально\r\n $amount = "100.00" ;\r\n $btn = "Выписать счет" ;\r\n $error = 0 ;\r\n?>\r\n<table width="100%">\r\n <b>ПОПОЛНЕНИЕ СЧЕТА ЧЕРЕЗ СИСТЕМУ<a href="http://w1.ru/"><img src="w1/logo_ru.gif"  style=''border:1px solid #CCC;''></a></b>\r\n <tbody>\r\n  <tr vAlign=top>\r\n   <td>\r\n    <br /><br />\r\n     Оплата осуществляется через \r\n     систему\r\n     <a href="http://www.w1.ru/" target="_blank" style="color: silver;">Единая касса</a>.\r\n     <br /> Минимальная платежа&nbsp;— <b>0.01 руб.</b>\r\n     <br /><br />Выберите желаемую сумму, для оплаты нажмите кнопку\r\n     <br /> "пополнить счет", затем выберите систему с которой\r\n     <br /> Вы желаете оплатить, оплаченная Вами сумма будет\r\n     <br /> зачислена на Ваш счет в течении нескольких минут . \r\n     <br /><br />Номер платежа: <?=$spShopPaymentId ?>\r\n     <br />\r\n\r\n<? if ( !isset($_GET[''prepare''] ) ){ ?>\r\n     <form method="post" action="/lobby/in.php?prepare=1&#w1_submit">\r\n      <input type="text" size="10" maxlength="10" name="w1_sum" value="<?=$amount;?>"> Руб.\r\n      <input type="hidden" name="w1_num" value="<?=$spShopPaymentId;?>">\r\n      <input type="submit" class="windowbutt" value="<?=$btn;?>">\r\n     </form>\r\n<?}?>\r\n<?if ( isset($_GET[''prepare''] ) )  {?>\r\n     <a name="#w1_submit"></a>\r\n<? $class = "windowbutt" ;  include ( ''w1/w1.php'') ;}?>\r\n    <br /><br />\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>', '        '),
(6, 'w1', '<?\r\nerror_reporting(0) ;\r\n//вытаскиваем общее количество платежей \r\n $query = mysql_query("SELECT COUNT(*) from stat_pay "); \r\n $spShopPaymentId = mysql_result($query, 0);\r\n  mysql_free_result($query);\r\n $spShopPaymentId += 1 ;// номер платежа, опцианально\r\n $amount = "100.00" ;\r\n $btn = "Выписать счет" ;\r\n $error = 0 ;\r\n?>\r\n<table width="100%">\r\n <b>ПОПОЛНЕНИЕ СЧЕТА ЧЕРЕЗ СИСТЕМУ<a href="http://w1.ru/"><img src="w1/logo_ru.gif"  style=''border:1px solid #CCC;''></a></b>\r\n <tbody>\r\n  <tr vAlign=top>\r\n   <td>\r\n    <br /><br />\r\n     Оплата осуществляется через \r\n     систему\r\n     <a href="http://www.w1.ru/" target="_blank" style="color: silver;">Единая касса</a>.\r\n     <br /> Минимальная платежа&nbsp;— <b>0.01 руб.</b>\r\n     <br /><br />Выберите желаемую сумму, для оплаты нажмите кнопку\r\n     <br /> "пополнить счет", затем выберите систему с которой\r\n     <br /> Вы желаете оплатить, оплаченная Вами сумма будет\r\n     <br /> зачислена на Ваш счет в течении нескольких минут . \r\n     <br /><br />Номер платежа: <?=$spShopPaymentId ?>\r\n     <br />\r\n\r\n<? if ( !isset($_GET[''prepare''] ) ){ ?>\r\n     <form method="post" action="/lobby/in.php?prepare=1&#w1_submit">\r\n      <input type="text" size="10" maxlength="10" name="w1_sum" value="<?=$amount;?>"> Руб.\r\n      <input type="hidden" name="w1_num" value="<?=$spShopPaymentId;?>">\r\n      <input type="submit" class="windowbutt" value="<?=$btn;?>">\r\n     </form>\r\n<?}?>\r\n<?if ( isset($_GET[''prepare''] ) )  {?>\r\n     <a name="#w1_submit"></a>\r\n<? $class = "windowbutt" ;  include ( ''w1/w1.php'') ;}?>\r\n    <br /><br />\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>', '     '),
(7, 'w1', '<?\r\nerror_reporting(0) ;\r\n//вытаскиваем общее количество платежей \r\n $query = mysql_query("SELECT COUNT(*) from stat_pay "); \r\n $spShopPaymentId = mysql_result($query, 0);\r\n  mysql_free_result($query);\r\n $spShopPaymentId += 1 ;// номер платежа, опцианально\r\n $amount = "100.00" ;\r\n $btn = "Выписать счет" ;\r\n $error = 0 ;\r\n?>\r\n<table width="100%">\r\n <b>ПОПОЛНЕНИЕ СЧЕТА ЧЕРЕЗ СИСТЕМУ<a href="http://w1.ru/"><img src="w1/logo_ru.gif"  style=''border:1px solid #CCC;''></a></b>\r\n <tbody>\r\n  <tr vAlign=top>\r\n   <td>\r\n    <br /><br />\r\n     Оплата осуществляется через \r\n     систему\r\n     <a href="http://www.w1.ru/" target="_blank" style="color: silver;">Единая касса</a>.\r\n     <br /> Минимальная платежа&nbsp;— <b>0.01 руб.</b>\r\n     <br /><br />Выберите желаемую сумму, для оплаты нажмите кнопку\r\n     <br /> "пополнить счет", затем выберите систему с которой\r\n     <br /> Вы желаете оплатить, оплаченная Вами сумма будет\r\n     <br /> зачислена на Ваш счет в течении нескольких минут . \r\n     <br /><br />Номер платежа: <?=$spShopPaymentId ?>\r\n     <br />\r\n\r\n<? if ( !isset($_GET[''prepare''] ) ){ ?>\r\n     <form method="post" action="/lobby/in.php?prepare=1&#w1_submit">\r\n      <input type="text" size="10" maxlength="10" name="w1_sum" value="<?=$amount;?>"> Руб.\r\n      <input type="hidden" name="w1_num" value="<?=$spShopPaymentId;?>">\r\n      <input type="submit" class="windowbutt" value="<?=$btn;?>">\r\n     </form>\r\n<?}?>\r\n<?if ( isset($_GET[''prepare''] ) )  {?>\r\n     <a name="#w1_submit"></a>\r\n<? $class = "windowbutt" ;  include ( ''w1/w1.php'') ;}?>\r\n    <br /><br />\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>', '  '),
(8, 'w1', '<?\r\nerror_reporting(0) ;\r\n//вытаскиваем общее количество платежей \r\n $query = mysql_query("SELECT COUNT(*) from stat_pay "); \r\n $spShopPaymentId = mysql_result($query, 0);\r\n  mysql_free_result($query);\r\n $spShopPaymentId += 1 ;// номер платежа, опцианально\r\n $amount = "100.00" ;\r\n $btn = "Выписать счет" ;\r\n $error = 0 ;\r\n?>\r\n<table width="100%">\r\n <b>ПОПОЛНЕНИЕ СЧЕТА ЧЕРЕЗ СИСТЕМУ<a href="http://w1.ru/"><img src="w1/logo_ru.gif"  style=''border:1px solid #CCC;''></a></b>\r\n <tbody>\r\n  <tr vAlign=top>\r\n   <td>\r\n    <br /><br />\r\n     Оплата осуществляется через \r\n     систему\r\n     <a href="http://www.w1.ru/" target="_blank" style="color: silver;">Единая касса</a>.\r\n     <br /> Минимальная платежа&nbsp;— <b>0.01 руб.</b>\r\n     <br /><br />Выберите желаемую сумму, для оплаты нажмите кнопку\r\n     <br /> "пополнить счет", затем выберите систему с которой\r\n     <br /> Вы желаете оплатить, оплаченная Вами сумма будет\r\n     <br /> зачислена на Ваш счет в течении нескольких минут . \r\n     <br /><br />Номер платежа: <?=$spShopPaymentId ?>\r\n     <br />\r\n\r\n<? if ( !isset($_GET[''prepare''] ) ){ ?>\r\n     <form method="post" action="/lobby/in.php?prepare=1&#w1_submit">\r\n      <input type="text" size="10" maxlength="10" name="w1_sum" value="<?=$amount;?>"> Руб.\r\n      <input type="hidden" name="w1_num" value="<?=$spShopPaymentId;?>">\r\n      <input type="submit" class="windowbutt" value="<?=$btn;?>">\r\n     </form>\r\n<?}?>\r\n<?if ( isset($_GET[''prepare''] ) )  {?>\r\n     <a name="#w1_submit"></a>\r\n<? $class = "windowbutt" ;  include ( ''w1/w1.php'') ;}?>\r\n    <br /><br />\r\n   </td>\r\n  </tr>\r\n </tbody>\r\n</table>', '   ');

-- --------------------------------------------------------

--
-- Table structure for table `merchant_request`
--

CREATE TABLE IF NOT EXISTS `merchant_request` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `merchant_id` int(10) unsigned NOT NULL DEFAULT '0',
  `payment_id` text NOT NULL,
  `amount` float unsigned NOT NULL DEFAULT '0',
  `credit` float unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `currency_id` int(10) unsigned NOT NULL DEFAULT '0',
  `time_begin` int(10) unsigned NOT NULL DEFAULT '0',
  `time_end` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `merchant_request`
--


-- --------------------------------------------------------

--
-- Table structure for table `mp3`
--

CREATE TABLE IF NOT EXISTS `mp3` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `artist` text,
  `track` text,
  `file` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `mp3`
--

INSERT INTO `mp3` (`id`, `artist`, `track`, `file`) VALUES
(13, 'Robbie Williams', 'Ain''t that a kikin'' the head', 'robbie_williams-ain''t_that_a_kikin''_the_head.mp3'),
(15, 'Robbie Williams', 'Mack the knife', 'robbie_williams-mack_the_knife.mp3'),
(14, 'Robbie Williams', 'Have you met Miss Jones', 'robbie_williams-have_you_met_miss_jones.mp3'),
(16, 'Robbie Williams', 'Things', 'robbie_williams-things.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  `body_en` text,
  `body_ru` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `body_en`, `body_ru`) VALUES
(1, 'Помощь', 'The casino Vezuviy-Flash can play for real money or play money. Game play money gives the opportunity to review the rules of games and internals casino. Play for real money you must have a positive account balance. When making the stakes account balance is reduced by the amount of the bet. When winning the account balance plus any winnings.\n\nAll games are held according to the casino rules Vezuviy-Flash, which\ncan be found in the relevant sections of the window "right."\nThe casino Vezuviy-Flash minimum bid of only 1 cent!\n\nDealer (surrendering) casino Vezuviy-Flash is the computer. The numbers, which up all possible combinations in a casino, and are generated by a computer\nentirely random. Our casino is truly "secure." All data\nbetween your computer and the casino are transmitted over an encrypted SSL 3.0, supports key length of 128 bits. In addition, all the data on your payments go directly to the processing center, and are not stored on the server casino\n that provides 100% protection against possible theft of your credit numbers\ncards.\n\nThe casino Vezuviy-Flash payments are made on the same day on working days (if the request for payment is received before 18 hours Central European time on the business day of the week). You can get a win in any possible way to the casino. Withdrawal is done by rules of payments. All costs associated with the payment of winnings, regardless of the amount and payment system takes care of the player.\n\nInternet casino owner "Vezuviy-Flash" is the company FRANFOX Corp., East 53rd Street, Marbella MMG Building, 2nd Floor, Republic of Panama.\n\nFor any requests support@vezuviy.net', 'В казино Vezuviy-Flash возможно играть как на реальные деньги, так и на виртуальные деньги. Игра на виртуальные деньги дает возможность ознакомиться с правилами игр и внутренним устройством казино. Игра на реальные деньги возможна только при положительном балансе игрового счета. При совершении ставки в игре баланс игрового счета уменьшается на сумму сделанной ставки. При выигрыше баланс игрового счета увеличивается на сумму выигрыша.\n\nВсе игры проводятся по действующим в казино Vezuviy-Flash правилам, с которыми\nможно ознакомиться в соответствующих разделах окна "ПРАВИЛА".\nВ казино Vezuviy-Flash минимальная ставка составляет всего 1 цент! \n\nКрупье (сдающим) в казино Vezuviy-Flash является компьютер. Числа, задающие выпадение всех комбинаций в казино, генерируются компьютером и являются\nабсолютно случайными. Наше казино является воистину "защищенным". Все данные\nмежду Вашим компьютером и казино передаются по защищенному протоколу SSL 3.0, поддерживающему длину ключа в 128 бит. Кроме того, все данные о Ваших платежах поступают непосредственно в процессинговый центр, а не хранятся на сервере казино,\n что обеспечивает 100% защиту от возможного воровства номеров Ваших кредитных\nкарт.\n\nВ казино Vezuviy-Flash выплаты осуществляются день в день в рабочие дни (если запрос на выплату поступил до 18-ти часов по среднеевропейскому времени в рабочий день недели). Получить выигрыш Вы можете любым возможным в казино способом. Выплата выигрышей осуществляется по правилам выплат. Все затраты, связанные с выплатой выигрышей, независимо от суммы и платежной системы, берет на себя игрок. \n\nВладельцем интернет казино "Vezuviy-Flash" является компания FRANFOX Corp., East 53rd Street, Marbella MMG Building, 2nd Floor, Republic of Panama.\n\nПо любым вопросом обращайтесь support@vezuviy.net'),
(2, 'Правила', 'Visiting a site online casino, opening of account and using it, taking part in games organized Internet casinos, performing any other activities related to participation in the games and promotions conducted by online casinos accepting any prize, the player that declares that he understands and agrees to these Terms and Conditions and agrees to abide by them, and declares and warrants that:\n\n 1. The player is an adult and capable citizen in the legal definition of the term in the country of their citizenship.\n\n 2. Player has the complete and unrestricted legal right to participate in games of chance on the internet. Player understands that he bears personal responsibility for the violation of the law of their country of residence regarding online gambling (gambling or betting may be illegal in the jurisdiction of the host player ..\n\n 3. Player understands that the Games are for fun, and interesting players to the online casino is personal. Use of the online casino for any other purpose, including professional, is prohibited.\n\n 4. Player understands that participation in the Games is solely his choice and risk.\n\n 5. Player understands that the results of the games are based solely on random events, which is used to model the random number generator online casino.\n\n 6. Identification Team site online casino and access to the score made by the player credentials: username and password.\n Username (login) - a unique public alphanumeric name that player chooses and specifies when registering yourself in the online casino.\n Password (password) - secret alphanumeric sequence that the player selects and specifies yourself when registering online casino for Internet-Casino on its behalf.\n\n 7. Player understands and accepts that he must keep his password secret from third parties, not to disclose it to anyone. Player may from time to time at its discretion to change the password to enhance the security of your account in the online casino. In case of loss or disclosure of the Player shall immediately notify the administration of the online casino and change the password.\n \n 8. Any action taken by using the credentials of the Player (username and password) are committed by the player. A player is not entitled to demand from the online casino withdrawal of financial transactions on his account, if the transaction were committed with the use of his credentials.\n \n 9. The player has no right to authorize any other person or third party, including minors, to play the game in its own name (your login and password ..\n \n 10. A player can have in the online casino several game accounts. Number of accounts opened by the same player, defines its needs for the game. In that case, if a player abuses given the opportunity to open the game accounts in more than one, the administration of the online casino has the right to warn the player about the inadmissibility of such actions and prohibit him from opening new accounts in the game later.\n \n 11. Players are allowed to publish your login in the list of participants held games and activities, a list of winners, news and any other informational materials online casino.\n \n 12. When you register at the online casino and the opening of a game account is recommended that the player real data about themselves (name, contact landline number and other information in accordance with the registration form).\n \n 13. When you register at the online casino current indication of personal e-mail addresses to communicate with the player is a must. In that case, if the player does not have a registration for a valid e-mail address, his account can be closed.\n \n 14. If you change the email address the player must make the appropriate changes to your account in the online casino.\n \n 15. Online casino may appeal to the player to provide real data about themselves and confirm their relevant documents. In particular, such information and documents may be requested when making payments through credit cards.\n \n 16. Online casino reserves the right to apply to the player via email, telephone or other means available to news reports, announcements ongoing promotions, information on offers and promotions online casino partners.\n \n 17. All personal data is kept confidential player and no player''s personal data can not be disclosed or transferred to a third party without the consent of the player except as specifically stated in these rules, situations.\n \n 18. Personal data may be transmitted by an official investigation of fraud, including in cases of credit card fraud.\n \n 19. Online casino is aware of the risks associated with gambling: sometimes the game can become a nasty habit that is hard to control. Therefore, the player always has the option to limit themselves in the game, please contact the online casino with a request to suspend the game and the operation on his account (for up to 6 months. Or close the account.\n \n 20. Online Casino reserves the right, exercisable in its sole discretion, temporarily or permanently suspend operations on the player''s account, including the investigation of suspicious activities and financial transactions player, but not limited to, as well as to cancel your account at any time and without notice.\n \n 21. When you close the account initiated by the online casino balance paid to the player on it, except as otherwise provided in this Regulation.\n \n 22. When playing in online casinos is strictly forbidden to use electronic, mechanical, or other device, software to automate decision-game decisions and / or automated gaming. Violation of rules related to the use of such devices and / or software may result in actions up to the ban on playing in online casinos, gaming account debiting funds in the amount received by such method or way of winning, excluding players from the list of promotions , tournaments, bonus programs. Never play with the anonymizing proxy servers and / or other technical means of preventing the definition of real ip-address of the computer player, and substituting technical service information transmitted in accordance with the protocols of the Internet. Never play with disabled cookies.\n \n 23. In case of the evidence that the player applies the methods and ways to play that are not provided for or against the rules, and / or a player in any way affect the technical software and / or hardware Internet casino, and / or a player uses found in the software errors, Internet Casino reserves the right, exercisable in its sole discretion, not to pay winnings in this way.\n \n 24. Online casino reserves the right to close a player account and debit balances on the account in the online casino revenue, if so there were no transactions (payment transactions, interest rates or other movement of funds. Within 12 months from the date of the last movement of funds on account .\n \n 25. All decisions relating to proposals to the player during the promotions, tournaments, bonus programs, are the exclusive competence of the online casino. Online Casino reserves the right, exercisable in its sole discretion whether to continue or cancel any promotional offer at any time and for any reason without any prior warning.\n \n 26. Online casino reserves the right to deny a player the right to participate in any promotion, event, preferred pricing at its discretion and without notice. The player does not observe the terms of promotion, tournament bonus program, be denied the right to continue to participate in it. Withdrawals teachings from casino bonus only after a deposit for an amount not less than the Cash bonus;\n\n 27. Online casino does not accept any liability for losses which may occur when using the player''s casino. Including online casino not responsible for: (a, in case of force majeure, (formerly at failures in the computer system, the online casino, including failures due to external influences hostile to the equipment and / or software online casino operators connection of the player, (c. for delays, losses, errors that occur during the temporary failure of performance and / or failure of telecommunications or other data transmission systems, administered by the Online Casino and / or the Player and / or managed by operators through which the connection between the computer and the server player online casino, (, with the actions of public authorities, including the adoption, repeal or amendment of laws granting or revocation of licenses or permits. This online casino on the other hand making all possible efforts to prevent and eliminate such losses or minimize the occurrence of such events.\n \n 28. The player has no right to demand from the online casino, its employees, as well as companies and their employees, and those with an Internet casino contractual relations: restitution, compensation for any expenses, costs, liabilities that may arise from the fact that the player (a. comes to your site and / or server online casino, (former uses any materials displayed on the Site, (c. involved in the game, (he took a win or prize).\n \n 29. Playing in online casinos is forbidden: employees online casino, online casino developers, resellers, online casinos and their immediate families. In cases of exposure of these players their accounts will be deleted and they will be further input is not possible. All bets and winnings will be null and void, and the deposited funds will be returned minus the usual commission.\n \n 30. In the event of a dispute management solution online casino is final and conclusive.\n \n 31. Online casino operates in the time zone GMT +3 (server time coincides with Moscow time. All materials of the site and message time is in the time zone.\n \n 32. Player is solely responsible for all taxes and obligatory payments, which may arise in connection with the receipt of prizes and awards in accordance with the laws of the country of which he is a resident and / or country of residence.\n \n 33. Player understands and accepts that the terms and conditions are subject to change without notice. The player will be periodically re-read these Terms and Conditions. In case of changes in the terms and conditions, this information will be published in a special section of "Changes in the rules" at the online casino. Player before the game itself checks whether the changes and amendments to the terms and conditions. Information about changes in the rules may be published in the news site and / or informational materials that are sent via e-mail.', 'Посещая сайт Интернет-казино, открывая игровой счет и используя его, принимая участие в играх, проводимых Интернет-казино, осуществляя любые иные действия, связанные с участием в играх и рекламных акциях, проводимых Интернет-казино, принимая какой-либо приз, игрок этим заявляет, что понимает и соглашается с данными Правилами и условиями и обязуется соблюдать их, а также заявляет и подтверждает что:\n\n 1.  Игрок является совершеннолетним и дееспособным гражданином в юридическом определении этого понятия в стране своего гражданства.\n\n 2.  Игрок имеет полное и неограниченное законное право принимать участие в азартных играх в Интернете. Игрок понимает, что несет персональную ответственность за невыполнение законов страны своего пребывания относительно азартных игр в Интернете (азартные игры или пари могут быть незаконными в юрисдикции пребывания игрока..\n\n 3. Игрок осознает, что игры предназначены только для развлечения, а интерес игрока к Интернет-казино имеет личный характер. Использование Интернет-казино для каких-либо иных целей, в том числе профессиональных, запрещено.\n\n 4.  Игрок понимает, что участие в играх остается исключительно его выбором и риском.\n\n 5.  Игрок понимает, что результаты игры основаны исключительно на случайных событиях, для моделирования которых используется Генератор случайных чисел Интернет-казино.\n\n 6.  Идентификация игрока на сайте Интернет-казино и доступ к игровому счету производится при помощи учетных данных игрока: логина и пароля.\n Логин (login) - уникальное публичное буквенно-числовое имя, которое игрок выбирает и указывает самостоятельно при регистрации в Интернет-казино.\n Пароль (password) – секретная буквенно-числовая последовательность, которую игрок выбирает и указывает самостоятельно при регистрации в Интернет-казино для доступа в Интернет-Казино от своего имени.\n\n 7.  Игрок понимает и принимает, что он должен сохранять свой пароль в тайне от третьих лиц, не сообщать его никому. Игрок вправе время от времени по своему усмотрению менять свой пароль для повышения безопасности своего счета в Интернет-казино. В случае утраты либо разглашения информации о пароле Игрок обязан незамедлительно уведомить об этом администрацию Интернет-казино и изменить Пароль.\n \n 8. Любые действия, совершенные с использованием учетных данных Игрока (Логина и Пароля) считаются совершенными самим Игроком. Игрок не вправе требовать от Интернет-казино отмены финансовых транзакций по его счету, если эти транзакции совершены с использованием его учетных данных.\n \n 9. Игрок не имеет права разрешать какому-либо иному лицу или третьей стороне, включая несовершеннолетних, участвовать в игре от своего имени (под своим логином и паролем..\n \n 10.  Игрок может иметь в Интернет-казино несколько игровых счетов. Количество счетов, открытых одним и тем же игроком, определяется его потребностями для игры. В том случае, если игрок злоупотребляет предоставленной ему возможностью открывать игровые счета в количестве более одного, администрация Интернет-казино вправе предупредить игрока о недопустимости таких действий и запретить ему открывать новые игровые счета в дальнейшем.\n \n 11.  Игрок разрешает публиковать свой Логин в списках участников проводимых игр и акций, списках победителей, новостях и любых иных информационных материалах Интернет-казино.\n \n 12.  При регистрации в Интернет-казино и открытии игрового счета игроку рекомендуется указывать реальные данные о себе (фамилия и имя, номер контактного стационарного телефона и другие сведения в соответствии с формой регистрации).\n \n 13.  При регистрации в Интернет-казино указание действующего личного адреса электронной почты для связи с игроком является обязательным. В том случае, если игрок при регистрации не указал свой действующий адрес электронной почты, его счет может быть закрыт.\n \n 14.  При изменении адреса электронной почты игрок должен внести соответствующие изменения в свою Учетную запись в Интернет-казино.\n \n 15.  Интернет-казино вправе обращаться к игроку с просьбами предоставить реальные данные о себе и подтвердить их соответствующими документами. В частности, такие данные и документы могут быть запрошены при проведении платежей посредством кредитных карт.\n \n 16.  Интернет-казино оставляет за собой право обращаться к игроку по электронной почте, телефону или иным доступным способом с информационными сообщениями, анонсами проводимых рекламных акций, информацией о предложениях и акциях партнеров Интернет-казино.\n \n 17.  Все личные данные игрока хранятся в тайне и никакие персональные данные игрока не могут разглашаться или передаваться третьей стороне без согласия игрока за исключением специально оговоренных в настоящих правилах ситуациях.\n \n 18. Личные данные могут передаваться при проведении официальных расследований мошенничества, в том числе в случаях мошенничества с кредитными картами.\n \n 19.  Интернет-казино осведомлено о рисках, связанных с азартными играми: иногда игры могут стать неприятной привычкой, которую тяжело контролировать. Поэтому игрок всегда имеет возможность ограничить себя в игре, обратившись в Интернет-казино с просьбой временно приостановить игры и операции по его счету (на срок до 6 месяцев. или закрыть счет.\n \n 20.  Интернет-казино оставляет за собой право, реализуемое исключительно по его усмотрению, временно или полностью приостанавливать операции по счету игрока, в том числе при расследовании подозрительных действий и финансовых транзакций игрока, но не ограничиваясь этим, а также закрыть счет игрока в любое время и без предварительного оповещения.\n \n 21.  При закрытии счета по инициативе Интернет-казино остаток средств по нему выплачивается игроку, за исключением случаев, оговоренных в настоящих Правилах.\n \n 22.  При игре в Интернет-казино категорически запрещено использовать электронные, механические или иные устройства, компьютерные программы для автоматизации принятия игровых решений и/или для автоматизированного ведения игры. Нарушение правил, связанных с использованием подобных устройств и/или компьютерных программ, может повлечь за собой меры вплоть до запрета на игру в Интернет-казино; списания с игрового счета средств в размере полученного таким методом или способом выигрыша; исключения игрока из списков участников рекламных акций, турниров, бонусных программ. Запрещается игра с использованием анонимизирующих прокси-серверов и/или иных технических средств, препятствующих определению реального ip-адреса компьютера игрока, а также подменяющих техническую служебную информацию, передаваемую в соответствии с протоколами работы сети Интернет. Запрещается игра с отключенными cookies.\n \n 23.  В случае установления фактов, свидетельствующих о том, что игрок применяет методы и способы игры, которые не предусмотрены или запрещены Правилами; и/или игрок каким-либо способом технического характера воздействует на программное обеспечение и/или оборудование Интернет-казино; и/или игрок использует найденные в программном обеспечении ошибки, Интернет-казино оставляет за собой право, реализуемое исключительно по его усмотрению, не выплачивать выигрыши, полученные таким способом.\n \n 24.  Интернет-казино оставляет за собой право закрывать счет игрока и списывать остатки средств на счете в доход Интернет-казино, если по нему не проводилось никаких операций (платежных транзакций, ставок или иного движения средств. в течение 12 месяцев от даты последнего движения средств по счету.\n \n 25.  Все решения, связанные с предложениями игроку при проведении рекламных акций, турниров, бонусных программ, находятся в исключительной компетенции Интернет-казино. Интернет-казино оставляет за собой право, реализуемое исключительно по его усмотрению, продолжать или отменять любое рекламное предложение в любой момент и по любой причине без какого бы то ни было предварительного оповещения.\n \n 26.  Интернет-казино оставляет за собой право отказать игроку в праве участвовать в любой рекламной акции, турнире, бонусной программе по своему усмотрению и без предварительного оповещения. Игрок, не соблюдающий правила проведения рекламной акции, турнира, бонусной программы, может быть лишен права продолжать участие в ней. Снять со счета поученный от казино бонус можно только после депозита по сумме не меньшего, чем снимаемый бонус; \n\n 27.  Интернет-казино не берет на себя никакой ответственности за потери, которые могут возникнуть у игрока при использовании казино. В том числе Интернет-казино не несет ответственности: (а. при форс-мажорных обстоятельствах; (б. при сбоях в компьютерной системе Интернет-казино, включая сбои в результате внешних враждебных воздействий на оборудование и/или программное обеспечение Интернет-казино, операторов связи, самого игрока; (в. при задержках, потерях, ошибках, возникающих при временном нарушении работоспособности и/или отказе телекоммуникационных или иных систем передачи данных, находящихся в ведении Интернет-казино, и/или Игрока, и/или в ведении операторов связи, через которых осуществляется связь между компьютером игрока и сервером Интернет-казино; (г. при действиях государственных органов власти, включая принятие, отмену или изменение законов, выдачу или аннулирование лицензий или разрешений. При этом Интернет-казино со своей стороны предпринимает все возможные усилия для предупреждения и недопущения таких потерь или их минимизации в случае наступления таких обстоятельств.\n \n 28.  Игрок не имеет права требовать от Интернет-казино, его сотрудников, а также компаний и их сотрудников, и лиц, имеющих с Интернет-казино договорные отношения: возмещения ущерба, компенсации любых расходов, затрат, обязательств, которые могут проистекать из того, что Игрок (а. заходит на сайт и/или сервер Интернет-казино; (б. использует любые материалы, выставленные на сайте; (в. участвует в Игре; (г. принимает Выигрыш или Приз).\n \n 29.  Игра в Интернет-казино запрещается: сотрудникам Интернет-казино, разработчикам Интернет казино, продавцам Интернет казино и их ближайшим родственникам. В случаи обнажения таких игроков их аккаунты будут удаляться и дальнейший вход их будет не возможен. Все ставки и выигрыши будут объявлены недействительными, а внесенные средства будут возвращены за вычетом обычной комиссии. \n \n 30.  В случае возникновения спорных ситуаций решение менеджмента Интернет-казино является окончательным и неоспоримым.\n \n 31.  Интернет-казино работает в часовом поясе GMT+3 (серверное время совпадает с московским временем. Во всех материалах сайта и сообщениях время указывается в этом часовом поясе.\n \n 32.  Игрок самостоятельно несет ответственность за уплату всех налогов и обязательных платежей, которые могут возникнуть в связи с получением выигрышей и призов в соответствии с законами страны, резидентом которой он является и/или страны своего проживания.\n \n 33.  Игрок понимает и принимает то, что правила и условия могут меняться без предварительного оповещения. Игрок периодически будет перечитывать эти Правила и условия. В случае внесения изменений в Правила и условия, информация об этом публикуется в специальном разделе "Изменения в правилах" на сайте Интернет-казино. Игрок перед началом игры самостоятельно проверяет, не были ли внесены изменения и дополнения в правила и условия. Информация об изменениях в правилах может публиковаться в новостной ленте сайта и/или информационных материалах, рассылаемых с помощью электронной почты.');

-- --------------------------------------------------------

--
-- Table structure for table `pincode`
--

CREATE TABLE IF NOT EXISTS `pincode` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `code` text NOT NULL,
  `amount` double unsigned NOT NULL,
  `status` tinyint(4) unsigned NOT NULL DEFAULT '2',
  `created` bigint(20) unsigned NOT NULL,
  `changed` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `pincode`
--


-- --------------------------------------------------------

--
-- Table structure for table `pincode_collection`
--

CREATE TABLE IF NOT EXISTS `pincode_collection` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `pincode_collection`
--

INSERT INTO `pincode_collection` (`id`, `title`) VALUES
(17, 'Пинкоды');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'login', 'Login privileges, granted after account confirmation'),
(2, 'root', 'Administrative user, has access to everything.'),
(4, 'admin', 'admin'),
(5, 'player', 'player');

-- --------------------------------------------------------

--
-- Table structure for table `roles_users`
--

CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles_users`
--

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 4),
(2, 1),
(2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `template_id` int(8) unsigned NOT NULL,
  `url` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `google_analytics` text NOT NULL,
  `google_webmaster_tools` text NOT NULL,
  `one_login` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `currency` double(8,2) unsigned NOT NULL DEFAULT '0.00',
  `demo_user_balance` double(20,2) unsigned NOT NULL DEFAULT '0.00',
  `lang_id_default` int(8) unsigned NOT NULL DEFAULT '0',
  `banking_limit_min_cash` double(20,2) unsigned NOT NULL DEFAULT '0.00',
  `banking_limit_min_cash_bonus` double(20,2) unsigned NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`template_id`, `url`, `title`, `description`, `keywords`, `google_analytics`, `google_webmaster_tools`, `one_login`, `currency`, `demo_user_balance`, `lang_id_default`, `banking_limit_min_cash`, `banking_limit_min_cash_bonus`) VALUES
(1, 'http://vezuviy-flash.ru/', 'Vezuviy-Flash.ru', '', '', '', '', 1, 1.00, 5000.00, 1, 100.00, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `setting_lang`
--

CREATE TABLE IF NOT EXISTS `setting_lang` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  `name` text,
  `position` int(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `setting_lang`
--

INSERT INTO `setting_lang` (`id`, `title`, `name`, `position`) VALUES
(1, 'Rus', 'ru_RU', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting_template`
--

CREATE TABLE IF NOT EXISTS `setting_template` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  `name` text,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `setting_template`
--

INSERT INTO `setting_template` (`id`, `title`, `name`, `description`) VALUES
(1, 'Default', 'default', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `statistics`
--

CREATE TABLE IF NOT EXISTS `statistics` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `game_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `map` int(8) unsigned NOT NULL DEFAULT '1',
  `bet` bigint(20) unsigned NOT NULL DEFAULT '0',
  `win` bigint(20) unsigned NOT NULL DEFAULT '0',
  `gamer_balance` bigint(20) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`user_id`,`game_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

--
-- Dumping data for table `statistics`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(127) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` char(50) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `password_original` varchar(50) NOT NULL,
  `ip` text,
  `last_bang` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `logins`, `last_login`, `blocked`, `password_original`, `ip`, `last_bang`) VALUES
(1, 'support@vezuviy.net', 'Admin', '55bbce67f1e1c9470076c1d69e451a7d39d54d88f908f15a6f', 31, 1374840773, 0, 'Admin', NULL, 0),
(2, 'profort.ru@list.ru', 'User', '554917956a735043799ef3f7e308471fea807fd3445c6b737d', 13, 1374840043, 0, 'User', '127.0.0.1', 1374841616);

-- --------------------------------------------------------

--
-- Table structure for table `user_attack`
--

CREATE TABLE IF NOT EXISTS `user_attack` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `request` text,
  `system_message` text,
  `created` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1062 ;

--
-- Dumping data for table `user_attack`
--

INSERT INTO `user_attack` (`id`, `user_id`, `request`, `system_message`, `created`) VALUES
(584, NULL, 'event/player/next', 'hack', 1343855839),
(585, NULL, 'media/mp3/robbie_williams-mack_the_knife.mp3', 'hack', 1343929089),
(586, NULL, 'media/mp3/robbie_williams-things.mp3', 'hack', 1343929094),
(587, NULL, 'media/mp3/robbie_williams-mack_the_knife.mp3', 'hack', 1343929122),
(588, NULL, 'event/player/volume', 'hack', 1343929180),
(589, NULL, 'event/player/volume', 'hack', 1343929181),
(590, NULL, 'event/player/volume', 'hack', 1343929183),
(591, NULL, 'event/player/volume', 'hack', 1343929331),
(592, NULL, 'event/player/volume', 'hack', 1343929332),
(593, NULL, 'event/player/volume', 'hack', 1343929400),
(594, NULL, 'event/player/volume', 'hack', 1343929401),
(595, NULL, 'event/player/pause', 'hack', 1343929403),
(596, NULL, 'event/player/play', 'hack', 1343929404),
(597, NULL, 'event/player/volume', 'hack', 1343929407),
(598, NULL, 'event/player/volume', 'hack', 1343929454),
(599, NULL, 'event/player/volume', 'hack', 1343929610),
(600, NULL, 'event/player/volume', 'hack', 1343929665),
(601, NULL, 'event/player/volume', 'hack', 1343929666),
(602, NULL, 'event/player/next', 'hack', 1343929667),
(603, NULL, 'event/player/next', 'hack', 1343929670),
(604, NULL, 'event/player/next', 'hack', 1343929672),
(605, NULL, 'event/player/next', 'hack', 1343929675),
(606, NULL, 'event/player/next', 'hack', 1343929677),
(607, NULL, 'event/player/next', 'hack', 1343929679),
(608, NULL, 'event/player/next', 'hack', 1343929682),
(609, NULL, 'event/player/pause', 'hack', 1343929687),
(610, NULL, 'event/player/play', 'hack', 1343929687),
(611, NULL, 'event/player/pause', 'hack', 1343929688),
(612, NULL, 'event/player/next', 'hack', 1343929689),
(613, NULL, 'event/player/next', 'hack', 1343929690),
(614, NULL, 'event/player/next', 'hack', 1343929693),
(615, NULL, 'event/player/next', 'hack', 1343929695),
(616, NULL, 'event/player/pause', 'hack', 1343929697),
(617, NULL, 'event/player/play', 'hack', 1343929698),
(618, NULL, 'event/player/volume', 'hack', 1343929700),
(619, NULL, 'event/player/volume', 'hack', 1343929767),
(620, NULL, 'event/player/volume', 'hack', 1343929925),
(621, NULL, 'event/player/volume', 'hack', 1343929926),
(622, NULL, 'media/mp3/1343930010Don&#039;t_Wоrry_Be_Happy.mp3', 'hack', 1343930063),
(623, NULL, 'event/player/next', 'hack', 1343930063),
(624, NULL, 'event/player/next', 'hack', 1343930366),
(625, NULL, 'event/player/next', 'hack', 1343930368),
(626, NULL, 'event/player/next', 'hack', 1343930371),
(627, NULL, 'event/player/next', 'hack', 1343930373),
(628, NULL, 'event/player/volume', 'hack', 1343930418),
(629, NULL, 'event/player/volume', 'hack', 1343930419),
(630, NULL, 'event/player/volume', 'hack', 1343931038),
(631, NULL, 'media/mp3/don&#039;t_wrry_be_happy.mp3', 'hack', 1343931500),
(632, NULL, 'event/player/volume', 'hack', 1343932991),
(633, NULL, 'event/player/volume', 'hack', 1343933229),
(634, NULL, 'event/player/volume', 'hack', 1343933231),
(635, NULL, 'event/player/volume', 'hack', 1343934029),
(636, NULL, 'event/player/volume', 'hack', 1343934272),
(637, NULL, 'event/player/volume', 'hack', 1343934899),
(638, NULL, 'event/player/volume', 'hack', 1343934901),
(639, NULL, 'event/player/volume', 'hack', 1343934904),
(640, NULL, 'event/player/volume', 'hack', 1343934979),
(641, NULL, 'event/player/volume', 'hack', 1343934980),
(642, NULL, 'event/player/volume', 'hack', 1343934981),
(643, NULL, 'event/player/volume', 'hack', 1343935046),
(644, NULL, 'media/mp3/don&#039;t_wrry_be_happy.mp3', 'hack', 1343935070),
(645, NULL, 'event/player/volume', 'hack', 1343935075),
(646, NULL, 'media/mp3/don&#039;t_wrry_be_happy.mp3', 'hack', 1343935081),
(647, NULL, 'event/player/volume', 'hack', 1343935088),
(648, NULL, 'media/mp3/don&#039;t_wrry_be_happy.mp3', 'hack', 1343935161),
(649, NULL, 'event/player/volume', 'hack', 1343935173),
(650, NULL, 'event/player/volume', 'hack', 1343935323),
(651, NULL, 'event/player/volume', 'hack', 1343935324),
(652, NULL, 'event/player/volume', 'hack', 1343935557),
(653, NULL, 'event/player/volume', 'hack', 1343935558),
(654, NULL, 'event/player/volume', 'hack', 1343935793),
(655, NULL, 'media/mp3/don&#039;t_wrry_be_happy.mp3', 'hack', 1343935819),
(656, NULL, 'event/player/volume', 'hack', 1343935854),
(657, NULL, 'event/player/volume', 'hack', 1343936099),
(658, NULL, 'event/player/volume', 'hack', 1343936100),
(659, NULL, 'event/player/volume', 'hack', 1343936424),
(660, NULL, 'media/mp3/don&#039;t_wrry_be_happy.mp3', 'hack', 1343936857),
(661, NULL, 'media/mp3/don&#039;t_wrry_be_happy.mp3', 'hack', 1343938748),
(662, NULL, 'media/mp3/don&#039;t_wrry_be_happy.mp3', 'hack', 1343938758),
(663, NULL, 'event/player/volume', 'hack', 1343938819),
(664, NULL, 'media/mp3/don&#039;t_wrry_be_happy.mp3', 'hack', 1343938822),
(665, NULL, 'event/player/volume', 'hack', 1343938962),
(666, NULL, 'event/player/volume', 'hack', 1343938963),
(667, NULL, 'event/player/volume', 'hack', 1343939056),
(668, NULL, 'event/player/volume', 'hack', 1343943701),
(669, NULL, 'media/mp3/1343944408Elvis_Presley_Viva_Las_Vegas.mp3', 'hack', 1343944582),
(670, NULL, 'media/mp3/1343944352Stanley_Bloom_Mike_Ro_Wave.mp3', 'hack', 1343944666),
(671, NULL, 'event/player/volume', 'hack', 1343944728),
(672, 28, 'shit', 'hack', 1343947423),
(673, 28, 'media/flash/template/default/index.swf', 'hack', 1343948056),
(674, 28, 'media/flash/template/default/index.swf', 'hack', 1343948062),
(675, 28, 'media/flash/template/default/index.swf', 'hack', 1343948071),
(676, 28, 'media/flash/template/default/index.swf', 'hack', 1343948077),
(677, 28, 'shit', 'hack', 1343948333),
(678, 28, 'shit', 'hack', 1343948342),
(679, 28, 'shit', 'hack', 1343948386),
(680, 28, 'shit', 'hack', 1343948454),
(681, 28, 'shit', 'hack', 1343948469),
(682, 28, 'shit', 'hack', 1343948508),
(683, 28, 'shit', 'hack', 1343948561),
(684, 28, 'event/player/volume', 'hack', 1343948793),
(685, 28, 'event/player/volume', 'hack', 1343948794),
(686, 28, 'event/player/volume', 'hack', 1343948857),
(687, 28, 'event/player/volume', 'hack', 1343948859),
(688, 28, 'event/player/volume', 'hack', 1343948859),
(689, 28, 'shit', 'hack', 1343948895),
(690, 28, 'event/player/volume', 'hack', 1343953288),
(691, 28, 'event/player/volume', 'hack', 1343953289),
(692, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1343968660),
(693, NULL, 'robots.txt', 'hack', 1343975528),
(694, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1343993947),
(695, NULL, 'event/player/next', 'hack', 1343993985),
(696, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1343994092),
(697, NULL, 'event/player/next', 'hack', 1343994092),
(698, NULL, 'event/player/pause', 'hack', 1343994094),
(699, NULL, 'event/player/play', 'hack', 1343994096),
(700, NULL, 'event/player/pause', 'hack', 1343994097),
(701, NULL, 'event/player/volume', 'hack', 1343994099),
(702, NULL, 'event/player/volume', 'hack', 1343994099),
(703, NULL, 'event/player/volume', 'hack', 1343994100),
(704, NULL, 'event/player/volume', 'hack', 1343994101),
(705, NULL, 'event/player/volume', 'hack', 1343994104),
(706, NULL, 'event/player/next', 'hack', 1343994105),
(707, NULL, 'event/player/next', 'hack', 1343994106),
(708, NULL, 'event/player/prev', 'hack', 1343994107),
(709, NULL, 'event/player/next', 'hack', 1343994109),
(710, NULL, 'event/player/volume', 'hack', 1343994207),
(711, NULL, 'event/player/volume', 'hack', 1343997663),
(712, NULL, 'event/player/volume', 'hack', 1343997666),
(713, NULL, 'event/player/volume', 'hack', 1343997668),
(714, NULL, 'event/player/volume', 'hack', 1343997669),
(715, NULL, 'event/player/volume', 'hack', 1343997670),
(716, NULL, 'event/player/volume', 'hack', 1344002079),
(717, NULL, 'event/player/volume', 'hack', 1344002082),
(718, NULL, 'event/player/volume', 'hack', 1344002087),
(719, NULL, 'event/player/volume', 'hack', 1344002814),
(720, NULL, 'event/player/volume', 'hack', 1344002832),
(721, NULL, 'event/player/volume', 'hack', 1344002834),
(722, NULL, 'event/player/volume', 'hack', 1344002837),
(723, NULL, 'event/player/volume', 'hack', 1344004603),
(724, NULL, 'event/player/volume', 'hack', 1344021909),
(725, NULL, 'event/player/volume', 'hack', 1344022144),
(726, NULL, 'event/player/volume', 'hack', 1344022145),
(727, NULL, 'event/player/volume', 'hack', 1344022146),
(728, NULL, 'event/player/volume', 'hack', 1344022148),
(729, NULL, 'event/player/volume', 'hack', 1344022153),
(730, NULL, 'event/player/volume', 'hack', 1344022165),
(731, NULL, 'event/player/volume', 'hack', 1344022167),
(732, NULL, 'event/player/volume', 'hack', 1344022167),
(733, NULL, 'event/player/volume', 'hack', 1344022168),
(734, NULL, 'event/player/volume', 'hack', 1344022169),
(735, NULL, 'event/player/volume', 'hack', 1344022343),
(736, NULL, 'event/player/volume', 'hack', 1344022345),
(737, NULL, 'event/player/volume', 'hack', 1344022577),
(738, NULL, 'event/player/volume', 'hack', 1344022578),
(739, NULL, 'event/player/volume', 'hack', 1344023185),
(740, NULL, 'event/player/volume', 'hack', 1344024179),
(741, NULL, 'event/player/volume', 'hack', 1344024241),
(742, NULL, 'event/player/volume', 'hack', 1344027215),
(743, NULL, 'event/player/volume', 'hack', 1344027216),
(744, NULL, 'event/player/volume', 'hack', 1344027216),
(745, 28, 'event/player/volume', 'hack', 1344027234),
(746, 28, 'event/player/volume', 'hack', 1344027234),
(747, 28, 'shit', 'hack', 1344027250),
(748, 28, 'event/player/volume', 'hack', 1344027363),
(749, 28, 'event/player/volume', 'hack', 1344027364),
(750, 28, 'event/player/volume', 'hack', 1344033425),
(751, 28, 'event/player/volume', 'hack', 1344033425),
(752, 28, 'event/player/volume', 'hack', 1344033426),
(753, 28, 'event/player/volume', 'hack', 1344033428),
(754, 28, 'event/player/volume', 'hack', 1344033431),
(755, 28, 'event/player/volume', 'hack', 1344033433),
(756, 28, 'event/player/volume', 'hack', 1344033438),
(757, 28, 'event/player/volume', 'hack', 1344033438),
(758, 28, 'event/player/volume', 'hack', 1344033439),
(759, 28, 'event/player/volume', 'hack', 1344033453),
(760, 28, 'shit', 'hack', 1344033490),
(761, 28, 'event/player/volume', 'hack', 1344033572),
(762, 28, 'event/player/volume', 'hack', 1344033607),
(763, 28, 'event/player/volume', 'hack', 1344033702),
(764, 28, 'event/player/volume', 'hack', 1344033774),
(765, 28, 'event/player/volume', 'hack', 1344033780),
(766, 28, 'event/player/volume', 'hack', 1344033782),
(767, 28, 'event/player/volume', 'hack', 1344033852),
(768, 28, 'event/player/volume', 'hack', 1344034015),
(769, 28, 'event/player/volume', 'hack', 1344034081),
(770, 28, 'event/player/volume', 'hack', 1344034115),
(771, 28, 'event/player/volume', 'hack', 1344034115),
(772, 28, 'event/player/volume', 'hack', 1344034121),
(773, 28, 'event/player/volume', 'hack', 1344034121),
(774, 28, 'event/player/volume', 'hack', 1344034817),
(775, 28, 'event/player/volume', 'hack', 1344034991),
(776, 28, 'event/player/volume', 'hack', 1344035006),
(777, 28, 'event/player/volume', 'hack', 1344035179),
(778, 28, 'event/player/volume', 'hack', 1344035324),
(779, 28, 'event/player/volume', 'hack', 1344035325),
(780, 28, 'event/player/volume', 'hack', 1344036150),
(781, 28, 'event/player/volume', 'hack', 1344036323),
(782, 28, 'event/player/volume', 'hack', 1344036323),
(783, 28, 'event/player/volume', 'hack', 1344036693),
(784, 28, 'event/player/volume', 'hack', 1344036922),
(785, 28, 'event/player/volume', 'hack', 1344037561),
(786, 28, 'shit', 'hack', 1344040114),
(787, 28, 'event/player/volume', 'hack', 1344040345),
(788, 28, 'event/player/volume', 'hack', 1344040347),
(789, 28, 'event/player/volume', 'hack', 1344040348),
(790, 28, 'event/player/volume', 'hack', 1344040491),
(791, 28, 'event/player/volume', 'hack', 1344040494),
(792, 28, 'event/player/volume', 'hack', 1344040495),
(793, 28, 'event/player/volume', 'hack', 1344040496),
(794, 28, 'shit', 'hack', 1345734035),
(795, 28, 'shit', 'hack', 1345735106),
(796, 28, 'shit', 'hack', 1345735196),
(797, 28, 'event/player/volume', 'hack', 1345735290),
(798, 28, 'event/player/volume', 'hack', 1345735292),
(799, 28, 'event/player/volume', 'hack', 1345735292),
(800, 28, 'event/player/volume', 'hack', 1345735294),
(801, 28, 'event/player/volume', 'hack', 1345735299),
(802, 28, 'event/player/volume', 'hack', 1345735299),
(803, 28, 'event/player/volume', 'hack', 1345735300),
(804, 28, 'event/player/volume', 'hack', 1345735301),
(805, 28, 'event/player/volume', 'hack', 1345735301),
(806, 28, 'event/player/volume', 'hack', 1345735301),
(807, NULL, 'robots.txt', 'hack', 1345736586),
(808, NULL, 'event/player/volume', 'hack', 1345751750),
(809, NULL, 'robots.txt', 'hack', 1345823041),
(810, NULL, 'event/player/pause', 'hack', 1345843583),
(811, NULL, 'robots.txt', 'hack', 1345848494),
(812, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1345924786),
(813, NULL, 'robots.txt', 'hack', 1346029415),
(814, NULL, 'robots.txt', 'hack', 1346082243),
(815, NULL, 'robots.txt', 'hack', 1346121741),
(816, NULL, 'robots.txt', 'hack', 1346122587),
(817, NULL, 'event/player/volume', 'hack', 1346130738),
(818, NULL, 'event/player/volume', 'hack', 1346134495),
(819, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1346134632),
(820, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1346134773),
(821, NULL, 'event/player/volume', 'hack', 1346134941),
(822, NULL, 'event/player/volume', 'hack', 1346134944),
(823, NULL, 'event/player/prev', 'hack', 1346134947),
(824, NULL, 'event/player/volume', 'hack', 1346134952),
(825, NULL, 'event/player/volume', 'hack', 1346135551),
(826, NULL, 'event/player/volume', 'hack', 1346135702),
(827, NULL, 'event/player/volume', 'hack', 1346135895),
(828, NULL, 'event/player/volume', 'hack', 1346135897),
(829, NULL, 'event/player/volume', 'hack', 1346135898),
(830, NULL, 'event/player/volume', 'hack', 1346136041),
(831, NULL, 'event/player/volume', 'hack', 1346136045),
(832, NULL, 'event/player/volume', 'hack', 1346136238),
(833, NULL, 'event/player/volume', 'hack', 1346136553),
(834, NULL, 'event/player/volume', 'hack', 1346136556),
(835, NULL, 'event/player/volume', 'hack', 1346136556),
(836, NULL, 'event/player/volume', 'hack', 1346136583),
(837, NULL, 'event/player/volume', 'hack', 1346136806),
(838, NULL, 'event/player/volume', 'hack', 1346149556),
(839, NULL, 'event/player/volume', 'hack', 1346149751),
(840, NULL, 'event/player/volume', 'hack', 1346149751),
(841, NULL, 'event/player/volume', 'hack', 1346157507),
(842, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1346158245),
(843, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1346162235),
(844, NULL, 'event/player/volume', 'hack', 1347606279),
(845, NULL, 'event/player/volume', 'hack', 1347606285),
(846, NULL, 'event/player/volume', 'hack', 1347609864),
(847, NULL, 'event/player/volume', 'hack', 1347609865),
(848, NULL, 'event/player/volume', 'hack', 1347609866),
(849, NULL, 'event/player/volume', 'hack', 1347609870),
(850, NULL, 'event/player/volume', 'hack', 1347609870),
(851, NULL, 'event/player/volume', 'hack', 1347634571),
(852, NULL, 'robots.txt', 'hack', 1347680130),
(853, NULL, 'event/player/volume', 'hack', 1347691605),
(854, NULL, 'event/player/volume', 'hack', 1347691607),
(855, NULL, 'event/player/volume', 'hack', 1347715920),
(856, NULL, 'robots.txt', 'hack', 1347716120),
(857, NULL, 'event/player/volume', 'hack', 1347718758),
(858, NULL, 'event/player/volume', 'hack', 1347718759),
(859, NULL, 'event/player/volume', 'hack', 1347718760),
(860, NULL, 'event/player/volume', 'hack', 1347718761),
(861, NULL, 'event/player/next', 'hack', 1347718762),
(862, NULL, 'event/player/next', 'hack', 1347718764),
(863, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1347721607),
(864, NULL, 'PMA', 'hack', 1347723621),
(865, NULL, 'mysqladmin', 'hack', 1347723636),
(866, NULL, 'phpmyadmin2', 'hack', 1347723639),
(867, NULL, 'dbadmin', 'hack', 1347723640),
(868, NULL, 'mysql', 'hack', 1347723643),
(869, NULL, 'phpmy', 'hack', 1347723645),
(870, NULL, 'mysql-admin', 'hack', 1347723647),
(871, NULL, 'sql-admin', 'hack', 1347723649),
(872, NULL, 'phpMyA', 'hack', 1347723650),
(873, NULL, 'phpMyAdmin-2', 'hack', 1347723652),
(874, NULL, 'phpmyad', 'hack', 1347723653),
(875, NULL, 'phpMyAdmin1', 'hack', 1347723655),
(876, NULL, 'myadmimi', 'hack', 1347723670),
(877, NULL, '_phpmyadmin', 'hack', 1347723672),
(878, NULL, 'phpmyadmin_', 'hack', 1347723674),
(879, NULL, '_phpmyadmin_', 'hack', 1347723675),
(880, NULL, 'sqlmanager', 'hack', 1347723682),
(881, NULL, 'mysqlmanager', 'hack', 1347723686),
(882, NULL, 'phpmanager', 'hack', 1347723686),
(883, NULL, 'php-myadmin', 'hack', 1347723690),
(884, NULL, 'dumper.php', 'hack', 1347723691),
(885, NULL, 'phpmy-admin', 'hack', 1347723691),
(886, NULL, 'backup/dumper.php', 'hack', 1347723692),
(887, NULL, 'backup/backup/dumper.php', 'hack', 1347723693),
(888, NULL, 'sypex/dumper.php', 'hack', 1347723694),
(889, NULL, '_backup/dumper.php', 'hack', 1347723697),
(890, NULL, 'backup1/dumper.php', 'hack', 1347723697),
(891, NULL, 'backup123/dumper.php', 'hack', 1347723703),
(892, NULL, 'event/player/volume', 'hack', 1347733091),
(893, NULL, 'robots.txt', 'hack', 1347745228),
(894, NULL, 'robots.txt', 'hack', 1347751120),
(895, NULL, 'event/player/volume', 'hack', 1347779862),
(896, NULL, 'event/player/volume', 'hack', 1347781999),
(897, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1347782010),
(898, NULL, 'event/player/pause', 'hack', 1347782016),
(899, NULL, 'event/player/play', 'hack', 1347782016),
(900, NULL, 'event/player/next', 'hack', 1347782017),
(901, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1347782017),
(902, NULL, 'event/player/pause', 'hack', 1347782019),
(903, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1347792357),
(904, NULL, 'event/player/pause', 'hack', 1347795008),
(905, NULL, 'event/player/pause', 'hack', 1347796271),
(906, NULL, 'event/player/volume', 'hack', 1347796283),
(907, NULL, 'event/player/play', 'hack', 1347796284),
(908, NULL, 'event/player/next', 'hack', 1347796286),
(909, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1347796286),
(910, NULL, 'event/player/pause', 'hack', 1347796298),
(911, NULL, 'event/player/play', 'hack', 1347796302),
(912, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1347796308),
(913, NULL, 'event/player/volume', 'hack', 1347796311),
(914, NULL, 'event/player/volume', 'hack', 1347796312),
(915, NULL, 'event/player/next', 'hack', 1347796314),
(916, NULL, 'event/player/next', 'hack', 1347796317),
(917, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1347796320),
(918, NULL, 'event/player/next', 'hack', 1347796320),
(919, NULL, 'robots.txt', 'hack', 1347798326),
(920, NULL, 'robots.txt', 'hack', 1347830170),
(921, NULL, 'robots.txt', 'hack', 1347851888),
(922, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1347891624),
(923, 28, 'shit', 'hack', 1347891648),
(924, 28, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1347891672),
(925, 28, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1347891675),
(926, NULL, 'robots.txt', 'hack', 1347903707),
(927, NULL, 'login', 'hack', 1347957698),
(928, NULL, 'robots.txt', 'hack', 1347975328),
(929, NULL, 'event/player/volume', 'hack', 1347995182),
(930, NULL, 'event/player/volume', 'hack', 1348000863),
(931, NULL, 'pay/w1', 'hack', 1348054719),
(932, NULL, 'pay/w1/w1.php', 'hack', 1348054725),
(933, NULL, 'pay/w1/pay.php', 'hack', 1348054731),
(934, NULL, 'pay/w1/w1.php', 'hack', 1348054766),
(935, NULL, 'pay/w1/w1.php', 'hack', 1348054767),
(936, NULL, 'pay/w1/w1.php', 'hack', 1348054767),
(937, NULL, 'pay/w1/w1.php', 'hack', 1348054771),
(938, NULL, 'event/player/next', 'hack', 1348058033),
(939, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1348058037),
(940, NULL, 'event/player/next', 'hack', 1348058037),
(941, NULL, 'event/player/next', 'hack', 1348058049),
(942, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1348058051),
(943, NULL, 'event/player/prev', 'hack', 1348058051),
(944, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1348058327),
(945, NULL, 'event/player/pause', 'hack', 1348058346),
(946, NULL, 'event/player/volume', 'hack', 1348060258),
(947, NULL, 'w1_137106024594.txt', 'hack', 1348061512),
(948, NULL, 'w1_177401348.txt', 'hack', 1348061697),
(949, NULL, 'w1_177401348.txt', 'hack', 1348061697),
(950, NULL, 'w1_177401348.txt', 'hack', 1348061697),
(951, NULL, 'w1_177401348.txt', 'hack', 1348061697),
(952, NULL, 'w1_177401348.txt', 'hack', 1348061697),
(953, NULL, 'w1_177401348.txt', 'hack', 1348061703),
(954, NULL, 'w1_177401348.txt', 'hack', 1348061703),
(955, NULL, 'w1_177401348.txt', 'hack', 1348061703),
(956, NULL, 'w1_177401348.txt', 'hack', 1348061703),
(957, NULL, 'w1_177401348.txt', 'hack', 1348061703),
(958, NULL, 'robots.txt', 'hack', 1348072464),
(959, NULL, 'robots.txt', 'hack', 1348089465),
(960, NULL, 'robots.txt', 'hack', 1348114688),
(961, NULL, 'event/player/volume', 'hack', 1348115276),
(962, NULL, 'event/player/volume', 'hack', 1348153737),
(963, NULL, 'event/player/volume', 'hack', 1348153738),
(964, NULL, 'robots.txt', 'hack', 1348166477),
(965, NULL, 'event/player/volume', 'hack', 1348231309),
(966, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1348231524),
(967, NULL, 'event/player/volume', 'hack', 1348231626),
(968, 29, 'event/player/volume', 'hack', 1348231706),
(969, 29, 'event/player/volume', 'hack', 1348231707),
(970, 29, 'event/player/volume', 'hack', 1348231789),
(971, 29, 'event/player/volume', 'hack', 1348231790),
(972, NULL, 'robots.txt', 'hack', 1348234561),
(973, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1348236404),
(974, 28, 'shit', 'hack', 1348236436),
(975, 28, 'event/player/volume', 'hack', 1348236449),
(976, 30, 'shit', 'hack', 1348236469),
(977, 30, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1348236480),
(978, 30, 'shit', 'hack', 1348236482),
(979, 28, 'shit', 'hack', 1348236532),
(980, 28, 'shit', 'hack', 1348236583),
(981, 28, 'event/player/volume', 'hack', 1348236630),
(982, 28, 'event/player/volume', 'hack', 1348236631),
(983, 28, 'event/player/volume', 'hack', 1348236864),
(984, 28, 'event/player/volume', 'hack', 1348236866),
(985, 28, 'shit', 'hack', 1348236868),
(986, 28, 'shit', 'hack', 1348236973),
(987, 28, 'event/player/volume', 'hack', 1348236999),
(988, 30, 'shit', 'hack', 1348237117),
(989, 28, 'shit', 'hack', 1348237126),
(990, 30, 'shit', 'hack', 1348237128),
(991, 28, 'shit', 'hack', 1348237540),
(992, 28, 'event/player/volume', 'hack', 1348237567),
(993, NULL, 'event/player/volume', 'hack', 1348264642),
(994, 28, 'shit', 'hack', 1348268054),
(995, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1348275701),
(996, 28, 'shit', 'hack', 1348293142),
(997, 28, 'shit', 'hack', 1348296973),
(998, 28, 'event/player/volume', 'hack', 1348296980),
(999, 28, 'shit', 'hack', 1348297204),
(1000, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1349244739),
(1001, NULL, 'event/player/volume', 'hack', 1349244739),
(1002, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1349244756),
(1003, NULL, 'event/player/volume', 'hack', 1349244764),
(1004, NULL, 'event/player/volume', 'hack', 1349244764),
(1005, NULL, 'event/player/volume', 'hack', 1349244795),
(1006, NULL, 'event/player/pause', 'hack', 1349244796),
(1007, 28, 'event/player/volume', 'hack', 1349245026),
(1008, 28, 'event/player/volume', 'hack', 1349245026),
(1009, NULL, 'media/flash/template/default/jackpot.swf', 'hack', 1349634376),
(1010, NULL, 'media/mp3/Don&#039;t_Wrry_be_Happy.mp3', 'hack', 1349634376),
(1011, NULL, 'media/flash/template/default/jackpot.swf', 'hack', 1349642022),
(1012, NULL, 'media/mp3/Elvis_Presley_Viva_Las_Vegas.mp3', 'hack', 1349642022),
(1013, NULL, 'robots.txt', 'hack', 1349649630),
(1014, NULL, 'media/flash/template/default/jackpot.swf', 'hack', 1349672936),
(1015, NULL, 'media/mp3/Don&#039;t_Wоrry_be_Happy.mp3', 'hack', 1349672936),
(1016, NULL, 'event/player/volume', 'hack', 1349672945),
(1017, NULL, 'media/flash/template/default/jackpot.swf', 'hack', 1349672949),
(1018, NULL, 'media/mp3/Stanley_Bloom_Mike_Ro_Wave.mp3', 'hack', 1349672949),
(1019, NULL, 'event/player/next', 'hack', 1349672953),
(1020, NULL, 'media/mp3/Elvis_Presley_Viva_Las_Vegas.mp3', 'hack', 1349672953),
(1021, NULL, 'event/player/pause', 'hack', 1349672957),
(1022, NULL, 'event/player/play', 'hack', 1349672958),
(1023, NULL, 'media/mp3/Don&#039;t_Wоrry_be_Happy.mp3', 'hack', 1349672959),
(1024, NULL, 'event/player/next', 'hack', 1349672959),
(1025, NULL, 'media/mp3/Stanley_Bloom_Mike_Ro_Wave.mp3', 'hack', 1349672969),
(1026, NULL, 'event/player/next', 'hack', 1349672969),
(1027, NULL, 'event/player/volume', 'hack', 1349672973),
(1028, NULL, 'media/flash/template/default/jackpot.swf', 'hack', 1349672991),
(1029, NULL, 'media/mp3/Stanley_Bloom_Mike_Ro_Wave.mp3', 'hack', 1349672991),
(1030, NULL, 'event/player/volume', 'hack', 1349672993),
(1031, NULL, 'media/flash/template/default/jackpot.swf', 'hack', 1349673168),
(1032, NULL, 'media/flash/template/default/jackpot.swf', 'hack', 1349673173),
(1033, NULL, 'event/player/volume', 'hack', 1349673184),
(1034, NULL, 'event/player/volume', 'hack', 1349673185),
(1035, NULL, 'event/player/volume', 'hack', 1349673185),
(1036, NULL, 'media/flash/template/default/jackpot.swf', 'hack', 1374839756),
(1037, NULL, 'media/mp3/M.I.A._Paper_Planes.mp3', 'hack', 1374839756),
(1038, NULL, 'media/flash/template/default/jackpot.swf', 'hack', 1374839760),
(1039, NULL, 'media/mp3/Feelin&#039;_the same_way_Norah_Jones.mp3', 'hack', 1374839761),
(1040, NULL, 'media/flash/template/default/jackpot.swf', 'hack', 1374839771),
(1041, NULL, 'media/mp3/M.I.A._Paper_Planes.mp3', 'hack', 1374839771),
(1042, NULL, 'event/player/pause', 'hack', 1374839788),
(1043, NULL, 'event/player/play', 'hack', 1374839873),
(1044, NULL, 'event/player/pause', 'hack', 1374839873),
(1045, NULL, 'media/flash/template/default/jackpot.swf', 'hack', 1374839883),
(1046, NULL, 'media/mp3/Feelin&#039;_the same_way_Norah_Jones.mp3', 'hack', 1374839884),
(1047, 28, 'media/flash/template/default/jackpot.swf', 'hack', 1374840043),
(1048, 28, 'shit', 'hack', 1374840046),
(1049, 28, 'media/flash/template/default/jackpot.swf', 'hack', 1374840881),
(1050, 28, 'undefined', 'hack', 1374840882),
(1051, 28, 'media/flash/template/default/jackpot.swf', 'hack', 1374840965),
(1052, 28, 'undefined', 'hack', 1374840965),
(1053, 28, 'event/player/pause', 'hack', 1374840969),
(1054, 28, 'event/player/play', 'hack', 1374840971),
(1055, 28, 'media/flash/template/default/index.swf', 'hack', 1374841214),
(1056, 28, 'media/flash/template/default/jackpot.swf', 'hack', 1374841406),
(1057, 28, 'shit', 'hack', 1374841408),
(1058, 28, 'event/player/pause', 'hack', 1374841410),
(1059, 28, 'event/player/play', 'hack', 1374841495),
(1060, 28, 'event/player/pause', 'hack', 1374841496),
(1061, 28, 'shit', 'hack', 1374841540);

-- --------------------------------------------------------

--
-- Table structure for table `user_cashout`
--

CREATE TABLE IF NOT EXISTS `user_cashout` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `payment_info` text,
  `status` tinyint(3) unsigned DEFAULT NULL,
  `created` int(10) unsigned DEFAULT '0',
  `changed` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user_cashout`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_games`
--

CREATE TABLE IF NOT EXISTS `user_games` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `game_id` bigint(20) unsigned DEFAULT NULL,
  `count` bigint(20) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `user_games`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_games_saving`
--

CREATE TABLE IF NOT EXISTS `user_games_saving` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `demo_id` bigint(20) unsigned NOT NULL,
  `game_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `create` int(10) unsigned NOT NULL DEFAULT '0',
  `w1` text NOT NULL,
  `w2` text NOT NULL,
  `w3` text NOT NULL,
  `w4` text NOT NULL,
  `w5` text NOT NULL,
  PRIMARY KEY (`id`,`demo_id`,`game_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_games_saving`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `sex` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `player_status` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `player_volume` int(8) unsigned NOT NULL DEFAULT '50',
  `fullscreen` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `lang_id` bigint(20) unsigned NOT NULL DEFAULT '2',
  `avatar_id` int(10) unsigned NOT NULL DEFAULT '0',
  `country_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `city` text,
  `phone` text,
  `bonus_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `mailing` tinyint(4) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `name`, `sex`, `player_status`, `player_volume`, `fullscreen`, `lang_id`, `avatar_id`, `country_id`, `city`, `phone`, `bonus_id`, `mailing`) VALUES
(2, 'Alex', 0, 1, 50, 0, 1, 3, 0, 'Луганск', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_payment`
--

CREATE TABLE IF NOT EXISTS `user_payment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cash` double(20,2) DEFAULT '0.00',
  `total_in` double(20,2) NOT NULL,
  `total_out` double(20,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `user_payment`
--

INSERT INTO `user_payment` (`id`, `cash`, `total_in`, `total_out`) VALUES
(2, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `user_payment_history`
--

CREATE TABLE IF NOT EXISTS `user_payment_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `pincode_id` bigint(20) NOT NULL,
  `merchant_request_id` bigint(20) unsigned DEFAULT NULL,
  `cashout_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(4) DEFAULT NULL,
  `amount` double(20,2) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `datetime` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `user_payment_history`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(32) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_tokens`
--

