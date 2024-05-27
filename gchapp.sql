-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2024 a las 13:21:30
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
-- Base de datos: `gchapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros_horas`
--

CREATE TABLE `registros_horas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hora` datetime NOT NULL,
  `comentario` varchar(255) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registros_horas`
--

INSERT INTO `registros_horas` (`id`, `user_id`, `hora`, `comentario`, `latitude`, `longitude`) VALUES
(1, 13, '2024-05-27 10:28:47', 'Inicio de jornada', 37.292928, -4.8825466),
(2, 13, '2024-05-27 10:28:56', 'Inicio de jornada', 37.292928, -4.8825466),
(3, 13, '2024-05-27 10:51:16', 'Inicio de jornada', 37.292928, -4.8825466),
(4, 13, '2024-05-27 10:52:01', 'Inicio de jornada', 37.292928, -4.8825466),
(5, 13, '2024-05-27 11:05:48', 'Inicio de jornada', 37.292928, -4.8825466),
(6, 13, '2024-05-27 11:06:34', 'Inicio de jornada', 37.292928, -4.8825466),
(7, 13, '2024-05-27 11:10:31', 'Inicio de jornada', 37.292928, -4.8825466),
(8, 13, '2024-05-27 11:12:26', 'Inicio de jornada', 37.292928, -4.8825466),
(9, 13, '2024-05-27 11:24:48', 'Inicio de jornada', 37.292928, -4.8825466),
(10, 13, '2024-05-27 12:04:10', 'Inicio de jornada', 37.292928, -4.8825466),
(11, 13, '2024-05-27 12:04:31', 'Pausa por Cita medica', 37.292928, -4.8825466),
(12, 13, '2024-05-27 12:04:34', 'Inicio de jornada', 37.292928, -4.8825466),
(13, 13, '2024-05-27 12:04:42', 'Pausa por cita medica', 37.292928, -4.8825466),
(14, 13, '2024-05-27 12:04:44', 'Parada', 37.292928, -4.8825466),
(15, 13, '2024-05-27 12:05:02', 'Inicio de jornada', 37.292928, -4.8825466),
(16, 13, '2024-05-27 12:05:21', 'Pausa por mercadona', 37.292928, -4.8825466),
(17, 13, '2024-05-27 12:05:24', 'Inicio de jornada', 37.292928, -4.8825466),
(18, 13, '2024-05-27 12:05:27', 'Parada', 37.292928, -4.8825466),
(19, 13, '2024-05-27 12:12:31', 'Inicio de jornada', 37.292928, -4.8825466),
(20, 13, '2024-05-27 12:12:43', 'Pausa iniciada - Motivo: llamada de la naturaleza', 37.292928, -4.8825466),
(21, 13, '2024-05-27 12:13:55', 'Inicio de jornada', 37.292928, -4.8825466),
(22, 13, '2024-05-27 12:14:05', 'Pausa iniciada - Motivo: llamada de la naturaleza', 37.292928, -4.8825466),
(23, 13, '2024-05-27 12:14:07', 'Fin de pausa - Motivo: Fin de pausa: 27/5/2024, 12:14:07', 37.292928, -4.8825466),
(24, 13, '2024-05-27 12:14:13', 'Inicio de jornada', 37.292928, -4.8825466),
(25, 13, '2024-05-27 12:14:16', 'Fin de jornada', 37.292928, -4.8825466),
(26, 13, '2024-05-27 12:14:17', 'Inicio de jornada', 37.292928, -4.8825466),
(27, 13, '2024-05-27 12:14:19', 'Pausa iniciada - Motivo: asdds', 37.292928, -4.8825466),
(28, 13, '2024-05-27 12:14:20', 'Fin de pausa - Motivo: Fin de pausa: 27/5/2024, 12:14:20', 37.292928, -4.8825466),
(29, 13, '2024-05-27 12:19:31', 'Inicio de jornada', 37.292928, -4.8825466),
(30, 13, '2024-05-27 12:19:41', 'Pausa iniciada - Motivo: Voy a comprar cafe', 37.292928, -4.8825466),
(31, 13, '2024-05-27 12:19:43', 'Fin de pausa - Motivo: Fin de la pausa', 37.292928, -4.8825466),
(32, 13, '2024-05-27 12:19:54', 'Inicio de jornada', 37.292928, -4.8825466),
(33, 13, '2024-05-27 12:19:57', 'Fin de jornada', 37.292928, -4.8825466),
(34, 13, '2024-05-27 12:20:40', 'Inicio de jornada', 37.292928, -4.8825466),
(35, 13, '2024-05-27 12:21:05', 'Inicio de jornada', 37.292928, -4.8825466),
(36, 13, '2024-05-27 12:21:42', 'Inicio de jornada', 37.292928, -4.8825466),
(37, 13, '2024-05-27 12:28:04', 'Inicio de jornada', 37.292928, -4.8825466),
(38, 13, '2024-05-27 12:28:16', 'Pausa iniciada - Motivo: voy a exar gasoil', 37.292928, -4.8825466),
(39, 13, '2024-05-27 12:30:07', 'Inicio de jornada', 37.292928, -4.8825466),
(40, 13, '2024-05-27 12:30:12', 'Pausa iniciada - Motivo: a por bellotas', 37.292928, -4.8825466),
(41, 13, '2024-05-27 12:30:50', 'Inicio de jornada', 37.292928, -4.8825466),
(42, 13, '2024-05-27 12:31:10', 'Pausa iniciada - Motivo: a por pan', 37.292928, -4.8825466),
(43, 13, '2024-05-27 12:32:51', 'Inicio de jornada', 37.292928, -4.8825466),
(44, 13, '2024-05-27 12:33:38', 'Inicio de jornada', 37.292928, -4.8825466),
(45, 13, '2024-05-27 12:34:57', 'Inicio de jornada', 37.292928, -4.8825466),
(46, 13, '2024-05-27 12:36:48', 'Inicio de jornada', 37.292928, -4.8825466),
(47, 13, '2024-05-27 12:38:28', 'Inicio de jornada', 37.292928, -4.8825466),
(48, 13, '2024-05-27 12:51:18', 'Inicio de jornada', 37.292928, -4.8825466),
(49, 13, '2024-05-27 12:51:40', 'Pausa iniciada - Motivo: a por chicles', 37.292928, -4.8825466),
(50, 13, '2024-05-27 12:52:22', 'Fin de jornada', 37.292928, -4.8825466),
(51, 13, '2024-05-27 13:01:50', 'Inicio de jornada', 37.292928, -4.8825466),
(52, 13, '2024-05-27 13:02:03', 'Pausa iniciada - Motivo: tengo el avion mal aparcado', 37.292928, -4.8825466),
(53, 13, '2024-05-27 13:02:12', 'Fin de jornada', 37.292928, -4.8825466),
(54, 13, '2024-05-27 13:03:13', 'Inicio de jornada', 37.292928, -4.8825466),
(55, 13, '2024-05-27 13:03:21', 'Inicio de jornada', 37.292928, -4.8825466),
(56, 13, '2024-05-27 13:03:28', 'Pausa iniciada - Motivo: me hago caca', 37.292928, -4.8825466),
(57, 13, '2024-05-27 13:03:37', 'Fin de jornada', 37.292928, -4.8825466),
(58, 13, '2024-05-27 13:05:02', 'Inicio de jornada', 37.292928, -4.8825466),
(59, 13, '2024-05-27 13:05:15', 'Pausa iniciada - Motivo: hol hola vecinito', 37.292928, -4.8825466),
(60, 13, '2024-05-27 13:05:25', 'Fin de jornada', 37.292928, -4.8825466),
(61, 13, '2024-05-27 13:20:19', 'Inicio de jornada', 37.292928, -4.8825466),
(62, 13, '2024-05-27 13:20:28', 'Pausa iniciada - Motivo: a por coca cola', 37.292928, -4.8825466),
(63, 13, '2024-05-27 13:20:37', 'Fin de jornada', 37.292928, -4.8825466);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'Webmaster'),
(2, 'Encargado'),
(3, 'Empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role_id`) VALUES
(1, 'juanca', 'juanca@gchapp.es', '$2y$10$.WvvSsGuzOjPl3WJ0wwIRecfXHXYH8yWEYSrI3eikQVeAwAHLfyoG', '2024-05-23 18:10:16', NULL),
(9, 'encargado2', 'encargado2@gechapp.es', '$2y$10$m7Beys2nyRy/1CZwFaZt.uxOUBoaX33LUMDzB6AXJnpqTn8DhpOOO', '2024-05-24 11:44:08', 2),
(10, 'webmaster2', 'webmaster2@gechapp.es4', '$2y$10$HUt4NXR3zc5sFai6YI1VQeSvk4QfiJbun5UmV0WgNYWQ17rSBjUe.', '2024-05-24 16:04:42', 1),
(11, 'webmaster3', 'webmaster3@gechapp.es', '$2y$10$ehB4O01oiffi3HZiwdOdvuXQ2QTCdOCJdFehTZ7YdykSwBMcbmAgO', '2024-05-24 16:14:07', 1),
(13, 'webmaster', 'webmaster@gechapp.es', '$2y$10$YuT0twiEd9YNiX.pLdNuyOhEWlozcqZNBV9W1eBT/y/JQ8Uk3u0FW', '2024-05-24 16:24:26', 1),
(14, 'juanca3', 'juancastp@gmail.com6', '$2y$10$THD3AXbO3MKvTZpM9fKv/O/xm2psdJECCZ3SzvkgqFbuqaPbAB3/.', '2024-05-24 16:24:59', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `registros_horas`
--
ALTER TABLE `registros_horas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_role` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `registros_horas`
--
ALTER TABLE `registros_horas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
