-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-04-2025 a las 23:32:43
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
-- Base de datos: `teobar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesos`
--

CREATE TABLE `accesos` (
  `id_accesos` int(25) NOT NULL,
  `id_rol` int(25) NOT NULL,
  `id_modulo` int(25) NOT NULL,
  `id_permiso` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `accesos`
--

INSERT INTO `accesos` (`id_accesos`, `id_rol`, `id_modulo`, `id_permiso`) VALUES
(1, 1, 1, 1),
(2, 1, 1, 2),
(3, 1, 1, 3),
(4, 1, 1, 4),
(5, 1, 2, 1),
(6, 1, 2, 2),
(7, 1, 2, 3),
(8, 1, 2, 4),
(9, 1, 3, 1),
(10, 1, 3, 2),
(11, 1, 3, 3),
(12, 1, 3, 4),
(13, 1, 4, 1),
(14, 1, 4, 2),
(15, 1, 4, 3),
(16, 1, 4, 4),
(17, 1, 5, 1),
(18, 1, 5, 2),
(19, 1, 5, 3),
(20, 1, 5, 4),
(21, 1, 6, 1),
(22, 1, 6, 2),
(23, 1, 6, 3),
(24, 1, 6, 4),
(25, 1, 7, 1),
(26, 1, 7, 2),
(27, 1, 7, 3),
(28, 1, 7, 4),
(29, 1, 8, 1),
(30, 1, 8, 2),
(31, 1, 8, 3),
(32, 1, 8, 4),
(33, 1, 9, 1),
(34, 1, 9, 2),
(35, 1, 9, 3),
(36, 1, 9, 4),
(37, 1, 10, 1),
(38, 1, 10, 2),
(39, 1, 10, 3),
(40, 1, 10, 4),
(41, 1, 11, 1),
(42, 1, 11, 2),
(43, 1, 11, 3),
(44, 1, 11, 4),
(45, 1, 12, 1),
(46, 1, 12, 2),
(47, 1, 12, 3),
(48, 1, 12, 4),
(49, 1, 13, 1),
(50, 1, 13, 2),
(51, 1, 13, 3),
(52, 1, 13, 4),
(53, 1, 14, 1),
(54, 1, 14, 2),
(55, 1, 14, 3),
(56, 1, 14, 4),
(57, 1, 15, 1),
(58, 1, 15, 2),
(59, 1, 15, 3),
(60, 1, 15, 4),
(61, 1, 16, 1),
(62, 1, 16, 2),
(63, 1, 16, 3),
(64, 1, 16, 4),
(65, 2, 1, 1),
(66, 2, 1, 2),
(67, 2, 1, 3),
(68, 2, 1, 4),
(69, 2, 2, 1),
(70, 2, 2, 2),
(71, 2, 2, 3),
(72, 2, 2, 4),
(73, 2, 3, 1),
(74, 2, 3, 2),
(75, 2, 3, 3),
(76, 2, 3, 4),
(77, 2, 4, 1),
(78, 2, 4, 2),
(79, 2, 4, 3),
(80, 2, 4, 4),
(81, 2, 5, 1),
(82, 2, 5, 2),
(83, 2, 5, 3),
(84, 2, 5, 4),
(85, 2, 6, 1),
(86, 2, 6, 2),
(87, 2, 6, 3),
(88, 2, 6, 4),
(89, 2, 7, 1),
(90, 2, 7, 2),
(91, 2, 7, 3),
(92, 2, 7, 4),
(93, 2, 8, 1),
(94, 2, 8, 2),
(95, 2, 8, 3),
(96, 2, 8, 4),
(97, 2, 9, 1),
(98, 2, 9, 2),
(99, 2, 9, 3),
(100, 2, 9, 4),
(101, 2, 10, 1),
(102, 2, 10, 2),
(103, 2, 10, 3),
(104, 2, 10, 4),
(105, 2, 11, 1),
(106, 2, 11, 2),
(107, 2, 11, 3),
(108, 2, 11, 4),
(109, 2, 12, 1),
(110, 2, 12, 2),
(111, 2, 12, 3),
(112, 2, 12, 4),
(113, 2, 13, 1),
(114, 2, 13, 2),
(115, 2, 13, 3),
(116, 2, 13, 4),
(117, 2, 14, 1),
(118, 2, 14, 2),
(119, 2, 14, 3),
(120, 2, 14, 4),
(121, 2, 15, 1),
(122, 2, 15, 2),
(123, 2, 15, 3),
(124, 2, 15, 4),
(125, 2, 16, 1),
(126, 2, 16, 2),
(127, 2, 16, 3),
(128, 2, 16, 4),
(129, 3, 2, 1),
(130, 3, 2, 2),
(131, 3, 2, 3),
(132, 3, 2, 4),
(133, 4, 6, 1),
(134, 4, 6, 2),
(135, 4, 6, 3),
(136, 4, 6, 4),
(137, 4, 7, 1),
(138, 4, 7, 2),
(139, 4, 7, 3),
(140, 4, 7, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancos`
--

CREATE TABLE `bancos` (
  `rif_banco` int(255) NOT NULL,
  `nombre_banco` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `bancos`
--

INSERT INTO `bancos` (`rif_banco`, `nombre_banco`) VALUES
(0, ''),
(102, 'Venezuela'),
(104, 'Venezolano de Credito'),
(105, 'Mercantil'),
(108, 'Provincial'),
(114, 'Bancaribe'),
(115, 'Exteriror'),
(116, 'Occidental de Descuento'),
(128, 'Banco Caroni'),
(134, 'Banesco'),
(137, 'Banco Sofitasa'),
(138, 'Banco Plaza'),
(151, 'Banco Fondo Comun'),
(156, '100% Banco'),
(157, 'Banco del Sur'),
(163, 'Banco del Tesoro'),
(166, 'Banco Agricola de Venezuela'),
(168, 'Bancrecer'),
(169, 'Mi Banco'),
(172, 'Bancamiga'),
(174, 'Banplus'),
(175, 'Bicentenario del Pueblo'),
(177, 'Banfanb'),
(191, 'Banco Nacional de Credito');

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
(56, '2025-03-27 17:20:26', 'Agregar', 'Producto', 'Producto: Azucar Sabana Dulce', 2),
(57, '2025-04-05 13:35:45', 'Agregar', 'Venta', 'El usuario: @admin_ca ha registrado una venta', 2),
(58, '2025-04-05 13:36:34', 'Abono', 'Cuenta Cobrar', 'El usuario: @admin_ca ha registrado un pago de una cuenta a cobrar pendiente', 2),
(59, '2025-04-05 14:38:16', 'Pagar', 'Cuenta Pagar', 'El usuario: @admin_ca ha registrado un pago a proveedor de una cuanta a pagar pendiente', 2),
(60, '2025-04-05 14:39:02', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(61, '2025-04-11 00:44:42', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(62, '2025-04-11 00:49:40', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(63, '2025-04-11 00:49:59', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(64, '2025-04-11 11:37:48', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(65, '2025-04-11 11:38:13', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(66, '2025-04-11 11:41:18', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(67, '2025-04-11 13:33:35', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(68, '2025-04-11 18:58:45', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(69, '2025-04-14 15:01:27', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(70, '2025-04-14 15:15:16', 'Agregar', 'Producto', 'Producto: pasta larga', 2),
(71, '2025-04-14 15:44:05', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(72, '2025-04-14 21:35:34', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(73, '2025-04-15 09:23:10', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(74, '2025-04-15 10:27:45', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(75, '2025-04-15 10:33:16', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(76, '2025-04-15 10:41:36', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(77, '2025-04-15 10:47:37', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(78, '2025-04-18 19:38:36', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(79, '2025-04-21 10:35:07', 'Iniciar Sesion', 'Usuario', 'El usuario: @vendedor_ca ha iniciado session', 13),
(80, '2025-04-21 10:38:13', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(81, '2025-04-21 10:39:09', 'Agregar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(82, '2025-04-21 10:39:56', 'Modificar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(83, '2025-04-21 10:40:06', 'Eliminar', 'Cliente', 'Cliente con la cedula:  17100998', 2),
(84, '2025-04-21 10:55:55', 'Agregar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(85, '2025-04-21 10:56:08', 'Eliminar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(86, '2025-04-21 12:26:38', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(87, '2025-04-21 12:27:09', 'Agregar', 'Cliente', 'Cliente con la cedula: V- 31039711', 2),
(88, '2025-04-21 12:30:10', 'Agregar', 'Cliente', 'Cliente con la cedula: V- 31039711', 2),
(89, '2025-04-21 12:32:09', 'Agregar', 'Cliente', 'Cliente con la cedula: V- 31039711', 2),
(90, '2025-04-21 13:07:05', 'Agregar', 'Cliente', 'Cliente con la cedula: V- 31039711', 2),
(91, '2025-04-21 13:15:45', 'Agregar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(92, '2025-04-21 13:34:19', 'Agregar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(93, '2025-04-21 15:45:17', 'Eliminar', 'Cliente', 'Cliente con la cedula: 0 17100998', 2),
(94, '2025-04-21 16:21:39', 'Eliminar', 'Cliente', 'Cliente con la cedula: 0 17100998', 2),
(95, '2025-04-21 16:24:58', 'Eliminar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(96, '2025-04-21 16:30:43', 'Eliminar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(97, '2025-04-21 16:30:55', 'Agregar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(98, '2025-04-21 17:17:02', 'Modificar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(99, '2025-04-21 17:18:31', 'Modificar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(100, '2025-04-21 17:18:51', 'Modificar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(101, '2025-04-21 17:20:53', 'Modificar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(102, '2025-04-21 17:25:19', 'Eliminar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(103, '2025-04-21 17:26:44', 'Agregar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(104, '2025-04-21 17:26:51', 'Eliminar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(105, '2025-04-21 17:41:10', 'Agregar', 'Cliente', 'Cliente con la cedula: V- 17100', 2),
(106, '2025-04-21 17:41:22', 'Eliminar', 'Cliente', 'Cliente con la cedula: V- 17100', 2),
(107, '2025-04-21 17:44:16', 'Agregar', 'Cliente', 'Cliente con la cedula: V- 12323', 2),
(108, '2025-04-21 17:44:30', 'Eliminar', 'Cliente', 'Cliente con la cedula: V- 12323', 2),
(109, '2025-04-21 17:56:18', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(110, '2025-04-21 18:06:21', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(111, '2025-04-21 18:11:35', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(112, '2025-04-21 18:38:57', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(113, '2025-04-21 20:02:41', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(114, '2025-04-21 20:09:57', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(115, '2025-04-21 20:12:52', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(116, '2025-04-21 20:14:06', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(117, '2025-04-21 20:15:04', 'Agregar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(118, '2025-04-21 20:15:29', 'Modificar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(119, '2025-04-21 20:15:46', 'Eliminar', 'Cliente', 'Cliente con la cedula: V- 17100998', 2),
(120, '2025-04-22 15:17:12', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(121, '2025-04-22 16:05:25', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(122, '2025-04-22 16:24:03', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(123, '2025-04-22 16:29:15', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(124, '2025-04-22 16:39:24', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 17100998', 2),
(125, '2025-04-22 16:39:35', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 17100998', 2),
(126, '2025-04-22 16:39:50', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(127, '2025-04-22 16:40:14', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 17100998', 9),
(128, '2025-04-22 16:40:49', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 17100998', 9),
(129, '2025-04-22 16:51:23', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(130, '2025-04-22 16:51:37', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 17100998', 2),
(131, '2025-04-22 16:51:54', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 17100998', 2),
(132, '2025-04-22 16:52:20', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(133, '2025-04-22 16:54:09', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(134, '2025-04-22 16:55:02', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 17100998', 2),
(135, '2025-04-22 16:55:09', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 17100998', 2),
(136, '2025-04-22 17:01:00', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(137, '2025-04-22 17:11:33', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(138, '2025-04-22 17:12:15', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 17100998', 2),
(139, '2025-04-22 17:12:30', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(140, '2025-04-22 17:15:20', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 2),
(141, '2025-04-22 17:19:04', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 17100998', 2),
(142, '2025-04-22 17:29:45', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9);

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
(2, 'Caja Secundaria transferencias y pago movil', 354.96);

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
(60, 24, 1.00, 12.00, 3, 20.00),
(61, 24, 40.00, 0.60, 1, 1.00),
(62, 24, 39999.00, 0.30, 2, 0.50),
(117, 20, 11.00, 43.00, 4, 0.00),
(119, 21, 16.00, 39.00, 4, 0.00),
(122, 22, 47.00, 42.00, 4, 0.00),
(151, 17, 20.00, 7.00, 3, 0.00),
(152, 18, 40.00, 18.00, 3, 0.00),
(153, 19, 24.00, 45.00, 4, 0.00),
(154, 66, 22.00, 23.00, 3, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
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

INSERT INTO `cliente` (`id_cliente`, `nombre_cliente`, `tlf`, `direccion`, `email`, `tipo_id`) VALUES
(31039711, 'Moises', '04263213495', 'Barrio', 'moises@gmail.com', 'V-'),
(32200771, 'david', '04121234567', 'AV La Salle', 'david@gmail.com', 'V-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
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

INSERT INTO `compra` (`id_compra`, `id_producto`, `rif_proveedor`, `cantidad_compra`, `monto`, `fecha`, `pago`) VALUES
(1, 24, 1234322, 10, 0.00, '2025-03-06', 5),
(2, 24, 131254678, 1, 42.00, '2025-03-27', 3),
(3, 24, 131254678, 1, 6.00, '2025-03-27', 1),
(4, 22, 131254678, 1, 6.00, '2025-03-27', 1),
(5, 22, 131254678, 1, 6.00, '2025-03-27', 1),
(6, 22, 131254678, 1, 2.00, '2025-03-27', 1),
(7, 22, 1234322, 1, 6.00, '2025-03-27', 1),
(12, 24, 1234322, 1, 12.00, '2024-11-20', 5),
(13, 24, 131254678, 1, 500.00, '2025-03-07', 4),
(14, 24, 131254678, 1, 10.00, '2025-03-07', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_por_cobrar`
--

CREATE TABLE `cuenta_por_cobrar` (
  `id_cuentaCobrar` int(255) NOT NULL,
  `id_venta` int(255) NOT NULL,
  `id_pago` int(11) DEFAULT NULL,
  `fecha_cuentaCobrar` date NOT NULL,
  `monto_cuentaCobrar` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `cuenta_por_cobrar`
--

INSERT INTO `cuenta_por_cobrar` (`id_cuentaCobrar`, `id_venta`, `id_pago`, `fecha_cuentaCobrar`, `monto_cuentaCobrar`) VALUES
(11, 11, NULL, '2025-03-21', 4.94),
(14, 14, NULL, '2025-03-12', 4.92),
(26, 26, NULL, '2025-03-27', 0.35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_por_pagar`
--

CREATE TABLE `cuenta_por_pagar` (
  `id_cuentaPagar` int(255) NOT NULL,
  `id_compra` int(255) NOT NULL,
  `id_pago` int(11) DEFAULT NULL,
  `fecha_cuentaPagar` date NOT NULL,
  `monto_cuentaPagar` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `cuenta_por_pagar`
--

INSERT INTO `cuenta_por_pagar` (`id_cuentaPagar`, `id_compra`, `id_pago`, `fecha_cuentaPagar`, `monto_cuentaPagar`) VALUES
(1, 1, NULL, '2025-03-06', 0.00),
(12, 12, 1, '2025-04-05', 9.00),
(14, 14, NULL, '2025-03-26', 9.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra_proveedor`
--

CREATE TABLE `detalle_compra_proveedor` (
  `id_detalleCompraProveedor` int(255) NOT NULL,
  `id_facturaProveedor` int(255) NOT NULL,
  `id_producto` int(255) NOT NULL,
  `cantidad_compra` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `detalle_compra_proveedor`
--

INSERT INTO `detalle_compra_proveedor` (`id_detalleCompraProveedor`, `id_facturaProveedor`, `id_producto`, `cantidad_compra`) VALUES
(1, 1, 24, 10),
(2, 2, 24, 1),
(3, 3, 24, 1),
(4, 4, 22, 1),
(7, 7, 22, 1),
(12, 12, 24, 1),
(13, 13, 24, 1),
(14, 14, 24, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_producto`
--

CREATE TABLE `detalle_producto` (
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

INSERT INTO `detalle_producto` (`id_detalle_producto`, `id_producto`, `id_venta`, `cantidad_producto`, `id_medida_especifica`, `precio`) VALUES
(1, 22, 1, 1, 4, 48.72),
(2, 22, 2, 1, 4, 48.72),
(3, 22, 3, 1, 4, 48.72),
(4, 22, 4, 1, 4, 48.72),
(11, 24, 11, 1, 3, 13.92),
(12, 24, 12, 1, 3, 13.92),
(13, 24, 13, 1, 3, 13.92),
(14, 24, 14, 1, 3, 13.92),
(23, 22, 23, 1, 4, 48.72),
(24, 22, 24, 1, 4, 48.72),
(26, 24, 26, 1, 2, 0.35),
(28, 22, 28, 1, 4, 48.72),
(30, 24, 30, 1, 3, 13.92);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos`
--

CREATE TABLE `egresos` (
  `ID` int(25) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `id_movimiento` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `ID` int(25) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `id_movimiento` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidad_de_pago`
--

CREATE TABLE `modalidad_de_pago` (
  `id_modalidad_pago` int(255) NOT NULL,
  `nombre_modalidad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `modalidad_de_pago`
--

INSERT INTO `modalidad_de_pago` (`id_modalidad_pago`, `nombre_modalidad`) VALUES
(0, ''),
(1, 'divisas'),
(2, 'Efectivo'),
(3, 'Pago Movil'),
(4, 'Transferencia'),
(5, 'Credito'),
(6, 'Descontado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id_modulo` int(25) NOT NULL,
  `nombre_modulo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `nombre_modulo`) VALUES
(1, 'Usuarios'),
(2, 'Productos'),
(3, 'Tipos'),
(4, 'Clientes'),
(5, 'Proveedores'),
(6, 'Ventas'),
(7, 'Compras'),
(8, 'Compras'),
(9, 'Cobrar'),
(10, 'Pagar'),
(11, 'Bitacora'),
(12, 'Ingresos'),
(13, 'Egresos'),
(14, 'Caja'),
(15, 'Reportes'),
(16, 'Ntificaciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo_actualizacion`
--

CREATE TABLE `motivo_actualizacion` (
  `id_motivoActualizacion` int(255) NOT NULL,
  `nombre_motivo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `motivo_actualizacion`
--

INSERT INTO `motivo_actualizacion` (`id_motivoActualizacion`, `nombre_motivo`) VALUES
(0, 'Compra'),
(1, 'Venta'),
(2, 'Caducidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_caja`
--

CREATE TABLE `movimientos_caja` (
  `ID` int(50) NOT NULL,
  `id_cajas` int(50) NOT NULL,
  `tipo_movimiento` varchar(255) NOT NULL,
  `monto_movimiento` decimal(20,2) NOT NULL,
  `concepto` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `id_pago` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos_caja`
--

INSERT INTO `movimientos_caja` (`ID`, `id_cajas`, `tipo_movimiento`, `monto_movimiento`, `concepto`, `fecha`, `id_pago`) VALUES
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
(15, 1, 'Egreso', 6.00, 'Compra de productos de productos', '2025-03-27', 1),
(16, 2, 'Ingreso', 13.92, 'Venta de productos', '2025-04-05', 3),
(17, 2, 'Ingreso', 14.62, 'Venta de productos', '2025-04-07', 3);

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
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(25) NOT NULL,
  `nombre_permiso` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `nombre_permiso`) VALUES
(1, 'agregar'),
(2, 'Consultar'),
(3, 'Modificar'),
(4, 'Eliminar');

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
  `id_producto` int(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `marca` varchar(50) NOT NULL,
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

INSERT INTO `producto` (`id_producto`, `nombre`, `marca`, `fecha_registro`, `fecha_vencimiento`, `id_motivoActualizacion`, `id_inventario`, `id_presentacion`, `enlace`) VALUES
(17, 'Refresco BigCola 2lt', '', '2025-03-27', '2025-04-05', 0, 0, 20, 'views/img/productos/Refresco BigCola 2lt.jpg'),
(18, 'Azucar La Pastora 1k', '', '2025-03-27', '2025-04-05', 0, 0, 23, 'views/img/productos/Azucar La Pastora 1k.jpg'),
(19, 'Azucar Sabana Dulce', '', '2025-03-27', '2025-04-05', 0, 0, 24, 'views/img/productos/Azucar Sabana Dulce.jpg'),
(20, 'Harina de Trigo Siseca', '', '2025-04-05', '2025-03-15', 0, 0, 25, 'views/img/productos/Harina de Trigo Siseca.jpg'),
(21, 'Harina de Trigo La Especial', '', '2025-03-15', '2025-04-05', 0, 0, 25, 'views/img/productos/Harina de Trigo La Especial.jpg'),
(22, 'Azucar La Nieve', '', '2025-03-15', '2025-04-05', 0, 0, 24, 'views/img/productos/Azucar La Nieve.jpg'),
(24, 'Arroz', '', '2024-11-20', '2024-12-07', 1, 0, 1, ''),
(56, 'avena', '', '2025-03-05', '2025-04-05', 2, 0, 6, ''),
(66, 'pasta larga', 'waker', '2025-04-14', '2025-05-10', 0, 0, 1, 'views/img/productos/logaritmo.png'),
(98, 'pasta', '', '2025-03-27', '2025-04-05', 0, 0, 1, 'views/img/productos/prueba.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
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

INSERT INTO `proveedor` (`id_proveedor`, `nombre_proveedor`, `direccion`, `tlf`, `id_representante`, `nombre_representante`, `tlf_representante`, `tipo_id`, `tipo_id2`) VALUES
(1234322, 'friz', 'Zona', '412321246', 32200771, 'moises', '04121235676', 'J-', 'V-'),
(131254678, 'Nestle', 'Zona', '4121234567', 31039711, 'moises', '04123213495', 'J-', 'V-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(25) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Superusuario'),
(2, 'Administrador'),
(3, 'Usuario'),
(4, 'Vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_de_medida`
--

CREATE TABLE `unidades_de_medida` (
  `id_unidad_medida` int(255) NOT NULL,
  `nombre_medida` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `unidades_de_medida`
--

INSERT INTO `unidades_de_medida` (`id_unidad_medida`, `nombre_medida`) VALUES
(1, 'kilogramos'),
(2, 'gramos'),
(3, 'Bulto'),
(4, 'Saco'),
(5, 'Litro'),
(6, 'mililitro'),
(7, 'Galon');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `id_rol` int(25) NOT NULL,
  `pw` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `usuario`, `id_rol`, `pw`) VALUES
(2, '@admin_ca', 2, '$2y$10$wyceSs4IUq08hnu2VYm/rOHcIepYuU2SdoslpClA7GN5V5nAZV126'),
(9, '@user_ca', 3, '$2y$10$KeSPukQrDVa8qGep.ZAXN.SNcqDHbBI573cq9XNuv12zSatxGJ0HO'),
(13, '@vendedor_ca', 4, '$2y$10$r2IqiyXhlP5QzceGgwCbL.Nu0YnPw0WmJRJj4UTkWonTf7mmmQ5gO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
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

INSERT INTO `venta` (`id_venta`, `id_producto`, `id_cliente`, `cantidad`, `fech_emision`, `id_modalidad_pago`, `monto`, `tipo_entrega`, `rif_banco`, `venta`, `tlf`, `is_active`) VALUES
(1, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(2, 22, 31039711, 1, '2025-03-27', 1, 48.72, 'Directa', 0, 6, 0, 1),
(3, 22, 31039711, 1, '2025-03-27', 1, 48.72, 'Directa', 0, 6, 0, 1),
(4, 22, 31039711, 1, '2025-03-27', 1, 48.72, 'Directa', 0, 6, 0, 1),
(11, 24, 31039711, 1, '2024-11-20', 1, 13.92, 'Directa', 0, 5, 0, 1),
(12, 24, 31039711, 1, '2025-03-07', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(13, 24, 32200771, 1, '2025-03-07', 4, 13.92, 'Delivery', 104, 6, 2147483647, 1),
(14, 24, 32200771, 1, '2025-03-07', 4, 13.92, 'Delivery', 108, 5, 1234567899, 1),
(15, 17, 31039711, 1, '2025-03-15', 3, 8.12, 'Directa', 102, 6, 2147483647, 1),
(16, 21, 31039711, 5, '2025-03-15', 3, 242.44, 'Delivery', 104, 5, 2147483647, 1),
(19, 24, 31039711, 1, '2025-03-27', 1, 13.92, 'Directa', 0, 6, 0, 1),
(20, 24, 31039711, 1, '2025-03-27', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(21, 24, 31039711, 1, '2025-03-27', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(22, 24, 31039711, 1, '2025-03-27', 3, 13.92, 'Directa', 102, 6, 2147483647, 1),
(23, 22, 31039711, 1, '2025-03-27', 0, 48.72, 'Directa', 102, 0, 2147483647, 1),
(24, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(25, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(26, 24, 31039711, 1, '2025-03-27', 0, 0.35, '', 0, 5, 0, 1),
(27, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(28, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(29, 22, 31039711, 1, '2025-03-27', 3, 48.72, 'Directa', 102, 6, 2147483647, 1),
(30, 24, 31039711, 1, '2025-04-05', 3, 13.92, 'Directa', 102, 6, 2147483647, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD PRIMARY KEY (`id_accesos`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_modulo` (`id_modulo`),
  ADD KEY `id_permiso` (`id_permiso`);

--
-- Indices de la tabla `bancos`
--
ALTER TABLE `bancos`
  ADD PRIMARY KEY (`rif_banco`) USING BTREE;

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
  ADD PRIMARY KEY (`id_cliente`) USING BTREE;

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`) USING BTREE,
  ADD KEY `INDEX` (`id_producto`,`rif_proveedor`),
  ADD KEY `rif_proveedor` (`rif_proveedor`);

--
-- Indices de la tabla `cuenta_por_cobrar`
--
ALTER TABLE `cuenta_por_cobrar`
  ADD PRIMARY KEY (`id_cuentaCobrar`) USING BTREE,
  ADD KEY `INDEX` (`id_venta`);

--
-- Indices de la tabla `cuenta_por_pagar`
--
ALTER TABLE `cuenta_por_pagar`
  ADD PRIMARY KEY (`id_cuentaPagar`),
  ADD KEY `id_compra` (`id_compra`);

--
-- Indices de la tabla `detalle_compra_proveedor`
--
ALTER TABLE `detalle_compra_proveedor`
  ADD PRIMARY KEY (`id_detalleCompraProveedor`) USING BTREE,
  ADD KEY `INDEX` (`id_facturaProveedor`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalle_producto`
--
ALTER TABLE `detalle_producto`
  ADD PRIMARY KEY (`id_detalle_producto`) USING BTREE,
  ADD KEY `INDEX` (`id_producto`,`id_venta`,`id_medida_especifica`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_medida_especifica` (`id_medida_especifica`);

--
-- Indices de la tabla `egresos`
--
ALTER TABLE `egresos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_movimiento` (`id_movimiento`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_movimiento` (`id_movimiento`);

--
-- Indices de la tabla `modalidad_de_pago`
--
ALTER TABLE `modalidad_de_pago`
  ADD PRIMARY KEY (`id_modalidad_pago`) USING BTREE;

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `motivo_actualizacion`
--
ALTER TABLE `motivo_actualizacion`
  ADD PRIMARY KEY (`id_motivoActualizacion`) USING BTREE;

--
-- Indices de la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_cajas` (`id_cajas`),
  ADD KEY `id_pago` (`id_pago`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`id_presentacion`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`) USING BTREE,
  ADD KEY `INDEX` (`id_motivoActualizacion`),
  ADD KEY `id_inventario` (`id_inventario`),
  ADD KEY `id_presentacion` (`id_presentacion`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`) USING BTREE;

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `unidades_de_medida`
--
ALTER TABLE `unidades_de_medida`
  ADD PRIMARY KEY (`id_unidad_medida`) USING BTREE;

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id_venta`) USING BTREE,
  ADD KEY `id_producto` (`id_producto`,`id_cliente`),
  ADD KEY `id_modalidad_pago` (`id_modalidad_pago`),
  ADD KEY `rif_banco` (`rif_banco`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_cliente_2` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesos`
--
ALTER TABLE `accesos`
  MODIFY `id_accesos` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cantidad_producto`
--
ALTER TABLE `cantidad_producto`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT de la tabla `egresos`
--
ALTER TABLE `egresos`
  MODIFY `ID` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `ID` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD CONSTRAINT `accesos_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accesos_ibfk_2` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accesos_ibfk_3` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`rif_proveedor`) REFERENCES `proveedor` (`id_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cuenta_por_cobrar`
--
ALTER TABLE `cuenta_por_cobrar`
  ADD CONSTRAINT `cuenta_por_cobrar_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id_venta`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `detalle_producto_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `egresos`
--
ALTER TABLE `egresos`
  ADD CONSTRAINT `egresos_ibfk_1` FOREIGN KEY (`id_movimiento`) REFERENCES `movimientos_caja` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD CONSTRAINT `ingresos_ibfk_1` FOREIGN KEY (`id_movimiento`) REFERENCES `movimientos_caja` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  ADD CONSTRAINT `movimientos_caja_ibfk_1` FOREIGN KEY (`id_pago`) REFERENCES `modalidad_de_pago` (`id_modalidad_pago`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movimientos_caja_ibfk_2` FOREIGN KEY (`id_cajas`) REFERENCES `cajas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD CONSTRAINT `notificacion_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_presentacion`) REFERENCES `presentacion` (`id_presentacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`id_motivoActualizacion`) REFERENCES `motivo_actualizacion` (`id_motivoActualizacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`id_modalidad_pago`) REFERENCES `modalidad_de_pago` (`id_modalidad_pago`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_ibfk_3` FOREIGN KEY (`rif_banco`) REFERENCES `bancos` (`rif_banco`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
