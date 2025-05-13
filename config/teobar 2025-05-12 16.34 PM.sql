-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 12-05-2025 a las 22:33:43
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

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
  `id_permiso` int(25) NOT NULL,
  `estatus` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `accesos`
--

INSERT INTO `accesos` (`id_accesos`, `id_rol`, `id_modulo`, `id_permiso`, `estatus`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 1, 2, 1),
(3, 1, 1, 3, 1),
(4, 1, 1, 4, 1),
(5, 1, 2, 1, 1),
(6, 1, 2, 2, 1),
(7, 1, 2, 3, 1),
(8, 1, 2, 4, 1),
(9, 1, 3, 1, 1),
(10, 1, 3, 2, 1),
(11, 1, 3, 3, 1),
(12, 1, 3, 4, 1),
(13, 1, 4, 1, 1),
(14, 1, 4, 2, 1),
(15, 1, 4, 3, 1),
(16, 1, 4, 4, 1),
(17, 1, 5, 1, 1),
(18, 1, 5, 2, 1),
(19, 1, 5, 3, 1),
(20, 1, 5, 4, 1),
(21, 1, 6, 1, 1),
(22, 1, 6, 2, 1),
(23, 1, 6, 3, 1),
(24, 1, 6, 4, 1),
(25, 1, 7, 1, 1),
(26, 1, 7, 2, 1),
(27, 1, 7, 3, 1),
(28, 1, 7, 4, 1),
(29, 1, 8, 1, 1),
(30, 1, 8, 2, 1),
(31, 1, 8, 3, 1),
(32, 1, 8, 4, 1),
(33, 1, 9, 1, 1),
(34, 1, 9, 2, 1),
(35, 1, 9, 3, 1),
(36, 1, 9, 4, 1),
(37, 1, 10, 1, 1),
(38, 1, 10, 2, 1),
(39, 1, 10, 3, 1),
(40, 1, 10, 4, 1),
(41, 1, 11, 1, 1),
(42, 1, 11, 2, 1),
(43, 1, 11, 3, 1),
(44, 1, 11, 4, 1),
(45, 1, 12, 1, 1),
(46, 1, 12, 2, 1),
(47, 1, 12, 3, 1),
(48, 1, 12, 4, 1),
(49, 1, 13, 1, 1),
(50, 1, 13, 2, 1),
(51, 1, 13, 3, 1),
(52, 1, 13, 4, 1),
(53, 1, 14, 1, 1),
(54, 1, 14, 2, 1),
(55, 1, 14, 3, 1),
(56, 1, 14, 4, 1),
(57, 1, 15, 1, 1),
(58, 1, 15, 2, 1),
(59, 1, 15, 3, 1),
(60, 1, 15, 4, 1),
(61, 1, 16, 1, 1),
(62, 1, 16, 2, 1),
(63, 1, 16, 3, 1),
(64, 1, 16, 4, 1),
(65, 2, 1, 1, 1),
(66, 2, 1, 2, 1),
(67, 2, 1, 3, 1),
(68, 2, 1, 4, 1),
(69, 2, 2, 1, 1),
(70, 2, 2, 2, 1),
(71, 2, 2, 3, 1),
(72, 2, 2, 4, 1),
(73, 2, 3, 1, 1),
(74, 2, 3, 2, 1),
(75, 2, 3, 3, 1),
(76, 2, 3, 4, 1),
(77, 2, 4, 1, 1),
(78, 2, 4, 2, 1),
(79, 2, 4, 3, 1),
(80, 2, 4, 4, 1),
(81, 2, 5, 1, 1),
(82, 2, 5, 2, 1),
(83, 2, 5, 3, 1),
(84, 2, 5, 4, 1),
(85, 2, 6, 1, 0),
(86, 2, 6, 2, 0),
(87, 2, 6, 3, 0),
(88, 2, 6, 4, 0),
(89, 2, 7, 1, 0),
(90, 2, 7, 2, 0),
(91, 2, 7, 3, 0),
(92, 2, 7, 4, 0),
(93, 2, 8, 1, 0),
(94, 2, 8, 2, 0),
(95, 2, 8, 3, 0),
(96, 2, 8, 4, 0),
(97, 2, 9, 1, 0),
(98, 2, 9, 2, 0),
(99, 2, 9, 3, 0),
(100, 2, 9, 4, 0),
(101, 2, 10, 1, 0),
(102, 2, 10, 2, 0),
(103, 2, 10, 3, 0),
(104, 2, 10, 4, 0),
(105, 2, 11, 1, 0),
(106, 2, 11, 2, 0),
(107, 2, 11, 3, 0),
(108, 2, 11, 4, 0),
(109, 2, 12, 1, 0),
(110, 2, 12, 2, 0),
(111, 2, 12, 3, 0),
(112, 2, 12, 4, 0),
(113, 2, 13, 1, 0),
(114, 2, 13, 2, 0),
(115, 2, 13, 3, 0),
(116, 2, 13, 4, 0),
(117, 2, 14, 1, 0),
(118, 2, 14, 2, 0),
(119, 2, 14, 3, 0),
(120, 2, 14, 4, 0),
(121, 2, 15, 1, 0),
(122, 2, 15, 2, 0),
(123, 2, 15, 3, 0),
(124, 2, 15, 4, 0),
(125, 2, 16, 1, 0),
(126, 2, 16, 2, 0),
(127, 2, 16, 3, 0),
(128, 2, 16, 4, 0),
(129, 3, 1, 1, 0),
(130, 3, 1, 2, 0),
(131, 3, 1, 3, 0),
(132, 3, 1, 4, 0),
(133, 3, 2, 1, 0),
(134, 3, 2, 2, 0),
(135, 3, 2, 3, 0),
(136, 3, 2, 4, 0),
(137, 3, 3, 1, 0),
(138, 3, 3, 2, 0),
(139, 3, 3, 3, 0),
(140, 3, 3, 4, 0),
(141, 3, 4, 1, 1),
(142, 3, 4, 2, 1),
(143, 3, 4, 3, 1),
(144, 3, 4, 4, 1),
(145, 3, 5, 1, 1),
(146, 3, 5, 2, 1),
(147, 3, 5, 3, 1),
(148, 3, 5, 4, 1),
(149, 3, 6, 1, 1),
(150, 3, 6, 2, 1),
(151, 3, 6, 3, 1),
(152, 3, 6, 4, 1),
(153, 3, 7, 1, 1),
(154, 3, 7, 2, 1),
(155, 3, 7, 3, 1),
(156, 3, 7, 4, 1),
(157, 3, 8, 1, 1),
(158, 3, 8, 2, 1),
(159, 3, 8, 3, 1),
(160, 3, 8, 4, 1),
(161, 3, 9, 1, 1),
(162, 3, 9, 2, 1),
(163, 3, 9, 3, 1),
(164, 3, 9, 4, 1),
(165, 3, 10, 1, 1),
(166, 3, 10, 2, 1),
(167, 3, 10, 3, 1),
(168, 3, 10, 4, 1),
(169, 3, 11, 1, 1),
(170, 3, 11, 2, 1),
(171, 3, 11, 3, 1),
(172, 3, 11, 4, 1),
(173, 3, 12, 1, 1),
(174, 3, 12, 2, 1),
(175, 3, 12, 3, 1),
(176, 3, 12, 4, 1),
(177, 3, 13, 1, 1),
(178, 3, 13, 2, 1),
(179, 3, 13, 3, 1),
(180, 3, 13, 4, 1),
(181, 3, 14, 1, 1),
(182, 3, 14, 2, 1),
(183, 3, 14, 3, 1),
(184, 3, 14, 4, 1),
(185, 3, 15, 1, 1),
(186, 3, 15, 2, 1),
(187, 3, 15, 3, 1),
(188, 3, 15, 4, 1),
(189, 3, 16, 1, 1),
(190, 3, 16, 2, 1),
(191, 3, 16, 3, 1),
(192, 3, 16, 4, 1),
(193, 4, 1, 1, 1),
(194, 4, 1, 2, 1),
(195, 4, 1, 3, 1),
(196, 4, 1, 4, 1),
(197, 4, 2, 1, 1),
(198, 4, 2, 2, 1),
(199, 4, 2, 3, 1),
(200, 4, 2, 4, 1),
(201, 4, 3, 1, 1),
(202, 4, 3, 2, 1),
(203, 4, 3, 3, 1),
(204, 4, 3, 4, 1),
(205, 4, 4, 1, 1),
(206, 4, 4, 2, 1),
(207, 4, 4, 3, 1),
(208, 4, 4, 4, 1),
(209, 4, 5, 1, 1),
(210, 4, 5, 2, 1),
(211, 4, 5, 3, 1),
(212, 4, 5, 4, 1),
(213, 4, 6, 1, 1),
(214, 4, 6, 2, 1),
(215, 4, 6, 3, 1),
(216, 4, 6, 4, 1),
(217, 4, 7, 1, 1),
(218, 4, 7, 2, 1),
(219, 4, 7, 3, 1),
(220, 4, 7, 4, 1),
(221, 4, 8, 1, 1),
(222, 4, 8, 2, 1),
(223, 4, 8, 3, 1),
(224, 4, 8, 4, 1),
(225, 4, 9, 1, 1),
(226, 4, 9, 2, 1),
(227, 4, 9, 3, 1),
(228, 4, 9, 4, 1),
(229, 4, 10, 1, 1),
(230, 4, 10, 2, 1),
(231, 4, 10, 3, 1),
(232, 4, 10, 4, 1),
(233, 4, 11, 1, 1),
(234, 4, 11, 2, 1),
(235, 4, 11, 3, 1),
(236, 4, 11, 4, 1),
(237, 4, 12, 1, 1),
(238, 4, 12, 2, 1),
(239, 4, 12, 3, 1),
(240, 4, 12, 4, 1),
(241, 4, 13, 1, 1),
(242, 4, 13, 2, 1),
(243, 4, 13, 3, 1),
(244, 4, 13, 4, 1),
(245, 4, 14, 1, 1),
(246, 4, 14, 2, 1),
(247, 4, 14, 3, 1),
(248, 4, 14, 4, 1),
(249, 4, 15, 1, 1),
(250, 4, 15, 2, 1),
(251, 4, 15, 3, 1),
(252, 4, 15, 4, 1),
(253, 4, 16, 1, 1),
(254, 4, 16, 2, 1),
(255, 4, 16, 3, 1),
(256, 4, 16, 4, 1),
(257, 5, 4, 1, 1),
(258, 5, 4, 2, 1),
(259, 5, 4, 3, 1),
(260, 5, 4, 4, 1),
(261, 5, 5, 1, 1),
(262, 5, 5, 2, 1),
(263, 5, 5, 3, 1),
(264, 5, 5, 4, 1),
(265, 5, 6, 1, 1),
(266, 5, 6, 2, 1),
(267, 5, 6, 3, 1),
(268, 5, 6, 4, 1),
(269, 5, 7, 1, 1),
(270, 5, 7, 2, 1),
(271, 5, 7, 3, 1),
(272, 5, 7, 4, 1),
(273, 5, 8, 1, 1),
(274, 5, 8, 2, 1),
(275, 5, 8, 3, 1),
(276, 5, 8, 4, 1),
(277, 5, 9, 1, 1),
(278, 5, 9, 2, 1),
(279, 5, 9, 3, 1),
(280, 5, 9, 4, 1),
(281, 5, 10, 1, 1),
(282, 5, 10, 2, 1),
(283, 5, 10, 3, 1),
(284, 5, 10, 4, 1),
(285, 5, 11, 1, 1),
(286, 5, 11, 2, 1),
(287, 5, 11, 3, 1),
(288, 5, 11, 4, 1),
(289, 5, 12, 1, 1),
(290, 5, 12, 2, 1),
(291, 5, 12, 3, 1),
(292, 5, 12, 4, 1),
(293, 5, 13, 1, 1),
(294, 5, 13, 2, 1),
(295, 5, 13, 3, 1),
(296, 5, 13, 4, 1),
(297, 5, 14, 1, 1),
(298, 5, 14, 2, 1),
(299, 5, 14, 3, 1),
(300, 5, 14, 4, 1),
(301, 5, 15, 1, 1),
(302, 5, 15, 2, 1),
(303, 5, 15, 3, 1),
(304, 5, 15, 4, 1),
(305, 5, 16, 1, 1),
(306, 5, 16, 2, 1),
(307, 5, 16, 3, 1),
(308, 5, 16, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancos`
--

CREATE TABLE `bancos` (
  `rif_banco` int(255) NOT NULL,
  `nombre_banco` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `bancos`
--

INSERT INTO `bancos` (`rif_banco`, `nombre_banco`) VALUES
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
  `movimiento` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `modulo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`ID`, `fecha`, `movimiento`, `modulo`, `descripcion`, `id_admin`) VALUES
(62, '2025-04-11 00:49:40', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(74, '2025-04-15 10:27:45', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(75, '2025-04-15 10:33:16', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(77, '2025-04-15 10:47:37', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(79, '2025-04-21 10:35:07', 'Iniciar Sesion', 'Usuario', 'El usuario: @vendedor_ca ha iniciado session', 13),
(122, '2025-04-22 16:24:03', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(126, '2025-04-22 16:39:50', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(127, '2025-04-22 16:40:14', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 17100998', 9),
(128, '2025-04-22 16:40:49', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 17100998', 9),
(132, '2025-04-22 16:52:20', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(136, '2025-04-22 17:01:00', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(139, '2025-04-22 17:12:30', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(142, '2025-04-22 17:29:45', 'Iniciar Sesion', 'Usuario', 'El usuario: @user_ca ha iniciado session', 9),
(152, '2025-04-22 20:46:13', 'Iniciar Sesion', 'Usuario', 'El usuario: @admin_ca ha iniciado session', 15),
(153, '2025-04-23 20:26:57', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(154, '2025-04-23 20:39:47', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(155, '2025-04-23 20:43:59', 'Agregar', 'Usuarios', 'El usuario:  ha agregado un nuevo usuario', 15),
(156, '2025-04-23 21:26:29', 'Eliminar', 'Usuarios', 'El usuario:  elimino un usuario', 15),
(157, '2025-04-23 23:44:07', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 17100998', 15),
(158, '2025-04-23 23:44:36', 'Modificar', 'Clientes', 'Cliente con la cedula: V- 17100998', 15),
(159, '2025-04-23 23:44:40', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 17100998', 15),
(160, '2025-04-23 23:48:55', 'Eliminar', 'Tipo de Producto', 'Tipo producto: Arroz Con presentacion: Mary Perlado Bulto 20 unidades de 1k', 15),
(161, '2025-04-23 23:49:57', 'Eliminar', 'Tipo de Producto', 'Tipo producto: Harina de trigo Con presentacion: Mary Saco de 43k', 15),
(162, '2025-04-23 23:50:01', 'Eliminar', 'Tipo de Producto', 'Tipo producto: Refresco Con presentacion: Refresco bulto de 6 unidades de 2lt', 15),
(163, '2025-04-23 23:50:04', 'Eliminar', 'Tipo de Producto', 'Tipo producto: Refresco Con presentacion: Refresco bulto de 6 unidades de 1lt', 15),
(164, '2025-04-23 23:50:08', 'Eliminar', 'Tipo de Producto', 'Tipo producto: Refresco Con presentacion: Refresco bulto de 6 unidades de 250ml', 15),
(165, '2025-04-23 23:50:11', 'Eliminar', 'Tipo de Producto', 'Tipo producto: Azucar Con presentacion: Azucar Bulto 20 unidades de 1k', 15),
(166, '2025-04-23 23:50:15', 'Eliminar', 'Tipo de Producto', 'Tipo producto: Azucar Con presentacion: Azucar Saco de 50k', 15),
(167, '2025-04-23 23:50:18', 'Eliminar', 'Tipo de Producto', 'Tipo producto: Harina de Trigo Con presentacion: Harina de Trigo saco de 45k', 15),
(168, '2025-04-23 23:54:43', 'Agregar', 'Tipo de Producto', 'Tipo producto: Aceite Con presentacion: Bulto de 9 undades de 900ml', 15),
(169, '2025-04-23 23:56:59', 'Agregar', 'Tipo de Producto', 'Tipo producto: moises Con presentacion: 213456uijhgfdc', 15),
(170, '2025-04-23 23:57:06', 'Eliminar', 'Tipo de Producto', 'Tipo producto: moises Con presentacion: 213456uijhgfdc', 15),
(171, '2025-04-23 23:58:48', 'Agregar', 'Tipo de Producto', 'Tipo producto: Aceite Con presentacion: 23456ruyjghf', 15),
(172, '2025-04-23 23:58:54', 'Eliminar', 'Tipo de Producto', 'Tipo producto: Aceite Con presentacion: 23456ruyjghf', 15),
(173, '2025-04-24 00:01:36', 'Agregar', 'Usuarios', 'El usuario:  ha agregado un nuevo usuario', 15),
(174, '2025-04-24 00:01:47', 'Eliminar', 'Usuarios', 'El usuario:  elimino un usuario', 15),
(175, '2025-04-24 00:24:04', 'Agregar', 'Usuarios', 'El usuario:  ha agregado un nuevo usuario', 15),
(176, '2025-04-24 00:24:46', 'Agregar', 'Usuarios', 'El usuario:  ha agregado un nuevo usuario', 15),
(177, '2025-04-24 00:28:11', 'Iniciar Sesion', 'Usuarios', 'El usuario: @super_ca ha iniciado session', 21),
(178, '2025-04-24 01:05:14', 'Iniciar Sesion', 'Usuarios', 'El usuario: @super_ca ha iniciado session', 21),
(179, '2025-04-24 10:10:58', 'Iniciar Sesion', 'Usuarios', 'El usuario: @super_ca ha iniciado session', 21),
(180, '2025-04-24 10:15:52', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 17100998', 21),
(181, '2025-04-24 10:16:34', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 17100998', 21),
(182, '2025-04-24 10:25:46', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(183, '2025-04-24 12:25:19', 'Iniciar Sesion', 'Usuarios', 'El usuario: @super_ca ha iniciado session', 21),
(184, '2025-04-24 12:25:56', 'Iniciar Sesion', 'Usuarios', 'El usuario: @super_ca ha iniciado session', 21),
(185, '2025-04-24 12:26:13', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(186, '2025-04-24 12:27:52', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 17100998', 15),
(187, '2025-04-24 12:27:59', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 17100998', 15),
(188, '2025-04-24 12:28:11', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 17100998', 15),
(189, '2025-04-24 12:28:26', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 17100998', 15),
(190, '2025-04-24 13:59:32', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(191, '2025-04-24 14:22:57', 'Iniciar Sesion', 'Usuarios', 'El usuario: @super_ca ha iniciado session', 21),
(192, '2025-04-24 15:13:18', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 17100998', 15),
(193, '2025-04-24 15:13:25', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 17100998', 15),
(194, '2025-04-24 19:01:28', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(195, '2025-04-24 19:01:38', 'Iniciar Sesion', 'Usuarios', 'El usuario: @super_ca ha iniciado session', 21),
(196, '2025-04-25 15:32:30', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(197, '2025-04-25 15:38:48', 'Iniciar Sesion', 'Usuarios', 'El usuario: @super_ca ha iniciado session', 21),
(198, '2025-04-25 18:11:29', 'Iniciar Sesion', 'Usuarios', 'El usuario: @user_ca ha iniciado session', 9),
(199, '2025-04-25 18:42:34', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(200, '2025-04-25 19:13:31', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(201, '2025-04-25 23:32:15', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(202, '2025-04-26 00:07:31', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(203, '2025-04-26 19:00:30', 'Iniciar Sesion', 'Usuarios', 'El usuario: @super_ca ha iniciado session', 21),
(204, '2025-04-26 19:48:52', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(205, '2025-04-26 20:31:47', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(206, '2025-04-26 20:41:43', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(207, '2025-04-26 20:48:24', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(208, '2025-04-26 20:49:51', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(209, '2025-04-26 20:52:03', 'Modificar', 'Clientes', 'Cliente con la cedula: V- 32200771', 15),
(210, '2025-04-26 20:52:44', 'Modificar', 'Clientes', 'Cliente con la cedula: V- 32200771', 15),
(211, '2025-04-26 20:53:13', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 23423423', 15),
(212, '2025-04-26 20:56:19', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 23423423', 15),
(213, '2025-04-26 20:59:50', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 12341324', 15),
(214, '2025-04-26 21:07:21', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(215, '2025-04-26 21:09:56', 'Modificar', 'Clientes', 'Cliente con la cedula: V- 12341324', 15),
(216, '2025-04-26 21:10:05', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 12341324', 15),
(217, '2025-04-26 21:10:29', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 98089089', 15),
(218, '2025-04-26 21:10:36', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 98089089', 15),
(219, '2025-04-26 21:14:35', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(220, '2025-04-26 21:15:39', 'Modificar', 'Clientes', 'Cliente con la cedula: V- 31039711', 15),
(221, '2025-04-26 21:17:06', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 34534534', 15),
(222, '2025-04-26 21:18:15', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 64532134', 15),
(223, '2025-04-26 21:19:22', 'Modificar', 'Clientes', 'Cliente con la cedula: V- 64532134', 15),
(224, '2025-04-26 21:19:33', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 34534534', 15),
(225, '2025-04-26 21:19:37', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 64532134', 15),
(226, '2025-04-26 21:23:44', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(227, '2025-04-26 21:24:34', 'Modificar', 'Clientes', 'Cliente con la cedula: V- 31039711', 15),
(228, '2025-04-26 21:27:28', 'Modificar', 'Clientes', 'Cliente con la cedula: V- 31039711', 15),
(229, '2025-04-26 21:29:47', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(230, '2025-04-26 21:35:05', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 23423434', 15),
(231, '2025-04-26 21:38:14', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 23423434', 15),
(232, '2025-04-26 21:57:56', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 34534534', 15),
(233, '2025-04-26 21:58:58', 'Modificar', 'Clientes', 'Cliente con la cedula: V- 34534534', 15),
(234, '2025-04-26 21:59:24', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 34534534', 15),
(235, '2025-04-26 22:22:32', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 23434342', 15),
(236, '2025-04-26 22:30:47', 'Modificar', 'Clientes', 'Cliente con la cedula: V- 23434342', 15),
(237, '2025-04-26 22:30:54', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 23434342', 15),
(238, '2025-04-26 22:32:12', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 30984347', 15),
(239, '2025-04-26 22:32:43', 'Modificar', 'Clientes', 'Cliente con la cedula: V- 30984347', 15),
(240, '2025-04-26 22:32:50', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 30984347', 15),
(241, '2025-04-28 13:19:20', 'Iniciar Sesion', 'Usuarios', 'El usuario: @admin_ca ha iniciado session', 15),
(242, '2025-04-28 13:20:01', 'Agregar', 'Clientes', 'Cliente con la cedula: V- 17100990', 15),
(243, '2025-04-28 13:20:31', 'Modificar', 'Clientes', 'Cliente con la cedula: V- 17100990', 15),
(244, '2025-04-28 13:20:44', 'Eliminar', 'Clientes', 'Cliente con la cedula: V- 17100990', 15),
(245, '2025-04-28 13:29:41', 'Iniciar Sesion', 'Usuarios', 'El usuario: @super_ca ha iniciado session', 21),
(246, '2025-04-28 14:19:25', 'Iniciar Sesion', 'Usuarios', 'El usuario: @super_ca ha iniciado session', 21),
(247, '2025-04-29 15:13:49', 'Iniciar Sesion', 'Usuarios', 'El usuario: @super_ca ha iniciado session', 21),
(248, '2025-05-12 12:09:02', 'Iniciar Sesion', 'Usuarios', 'El usuario: @super_ca ha iniciado session', 21),
(249, '2025-05-12 12:59:22', 'Agregar', 'Ventas', 'El usuario: @super_ca ha registrado una venta', 21),
(250, '2025-05-12 13:11:30', 'Agregar', 'Ventas', 'El usuario: @super_ca ha registrado una venta', 21),
(251, '2025-05-12 13:15:54', 'Agregar', 'Ventas', 'El usuario: @super_ca ha registrado una venta', 21),
(252, '2025-05-12 13:29:05', 'Agregar', 'Ventas', 'El usuario: @super_ca ha registrado una venta', 21),
(253, '2025-05-12 13:33:11', 'Agregar', 'Ventas', 'El usuario: @super_ca ha registrado una venta', 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `ID` int(50) NOT NULL,
  `nombre_caja` varchar(255) NOT NULL,
  `saldo_caja` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`ID`, `nombre_caja`, `saldo_caja`) VALUES
(1, 'Caja Principal efectivos y divisas', '240.16'),
(2, 'Caja Secundaria transferencias y pago movil', '386.17');

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
  `peso` decimal(20,2) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cantidad_producto`
--

INSERT INTO `cantidad_producto` (`ID`, `id_producto`, `cantidad`, `precio`, `id_unidad_medida`, `peso`, `status`) VALUES
(60, 24, '0.00', '12.00', 3, '20.00', 0),
(61, 24, '40.00', '0.60', 1, '1.00', 0),
(62, 24, '39994.00', '0.30', 2, '0.50', 0),
(117, 20, '11.00', '43.00', 4, '0.00', 0),
(119, 21, '16.00', '39.00', 4, '0.00', 0),
(122, 22, '47.00', '42.00', 4, '0.00', 0),
(151, 17, '18.00', '7.00', 3, '0.00', 0),
(152, 18, '40.00', '18.00', 3, '0.00', 0),
(153, 19, '24.00', '45.00', 4, '0.00', 0),
(154, 66, '22.00', '23.00', 3, '0.00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(255) NOT NULL,
  `nombre_cliente` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tlf` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo_id` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nombre_cliente`, `tlf`, `direccion`, `email`, `tipo_id`, `status`) VALUES
(31039711, 'Moises', '04263213495', 'Barrio', 'moises@gmail.com', 'V-', 0),
(32200771, 'david', '04121234567', 'AV La Salle', 'david@gmail.com', 'V-', 0);

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
  `pago` int(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id_compra`, `id_producto`, `rif_proveedor`, `cantidad_compra`, `monto`, `fecha`, `pago`, `status`) VALUES
(1, 24, 1234322, 10, '0.00', '2025-03-06', 5, 0),
(2, 24, 131254678, 1, '42.00', '2025-03-27', 3, 0),
(3, 24, 131254678, 1, '6.00', '2025-03-27', 1, 0),
(4, 22, 131254678, 1, '6.00', '2025-03-27', 1, 0),
(5, 22, 131254678, 1, '6.00', '2025-03-27', 1, 0),
(6, 22, 131254678, 1, '2.00', '2025-03-27', 1, 0),
(7, 22, 1234322, 1, '6.00', '2025-03-27', 1, 0),
(12, 24, 1234322, 1, '12.00', '2024-11-20', 5, 0),
(13, 24, 131254678, 1, '500.00', '2025-03-07', 4, 0),
(14, 24, 131254678, 1, '10.00', '2025-03-07', 5, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_por_cobrar`
--

CREATE TABLE `cuenta_por_cobrar` (
  `id_cuentaCobrar` int(255) NOT NULL,
  `id_venta` int(255) NOT NULL,
  `id_pago` int(11) DEFAULT NULL,
  `fecha_cuentaCobrar` date NOT NULL,
  `monto_cuentaCobrar` decimal(20,2) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `cuenta_por_cobrar`
--

INSERT INTO `cuenta_por_cobrar` (`id_cuentaCobrar`, `id_venta`, `id_pago`, `fecha_cuentaCobrar`, `monto_cuentaCobrar`, `status`) VALUES
(14, 14, NULL, '2025-03-12', '4.92', 0),
(32, 32, NULL, '2025-05-12', '1.39', 0),
(2147483647, 31, NULL, '2025-05-12', '13.92', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_por_pagar`
--

CREATE TABLE `cuenta_por_pagar` (
  `id_cuentaPagar` int(255) NOT NULL,
  `id_compra` int(255) NOT NULL,
  `id_pago` int(11) DEFAULT NULL,
  `fecha_cuentaPagar` date NOT NULL,
  `monto_cuentaPagar` decimal(20,2) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `cuenta_por_pagar`
--

INSERT INTO `cuenta_por_pagar` (`id_cuentaPagar`, `id_compra`, `id_pago`, `fecha_cuentaPagar`, `monto_cuentaPagar`, `status`) VALUES
(1, 1, NULL, '2025-03-06', '0.00', 0),
(12, 12, 1, '2025-04-05', '9.00', 0),
(14, 14, NULL, '2025-03-26', '9.00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra_proveedor`
--

CREATE TABLE `detalle_compra_proveedor` (
  `id_detalleCompraProveedor` int(255) NOT NULL,
  `id_facturaProveedor` int(255) NOT NULL,
  `id_producto` int(255) NOT NULL,
  `cantidad_compra` int(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `detalle_compra_proveedor`
--

INSERT INTO `detalle_compra_proveedor` (`id_detalleCompraProveedor`, `id_facturaProveedor`, `id_producto`, `cantidad_compra`, `status`) VALUES
(1, 1, 24, 10, 0),
(2, 2, 24, 1, 0),
(3, 3, 24, 1, 0),
(4, 4, 22, 1, 0),
(7, 7, 22, 1, 0),
(12, 12, 24, 1, 0),
(13, 13, 24, 1, 0),
(14, 14, 24, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_notificacion`
--

CREATE TABLE `detalle_notificacion` (
  `ID` int(25) NOT NULL,
  `id_detalle_notificaciones` int(25) NOT NULL,
  `id_admin` int(25) NOT NULL,
  `mensaje` varchar(100) NOT NULL,
  `enlace` varchar(50) NOT NULL,
  `estatus` int(25) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `precio` decimal(20,2) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `detalle_producto`
--

INSERT INTO `detalle_producto` (`id_detalle_producto`, `id_producto`, `id_venta`, `cantidad_producto`, `id_medida_especifica`, `precio`, `status`) VALUES
(1, 22, 1, 1, 4, '48.72', 0),
(12, 24, 12, 1, 3, '13.92', 0),
(13, 24, 13, 1, 3, '13.92', 0),
(14, 24, 14, 1, 3, '13.92', 0),
(23, 22, 23, 1, 4, '48.72', 0),
(24, 22, 24, 1, 4, '48.72', 0),
(28, 22, 28, 1, 4, '48.72', 0),
(30, 24, 30, 1, 3, '13.92', 0),
(32, 24, 32, 4, 2, '1.39', 0),
(33, 24, 33, 1, 2, '0.35', 0),
(34, 17, 34, 1, 3, '8.12', 0),
(35, 17, 35, 1, 3, '8.12', 0),
(2147483647, 24, 31, 1, 3, '13.92', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos`
--

CREATE TABLE `egresos` (
  `ID` int(25) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `id_movimiento` int(25) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `ID` int(25) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `id_movimiento` int(25) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidad_de_pago`
--

CREATE TABLE `modalidad_de_pago` (
  `id_modalidad_pago` int(255) NOT NULL,
  `nombre_modalidad` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(8, 'Pedidos'),
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
  `nombre_motivo` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL
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
  `id_pago` int(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `movimientos_caja`
--

INSERT INTO `movimientos_caja` (`ID`, `id_cajas`, `tipo_movimiento`, `monto_movimiento`, `concepto`, `fecha`, `id_pago`, `status`) VALUES
(1, 1, 'Ingreso', '100.00', 'Venta de productos', '2025-03-27', 1, 0),
(2, 2, 'Ingreso', '48.72', 'Venta de productos', '2025-03-27', 3, 0),
(3, 2, 'Ingreso', '0.35', 'Venta de productos', '2025-03-27', 0, 0),
(4, 2, 'Ingreso', '48.72', 'Venta de productos', '2025-03-27', 3, 0),
(5, 2, 'Ingreso', '48.72', 'Venta de productos', '2025-03-27', 3, 0),
(6, 2, 'Ingreso', '48.72', 'Venta de productos', '2025-03-27', 3, 0),
(7, 2, 'Ingreso', '48.72', 'Venta de productos', '2025-03-27', 3, 0),
(8, 2, 'Ingreso', '48.72', 'Venta de productos', '2025-03-27', 3, 0),
(9, 2, 'Ingreso', '48.72', 'Venta de productos', '2025-03-27', 3, 0),
(10, 1, 'Ingreso', '48.72', 'Venta de productos', '2025-03-27', 1, 0),
(11, 1, 'Ingreso', '48.72', 'Venta de productos', '2025-03-27', 1, 0),
(12, 1, 'Ingreso', '48.72', 'Venta de productos', '2025-03-27', 1, 0),
(13, 1, 'Egreso', '2.00', 'Venta de productos', '2025-03-27', 1, 0),
(14, 1, 'Egreso', '2.00', 'Venta de productos', '2025-03-27', 1, 0),
(15, 1, 'Egreso', '6.00', 'Compra de productos de productos', '2025-03-27', 1, 0),
(16, 2, 'Ingreso', '13.92', 'Venta de productos', '2025-04-05', 3, 0),
(17, 2, 'Ingreso', '14.62', 'Venta de productos', '2025-04-07', 3, 0),
(18, 2, 'Ingreso', '13.92', 'Venta de productos', '2025-05-12', 0, 0),
(19, 2, 'Ingreso', '1.39', 'Venta de productos', '2025-05-12', 0, 0),
(20, 2, 'Ingreso', '0.35', 'Venta de productos', '2025-05-12', 3, 0),
(21, 2, 'Ingreso', '8.12', 'Venta de productos', '2025-05-12', 3, 0),
(22, 2, 'Ingreso', '8.12', 'Venta de productos', '2025-05-12', 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `id_notificacion` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_admin` int(11) NOT NULL,
  `titulo` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `notificacion`
--

INSERT INTO `notificacion` (`id_notificacion`, `fecha`, `id_admin`, `titulo`, `status`) VALUES
(1, '2025-04-02 15:47:27', 9, 'El producto  se ha agotado.', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(25) NOT NULL,
  `id_producto` int(25) NOT NULL,
  `id_cliente` int(25) NOT NULL,
  `id_modalidad_pago` int(25) NOT NULL,
  `fecha_emision` date NOT NULL,
  `monto` int(25) NOT NULL,
  `cantidad` int(25) NOT NULL,
  `tipo_entrega` varchar(50) NOT NULL,
  `rif_banco` int(25) NOT NULL,
  `tlf` int(25) NOT NULL,
  `is_active` int(25) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(25) NOT NULL,
  `nombre_permiso` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `nombre_permiso`) VALUES
(1, 'agregar'),
(2, 'consultar'),
(3, 'Modificar'),
(4, 'Eliminar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `id_presentacion` int(20) NOT NULL,
  `tipo_producto` varchar(255) NOT NULL,
  `presentacion` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `presentacion`
--

INSERT INTO `presentacion` (`id_presentacion`, `tipo_producto`, `presentacion`, `status`) VALUES
(1, 'Arroz', 'Mary Perlado Bulto 20 unidades de 1k', 0),
(6, 'Harina de trigo', 'Mary Saco de 43k', 0),
(20, 'Refresco', 'Refresco bulto de 6 unidades de 2lt', 0),
(21, 'Refresco', 'Refresco bulto de 6 unidades de 1lt', 0),
(22, 'Refresco', 'Refresco bulto de 6 unidades de 250ml', 0),
(23, 'Azucar', 'Azucar Bulto 20 unidades de 1k', 0),
(24, 'Azucar', 'Azucar Saco de 50k', 0),
(25, 'Harina de Trigo', 'Harina de Trigo saco de 45k', 0),
(26, 'Aceite', 'Bulto de 9 undades de 900ml', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(255) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `marca` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_registro` date DEFAULT NULL,
  `fecha_vencimiento` date NOT NULL,
  `id_motivoActualizacion` int(255) NOT NULL,
  `id_inventario` int(255) NOT NULL,
  `id_presentacion` int(255) NOT NULL,
  `enlace` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `marca`, `fecha_registro`, `fecha_vencimiento`, `id_motivoActualizacion`, `id_inventario`, `id_presentacion`, `enlace`, `status`) VALUES
(17, 'Refresco BigCola 2lt', '', '2025-03-27', '2025-04-05', 1, 0, 20, 'views/img/productos/Refresco BigCola 2lt.jpg', 0),
(18, 'Azucar La Pastora 1k', '', '2025-03-27', '2025-04-05', 0, 0, 23, 'views/img/productos/Azucar La Pastora 1k.jpg', 0),
(19, 'Azucar Sabana Dulce', '', '2025-03-27', '2025-04-05', 0, 0, 24, 'views/img/productos/Azucar Sabana Dulce.jpg', 0),
(20, 'Harina de Trigo Siseca', '', '2025-04-05', '2025-03-15', 0, 0, 25, 'views/img/productos/Harina de Trigo Siseca.jpg', 0),
(21, 'Harina de Trigo La Especial', '', '2025-03-15', '2025-04-05', 0, 0, 25, 'views/img/productos/Harina de Trigo La Especial.jpg', 0),
(22, 'Azucar La Nieve', '', '2025-03-15', '2025-04-05', 0, 0, 24, 'views/img/productos/Azucar La Nieve.jpg', 0),
(24, 'Arroz', '', '2024-11-20', '2024-12-07', 1, 0, 1, '', 0),
(56, 'avena', '', '2025-03-05', '2025-04-05', 2, 0, 6, '', 0),
(66, 'pasta larga', 'waker', '2025-04-14', '2025-05-10', 0, 0, 1, 'views/img/productos/logaritmo.png', 0),
(98, 'pasta', '', '2025-03-27', '2025-04-05', 0, 0, 1, 'views/img/productos/prueba.png', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(255) NOT NULL,
  `nombre_proveedor` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tlf` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_representante` int(255) NOT NULL,
  `nombre_representante` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tlf_representante` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo_id` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo_id2` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre_proveedor`, `direccion`, `tlf`, `id_representante`, `nombre_representante`, `tlf_representante`, `tipo_id`, `tipo_id2`, `status`) VALUES
(1234322, 'friz', 'Zona', '412321246', 32200771, 'moises', '04121235676', 'J-', 'V-', 0),
(131254678, 'Nestle', 'Zona', '4121234567', 31039711, 'moises', '04123213495', 'J-', 'V-', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(25) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Superusuario'),
(2, 'Administrador'),
(3, 'Usuario'),
(4, 'Vendedor'),
(5, 'Contador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_de_medida`
--

CREATE TABLE `unidades_de_medida` (
  `id_unidad_medida` int(255) NOT NULL,
  `nombre_medida` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL
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
  `usuario` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_rol` int(25) NOT NULL,
  `pw` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `usuario`, `id_rol`, `pw`, `status`) VALUES
(9, '@user_ca', 3, '$2y$10$KeSPukQrDVa8qGep.ZAXN.SNcqDHbBI573cq9XNuv12zSatxGJ0HO', 0),
(13, '@vendedor_ca', 4, '$2y$10$r2IqiyXhlP5QzceGgwCbL.Nu0YnPw0WmJRJj4UTkWonTf7mmmQ5gO', 0),
(15, '@admin_ca', 2, '$2y$10$IkC21BwrFzNE8gRcfOxroOX.f35CiKfhLWbHDfBFzWGcJCjV3ONuS', 0),
(20, '@contador_ca', 5, '$2y$10$TrY0fmY6M24kLAGrn/gsWuA9XjvpwBp5o3CIXLaL0Vq3DevCsaqaG', 0),
(21, '@super_ca', 1, '$2y$10$ncqS3m/eGCNgXnV48SxddOyXeV/Fy2HBjC.hY6Xuq7YGCwsHKe50K', 0);

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
  `fech_vencimiento` date NOT NULL,
  `id_modalidad_pago` int(255) NOT NULL,
  `monto` decimal(20,2) NOT NULL,
  `tipo_entrega` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `rif_banco` int(255) DEFAULT NULL,
  `venta` int(11) DEFAULT NULL,
  `tlf` varchar(11) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id_venta`, `id_producto`, `id_cliente`, `cantidad`, `fech_emision`, `fech_vencimiento`, `id_modalidad_pago`, `monto`, `tipo_entrega`, `rif_banco`, `venta`, `tlf`, `is_active`, `status`) VALUES
(1, 22, 31039711, 1, '2025-03-27', '2025-05-12', 3, '48.72', 'Directa', 102, 6, '2147483647', 1, 0),
(12, 24, 31039711, 1, '2025-03-07', '2025-05-12', 3, '13.92', 'Directa', 102, 6, '2147483647', 1, 0),
(13, 24, 32200771, 1, '2025-03-07', '2025-05-12', 4, '13.92', 'Delivery', 104, 6, '2147483647', 1, 0),
(14, 24, 32200771, 1, '2025-03-07', '2025-05-12', 4, '13.92', 'Delivery', 108, 5, '1234567899', 1, 0),
(15, 17, 31039711, 1, '2025-03-15', '2025-05-12', 3, '8.12', 'Directa', 102, 6, '2147483647', 1, 0),
(16, 21, 31039711, 5, '2025-03-15', '2025-05-12', 3, '242.44', 'Delivery', 104, 5, '2147483647', 1, 0),
(20, 24, 31039711, 1, '2025-03-27', '2025-05-12', 3, '13.92', 'Directa', 102, 6, '2147483647', 1, 0),
(21, 24, 31039711, 1, '2025-03-27', '2025-05-12', 3, '13.92', 'Directa', 102, 6, '2147483647', 1, 0),
(22, 24, 31039711, 1, '2025-03-27', '2025-05-12', 3, '13.92', 'Directa', 102, 6, '2147483647', 1, 0),
(23, 22, 31039711, 1, '2025-03-27', '2025-05-12', 0, '48.72', 'Directa', 102, 0, '2147483647', 1, 0),
(24, 22, 31039711, 1, '2025-03-27', '2025-05-12', 3, '48.72', 'Directa', 102, 6, '2147483647', 1, 0),
(25, 22, 31039711, 1, '2025-03-27', '2025-05-12', 3, '48.72', 'Directa', 102, 6, '2147483647', 1, 0),
(27, 22, 31039711, 1, '2025-03-27', '2025-05-12', 3, '48.72', 'Directa', 102, 6, '2147483647', 1, 0),
(28, 22, 31039711, 1, '2025-03-27', '2025-05-12', 3, '48.72', 'Directa', 102, 6, '2147483647', 1, 0),
(29, 22, 31039711, 1, '2025-03-27', '2025-05-12', 3, '48.72', 'Directa', 102, 6, '2147483647', 1, 0),
(30, 24, 31039711, 1, '2025-04-05', '2025-05-12', 3, '13.92', 'Directa', 102, 6, '2147483647', 1, 0),
(31, 24, 32200771, 1, '2025-05-12', '2025-05-19', 0, '13.92', '', NULL, 5, '0', 1, 0),
(32, 24, 31039711, 4, '2025-05-12', '2025-05-19', 0, '1.39', '', NULL, 5, '0', 1, 0),
(33, 24, 31039711, 1, '2025-05-12', '2025-05-19', 3, '0.35', 'Directa', 102, 6, '2147483647', 1, 0),
(34, 17, 31039711, 1, '2025-05-12', '2025-05-19', 3, '8.12', 'Delivery', 102, 6, '2147483647', 1, 0),
(35, 17, 31039711, 1, '2025-05-12', '2025-05-19', 3, '8.12', 'Delivery', 134, 6, '04161234567', 1, 0);

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
-- Indices de la tabla `detalle_notificacion`
--
ALTER TABLE `detalle_notificacion`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_detalle_notificaciones` (`id_detalle_notificaciones`);

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
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`,`id_cliente`,`rif_banco`),
  ADD KEY `id_modalidad_pago` (`id_modalidad_pago`),
  ADD KEY `id_cliente` (`id_cliente`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

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
-- AUTO_INCREMENT de la tabla `detalle_notificacion`
--
ALTER TABLE `detalle_notificacion`
  MODIFY `ID` int(25) NOT NULL AUTO_INCREMENT;

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
  MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `id_presentacion` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
-- Filtros para la tabla `detalle_notificacion`
--
ALTER TABLE `detalle_notificacion`
  ADD CONSTRAINT `detalle_notificacion_ibfk_1` FOREIGN KEY (`id_detalle_notificaciones`) REFERENCES `notificacion` (`id_notificacion`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;

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
