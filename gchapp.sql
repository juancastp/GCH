-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-05-2024 a las 20:38:14
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
