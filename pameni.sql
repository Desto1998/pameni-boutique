-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour pameni
CREATE DATABASE IF NOT EXISTS `pameni` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `pameni`;

-- Listage de la structure de la table pameni. admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(5000) NOT NULL DEFAULT '',
  `motdepasse` text NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT 'pameni@gmail.com',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Pour les utilisateurs';

-- Listage des données de la table pameni.admin : ~0 rows (environ)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Listage de la structure de la table pameni. categories
CREATE TABLE IF NOT EXISTS `categories` (
  `idcat` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(5000) NOT NULL DEFAULT '',
  `description_cat` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcat`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Pour les catgories de produits';

-- Listage des données de la table pameni.categories : ~7 rows (environ)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
REPLACE INTO `categories` (`idcat`, `titre`, `description_cat`, `created_at`, `updated_at`) VALUES
	(1, 'Ordinateur portable 1212', 'hhgdfg fgfgdfgfg', '2022-07-19 10:31:37', '2022-07-19 10:33:16'),
	(3, 'Ordinateur HP', 'tukykll', '2022-07-19 10:34:05', '2022-07-19 10:34:05'),
	(4, 'Peinture mixte', 'fsfsdggsdg', '2022-07-19 10:37:29', '2022-07-19 10:37:29'),
	(5, 'Peinture interieurs', 'Peinture externe', '2022-07-19 10:38:08', '2022-07-19 10:38:08'),
	(6, 'Peinture exterieur', 'Peinture du dehors', '2022-07-19 10:38:35', '2022-07-19 10:38:35'),
	(7, 'Peinture interieurs2122', 'noioppoiop', '2022-07-19 10:41:02', '2022-07-19 10:41:02'),
	(8, 'testffg', 'dssdfsdfdf', '2022-07-19 10:45:07', '2022-07-19 10:45:07');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Listage de la structure de la table pameni. clients
CREATE TABLE IF NOT EXISTS `clients` (
  `idclient` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tel` varchar(20) NOT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `date_ajout` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idclient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table pameni.clients : ~0 rows (environ)
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;

-- Listage de la structure de la table pameni. commandes
CREATE TABLE IF NOT EXISTS `commandes` (
  `idcommande` int(11) NOT NULL AUTO_INCREMENT,
  `date_com` date NOT NULL,
  `idclient` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcommande`),
  KEY `FK__client` (`idclient`),
  CONSTRAINT `FK__client` FOREIGN KEY (`idclient`) REFERENCES `clients` (`idclient`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table pameni.commandes : ~0 rows (environ)
/*!40000 ALTER TABLE `commandes` DISABLE KEYS */;
/*!40000 ALTER TABLE `commandes` ENABLE KEYS */;

-- Listage de la structure de la table pameni. contient
CREATE TABLE IF NOT EXISTS `contient` (
  `idcontient` int(11) NOT NULL AUTO_INCREMENT,
  `qte` int(11) NOT NULL,
  `prix` float NOT NULL,
  `idproduit` int(10) unsigned NOT NULL,
  `idcommande` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcontient`),
  KEY `FK__contientproduits` (`idproduit`),
  KEY `FK__contientcommande` (`idcommande`),
  CONSTRAINT `FK__contientcommande` FOREIGN KEY (`idcommande`) REFERENCES `commandes` (`idcommande`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK__contientproduits` FOREIGN KEY (`idproduit`) REFERENCES `produits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table pameni.contient : ~0 rows (environ)
/*!40000 ALTER TABLE `contient` DISABLE KEYS */;
/*!40000 ALTER TABLE `contient` ENABLE KEYS */;

-- Listage de la structure de la table pameni. failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pameni.failed_jobs : ~0 rows (environ)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Listage de la structure de la table pameni. images
CREATE TABLE IF NOT EXISTS `images` (
  `idimg` int(11) NOT NULL AUTO_INCREMENT,
  `chemin` varchar(5000) DEFAULT NULL,
  `idp` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idimg`) USING BTREE,
  KEY `FK__produits` (`idp`) USING BTREE,
  CONSTRAINT `FK__produits` FOREIGN KEY (`idp`) REFERENCES `produits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 CHECKSUM=1 COMMENT='Pour les images des produits';

-- Listage des données de la table pameni.images : ~3 rows (environ)
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
REPLACE INTO `images` (`idimg`, `chemin`, `idp`, `created_at`, `updated_at`) VALUES
	(4, 'https://decorexpro.com/images/article/orig/2018/01/chem-otlichayutsya-lateksnye-i-akrilovye-kraski-2.jpg', 1, '2022-07-19 11:53:49', '2022-07-19 11:53:49'),
	(5, 'https://decorexpro.com/images/article/orig/2018/01/chem-otlichayutsya-lateksnye-i-akrilovye-kraski-2.jpg', 1, '2022-07-19 11:53:49', '2022-07-19 11:53:49'),
	(6, 'https://decorexpro.com/images/article/orig/2018/01/chem-otlichayutsya-lateksnye-i-akrilovye-kraski-2.jpg', 1, '2022-07-19 11:53:49', '2022-07-19 11:53:49');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;

-- Listage de la structure de la table pameni. menus
CREATE TABLE IF NOT EXISTS `menus` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(11) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Listage des données de la table pameni.menus : ~12 rows (environ)
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
REPLACE INTO `menus` (`menu_id`, `position`, `code`, `label`, `description`) VALUES
	(1, 0, 'US', 'Gestion des uilisateurs', 'Menue gestion des utilisateurs, possibilité de créer, modifier et consulter la liste des utilisateurs'),
	(2, 1, 'DE', 'Devis', 'Créer une proformat, gestion des proformats'),
	(3, 2, 'FA', 'Factures', 'Créer une facture, gérer les factures, effectuer les règlements sur les factures'),
	(4, 3, 'CA', 'Commandes', 'Créer un bon de commande, gérer les bons de commandes, mettre les produits du bon de commande en stock'),
	(5, 4, 'CL', 'Clients', 'Gestion des clients : ajouter, éditer ; supprimer et voir les détails d\'un client '),
	(6, 5, 'FR', 'Fournisseurs', 'Gestion des fournisseurs : ajouter, éditer ; supprimer et voir les détails d\'un fournisseur'),
	(7, 6, 'PR', 'Produits', 'Gestion des produits, enregistrer les produits, éditer un produit.'),
	(8, 7, 'GEC', 'Gestions', 'Gestion des charges et des dépenses de l\'entreprise'),
	(9, 8, 'GER', 'Rapports', 'Impression des différents rapports'),
	(10, -1, 'NT', 'Notifications', 'Voir les notifications'),
	(11, 9, 'GCA', 'Caisses', 'Pour le gestion de la caisse'),
	(12, 11, 'DIV', 'Divers', 'Menu divers pour les factures, devis avec produits entree manuellement');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;

-- Listage de la structure de la table pameni. migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pameni.migrations : ~5 rows (environ)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2022_03_03_081950_roles_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Listage de la structure de la table pameni. password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pameni.password_resets : ~27 rows (environ)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
REPLACE INTO `password_resets` (`email`, `token`, `created_at`) VALUES
	('desto237@gmail.com', 'dgwBe9d6aGvamrRl96tiWtrZNiPhIV8U0E75qfjK2qlwHqw7LN4VcOs4Yxjm', '2022-04-04 10:04:14'),
	('desto237@gmail.com', 'BMDRljPmCumUNYrulZE6TRRSLkz6CcaYjHf6ALFRZSmbgo9f7xNgQuGHcoTJ', '2022-04-04 10:04:44'),
	('desto237@gmail.com', 'okGUJ5adeXqrtfUyca8BYGR3ZqFFuqRC6WFJP1i9AMfMSi2E4IV8ddcDtQzg', '2022-04-04 10:04:02'),
	('desto237@gmail.com', 'VoKcKyBwB0TPhZXH4JCCneTxgrAxuCHZUbyiIHCmA67tuAPsYBBDng4113Ve', '2022-04-04 10:04:20'),
	('desto237@gmail.com', '9xJ0I1xlAyJZTzaOfmZgnFGii8FDPvzSDCj8J34XLHAR6geeUbhpZ1QUKwJo', '2022-04-04 10:04:02'),
	('desto237@gmail.com', 'zqegQeRWkaEH6QlEm5DyiRwnTCPHpV7kZD3triUdWBRaLmuDxngeNpRA3Mid', '2022-04-11 09:04:57'),
	('desto237@gmail.com', 'NYKJ1rIdywFcLH8loapLEy71Any36gNQ2zBB9mfhiyC81D2JS5UhU2pBGYbJ', '2022-04-11 09:04:09'),
	('desto237@gmail.com', 'XH033hTl5dggpBrbJ2QbBcgsSmW8dSKzhokKGGWXUE4nkM97UvenrnjXlcmH', '2022-04-11 13:04:36'),
	('desto237@gmail.com', 'FzkypMWaH3NuCQwHDQkOj5dFS9gt7fjcgmXIdZq8G3zAe81u7ueWxSlxg65J', '2022-04-11 13:04:49'),
	('desto237@gmail.com', 'dgwBe9d6aGvamrRl96tiWtrZNiPhIV8U0E75qfjK2qlwHqw7LN4VcOs4Yxjm', '2022-04-04 10:04:14'),
	('desto237@gmail.com', 'BMDRljPmCumUNYrulZE6TRRSLkz6CcaYjHf6ALFRZSmbgo9f7xNgQuGHcoTJ', '2022-04-04 10:04:44'),
	('desto237@gmail.com', 'okGUJ5adeXqrtfUyca8BYGR3ZqFFuqRC6WFJP1i9AMfMSi2E4IV8ddcDtQzg', '2022-04-04 10:04:02'),
	('desto237@gmail.com', 'VoKcKyBwB0TPhZXH4JCCneTxgrAxuCHZUbyiIHCmA67tuAPsYBBDng4113Ve', '2022-04-04 10:04:20'),
	('desto237@gmail.com', '9xJ0I1xlAyJZTzaOfmZgnFGii8FDPvzSDCj8J34XLHAR6geeUbhpZ1QUKwJo', '2022-04-04 10:04:02'),
	('desto237@gmail.com', 'zqegQeRWkaEH6QlEm5DyiRwnTCPHpV7kZD3triUdWBRaLmuDxngeNpRA3Mid', '2022-04-11 09:04:57'),
	('desto237@gmail.com', 'NYKJ1rIdywFcLH8loapLEy71Any36gNQ2zBB9mfhiyC81D2JS5UhU2pBGYbJ', '2022-04-11 09:04:09'),
	('desto237@gmail.com', 'XH033hTl5dggpBrbJ2QbBcgsSmW8dSKzhokKGGWXUE4nkM97UvenrnjXlcmH', '2022-04-11 13:04:36'),
	('desto237@gmail.com', 'FzkypMWaH3NuCQwHDQkOj5dFS9gt7fjcgmXIdZq8G3zAe81u7ueWxSlxg65J', '2022-04-11 13:04:49'),
	('desto237@gmail.com', 'dgwBe9d6aGvamrRl96tiWtrZNiPhIV8U0E75qfjK2qlwHqw7LN4VcOs4Yxjm', '2022-04-04 10:04:14'),
	('desto237@gmail.com', 'BMDRljPmCumUNYrulZE6TRRSLkz6CcaYjHf6ALFRZSmbgo9f7xNgQuGHcoTJ', '2022-04-04 10:04:44'),
	('desto237@gmail.com', 'okGUJ5adeXqrtfUyca8BYGR3ZqFFuqRC6WFJP1i9AMfMSi2E4IV8ddcDtQzg', '2022-04-04 10:04:02'),
	('desto237@gmail.com', 'VoKcKyBwB0TPhZXH4JCCneTxgrAxuCHZUbyiIHCmA67tuAPsYBBDng4113Ve', '2022-04-04 10:04:20'),
	('desto237@gmail.com', '9xJ0I1xlAyJZTzaOfmZgnFGii8FDPvzSDCj8J34XLHAR6geeUbhpZ1QUKwJo', '2022-04-04 10:04:02'),
	('desto237@gmail.com', 'zqegQeRWkaEH6QlEm5DyiRwnTCPHpV7kZD3triUdWBRaLmuDxngeNpRA3Mid', '2022-04-11 09:04:57'),
	('desto237@gmail.com', 'NYKJ1rIdywFcLH8loapLEy71Any36gNQ2zBB9mfhiyC81D2JS5UhU2pBGYbJ', '2022-04-11 09:04:09'),
	('desto237@gmail.com', 'XH033hTl5dggpBrbJ2QbBcgsSmW8dSKzhokKGGWXUE4nkM97UvenrnjXlcmH', '2022-04-11 13:04:36'),
	('desto237@gmail.com', 'FzkypMWaH3NuCQwHDQkOj5dFS9gt7fjcgmXIdZq8G3zAe81u7ueWxSlxg65J', '2022-04-11 13:04:49');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Listage de la structure de la table pameni. personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pameni.personal_access_tokens : ~0 rows (environ)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Listage de la structure de la table pameni. produits
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(5000) NOT NULL DEFAULT '',
  `quantite` int(10) unsigned NOT NULL,
  `prix` float NOT NULL DEFAULT '0',
  `description` text,
  `image` text,
  `idcat` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK__categories` (`idcat`),
  CONSTRAINT `FK__categories` FOREIGN KEY (`idcat`) REFERENCES `categories` (`idcat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Pour les produits';

-- Listage des données de la table pameni.produits : ~1 rows (environ)
/*!40000 ALTER TABLE `produits` DISABLE KEYS */;
REPLACE INTO `produits` (`id`, `nom`, `quantite`, `prix`, `description`, `image`, `idcat`, `created_at`, `updated_at`) VALUES
	(1, 'wdqwewqe', 4, 45, 'kknkln; knm; ;k;k', 'https://decorexpro.com/images/article/orig/2018/01/chem-otlichayutsya-lateksnye-i-akrilovye-kraski-2.jpg', 5, '2022-07-19 11:31:54', '2022-07-19 11:53:49');
/*!40000 ALTER TABLE `produits` ENABLE KEYS */;

-- Listage de la structure de la table pameni. roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pameni.roles : ~2 rows (environ)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
REPLACE INTO `roles` (`id`, `title`) VALUES
	(1, 'administrateur'),
	(2, 'Utilisateur');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Listage de la structure de la table pameni. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_active` int(11) NOT NULL DEFAULT '0',
  `is_admin` int(11) NOT NULL DEFAULT '0',
  `idrole` bigint(20) unsigned NOT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pameni.users : ~7 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `firstname`, `lastname`, `email`, `email_verified_at`, `password`, `remember_token`, `adresse`, `phone`, `is_active`, `is_admin`, `idrole`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'super', 'admin@gmail.com', NULL, '$2y$10$qAEOxT/9I.eUG8RRzvf20.qvE6iVPCR9wYzeeXlx3an9ZcYQjoJz6', NULL, 'logpom', '679353205', 1, 1, 1, 'WIN_20220302_13_53_42_Pro.jpg', NULL, '2022-04-01 11:29:32'),
	(2, 'Desto', 'super text', 'desto237@gmail.com', NULL, '$2y$10$hbuqg51nxRgtZPLCbANN2.Fo1wz1VIhgy2O4B6QsiIQEtiCfxZCxW', NULL, 'logpom', '679353205', 1, 1, 1, NULL, NULL, NULL),
	(3, 'admin', 'simple', 'admin2@gmail.com', NULL, '$2y$10$v46Zo4sNFpJbaJf6XCbnze0WzQi7VuSAH7E7e5XYjTT.e47kZniTe', NULL, 'Makepe', '660041366', 1, 1, 1, NULL, NULL, NULL),
	(4, 'admin 1', 'simple 1', 'admin1@gmail.com', NULL, '$2y$10$HZg4ZVXt4ZmdinCv5OKZaOxgrTefsH1JK94p0pmV3Te94tvahNWBq', NULL, 'Makepe', '660041366', 0, 1, 1, NULL, NULL, NULL),
	(5, 'user', 'user 1', 'user1@gmail.com', NULL, '$2y$10$1hXPw6eBpqsZDiyWTCkvH.YGkqrAAoFdmjV5/0otJ9yMqLQuOwsEq', NULL, 'Douala', '660041366', 1, 0, 2, 'cachet_gsc.png', NULL, '2022-04-01 11:44:34'),
	(6, 'user', 'user 2', 'user2@gmail.com', NULL, '$2y$10$QauFOfDueR.Xfl2Kvia8PO6AiC4ZRTMr.4rOiqnBPjVsFxlalN7su', NULL, 'Douala', '660041366', 0, 0, 2, NULL, NULL, NULL),
	(7, 'user', 'user 3', 'user3@gmail.com', NULL, '$2y$10$Atbq6Mw75vnlMU/CYKo0P.BLv1TPkwxfnsDV4hJUHiSoYjRPnwA3.', NULL, 'Douala', '660041366', 1, 0, 2, NULL, NULL, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Listage de la structure de la table pameni. user_menus
CREATE TABLE IF NOT EXISTS `user_menus` (
  `user_menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `idmenu` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_menu_id`),
  KEY `idmenu` (`idmenu`),
  CONSTRAINT `user_menus_ibfk_1` FOREIGN KEY (`idmenu`) REFERENCES `menus` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

-- Listage des données de la table pameni.user_menus : ~33 rows (environ)
/*!40000 ALTER TABLE `user_menus` DISABLE KEYS */;
REPLACE INTO `user_menus` (`user_menu_id`, `idmenu`, `userid`, `iduser`, `created_at`, `updated_at`) VALUES
	(13, 1, 2, 1, '2022-04-04 12:14:31', '2022-04-04 12:14:31'),
	(14, 2, 2, 1, '2022-04-04 12:14:31', '2022-04-04 12:14:31'),
	(15, 3, 2, 1, '2022-04-04 12:14:31', '2022-04-04 12:14:31'),
	(16, 4, 2, 1, '2022-04-04 12:14:31', '2022-04-04 12:14:31'),
	(17, 8, 2, 1, '2022-04-04 12:14:31', '2022-04-04 12:14:31'),
	(18, 9, 2, 1, '2022-04-04 12:14:31', '2022-04-04 12:14:31'),
	(19, 10, 2, 1, '2022-04-04 12:14:31', '2022-04-04 12:14:31'),
	(30, 2, 6, 1, '2022-04-04 15:55:42', '2022-04-04 15:55:42'),
	(31, 3, 6, 1, '2022-04-04 15:55:43', '2022-04-04 15:55:43'),
	(32, 4, 6, 1, '2022-04-04 15:55:43', '2022-04-04 15:55:43'),
	(33, 6, 6, 1, '2022-04-04 15:55:43', '2022-04-04 15:55:43'),
	(43, 2, 5, 1, '2022-04-05 15:50:48', '2022-04-05 15:50:48'),
	(44, 3, 5, 1, '2022-04-05 15:50:48', '2022-04-05 15:50:48'),
	(45, 4, 5, 1, '2022-04-05 15:50:48', '2022-04-05 15:50:48'),
	(46, 5, 5, 1, '2022-04-05 15:50:48', '2022-04-05 15:50:48'),
	(47, 6, 5, 1, '2022-04-05 15:50:48', '2022-04-05 15:50:48'),
	(48, 7, 5, 1, '2022-04-05 15:50:48', '2022-04-05 15:50:48'),
	(49, 8, 5, 1, '2022-04-05 15:50:48', '2022-04-05 15:50:48'),
	(50, 9, 5, 1, '2022-04-05 15:50:48', '2022-04-05 15:50:48'),
	(51, 10, 5, 1, '2022-04-05 15:50:48', '2022-04-05 15:50:48'),
	(52, 11, 5, 1, '2022-04-05 15:50:48', '2022-04-05 15:50:48'),
	(64, 1, 1, 1, '2022-05-30 08:53:58', '2022-05-30 08:53:58'),
	(65, 2, 1, 1, '2022-05-30 08:53:58', '2022-05-30 08:53:58'),
	(66, 3, 1, 1, '2022-05-30 08:53:58', '2022-05-30 08:53:58'),
	(67, 4, 1, 1, '2022-05-30 08:53:58', '2022-05-30 08:53:58'),
	(68, 5, 1, 1, '2022-05-30 08:53:58', '2022-05-30 08:53:58'),
	(69, 6, 1, 1, '2022-05-30 08:53:58', '2022-05-30 08:53:58'),
	(70, 7, 1, 1, '2022-05-30 08:53:58', '2022-05-30 08:53:58'),
	(71, 8, 1, 1, '2022-05-30 08:53:59', '2022-05-30 08:53:59'),
	(72, 9, 1, 1, '2022-05-30 08:53:59', '2022-05-30 08:53:59'),
	(73, 10, 1, 1, '2022-05-30 08:53:59', '2022-05-30 08:53:59'),
	(74, 11, 1, 1, '2022-05-30 08:53:59', '2022-05-30 08:53:59'),
	(75, 12, 1, 1, '2022-05-30 08:53:59', '2022-05-30 08:53:59');
/*!40000 ALTER TABLE `user_menus` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
