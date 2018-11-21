-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-11-2018 a las 04:10:02
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `map_rutas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `andciudades`
--

CREATE TABLE `andciudades` (
  `ciuId` int(11) NOT NULL,
  `ciuNombre` varchar(50) NOT NULL,
  `ciuLatitud` varchar(40) NOT NULL,
  `ciuLongitud` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `andciudades`
--

INSERT INTO `andciudades` (`ciuId`, `ciuNombre`, `ciuLatitud`, `ciuLongitud`) VALUES
(1, 'Guayaquil', '-2.1709979', '-79.9223592'),
(2, 'Cuenca', '-2.9001285', '-79.0058965'),
(3, 'Ambato', '-1.2490800', '-78.6167500'),
(4, 'Quito', '-0.1806532', '-78.4678382'),
(6, 'Portoviejo', '-1.0545800', '-80.4544500'),
(7, 'Riobamba', '-1.6709800', '-78.6471200');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `andrutaciudad`
--

CREATE TABLE `andrutaciudad` (
  `rutCiuId` int(11) NOT NULL,
  `rutCiuRutaId` int(11) NOT NULL,
  `rutCiuCiudadId` int(11) NOT NULL,
  `rutCiuOrden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `andrutas`
--

CREATE TABLE `andrutas` (
  `rutId` int(11) NOT NULL,
  `rutCodCiudad` varchar(20) NOT NULL,
  `rutNombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `andciudades`
--
ALTER TABLE `andciudades`
  ADD PRIMARY KEY (`ciuId`);

--
-- Indices de la tabla `andrutaciudad`
--
ALTER TABLE `andrutaciudad`
  ADD PRIMARY KEY (`rutCiuId`);

--
-- Indices de la tabla `andrutas`
--
ALTER TABLE `andrutas`
  ADD PRIMARY KEY (`rutId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `andciudades`
--
ALTER TABLE `andciudades`
  MODIFY `ciuId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `andrutaciudad`
--
ALTER TABLE `andrutaciudad`
  MODIFY `rutCiuId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `andrutas`
--
ALTER TABLE `andrutas`
  MODIFY `rutId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
