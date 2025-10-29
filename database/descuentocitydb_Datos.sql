-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-10-2025 a las 01:59:05
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `descuentocitydb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `IdImg` int(11) NOT NULL,
  `tipoImg` enum('logo','galeria','portada','carrusel') NOT NULL,
  `nombreImg` varchar(255) NOT NULL,
  `rutaArchivo` varchar(255) NOT NULL,
  `tipoIdentidad` enum('local','novedad','promocion') NOT NULL,
  `idIdentidad` int(11) NOT NULL,
  `fechaSubida` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`IdImg`, `tipoImg`, `nombreImg`, `rutaArchivo`, `tipoIdentidad`, `idIdentidad`, `fechaSubida`) VALUES
(1, 'logo', '1761115333_fac4b0ca.jpg', 'uploads/logos/1761115333_fac4b0ca.jpg', 'local', 19, '2025-10-22 03:42:13'),
(2, 'logo', '1761115361_mclogo.png', 'uploads/logos/1761115361_mclogo.png', 'local', 20, '2025-10-22 03:42:41'),
(3, 'logo', '1761115514_logoWilson.webp', 'uploads/logos/1761115514_logoWilson.webp', 'local', 22, '2025-10-22 03:45:14'),
(4, 'logo', '1761150592_e9820a99.png', 'uploads/logos/1761150592_e9820a99.png', 'local', 21, '2025-10-22 13:29:52'),
(5, 'portada', '1761348924_promoMC.png', 'uploads/fondoPromo/1761348924_promoMC.png', 'promocion', 5, '2025-10-24 20:35:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locales`
--

CREATE TABLE `locales` (
  `codLocal` int(11) NOT NULL,
  `nombreLocal` varchar(100) NOT NULL,
  `ubicacionLocal` varchar(150) DEFAULT NULL,
  `rubroLocal` varchar(50) DEFAULT NULL,
  `codUsuario` int(11) NOT NULL,
  `estadoLocal` enum('activo','eliminado') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `locales`
--

INSERT INTO `locales` (`codLocal`, `nombreLocal`, `ubicacionLocal`, `rubroLocal`, `codUsuario`, `estadoLocal`) VALUES
(19, 'Babolat', 'P3 - L10', 'Indumentaria', 13, 'activo'),
(20, 'Mc Donald', 'P3 - L2', 'Gastronomia', 10, 'activo'),
(21, 'Head', 'P1 - L10', 'Indumentaria', 15, 'activo'),
(22, 'Wilson', 'P6 - L7', 'Indumentaria', 8, 'eliminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedades`
--

CREATE TABLE `novedades` (
  `codNovedad` int(11) NOT NULL,
  `textoNovedad` text NOT NULL,
  `fechaDesdeNovedad` date NOT NULL,
  `fechaHastaNovedad` date NOT NULL,
  `tipoUsuario` enum('inicial','medium','premium') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `codPromo` int(11) NOT NULL,
  `textoPromo` varchar(200) NOT NULL,
  `fechaDesdePromo` date NOT NULL,
  `fechaHastaPromo` date NOT NULL,
  `categoriaCliente` enum('Inicial','Medium','Premium') NOT NULL,
  `diasSemana` set('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo') DEFAULT NULL,
  `estadoPromo` enum('pendiente','aprobada','denegada') NOT NULL DEFAULT 'pendiente',
  `codLocal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`codPromo`, `textoPromo`, `fechaDesdePromo`, `fechaHastaPromo`, `categoriaCliente`, `diasSemana`, `estadoPromo`, `codLocal`) VALUES
(5, '2x1 en Hamburguesas', '2025-10-25', '2025-10-29', 'Inicial', 'Viernes,Sábado,Domingo', 'pendiente', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_descuentos`
--

CREATE TABLE `solicitudes_descuentos` (
  `id_solicitud` int(11) NOT NULL,
  `codCliente` int(11) NOT NULL,
  `codPromo` int(11) NOT NULL,
  `fecha_solicitud` datetime DEFAULT current_timestamp(),
  `estado` enum('pendiente','aceptada','rechazada') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uso_promociones`
--

CREATE TABLE `uso_promociones` (
  `idUso` int(11) NOT NULL,
  `codCliente` int(11) NOT NULL,
  `codPromo` int(11) NOT NULL,
  `fechaUsoPromo` datetime DEFAULT current_timestamp(),
  `estado` enum('enviada','aceptada','rechazada') DEFAULT 'enviada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `codUsuario` int(11) NOT NULL,
  `nombreUsuario` varchar(100) NOT NULL,
  `claveUsuario` varchar(255) NOT NULL,
  `tipoUsuario` enum('admin','dueño','cliente') NOT NULL,
  `categoriaCliente` enum('inicial','medium','premium') DEFAULT 'inicial',
  `estadoUsuario` enum('activo','pendiente','eliminado') DEFAULT 'pendiente',
  `token` varchar(64) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`codUsuario`, `nombreUsuario`, `claveUsuario`, `tipoUsuario`, `categoriaCliente`, `estadoUsuario`, `token`, `fechaRegistro`) VALUES
(1, 'admin@dc.com', '$2y$10$qCL0YTwTjf961QJ3HbVJlO88WsbZ5idzZfFtVeb6DUjcgBxiAE4dG', 'admin', 'inicial', 'activo', NULL, '2025-10-20 22:07:45'),
(2, 'gabilovato45@gmail.com', '$2y$10$/iwCg69xzMzHqcEtDEP8bu5l281ApK.Sx3nRCsgZQpuqdI2bdI5hq', 'cliente', 'inicial', 'activo', NULL, '2025-10-20 22:09:05'),
(3, 'latriesta@dc.com', '$2y$10$NRi.5jXdU29HFOfhEgz2Pu1EgBoVnNyCzxLdCJ.i8noDoejA0yOie', 'dueño', 'inicial', 'eliminado', 'd0c2ef7795dcb101ab43edb9acc263fb', '2025-10-20 22:24:44'),
(8, 'wilson@dc.com', '$2y$10$yI8e/wHjG28SnMVZgmRchu9Olsjt9Z.QWe/XR39GNEgkNhw8wIJGi', 'dueño', 'inicial', 'activo', '4c7b4dfbdc2f80fb1ecf6342e2308f69', '2025-10-21 01:02:04'),
(10, 'mc@dc.com', '$2y$10$G4vMk9YrpYbFN8pf5b4N2O0xhZDdfravas9Ff.Wrc0JNVDfz1C.7q', 'dueño', 'inicial', 'activo', '0d3049759e979a682a5fde0ad034e64a', '2025-10-21 10:18:16'),
(11, 'niike@dc.com', '$2y$10$U2BUjqbkE1NK7zrrLnsYnudpTYFn80237hdd8DBnudf0w1XWJeVLu', 'dueño', 'inicial', 'activo', 'b45517d9d19ee7f9f531bae54fed1ef6', '2025-10-21 15:09:20'),
(12, 'adidas@gmail.com', '$2y$10$OBQDi38RIP9jpSOdi7IcmeoDcISN0AdkqgeBEUWidLOGGaphLpruC', 'dueño', 'inicial', 'activo', '04dbe3dc6ba5018f3bf8d8b1eee0cc52', '2025-10-21 23:58:11'),
(13, 'babolat@dc.com', '$2y$10$QYQcb5Uo/WiZZpIygZkx.ehvHNdAiu/7GZa3FCSVqeQNEMJDHbSBy', 'dueño', 'inicial', 'pendiente', '725d8f61565ee7cd607e6701e413d707', '2025-10-22 01:40:10'),
(14, 'prince@dc.com', '$2y$10$9vNSnygFnRqEmscc6qFXOe5kGmovK0tUsD6Tb5DlnSzedZuCZl6vG', 'dueño', 'inicial', 'eliminado', 'c3ccfe4b33819e49f8717fcf4a9012f2', '2025-10-22 01:41:26'),
(15, 'head@dc.com', '$2y$10$HLAs57Akxs2c78WDebtY5.HnHdqoC0auwXAwpp7v6uNy2.gI6pDDq', 'dueño', 'inicial', 'activo', '811bb65cb991850e3ef806894d2f471d', '2025-10-22 01:41:43');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`IdImg`);

--
-- Indices de la tabla `locales`
--
ALTER TABLE `locales`
  ADD PRIMARY KEY (`codLocal`),
  ADD KEY `codUsuario` (`codUsuario`);

--
-- Indices de la tabla `novedades`
--
ALTER TABLE `novedades`
  ADD PRIMARY KEY (`codNovedad`);

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`codPromo`),
  ADD KEY `codLocal` (`codLocal`);

--
-- Indices de la tabla `solicitudes_descuentos`
--
ALTER TABLE `solicitudes_descuentos`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `codCliente` (`codCliente`),
  ADD KEY `codPromo` (`codPromo`);

--
-- Indices de la tabla `uso_promociones`
--
ALTER TABLE `uso_promociones`
  ADD PRIMARY KEY (`idUso`),
  ADD UNIQUE KEY `codCliente` (`codCliente`,`codPromo`),
  ADD KEY `codPromo` (`codPromo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`codUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `IdImg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `locales`
--
ALTER TABLE `locales`
  MODIFY `codLocal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `novedades`
--
ALTER TABLE `novedades`
  MODIFY `codNovedad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `codPromo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `solicitudes_descuentos`
--
ALTER TABLE `solicitudes_descuentos`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `uso_promociones`
--
ALTER TABLE `uso_promociones`
  MODIFY `idUso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `codUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `locales`
--
ALTER TABLE `locales`
  ADD CONSTRAINT `locales_ibfk_1` FOREIGN KEY (`codUsuario`) REFERENCES `usuarios` (`codUsuario`);

--
-- Filtros para la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD CONSTRAINT `promociones_ibfk_1` FOREIGN KEY (`codLocal`) REFERENCES `locales` (`codLocal`);

--
-- Filtros para la tabla `solicitudes_descuentos`
--
ALTER TABLE `solicitudes_descuentos`
  ADD CONSTRAINT `solicitudes_descuentos_ibfk_1` FOREIGN KEY (`codCliente`) REFERENCES `usuarios` (`codUsuario`),
  ADD CONSTRAINT `solicitudes_descuentos_ibfk_2` FOREIGN KEY (`codPromo`) REFERENCES `promociones` (`codPromo`);

--
-- Filtros para la tabla `uso_promociones`
--
ALTER TABLE `uso_promociones`
  ADD CONSTRAINT `uso_promociones_ibfk_1` FOREIGN KEY (`codCliente`) REFERENCES `usuarios` (`codUsuario`),
  ADD CONSTRAINT `uso_promociones_ibfk_2` FOREIGN KEY (`codPromo`) REFERENCES `promociones` (`codPromo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
