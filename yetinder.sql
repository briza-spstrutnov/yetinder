-- --------------------------------------------------------
-- Hostitel:                     127.0.0.1
-- Verze serveru:                10.7.4-MariaDB - mariadb.org binary distribution
-- OS serveru:                   Win64
-- HeidiSQL Verze:               11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Exportování dat pro tabulku yetinder.doctrine_migration_versions: ~6 rows (přibližně)
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20220523080414', '2022-05-23 08:06:42', 29),
	('DoctrineMigrations\\Version20220523110923', '2022-05-23 11:10:30', 25),
	('DoctrineMigrations\\Version20220524081114', '2022-05-24 08:11:28', 185),
	('DoctrineMigrations\\Version20220524090318', '2022-05-24 09:03:27', 18),
	('DoctrineMigrations\\Version20220525055724', '2022-05-25 05:58:35', 39),
	('DoctrineMigrations\\Version20220525055807', '2022-05-25 05:58:35', 1);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;

-- Exportování dat pro tabulku yetinder.time_click: ~4 rows (přibližně)
/*!40000 ALTER TABLE `time_click` DISABLE KEYS */;
INSERT INTO `time_click` (`id`, `time`, `clicks`, `day_time`, `end_time`) VALUES
	(6, '06:00:00', 14, 'morning', '11:59:59'),
	(7, '12:00:00', 12, 'afternoon', '17:59:59'),
	(8, '18:00:00', 4, 'evening', '23:59:59'),
	(9, '00:00:00', 2, 'night', '05:59:59');
/*!40000 ALTER TABLE `time_click` ENABLE KEYS */;

-- Exportování dat pro tabulku yetinder.user: ~3 rows (přibližně)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `password`) VALUES
	(7, 'test1', '$2y$13$IpQT9QpFh20XQ7tdOEbgCOSAQzgfWBlLkBHUUlYRTAdEvwS1hhurC'),
	(8, 'test2', '$2y$13$D6d1F0DPPu2djjRdllfEH.60zBzUlelAdi2PHDy2t8ImRzmlHHRUS'),
	(9, 'test3', '$2y$13$1ArRSt5I7ycKLGAdeRG.o.FNFWEv2YoZCuGmNxkr8i3ws3XsAn89S');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Exportování dat pro tabulku yetinder.user_yeti: ~22 rows (přibližně)
/*!40000 ALTER TABLE `user_yeti` DISABLE KEYS */;
INSERT INTO `user_yeti` (`user_id`, `yeti_id`) VALUES
	(7, 23),
	(7, 24),
	(7, 25),
	(7, 26),
	(7, 27),
	(8, 23),
	(8, 24),
	(8, 25),
	(8, 26),
	(8, 27),
	(8, 28),
	(8, 29),
	(8, 30),
	(8, 31),
	(8, 32),
	(8, 33),
	(8, 34),
	(8, 35),
	(9, 23),
	(9, 24),
	(9, 27),
	(9, 28);
/*!40000 ALTER TABLE `user_yeti` ENABLE KEYS */;

-- Exportování dat pro tabulku yetinder.yeti: ~14 rows (přibližně)
/*!40000 ALTER TABLE `yeti` DISABLE KEYS */;
INSERT INTO `yeti` (`id`, `name`, `gender`, `height`, `weight`, `rating`, `phone_number`) VALUES
	(23, 'yeti1', 'Male', 190, 90, 101, '000 000 000'),
	(24, 'yeti2', 'Male', 180, 80, 103, '111 111 111'),
	(25, 'yeti3', 'Male', 160, 60, 102, '222 222 222'),
	(26, 'yeti4', 'Male', 160, 60, 102, '222 222 222'),
	(27, 'yeti5', 'Male', 160, 60, 104, '55555555'),
	(28, 'yeti8', 'Male', 150, 50, 100, '55555'),
	(29, 'yeti9', 'Male', 130, 30, 101, '555'),
	(30, 'yeti6', 'Male', 150, 50, 101, '205665161'),
	(31, 'yeti18', 'Female', 135, 41, 101, '6581984161'),
	(32, 'yeti15', 'Female', 205, 56, 101, '651698416516'),
	(33, 'yeti20', 'Male', 89, 41, 101, '61984106854165'),
	(34, 'asfdhgas', 'Male', 61569, 651, 101, '65169851'),
	(35, 'oasdng', 'Female', 916851, 651, 99, '651'),
	(36, 'asdasd', 'Male', 150, 34, 100, '168516981');
/*!40000 ALTER TABLE `yeti` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
