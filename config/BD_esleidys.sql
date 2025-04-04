-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-04-2025 a las 20:18:03
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
-- Base de datos: `venta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `ID` int(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `rol` varchar(255) NOT NULL,
  `pw` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`ID`, `usuario`, `rol`, `pw`) VALUES
(2, '@admin_ca', 'Administrador', '$2y$10$wyceSs4IUq08hnu2VYm/rOHcIepYuU2SdoslpClA7GN5V5nAZV126'),
(9, '@user_ca', 'Usuario', '$2y$10$KeSPukQrDVa8qGep.ZAXN.SNcqDHbBI573cq9XNuv12zSatxGJ0HO'),
(13, '@cajero_ca', 'Cajero', '$2y$10$r2IqiyXhlP5QzceGgwCbL.Nu0YnPw0WmJRJj4UTkWonTf7mmmQ5gO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancos`
--

CREATE TABLE `bancos` (
  `ID` int(255) NOT NULL,
  `rif_banco` int(255) NOT NULL,
  `nombre_banco` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `bancos`
--

INSERT INTO `bancos` (`ID`, `rif_banco`, `nombre_banco`) VALUES
(3, 102, 'Venezuela'),
(4, 104, 'Venezolano de Credito'),
(5, 105, 'Mercantil'),
(6, 108, 'Provincial'),
(7, 114, 'Bancaribe'),
(8, 115, 'Exteriror'),
(9, 116, 'Occidental de Descuento'),
(10, 128, 'Banco Caroni'),
(11, 134, 'Banesco'),
(12, 137, 'Banco Sofitasa'),
(13, 138, 'Banco Plaza'),
(14, 151, 'Banco Fondo Comun'),
(15, 156, '100% Banco'),
(16, 157, 'Banco del Sur'),
(17, 163, 'Banco del Tesoro'),
(18, 166, 'Banco Agricola de Venezuela'),
(19, 168, 'Bancrecer'),
(20, 169, 'Mi Banco'),
(21, 172, 'Bancamiga'),
(22, 174, 'Banplus'),
(23, 175, 'Bicentenario del Pueblo'),
(24, 177, 'Banfanb'),
(25, 191, 'Banco Nacional de Credito'),
(26, 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `ID` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `movimiento` varchar(20) NOT NULL,
  `modulo` varchar(20) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`ID`, `fecha`, `movimiento`, `modulo`, `descripcion`, `id_admin`) VALUES
(40, '2025-03-26 18:01:39', 'Agregar', 'Cliente', 'Cliente con la cedula: V- 3122123', 2),
(41, '2025-03-26 18:01:48', 'Eliminar', 'Cliente', 'Cliente con la cedula: V- 3122123', 2),
(42, '2025-03-26 18:16:15', 'Modificar', 'Producto', 'Producto: Refresco BigCola 2lt', 2),
(43, '2025-03-27 15:58:15', 'Agregar', 'Producto', 'Producto: pasta', 2),
(44, '2025-03-27 16:03:10', 'Agregar', 'Producto', 'Producto: pasta', 2),
(45, '2025-03-27 16:23:29', 'Eliminar', 'Producto', 'Producto: pasta', 2),
(46, '2025-03-27 16:24:02', 'Agregar', 'Producto', 'Producto: pasta', 2),
(47, '2025-03-27 16:28:08', 'Eliminar', 'Producto', 'Producto: pasta', 2),
(48, '2025-03-27 16:28:33', 'Agregar', 'Producto', 'Producto: pasta', 2),
(49, '2025-03-27 16:30:28', 'Agregar', 'Producto', 'Producto: pasta', 2),
(50, '2025-03-27 16:34:22', 'Agregar', 'Producto', 'Producto: pasta', 2),
(51, '2025-03-27 16:38:12', 'Agregar', 'Producto', 'Producto: pasta', 2),
(52, '2025-03-27 16:41:57', 'Agregar', 'Producto', 'Producto: pasta', 2),
(53, '2025-03-27 16:43:38', 'Agregar', 'Producto', 'Producto: pasta', 2),
(54, '2025-03-27 17:14:22', 'Agregar', 'Producto', 'Producto: Refresco BigCola 2lt', 2),
(55, '2025-03-27 17:19:03', 'Agregar', 'Producto', 'Producto: Azucar La Pastora 1k', 2),
(56, '2025-03-27 17:20:26', 'Agregar', 'Producto', 'Producto: Azucar Sabana Dulce', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `ID` int(50) NOT NULL,
  `nombre_caja` varchar(255) NOT NULL,
  `saldo_caja` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`ID`, `nombre_caja`, `saldo_caja`) VALUES
(1, 'Caja Principal efectivos y divisas', 240.16),
(2, 'Caja Secundaria transferencias y pago movil', 341.04);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cantidad_producto`
--

CREATE TABLE `cantidad_producto` (
  `ID` int(255) NOT NULL,
  `id_producto` int(255) NOT NULL,
  `cantidad` decimal(20,2) NOT NULL,
  `precio` decimal(20,2) NOT NULL,
  `id_unidad_medida` int(255) NOT NULL,
  `peso` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cantidad_producto`
--

INSERT INTO `cantidad_producto` (`ID`, `id_producto`, `cantidad`, `precio`, `id_unidad_medida`, `peso`) VALUES
(60, 24, 2.00, 12.00, 3, 20.00),
(61, 24, 40.00, 0.60, 1, 1.00),
(62, 24, 39999.00, 0.30, 2, 0.50),
(117, 20, 11.00, 43.00, 4, 0.00),
(119, 21, 16.00, 39.00, 4, 0.00),
(122, 22, 47.00, 42.00, 4, 0.00),
(151, 17, 20.00, 7.00, 3, 0.00),
(152, 18, 40.00, 18.00, 3, 0.00),
(153, 19, 24.00, 45.00, 4, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID` int(255) NOT NULL,
  `id_cliente` int(255) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `tlf` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tipo_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID`, `id_cliente`, `nombre_cliente`, `tlf`, `direccion`, `email`, `tipo_id`) VALUES
(20, 32200771, 'david', '04121234567', 'AV La Salle', 'david@gmail.com', 'V-'),
(56, 31039711, 'Moises', '04263213495', 'Barrio', 'moises@gmail.com', 'V-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `ID` int(255) NOT NULL,
  `id_compra` int(255) NOT NULL,
  `id_producto` int(255) NOT NULL,
  `rif_proveedor` int(255) NOT NULL,
  `cantidad_compra` int(255) NOT NULL,
  `monto` decimal(20,2) NOT NULL,
  `fecha` date NOT NULL,
  `pago` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`ID`, `id_compra`, `id_producto`, `rif_proveedor`, `cantidad_compra`, `monto`, `fecha`, `pago`) VALUES
(24, 12, 24, 1234322, 1, 12.00, '2024-11-20', 5),
(25, 1, 24, 1234322, 10, 0.00, '2025-03-06', 5),
(26, 13, 24, 131254678, 1, 500.00, '2025-03-07', 4),
(27, 14, 24, 131254678, 1, 10.00, '2025-03-07', 5),
(28, 2, 24, 131254678, 1, 42.00, '2025-03-27', 3),
(29, 3, 24, 131254678, 1, 6.00, '2025-03-27', 1),
(30, 4, 22, 131254678, 1, 6.00, '2025-03-27', 1),
(31, 5, 22, 131254678, 1, 6.00, '2025-03-27', 1),
(32, 5, 22, 131254678, 1, 6.00, '2025-03-27', 1),
(33, 6, 22, 131254678, 1, 2.00, '2025-03-27', 1),
(34, 6, 22, 131254678, 1, 2.00, '2025-03-27', 1),
(35, 6, 22, 131254678, 1, 2.00, '2025-03-27', 1),
(36, 7, 22, 1234322, 1, 6.00, '2025-03-27', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_por_cobrar`
--

CREATE TABLE `cuenta_por_cobrar` (
  `ID` int(255) NOT NULL,
  `id_cuentaCobrar` int(255) NOT NULL,
  `id_venta` int(255) NOT NULL,
  `fecha_cuentaCobrar` date NOT NULL,
  `monto_cuentaCobrar` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `cuenta_por_cobrar`
--

INSERT INTO `cuenta_por_cobrar` (`ID`, `id_cuentaCobrar`, `id_venta`, `fecha_cuentaCobrar`, `monto_cuentaCobrar`) VALUES
(20, 11, 11, '2025-03-21', 4.94),
(21, 14, 14, '2025-03-12', 4.92),
(22, 16, 16, '2025-03-26', 196.44),
(23, 26, 26, '2025-03-27', 0.35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_por_pagar`
--

CREATE TABLE `cuenta_por_pagar` (
  `ID` int(255) NOT NULL,
  `id_cuentaPagar` int(255) NOT NULL,
  `id_compra` int(255) NOT NULL,
  `fecha_cuentaPagar` date NOT NULL,
  `monto_cuentaPagar` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `cuenta_por_pagar`
--

INSERT INTO `cuenta_por_pagar` (`ID`, `id_cuentaPagar`, `id_compra`, `fecha_cuentaPagar`, `monto_cuentaPagar`) VALUES
(5, 12, 12, '2025-03-07', 10.00),
(6, 1, 1, '2025-03-06', 0.00),
(7, 14, 14, '2025-03-26', 9.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra_proveedor`
--

CREATE TABLE `detalle_compra_proveedor` (
  `ID` int(255) NOT NULL,
  `id_detalleCompraProveedor` int(255) NOT NULL,
  `id_facturaProveedor` int(255) NOT NULL,
  `id_producto` int(255) NOT NULL,
  `cantidad_compra` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `detalle_compra_proveedor`
--

INSERT INTO `detalle_compra_proveedor` (`ID`, `id_detalleCompraProveedor`, `id_facturaProveedor`, `id_producto`, `cantidad_compra`) VALUES
(17, 12, 12, 24, 1),
(18, 1, 1, 24, 10),
(19, 13, 13, 24, 1),
(20, 14, 14, 24, 1),
(21, 2, 2, 24, 1),
(22, 3, 3, 24, 1),
(23, 4, 4, 22, 1),
(24, 5, 5, 22, 1),
(25, 5, 5, 22, 1),
(26, 6, 6, 22, 1),
(27, 6, 6, 22, 1),
(28, 6, 6, 22, 1),
(29, 7, 7, 22, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_producto`
--

CREATE TABLE `detalle_producto` (
  `ID` int(255) NOT NULL,
  `id_detalle_producto` int(255) NOT NULL,
  `id_producto` int(255) NOT NULL,
  `id_venta` int(255) NOT NULL,
  `cantidad_producto` int(255) NOT NULL,
  `id_medida_especifica` int(255) NOT NULL,
  `precio` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `detalle_producto`
--

INSERT INTO `detalle_producto` (`ID`, `id_detalle_producto`, `id_producto`, `id_venta`, `cantidad_producto`, `id_medida_especifica`, `precio`) VALUES
(49, 11, 24, 11, 1, 3, 13.92),
(50, 12, 24, 12, 1, 3, 13.92),
(51, 13, 24, 13, 1, 3, 13.92),
(52, 14, 24, 14, 1, 3, 13.92),
(54, 16, 21, 16, 5, 4, 242.44),
(56, 19, 24, 19, 1, 3, 13.92),
(57, 19, 24, 19, 1, 3, 13.92),
(58, 19, 24, 19, 1, 3, 13.92),
(59, 20, 24, 20, 1, 3, 13.92),
(60, 20, 24, 20, 1, 3, 13.92),
(61, 20, 24, 20, 1, 3, 13.92),
(62, 21, 24, 21, 1, 3, 13.92),
(63, 21, 24, 21, 1, 3, 13.92),
(64, 22, 24, 22, 1, 3, 13.92),
(65, 22, 24, 22, 1, 3, 13.92),
(66, 22, 24, 22, 1, 3, 13.92),
(67, 23, 22, 23, 1, 4, 48.72),
(68, 24, 22, 24, 1, 4, 48.72),
(69, 25, 22, 25, 1, 4, 48.72),
(70, 25, 22, 25, 1, 4, 48.72),
(71, 25, 22, 25, 1, 4, 48.72),
(72, 25, 22, 25, 1, 4, 48.72),
(73, 26, 24, 26, 1, 2, 0.35),
(74, 27, 22, 27, 1, 4, 48.72),
(75, 27, 22, 27, 1, 4, 48.72),
(76, 28, 22, 28, 1, 4, 48.72),
(77, 29, 22, 29, 1, 4, 48.72),
(78, 29, 22, 29, 1, 4, 48.72),
(79, 1, 22, 1, 1, 4, 48.72),
(80, 2, 22, 2, 1, 4, 48.72),
(81, 3, 22, 3, 1, 4, 48.72),
(82, 4, 22, 4, 1, 4, 48.72);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidad_de_pago`
--

CREATE TABLE `modalidad_de_pago` (
  `ID` int(255) NOT NULL,
  `id_modalidad_pago` int(255) NOT NULL,
  `nombre_modalidad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `modalidad_de_pago`
--

INSERT INTO `modalidad_de_pago` (`ID`, `id_modalidad_pago`, `nombre_modalidad`) VALUES
(1, 1, 'divisas'),
(2, 2, 'Efectivo'),
(3, 3, 'Pago Movil'),
(4, 4, 'Transferencia'),
(5, 5, 'Credito'),
(6, 6, 'Descontado'),
(7, 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo_actualizacion`
--

CREATE TABLE `motivo_actualizacion` (
  `ID` int(255) NOT NULL,
  `id_motivoActualizacion` int(255) NOT NULL,
  `nombre_motivo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `motivo_actualizacion`
--

INSERT INTO `motivo_actualizacion` (`ID`, `id_motivoActualizacion`, `nombre_motivo`) VALUES
(0, 0, 'Compra'),
(1, 1, 'Venta'),
(2, 2, 'Caducidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `ID` int(50) NOT NULL,
  `id_cajas` int(50) NOT NULL,
  `tipo_movimiento` varchar(255) NOT NULL,
  `monto_movimiento` decimal(20,2) NOT NULL,
  `concepto` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `id_pago` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`ID`, `id_cajas`, `tipo_movimiento`, `monto_movimiento`, `concepto`, `fecha`, `id_pago`) VALUES
(1, 1, 'Ingreso', 100.00, 'Venta de productos', '2025-03-27', 1),
(2, 2, 'Ingreso', 48.72, 'Venta de productos', '2025-03-27', 3),
(3, 2, 'Ingreso', 0.35, 'Venta de productos', '2025-03-27', 0),
(4, 2, 'Ingreso', 48.72, 'Venta de productos', '2025-03-27', 3),
(5, 2, 'Ingreso', 48.72, 'Venta de productos', '2025-03-27', 3),
(6, 2, 'Ingreso', 48.72, 'Venta de productos', '2025-03-27', 3),
(7, 2, 'Ingreso', 48.72, 'Venta de productos', '2025-03-27', 3),
(8, 2, 'Ingreso', 48.72, 'Venta de productos', '2025-03-27', 3),
(9, 2, 'Ingreso', 48.72, 'Venta de productos', '2025-03-27', 3),
(10, 1, 'Ingreso', 48.72, 'Venta de productos', '2025-03-27', 1),
(11, 1, 'Ingreso', 48.72, 'Venta de productos', '2025-03-27', 1),
(12, 1, 'Ingreso', 48.72, 'Venta de productos', '2025-03-27', 1),
(13, 1, 'Egreso', 2.00, 'Venta de productos', '2025-03-27', 1),
(14, 1, 'Egreso', 2.00, 'Venta de productos', '2025-03-27', 1),
(15, 1, 'Egreso', 6.00, 'Compra de productos de productos', '2025-03-27', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `id_notificacion` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_admin` int(11) NOT NULL,
  `mensaje` varchar(200) NOT NULL,
  `enlace` varchar(100) NOT NULL,
  `estatus` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `notificacion`
--

INSERT INTO `notificacion` (`id_notificacion`, `fecha`, `id_admin`, `mensaje`, `enlace`, `estatus`) VALUES
(1, '2025-04-02 15:47:27', 9, 'El producto  se ha agotado.', 'index.php?action=producto&a=d', 'Sin leer');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `id_presentacion` int(20) NOT NULL,
  `tipo_producto` varchar(255) NOT NULL,
  `presentacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presentacion`
--

INSERT INTO `presentacion` (`id_presentacion`, `tipo_producto`, `presentacion`) VALUES
(1, 'Arroz', 'Mary Perlado Bulto 20 unidades de 1k'),
(6, 'Harina de trigo', 'Mary Saco de 43k'),
(20, 'Refresco', 'Refresco bulto de 6 unidades de 2lt'),
(21, 'Refresco', 'Refresco bulto de 6 unidades de 1lt'),
(22, 'Refresco', 'Refresco bulto de 6 unidades de 250ml'),
(23, 'Azucar', 'Azucar Bulto 20 unidades de 1k'),
(24, 'Azucar', 'Azucar Saco de 50k'),
(25, 'Harina de Trigo', 'Harina de Trigo saco de 45k');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `ID` int(255) NOT NULL,
  `id_producto` int(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_registro` date DEFAULT NULL,
  `fecha_vencimiento` date NOT NULL,
  `id_motivoActualizacion` int(255) NOT NULL,
  `id_inventario` int(255) NOT NULL,
  `id_presentacion` int(255) NOT NULL,
  `enlace` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`ID`, `id_producto`, `nombre`, `fecha_registro`, `fecha_vencimiento`, `id_motivoActualizacion`, `id_inventario`, `id_presentacion`, `enlace`) VALUES
(97, 24, 'Arroz', '2024-11-20', '2024-12-07', 0, 0, 1, ''),
(101, 56, 'avena', '2025-03-05', '2025-04-05', 2, 0, 6, ''),
(120, 20, 'Harina de Trigo Siseca', '2025-04-05', '2025-03-15', 0, 0, 25, 'views/img/productos/Harina de Trigo Siseca.jpg'),
(122, 21, 'Harina de Trigo La Especial', '2025-03-15', '2025-04-05', 0, 0, 25, 'views/img/productos/Harina de Trigo La Especial.jpg'),
(125, 22, 'Azucar La Nieve', '2025-03-15', '2025-04-05', 0, 0, 24, 'views/img/productos/Azucar La Nieve.jpg'),
(141, 98, 'pasta', '2025-03-27', '2025-04-05', 0, 0, 1, 'views/img/productos/prueba.png'),
(142, 17, 'Refresco BigCola 2lt', '2025-03-27', '2025-04-05', 0, 0, 20, 'views/img/productos/Refresco BigCola 2lt.jpg'),
(143, 18, 'Azucar La Pastora 1k', '2025-03-27', '2025-04-05', 0, 0, 23, 'views/img/productos/Azucar La Pastora 1k.jpg'),
(144, 19, 'Azucar Sabana Dulce', '2025-03-27', '2025-04-05', 0, 0, 24, 'views/img/productos/Azucar Sabana Dulce.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `ID` int(255) NOT NULL,
  `id_proveedor` int(255) NOT NULL,
  `nombre_proveedor` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `tlf` varchar(255) NOT NULL,
  `id_representante` int(255) NOT NULL,
  `nombre_representante` varchar(255) NOT NULL,
  `tlf_representante` varchar(255) NOT NULL,
  `tipo_id` varchar(255) NOT NULL,
  `tipo_id2` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`ID`, `id_proveedor`, `nombre_proveedor`, `direccion`, `tlf`, `id_representante`, `nombre_representante`, `tlf_representante`, `tipo_id`, `tipo_id2`) VALUES
(3, 131254678, 'Nestle', 'Zona', '4121234567', 31039711, 'moises', '04123213495', 'J-', 'V-'),
(7, 1234322, 'friz', 'Zona', '412321246', 32200771, 'moises', '04121235676', 'J-', 'V-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_de_medida`
--

CREATE TABLE `unidades_de_medida` (
  `ID` int(255) NOT NULL,
  `id_unidad_medida` int(255) NOT NULL,
  `nombre_medida` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `unidades_de_medida`
--

INSERT INTO `unidades_de_medida` (`ID`, `id_unidad_medida`, `nombre_medida`) VALUES
(1, 1, 'kilogramos'),
(2, 2, 'gramos'),
(3, 3, 'Bulto'),
(4, 4, 'Saco'),
(5, 5, 'Litro'),
(6, 6, 'mililitro'),
(7, 7, 'Galon');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `ID` int(255) NOT NULL,
  `id_venta` int(255) NOT NULL,
  `id_producto` int(255) NOT NULL,
  `id_cliente` int(255) NOT NULL,
  `cantidad` int(255) NOT NULL,
  `fech_emision` date NOT NULL,
  `id_modalidad_pago` int(255) NOT NULL,
  `monto` decimal(20,2) NOT NULL,
  `tipo_entrega` varchar(255) NOT NULL,
  `rif_banco` int(255) DEFAULT NULL,
  `venta` int(11) DEFAULT NULL,
  `tlf` int(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`ID`, `id_venta`, `id_producto`, `id_cliente`, `cantidad`, `fech_emision`, `id_modalidad_pago`, `monto`, `tipo_entrega`, `rif_banco`, `venta`, `tlf`, `is_active`) VALUES
(67, 11, 24, 31039711, 1, '2024-11-20', 1, 13.92, 'Directa', 0, 5, 0, 1),
(68, 12, 24, 31039711, 1, '2025-03-07', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(69, 13, 24, 32200771, 1, '2025-03-07', 4, 13.92, 'Delivery', 104, 6, 2147483647, 1),
(70, 14, 24, 32200771, 1, '2025-03-07', 4, 13.92, 'Delivery', 108, 5, 1234567899, 1),
(71, 15, 17, 31039711, 1, '2025-03-15', 3, 8.12, 'Directa', 102, 6, 2147483647, 1),
(72, 16, 21, 31039711, 5, '2025-03-15', 3, 242.44, 'Delivery', 104, 5, 2147483647, 1),
(73, 16, 17, 31039711, 2, '2025-03-15', 3, 242.44, 'Delivery', 104, 5, 2147483647, 1),
(74, 19, 24, 31039711, 1, '2025-03-27', 1, 13.92, 'Directa', 0, 6, 0, 1),
(75, 19, 24, 31039711, 1, '2025-03-27', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(76, 19, 24, 31039711, 1, '2025-03-27', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(77, 20, 24, 31039711, 1, '2025-03-27', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(78, 20, 24, 31039711, 1, '2025-03-27', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(79, 20, 24, 31039711, 1, '2025-03-27', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(80, 21, 24, 31039711, 1, '2025-03-27', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(81, 21, 24, 31039711, 1, '2025-03-27', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(82, 22, 24, 31039711, 1, '2025-03-27', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(83, 22, 24, 31039711, 1, '2025-03-27', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(84, 22, 24, 31039711, 1, '2025-03-27', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(85, 23, 22, 31039711, 1, '2025-03-27', 0, 48.72, 'Directa', 102, 0, 2147483647, 1),
(86, 24, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(87, 25, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(88, 25, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(89, 25, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(90, 25, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(91, 26, 24, 31039711, 1, '2025-03-27', 0, 0.35, '', 0, 5, 0, 1),
(92, 27, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(93, 27, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(94, 28, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(95, 29, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(96, 29, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(97, 1, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(98, 2, 22, 31039711, 1, '2025-03-27', 1, 48.72, 'Directa', 0, 6, 0, 1),
(99, 3, 22, 31039711, 1, '2025-03-27', 1, 48.72, 'Directa', 0, 6, 0, 1),
(100, 4, 22, 31039711, 1, '2025-03-27', 1, 48.72, 'Directa', 0, 6, 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `bancos`
--
ALTER TABLE `bancos`
  ADD PRIMARY KEY (`ID`,`rif_banco`),
  ADD KEY `rif_banco` (`rif_banco`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `cantidad_producto`
--
ALTER TABLE `cantidad_producto`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_unidad_medida` (`id_unidad_medida`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID`,`id_cliente`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`ID`,`id_compra`),
  ADD KEY `INDEX` (`id_producto`,`rif_proveedor`),
  ADD KEY `id_compra` (`id_compra`),
  ADD KEY `rif_proveedor` (`rif_proveedor`);

--
-- Indices de la tabla `cuenta_por_cobrar`
--
ALTER TABLE `cuenta_por_cobrar`
  ADD PRIMARY KEY (`ID`,`id_cuentaCobrar`),
  ADD KEY `INDEX` (`id_venta`),
  ADD KEY `id_cuentaCobrar` (`id_cuentaCobrar`);

--
-- Indices de la tabla `cuenta_por_pagar`
--
ALTER TABLE `cuenta_por_pagar`
  ADD PRIMARY KEY (`ID`,`id_cuentaPagar`),
  ADD KEY `id_compra` (`id_compra`);

--
-- Indices de la tabla `detalle_compra_proveedor`
--
ALTER TABLE `detalle_compra_proveedor`
  ADD PRIMARY KEY (`ID`,`id_detalleCompraProveedor`),
  ADD KEY `INDEX` (`id_facturaProveedor`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalle_producto`
--
ALTER TABLE `detalle_producto`
  ADD PRIMARY KEY (`ID`,`id_detalle_producto`),
  ADD KEY `INDEX` (`id_producto`,`id_venta`,`id_medida_especifica`),
  ADD KEY `id_detalle_producto` (`id_detalle_producto`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_medida_especifica` (`id_medida_especifica`);

--
-- Indices de la tabla `modalidad_de_pago`
--
ALTER TABLE `modalidad_de_pago`
  ADD PRIMARY KEY (`ID`,`id_modalidad_pago`),
  ADD KEY `id_modalidad_pago` (`id_modalidad_pago`);

--
-- Indices de la tabla `motivo_actualizacion`
--
ALTER TABLE `motivo_actualizacion`
  ADD PRIMARY KEY (`ID`,`id_motivoActualizacion`),
  ADD KEY `id_motivoActualizacion` (`id_motivoActualizacion`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_cajas` (`id_cajas`),
  ADD KEY `id_pago` (`id_pago`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`id_notificacion`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`id_presentacion`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID`,`id_producto`),
  ADD KEY `INDEX` (`id_motivoActualizacion`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_inventario` (`id_inventario`),
  ADD KEY `id_presentacion` (`id_presentacion`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`ID`,`id_proveedor`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `unidades_de_medida`
--
ALTER TABLE `unidades_de_medida`
  ADD PRIMARY KEY (`ID`,`id_unidad_medida`),
  ADD KEY `id_unidad_medida` (`id_unidad_medida`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`ID`,`id_venta`),
  ADD KEY `id_producto` (`id_producto`,`id_cliente`),
  ADD KEY `id_modalidad_pago` (`id_modalidad_pago`),
  ADD KEY `rif_banco` (`rif_banco`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_cliente_2` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `bancos`
--
ALTER TABLE `bancos`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cantidad_producto`
--
ALTER TABLE `cantidad_producto`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `cuenta_por_cobrar`
--
ALTER TABLE `cuenta_por_cobrar`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `cuenta_por_pagar`
--
ALTER TABLE `cuenta_por_pagar`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalle_compra_proveedor`
--
ALTER TABLE `detalle_compra_proveedor`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `detalle_producto`
--
ALTER TABLE `detalle_producto`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `modalidad_de_pago`
--
ALTER TABLE `modalidad_de_pago`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `motivo_actualizacion`
--
ALTER TABLE `motivo_actualizacion`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `id_presentacion` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `unidades_de_medida`
--
ALTER TABLE `unidades_de_medida`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`ID`);

--
-- Filtros para la tabla `cantidad_producto`
--
ALTER TABLE `cantidad_producto`
  ADD CONSTRAINT `cantidad_producto_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cantidad_producto_ibfk_2` FOREIGN KEY (`id_unidad_medida`) REFERENCES `unidades_de_medida` (`id_unidad_medida`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`rif_proveedor`) REFERENCES `proveedor` (`id_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cuenta_por_cobrar`
--
ALTER TABLE `cuenta_por_cobrar`
  ADD CONSTRAINT `cuenta_por_cobrar_ibfk_1` FOREIGN KEY (`id_cuentaCobrar`) REFERENCES `venta` (`id_venta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cuenta_por_pagar`
--
ALTER TABLE `cuenta_por_pagar`
  ADD CONSTRAINT `cuenta_por_pagar_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_compra_proveedor`
--
ALTER TABLE `detalle_compra_proveedor`
  ADD CONSTRAINT `detalle_compra_proveedor_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_compra_proveedor_ibfk_2` FOREIGN KEY (`id_facturaProveedor`) REFERENCES `compra` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_producto`
--
ALTER TABLE `detalle_producto`
  ADD CONSTRAINT `detalle_producto_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id_venta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_producto_ibfk_2` FOREIGN KEY (`id_medida_especifica`) REFERENCES `unidades_de_medida` (`id_unidad_medida`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_producto_ibfk_3` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`id_cajas`) REFERENCES `cajas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`id_pago`) REFERENCES `modalidad_de_pago` (`id_modalidad_pago`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_motivoActualizacion`) REFERENCES `motivo_actualizacion` (`id_motivoActualizacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`id_presentacion`) REFERENCES `presentacion` (`id_presentacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`id_modalidad_pago`) REFERENCES `modalidad_de_pago` (`id_modalidad_pago`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`rif_banco`) REFERENCES `bancos` (`rif_banco`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_ibfk_3` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
