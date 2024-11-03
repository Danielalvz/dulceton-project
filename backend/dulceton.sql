-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2024 a las 01:42:23
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dulceton`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre`) VALUES
(1, 'Tortas'),
(3, 'Snacks'),
(4, 'Panadería'),
(5, 'Postres'),
(6, 'Bebidas'),
(7, 'Salados'),
(8, 'Accesorios'),
(9, 'Combos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `id_ciudad` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `fo_dpto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id_ciudad`, `nombre`, `fo_dpto`) VALUES
(1, 'Leticia', 1),
(2, 'Medellín', 2),
(3, 'Arauca', 3),
(4, 'Barranquilla', 4),
(5, 'Cartagena', 5),
(6, 'Tunja', 6),
(7, 'Manizales', 7),
(8, 'Florencia', 8),
(9, 'Yopal', 9),
(10, 'Popayán', 10),
(11, 'Valledupar', 11),
(12, 'Quibdó', 12),
(13, 'Montería', 13),
(14, 'Bogotá', 14),
(15, 'Inírida', 15),
(16, 'San José del Guaviare', 16),
(17, 'Neiva', 17),
(18, 'Riohacha', 18),
(19, 'Santa Marta', 19),
(20, 'Villavicencio', 20),
(21, 'Pasto', 21),
(22, 'Cúcuta', 22),
(23, 'Mocoa', 23),
(24, 'Armenia', 24),
(25, 'Pereira', 25),
(26, 'San Andrés', 26),
(27, 'Bucaramanga', 27),
(28, 'Sincelejo', 28),
(29, 'Ibagué', 29),
(30, 'Cali', 30),
(31, 'Mitú', 31),
(32, 'Puerto Carreño', 32),
(34, 'Ciudad Actualizada', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `identificacion` varchar(20) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fo_ciudad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `identificacion`, `nombre`, `direccion`, `telefono`, `email`, `fo_ciudad`) VALUES
(1, '587464', 'Pablo Perez', 'Cl wallaci 24', '123456789', 'pablop@egmail.com', 1),
(3, '2654541', 'Cliente Editado', 'Nueva Dirección', '987654321', 'clienteeditado@example.com', 2),
(4, '436343', 'arisita', '5645', '454', 'a@a.com', 29),
(7, '436343d', 'ari', '5645', '454', 'a@a.com', 31),
(9, '4363434', 'ariha', '4sff', '56146445', 'aa@a.com', 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id_compra` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `iva` decimal(5,2) NOT NULL,
  `fo_proveedor` int(11) NOT NULL,
  `fo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id_compra`, `fecha`, `iva`, `fo_proveedor`, `fo_usuario`) VALUES
(6, '2024-10-11', 1.00, 1, 3),
(8, '2024-10-24', 15.00, 1, 4),
(9, '2024-10-16', 1.00, 1, 3),
(10, '2024-10-04', 1.00, 1, 3),
(11, '2024-11-13', 6.00, 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `nombre`) VALUES
(1, 'Amazonas'),
(2, 'Antioquia'),
(3, 'Arauca'),
(4, 'Atlántico'),
(5, 'Bolívar'),
(6, 'Boyacá'),
(7, 'Caldas'),
(8, 'Caquetá'),
(9, 'Casanare'),
(10, 'Cauca'),
(11, 'Cesar'),
(12, 'Chocó'),
(13, 'Córdoba'),
(14, 'Cundinamarca'),
(15, 'Guainía'),
(16, 'Guaviare'),
(17, 'Huila'),
(18, 'La Guajira'),
(19, 'Magdalena'),
(20, 'Meta'),
(21, 'Nariño'),
(22, 'Norte de Santander'),
(23, 'Putumayo'),
(24, 'Quindío'),
(25, 'Risaralda'),
(26, 'San Andrés y Providencia'),
(27, 'Santander'),
(28, 'Sucre'),
(29, 'Tolima'),
(30, 'Valle del Cauca'),
(31, 'Vaupés'),
(32, 'Vichada'),
(34, 'Departamento Actualizado'),
(35, 'Nuevo Departamento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecompra`
--

CREATE TABLE `detallecompra` (
  `id_detalle_compra` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fo_compras` int(11) NOT NULL,
  `fo_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `detallecompra`
--

INSERT INTO `detallecompra` (`id_detalle_compra`, `cantidad`, `precio`, `fo_compras`, `fo_producto`) VALUES
(16, 1, 1.00, 8, 4),
(17, 100, 1.00, 9, 3),
(49, 1, 1.00, 11, 1),
(50, 100, 100.00, 11, 10),
(51, 1, 1.00, 11, 5),
(52, 1, 1.00, 11, 3),
(53, 100, 100.00, 11, 15),
(54, 1, 1.00, 6, 1),
(55, 1, 1.00, 10, 10),
(56, 1, 1.00, 10, 15),
(57, 1, 1.00, 10, 4),
(58, 1, 1.00, 10, 3),
(59, 1, 1.00, 6, 12),
(60, 1, 1.00, 9, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventa`
--

CREATE TABLE `detalleventa` (
  `id_detalle_venta` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fo_venta` int(11) NOT NULL,
  `fo_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `detalleventa`
--

INSERT INTO `detalleventa` (`id_detalle_venta`, `cantidad`, `precio`, `fo_venta`, `fo_producto`) VALUES
(5, 6, 18000.00, 3, 5),
(6, 10, 15000.00, 3, 2),
(9, 16, 1.00, 9, 4),
(11, 1, 1.00, 9, 3),
(12, 1, 1.00, 9, 7),
(13, 1, 1.00, 9, 3),
(14, 1, 1.00, 9, 4),
(15, 1, 1.00, 9, 8),
(16, 1, 1.00, 9, 3),
(17, 1, 1.00, 3, 4),
(18, 1, 1.00, 3, 3),
(19, 1, 1.00, 3, 4),
(20, 3, 3.00, 3, 12),
(21, 1, 1.00, 3, 3),
(22, 1, 1.00, 3, 3),
(23, 1, 1.00, 3, 3),
(24, 1, 1.00, 9, 5),
(25, 1, 1.00, 9, 3),
(26, 1, 1.00, 9, 5),
(27, 1, 1.00, 13, 5),
(28, 5, 1.00, 13, 5),
(29, 1, 1.00, 13, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `fo_categoria` int(11) NOT NULL,
  `valor_compra` decimal(10,2) NOT NULL,
  `valor_venta` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `venta_al_publico` tinyint(1) NOT NULL,
  `fo_proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `codigo`, `nombre`, `fo_categoria`, `valor_compra`, `valor_venta`, `stock`, `venta_al_publico`, `fo_proveedor`) VALUES
(1, 'P001', 'Torta de Chocolate 1 libra', 1, 15000.00, 30000.00, 20, 1, 1),
(2, 'P002', 'Torta de Zanahoria 1 libra', 1, 12500.00, 24000.00, 15, 1, 1),
(3, 'P003', 'Cheesecake de Fresa 1 libra', 1, 18000.00, 36000.00, 10, 1, 1),
(4, 'P004', 'Brownie por unidad', 5, 800.00, 1600.00, 100, 1, 2),
(5, 'P005', 'Cupcake de Vainilla por unidad', 5, 600.00, 1200.00, 150, 1, 2),
(6, 'P006', 'Macarons por unidad', 5, 2000.00, 4000.00, 50, 1, 1),
(7, 'P007', 'Torta de Manzana 1 libra', 1, 17000.00, 34000.00, 8, 1, 2),
(8, 'P008', 'Panqueques por unidad', 4, 1000.00, 2000.00, 60, 1, 2),
(9, 'P009', 'Muffin de Chocolate por unidad', 5, 700.00, 1400.00, 80, 1, 1),
(10, 'P010', 'Torta de Limón 1 libra', 1, 16000.00, 32000.00, 14, 1, 2),
(12, 'P011', 'Tartin de Chocolate 1 libra', 1, 15000.00, 32000.00, 15, 1, 1),
(15, 'P012', 'Galletas chip de chocolate', 4, 5000.00, 8000.00, 4, 1, 1),
(19, 'P015', 'Muffin mora azul', 4, 8000.00, 12000.00, 3, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `razon_social` varchar(20) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fo_ciudad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `razon_social`, `nombre`, `direccion`, `telefono`, `email`, `fo_ciudad`) VALUES
(1, '1565161', 'Doña Lupe', 'CRA 5 no.25-85', '3255856745', 'lalupe@gmail.com', 2),
(2, '5544155', 'Jacobo Martinez', 'CL 52 no. 57-85 la monarca', '3151526325', 'jacoboponques@gmail.com', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

CREATE TABLE `tipousuario` (
  `id_tipo_usuario` int(11) NOT NULL,
  `cargo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`id_tipo_usuario`, `cargo`) VALUES
(1, 'Administrador'),
(2, 'Vendedor'),
(3, 'Jefe de compras'),
(4, 'Practicante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `fo_tipo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `usuario`, `password`, `email`, `telefono`, `fo_tipo_usuario`) VALUES
(1, 'Arincon', '094e8e159db7824161b1e67ab209da503434c626', 'armandorincon@gmail.com', '3202000102', 2),
(2, 'Sramirez', '3b2090e3217adb6c29ba149cc9b2358bc6cb3541', 'susaramirez@gmail.com', '3145485256', 3),
(3, 'Aflorez', '8759003f94d0f07fdfcb69db7f992d774bcf6e5c', 'andresflorezn@gmail.com', '56146445', 2),
(4, 'Jperez', '57d94166ddde045952194477c07f278cc2f08af7', 'juanperez@gmail.com', '3102301152', 1),
(5, 'LuCorrales', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'lucia.corral@example.com', '21651512', 4),
(6, 'Carmin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'carmin@thebear.com', '221564154', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id_venta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `iva` decimal(5,2) NOT NULL,
  `fo_cliente` int(11) NOT NULL,
  `fo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id_venta`, `fecha`, `iva`, `fo_cliente`, `fo_usuario`) VALUES
(3, '2024-10-30', 19.00, 1, 3),
(9, '2024-10-21', 6.00, 7, 3),
(13, '2024-11-07', 1.00, 7, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id_ciudad`),
  ADD KEY `fo_dpto` (`fo_dpto`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `fo_ciudad` (`fo_ciudad`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `fk_compra_proveedor` (`fo_proveedor`),
  ADD KEY `fk_compra_usuario` (`fo_usuario`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD PRIMARY KEY (`id_detalle_compra`),
  ADD KEY `fo_compras` (`fo_compras`),
  ADD KEY `fo_producto` (`fo_producto`);

--
-- Indices de la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD PRIMARY KEY (`id_detalle_venta`),
  ADD KEY `fo_venta` (`fo_venta`),
  ADD KEY `fo_producto` (`fo_producto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `fo_proveedor` (`fo_proveedor`),
  ADD KEY `fk_producto_categoria` (`fo_categoria`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD KEY `fo_producto` (`fo_ciudad`);

--
-- Indices de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fo_tipo_usuario` (`fo_tipo_usuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `fo_cliente` (`fo_cliente`),
  ADD KEY `fo_usuario` (`fo_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `id_ciudad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  MODIFY `id_detalle_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  MODIFY `id_detalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD CONSTRAINT `fk_ciudad_departamento` FOREIGN KEY (`fo_dpto`) REFERENCES `departamento` (`id_departamento`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_cliente_ciudad` FOREIGN KEY (`fo_ciudad`) REFERENCES `ciudad` (`id_ciudad`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_proveedor` FOREIGN KEY (`fo_proveedor`) REFERENCES `proveedor` (`id_proveedor`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_compra_usuario` FOREIGN KEY (`fo_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD CONSTRAINT `fk_detallecompra_compras` FOREIGN KEY (`fo_compras`) REFERENCES `compra` (`id_compra`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detallecompra_producto` FOREIGN KEY (`fo_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD CONSTRAINT `fk_detalleventa_producto` FOREIGN KEY (`fo_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalleventa_venta` FOREIGN KEY (`fo_venta`) REFERENCES `venta` (`id_venta`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`fo_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto_proveedor` FOREIGN KEY (`fo_proveedor`) REFERENCES `proveedor` (`id_proveedor`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `fk_proveedor_ciudad` FOREIGN KEY (`fo_ciudad`) REFERENCES `ciudad` (`id_ciudad`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_tipousuario` FOREIGN KEY (`fo_tipo_usuario`) REFERENCES `tipousuario` (`id_tipo_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `fk_venta_cliente` FOREIGN KEY (`fo_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_venta_usuario` FOREIGN KEY (`fo_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
