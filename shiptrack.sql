-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for shiptrack
CREATE DATABASE IF NOT EXISTS `shiptrack` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `shiptrack`;

-- Dumping structure for table shiptrack.items
CREATE TABLE IF NOT EXISTS `items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table shiptrack.items: ~3 rows (approximately)
INSERT INTO `items` (`id`, `name`, `weight`, `category`, `type`) VALUES
	(1, 'TV Samsung', '12', 'Elektronik', 'CARGO'),
	(2, 'Dress Pengantin', '10', 'Pakaian', 'REG'),
	(3, 'Sertifikat', '1', 'Lainnya', 'DOCUMENT');

-- Dumping structure for table shiptrack.receivers
CREATE TABLE IF NOT EXISTS `receivers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table shiptrack.receivers: ~1 rows (approximately)
INSERT INTO `receivers` (`id`, `name`, `phone`, `address`, `city`) VALUES
	(1, 'Asep', '083746473673', 'jln pakutandang no 20', 'Kota Bandung');

-- Dumping structure for table shiptrack.senders
CREATE TABLE IF NOT EXISTS `senders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table shiptrack.senders: ~1 rows (approximately)
INSERT INTO `senders` (`id`, `name`, `phone`, `address`, `city`) VALUES
	(1, 'Jamaludin', '0881023747287', 'jln perjuangan no 30', 'Kota Cirebon');

-- Dumping structure for table shiptrack.shipments
CREATE TABLE IF NOT EXISTS `shipments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tracking_number` varchar(255) NOT NULL,
  `item_id` int NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `status` varchar(255) NOT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  `shipping_cost` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tracking_number` (`tracking_number`,`item_id`,`sender_id`,`receiver_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table shiptrack.shipments: ~4 rows (approximately)
INSERT INTO `shipments` (`id`, `tracking_number`, `item_id`, `sender_id`, `receiver_id`, `status`, `proof_image`, `shipping_cost`, `created_at`) VALUES
	(1, 'PR-K5Q72KZHPMRC', 1, 1, 1, 'Diterima', 'proof_1764691403.png', 144000, '2025-12-07'),
	(2, 'PR-1HT80D59BQJZ', 2, 1, 1, 'Proses', NULL, 100000, '2025-12-07'),
	(3, 'PR-AFB4W7HO9IBR', 3, 1, 1, 'Proses', NULL, 8000, '2025-12-07'),
	(4, 'PR-48BGLSF9I3YR', 1, 1, 1, 'Proses', NULL, 144000, '2025-12-07');

-- Dumping structure for table shiptrack.shipment_assignments
CREATE TABLE IF NOT EXISTS `shipment_assignments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shipment_id` int NOT NULL,
  `courier_id` int NOT NULL,
  `assigned_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shipment_assignment_index` (`shipment_id`,`courier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table shiptrack.shipment_assignments: ~4 rows (approximately)
INSERT INTO `shipment_assignments` (`id`, `shipment_id`, `courier_id`, `assigned_at`) VALUES
	(1, 1, 5, '2025-12-02 15:50:58'),
	(2, 2, 6, '2025-12-02 16:07:40'),
	(3, 3, 5, '2025-12-02 16:07:48'),
	(4, 4, 5, '2025-12-07 12:16:57');

-- Dumping structure for table shiptrack.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table shiptrack.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `name`, `role`, `username`, `password`) VALUES
	(1, 'Admin', 'admin', 'admin', '$2y$10$vVlCf5LqJQwAJ/kU66uyoOnT0cQAl8wQ/BP.Yhrp0/rf4GKVj5puC'),
	(4, 'Muhamad Adriansyah Suryawan', 'admin', 'adrian', '$2y$10$8Suv/0cDhH3jaHTAz6d/jOJrXZImxmos/TeEUZ6hMLzvFcSHqGroC'),
	(5, 'Haikal Dwiki Akbar', 'courier', 'haikal', '$2y$10$SlbYdDNoRwSSSIqd1dPmBOWOpb84LT0WWgInNiBml8TP1RTS58w1q'),
	(6, 'Aldin', 'courier', 'aldin', '$2y$10$C/HdFxxarYiLnEHa85ua5Oii56NmfpSCvVdarvj7fCKdR6h2CL2Ye');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
