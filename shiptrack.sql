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

-- Dumping data for table shiptrack.items: ~2 rows (approximately)
INSERT INTO `items` (`id`, `name`, `weight`, `category`, `type`) VALUES
	(1, 'TV Samsung', '12', 'Elektronik', 'CARGO'),
	(2, 'Dress Pengantin', '10', 'Pakaian', 'REG'),
	(3, 'Sertifikat', '1', 'Lainnya', 'DOCUMENT');

-- Dumping data for table shiptrack.receivers: ~2 rows (approximately)
INSERT INTO `receivers` (`id`, `name`, `phone`, `address`, `city`) VALUES
	(1, 'Asep', '083746473673', 'jln pakutandang no 20', 'Kota Bandung');

-- Dumping data for table shiptrack.senders: ~2 rows (approximately)
INSERT INTO `senders` (`id`, `name`, `phone`, `address`, `city`) VALUES
	(1, 'Jamaludin', '0881023747287', 'jln perjuangan no 30', 'Kota Cirebon');

-- Dumping data for table shiptrack.shipments: ~1 rows (approximately)
INSERT INTO `shipments` (`id`, `tracking_number`, `item_id`, `sender_id`, `receiver_id`, `status`, `proof_image`, `shipping_cost`) VALUES
	(1, 'PR-K5Q72KZHPMRC', 1, 1, 1, 'Diterima', 'proof_1764691403.png', 144000),
	(2, 'PR-1HT80D59BQJZ', 2, 1, 1, 'Proses', NULL, 100000),
	(3, 'PR-AFB4W7HO9IBR', 3, 1, 1, 'Proses', NULL, 8000);

-- Dumping data for table shiptrack.shipment_assignments: ~1 rows (approximately)
INSERT INTO `shipment_assignments` (`id`, `shipment_id`, `courier_id`, `assigned_at`) VALUES
	(1, 1, 5, '2025-12-02 15:50:58'),
	(2, 2, 6, '2025-12-02 16:07:40'),
	(3, 3, 5, '2025-12-02 16:07:48');

-- Dumping data for table shiptrack.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `name`, `role`, `username`, `password`) VALUES
	(1, 'Admin', 'admin', 'admin', '$2y$10$vVlCf5LqJQwAJ/kU66uyoOnT0cQAl8wQ/BP.Yhrp0/rf4GKVj5puC'),
	(4, 'Muhamad Adriansyah Suryawan', 'admin', 'adrian', '$2y$10$8Suv/0cDhH3jaHTAz6d/jOJrXZImxmos/TeEUZ6hMLzvFcSHqGroC'),
	(5, 'Haikal Dwiki Akbar', 'courier', 'haikal', '$2y$10$JUczt4BzsZHoWFqgccVJoeuWMbQEV3lil4p3WCDIYlOGLWfB.GTLa'),
	(6, 'Aldin', 'courier', 'aldin', '$2y$10$C/HdFxxarYiLnEHa85ua5Oii56NmfpSCvVdarvj7fCKdR6h2CL2Ye');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
