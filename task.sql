-- --------------------------------------------------------
-- Hôte :                        192.168.56.56
-- Version du serveur:           8.0.28-0ubuntu0.20.04.3 - (Ubuntu)
-- SE du serveur:                Linux
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour fintech
DROP DATABASE IF EXISTS `fintech`;
CREATE DATABASE IF NOT EXISTS `fintech` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `fintech`;

-- Listage de la structure de la table fintech. tasks
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
                                       `id` int unsigned NOT NULL AUTO_INCREMENT,
                                       `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                       `command` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                       `parameters` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                       `expression` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                       `timezone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UTC',
                                       `is_active` tinyint(1) NOT NULL DEFAULT '1',
                                       `dont_overlap` tinyint(1) NOT NULL DEFAULT '0',
                                       `run_in_maintenance` tinyint(1) NOT NULL DEFAULT '0',
                                       `notification_email_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                       `notification_phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                       `notification_slack_webhook` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                       `created_at` timestamp NULL DEFAULT NULL,
                                       `updated_at` timestamp NULL DEFAULT NULL,
                                       `auto_cleanup_num` int NOT NULL DEFAULT '0',
                                       `auto_cleanup_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                       `run_on_one_server` tinyint(1) NOT NULL DEFAULT '0',
                                       `run_in_background` tinyint(1) NOT NULL DEFAULT '0',
                                       PRIMARY KEY (`id`),
                                       KEY `tasks_is_active_idx` (`is_active`),
                                       KEY `tasks_dont_overlap_idx` (`dont_overlap`),
                                       KEY `tasks_run_in_maintenance_idx` (`run_in_maintenance`),
                                       KEY `tasks_run_on_one_server_idx` (`run_on_one_server`),
                                       KEY `tasks_auto_cleanup_num_idx` (`auto_cleanup_num`),
                                       KEY `tasks_auto_cleanup_type_idx` (`auto_cleanup_type`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table fintech.tasks : ~0 rows (environ)
DELETE FROM `tasks`;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`id`, `description`, `command`, `parameters`, `expression`, `timezone`, `is_active`, `dont_overlap`, `run_in_maintenance`, `notification_email_address`, `notification_phone_number`, `notification_slack_webhook`, `created_at`, `updated_at`, `auto_cleanup_num`, `auto_cleanup_type`, `run_on_one_server`, `run_in_background`) VALUES
(1, 'Accepte automatiquement les prélèvement Créditeur toute les heures', 'system:execute', 'call=autoAcceptCreditPrlv', NULL, 'Europe/Paris', 1, 0, 0, NULL, NULL, NULL, '2022-06-13 20:59:11', '2022-06-13 20:59:11', 0, 'days', 0, 0),
(2, 'Passe tous les pret ouvert en étude', 'system:execute', 'call=verifRequestLoanOpen', NULL, 'Europe/Paris', 1, 0, 0, NULL, NULL, NULL, '2022-06-13 20:59:52', '2022-06-13 20:59:52', 0, 'days', 0, 0),
(3, 'Effectue le virement du montant des pret accordées', 'system:execute', 'call=acceptedLoanCharge', NULL, 'Europe/Paris', 1, 0, 0, NULL, NULL, NULL, '2022-06-13 21:00:26', '2022-06-13 21:00:26', 0, 'days', 0, 0),
(4, 'Initialise tous les prélèvements à effectuer sur les comptes épargne', 'system:execute', 'call=initPrlvCptEpargne', NULL, 'Europe/Paris', 1, 0, 0, NULL, NULL, NULL, '2022-06-13 21:01:09', '2022-06-13 21:01:09', 0, 'days', 0, 0),
(5, 'Initialise tous les prélèvements à effectuer sur les comptes de pret', 'system:execute', 'call=initPrlvCptPret', NULL, 'Europe/Paris', 1, 0, 0, NULL, NULL, NULL, '2022-06-13 21:01:44', '2022-06-13 21:01:44', 0, 'days', 0, 0),
(6, 'Exécute tous les ordres de prélèvement sépa journalier', 'system:execute', 'call=executeSepaOrderDay', NULL, 'Europe/Paris', 1, 0, 0, NULL, NULL, NULL, '2022-06-13 21:02:17', '2022-06-13 21:02:17', 0, 'days', 0, 0),
(7, 'Création de nouveau client', 'life', 'call=generateCustomer', NULL, 'Europe/Paris', 1, 0, 0, NULL, NULL, NULL, '2022-06-13 21:02:40', '2022-06-13 21:02:40', 0, 'days', 0, 0);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

-- Listage de la structure de la table fintech. task_frequencies
DROP TABLE IF EXISTS `task_frequencies`;
CREATE TABLE IF NOT EXISTS `task_frequencies` (
                                                  `id` int unsigned NOT NULL AUTO_INCREMENT,
                                                  `task_id` int unsigned NOT NULL,
                                                  `label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                                  `interval` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                                  `created_at` timestamp NULL DEFAULT NULL,
                                                  `updated_at` timestamp NULL DEFAULT NULL,
                                                  PRIMARY KEY (`id`),
                                                  KEY `task_frequencies_task_id_idx` (`task_id`),
                                                  CONSTRAINT `task_frequencies_task_id_fk` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table fintech.task_frequencies : ~0 rows (environ)
DELETE FROM `task_frequencies`;
/*!40000 ALTER TABLE `task_frequencies` DISABLE KEYS */;
INSERT INTO `task_frequencies` (`id`, `task_id`, `label`, `interval`, `created_at`, `updated_at`) VALUES
(1, 1, 'Hourly', 'hourly', '2022-06-13 20:59:11', '2022-06-13 20:59:11'),
(2, 2, 'Daily at', 'dailyAt', '2022-06-13 20:59:52', '2022-06-13 20:59:52'),
(3, 3, 'Daily at', 'dailyAt', '2022-06-13 21:00:26', '2022-06-13 21:00:26'),
(4, 4, 'Daily at', 'dailyAt', '2022-06-13 21:01:09', '2022-06-13 21:01:09'),
(5, 5, 'Daily at', 'dailyAt', '2022-06-13 21:01:44', '2022-06-13 21:01:44'),
(6, 6, 'Daily', 'daily', '2022-06-13 21:02:17', '2022-06-13 21:02:17'),
(7, 7, 'Every Minute', 'everyMinute', '2022-06-13 21:02:40', '2022-06-13 21:02:40');
/*!40000 ALTER TABLE `task_frequencies` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
