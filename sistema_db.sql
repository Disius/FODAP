-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 05-09-2023 a las 19:09:09
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id` bigint UNSIGNED NOT NULL,
  `nameCarrera` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jefe_departamento` bigint UNSIGNED DEFAULT NULL,
  `presidente_academia` bigint UNSIGNED DEFAULT NULL,
  `departamento_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id`, `nameCarrera`, `jefe_departamento`, `presidente_academia`, `departamento_id`, `created_at`, `updated_at`) VALUES
(1, 'Ingeniería Mecánica', NULL, 404, 5, '2023-05-18 12:32:06', '2023-07-25 18:01:49'),
(2, 'Ingeniería en Sistemas Computacionales', NULL, NULL, 7, '2023-05-18 12:32:26', '2023-07-26 05:11:38'),
(3, 'Ingeniería Industrial', NULL, NULL, 4, '2023-05-18 12:32:40', '2023-07-26 05:11:50'),
(4, 'Ingeniería Electrónica', NULL, NULL, 3, '2023-05-18 12:33:02', '2023-07-26 05:11:57'),
(5, 'Ingeniería Eléctrica', NULL, NULL, 3, '2023-05-18 12:33:12', '2023-07-26 05:12:04'),
(6, 'Ingeniería Bioquímica', NULL, NULL, 6, '2023-05-18 12:33:45', '2023-07-26 05:12:13'),
(7, 'Ingeniería Química', NULL, 400, 6, '2023-05-18 12:34:02', '2023-07-25 18:01:56'),
(8, 'Ingeniería en Gestión Empresarial', NULL, NULL, 9, '2023-05-18 12:34:18', '2023-07-26 05:12:24'),
(9, 'Ingeniería en Logística', NULL, NULL, 9, '2023-05-18 12:34:35', '2023-07-26 05:12:36'),
(10, 'Ingeniería en Mecatrónica', NULL, NULL, 3, '2023-05-18 12:35:32', '2023-07-26 05:12:44'),
(11, 'Todas las carreras', NULL, NULL, NULL, '2023-05-18 12:36:01', '2023-05-18 12:36:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` bigint UNSIGNED NOT NULL,
  `nameCurso` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_curso` int NOT NULL,
  `objetivo` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_I` date NOT NULL,
  `fecha_F` date NOT NULL,
  `lugar` int DEFAULT NULL,
  `hora_I` time NOT NULL,
  `hora_F` time NOT NULL,
  `dirigido` bigint UNSIGNED NOT NULL,
  `duracion` int DEFAULT NULL,
  `periodo` int NOT NULL,
  `observaciones` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_actividad` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `nameCurso`, `tipo_curso`, `objetivo`, `fecha_I`, `fecha_F`, `lugar`, `hora_I`, `hora_F`, `dirigido`, `duracion`, `periodo`, `observaciones`, `tipo_actividad`, `created_at`, `updated_at`) VALUES
(8, 'ddwdwd', 2, 'dwadawd', '2023-04-18', '2023-04-11', NULL, '16:03:00', '16:05:00', 9, NULL, 2, NULL, 4, '2023-04-26 02:19:34', '2023-04-26 02:19:34'),
(9, 'dwqdqwd', 2, 'dqwdqdwqd', '2023-04-18', '2023-04-27', NULL, '03:41:00', '03:41:00', 9, NULL, 2, NULL, 5, '2023-04-26 02:19:43', '2023-04-26 02:19:43'),
(10, 'dqwdqwd', 1, 'dqwdqdq', '2023-04-10', '2023-04-02', NULL, '15:37:00', '04:34:00', 8, NULL, 2, NULL, 2, '2023-04-26 02:19:48', '2023-04-26 02:19:48'),
(11, 'Es un curso para realizar actividades un dia por dia', 1, 'jrbj2jkvkewv', '2023-04-12', '2023-03-28', NULL, '14:17:00', '14:15:00', 8, NULL, 2, 'El nombre esta mal', 3, '2023-04-26 02:19:53', '2023-04-26 02:19:53'),
(12, 'wqdqwjd', 1, 'qwdjqwjdlq', '2023-05-11', '2023-05-23', NULL, '15:21:00', '16:23:00', 9, NULL, 1, NULL, 4, '2023-05-12 00:20:07', '2023-05-12 00:20:07'),
(13, 'sdadqdqw', 1, 'qwdqdqwd', '2023-05-10', '2023-05-16', NULL, '12:09:00', '13:09:00', 2, NULL, 1, NULL, 1, '2023-06-05 23:45:03', '2023-06-05 23:45:03'),
(14, 'Curso Programacion', 2, 'Objetivo 2', '2023-08-21', '2023-08-24', NULL, '08:00:00', '18:00:00', 2, NULL, 2, NULL, 3, '2023-06-05 23:45:38', '2023-06-05 23:45:38'),
(15, 'Curso', 1, 'Objetivo', '2023-06-19', '2023-06-23', NULL, '08:00:00', '16:00:00', 2, NULL, 1, NULL, 2, '2023-06-05 23:45:49', '2023-06-05 23:45:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id` bigint UNSIGNED NOT NULL,
  `nameDepartamento` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jefe_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id`, `nameDepartamento`, `jefe_id`, `created_at`, `updated_at`) VALUES
(1, 'Departamento de Ciencias Básicas', 400, NULL, NULL),
(2, 'Departamento de Desarrollo Académico', NULL, NULL, NULL),
(3, 'Departamento de Ingeniería Eléctrica y Electrónica', NULL, NULL, NULL),
(4, 'Departamento de Ingeniería Industrial', NULL, NULL, NULL),
(5, 'Departamento de Metal Mecánica', NULL, NULL, NULL),
(6, 'Departamento de Ingeniería Química y Bioquímica', NULL, NULL, NULL),
(7, 'Departamento de Sistemas y Computación', 415, NULL, NULL),
(8, 'Departamento Económico Administrativo', NULL, NULL, NULL),
(9, 'Departamento de Ingenierías', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deteccion_has_facilitadores`
--

CREATE TABLE `deteccion_has_facilitadores` (
  `id` bigint UNSIGNED NOT NULL,
  `deteccion_id` bigint UNSIGNED DEFAULT NULL,
  `docente_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `deteccion_has_facilitadores`
--

INSERT INTO `deteccion_has_facilitadores` (`id`, `deteccion_id`, `docente_id`, `created_at`, `updated_at`) VALUES
(1, 59, 407, NULL, NULL),
(2, 60, 407, NULL, NULL),
(12, 61, 407, NULL, NULL),
(13, 61, 408, NULL, NULL),
(14, 62, 408, NULL, NULL),
(15, 62, 407, NULL, NULL),
(16, 63, 409, NULL, NULL),
(17, 64, 409, NULL, NULL),
(18, 65, 408, NULL, NULL),
(19, 66, 409, NULL, NULL),
(20, 67, 407, NULL, NULL),
(21, 68, 409, NULL, NULL),
(22, 69, 408, NULL, NULL),
(23, 70, 408, NULL, NULL),
(24, 71, 409, NULL, NULL),
(25, 72, 407, NULL, NULL),
(26, 73, 408, NULL, NULL),
(27, 74, 407, NULL, NULL),
(29, 76, 407, NULL, NULL),
(30, 75, 408, NULL, NULL),
(32, 77, 409, NULL, NULL),
(33, 78, 409, NULL, NULL),
(34, 79, 408, NULL, NULL),
(35, 80, 407, NULL, NULL),
(36, 81, 413, NULL, NULL),
(37, 82, 414, NULL, NULL),
(38, 82, 413, NULL, NULL),
(39, 83, 413, NULL, NULL),
(40, 85, 415, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deteccion_necesidades`
--

CREATE TABLE `deteccion_necesidades` (
  `id` bigint UNSIGNED NOT NULL,
  `id_jefe` bigint UNSIGNED DEFAULT NULL,
  `asignaturaFA` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenidosTM` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeroProfesores` int NOT NULL,
  `periodo` int NOT NULL,
  `carrera_dirigido` bigint UNSIGNED NOT NULL,
  `id_departamento` bigint DEFAULT NULL,
  `nombreCurso` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_FDoAP` int DEFAULT NULL,
  `tipo_actividad` int DEFAULT NULL,
  `fecha_I` date NOT NULL,
  `fecha_F` date NOT NULL,
  `hora_I` time NOT NULL,
  `hora_F` time NOT NULL,
  `total_horas` bigint DEFAULT NULL,
  `objetivoEvento` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `modalidad` bigint DEFAULT NULL,
  `id_lugar` bigint DEFAULT NULL,
  `facilitador_externo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `obs` int DEFAULT NULL,
  `aceptado` int DEFAULT NULL,
  `estado` bigint DEFAULT NULL,
  `anio_realizacion` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `deteccion_necesidades`
--

INSERT INTO `deteccion_necesidades` (`id`, `id_jefe`, `asignaturaFA`, `contenidosTM`, `numeroProfesores`, `periodo`, `carrera_dirigido`, `id_departamento`, `nombreCurso`, `tipo_FDoAP`, `tipo_actividad`, `fecha_I`, `fecha_F`, `hora_I`, `hora_F`, `total_horas`, `objetivoEvento`, `modalidad`, `id_lugar`, `facilitador_externo`, `observaciones`, `obs`, `aceptado`, `estado`, `anio_realizacion`, `created_at`, `updated_at`) VALUES
(81, 415, 'Fundamentos de programacion web', 'Todo lo relacionado a programacion web', 12, 1, 2, 7, 'Programacion web', 1, 3, '2023-09-11', '2023-09-15', '08:00:00', '16:00:00', 40, 'Aprender los fundamentos de programacion web', 2, 1, NULL, NULL, 0, 1, 0, NULL, '2023-09-04 15:20:15', '2023-09-04 17:17:12'),
(82, 415, 'Redes', 'Taller de redes', 12, 1, 2, 7, 'Redes para oficinas', 1, 3, '2023-09-18', '2023-09-22', '15:00:00', '21:00:00', 30, 'Aprender de redes', 2, 6, NULL, 'Consideras', 1, 1, 0, NULL, '2023-09-04 15:36:09', '2023-09-04 17:17:12'),
(83, 415, 'Profesional', 'ser profesional', 12, 1, 2, 7, 'Profesionalismo', 2, 3, '2023-09-04', '2023-09-08', '08:00:00', '14:00:00', 30, 'Lograr ser profesional', 1, 3, NULL, NULL, 0, 1, 1, NULL, '2023-09-04 16:37:38', '2023-09-04 17:17:12'),
(84, 415, 'Todos los temas de programacion en arduino', 'Temas programacion en arduino', 12, 1, 2, 7, 'Programacion en arduino', 1, 3, '2020-01-06', '2020-01-10', '10:00:00', '17:00:00', 35, 'Aprender y reforzar conocimientos en arduino', 1, 3, NULL, NULL, 0, 1, 2, NULL, '2023-09-05 01:17:15', '2023-09-05 01:17:15'),
(85, 415, 'a', 'a', 12, 1, 2, 7, 'a', 1, 3, '2003-03-12', '2003-04-12', '16:37:00', '17:38:00', 23, 'a', 1, 4, NULL, NULL, 0, 0, NULL, NULL, '2023-09-05 02:35:27', '2023-09-05 02:35:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id` bigint UNSIGNED NOT NULL,
  `rfc` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `curp` varchar(45) DEFAULT NULL,
  `nombre` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `apellidoPat` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `apellidoMat` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `sexo` bigint DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `interno` tinyint(1) DEFAULT NULL,
  `carrera_id` bigint UNSIGNED DEFAULT NULL,
  `id_posgrado` bigint DEFAULT NULL,
  `id_puesto` bigint DEFAULT NULL,
  `clavePresup` varchar(45) DEFAULT NULL,
  `horarioEntrada` time DEFAULT NULL,
  `horarioSalida` time DEFAULT NULL,
  `tipo_plaza` bigint DEFAULT NULL,
  `licenciatura` varchar(60) DEFAULT NULL,
  `prodep` varchar(45) DEFAULT NULL,
  `departamento_id` bigint UNSIGNED DEFAULT NULL,
  `empresa` varchar(75) DEFAULT NULL,
  `tipodecurso` varchar(255) DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nombre_completo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id`, `rfc`, `curp`, `nombre`, `apellidoPat`, `apellidoMat`, `sexo`, `telefono`, `interno`, `carrera_id`, `id_posgrado`, `id_puesto`, `clavePresup`, `horarioEntrada`, `horarioSalida`, `tipo_plaza`, `licenciatura`, `prodep`, `departamento_id`, `empresa`, `tipodecurso`, `user_id`, `created_at`, `updated_at`, `nombre_completo`) VALUES
(413, 'FWFWEFWFWFWEFWEF', 'FEPD990824HCSRRN09', 'Daniel Eduardo', 'Fernández', 'Pérez', 1, '9615797102', NULL, 2, 1, 3, NULL, NULL, NULL, 2, 'Ingenieria en Sisitemas Computacionales', NULL, 7, NULL, NULL, 7, '2023-09-04 02:52:26', '2023-09-04 03:23:53', 'Daniel Eduardo Fernández Pérez'),
(414, 'BEDJ850506ND8', 'FEPD990824HCSRRN09', 'Salvador', 'Hernandez', 'Garduza', 1, '9615797102', NULL, 4, 2, 2, NULL, NULL, NULL, 1, 'Ingenieria Electronica', NULL, 1, NULL, NULL, 8, '2023-09-04 12:24:09', '2023-09-04 12:24:09', 'Salvador Hernandez Garduza'),
(415, 'BEDJ850506ND8', 'FEPD990824HCSRRN09', 'Maria', 'Mojaras', 'Gutierrez', 1, '9615797102', NULL, 2, 3, 2, NULL, NULL, NULL, 1, 'Ingenieria en Sisitemas Computacionales', NULL, 7, NULL, NULL, 2, '2023-09-04 12:31:15', '2023-09-04 12:31:15', 'Maria Mojaras Gutierrez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `id` bigint UNSIGNED NOT NULL,
  `curso_id` bigint UNSIGNED NOT NULL,
  `docente_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`id`, `curso_id`, `docente_id`, `created_at`, `updated_at`) VALUES
(18, 84, 413, NULL, NULL),
(19, 84, 414, NULL, NULL),
(20, 84, 415, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugar`
--

CREATE TABLE `lugar` (
  `id` int NOT NULL,
  `nombreAula` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `lugar`
--

INSERT INTO `lugar` (`id`, `nombreAula`) VALUES
(1, 'AULA H-6'),
(2, 'AUDIO VISUAL EL EDIF. D1'),
(3, 'EDIFICIO D1 - LCOM 1'),
(4, 'AUDIOVISUAL DEL EDIF. I'),
(5, 'SALA DE USOS MULTIPLES EDIF. I'),
(6, 'AULA DE CAPACITACIÓN DE GESTIÓN Y VINCULACIÓN TECNOLÓGICA'),
(7, 'AULA LMEC'),
(8, 'EDFICIO D1 - LCOM 4'),
(9, 'EDIFICIO W'),
(10, 'SALA DE JUNTAS: EDIFICIO Z'),
(11, 'SALA DE JUNTAS: CIENCIAS BASICAS'),
(12, 'SALA DE JUNTAS: INGENIERíA ELECTRÓNICA'),
(13, 'SALA DE JUNTAS: POSGRADO EDIF. Z'),
(14, 'SALA DE JUNTAS: EDIFICIO D1'),
(15, 'SALA DE USOS MÚLTIPLES 1 EDIFICIO I'),
(16, 'SALA MAGNA: EDIF. K'),
(17, 'MODALIDAD VIRTUAL - GRUPO A'),
(18, 'MODALIDAD VIRTUAL - GRUPO B'),
(19, 'LABORATORIO DE BIOLOGIA MOLECULAR POLO TECNOLOGICO'),
(20, 'LABORATORIO DE SISTEMAS DIGITALES: EDIF. I'),
(21, 'LABORATORIOS DE MECÁNICA'),
(22, 'SIN ASIGNACIÓN'),
(23, 'AULA I - 13'),
(24, 'VIRTUAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_07_12_193558_create_permission_tables', 2),
(19, '2014_10_12_000000_create_users_table', 1),
(20, '2014_10_12_100000_create_password_resets_table', 1),
(21, '2019_08_19_000000_create_failed_jobs_table', 1),
(22, '2023_01_10_052527_create_permission_tables', 1),
(23, '2023_01_12_054837_create_deteccion_necesidades_table', 1),
(24, '2023_02_18_213349_create_facilitadores_table', 2),
(25, '2023_02_21_173403_create_departamento_table', 2),
(26, '2023_02_21_173639_create_carreras_table', 3),
(27, '2014_10_12_100000_create_password_reset_tokens_table', 4),
(28, '2019_12_14_000001_create_personal_access_tokens_table', 4),
(29, '2023_02_27_205905_create_deteccion_has_facilitadores_table', 5),
(30, '2023_03_05_014404_create_deteccion_has_facilitadores_table', 6),
(31, '2023_03_05_014755_create_deteccion_has_facilitadores_table', 7),
(32, '2023_03_06_133556_create_deteccion_has_facilitadores_table', 8),
(33, '2023_04_25_165109_create_cursos_table', 9),
(34, '2023_04_25_171145_create_inscripcion_table', 10),
(35, '2023_06_06_044106_create_notifications_table', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 6),
(4, 'App\\Models\\User', 7),
(1, 'App\\Models\\User', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel`
--

CREATE TABLE `nivel` (
  `id` bigint NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `nivel`
--

INSERT INTO `nivel` (`id`, `nombre`) VALUES
(1, 'OPERATIVO'),
(2, 'FUNCIONAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('029c4ea4-7348-4245-a00f-b83a4550461b', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:43', '2023-08-23 13:36:44', '2023-08-31 04:10:43'),
('045e814d-968b-4727-8ac2-7753335c2324', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"cformacion@tuxtla.tecnm.mx\",\"id\":76,\"route\":\"\\/academicos\\/curso\\/inscritos\",\"messegue\":\"El curso se ha aceptado\"}', '2023-08-23 12:44:05', '2023-08-23 11:24:58', '2023-08-23 12:44:05'),
('1134815e-7e71-42d7-9564-09b24b5897be', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 02:17:21', '2023-08-23 13:37:46', '2023-09-02 02:17:21'),
('122639e1-e80e-43c0-af59-7b45afdb97bf', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":78,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:12', '2023-08-29 02:17:32', '2023-08-31 04:10:12'),
('14ba31cb-c0a8-4f1a-9afe-45610760a717', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":69,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-10 09:24:54', '2023-08-07 13:24:23', '2023-08-10 09:24:54'),
('14efb221-b0a0-481f-a7eb-04f4846de888', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 02:17:58', '2023-08-23 13:17:40', '2023-09-02 02:17:58'),
('15b929ba-4a35-43ad-8f7b-807f5cbcff2d', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":78,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:49:45', '2023-08-29 02:13:21', '2023-09-02 01:49:45'),
('183783e2-10b8-4f4e-9f7a-7106c471483b', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"cformacion@tuxtla.tecnm.mx\",\"id\":83,\"route\":\"\\/academicos\\/curso\\/inscritos\",\"messegue\":\"El curso se ha aceptado\"}', '2023-09-05 15:16:55', '2023-09-04 16:38:12', '2023-09-05 15:16:55'),
('1abd0bdc-e3b5-475b-b892-8efe521746f6', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-08-26 06:28:07', '2023-08-26 06:27:49', '2023-08-26 06:28:07'),
('1be4dc84-5be9-47de-8ed0-5ae205de7790', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":72,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Se ha creado una nueva deteccion de necesidades\"}', '2023-08-10 09:46:22', '2023-08-10 09:40:23', '2023-08-10 09:46:22'),
('1f21e336-9748-4936-959d-fefef4e58500', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":71,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Se ha creado una nueva deteccion de necesidades\"}', '2023-08-10 09:46:24', '2023-08-10 09:25:31', '2023-08-10 09:46:24'),
('24e452c0-0fef-4587-9f2e-b78c7750b3f9', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:31', '2023-08-23 22:53:26', '2023-08-31 04:10:31'),
('276385cd-77e3-46a0-8c8b-be3982ba2bb0', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":77,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:21', '2023-08-26 15:12:47', '2023-08-31 04:10:21'),
('279f42bd-5bab-4e8c-b479-72c6e9354f64', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":76,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-23 12:44:02', '2023-08-23 11:23:45', '2023-08-23 12:44:02'),
('2d0ced6c-043a-48e7-9ac3-2c97bbd4c2cd', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":77,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:49:56', '2023-08-26 15:20:00', '2023-09-02 01:49:56'),
('2e604ca3-5be5-4577-b967-2744f5d31bee', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:33', '2023-08-23 22:38:03', '2023-08-31 04:10:33'),
('2f8a7624-c609-476a-872d-cb21e8f2ceb8', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:21', '2023-08-23 23:48:42', '2023-09-02 01:50:21'),
('34254496-80bc-4c15-a20f-93b0d12f7369', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"cformacion@tuxtla.tecnm.mx\",\"id\":82,\"route\":\"\\/academicos\\/curso\\/inscritos\",\"messegue\":\"El curso se ha aceptado\"}', '2023-09-04 16:16:05', '2023-09-04 16:15:57', '2023-09-04 16:16:05'),
('342594eb-07aa-459e-b618-897a52f4df19', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:29', '2023-08-23 22:55:37', '2023-08-31 04:10:29'),
('3d78f78d-caf1-4b2d-9219-5787c11d85e7', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:26', '2023-08-23 22:57:28', '2023-08-31 04:10:26'),
('469e6135-3dcb-4874-a103-4ddacf34b4ed', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":80,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-09-04 16:13:40', '2023-09-02 02:14:48', '2023-09-04 16:13:40'),
('4977a78e-b389-4cfd-9be0-c01e9867585a', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":78,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:49:49', '2023-08-29 02:09:35', '2023-09-02 01:49:49'),
('4ec3e5d9-a30c-4280-988a-548bd07b78f4', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":79,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"creo una nueva deteccion de necesidades\"}', '2023-08-31 11:44:45', '2023-08-29 03:23:27', '2023-08-31 11:44:45'),
('4f625b11-3044-4e85-b0c3-e761314bf55f', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:40', '2023-08-23 21:53:26', '2023-08-31 04:10:40'),
('544b1fef-3d50-4446-83ef-f1bfccc2495c', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:38', '2023-08-23 21:53:50', '2023-08-31 04:10:38'),
('56d5c2b4-b8ca-4cce-9125-90a30476ff9c', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:26', '2023-08-23 22:57:13', '2023-09-02 01:50:26'),
('5b8fa932-22cb-4d66-8e45-c4e22f6da041', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:18', '2023-08-23 23:59:22', '2023-09-02 01:50:18'),
('61872dad-e83a-490e-812c-23ceb87d36c8', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":78,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:15', '2023-08-29 02:12:32', '2023-08-31 04:10:15'),
('67fc9cc6-ce44-4db1-b1f8-43f1fdbb4486', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Edito la deteccion de necesidades\"}', '2023-09-04 16:16:13', '2023-08-23 13:01:52', '2023-09-04 16:16:13'),
('6a45db6f-64ba-4532-b660-a95d98dd741c', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":null,\"id\":76,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Se ha creado una nueva deteccion de necesidades\"}', '2023-08-23 12:42:18', '2023-08-23 06:02:43', '2023-08-23 12:42:18'),
('6a8aa33d-deb4-498a-ac6c-d0319b7c83f6', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:23', '2023-08-24 00:27:53', '2023-08-31 04:10:23'),
('6c567cbd-41c2-4f31-94d4-85e21ed42922', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":78,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-04 16:16:11', '2023-09-02 14:57:41', '2023-09-04 16:16:11'),
('6c7ab0a1-d337-45f7-aea7-20c7f7fb0943', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-23 12:44:07', '2023-08-23 11:28:58', '2023-08-23 12:44:07'),
('7112903a-4618-407f-96b1-da7b29d5fdd4', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:41', '2023-08-23 13:54:31', '2023-08-31 04:10:41'),
('72c08d2d-1205-4b62-b8b1-838fa66aa90d', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":69,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-08-07 13:26:10', '2023-08-07 13:25:22', '2023-08-07 13:26:10'),
('75cdda9c-df00-4872-8068-165bba397cf9', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:47', '2023-08-23 12:47:45', '2023-08-31 04:10:47'),
('78a9bba3-2c59-475f-9244-25a2be6ebc11', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:28', '2023-08-23 22:55:02', '2023-09-02 01:50:28'),
('794e620a-589e-48f6-81b9-dc2b0d722729', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":78,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-09-04 16:13:26', '2023-09-02 14:56:01', '2023-09-04 16:13:26'),
('7a8a18e6-c775-4947-8068-016d95dfdff7', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:11', '2023-08-24 00:04:03', '2023-09-02 01:50:11'),
('7e74d6fd-d412-45c8-b5f2-73654155e807', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":77,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"creo una nueva deteccion de necesidades\"}', '2023-09-02 01:50:00', '2023-08-26 15:07:22', '2023-09-02 01:50:00'),
('875c05e5-bea6-4036-beab-d5eab5ef2d6f', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":85,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"creo una nueva deteccion de necesidades\"}', NULL, '2023-09-05 02:35:27', '2023-09-05 02:35:27'),
('8c339bdb-65ae-4c99-8e8c-55a4a3a54c26', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":76,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-23 12:44:00', '2023-08-23 11:21:57', '2023-08-23 12:44:00'),
('90f10f8e-617e-43fc-b5e1-9ee51cf3c3bb', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":81,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"creo una nueva deteccion de necesidades\"}', '2023-09-04 16:16:09', '2023-09-04 15:20:16', '2023-09-04 16:16:09'),
('916eafe1-6623-46fc-9b09-1b6bee423acc', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":76,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-23 12:44:03', '2023-08-23 11:22:16', '2023-08-23 12:44:03'),
('92adb9a3-b674-43eb-8344-92163943bd1b', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"cformacion@tuxtla.tecnm.mx\",\"id\":73,\"route\":\"\\/academicos\\/curso\\/inscritos\",\"messegue\":\"El curso se ha aceptado\"}', '2023-08-23 00:56:29', '2023-08-10 09:42:35', '2023-08-23 00:56:29'),
('9ac83596-7a52-44ec-8a0e-c2477499052a', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:23', '2023-08-23 23:00:35', '2023-09-02 01:50:23'),
('9f27f056-1615-4254-b635-9c9b6fcf58c7', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:44', '2023-08-23 13:09:22', '2023-08-31 04:10:44'),
('9fbe461f-c5e0-4e2f-9b12-3ace2b26fe2f', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:31', '2023-08-23 22:53:58', '2023-09-02 01:50:31'),
('a18d6970-5a20-46b2-91da-c56bd6da22f6', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:08', '2023-08-24 00:11:38', '2023-09-02 01:50:08'),
('a1c4e865-a844-4bec-a08d-a1c821b61dd8', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":70,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Se ha creado una nueva deteccion de necesidades\"}', '2023-08-10 09:25:56', '2023-08-10 09:19:50', '2023-08-10 09:25:56'),
('a5e6c924-1488-4266-bf32-fc573e7716d6', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":82,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"creo una nueva deteccion de necesidades\"}', '2023-09-04 16:16:09', '2023-09-04 15:36:09', '2023-09-04 16:16:09'),
('a7dc0f6a-bf4b-4743-bf3a-af628984cb37', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":73,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Se ha creado una nueva deteccion de necesidades\"}', '2023-08-10 09:46:20', '2023-08-10 09:42:16', '2023-08-10 09:46:20'),
('a98e6ca9-ac15-4951-bc29-914294bbafdd', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":78,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-04 16:16:10', '2023-09-02 15:17:58', '2023-09-04 16:16:10'),
('b228151c-ef01-40da-91e5-4486bda24be3', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"cformacion@tuxtla.tecnm.mx\",\"id\":75,\"route\":\"\\/academicos\\/curso\\/inscritos\",\"messegue\":\"El curso se ha aceptado\"}', '2023-08-31 04:10:18', '2023-08-26 15:25:10', '2023-08-31 04:10:18'),
('b2c1f915-817b-4ccf-9a53-7c1fa45751f6', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"cformacion@tuxtla.tecnm.mx\",\"id\":71,\"route\":\"\\/academicos\\/cursos\",\"messegue\":\"El curso se ha aceptado\"}', '2023-08-10 09:39:13', '2023-08-10 09:26:00', '2023-08-10 09:39:13'),
('b7d122b1-cae0-478d-bf14-9aebbb7a308e', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:36', '2023-08-23 21:54:10', '2023-08-31 04:10:36'),
('b98aaeb4-a70a-454b-b355-404e268dff8d', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"cformacion@tuxtla.tecnm.mx\",\"id\":72,\"route\":\"\\/academicos\\/curso\\/inscritos\\/\",\"messegue\":\"El curso se ha aceptado\"}', '2023-08-10 09:41:28', '2023-08-10 09:40:43', '2023-08-10 09:41:28'),
('bd75d6da-bbcc-46b5-9973-041278f9fa4e', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":82,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-04 16:16:08', '2023-09-04 16:15:37', '2023-09-04 16:16:08'),
('be285990-6554-436b-808c-59789640631d', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:30', '2023-08-23 22:53:36', '2023-08-31 04:10:30'),
('bee43515-e749-4b47-80a5-ad61e2b623a8', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:14', '2023-08-24 00:03:31', '2023-09-02 01:50:14'),
('c4d190cc-9ec0-486d-b697-52c7af23863a', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"cformacion@tuxtla.tecnm.mx\",\"id\":81,\"route\":\"\\/academicos\\/curso\\/inscritos\",\"messegue\":\"El curso se ha aceptado\"}', '2023-09-04 16:11:42', '2023-09-04 15:39:33', '2023-09-04 16:11:42'),
('c53c5d71-67e3-466d-be81-65998767ef58', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":77,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:22', '2023-08-26 15:09:04', '2023-08-31 04:10:22'),
('c5aac0a7-bc20-43ed-bd01-10852d174e70', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":82,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-09-04 16:13:25', '2023-09-04 15:41:52', '2023-09-04 16:13:25'),
('c749ed7d-071e-4667-8744-2136312729a8', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:38', '2023-08-23 22:38:18', '2023-09-02 01:50:38'),
('caa2d3da-4c37-49ef-8d42-7623049d7a69', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:45', '2023-08-23 13:05:38', '2023-08-31 04:10:45'),
('cbd6de64-9a10-4fdf-9385-5fee29ab43c1', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":69,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Se ha creado una nueva deteccion de necesidades\"}', '2023-08-07 13:19:08', '2023-08-07 12:49:11', '2023-08-07 13:19:08'),
('cc3bad33-fd46-482a-b032-c301e44d0ab7', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":78,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:13', '2023-08-29 02:15:39', '2023-08-31 04:10:13'),
('cca2f2ea-ef8b-4661-aaf3-aec6ef41e6da', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:41', '2023-08-23 22:37:30', '2023-09-02 01:50:41'),
('cd125be4-7ae7-40d5-9cc7-a85831065ab1', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":80,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"creo una nueva deteccion de necesidades\"}', '2023-09-02 01:49:43', '2023-09-01 02:02:11', '2023-09-02 01:49:43'),
('cd84a130-a871-4781-917e-7954e86ecdf1', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":83,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"creo una nueva deteccion de necesidades\"}', '2023-09-04 18:26:19', '2023-09-04 16:37:38', '2023-09-04 18:26:19'),
('d053706d-f37a-46e4-aaf4-b0b11711b98a', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:33', '2023-08-23 22:53:16', '2023-09-02 01:50:33'),
('d07f0421-f293-480c-9aa0-ed16ba5069fa', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:28', '2023-08-23 22:55:49', '2023-08-31 04:10:28'),
('d227e869-2953-4070-9e24-fce0780f073f', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":77,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:49:58', '2023-08-26 15:10:32', '2023-09-02 01:49:58'),
('ddcf3368-c2b9-4f92-8e02-1835660e02d4', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":null,\"id\":75,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Se ha creado una nueva deteccion de necesidades\"}', '2023-09-04 16:16:14', '2023-08-23 00:54:23', '2023-09-04 16:16:14'),
('df08bb2f-472f-436d-b5bf-5d7ec66a12aa', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":69,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Edito la deteccion de necesidades\"}', '2023-08-10 09:11:07', '2023-08-07 13:27:13', '2023-08-10 09:11:07'),
('e14b4045-fe30-4554-89f5-2828f29792f7', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":78,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"creo una nueva deteccion de necesidades\"}', '2023-09-02 01:49:52', '2023-08-29 02:01:46', '2023-09-02 01:49:52'),
('e3b03312-2aba-47cb-8c0b-7bc78084fbc2', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":82,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-09-04 16:11:38', '2023-09-04 15:43:39', '2023-09-04 16:11:38'),
('e42e5c3d-e59a-4a9c-9ff5-0e9ab9d48204', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:03', '2023-08-24 00:13:17', '2023-09-02 01:50:03'),
('e54726a8-22f6-4ba4-90af-aded975d967e', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:05', '2023-08-24 00:13:02', '2023-09-02 01:50:05'),
('ea77682a-cdbf-4790-bd9c-69b8aea9a293', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"cformacion@tuxtla.tecnm.mx\",\"id\":80,\"route\":\"\\/academicos\\/curso\\/inscritos\",\"messegue\":\"El curso se ha aceptado\"}', '2023-09-04 16:13:27', '2023-09-02 14:50:22', '2023-09-04 16:13:27'),
('eb765299-fbd3-4103-8eda-fbc8722e642a', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"cformacion@tuxtla.tecnm.mx\",\"id\":77,\"route\":\"\\/academicos\\/curso\\/inscritos\",\"messegue\":\"El curso se ha aceptado\"}', '2023-08-31 04:10:19', '2023-08-26 15:22:57', '2023-08-31 04:10:19'),
('ee924548-5eb8-4aa9-acbb-f3ea0d449fe6', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-02 01:50:36', '2023-08-23 22:52:21', '2023-09-02 01:50:36'),
('ef9a5b75-cc72-45a5-a4e4-0f7a9525cff9', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":78,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:16', '2023-08-29 02:02:57', '2023-08-31 04:10:16'),
('f01d9932-4810-4a61-9c58-fbbe8b73dbf4', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":69,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-10 09:24:52', '2023-08-07 13:26:40', '2023-08-10 09:24:52'),
('f39ed76c-0bf6-4f21-ac1b-2621b2dd8ad1', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":75,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-04 16:16:12', '2023-08-23 13:08:17', '2023-09-04 16:16:12'),
('f42b8d09-e4b9-4fa1-a615-dc279ae52cef', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":80,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-09-04 16:16:12', '2023-09-02 02:26:07', '2023-09-04 16:16:12'),
('f70f1ef5-138a-447d-9fec-24ec59123330', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:34', '2023-08-23 21:55:04', '2023-08-31 04:10:34'),
('fc17637e-d07d-4dfd-a204-800f4d9cffcb', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/academicos\\/cursos\",\"messegue\":\"El curso se ha aceptado\"}', '2023-08-10 09:24:51', '2023-08-10 09:22:34', '2023-08-10 09:24:51'),
('fefb3097-d139-4cd4-909f-49776f648390', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":75,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-31 04:10:48', '2023-08-23 12:44:18', '2023-08-31 04:10:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('l17270705@tuxtla.tecnm.mx', '$2y$10$3bv.KuuPBLFbbB/9qXRK5OTHLOqcfLbohsUKjIG7KJIQBFZEvgis2', '2023-08-23 23:11:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posgrado`
--

CREATE TABLE `posgrado` (
  `id` bigint NOT NULL,
  `nombre` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `posgrado`
--

INSERT INTO `posgrado` (`id`, `nombre`) VALUES
(1, 'LICENCIATURA'),
(2, 'MAESTRIA'),
(3, 'DOCTORADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesto`
--

CREATE TABLE `puesto` (
  `id` bigint NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `puesto`
--

INSERT INTO `puesto` (`id`, `nombre`) VALUES
(1, 'ADMINISTRATIVO'),
(2, 'JEFE DE DEPARTAMENTO'),
(3, 'DOCENTE'),
(4, 'DIRECTOR'),
(5, 'SUBDIRECCIÓN DE PLANEACIÓN Y VINCULACIÓN'),
(7, 'SUBDIRECCIÓN DE SERVICIOS ADMINISTRATIVOS'),
(8, 'AUXILIAR ADMINISTRATIVO'),
(9, 'SUBDIRECCIÓN ACADÉMICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Jefe del Departamento de Desarrollo Academico', 'web', '2023-02-21 23:43:51', '2023-02-21 23:43:51'),
(2, 'Coordinacion de FD y AP', 'web', '2023-02-21 23:43:54', '2023-02-21 23:43:54'),
(3, 'Jefes Academicos', 'web', '2023-02-21 23:43:59', '2023-02-21 23:43:59'),
(4, 'Docentes', 'web', '2023-02-21 23:44:03', '2023-02-21 23:44:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_plaza`
--

CREATE TABLE `tipo_plaza` (
  `id` bigint NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_plaza`
--

INSERT INTO `tipo_plaza` (`id`, `nombre`) VALUES
(1, 'Directivo'),
(2, 'Docente / Interinato'),
(3, 'Honorarios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docente_id` bigint DEFAULT NULL,
  `role` bigint NOT NULL,
  `departamento_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `docente_id`, `role`, `departamento_id`, `created_at`, `updated_at`) VALUES
(2, NULL, 'sistemas@tuxtla.tecnm.mx', NULL, '$2y$10$SQWcjmohQTsAzvRsMAtpMeM240qQQIb8Y4XOqQzDTNDt/s.6cIRsW', NULL, 415, 3, 7, '2023-07-19 12:52:28', '2023-09-04 12:31:15'),
(5, NULL, 'cformacion@tuxtla.tecnm.mx', NULL, '$2y$10$EniwEJeEOB3xbUY/l3PHeuiZrKSttlp535d0ksqZcLb5jRM5LTJuC', NULL, NULL, 2, 2, '2023-07-31 12:28:26', '2023-07-31 12:28:26'),
(7, NULL, 'l17270705@tuxtla.tecnm.mx', NULL, '$2y$10$JRnzeWbTsUenjoT4Rm1QlunYD2h0Hf0BvMwoSXK1AH5l2wa8t9hqa', NULL, 413, 4, 7, '2023-08-31 12:06:20', '2023-09-04 02:52:26'),
(8, NULL, 'dda_tgutierrez@tecnm.mx', NULL, '$2y$10$2cZ6le6lCG2XMDbKDdtTae7rdaJvYYANYXkLdiBMVkKDmRcPszLdO', NULL, 414, 1, 1, '2023-09-04 12:21:41', '2023-09-04 12:24:09');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carreras_jefe_departamento_foreign` (`jefe_departamento`),
  ADD KEY `carreras_presidente_academia_foreign` (`presidente_academia`),
  ADD KEY `carreras_departamento_id_foreign` (`departamento_id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dirigido` (`dirigido`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departamento_jefe_id_foreign` (`jefe_id`);

--
-- Indices de la tabla `deteccion_has_facilitadores`
--
ALTER TABLE `deteccion_has_facilitadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deteccion_has_facilitadores_deteccion_id_foreign` (`deteccion_id`),
  ADD KEY `deteccion_has_facilitadores_docente_id_foreign` (`docente_id`);

--
-- Indices de la tabla `deteccion_necesidades`
--
ALTER TABLE `deteccion_necesidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jefe_id_foreign` (`id_jefe`),
  ADD KEY `carrera_id_foreign` (`carrera_dirigido`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Docente_Puesto1_idx` (`id_puesto`),
  ADD KEY `fk_Docente_Nivel1_idx` (`licenciatura`),
  ADD KEY `fk_Docente_Departamento1_idx` (`departamento_id`),
  ADD KEY `fk_docente_carrera1_idx` (`carrera_id`),
  ADD KEY `fk_docente_posgrado1_idx` (`id_posgrado`),
  ADD KEY `fk_docente_tipoPlaza` (`tipo_plaza`),
  ADD KEY `user_id_foreign` (`user_id`);
ALTER TABLE `docente` ADD FULLTEXT KEY `nombre` (`nombre`,`apellidoPat`,`apellidoMat`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lugar`
--
ALTER TABLE `lugar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `posgrado`
--
ALTER TABLE `posgrado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `puesto`
--
ALTER TABLE `puesto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `tipo_plaza`
--
ALTER TABLE `tipo_plaza`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `deteccion_has_facilitadores`
--
ALTER TABLE `deteccion_has_facilitadores`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `deteccion_necesidades`
--
ALTER TABLE `deteccion_necesidades`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=416;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `lugar`
--
ALTER TABLE `lugar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
