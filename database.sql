-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-08-2017 a las 02:02:01
-- Versión del servidor: 10.1.25-MariaDB-
-- Versión de PHP: 7.0.22-0ubuntu0.17.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hospital`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda`
--

CREATE TABLE `agenda` (
  `ag_codigo` bigint(20) NOT NULL,
  `ag_hora_pedido` datetime DEFAULT NULL,
  `ag_hora_agendada` datetime DEFAULT NULL,
  `pa_codigo` bigint(20) NOT NULL,
  `me_codigo` bigint(20) NOT NULL,
  `bx_codigo` smallint(6) NOT NULL,
  `es_codigo` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anaquel`
--

CREATE TABLE `anaquel` (
  `an_codigo` smallint(6) NOT NULL,
  `an_nombre` varchar(10) DEFAULT NULL,
  `bo_codigo` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `anaquel`
--

INSERT INTO `anaquel` (`an_codigo`, `an_nombre`, `bo_codigo`) VALUES
(1, 'Anaquel 1', 4),
(2, 'Anaquel 2', 12),
(3, 'Anaquel 3', 7),
(4, 'Anaquel 4', 15),
(5, 'Anaquel 5', 13),
(6, 'Anaquel 6', 13),
(7, 'Anaquel 7', 7),
(8, 'Anaquel 8', 3),
(9, 'Anaquel 9', 6),
(10, 'Anaquel 10', 11),
(11, 'Anaquel 11', 6),
(12, 'Anaquel 12', 8),
(13, 'Anaquel 13', 7),
(14, 'Anaquel 14', 20),
(15, 'Anaquel 15', 8),
(16, 'Anaquel 16', 1),
(17, 'Anaquel 17', 7),
(18, 'Anaquel 18', 17),
(19, 'Anaquel 19', 8),
(20, 'Anaquel 20', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega`
--

CREATE TABLE `bodega` (
  `bo_codigo` smallint(6) NOT NULL,
  `bo_nombre` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `bodega`
--

INSERT INTO `bodega` (`bo_codigo`, `bo_nombre`) VALUES
(1, 'Bodegas 1'),
(2, 'Bodegas 2'),
(3, 'Bodegas 3'),
(4, 'Bodegas 4'),
(5, 'Bodegas 5'),
(6, 'Bodegas 6'),
(7, 'Bodegas 7'),
(8, 'Bodegas 8'),
(9, 'Bodegas 9'),
(10, 'Bodegas 10'),
(11, 'Bodegas 11'),
(12, 'Bodegas 12'),
(13, 'Bodegas 13'),
(14, 'Bodegas 14'),
(15, 'Bodegas 15'),
(16, 'Bodegas 16'),
(17, 'Bodegas 17'),
(18, 'Bodegas 18'),
(19, 'Bodegas 19'),
(20, 'Bodegas 20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `box`
--

CREATE TABLE `box` (
  `bx_codigo` smallint(6) NOT NULL,
  `bx_nombre` varchar(20) DEFAULT NULL,
  `un_codigo` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `box`
--

INSERT INTO `box` (`bx_codigo`, `bx_nombre`, `un_codigo`) VALUES
(1, 'Box 1', 13),
(2, 'Box 2', 15),
(3, 'Box 3', 14),
(4, 'Box 4', 11),
(5, 'Box 5', 10),
(6, 'Box 6', 14),
(7, 'Box 7', 13),
(8, 'Box 8', 17),
(9, 'Box 9', 17),
(10, 'Box 10', 15),
(11, 'Box 11', 8),
(12, 'Box 12', 16),
(13, 'Box 13', 1),
(14, 'Box 14', 7),
(15, 'Box 15', 4),
(16, 'Box 16', 20),
(17, 'Box 17', 15),
(18, 'Box 18', 13),
(19, 'Box 19', 12),
(20, 'Box 20', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajon`
--

CREATE TABLE `cajon` (
  `ca_codigo` smallint(6) NOT NULL,
  `ca_nombre` varchar(10) DEFAULT NULL,
  `me_codigo` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conformidad`
--

CREATE TABLE `conformidad` (
  `co_codigo` bigint(20) NOT NULL,
  `co_fecha` datetime DEFAULT NULL,
  `co_cantidad` smallint(6) DEFAULT NULL,
  `co_obs` text,
  `tc_codigo` int(11) NOT NULL,
  `pa_codigo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `division`
--

CREATE TABLE `division` (
  `di_codigo` int(11) NOT NULL,
  `di_nombre` varchar(4) DEFAULT NULL,
  `di_rango_min` int(11) DEFAULT NULL,
  `di_rango_max` int(11) DEFAULT NULL,
  `an_codigo` smallint(6) DEFAULT NULL,
  `fu_codigo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `division`
--

INSERT INTO `division` (`di_codigo`, `di_nombre`, `di_rango_min`, `di_rango_max`, `an_codigo`, `fu_codigo`) VALUES
(1, 'D 1', 1, 10, 6, 1),
(2, 'D 2', 11, 20, 15, 2),
(3, 'D 3', 31, 40, 12, 3),
(4, 'D 4', 71, 80, 1, 4),
(5, 'D 5', 151, 160, 19, 5),
(6, 'D 6', 311, 320, 17, 6),
(7, 'D 7', 631, 640, 4, 7),
(8, 'D 8', 1271, 1280, 14, 8),
(9, 'D 9', 2551, 2560, 10, 9),
(10, 'D 10', 5111, 5120, 7, 10),
(11, 'D 11', 10231, 10240, 5, 11),
(12, 'D 12', 20471, 20480, 4, 12),
(13, 'D 13', 40951, 40960, 17, 13),
(14, 'D 14', 81911, 81920, 1, 14),
(15, 'D 15', 163831, 163840, 12, 15),
(16, 'D 16', 327671, 327680, 11, 16),
(17, 'D 17', 655351, 655360, 1, 17),
(18, 'D 18', 1310711, 1310720, 17, 18),
(19, 'D 19', 2621431, 2621440, 19, 19),
(20, 'D 20', 5242871, 5242880, 3, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `es_codigo` smallint(6) NOT NULL,
  `es_nombre` varchar(30) DEFAULT NULL,
  `se_codigo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`es_codigo`, `es_nombre`, `se_codigo`) VALUES
(1, 'Especialidad 1', 18),
(2, 'Especialidad 2', 6),
(3, 'Especialidad 3', 13),
(4, 'Especialidad 4', 17),
(5, 'Especialidad 5', 16),
(6, 'Especialidad 6', 5),
(7, 'Especialidad 7', 11),
(8, 'Especialidad 8', 20),
(9, 'Especialidad 9', 1),
(10, 'Especialidad 10', 8),
(11, 'Especialidad 11', 6),
(12, 'Especialidad 12', 13),
(13, 'Especialidad 13', 13),
(14, 'Especialidad 14', 15),
(15, 'Especialidad 15', 18),
(16, 'Especialidad 16', 5),
(17, 'Especialidad 17', 5),
(18, 'Especialidad 18', 1),
(19, 'Especialidad 19', 8),
(20, 'Especialidad 20', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_trazabilidad`
--

CREATE TABLE `estado_trazabilidad` (
  `et_codigo` smallint(6) NOT NULL,
  `et_nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionario`
--

CREATE TABLE `funcionario` (
  `fu_codigo` bigint(20) NOT NULL,
  `fu_rut` varchar(12) DEFAULT NULL,
  `fu_nombres` varchar(50) DEFAULT NULL,
  `fu_apellidos` varchar(50) DEFAULT NULL,
  `fu_email` varchar(50) DEFAULT NULL,
  `fu_password` varchar(256) DEFAULT NULL,
  `fu_estado` tinyint(1) DEFAULT NULL,
  `ti_codigo` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `funcionario`
--

INSERT INTO `funcionario` (`fu_codigo`, `fu_rut`, `fu_nombres`, `fu_apellidos`, `fu_email`, `fu_password`, `fu_estado`, `ti_codigo`) VALUES
(1, '18.433.269-8', 'VICTOR ADRIAN', 'JARPA HERMOSILLA', 'contacto@victorjarpa.cl', 'c152b479523a3eca99c2861dd0f1c3db', 1, 2),
(2, '11.111.111-1', 'PRUEBA PRUEBA', 'PRUEBA PRUEBA', 'prueba@prueba.cl', 'c893bad68927b457dbed39460e6afd62', 1, 2),
(3, '18.415.902-4', 'FUNCIONARIO DE', 'PRUEBA 1', 'prueba1@prueba.cl', '4ccd3d391dcd3c98c6a92a3c579b0047', 1, 1),
(4, '4.685.841-5', 'FUNCIONARIO DE', 'PRUEBA 2', 'prueba2@prueba.cl', '3c0cbdab3f36cd5b431ac5a6d4b7a139', 1, 1),
(5, '2.471.330-3', 'FUNCIONARIO DE', 'PRUEBA 3', 'prueba3@prueba.cl', '8c7527d629c7485fc99922878e1315fd', 1, 1),
(6, '26.590.878-9', 'FUNCIONARIO DE', 'PRUEBA 4', 'prueba4@prueba.cl', 'f05dae60c95ced3b8bdba7c10b16bea7', 1, 1),
(7, '13.127.852-3', 'FUNCIONARIO DE', 'PRUEBA 5', 'prueba5@prueba.cl', 'd4e7daee6cf3b19e4a1f328b12afcab1', 1, 1),
(8, '25.424.441-1', 'FUNCIONARIO DE', 'PRUEBA 6', 'prueba6@prueba.cl', 'fe1905ed8d0ff2d4d6087bdfae3e0063', 1, 1),
(9, '14.659.145-3', 'FUNCIONARIO DE', 'PRUEBA 7', 'prueba7@prueba.cl', 'adef8e2e05c38321efe3fb65569b81db', 1, 1),
(10, '9.499.698-2', 'FUNCIONARIO DE', 'PRUEBA 8', 'prueba8@prueba.cl', '07b4134dde70d4a62a8d26b91fa7ee3d', 1, 1),
(11, '28.234.408-2', 'FUNCIONARIO DE', 'PRUEBA 9', 'prueba9@prueba.cl', '7fb22808646f08c2c68ca04c03c6a323', 1, 1),
(12, '7.134.926-1', 'FUNCIONARIO DE', 'PRUEBA 10', 'prueba10@prueba.cl', '39a6f18f2d06e8346d100787ebd4dd4a', 1, 1),
(13, '24.545.110-6', 'FUNCIONARIO DE', 'PRUEBA 11', 'prueba11@prueba.cl', '66d7e911356f4f8cdbd2ef7cd79c1477', 1, 1),
(14, '6.503.252-6', 'FUNCIONARIO DE', 'PRUEBA 12', 'prueba12@prueba.cl', '4f5185a4df4395fcf1d8c8c483d12222', 1, 1),
(15, '27.100.196-9', 'FUNCIONARIO DE', 'PRUEBA 13', 'prueba13@prueba.cl', 'dad469b886164814aa1703a3550e5d53', 1, 1),
(16, '4.287.794-8', 'FUNCIONARIO DE', 'PRUEBA 14', 'prueba14@prueba.cl', 'feb460fec50baa9c929edd6523aff575', 1, 1),
(17, '22.745.523-1', 'FUNCIONARIO DE', 'PRUEBA 15', 'prueba15@prueba.cl', 'af68885d09e652537b0cbc66a95d24db', 1, 1),
(18, '26.333.949-7', 'FUNCIONARIO DE', 'PRUEBA 16', 'prueba16@prueba.cl', '7bed72fed3b13d705fcb4bc548c33e2d', 1, 1),
(19, '28.591.850-9', 'FUNCIONARIO DE', 'PRUEBA 17', 'prueba17@prueba.cl', '6e10d4c531b1ba8c8a6e264bd77173ad', 1, 1),
(20, '20.210.653-8', 'FUNCIONARIO DE', 'PRUEBA 18', 'prueba18@prueba.cl', '66bb22d7a6951228a5f42da69fb954d8', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico`
--

CREATE TABLE `medico` (
  `me_codigo` bigint(20) NOT NULL,
  `me_rut` varchar(12) DEFAULT NULL,
  `me_nombres` varchar(50) DEFAULT NULL,
  `me_apellidos` varchar(50) DEFAULT NULL,
  `me_email` varchar(50) DEFAULT NULL,
  `me_estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `medico`
--

INSERT INTO `medico` (`me_codigo`, `me_rut`, `me_nombres`, `me_apellidos`, `me_email`, `me_estado`) VALUES
(1, '22.482.334-4', 'MEDICO DE', 'PRUEBA 1', 'prueba1@prueba.cl', 1),
(2, '17.933.763-8', 'MEDICO DE', 'PRUEBA 2', 'prueba2@prueba.cl', 1),
(3, '16.231.185-4', 'MEDICO DE', 'PRUEBA 3', 'prueba3@prueba.cl', 1),
(4, '4.968.278-2', 'MEDICO DE', 'PRUEBA 4', 'prueba4@prueba.cl', 1),
(5, '21.843.335-5', 'MEDICO DE', 'PRUEBA 5', 'prueba5@prueba.cl', 1),
(6, '26.304.104-5', 'MEDICO DE', 'PRUEBA 6', 'prueba6@prueba.cl', 1),
(7, '29.241.801-2', 'MEDICO DE', 'PRUEBA 7', 'prueba7@prueba.cl', 1),
(8, '19.776.487-4', 'MEDICO DE', 'PRUEBA 8', 'prueba8@prueba.cl', 1),
(9, '1.855.785-2', 'MEDICO DE', 'PRUEBA 9', 'prueba9@prueba.cl', 1),
(10, '16.300.253-7', 'MEDICO DE', 'PRUEBA 10', 'prueba10@prueba.cl', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico_especialidad`
--

CREATE TABLE `medico_especialidad` (
  `me_codigo` bigint(20) NOT NULL,
  `es_codigo` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `medico_especialidad`
--

INSERT INTO `medico_especialidad` (`me_codigo`, `es_codigo`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 5),
(3, 6),
(4, 7),
(4, 8),
(5, 9),
(6, 10),
(7, 11),
(7, 12),
(8, 13),
(8, 14),
(9, 15),
(10, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo_solicitud`
--

CREATE TABLE `motivo_solicitud` (
  `mo_codigo` smallint(6) NOT NULL,
  `mo_nombre` varchar(256) DEFAULT NULL,
  `mo_dias` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `motivo_solicitud`
--

INSERT INTO `motivo_solicitud` (`mo_codigo`, `mo_nombre`, `mo_dias`) VALUES
(1, 'Usuarios con atención medica en atención cerrada', 1),
(2, 'Usuarios con atención abierta por nomina', 1),
(3, 'Usuarios con atención abierta por fuera de nominas', 1),
(4, 'Usuarios con atención abierta espontaneas', 1),
(5, 'Auditorías externas', 3),
(6, 'Auditorías médicas', 2),
(7, 'Preparación de HHCC en Cirugía Mayor Ambulatoria', 1),
(8, 'Revisión de HHCC en Cirugía Mayor Ambulatoria', 2),
(9, 'Revisión y preparación de HHCC en distintos comités', 2),
(10, 'Auditorías internas', 2),
(11, 'Solicitudes de trámites en línea', 15),
(12, 'Solicitudes de índole legal', 1),
(13, 'Solicitudes HHCC para Estudios', 5),
(14, 'Otras solicitudes', 2),
(15, 'Unidad Anatomía Patológica', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomina`
--

CREATE TABLE `nomina` (
  `no_codigo` bigint(20) NOT NULL,
  `no_fecha_creada` datetime DEFAULT NULL,
  `no_fecha_asignada` datetime DEFAULT NULL,
  `me_codigo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomina_agenda`
--

CREATE TABLE `nomina_agenda` (
  `no_codigo` bigint(20) NOT NULL,
  `ag_codigo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `pa_codigo` bigint(20) NOT NULL,
  `pa_rut` varchar(12) DEFAULT NULL,
  `pa_nombres` varchar(50) DEFAULT NULL,
  `pa_apellidos` varchar(50) DEFAULT NULL,
  `pa_estado` tinyint(1) DEFAULT NULL,
  `pa_hhcc` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`pa_codigo`, `pa_rut`, `pa_nombres`, `pa_apellidos`, `pa_estado`, `pa_hhcc`) VALUES
(1, '30.467.453-7', 'PACIENTE DE', 'PRUEBA 1', 1, 1),
(2, '3.713.134-9', 'PACIENTE DE', 'PRUEBA 2', 1, 2),
(3, '8.838.280-3', 'PACIENTE DE', 'PRUEBA 3', 1, 3),
(4, '1.702.851-8', 'PACIENTE DE', 'PRUEBA 4', 1, 4),
(5, '21.864.231-7', 'PACIENTE DE', 'PRUEBA 5', 1, 5),
(6, '1.931.959-7', 'PACIENTE DE', 'PRUEBA 6', 1, 6),
(7, '19.112.440-8', 'PACIENTE DE', 'PRUEBA 7', 1, 7),
(8, '13.293.917-4', 'PACIENTE DE', 'PRUEBA 8', 1, 8),
(9, '19.371.245-7', 'PACIENTE DE', 'PRUEBA 9', 1, 9),
(10, '30.280.714-3', 'PACIENTE DE', 'PRUEBA 10', 1, 10),
(11, '1.894.561-1', 'PACIENTE DE', 'PRUEBA 11', 1, 11),
(12, '17.413.841-3', 'PACIENTE DE', 'PRUEBA 12', 1, 12),
(13, '6.972.104-2', 'PACIENTE DE', 'PRUEBA 13', 1, 13),
(14, '27.963.934-5', 'PACIENTE DE', 'PRUEBA 14', 1, 14),
(15, '30.375.445-4', 'PACIENTE DE', 'PRUEBA 15', 1, 15),
(16, '16.363.827-2', 'PACIENTE DE', 'PRUEBA 16', 1, 16),
(17, '18.972.860-6', 'PACIENTE DE', 'PRUEBA 17', 1, 17),
(18, '6.574.840-2', 'PACIENTE DE', 'PRUEBA 18', 1, 18),
(19, '13.401.295-9', 'PACIENTE DE', 'PRUEBA 19', 1, 19),
(20, '21.136.289-8', 'PACIENTE DE', 'PRUEBA 20', 1, 20),
(21, '1.293.183-9', 'PACIENTE DE', 'PRUEBA 21', 1, 21),
(22, '6.117.475-2', 'PACIENTE DE', 'PRUEBA 22', 1, 22),
(23, '10.820.597-8', 'PACIENTE DE', 'PRUEBA 23', 1, 23),
(24, '3.424.991-7', 'PACIENTE DE', 'PRUEBA 24', 1, 24),
(25, '10.852.338-5', 'PACIENTE DE', 'PRUEBA 25', 1, 25),
(26, '11.179.722-7', 'PACIENTE DE', 'PRUEBA 26', 1, 26),
(27, '13.918.763-1', 'PACIENTE DE', 'PRUEBA 27', 1, 27),
(28, '29.952.989-9', 'PACIENTE DE', 'PRUEBA 28', 1, 28),
(29, '5.172.877-4', 'PACIENTE DE', 'PRUEBA 29', 1, 29),
(30, '4.352.537-4', 'PACIENTE DE', 'PRUEBA 30', 1, 30),
(31, '3.134.344-2', 'PACIENTE DE', 'PRUEBA 31', 1, 31),
(32, '12.336.875-7', 'PACIENTE DE', 'PRUEBA 32', 1, 32),
(33, '3.214.307-5', 'PACIENTE DE', 'PRUEBA 33', 1, 33),
(34, '7.929.312-6', 'PACIENTE DE', 'PRUEBA 34', 1, 34),
(35, '25.975.770-8', 'PACIENTE DE', 'PRUEBA 35', 1, 35),
(36, '28.760.767-1', 'PACIENTE DE', 'PRUEBA 36', 1, 36),
(37, '25.645.478-9', 'PACIENTE DE', 'PRUEBA 37', 1, 37),
(38, '27.915.405-9', 'PACIENTE DE', 'PRUEBA 38', 1, 38),
(39, '29.650.228-4', 'PACIENTE DE', 'PRUEBA 39', 1, 39),
(40, '27.103.166-9', 'PACIENTE DE', 'PRUEBA 40', 1, 40),
(41, '4.373.491-4', 'PACIENTE DE', 'PRUEBA 41', 1, 41),
(42, '7.703.986-1', 'PACIENTE DE', 'PRUEBA 42', 1, 42),
(43, '20.757.854-6', 'PACIENTE DE', 'PRUEBA 43', 1, 43),
(44, '14.622.681-3', 'PACIENTE DE', 'PRUEBA 44', 1, 44),
(45, '6.159.272-1', 'PACIENTE DE', 'PRUEBA 45', 1, 45),
(46, '30.578.136-9', 'PACIENTE DE', 'PRUEBA 46', 1, 46),
(47, '5.264.334-1', 'PACIENTE DE', 'PRUEBA 47', 1, 47),
(48, '6.401.991-3', 'PACIENTE DE', 'PRUEBA 48', 1, 48),
(49, '20.482.698-8', 'PACIENTE DE', 'PRUEBA 49', 1, 49),
(50, '3.684.928-7', 'PACIENTE DE', 'PRUEBA 50', 1, 50),
(51, '12.782.370-8', 'PACIENTE DE', 'PRUEBA 51', 1, 51),
(52, '11.952.208-5', 'PACIENTE DE', 'PRUEBA 52', 1, 52),
(53, '1.381.638-9', 'PACIENTE DE', 'PRUEBA 53', 1, 53),
(54, '26.674.912-9', 'PACIENTE DE', 'PRUEBA 54', 1, 54),
(55, '25.247.104-1', 'PACIENTE DE', 'PRUEBA 55', 1, 55),
(56, '15.996.393-2', 'PACIENTE DE', 'PRUEBA 56', 1, 56),
(57, '13.991.100-5', 'PACIENTE DE', 'PRUEBA 57', 1, 57),
(58, '20.928.329-1', 'PACIENTE DE', 'PRUEBA 58', 1, 58),
(59, '21.599.876-1', 'PACIENTE DE', 'PRUEBA 59', 1, 59),
(60, '16.985.588-5', 'PACIENTE DE', 'PRUEBA 60', 1, 60),
(61, '9.226.551-2', 'PACIENTE DE', 'PRUEBA 61', 1, 61),
(62, '24.464.215-6', 'PACIENTE DE', 'PRUEBA 62', 1, 62),
(63, '18.220.647-1', 'PACIENTE DE', 'PRUEBA 63', 1, 63),
(64, '4.940.284-5', 'PACIENTE DE', 'PRUEBA 64', 1, 64),
(65, '28.284.160-6', 'PACIENTE DE', 'PRUEBA 65', 1, 65),
(66, '4.389.626-8', 'PACIENTE DE', 'PRUEBA 66', 1, 66),
(67, '27.503.839-4', 'PACIENTE DE', 'PRUEBA 67', 1, 67),
(68, '13.427.905-7', 'PACIENTE DE', 'PRUEBA 68', 1, 68),
(69, '16.456.882-3', 'PACIENTE DE', 'PRUEBA 69', 1, 69),
(70, '25.997.895-4', 'PACIENTE DE', 'PRUEBA 70', 1, 70),
(71, '4.542.493-3', 'PACIENTE DE', 'PRUEBA 71', 1, 71),
(72, '13.678.830-4', 'PACIENTE DE', 'PRUEBA 72', 1, 72),
(73, '26.890.924-9', 'PACIENTE DE', 'PRUEBA 73', 1, 73),
(74, '6.550.799-1', 'PACIENTE DE', 'PRUEBA 74', 1, 74),
(75, '29.638.510-4', 'PACIENTE DE', 'PRUEBA 75', 1, 75),
(76, '29.415.198-5', 'PACIENTE DE', 'PRUEBA 76', 1, 76),
(77, '23.981.776-5', 'PACIENTE DE', 'PRUEBA 77', 1, 77),
(78, '30.671.925-1', 'PACIENTE DE', 'PRUEBA 78', 1, 78),
(79, '4.419.431-5', 'PACIENTE DE', 'PRUEBA 79', 1, 79),
(80, '30.262.912-8', 'PACIENTE DE', 'PRUEBA 80', 1, 80),
(81, '2.836.835-3', 'PACIENTE DE', 'PRUEBA 81', 1, 81),
(82, '10.634.401-3', 'PACIENTE DE', 'PRUEBA 82', 1, 82),
(83, '6.811.684-2', 'PACIENTE DE', 'PRUEBA 83', 1, 83),
(84, '5.783.661-8', 'PACIENTE DE', 'PRUEBA 84', 1, 84),
(85, '23.437.491-7', 'PACIENTE DE', 'PRUEBA 85', 1, 85),
(86, '1.417.840-2', 'PACIENTE DE', 'PRUEBA 86', 1, 86),
(87, '22.272.720-7', 'PACIENTE DE', 'PRUEBA 87', 1, 87),
(88, '12.632.595-4', 'PACIENTE DE', 'PRUEBA 88', 1, 88),
(89, '13.431.719-7', 'PACIENTE DE', 'PRUEBA 89', 1, 89),
(90, '29.120.999-2', 'PACIENTE DE', 'PRUEBA 90', 1, 90),
(91, '25.683.379-9', 'PACIENTE DE', 'PRUEBA 91', 1, 91),
(92, '13.941.858-2', 'PACIENTE DE', 'PRUEBA 92', 1, 92),
(93, '10.350.874-3', 'PACIENTE DE', 'PRUEBA 93', 1, 93),
(94, '19.714.511-4', 'PACIENTE DE', 'PRUEBA 94', 1, 94),
(95, '27.231.140-3', 'PACIENTE DE', 'PRUEBA 95', 1, 95),
(96, '23.636.707-2', 'PACIENTE DE', 'PRUEBA 96', 1, 96),
(97, '29.427.890-9', 'PACIENTE DE', 'PRUEBA 97', 1, 97),
(98, '12.890.172-2', 'PACIENTE DE', 'PRUEBA 98', 1, 98),
(99, '16.452.240-9', 'PACIENTE DE', 'PRUEBA 99', 1, 99),
(100, '10.999.172-6', 'PACIENTE DE', 'PRUEBA 100', 1, 100),
(101, '9.946.961-9', 'PACIENTE DE', 'PRUEBA 101', 1, 101),
(102, '19.472.325-5', 'PACIENTE DE', 'PRUEBA 102', 1, 102),
(103, '17.366.768-3', 'PACIENTE DE', 'PRUEBA 103', 1, 103),
(104, '27.476.501-8', 'PACIENTE DE', 'PRUEBA 104', 1, 104),
(105, '24.392.802-2', 'PACIENTE DE', 'PRUEBA 105', 1, 105),
(106, '7.875.433-7', 'PACIENTE DE', 'PRUEBA 106', 1, 106),
(107, '8.574.697-6', 'PACIENTE DE', 'PRUEBA 107', 1, 107),
(108, '16.769.294-8', 'PACIENTE DE', 'PRUEBA 108', 1, 108),
(109, '21.255.745-3', 'PACIENTE DE', 'PRUEBA 109', 1, 109),
(110, '18.970.825-2', 'PACIENTE DE', 'PRUEBA 110', 1, 110),
(111, '8.594.499-2', 'PACIENTE DE', 'PRUEBA 111', 1, 111),
(112, '30.901.108-7', 'PACIENTE DE', 'PRUEBA 112', 1, 112),
(113, '7.811.927-4', 'PACIENTE DE', 'PRUEBA 113', 1, 113),
(114, '20.361.234-9', 'PACIENTE DE', 'PRUEBA 114', 1, 114),
(115, '25.831.536-4', 'PACIENTE DE', 'PRUEBA 115', 1, 115),
(116, '17.730.236-3', 'PACIENTE DE', 'PRUEBA 116', 1, 116),
(117, '27.881.595-5', 'PACIENTE DE', 'PRUEBA 117', 1, 117),
(118, '26.420.644-1', 'PACIENTE DE', 'PRUEBA 118', 1, 118),
(119, '28.144.327-8', 'PACIENTE DE', 'PRUEBA 119', 1, 119),
(120, '29.335.660-2', 'PACIENTE DE', 'PRUEBA 120', 1, 120),
(121, '2.588.617-7', 'PACIENTE DE', 'PRUEBA 121', 1, 121),
(122, '26.751.648-6', 'PACIENTE DE', 'PRUEBA 122', 1, 122),
(123, '17.185.997-1', 'PACIENTE DE', 'PRUEBA 123', 1, 123),
(124, '24.234.403-7', 'PACIENTE DE', 'PRUEBA 124', 1, 124),
(125, '1.899.213-8', 'PACIENTE DE', 'PRUEBA 125', 1, 125),
(126, '8.758.957-2', 'PACIENTE DE', 'PRUEBA 126', 1, 126),
(127, '24.284.120-7', 'PACIENTE DE', 'PRUEBA 127', 1, 127),
(128, '15.680.889-5', 'PACIENTE DE', 'PRUEBA 128', 1, 128),
(129, '6.507.302-1', 'PACIENTE DE', 'PRUEBA 129', 1, 129),
(130, '6.850.705-7', 'PACIENTE DE', 'PRUEBA 130', 1, 130),
(131, '28.703.828-7', 'PACIENTE DE', 'PRUEBA 131', 1, 131),
(132, '25.232.452-8', 'PACIENTE DE', 'PRUEBA 132', 1, 132),
(133, '2.565.723-3', 'PACIENTE DE', 'PRUEBA 133', 1, 133),
(134, '8.681.486-1', 'PACIENTE DE', 'PRUEBA 134', 1, 134),
(135, '26.506.775-3', 'PACIENTE DE', 'PRUEBA 135', 1, 135),
(136, '3.665.854-3', 'PACIENTE DE', 'PRUEBA 136', 1, 136),
(137, '3.156.374-3', 'PACIENTE DE', 'PRUEBA 137', 1, 137),
(138, '27.980.974-8', 'PACIENTE DE', 'PRUEBA 138', 1, 138),
(139, '20.803.595-5', 'PACIENTE DE', 'PRUEBA 139', 1, 139),
(140, '28.947.376-9', 'PACIENTE DE', 'PRUEBA 140', 1, 140),
(141, '14.100.319-7', 'PACIENTE DE', 'PRUEBA 141', 1, 141),
(142, '20.705.763-5', 'PACIENTE DE', 'PRUEBA 142', 1, 142),
(143, '4.539.833-2', 'PACIENTE DE', 'PRUEBA 143', 1, 143),
(144, '4.688.554-2', 'PACIENTE DE', 'PRUEBA 144', 1, 144),
(145, '22.829.508-6', 'PACIENTE DE', 'PRUEBA 145', 1, 145),
(146, '24.482.496-4', 'PACIENTE DE', 'PRUEBA 146', 1, 146),
(147, '7.991.914-2', 'PACIENTE DE', 'PRUEBA 147', 1, 147),
(148, '28.290.189-4', 'PACIENTE DE', 'PRUEBA 148', 1, 148),
(149, '7.408.188-8', 'PACIENTE DE', 'PRUEBA 149', 1, 149),
(150, '1.852.419-2', 'PACIENTE DE', 'PRUEBA 150', 1, 150),
(151, '10.252.425-4', 'PACIENTE DE', 'PRUEBA 151', 1, 151),
(152, '25.879.673-5', 'PACIENTE DE', 'PRUEBA 152', 1, 152),
(153, '21.181.239-5', 'PACIENTE DE', 'PRUEBA 153', 1, 153),
(154, '16.636.910-7', 'PACIENTE DE', 'PRUEBA 154', 1, 154),
(155, '18.824.872-5', 'PACIENTE DE', 'PRUEBA 155', 1, 155),
(156, '1.962.919-3', 'PACIENTE DE', 'PRUEBA 156', 1, 156),
(157, '10.108.177-3', 'PACIENTE DE', 'PRUEBA 157', 1, 157),
(158, '26.497.511-2', 'PACIENTE DE', 'PRUEBA 158', 1, 158),
(159, '19.837.648-4', 'PACIENTE DE', 'PRUEBA 159', 1, 159),
(160, '21.321.978-4', 'PACIENTE DE', 'PRUEBA 160', 1, 160),
(161, '11.218.843-8', 'PACIENTE DE', 'PRUEBA 161', 1, 161),
(162, '22.753.618-3', 'PACIENTE DE', 'PRUEBA 162', 1, 162),
(163, '16.490.851-5', 'PACIENTE DE', 'PRUEBA 163', 1, 163),
(164, '12.770.799-7', 'PACIENTE DE', 'PRUEBA 164', 1, 164),
(165, '23.877.109-6', 'PACIENTE DE', 'PRUEBA 165', 1, 165),
(166, '10.521.792-9', 'PACIENTE DE', 'PRUEBA 166', 1, 166),
(167, '9.441.416-9', 'PACIENTE DE', 'PRUEBA 167', 1, 167),
(168, '19.395.399-9', 'PACIENTE DE', 'PRUEBA 168', 1, 168),
(169, '14.242.833-2', 'PACIENTE DE', 'PRUEBA 169', 1, 169),
(170, '27.451.552-4', 'PACIENTE DE', 'PRUEBA 170', 1, 170),
(171, '25.403.968-2', 'PACIENTE DE', 'PRUEBA 171', 1, 171),
(172, '3.768.918-8', 'PACIENTE DE', 'PRUEBA 172', 1, 172),
(173, '19.927.493-9', 'PACIENTE DE', 'PRUEBA 173', 1, 173),
(174, '12.285.846-7', 'PACIENTE DE', 'PRUEBA 174', 1, 174),
(175, '18.263.681-2', 'PACIENTE DE', 'PRUEBA 175', 1, 175),
(176, '16.980.255-9', 'PACIENTE DE', 'PRUEBA 176', 1, 176),
(177, '5.989.240-1', 'PACIENTE DE', 'PRUEBA 177', 1, 177),
(178, '12.692.495-2', 'PACIENTE DE', 'PRUEBA 178', 1, 178),
(179, '30.463.478-1', 'PACIENTE DE', 'PRUEBA 179', 1, 179),
(180, '5.397.923-7', 'PACIENTE DE', 'PRUEBA 180', 1, 180),
(181, '8.416.700-6', 'PACIENTE DE', 'PRUEBA 181', 1, 181),
(182, '17.547.379-2', 'PACIENTE DE', 'PRUEBA 182', 1, 182),
(183, '21.960.417-2', 'PACIENTE DE', 'PRUEBA 183', 1, 183),
(184, '29.573.241-1', 'PACIENTE DE', 'PRUEBA 184', 1, 184),
(185, '16.381.185-9', 'PACIENTE DE', 'PRUEBA 185', 1, 185),
(186, '30.580.188-9', 'PACIENTE DE', 'PRUEBA 186', 1, 186),
(187, '29.567.139-1', 'PACIENTE DE', 'PRUEBA 187', 1, 187),
(188, '26.962.856-1', 'PACIENTE DE', 'PRUEBA 188', 1, 188),
(189, '10.556.762-8', 'PACIENTE DE', 'PRUEBA 189', 1, 189),
(190, '1.142.109-7', 'PACIENTE DE', 'PRUEBA 190', 1, 190),
(191, '1.427.885-9', 'PACIENTE DE', 'PRUEBA 191', 1, 191),
(192, '27.126.110-4', 'PACIENTE DE', 'PRUEBA 192', 1, 192),
(193, '11.195.368-3', 'PACIENTE DE', 'PRUEBA 193', 1, 193),
(194, '20.456.351-6', 'PACIENTE DE', 'PRUEBA 194', 1, 194),
(195, '28.391.697-7', 'PACIENTE DE', 'PRUEBA 195', 1, 195),
(196, '9.553.877-6', 'PACIENTE DE', 'PRUEBA 196', 1, 196),
(197, '1.639.514-1', 'PACIENTE DE', 'PRUEBA 197', 1, 197),
(198, '20.523.731-6', 'PACIENTE DE', 'PRUEBA 198', 1, 198),
(199, '26.616.629-7', 'PACIENTE DE', 'PRUEBA 199', 1, 199),
(200, '19.640.214-9', 'PACIENTE DE', 'PRUEBA 200', 1, 200);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `se_codigo` bigint(20) NOT NULL,
  `se_nombre` varchar(20) DEFAULT NULL,
  `un_codigo` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`se_codigo`, `se_nombre`, `un_codigo`) VALUES
(1, 'Servicio 1', 10),
(2, 'Servicio 2', 8),
(3, 'Servicio 3', 19),
(4, 'Servicio 4', 13),
(5, 'Servicio 5', 10),
(6, 'Servicio 6', 18),
(7, 'Servicio 7', 12),
(8, 'Servicio 8', 16),
(9, 'Servicio 9', 5),
(10, 'Servicio 10', 4),
(11, 'Servicio 11', 16),
(12, 'Servicio 12', 9),
(13, 'Servicio 13', 8),
(14, 'Servicio 14', 15),
(15, 'Servicio 15', 4),
(16, 'Servicio 16', 4),
(17, 'Servicio 17', 16),
(18, 'Servicio 18', 11),
(19, 'Servicio 19', 16),
(20, 'Servicio 20', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `so_codigo` bigint(20) NOT NULL,
  `so_fecha_emision` datetime DEFAULT NULL,
  `so_fecha_asignada` datetime DEFAULT NULL,
  `so_fecha_entrega` datetime DEFAULT NULL,
  `so_detalle` text,
  `so_nombre_medico` varchar(100) DEFAULT NULL,
  `so_email_medico` varchar(100) DEFAULT NULL,
  `so_telefono_medico` varchar(100) DEFAULT NULL,
  `mo_codigo` smallint(6) NOT NULL,
  `fu_codigo` bigint(20) NOT NULL,
  `me_codigo` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_paciente`
--

CREATE TABLE `solicitud_paciente` (
  `so_codigo` int(11) NOT NULL,
  `pa_codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_conformidad`
--

CREATE TABLE `tipo_conformidad` (
  `tc_codigo` int(11) NOT NULL,
  `tc_nombre` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_conformidad`
--

INSERT INTO `tipo_conformidad` (`tc_codigo`, `tc_nombre`) VALUES
(1, 'Lentes'),
(2, 'Audifonos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_funcionario`
--

CREATE TABLE `tipo_funcionario` (
  `ti_codigo` smallint(6) NOT NULL,
  `ti_nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_funcionario`
--

INSERT INTO `tipo_funcionario` (`ti_codigo`, `ti_nombre`) VALUES
(1, 'NORMAL'),
(2, 'ADMIN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trazabilidad`
--

CREATE TABLE `trazabilidad` (
  `tr_codigo` bigint(20) NOT NULL,
  `tr_fecha` datetime DEFAULT NULL,
  `et_codigo` smallint(6) NOT NULL,
  `bx_codigo` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trazabilidad_hhcc`
--

CREATE TABLE `trazabilidad_hhcc` (
  `pa_codigo` bigint(20) NOT NULL,
  `tr_codigo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `un_codigo` smallint(6) NOT NULL,
  `un_nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`un_codigo`, `un_nombre`) VALUES
(1, 'Unidad 1'),
(2, 'Unidad 2'),
(3, 'Unidad 3'),
(4, 'Unidad 4'),
(5, 'Unidad 5'),
(6, 'Unidad 6'),
(7, 'Unidad 7'),
(8, 'Unidad 8'),
(9, 'Unidad 9'),
(10, 'Unidad 10'),
(11, 'Unidad 11'),
(12, 'Unidad 12'),
(13, 'Unidad 13'),
(14, 'Unidad 14'),
(15, 'Unidad 15'),
(16, 'Unidad 16'),
(17, 'Unidad 17'),
(18, 'Unidad 18'),
(19, 'Unidad 19'),
(20, 'Unidad 20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`ag_codigo`),
  ADD KEY `fk_agenda_box` (`bx_codigo`),
  ADD KEY `fk_agenda_especialidad` (`es_codigo`),
  ADD KEY `fk_agenda_medico` (`me_codigo`),
  ADD KEY `fk_paciente_agenda` (`pa_codigo`);

--
-- Indices de la tabla `anaquel`
--
ALTER TABLE `anaquel`
  ADD PRIMARY KEY (`an_codigo`),
  ADD KEY `fk_bodega_anaquel` (`bo_codigo`);

--
-- Indices de la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD PRIMARY KEY (`bo_codigo`);

--
-- Indices de la tabla `box`
--
ALTER TABLE `box`
  ADD PRIMARY KEY (`bx_codigo`),
  ADD KEY `fk_pasillo_box` (`un_codigo`);

--
-- Indices de la tabla `cajon`
--
ALTER TABLE `cajon`
  ADD PRIMARY KEY (`ca_codigo`),
  ADD KEY `fk_medico_cajon` (`me_codigo`);

--
-- Indices de la tabla `conformidad`
--
ALTER TABLE `conformidad`
  ADD PRIMARY KEY (`co_codigo`),
  ADD KEY `fk_paciente_conformidad` (`pa_codigo`),
  ADD KEY `fk_tipo_conformidad` (`tc_codigo`);

--
-- Indices de la tabla `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`di_codigo`),
  ADD KEY `fk_anaquel_division` (`an_codigo`),
  ADD KEY `fk_funcionario_division` (`fu_codigo`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`es_codigo`),
  ADD KEY `fk_servicio_especialidad` (`se_codigo`);

--
-- Indices de la tabla `estado_trazabilidad`
--
ALTER TABLE `estado_trazabilidad`
  ADD PRIMARY KEY (`et_codigo`);

--
-- Indices de la tabla `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`fu_codigo`),
  ADD KEY `fk_funcionario_tipo` (`ti_codigo`);

--
-- Indices de la tabla `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`me_codigo`);

--
-- Indices de la tabla `medico_especialidad`
--
ALTER TABLE `medico_especialidad`
  ADD PRIMARY KEY (`me_codigo`,`es_codigo`),
  ADD KEY `fk_medico_especialidad2` (`es_codigo`);

--
-- Indices de la tabla `motivo_solicitud`
--
ALTER TABLE `motivo_solicitud`
  ADD PRIMARY KEY (`mo_codigo`);

--
-- Indices de la tabla `nomina`
--
ALTER TABLE `nomina`
  ADD PRIMARY KEY (`no_codigo`),
  ADD KEY `fk_nomina_medico` (`me_codigo`);

--
-- Indices de la tabla `nomina_agenda`
--
ALTER TABLE `nomina_agenda`
  ADD PRIMARY KEY (`no_codigo`,`ag_codigo`),
  ADD KEY `fk_nomina_agenda2` (`ag_codigo`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`pa_codigo`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`se_codigo`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`so_codigo`),
  ADD KEY `fk_funcionario_solicitud` (`fu_codigo`),
  ADD KEY `fk_solicitud_medico` (`me_codigo`),
  ADD KEY `fk_solicitud_motivo` (`mo_codigo`);

--
-- Indices de la tabla `tipo_conformidad`
--
ALTER TABLE `tipo_conformidad`
  ADD PRIMARY KEY (`tc_codigo`);

--
-- Indices de la tabla `tipo_funcionario`
--
ALTER TABLE `tipo_funcionario`
  ADD PRIMARY KEY (`ti_codigo`);

--
-- Indices de la tabla `trazabilidad`
--
ALTER TABLE `trazabilidad`
  ADD PRIMARY KEY (`tr_codigo`),
  ADD KEY `fk_trazabilidad_box` (`bx_codigo`),
  ADD KEY `fk_trazabilidad_estado` (`et_codigo`);

--
-- Indices de la tabla `trazabilidad_hhcc`
--
ALTER TABLE `trazabilidad_hhcc`
  ADD PRIMARY KEY (`pa_codigo`,`tr_codigo`),
  ADD KEY `fk_trazabilidad_hhcc2` (`tr_codigo`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`un_codigo`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `fk_agenda_box` FOREIGN KEY (`bx_codigo`) REFERENCES `box` (`bx_codigo`),
  ADD CONSTRAINT `fk_agenda_especialidad` FOREIGN KEY (`es_codigo`) REFERENCES `especialidad` (`es_codigo`),
  ADD CONSTRAINT `fk_agenda_medico` FOREIGN KEY (`me_codigo`) REFERENCES `medico` (`me_codigo`),
  ADD CONSTRAINT `fk_paciente_agenda` FOREIGN KEY (`pa_codigo`) REFERENCES `paciente` (`pa_codigo`);

--
-- Filtros para la tabla `anaquel`
--
ALTER TABLE `anaquel`
  ADD CONSTRAINT `fk_bodega_anaquel` FOREIGN KEY (`bo_codigo`) REFERENCES `bodega` (`bo_codigo`);

--
-- Filtros para la tabla `box`
--
ALTER TABLE `box`
  ADD CONSTRAINT `fk_pasillo_box` FOREIGN KEY (`un_codigo`) REFERENCES `unidad` (`un_codigo`);

--
-- Filtros para la tabla `cajon`
--
ALTER TABLE `cajon`
  ADD CONSTRAINT `fk_medico_cajon` FOREIGN KEY (`me_codigo`) REFERENCES `medico` (`me_codigo`);

--
-- Filtros para la tabla `conformidad`
--
ALTER TABLE `conformidad`
  ADD CONSTRAINT `fk_paciente_conformidad` FOREIGN KEY (`pa_codigo`) REFERENCES `paciente` (`pa_codigo`),
  ADD CONSTRAINT `fk_tipo_conformidad` FOREIGN KEY (`tc_codigo`) REFERENCES `tipo_conformidad` (`tc_codigo`);

--
-- Filtros para la tabla `division`
--
ALTER TABLE `division`
  ADD CONSTRAINT `fk_anaquel_division` FOREIGN KEY (`an_codigo`) REFERENCES `anaquel` (`an_codigo`),
  ADD CONSTRAINT `fk_funcionario_division` FOREIGN KEY (`fu_codigo`) REFERENCES `funcionario` (`fu_codigo`);

--
-- Filtros para la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD CONSTRAINT `fk_servicio_especialidad` FOREIGN KEY (`se_codigo`) REFERENCES `servicio` (`se_codigo`);

--
-- Filtros para la tabla `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `fk_funcionario_tipo` FOREIGN KEY (`ti_codigo`) REFERENCES `tipo_funcionario` (`ti_codigo`);

--
-- Filtros para la tabla `medico_especialidad`
--
ALTER TABLE `medico_especialidad`
  ADD CONSTRAINT `fk_medico_especialidad` FOREIGN KEY (`me_codigo`) REFERENCES `medico` (`me_codigo`),
  ADD CONSTRAINT `fk_medico_especialidad2` FOREIGN KEY (`es_codigo`) REFERENCES `especialidad` (`es_codigo`);

--
-- Filtros para la tabla `nomina`
--
ALTER TABLE `nomina`
  ADD CONSTRAINT `fk_nomina_medico` FOREIGN KEY (`me_codigo`) REFERENCES `medico` (`me_codigo`);

--
-- Filtros para la tabla `nomina_agenda`
--
ALTER TABLE `nomina_agenda`
  ADD CONSTRAINT `fk_nomina_agenda` FOREIGN KEY (`no_codigo`) REFERENCES `nomina` (`no_codigo`),
  ADD CONSTRAINT `fk_nomina_agenda2` FOREIGN KEY (`ag_codigo`) REFERENCES `agenda` (`ag_codigo`);

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `fk_funcionario_solicitud` FOREIGN KEY (`fu_codigo`) REFERENCES `funcionario` (`fu_codigo`),
  ADD CONSTRAINT `fk_solicitud_motivo` FOREIGN KEY (`mo_codigo`) REFERENCES `motivo_solicitud` (`mo_codigo`);

--
-- Filtros para la tabla `trazabilidad`
--
ALTER TABLE `trazabilidad`
  ADD CONSTRAINT `fk_trazabilidad_box` FOREIGN KEY (`bx_codigo`) REFERENCES `box` (`bx_codigo`),
  ADD CONSTRAINT `fk_trazabilidad_estado` FOREIGN KEY (`et_codigo`) REFERENCES `estado_trazabilidad` (`et_codigo`);

--
-- Filtros para la tabla `trazabilidad_hhcc`
--
ALTER TABLE `trazabilidad_hhcc`
  ADD CONSTRAINT `fk_trazabilidad_hhcc` FOREIGN KEY (`pa_codigo`) REFERENCES `paciente` (`pa_codigo`),
  ADD CONSTRAINT `fk_trazabilidad_hhcc2` FOREIGN KEY (`tr_codigo`) REFERENCES `trazabilidad` (`tr_codigo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
