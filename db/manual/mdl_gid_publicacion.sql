-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2016 at 12:26 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `moodle`
--

-- --------------------------------------------------------

--
-- Table structure for table `mdl_gid_publicacion`
--

CREATE TABLE IF NOT EXISTS `mdl_gid_publicacion` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `publicacion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(11) DEFAULT NULL,
  `nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fecha_creacion` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `material_id` bigint(10) DEFAULT NULL,
  `ramo_id` bigint(10) DEFAULT NULL,
  `curso_id` bigint(10) NOT NULL,
  `descripcion` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `clasificacion` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_gidpubl_mat_ix` (`material_id`),
  KEY `mdl_gidpubl_ram_ix` (`ramo_id`),
  KEY `ramo_id` (`ramo_id`),
  KEY `user_id` (`user_id`),
  KEY `curso_id` (`curso_id`),
  KEY `curso_id_2` (`curso_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='tabla para publicaciones' AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mdl_gid_publicacion`
--
ALTER TABLE `mdl_gid_publicacion`
  ADD CONSTRAINT `mdl_gid_publicacion_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mdl_user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
