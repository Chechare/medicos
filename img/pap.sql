-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-04-2014 a las 15:19:50
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `pap`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE IF NOT EXISTS `eventos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `video` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `clasificacion` varchar(50) NOT NULL,
  `tipo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `latitud` double NOT NULL,
  `longitud` double NOT NULL,
  `meta` int(8) NOT NULL,
  `recaudado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `titulo`, `descripcion`, `video`, `clasificacion`, `tipo`, `fecha`, `latitud`, `longitud`, `meta`, `recaudado`) VALUES
(1, 'Eventito', 'ASD', 'https://www.youtube.com/watch?v=pW-Njfe6zcg', 'evento', 'social', '2014-04-04', 16.951723, -93.29933, 10000, 0),
(2, 'Problemas Sociales en Afganistán', 'La guerra civil en Afganistán ha causado múltiples males sociales como pobreza, robos, secuestros, inequidad y  encuentros violentos entre grupos étnicos. La continua guerra civil ha causado la muerte de cientos de personas. Pueblos como Kabul se han mantenido sin electricidad por más de una década debido a estos enfrentamientos.', 'https://www.youtube.com/watch?v=qbSTuGDtzks', 'evento', 'social', '2014-12-31', 33.9333, 66.1833, 9000000, 230000);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
