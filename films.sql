-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `films`;
CREATE TABLE `films` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `title_original` text NOT NULL,
  `duration` int(11) DEFAULT NULL,
  `resolution` enum('','sd','720','1080') DEFAULT NULL,
  `language` enum('','muda','doblada','dual','vose','v-original') DEFAULT NULL,
  `sound` enum('','dolby-digital','dts','flac','dolby-digital-ex','dolby-true-hd','dts-hd','pcm','mp3','acc') DEFAULT NULL,
  `channel` enum('','1-0','2-0','5-1','7-1') DEFAULT NULL,
  `img` text,
  `notes` text,
  `status` enum('','seleccionada','para-reordenar','para-borrar','para-reemplazar') DEFAULT NULL,
  `imdb` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('year','genre','saga','author','format') NOT NULL,
  `value` text NOT NULL,
  `film_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `views`;
CREATE TABLE `views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mode` enum('tv','mobile','cinema','room') NOT NULL,
  `film_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- 2018-06-06 22:23:55
