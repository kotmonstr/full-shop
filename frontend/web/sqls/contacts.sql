
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 24 2015 г., 12:45
-- Версия сервера: 10.0.20-MariaDB
-- Версия PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `u480027760_shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `content` text,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `contacts`
--

INSERT INTO `contacts` (`id`, `ip`, `user_id`, `content`, `name`, `email`, `subject`, `created_at`) VALUES
(1, '127.0.0.1', '1', 'dg dh ergberb', 'sdfv', 'adfvsdfv', 'dfvsdfv', 1433712692),
(2, '127.0.0.1', '1', 'dghn dgh', 'gndethn', 'dgnfghm', 'dfndhn', 1433713475),
(3, '127.0.0.1', '1', '3erf3f', 'efwerf', 'kot@kot.ff', 'werfw', 1433713769),
(4, '127.0.0.1', '1', 'wsedcf', 'efwerf', 'kot@kot.ff', 'werfw', 1433713926),
(5, '127.0.0.1', '1', '4tv4tv', '3rv3rv', 'kot@kot.yy', '34tv34tv', 1433713953),
(6, '127.0.0.1', '1', '4tv4tv', '3rv3rv', 'kot@kot.yy', '34tv34tv', 1433713990),
(7, '127.0.0.1', '1', 'wergwerg', 'egwe', 'kot@kot.gg', 'ergwerg', 1433714012),
(8, '49s9fj370p7', '49s9fj370p7gidbkg0a5hlmfc4', 'ujm6um', 'rgmtym', 'kotmonstr@ukr.net', 'ym6y', 1436139040);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
