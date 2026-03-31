-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-03-2026 a las 18:54:26
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_sistema_inmobiliaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alquiler`
--

CREATE TABLE `alquiler` (
  `nro_operacion` int(11) NOT NULL,
  `nro_inmueble` int(11) NOT NULL,
  `titulo_publicacion` varchar(50) NOT NULL,
  `precio` int(50) NOT NULL,
  `disponibilidad` tinyint(1) NOT NULL,
  `esta_amoblado` tinyint(1) NOT NULL,
  `plazo` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alquiler`
--

INSERT INTO `alquiler` (`nro_operacion`, `nro_inmueble`, `titulo_publicacion`, `precio`, `disponibilidad`, `esta_amoblado`, `plazo`) VALUES
(1, 1, 'casa 1', 250000, 1, 1, 12),
(2, 2, 'departamento 0', 180000, 1, 0, 6),
(3, 4, 'departamento 1', 200000, 1, 0, 12),
(4, 5, 'departamento 2', 150000, 1, 1, 24),
(5, 6, 'oficina 1', 300000, 1, 1, 12),
(6, 7, 'oficina 2', 350000, 1, 1, 24),
(16, 21, 'titulo del departamento publicacion', 12345678, 1, 0, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto`
--

CREATE TABLE `foto` (
  `nro_foto` int(11) NOT NULL,
  `nombre_foto` varchar(100) NOT NULL,
  `path` varchar(250) NOT NULL,
  `nro_inmueble` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `foto`
--

INSERT INTO `foto` (`nro_foto`, `nombre_foto`, `path`, `nro_inmueble`) VALUES
(1, 'casa1 baño', 'imagenes/casa1_bano.jpg', 1),
(2, 'casa1 cocina', 'imagenes/casa1_cocina.jpg', 1),
(3, 'casa1 comedor', 'imagenes/casa1_comedor.jpg', 1),
(4, 'casa1 habitacion', 'imagenes/casa1_habitacion.jpg', 1),
(5, 'casa1 habitacion2', 'imagenes/casa1_habitacion2.jpg', 1),
(6, 'casa1 lavadero', 'imagenes/casa1_lavadero.jpg', 1),
(7, 'casa1 patio', 'imagenes/casa1_patio.jpg', 1),
(8, 'casa1 quincho', 'imagenes/casa1_quincho.jpg', 1),
(9, 'departamento0 bano', 'imagenes/departamento0_bano.jpg', 2),
(10, 'departamento0 cocina', 'imagenes/departamento0_cocina.jpg', 2),
(11, 'departamento0 living comedor', 'imagenes/departamento0_living_comedor.jpg', 2),
(12, 'casa3 bano', 'imagenes/casa3_bano.jpg', 3),
(13, 'casa3 cocina', 'imagenes/casa3_cocina.jpg', 3),
(14, 'casa3 comedor', 'imagenes/casa3_comedor.jpg', 3),
(15, 'casa3 garaje', 'imagenes/casa3_garaje.jpg', 3),
(16, 'casa3 living', 'imagenes/casa3_living.jpg', 3),
(17, 'casa3 patio', 'imagenes/casa3_patio.jpg', 3),
(18, 'departamento1 bano', 'imagenes/departamento1_bano.jpg', 4),
(19, 'departamento1 cocina', 'imagenes/departamento1_cocina.jpg', 4),
(20, 'departamento1 comedor', 'imagenes/departamento1_comedor.jpg', 4),
(21, 'departamento1 dormitorio', 'imagenes/departamento1_dormitorio.jpg', 4),
(22, 'departamento1 living', 'imagenes/departamento1_living.jpg', 4),
(23, 'departamento2 bano', 'imagenes/departamento2_bano.jpg', 5),
(24, 'departamento2 dormitorio', 'imagenes/departamento2_dormitorio.jpg', 5),
(25, 'departamento2 living comedor', 'imagenes/departamento2_living_comedor.jpg', 5),
(26, 'departamento2 mirador', 'imagenes/departamento2_mirador.jpg', 5),
(27, 'oficina1 administracion', 'imagenes/oficina1_administracion.jpg', 6),
(28, 'oficina1 bano', 'imagenes/oficina1_bano.jpg', 6),
(29, 'oficina1 callcenter', 'imagenes/oficina1_callcenter.jpg', 6),
(30, 'oficina1 cocina comedor', 'imagenes/oficina1_cocina_comedor.jpg', 6),
(31, 'oficina1 cubiculo', 'imagenes/oficina1_cubiculo.jpg', 6),
(32, 'oficina1 sala reunion', 'imagenes/oficina1_sala_reunion.jpg', 6),
(33, 'oficina1 atencion cliente', 'imagenes/oficina1_atencion_cliente.jpg', 6),
(34, 'oficina2 bano', 'imagenes/oficina2_bano.jpg', 7),
(35, 'oficina2 cocina', 'imagenes/oficina2_cocina.jpg', 7),
(36, 'oficina2 despacho', 'imagenes/oficina2_despacho.jpg', 7),
(37, 'oficina2 despacho2', 'imagenes/oficina2_despacho2.jpg', 7),
(38, 'oficina2 despacho3', 'imagenes/oficina2_despacho3.jpg', 7),
(39, 'terreno1', 'imagenes/terreno1.jpg', 8),
(40, 'terreno1 sur', 'imagenes/terreno1-sur.jpg', 8),
(41, 'terreno2 foto2', 'imagenes/terreno2-foto2.jpg', 9),
(42, 'terreno2 sur', 'imagenes/terreno2-sur.jpg', 9),
(43, 'Descripción de 1773095245428~2.jpg', 'imagenes/1774629960_1773095245428~2.jpg', 10),
(44, 'Descripción de IMG_20260221_095502661_HDR.jpg', 'imagenes/1774629960_IMG_20260221_095502661_HDR.jpg', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inmueble`
--

CREATE TABLE `inmueble` (
  `nro_inmueble` int(11) NOT NULL,
  `dni_usuario` varchar(8) NOT NULL,
  `tipo_propiedad` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `con_quincho` tinyint(1) NOT NULL,
  `con_lavadero` tinyint(1) NOT NULL,
  `con_patio` tinyint(1) NOT NULL,
  `con_garage` tinyint(1) NOT NULL,
  `cord_latitud` decimal(10,7) NOT NULL,
  `cord_longitud` decimal(10,7) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `zona` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inmueble`
--

INSERT INTO `inmueble` (`nro_inmueble`, `dni_usuario`, `tipo_propiedad`, `descripcion`, `con_quincho`, `con_lavadero`, `con_patio`, `con_garage`, `cord_latitud`, `cord_longitud`, `direccion`, `zona`) VALUES
(1, '12345678', 'casa', 'casa estilo rustico amoblada', 1, 1, 1, 0, -45.8202560, -67.4635620, 'amancay 38', 'zona_norte'),
(2, '12345678', 'departamento', 'departamento 0 no amueblado general mosconi', 0, 0, 0, 0, -45.8387730, -67.4880430, 'Av. Fray Luis Beltrán 692', 'zona_norte'),
(3, '87654321', 'casa', 'casa 3 no amueblada estilo rustico amplia', 0, 0, 1, 1, -45.8549810, -67.4974880, 'Alvear 1409', 'zona_sur'),
(4, '87654321', 'departamento', 'departamento 1 amoblado monoambiente', 0, 0, 0, 0, -45.8582240, -67.4961150, 'Virgen del Carmen 1498', 'zona_sur'),
(5, '87654321', 'departamento', 'departamento 3 sencillo', 0, 0, 0, 0, -45.8609890, -67.5226370, 'Las Orquideas 898', 'zona_centro'),
(6, '12345678', 'oficina', 'oficina 1', 0, 0, 0, 0, -45.8631700, -67.5203620, 'Wilde 2601', 'zona_centro'),
(7, '12345678', 'oficina', 'oficina 2', 0, 1, 0, 1, -45.8634690, -67.5136240, 'Florencio Sánchez 2596', 'zona_centro'),
(8, '12345678', 'terreno', 'terreno 1', 0, 0, 0, 0, -45.9227330, -67.5801670, 'escalante', 'rada_tilly'),
(9, '12345678', 'terreno', 'terreno 2', 0, 0, 0, 0, -45.9218070, -67.5774200, 'Aldea Alpaleg 3013', 'rada_tilly'),
(10, '12345678', 'departamento', 'departamento 5 hoala como estas estso es una descripcion', 1, 1, 0, 0, 123.0000000, 456.0000000, 'calle 123', 'zona_centro'),
(21, '12345678', 'departamento', 'departamento 5 hoala como estas estso es una descripcion', 1, 1, 0, 0, 123.0000000, 456.0000000, 'calle 123', 'zona_centro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `nro_mensaje` int(11) NOT NULL,
  `nro_inmueble` int(11) NOT NULL,
  `fecha_hora` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nro_celular` varchar(20) NOT NULL,
  `Cuerpo_mensaje` varchar(800) NOT NULL,
  `visto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`nro_mensaje`, `nro_inmueble`, `fecha_hora`, `nombre`, `apellido`, `email`, `nro_celular`, `Cuerpo_mensaje`, `visto`) VALUES
(1, 1, '2026-03-25 22:08:56', 'Santiago', 'Servin', 'santiago@servin.com', '12345678', 'cASA 1', 0),
(2, 1, '2026-03-26 22:11:10', 'Santiago', 'Servin', 'santiago@servin.com', '12345678', 'casa1', 0),
(3, 7, '2026-03-25 02:50:39', 'santino', 'sanchez', 'santiago@servin.com', '12345678', 'hola buenas tardes me gusto esa oficina 2', 0),
(4, 8, '2026-03-22 16:46:38', 'Santiago', 'Servin', 'santiago@servin.com', '12345678', 'buen día le quería preguntar el precio del terreno, si acepta en dólares', 0),
(5, 6, '2026-03-31 18:27:27', 'Santiago', 'Servin', 'santiago@servin.com', '12345678', 'Hola esta es mi consulta por la oficina 1 del centro', 0),
(6, 6, '2026-03-31 18:27:27', 'Santiago', 'Servin', 'santiago@servin.com', '12345678', 'Hola esta es mi consulta por la oficina 1 del centro', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion_financiacion`
--

CREATE TABLE `opcion_financiacion` (
  `cod_financiacion` varchar(50) NOT NULL,
  `titulo_opcion_financiacion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `opcion_financiacion`
--

INSERT INTO `opcion_financiacion` (`cod_financiacion`, `titulo_opcion_financiacion`) VALUES
('FBC-1', 'Financiacion banco Chubut'),
('FBG-1', 'Financiacion banco Galicia'),
('FBN-1', 'Financiacion banco Nacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_mensual`
--

CREATE TABLE `pago_mensual` (
  `nro_pago` int(11) NOT NULL,
  `monto_pago` int(50) NOT NULL,
  `fecha_pago` date NOT NULL,
  `mes_abonado` int(5) NOT NULL,
  `nro_operacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `r_financiacion_venta`
--

CREATE TABLE `r_financiacion_venta` (
  `nro_operacion` int(11) NOT NULL,
  `cod_financiacion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `r_financiacion_venta`
--

INSERT INTO `r_financiacion_venta` (`nro_operacion`, `cod_financiacion`) VALUES
(2, 'FBC-1'),
(2, 'FBG-1'),
(2, 'FBN-1'),
(3, 'FBC-1'),
(3, 'FBN-1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_administrador`
--

CREATE TABLE `usuario_administrador` (
  `dni` varchar(8) NOT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `nro_celular` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_administrador`
--

INSERT INTO `usuario_administrador` (`dni`, `contrasena`, `nombre`, `apellido`, `nro_celular`, `email`) VALUES
('12345678', '12345678', 'Juan', 'Pablo', '2971234567', 'juan@pablo.com'),
('87654321', '87654321', 'Pepe', 'Gonzales', '2977654321', 'pepe@gonzales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `nro_operacion` int(11) NOT NULL,
  `nro_inmueble` int(11) NOT NULL,
  `titulo_publicacion` varchar(50) NOT NULL,
  `precio` int(50) NOT NULL,
  `disponibilidad` tinyint(1) NOT NULL,
  `apto_credito_hipotecario` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`nro_operacion`, `nro_inmueble`, `titulo_publicacion`, `precio`, `disponibilidad`, `apto_credito_hipotecario`) VALUES
(1, 3, 'casa 3', 35000000, 1, 1),
(2, 8, 'terreno 1', 20000000, 1, 0),
(3, 9, 'terreno 2', 18000000, 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alquiler`
--
ALTER TABLE `alquiler`
  ADD PRIMARY KEY (`nro_operacion`),
  ADD KEY `inmueble_alquiler` (`nro_inmueble`);

--
-- Indices de la tabla `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`nro_foto`),
  ADD KEY `inmueble_foto` (`nro_inmueble`);

--
-- Indices de la tabla `inmueble`
--
ALTER TABLE `inmueble`
  ADD PRIMARY KEY (`nro_inmueble`),
  ADD KEY `Usuario_inmueble` (`dni_usuario`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`nro_mensaje`),
  ADD KEY `inmueble_mensaje` (`nro_inmueble`);

--
-- Indices de la tabla `opcion_financiacion`
--
ALTER TABLE `opcion_financiacion`
  ADD PRIMARY KEY (`cod_financiacion`);

--
-- Indices de la tabla `pago_mensual`
--
ALTER TABLE `pago_mensual`
  ADD PRIMARY KEY (`nro_pago`),
  ADD KEY `pago_mensual_Operacion` (`nro_operacion`);

--
-- Indices de la tabla `r_financiacion_venta`
--
ALTER TABLE `r_financiacion_venta`
  ADD PRIMARY KEY (`nro_operacion`,`cod_financiacion`),
  ADD KEY `cod_financiacion` (`cod_financiacion`);

--
-- Indices de la tabla `usuario_administrador`
--
ALTER TABLE `usuario_administrador`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`nro_operacion`),
  ADD KEY `venta_inmueble` (`nro_inmueble`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alquiler`
--
ALTER TABLE `alquiler`
  MODIFY `nro_operacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `foto`
--
ALTER TABLE `foto`
  MODIFY `nro_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `inmueble`
--
ALTER TABLE `inmueble`
  MODIFY `nro_inmueble` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `nro_mensaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pago_mensual`
--
ALTER TABLE `pago_mensual`
  MODIFY `nro_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `nro_operacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alquiler`
--
ALTER TABLE `alquiler`
  ADD CONSTRAINT `inmueble_alquiler` FOREIGN KEY (`nro_inmueble`) REFERENCES `inmueble` (`nro_inmueble`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `inmueble_foto` FOREIGN KEY (`nro_inmueble`) REFERENCES `inmueble` (`nro_inmueble`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inmueble`
--
ALTER TABLE `inmueble`
  ADD CONSTRAINT `Usuario_inmueble` FOREIGN KEY (`dni_usuario`) REFERENCES `usuario_administrador` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `inmueble_mensaje` FOREIGN KEY (`nro_inmueble`) REFERENCES `inmueble` (`nro_inmueble`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pago_mensual`
--
ALTER TABLE `pago_mensual`
  ADD CONSTRAINT `pago_mensual_Operacion` FOREIGN KEY (`nro_operacion`) REFERENCES `alquiler` (`nro_operacion`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `r_financiacion_venta`
--
ALTER TABLE `r_financiacion_venta`
  ADD CONSTRAINT `r_financiacion_venta_ibfk_1` FOREIGN KEY (`nro_operacion`) REFERENCES `venta` (`nro_operacion`),
  ADD CONSTRAINT `r_financiacion_venta_ibfk_2` FOREIGN KEY (`cod_financiacion`) REFERENCES `opcion_financiacion` (`cod_financiacion`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_inmueble` FOREIGN KEY (`nro_inmueble`) REFERENCES `inmueble` (`nro_inmueble`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
