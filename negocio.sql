-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 16-05-2025 a las 10:43:58
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `negocio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `fecha_creacion`, `estado`) VALUES
(1, 'Monitor', 'Monitor Acer 100ips', '2025-05-15 00:54:52', 1),
(2, 'Teclado', 'Teclado Redragon', '2025-05-15 05:00:00', 1),
(3, 'Teclado2', 'fsdfs', '2025-05-15 05:00:00', 1),
(4, 'Teclado4', 'asdfgsg', '2025-05-15 05:00:00', 1),
(5, 'prueba155', 'adfaf', '2025-05-15 21:31:47', 0),
(6, 'prueba155', 'adfaf', '2025-05-15 21:33:43', 1),
(7, 'prueba13445', 'asfaf', '2025-05-15 21:33:53', 1),
(8, 'afaf', 'afafas', '2025-05-15 21:35:32', 1),
(9, 'dhdhd', 'dhdfh', '2025-05-15 21:36:29', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sale_id` int NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `reference_number` varchar(100) DEFAULT NULL,
  `card_number` varchar(20) DEFAULT NULL,
  `cardholder_name` varchar(100) DEFAULT NULL,
  `card_expiry` varchar(7) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_number` varchar(30) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'completed',
  `amount_tendered` decimal(10,2) DEFAULT NULL,
  `change` decimal(10,2) DEFAULT NULL,
  `installments` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `category_id` int NOT NULL,
  `provider_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_category` (`category_id`),
  KEY `fk_provider` (`provider_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `name`, `description`, `price`, `stock`, `category_id`, `provider_id`, `created_at`, `updated_at`) VALUES
(1, 'Teclado Redragon k128', 'Teclado Mecánico switch rojos', 176000.00, 55, 2, 1, '2025-05-15 18:01:51', '2025-05-15 23:59:20'),
(2, 'Monitor LG 24\'\'', '', 200000.00, 7, 1, 2, '2025-05-15 21:18:33', '2025-05-15 23:59:20'),
(3, 'Monitor Lenovo 75hz', '', 135000.00, 20, 1, 1, '2025-05-15 22:09:17', '2025-05-15 22:09:17'),
(4, 'Producto Ejemplo', '', 20000.00, 97, 5, 2, '2025-05-15 23:19:54', '2025-05-15 23:59:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

DROP TABLE IF EXISTS `promociones`;
CREATE TABLE IF NOT EXISTS `promociones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `discount_percent` decimal(5,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`id`, `product_id`, `discount_percent`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(2, 2, 20.00, '2025-05-15', '2025-05-31', '2025-05-15 21:22:03', '2025-05-15 21:22:03'),
(3, 1, 10.00, '2025-05-15', '2025-05-27', '2025-05-15 22:03:27', '2025-05-15 22:03:27'),
(4, 3, 5.00, '2025-05-15', '2025-05-16', '2025-05-15 22:09:49', '2025-05-15 22:09:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE IF NOT EXISTS `proveedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `name`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Kevin Morelo Negrette', 'kmorelo89@gmail.com', '3114079342', 'Montelibano B/Paraiso', '2025-05-15 17:44:43', '2025-05-15 17:46:35'),
(2, 'Felix Morelo', 'fmorelo@hotmail.com', '3126861550', 'Montelibano', '2025-05-15 21:17:42', '2025-05-15 21:17:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `total` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_details` text,
  `status` varchar(20) DEFAULT 'pending',
  `user_id` int NOT NULL,
  `shipping_name` varchar(100) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `sales`
--

INSERT INTO `sales` (`id`, `total`, `payment_method`, `payment_details`, `status`, `user_id`, `shipping_name`, `shipping_address`, `shipping_city`, `shipping_phone`, `created_at`, `updated_at`) VALUES
(1, 704000.00, 'efectivo', '{\"cash_received\":\"\"}', 'pendiente', 1, '', '', '', '', '2025-05-15 19:27:41', '2025-05-15 19:27:41'),
(2, 704000.00, 'efectivo', '{\"cash_received\":\"\"}', 'pendiente', 1, '', '', '', '', '2025-05-15 19:32:34', '2025-05-15 19:32:34'),
(3, 352000.00, 'efectivo', '{\"cash_received\":\"\"}', 'pendiente', 1, '', '', '', '', '2025-05-15 19:32:42', '2025-05-15 19:32:42'),
(4, 352000.00, 'efectivo', '{\"cash_received\":\"\"}', 'pendiente', 1, '', '', '', '', '2025-05-15 19:32:45', '2025-05-15 19:32:45'),
(5, 352000.00, 'efectivo', '{\"cash_received\":\"\"}', 'pendiente', 1, '', '', '', '', '2025-05-15 19:33:11', '2025-05-15 19:33:11'),
(6, 352000.00, 'efectivo', '{\"cash_received\":\"\"}', 'pendiente', 1, '', '', '', '', '2025-05-15 19:33:20', '2025-05-15 19:33:20'),
(7, 704000.00, 'transferencia', '{\"bank\":\"banco1\",\"reference_number\":\"237457347\"}', 'pendiente', 1, 'Kevin Jose Morelo Negrette', 'Calle 23 #65-50', 'Monteria', '3126861550', '2025-05-15 19:33:46', '2025-05-15 19:33:46'),
(8, 352000.00, 'efectivo', '{\"cash_received\":\"400000\"}', 'pendiente', 1, 'Kevin Jose Morelo Negrette', 'Calle 23 #65-50', 'Montelibano', '3114079342', '2025-05-15 20:19:45', '2025-05-15 20:19:45'),
(9, 176000.00, 'transferencia', '{', 'pendiente', 1, '0', 'Calle 42', 'Monteria', '3126861550', '2025-05-15 20:50:39', '2025-05-15 21:43:12'),
(11, 0.00, 'efectivo', '{\"cash_received\":\"140000\"}', 'pendiente', 1, 'Felix Morelo', 'Calle 42', 'Monteria', '3126861550', '2025-05-15 22:54:40', '2025-05-15 22:54:40'),
(10, 576000.00, 'efectivo', '{', 'pendiente', 1, '0', 'Calle 41', 'Purisima', '3126861550', '2025-05-15 21:19:26', '2025-05-15 21:42:02'),
(12, 0.00, 'efectivo', '{\"cash_received\":\"200000\"}', 'pendiente', 1, '', '', '', '', '2025-05-15 22:55:17', '2025-05-15 22:55:17'),
(13, 0.00, 'efectivo', '{\"cash_received\":\"200000\"}', 'pendiente', 1, '', '', '', '', '2025-05-15 22:57:59', '2025-05-15 22:57:59'),
(14, 0.00, 'efectivo', '{\"cash_received\":\"200000\"}', 'pendiente', 1, '', '', '', '', '2025-05-15 22:58:11', '2025-05-15 22:58:11'),
(15, 0.00, 'efectivo', '{\"cash_received\":\"200000\"}', 'pendiente', 1, '', '', '', '', '2025-05-15 22:58:17', '2025-05-15 22:58:17'),
(16, 0.00, 'efectivo', '{\"cash_received\":\"200000\"}', 'pendiente', 1, '', '', '', '', '2025-05-15 22:58:44', '2025-05-15 22:58:44'),
(17, 200000.00, 'efectivo', '{\"cash_received\":\"200000\"}', 'pendiente', 1, '', '', '', '', '2025-05-15 22:59:44', '2025-05-15 22:59:44'),
(18, 2000000.00, 'tarjeta_debito', '{\"card_number\":\"1234123412341234\",\"card_holder\":\"Andres Martinez\"}', 'pendiente', 1, 'Andres Martinez', 'calle 2344', 'Magangue', '312535663', '2025-05-15 23:20:45', '2025-05-15 23:20:45'),
(19, 636000.00, 'efectivo', '{\"cash_received\":\"650000\"}', 'Completada', 1, 'Nelly Rivera', 'Calle 1290 #120', 'Lorica', '1349049042', '2025-05-15 23:59:20', '2025-05-15 23:59:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale_product`
--

DROP TABLE IF EXISTS `sale_product`;
CREATE TABLE IF NOT EXISTS `sale_product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sale_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_sale` (`sale_id`),
  KEY `fk_product` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `sale_product`
--

INSERT INTO `sale_product` (`id`, `sale_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 2, 176000.00, '2025-05-15 19:33:11', '2025-05-15 19:33:11'),
(2, 6, 1, 2, 176000.00, '2025-05-15 19:33:20', '2025-05-15 19:33:20'),
(3, 7, 1, 4, 176000.00, '2025-05-15 19:33:46', '2025-05-15 19:33:46'),
(4, 8, 1, 2, 176000.00, '2025-05-15 20:19:45', '2025-05-15 20:19:45'),
(5, 9, 1, 1, 176000.00, '2025-05-15 20:50:39', '2025-05-15 20:50:39'),
(6, 10, 1, 1, 176000.00, '2025-05-15 21:19:26', '2025-05-15 21:19:26'),
(7, 10, 2, 2, 200000.00, '2025-05-15 21:19:26', '2025-05-15 21:19:26'),
(8, 17, 2, 1, 200000.00, '2025-05-15 22:59:44', '2025-05-15 22:59:44'),
(9, 18, 4, 100, 20000.00, '2025-05-15 23:20:45', '2025-05-15 23:20:45'),
(10, 19, 1, 1, 176000.00, '2025-05-15 23:59:20', '2025-05-15 23:59:20'),
(11, 19, 2, 2, 200000.00, '2025-05-15 23:59:20', '2025-05-15 23:59:20'),
(12, 19, 4, 3, 20000.00, '2025-05-15 23:59:20', '2025-05-15 23:59:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`) VALUES
(1, 'kevinmorelo', '$2y$10$0Rw3iIc5sP0.M3ZySJjqL.2KA9QgDJEG4fRWgtLarFhk7E4SOVc1m');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
