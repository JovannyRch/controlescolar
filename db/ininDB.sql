-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 05-08-2018 a las 17:26:34
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `midb`
--
CREATE DATABASE IF NOT EXISTS `midb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `midb`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE `autores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`id`, `nombre`, `tipo`) VALUES
(1, 'Haruki Murakami', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificaciones`
--

CREATE TABLE `clasificaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clasificaciones`
--

INSERT INTO `clasificaciones` (`id`, `nombre`, `tipo`) VALUES
(2, 'Clásica xd', 1),
(3, 'Pop', 1),
(4, 'Sinfónica', 1),
(5, 'Regional Mexicano', 1),
(6, 'Ciencia Ficcion', 2),
(7, 'Acción', 2),
(9, 'Ciencia Ficción', 3),
(11, 'Urbano', 1),
(12, 'Cumbia', 1),
(13, 'x', 2),
(14, 'Hola', 3),
(15, 'sad', 3),
(18, 'Docs', 3),
(20, 'Asdfad', 3),
(38, '1', 3),
(39, '4', 3),
(40, '23', 3),
(41, '125', 3),
(42, '123', 3),
(43, '124', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `paterno` varchar(50) NOT NULL,
  `materno` varchar(50) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `direccion` text NOT NULL,
  `password` varchar(15) DEFAULT NULL,
  `tipo_usuario` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `paterno`, `materno`, `correo`, `telefono`, `direccion`, `password`, `tipo_usuario`, `username`) VALUES
(1, 'Jovanny', 'Ramírez', 'Chimal', 'jovannyrch@gmail.com', 7121397374, 'DC', '1234', 1, 'j19'),
(2, 'Miriam', 'Ramírez', 'García', 'mrgbep@gmail.com', 7122080680, 'San Pedro el Alto', NULL, 2, NULL),
(3, 'Andrea', 'Ramírez', 'Chimal', 'andy@gmail.com', 123123, 'asd', NULL, 2, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clasificaciones`
--
ALTER TABLE `clasificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autores`
--
ALTER TABLE `autores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `clasificaciones`
--
ALTER TABLE `clasificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
