-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-05-2014 a las 04:52:29
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `medicos`
--
CREATE DATABASE IF NOT EXISTS `medicos` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `medicos`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(10) NOT NULL DEFAULT '',
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('Chechare', '123456'),
('petra', 'abc123'),
('secre1', 'contra1'),
('YoabP', 'qwerty');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `appointment`
--

DROP TABLE IF EXISTS `appointment`;
CREATE TABLE IF NOT EXISTS `appointment` (
  `pID` varchar(4) NOT NULL DEFAULT '',
  `drId` varchar(3) NOT NULL DEFAULT '',
  `app_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` varchar(140) DEFAULT NULL,
  `approved` char(1) DEFAULT NULL,
  PRIMARY KEY (`pID`,`drId`,`app_datetime`),
  KEY `fk_appointmentDr` (`drId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `appointment`
--

INSERT INTO `appointment` (`pID`, `drId`, `app_datetime`, `description`, `approved`) VALUES
('P002', 'D03', '2014-05-23 16:30:00', 'a mi hija le duele la panza y tiene diarrea', 'P'),
('P003', 'D01', '2014-05-23 16:30:00', 'tengo dolor de cabeza y no se que hacer al respecto', 'C'),
('P004', 'D02', '2014-05-23 16:30:00', 'tengo calentura y vomito desde hace 2 dias', 'A');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `app_data`
--
DROP VIEW IF EXISTS `app_data`;
CREATE TABLE IF NOT EXISTS `app_data` (
`drid` varchar(3)
,`pid` varchar(4)
,`dfname` varchar(50)
,`dlname` varchar(50)
,`pfname` varchar(50)
,`plname` varchar(50)
,`description` varchar(140)
,`app_start` varchar(21)
,`app_end` varchar(10)
,`app_lenght` varchar(21)
,`status` char(1)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctor`
--

DROP TABLE IF EXISTS `doctor`;
CREATE TABLE IF NOT EXISTS `doctor` (
  `drID` varchar(3) NOT NULL DEFAULT '',
  `dfname` varchar(50) NOT NULL,
  `dlname` varchar(50) NOT NULL,
  `specialty` varchar(20) NOT NULL,
  `app_lenght` datetime NOT NULL,
  PRIMARY KEY (`drID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `doctor`
--

INSERT INTO `doctor` (`drID`, `dfname`, `dlname`, `specialty`, `app_lenght`) VALUES
('D01', 'Gabriel', 'Perez Osuna', 'Neurocirujano', '2014-05-23 01:00:00'),
('D02', 'Martin', 'Rosas Marquez', 'Pediatra', '2014-05-23 00:45:00'),
('D03', 'Paola', 'Hernandez Bojorquez', 'Ornitolarringologa', '2014-05-23 00:30:00');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `doctor_data`
--
DROP VIEW IF EXISTS `doctor_data`;
CREATE TABLE IF NOT EXISTS `doctor_data` (
`drid` varchar(3)
,`dfname` varchar(50)
,`dlname` varchar(50)
,`specialty` varchar(20)
,`lenght` varchar(10)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `hour_data`
--
DROP VIEW IF EXISTS `hour_data`;
CREATE TABLE IF NOT EXISTS `hour_data` (
`day` varchar(10)
,`drid` varchar(3)
,`starthour` varchar(10)
,`endhour` varchar(10)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `pId` varchar(4) NOT NULL DEFAULT '',
  `pfname` varchar(50) NOT NULL,
  `plname` varchar(50) NOT NULL,
  `phone` int(10) DEFAULT NULL,
  `email` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`pId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `patient`
--

INSERT INTO `patient` (`pId`, `pfname`, `plname`, `phone`, `email`) VALUES
('P001', 'Andrea', 'Lopez Pineda', 33123456, 'andrea_moxi@gmail.com'),
('P002', 'Martin', 'Martinez Martinez', 33234561, 'martin3@gmail.com'),
('P003', 'Maria de la Concepcion', 'Pureza de la Hoya', 33345612, 'maryconchita@gmail.com'),
('P004', 'Esteban Julio Ricardo', 'Montoya de la Rosa Ramirez', 33234561, 'esteban34@gmail.com');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `patient_data`
--
DROP VIEW IF EXISTS `patient_data`;
CREATE TABLE IF NOT EXISTS `patient_data` (
`pid` varchar(4)
,`pfname` varchar(50)
,`plname` varchar(50)
,`phone` int(10)
,`email` varchar(254)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `day` varchar(10) NOT NULL DEFAULT '',
  `drID` varchar(3) NOT NULL DEFAULT '',
  `startHour` datetime DEFAULT NULL,
  `endHour` datetime DEFAULT NULL,
  PRIMARY KEY (`day`,`drID`),
  KEY `fk_scheduleDr` (`drID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `schedule`
--

INSERT INTO `schedule` (`day`, `drID`, `startHour`, `endHour`) VALUES
('domingo', 'D01', '2014-05-23 10:00:00', '2014-05-23 17:00:00'),
('domingo', 'D02', '2014-05-23 10:00:00', '2014-05-23 17:00:00'),
('domingo', 'D03', '2014-05-23 10:00:00', '2014-05-23 17:00:00'),
('jueves', 'D01', '2014-05-23 07:00:00', '2014-05-23 20:00:00'),
('jueves', 'D02', '2014-05-23 07:00:00', '2014-05-23 20:00:00'),
('jueves', 'D03', '2014-05-23 07:00:00', '2014-05-23 20:00:00'),
('lunes', 'D01', '2014-05-23 07:00:00', '2014-05-23 20:00:00'),
('lunes', 'D02', '2014-05-23 07:00:00', '2014-05-23 20:00:00'),
('lunes', 'D03', '2014-05-23 07:00:00', '2014-05-23 20:00:00'),
('martes', 'D01', '2014-05-23 07:00:00', '2014-05-23 20:00:00'),
('martes', 'D02', '2014-05-23 07:00:00', '2014-05-23 20:00:00'),
('martes', 'D03', '2014-05-23 07:00:00', '2014-05-23 20:00:00'),
('miercoles', 'D01', '2014-05-23 07:00:00', '2014-05-23 20:00:00'),
('miercoles', 'D02', '2014-05-23 07:00:00', '2014-05-23 20:00:00'),
('miercoles', 'D03', '2014-05-23 07:00:00', '2014-05-23 20:00:00'),
('sabado', 'D01', '2014-05-23 10:00:00', '2014-05-23 20:00:00'),
('sabado', 'D02', '2014-05-23 10:00:00', '2014-05-23 20:00:00'),
('sabado', 'D03', '2014-05-23 10:00:00', '2014-05-23 20:00:00'),
('viernes', 'D01', '2014-05-23 07:00:00', '2014-05-23 20:00:00'),
('viernes', 'D02', '2014-05-23 07:00:00', '2014-05-23 20:00:00'),
('viernes', 'D03', '2014-05-23 07:00:00', '2014-05-23 20:00:00');

-- --------------------------------------------------------

--
-- Estructura para la vista `app_data`
--
DROP TABLE IF EXISTS `app_data`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `app_data` AS select `doctor`.`drID` AS `drid`,`patient`.`pId` AS `pid`,`doctor`.`dfname` AS `dfname`,`doctor`.`dlname` AS `dlname`,`patient`.`pfname` AS `pfname`,`patient`.`plname` AS `plname`,`appointment`.`description` AS `description`,date_format(`appointment`.`app_datetime`,'%Y-%m-%d %H:%i') AS `app_start`,date_format(timestamp(cast(`appointment`.`app_datetime` as time),cast(`doctor`.`app_lenght` as time)),'%H:%i') AS `app_end`,date_format(`doctor`.`app_lenght`,'%Y-%m-%d %H:%i') AS `app_lenght`,`appointment`.`approved` AS `status` from ((`doctor` join `patient`) join `appointment` on(((`doctor`.`drID` = `appointment`.`drId`) and (`patient`.`pId` = `appointment`.`pID`))));

-- --------------------------------------------------------

--
-- Estructura para la vista `doctor_data`
--
DROP TABLE IF EXISTS `doctor_data`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `doctor_data` AS select `doctor`.`drID` AS `drid`,`doctor`.`dfname` AS `dfname`,`doctor`.`dlname` AS `dlname`,`doctor`.`specialty` AS `specialty`,date_format(`doctor`.`app_lenght`,'%H:%i') AS `lenght` from `doctor`;

-- --------------------------------------------------------

--
-- Estructura para la vista `hour_data`
--
DROP TABLE IF EXISTS `hour_data`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `hour_data` AS select `schedule`.`day` AS `day`,`schedule`.`drID` AS `drid`,date_format(`schedule`.`startHour`,'%H:%i') AS `starthour`,date_format(`schedule`.`endHour`,'%H:%i') AS `endhour` from `schedule`;

-- --------------------------------------------------------

--
-- Estructura para la vista `patient_data`
--
DROP TABLE IF EXISTS `patient_data`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `patient_data` AS select `patient`.`pId` AS `pid`,`patient`.`pfname` AS `pfname`,`patient`.`plname` AS `plname`,`patient`.`phone` AS `phone`,`patient`.`email` AS `email` from `patient`;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `fk_appointmentPatient` FOREIGN KEY (`pID`) REFERENCES `patient` (`pId`),
  ADD CONSTRAINT `fk_appointmentDr` FOREIGN KEY (`drId`) REFERENCES `doctor` (`drID`);

--
-- Filtros para la tabla `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `fk_scheduleDr` FOREIGN KEY (`drID`) REFERENCES `doctor` (`drID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
