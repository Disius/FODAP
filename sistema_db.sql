-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-08-2023 a las 17:56:04
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
(7, 'Departamento de Sistemas y Computación', 408, NULL, NULL),
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
(26, 73, 408, NULL, NULL);

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
  `facilitador_externo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `obs` int DEFAULT NULL,
  `aceptado` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `deteccion_necesidades`
--

INSERT INTO `deteccion_necesidades` (`id`, `id_jefe`, `asignaturaFA`, `contenidosTM`, `numeroProfesores`, `periodo`, `carrera_dirigido`, `id_departamento`, `nombreCurso`, `tipo_FDoAP`, `tipo_actividad`, `fecha_I`, `fecha_F`, `hora_I`, `hora_F`, `total_horas`, `objetivoEvento`, `modalidad`, `facilitador_externo`, `observaciones`, `obs`, `aceptado`, `created_at`, `updated_at`) VALUES
(61, 408, 'Contabilidad financiera, cultura empresarial, gestion de proyectos de software, formulacion y evaluacion de proyectos', 'Todos', 20, 1, 2, 7, 'Principios de sistemas de informacion financiera', 1, 2, '2023-01-16', '2023-07-20', '08:00:00', '17:00:00', NULL, 'Conocer, analizar e interpretar la informacion financiera para la toma de decisiones empresariales.', 2, NULL, NULL, 0, 1, '2023-07-30 00:36:34', '2023-08-02 01:50:28'),
(69, 408, 'Asignatura', 'a', 12, 1, 2, NULL, 'a', 2, 2, '2023-07-30', '2023-08-23', '02:51:00', '03:52:00', NULL, 'Objetivo', 1, NULL, 'sigue mal', 1, 1, '2023-08-07 12:49:10', '2023-08-10 09:11:18'),
(70, 408, 'b', 'b', 12, 2, 2, NULL, 'b', 1, 3, '2023-08-09', '2023-08-30', '23:21:00', '13:23:00', NULL, 'b', 1, NULL, NULL, 0, 1, '2023-08-10 09:19:49', '2023-08-10 09:22:34'),
(71, 408, 'c', 'c', 12, 1, 2, NULL, 'c', 2, 3, '2023-08-14', '2023-08-30', '12:28:00', '12:28:00', NULL, 'c', 2, NULL, NULL, 0, 1, '2023-08-10 09:25:30', '2023-08-10 09:26:00'),
(72, 408, 'd', 'd', 12, 1, 2, NULL, 'd', 1, 2, '2023-08-09', '2023-08-29', '09:40:00', '23:42:00', NULL, 'd', 3, NULL, NULL, 0, 1, '2023-08-10 09:40:23', '2023-08-10 09:40:43'),
(73, 408, 'f', 'f', 12, 2, 2, NULL, 'f', 1, 2, '2023-08-09', '2023-08-15', '12:45:00', '23:44:00', NULL, 'f', 2, NULL, NULL, 0, 1, '2023-08-10 09:42:16', '2023-08-10 09:42:35');

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
  `id_nivel` bigint DEFAULT NULL,
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

INSERT INTO `docente` (`id`, `rfc`, `curp`, `nombre`, `apellidoPat`, `apellidoMat`, `sexo`, `telefono`, `interno`, `carrera_id`, `id_posgrado`, `id_puesto`, `clavePresup`, `horarioEntrada`, `horarioSalida`, `tipo_plaza`, `id_nivel`, `prodep`, `departamento_id`, `empresa`, `tipodecurso`, `user_id`, `created_at`, `updated_at`, `nombre_completo`) VALUES
(407, 'FEPD9908247J2', 'FEPD990824HCSRRN09', 'Salvador', 'Hernandez', 'Garduza', 1, '961-579-7102', NULL, 2, NULL, 2, NULL, NULL, NULL, 1, NULL, NULL, 2, NULL, NULL, NULL, '2023-07-26 09:45:10', '2023-07-26 09:46:10', NULL),
(408, 'FEPD9908247J2', 'FEPD990824HCSRRN09', 'Maria', 'Monjaras', 'Gutierrez', 2, '961-427-6822', NULL, 2, NULL, 2, NULL, NULL, NULL, 1, NULL, NULL, 7, NULL, NULL, 2, '2023-07-26 09:48:01', '2023-07-26 09:48:01', NULL),
(409, 'FEPD9908247J2', 'FEPD990824HCSRRN09', 'Daniel Eduardo', 'Fernandez', 'Perez', 1, '961-579-7102', NULL, 2, NULL, 3, NULL, NULL, NULL, 2, NULL, NULL, 7, NULL, NULL, 6, '2023-08-03 07:08:58', '2023-08-03 07:08:58', NULL);

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
(1, 61, 409, NULL, NULL);

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
(4, 'App\\Models\\User', 6);

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
('14ba31cb-c0a8-4f1a-9afe-45610760a717', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":69,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-10 09:24:54', '2023-08-07 13:24:23', '2023-08-10 09:24:54'),
('1be4dc84-5be9-47de-8ed0-5ae205de7790', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":72,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Se ha creado una nueva deteccion de necesidades\"}', '2023-08-10 09:46:22', '2023-08-10 09:40:23', '2023-08-10 09:46:22'),
('1f21e336-9748-4936-959d-fefef4e58500', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":71,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Se ha creado una nueva deteccion de necesidades\"}', '2023-08-10 09:46:24', '2023-08-10 09:25:31', '2023-08-10 09:46:24'),
('72c08d2d-1205-4b62-b8b1-838fa66aa90d', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":69,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"edito la deteccion de necesidades\"}', '2023-08-07 13:26:10', '2023-08-07 13:25:22', '2023-08-07 13:26:10'),
('92adb9a3-b674-43eb-8344-92163943bd1b', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"cformacion@tuxtla.tecnm.mx\",\"id\":73,\"route\":\"\\/academicos\\/curso\\/inscritos\",\"messegue\":\"El curso se ha aceptado\"}', NULL, '2023-08-10 09:42:35', '2023-08-10 09:42:35'),
('a1c4e865-a844-4bec-a08d-a1c821b61dd8', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":70,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Se ha creado una nueva deteccion de necesidades\"}', '2023-08-10 09:25:56', '2023-08-10 09:19:50', '2023-08-10 09:25:56'),
('a7dc0f6a-bf4b-4743-bf3a-af628984cb37', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":73,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Se ha creado una nueva deteccion de necesidades\"}', '2023-08-10 09:46:20', '2023-08-10 09:42:16', '2023-08-10 09:46:20'),
('b2c1f915-817b-4ccf-9a53-7c1fa45751f6', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"cformacion@tuxtla.tecnm.mx\",\"id\":71,\"route\":\"\\/academicos\\/cursos\",\"messegue\":\"El curso se ha aceptado\"}', '2023-08-10 09:39:13', '2023-08-10 09:26:00', '2023-08-10 09:39:13'),
('b98aaeb4-a70a-454b-b355-404e268dff8d', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"cformacion@tuxtla.tecnm.mx\",\"id\":72,\"route\":\"\\/academicos\\/curso\\/inscritos\\/\",\"messegue\":\"El curso se ha aceptado\"}', '2023-08-10 09:41:28', '2023-08-10 09:40:43', '2023-08-10 09:41:28'),
('cbd6de64-9a10-4fdf-9385-5fee29ab43c1', 'App\\Notifications\\NewDeteccionNotification', 'App\\Models\\User', 5, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":69,\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Se ha creado una nueva deteccion de necesidades\"}', '2023-08-07 13:19:08', '2023-08-07 12:49:11', '2023-08-07 13:19:08'),
('df08bb2f-472f-436d-b5bf-5d7ec66a12aa', 'App\\Notifications\\DeteccionEditadaNotification', 'App\\Models\\User', 5, '{\"id\":69,\"email\":\"sistemas@tuxtla.tecnm.mx\",\"route\":\"\\/coordinacion\\/detecciones\\/deteccion\",\"messegue\":\"Edito la deteccion de necesidades\"}', '2023-08-10 09:11:07', '2023-08-07 13:27:13', '2023-08-10 09:11:07'),
('f01d9932-4810-4a61-9c58-fbbe8b73dbf4', 'App\\Notifications\\ObservacionNotification', 'App\\Models\\User', 2, '{\"id\":69,\"email\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/deteccion\",\"messegue\":\"agrego una observacion\"}', '2023-08-10 09:24:52', '2023-08-07 13:26:40', '2023-08-10 09:24:52'),
('fc17637e-d07d-4dfd-a204-800f4d9cffcb', 'App\\Notifications\\AceptadoNotification', 'App\\Models\\User', 2, '{\"email\":\"sistemas@tuxtla.tecnm.mx\",\"id\":\"cformacion@tuxtla.tecnm.mx\",\"route\":\"\\/academicos\\/cursos\",\"messegue\":\"El curso se ha aceptado\"}', '2023-08-10 09:24:51', '2023-08-10 09:22:34', '2023-08-10 09:24:51');

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
(1, 'MAESTRÍA'),
(2, 'DOCTORADO');

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
(5, 'SUBDIRECCION'),
(6, 'COORDINADOR DE ACTUALIZACION'),
(7, 'CATEDRATICO'),
(8, 'AUXILIAR ADMINISTRATIVO'),
(9, 'JEFE DE LA OFICINA DE PROMOCION DEPORTIVA'),
(10, 'PROMOTOR CULTURAL'),
(11, 'PREFECTO');

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
(1, 'Base'),
(2, 'Honorarios'),
(3, 'Interinato');

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
(2, NULL, 'sistemas@tuxtla.tecnm.mx', NULL, '$2y$10$SQWcjmohQTsAzvRsMAtpMeM240qQQIb8Y4XOqQzDTNDt/s.6cIRsW', NULL, 408, 3, 7, '2023-07-19 12:52:28', '2023-07-26 09:48:01'),
(4, NULL, 'dda_tgutierrez@tuxtla.tecnm.mx', NULL, '$2y$10$NbZ6iSAGfUO.Al9xaUpjHOm9SWG12STSb/HLzjWhGJV/pqj9yankG', NULL, 407, 1, 2, '2023-07-25 13:42:21', '2023-07-26 09:45:10'),
(5, NULL, 'cformacion@tuxtla.tecnm.mx', NULL, '$2y$10$EniwEJeEOB3xbUY/l3PHeuiZrKSttlp535d0ksqZcLb5jRM5LTJuC', NULL, NULL, 2, 2, '2023-07-31 12:28:26', '2023-07-31 12:28:26'),
(6, NULL, 'l17270705@tuxtla.tecnm.mx', NULL, '$2y$10$dNXEzW2jzmBTul4Peh2ybe16D2E2fAd4V1vSuB1kpjYCRj4thHfbO', NULL, 409, 4, 7, '2023-08-03 07:08:02', '2023-08-03 07:08:58');

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
  ADD KEY `fk_Docente_Nivel1_idx` (`id_nivel`),
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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `deteccion_necesidades`
--
ALTER TABLE `deteccion_necesidades`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=410;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
