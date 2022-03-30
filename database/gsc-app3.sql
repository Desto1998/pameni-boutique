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


-- Listage de la structure de la base pour gsc-app
DROP DATABASE IF EXISTS `gsc-app`;
CREATE DATABASE IF NOT EXISTS `gsc-app` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `gsc-app`;

-- Listage de la structure de la table gsc-app. categories
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categorie_id` int(11) NOT NULL AUTO_INCREMENT,
  `titre_cat` varchar(255) NOT NULL,
  `code_cat` varchar(10) NOT NULL,
  `description_cat` varchar(1000) DEFAULT NULL,
  `actualNum` int(11) DEFAULT '0',
  `iduser` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.categories : ~7 rows (environ)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
REPLACE INTO `categories` (`categorie_id`, `titre_cat`, `code_cat`, `description_cat`, `actualNum`, `iduser`, `created_at`, `updated_at`) VALUES
	(2, 'Ordinateur portable pp0000', 'ORDPT', 'kldjladdajkdanb', 14, 1, '2022-03-07 12:12:18', '2022-03-14 12:29:51'),
	(3, 'Moniteur pour pac', 'MPPOT', 'dzxczxczxcc', 29, 1, '2022-03-07 12:13:31', '2022-03-14 12:33:31'),
	(4, 'PLOMBERIE', 'PLMB', 'Pour materiel lié à la plomberie', 13, 1, '2022-03-10 10:41:43', '2022-03-13 12:01:52'),
	(6, 'dsdfsdfdfsd', 'FDFDF', 'dfsfdffdf', 0, 1, '2022-03-13 11:17:36', '2022-03-13 11:17:36'),
	(7, 'fddfsdfdfd', 'DFDDD', 'dffdsfdfdfdfdf', 0, 1, '2022-03-13 11:26:36', '2022-03-13 11:26:36'),
	(8, 'xczxcxzcxz', 'PLMBJ', 'afdfdsfsdsdf', 0, 1, '2022-03-13 11:28:58', '2022-03-13 11:28:58'),
	(9, 'dfsdfdf', 'DFDFDD', 'dfdffdf', 0, 1, '2022-03-13 11:30:42', '2022-03-13 11:30:42'),
	(10, 'c  cxvvcxvcc', 'CVXCVC', 'cxcxcxc', 0, 1, '2022-03-14 12:28:03', '2022-03-14 12:28:19');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. charges
DROP TABLE IF EXISTS `charges`;
CREATE TABLE IF NOT EXISTS `charges` (
  `charge_id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(1000) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`charge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.charges : ~7 rows (environ)
/*!40000 ALTER TABLE `charges` DISABLE KEYS */;
REPLACE INTO `charges` (`charge_id`, `titre`, `description`, `iduser`, `created_at`, `updated_at`) VALUES
	(2, 'Achat du savonvcvcv', 'Achat pour la versellleevcvcv', 1, '2022-03-04 17:08:36', '2022-03-05 12:37:09'),
	(8, 'Charge electricite', 'Pour la paie des facture eneo et le caburent pour groupe', 1, '2022-03-05 22:23:49', '2022-03-05 22:26:20'),
	(9, 'Paiement facture CAMMATER', 'pour les factures de l eau', 1, '2022-03-07 08:56:33', '2022-03-14 10:27:24'),
	(10, 'Paiement de liberd', 'Payer libert pour ce mois', 1, '2022-03-14 10:30:39', '2022-03-14 10:30:39'),
	(11, 'Paiement de liberd 102', 'fgfhghghg', 1, '2022-03-14 10:31:03', '2022-03-14 10:31:03'),
	(12, 'xsxzXXzXfdfffffdfffdfffdddddddddd', 'zxzXzxzxzXffddff', 1, '2022-03-14 10:45:51', '2022-03-14 10:57:55'),
	(13, 'desto', 'test', 1, '2022-03-14 10:53:58', '2022-03-14 11:38:36');
/*!40000 ALTER TABLE `charges` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. clients
DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `raison_s_client` varchar(1000) DEFAULT NULL,
  `nom_client` varchar(255) DEFAULT NULL,
  `prenom_client` varchar(255) DEFAULT NULL,
  `email_client` varchar(255) DEFAULT NULL,
  `phone_1_client` varchar(20) NOT NULL,
  `phone_2_client` varchar(20) DEFAULT NULL,
  `idpays` int(11) DEFAULT NULL,
  `ville_client` varchar(255) DEFAULT NULL,
  `adresse_client` varchar(255) DEFAULT NULL,
  `logo_client` varchar(255) DEFAULT NULL,
  `date_ajout` date NOT NULL,
  `contribuable` varchar(100) DEFAULT NULL,
  `slogan` varchar(500) DEFAULT NULL,
  `siteweb` varchar(500) DEFAULT NULL,
  `rcm` varchar(500) DEFAULT NULL,
  `postale` varchar(50) DEFAULT NULL,
  `type_client` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `iddevise` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.clients : ~5 rows (environ)
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
REPLACE INTO `clients` (`client_id`, `raison_s_client`, `nom_client`, `prenom_client`, `email_client`, `phone_1_client`, `phone_2_client`, `idpays`, `ville_client`, `adresse_client`, `logo_client`, `date_ajout`, `contribuable`, `slogan`, `siteweb`, `rcm`, `postale`, `type_client`, `iduser`, `iddevise`, `created_at`, `updated_at`) VALUES
	(1, '', 'Desto', 'Tambu', 'teneyemdesto@gmail.com', '676934987', NULL, NULL, 'Doula', 'Makepe palace', NULL, '2022-03-07', '', NULL, NULL, '', 'Po000', '0', 1, NULL, '2022-03-07 16:27:43', '2022-03-07 16:27:43'),
	(3, 'GSC global soft an comm', '', '', 'teneyemdesto@gmail.com', '0676934987', '0676934987', 20, 'Doula', 'Makepe palace', NULL, '2022-03-08', NULL, NULL, NULL, 'klk;l44545b', 'Po000', '1', 1, NULL, '2022-03-08 08:21:51', '2022-03-08 11:06:33'),
	(4, '', 'xvddsdf', 'fdsfsdsdfd', 'teneyemdesto@gmail.com', '0676934987', '5454545', 1, 'Doula', 'Makepe palace', NULL, '2022-03-13', '', NULL, NULL, '', 'Po000', '0', 1, NULL, '2022-03-13 13:44:25', '2022-03-13 13:44:25'),
	(5, 'xcvcxxcvcvxcv', '', '', 'gfgfg@gmail.com', '4545566', '564545656', 5, 'rdtrdftdtdrt', 'rtrtrtrtrt', NULL, '2022-03-13', '23212huh', NULL, NULL, '212121212', '2101', '1', 1, NULL, '2022-03-13 13:47:25', '2022-03-13 13:47:25'),
	(8, '', 'Desto1221', 'Tambu2121212', 'teneyemdesto@gmail.com', '0676934987', '0676934987', 15, 'Doula', 'Makepe palace', NULL, '2022-03-22', '', NULL, NULL, '', 'Po000', '0', 1, NULL, '2022-03-22 13:38:08', '2022-03-22 13:38:08');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. commandes
DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `commande_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_commande` varchar(20) NOT NULL,
  `objet` varchar(1000) NOT NULL,
  `date_commande` date NOT NULL,
  `statut` int(11) DEFAULT '0',
  `idfournisseur` int(11) NOT NULL,
  `service` varchar(1000) DEFAULT NULL,
  `direction` varchar(1000) DEFAULT NULL,
  `mode_paiement` varchar(1000) DEFAULT NULL,
  `condition_paiement` varchar(1000) DEFAULT NULL,
  `delai_liv` varchar(1000) DEFAULT NULL,
  `observation` varchar(1000) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `lieu_liv` varchar(1000) DEFAULT NULL,
  `iduser` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tva_statut` int(11) DEFAULT NULL,
  PRIMARY KEY (`commande_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.commandes : ~0 rows (environ)
/*!40000 ALTER TABLE `commandes` DISABLE KEYS */;
/*!40000 ALTER TABLE `commandes` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. commentaires
DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `commentaire_id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(1000) NOT NULL,
  `date_commentaire` date NOT NULL,
  `statut_commentaire` int(11) DEFAULT '0',
  `idcommande` int(11) DEFAULT NULL,
  `iddevis` int(11) DEFAULT NULL,
  `idfacture` int(11) DEFAULT NULL,
  `iduser` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`commentaire_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.commentaires : ~0 rows (environ)
/*!40000 ALTER TABLE `commentaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `commentaires` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. complements
DROP TABLE IF EXISTS `complements`;
CREATE TABLE IF NOT EXISTS `complements` (
  `complement_id` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` int(11) NOT NULL,
  `prix` float NOT NULL,
  `remise` float DEFAULT '0',
  `tva` float DEFAULT '0',
  `idproduit` int(11) NOT NULL,
  `iddevis` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`complement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.complements : ~6 rows (environ)
/*!40000 ALTER TABLE `complements` DISABLE KEYS */;
REPLACE INTO `complements` (`complement_id`, `quantite`, `prix`, `remise`, `tva`, `idproduit`, `iddevis`, `iduser`, `created_at`, `updated_at`) VALUES
	(2, 2, 3, 2, 3, 52, 2, 1, '2022-03-15 15:34:15', '2022-03-15 15:34:15'),
	(3, 2, 4, 2, 3, 52, 3, 1, '2022-03-15 15:35:55', '2022-03-15 15:35:55'),
	(4, 1, 3, 1, 1, 52, 6, 1, '2022-03-15 16:30:03', '2022-03-15 16:30:03'),
	(5, 1, 4, 0, 0, 23, 1, 1, '2022-03-17 15:14:31', '2022-03-17 15:14:31'),
	(6, 1, 3, 0, 0, 65, 1, 1, '2022-03-17 15:14:31', '2022-03-17 15:14:31'),
	(7, 0, 3, 0, 0, 24, 1, 1, '2022-03-17 15:14:31', '2022-03-17 15:14:31'),
	(8, 1, 3, 1, 1, 52, 6, 1, '2022-03-17 16:20:21', '2022-03-17 16:20:21');
/*!40000 ALTER TABLE `complements` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. comportes
DROP TABLE IF EXISTS `comportes`;
CREATE TABLE IF NOT EXISTS `comportes` (
  `comporte_id` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` int(11) NOT NULL,
  `prix` float NOT NULL,
  `remise` float DEFAULT '0',
  `tva` float DEFAULT '0',
  `idcommande` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`comporte_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.comportes : ~0 rows (environ)
/*!40000 ALTER TABLE `comportes` DISABLE KEYS */;
/*!40000 ALTER TABLE `comportes` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. devis
DROP TABLE IF EXISTS `devis`;
CREATE TABLE IF NOT EXISTS `devis` (
  `devis_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_devis` varchar(20) NOT NULL,
  `date_devis` date NOT NULL,
  `statut` int(11) DEFAULT '0',
  `idclient` int(11) NOT NULL,
  `validite` int(11) NOT NULL,
  `objet` varchar(1000) DEFAULT NULL,
  `disponibilite` varchar(1000) DEFAULT NULL,
  `garentie` varchar(1000) DEFAULT NULL,
  `condition_financiere` varchar(1000) DEFAULT NULL,
  `date_paie` date DEFAULT NULL,
  `echeance` date DEFAULT NULL,
  `iduser` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tva_statut` int(11) DEFAULT '0',
  PRIMARY KEY (`devis_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.devis : ~7 rows (environ)
/*!40000 ALTER TABLE `devis` DISABLE KEYS */;
REPLACE INTO `devis` (`devis_id`, `reference_devis`, `date_devis`, `statut`, `idclient`, `validite`, `objet`, `disponibilite`, `garentie`, `condition_financiere`, `date_paie`, `echeance`, `iduser`, `created_at`, `updated_at`, `tva_statut`) VALUES
	(1, 'PF2022001', '2022-03-17', 0, 5, 2, 'un devis premier', 'dfgfggfg', '1 mois', 'Tous a la reception', NULL, '2022-03-31', 1, '2022-03-15 15:25:01', '2022-03-17 15:14:30', 1),
	(2, 'PF2022679', '2022-03-15', 0, 5, 2, 'XZXZxZXXZX', '123123', '233NVBVCXV', 'CVXCVCVCV', NULL, NULL, 1, '2022-03-15 15:34:15', '2022-03-15 15:34:15', NULL),
	(3, 'PF2022679', '2022-03-09', 0, 3, 12, 'xvvcvxcvcxv', '1fhhghgh', 'ghghghg', 'hghfghgfhgh', NULL, NULL, 1, '2022-03-15 15:35:55', '2022-03-15 15:35:55', NULL),
	(4, 'PF2022679', '2022-03-15', 2, 3, 2, 'dgs;fldsbjhmkcvnzcvjnkcvjkcv', 'dfvfddfv', 'vvfdvfv', 'fvfvfvfv', NULL, '2022-03-17', 1, '2022-03-15 16:27:53', '2022-03-22 10:22:09', NULL),
	(5, 'PF2022679', '2022-03-15', 2, 3, 2, 'dgs;fldsbjhmkcvnzcvjnkcvjkcv', 'dfvfddfv', 'vvfdvfv', 'fvfvfvfv', NULL, '2022-03-17', 1, '2022-03-15 16:29:09', '2022-03-22 10:25:39', NULL),
	(6, 'PF2022679', '2022-03-15', 2, 5, 3, 'sdcsdcsdcsdc', 'dcddcsdc', '2 mois', 'En deux tranches', NULL, '2022-04-05', 1, '2022-03-15 16:30:03', '2022-03-22 16:25:54', 0),
	(7, 'PF2022680', '2022-03-02', 2, 5, 3, 'dcsdcdcsdcsdcdcssdcdscsdcdc', 'sdcdcdc', 'dcscdcdc', 'dccscdscsdcdc', NULL, '2022-03-05', 1, '2022-03-15 16:31:55', '2022-03-19 13:51:00', NULL);
/*!40000 ALTER TABLE `devis` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. devises
DROP TABLE IF EXISTS `devises`;
CREATE TABLE IF NOT EXISTS `devises` (
  `devise_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_devise` varchar(230) NOT NULL,
  `symbole` varchar(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`devise_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.devises : ~0 rows (environ)
/*!40000 ALTER TABLE `devises` DISABLE KEYS */;
/*!40000 ALTER TABLE `devises` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. factures
DROP TABLE IF EXISTS `factures`;
CREATE TABLE IF NOT EXISTS `factures` (
  `facture_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_fact` varchar(20) NOT NULL,
  `date_fact` date NOT NULL,
  `statut` int(11) DEFAULT '0',
  `tva_statut` int(11) DEFAULT '0',
  `idclient` int(11) NOT NULL,
  `objet` varchar(1000) DEFAULT NULL,
  `disponibilite` varchar(1000) DEFAULT NULL,
  `garentie` varchar(1000) DEFAULT NULL,
  `condition_financiere` varchar(1000) DEFAULT NULL,
  `iduser` int(11) NOT NULL,
  `iddevis` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`facture_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.factures : ~12 rows (environ)
/*!40000 ALTER TABLE `factures` DISABLE KEYS */;
REPLACE INTO `factures` (`facture_id`, `reference_fact`, `date_fact`, `statut`, `tva_statut`, `idclient`, `objet`, `disponibilite`, `garentie`, `condition_financiere`, `iduser`, `iddevis`, `created_at`, `updated_at`) VALUES
	(1, 'F2022001', '2022-03-18', 0, 0, 5, 'Une premiere facture', NULL, NULL, NULL, 1, NULL, '2022-03-18 12:00:59', '2022-03-18 14:46:03'),
	(2, 'F2022002', '2022-03-18', 0, 0, 5, 'Une premiere facture', NULL, NULL, NULL, 1, NULL, '2022-03-18 12:01:35', '2022-03-18 12:01:35'),
	(3, 'F2022003', '2022-03-18', 0, 0, 5, 'Une premiere facture', NULL, NULL, NULL, 1, NULL, '2022-03-18 12:03:04', '2022-03-18 12:03:04'),
	(4, 'F2022004', '2022-03-18', 0, 0, 5, 'Une premiere facture', NULL, NULL, NULL, 1, NULL, '2022-03-18 12:03:24', '2022-03-18 12:03:24'),
	(5, 'F2022005', '2022-03-18', 0, 0, 5, 'Une premiere facture', NULL, NULL, NULL, 1, NULL, '2022-03-18 12:05:54', '2022-03-18 12:05:54'),
	(6, 'F2022006', '2022-03-18', 0, 0, 5, 'Une premiere facture', NULL, NULL, NULL, 1, NULL, '2022-03-18 12:06:22', '2022-03-18 12:06:22'),
	(7, 'F2022007', '2022-03-18', 0, 1, 1, 'Une premiere facture 222', NULL, NULL, NULL, 1, NULL, '2022-03-18 12:08:10', '2022-03-18 12:08:10'),
	(8, 'F2022008', '2022-03-18', 0, NULL, 5, 'dcsdcdcsdcsdcdcssdcdscsdcdc', 'sdcdcdc', 'dcscdcdc', NULL, 1, NULL, '2022-03-19 13:46:46', '2022-03-19 13:46:46'),
	(9, 'F2022009', '2022-03-19', 1, NULL, 5, 'dcsdcdcsdcsdcdcssdcdscsdcdc', 'sdcdcdc', 'dcscdcdc', NULL, 1, NULL, '2022-03-19 13:51:00', '2022-03-21 09:01:26'),
	(10, 'F2022010', '2022-03-22', 0, NULL, 3, 'dgs;fldsbjhmkcvnzcvjnkcvjkcv', 'dfvfddfv', 'vvfdvfv', NULL, 1, NULL, '2022-03-22 10:22:08', '2022-03-22 10:22:08'),
	(11, 'F2022011', '2022-03-22', 0, NULL, 3, 'dgs;fldsbjhmkcvnzcvjnkcvjkcv', 'dfvfddfv', 'vvfdvfv', NULL, 1, NULL, '2022-03-22 10:25:38', '2022-03-22 10:25:38'),
	(12, 'F2022012', '2022-03-22', 0, 0, 5, 'sdcsdcsdcsdc', 'dcddcsdc', '2 mois', NULL, 1, NULL, '2022-03-22 16:25:53', '2022-03-22 16:25:53');
/*!40000 ALTER TABLE `factures` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
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

-- Listage des données de la table gsc-app.failed_jobs : ~0 rows (environ)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. fournisseurs
DROP TABLE IF EXISTS `fournisseurs`;
CREATE TABLE IF NOT EXISTS `fournisseurs` (
  `fournisseur_id` int(11) NOT NULL AUTO_INCREMENT,
  `raison_s_fr` varchar(255) DEFAULT NULL,
  `nom_fr` varchar(255) DEFAULT NULL,
  `prenom_fr` varchar(255) DEFAULT NULL,
  `email_fr` varchar(255) DEFAULT NULL,
  `phone_1_fr` varchar(20) NOT NULL,
  `phone_2_fr` varchar(20) DEFAULT NULL,
  `idpays` int(11) DEFAULT NULL,
  `ville_fr` varchar(255) DEFAULT NULL,
  `adresse_fr` varchar(255) DEFAULT NULL,
  `logo_fr` varchar(255) DEFAULT NULL,
  `date_ajout_fr` date NOT NULL,
  `contribuable` varchar(100) DEFAULT NULL,
  `slogan` varchar(500) DEFAULT NULL,
  `siteweb` varchar(500) DEFAULT NULL,
  `rcm` varchar(500) DEFAULT NULL,
  `postale` varchar(50) DEFAULT NULL,
  `type_fr` varchar(50) DEFAULT NULL,
  `iduser` int(11) NOT NULL,
  `iddevise` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fournisseur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.fournisseurs : ~3 rows (environ)
/*!40000 ALTER TABLE `fournisseurs` DISABLE KEYS */;
REPLACE INTO `fournisseurs` (`fournisseur_id`, `raison_s_fr`, `nom_fr`, `prenom_fr`, `email_fr`, `phone_1_fr`, `phone_2_fr`, `idpays`, `ville_fr`, `adresse_fr`, `logo_fr`, `date_ajout_fr`, `contribuable`, `slogan`, `siteweb`, `rcm`, `postale`, `type_fr`, `iduser`, `iddevise`, `created_at`, `updated_at`) VALUES
	(1, '', 'Desto', 'Tambu', 'teneyemdesto@gmail.com', '0676934987', '0676934987', 1, 'Doula', 'Makepe palace', NULL, '2022-03-08', '', NULL, NULL, '', 'Po000', '0', 1, NULL, '2022-03-08 09:32:44', '2022-03-08 09:32:44'),
	(2, 'ENEO', '', '', 'eneo@gmail.com', '66565622', '364545', 1, 'Doula', 'Makepe palace', NULL, '2022-03-08', '55545454', NULL, NULL, 'vgb6563535', 'P0552', '1', 1, NULL, '2022-03-08 09:48:45', '2022-03-08 09:48:45'),
	(3, '', 'Destohjh', 'Tambujhjh', 'teneyemdesto@gmail.com', '0676934987', '0676934987', 1, 'Doula', 'Makepe palace hjh', NULL, '2022-03-08', '', NULL, NULL, '', 'Po000', '0', 1, NULL, '2022-03-08 10:37:30', '2022-03-08 10:37:30');
/*!40000 ALTER TABLE `fournisseurs` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gsc-app.migrations : ~5 rows (environ)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2022_03_03_081950_roles_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. num_factures
DROP TABLE IF EXISTS `num_factures`;
CREATE TABLE IF NOT EXISTS `num_factures` (
  `idnum_facture` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) DEFAULT NULL,
  `date_num` date DEFAULT NULL,
  `iddevis` int(11) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idnum_facture`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.num_factures : ~0 rows (environ)
/*!40000 ALTER TABLE `num_factures` DISABLE KEYS */;
/*!40000 ALTER TABLE `num_factures` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. paiements
DROP TABLE IF EXISTS `paiements`;
CREATE TABLE IF NOT EXISTS `paiements` (
  `paiement_id` int(11) NOT NULL AUTO_INCREMENT,
  `mode` varchar(255) NOT NULL,
  `date_paiement` date NOT NULL,
  `description` varchar(1000) NOT NULL,
  `montant` float NOT NULL,
  `statut` int(11) DEFAULT '1',
  `idcommande` int(11) DEFAULT NULL,
  `iddevis` int(11) DEFAULT NULL,
  `idfacture` int(11) DEFAULT NULL,
  `iduser` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`paiement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.paiements : ~4 rows (environ)
/*!40000 ALTER TABLE `paiements` DISABLE KEYS */;
REPLACE INTO `paiements` (`paiement_id`, `mode`, `date_paiement`, `description`, `montant`, `statut`, `idcommande`, `iddevis`, `idfacture`, `iduser`, `created_at`, `updated_at`) VALUES
	(1, 'En expèce', '2022-03-22', 'un bon paiement', 6000, 1, NULL, NULL, 9, 1, '2022-03-22 12:18:18', '2022-03-22 12:18:18'),
	(2, 'Par Dépot OM/MOMO', '2022-03-22', 'fgfgfgfdg', 30000, 1, NULL, NULL, 6, 1, '2022-03-22 12:21:08', '2022-03-22 12:21:08'),
	(3, 'Par virement', '2022-03-22', 'dvcvcxcvcvvcvc', 3000, 1, NULL, NULL, 9, 1, '2022-03-22 12:23:49', '2022-03-22 12:23:49'),
	(4, 'Par virement', '2022-03-22', 'cvxccvcvxcvcv', 3000, 1, NULL, NULL, 11, 1, '2022-03-22 16:17:39', '2022-03-22 16:17:39');
/*!40000 ALTER TABLE `paiements` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gsc-app.password_resets : ~0 rows (environ)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. pays
DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `pays_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_pays` varchar(255) NOT NULL,
  `code_pays` varchar(255) NOT NULL,
  `drapeau` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pays_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.pays : ~20 rows (environ)
/*!40000 ALTER TABLE `pays` DISABLE KEYS */;
REPLACE INTO `pays` (`pays_id`, `nom_pays`, `code_pays`, `drapeau`, `created_at`, `updated_at`) VALUES
	(1, 'Cameroun', '+237', NULL, '2022-03-08 09:13:44', '2022-03-08 09:20:26'),
	(2, 'Benin', '222', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(3, 'Mali', '000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(4, 'Maroc', '0000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(5, 'Cote d\'Ivoir', '000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(6, 'Gabon', '000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(7, 'Nigeria', '0000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(8, 'France', '0000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(9, 'Amerique', '0000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(10, 'Afrique du sud', '0000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(11, 'Guinee', '0000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(12, 'Guinee Equtoriale', '000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(13, 'Japon', '0000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(14, 'Chine', '0000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(15, 'Canada', '0000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(16, 'Belgique', '0000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(17, 'Engleterre', '0000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(18, 'Italie', '0000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(19, 'Ruissie', '0000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27'),
	(20, 'Inde', '0000', NULL, '2022-03-08 09:20:27', '2022-03-08 09:20:27');
/*!40000 ALTER TABLE `pays` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. personal_access_tokens
DROP TABLE IF EXISTS `personal_access_tokens`;
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

-- Listage des données de la table gsc-app.personal_access_tokens : ~0 rows (environ)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. pieces
DROP TABLE IF EXISTS `pieces`;
CREATE TABLE IF NOT EXISTS `pieces` (
  `piece_id` int(11) NOT NULL AUTO_INCREMENT,
  `chemin` varchar(500) DEFAULT NULL,
  `ref` varchar(50) DEFAULT NULL,
  `remise` float DEFAULT NULL,
  `idcommande` int(11) DEFAULT NULL,
  `idfacture` int(11) DEFAULT NULL,
  `date_piece` date DEFAULT NULL,
  `iddevis` int(11) DEFAULT NULL,
  `iduser` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`piece_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.pieces : ~9 rows (environ)
/*!40000 ALTER TABLE `pieces` DISABLE KEYS */;
REPLACE INTO `pieces` (`piece_id`, `chemin`, `ref`, `remise`, `idcommande`, `idfacture`, `date_piece`, `iddevis`, `iduser`, `created_at`, `updated_at`) VALUES
	(1, 'AJEDB-LOGO-DOUALA.png', 'BC00000', NULL, NULL, 6, '2022-03-16', NULL, 1, '2022-03-18 12:06:22', '2022-03-18 12:06:22'),
	(2, 'Premade-Logo-Sewing-Logo-Sewing-Machine-Logo-Tailor-Logo-_-Etsy2.gif', 'BC00000', NULL, NULL, 7, '2022-03-16', NULL, 1, '2022-03-18 12:08:10', '2022-03-18 12:08:10'),
	(3, 'R.jfif', 'BC00001', NULL, NULL, 1, '2022-03-18', NULL, 1, '2022-03-18 14:45:02', '2022-03-18 14:45:02'),
	(4, 'Premade-Logo-Sewing-Logo-Sewing-Machine-Logo-Tailor-Logo-_-Etsy3.gif', 'BC00001', NULL, NULL, 1, '2022-03-18', NULL, 1, '2022-03-18 14:46:03', '2022-03-18 14:46:03'),
	(5, '', 'BC00111', NULL, NULL, 8, '2022-03-12', NULL, 1, '2022-03-19 13:46:46', '2022-03-19 13:46:46'),
	(6, '', 'BC00111', NULL, NULL, 9, '2022-03-19', NULL, 1, '2022-03-19 13:51:00', '2022-03-19 13:51:00'),
	(7, '', 'bbb000', NULL, NULL, 10, '2022-03-22', NULL, 1, '2022-03-22 10:22:09', '2022-03-22 10:22:09'),
	(8, '', 'bbb002', NULL, NULL, 11, '2022-03-22', NULL, 1, '2022-03-22 10:25:39', '2022-03-22 10:25:39'),
	(9, '', '2568n26gh3', NULL, NULL, 12, '2022-03-22', NULL, 1, '2022-03-22 16:25:53', '2022-03-22 16:25:53');
/*!40000 ALTER TABLE `pieces` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. pocedes
DROP TABLE IF EXISTS `pocedes`;
CREATE TABLE IF NOT EXISTS `pocedes` (
  `pocede_id` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` int(11) NOT NULL,
  `prix` float NOT NULL,
  `remise` float DEFAULT '0',
  `tva` float DEFAULT '0',
  `num_serie` varchar(1000) DEFAULT NULL,
  `iddevis` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pocede_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.pocedes : ~13 rows (environ)
/*!40000 ALTER TABLE `pocedes` DISABLE KEYS */;
REPLACE INTO `pocedes` (`pocede_id`, `quantite`, `prix`, `remise`, `tva`, `num_serie`, `iddevis`, `idproduit`, `iduser`, `created_at`, `updated_at`) VALUES
	(1, 1, 3, 1, 0, NULL, 1, 52, 1, '2022-03-15 15:25:01', '2022-03-15 15:25:01'),
	(2, 2, 3, 2, 0, NULL, 1, 52, 1, '2022-03-15 15:25:01', '2022-03-15 15:25:01'),
	(4, 1, 4, 1, 0, NULL, 2, 53, 1, '2022-03-15 15:34:15', '2022-03-15 15:34:15'),
	(5, 3, 3, 3, 4, NULL, 3, 53, 1, '2022-03-15 15:35:55', '2022-03-15 15:35:55'),
	(6, 2, 3, 2, 2, NULL, 4, 52, 1, '2022-03-15 16:27:53', '2022-03-15 16:27:53'),
	(7, 2, 3, 2, 2, NULL, 5, 52, 1, '2022-03-15 16:29:09', '2022-03-15 16:29:09'),
	(8, 1, 1212, 1, 1, NULL, 6, 41, 1, '2022-03-15 16:30:03', '2022-03-15 16:30:03'),
	(9, 1, 3, 1, 1, NULL, 7, 52, 1, '2022-03-15 16:31:55', '2022-03-15 16:31:55'),
	(10, 1, 1000, 0, 0, NULL, 1, 66, 1, '2022-03-17 15:14:30', '2022-03-17 15:14:30'),
	(11, 2, 12212, 0, 0, NULL, 1, 55, 1, '2022-03-17 15:14:31', '2022-03-17 15:14:31'),
	(12, 1, 300, 0, 0, NULL, 6, 48, 1, '2022-03-17 16:20:21', '2022-03-17 16:20:21'),
	(13, 1, 1000, 1, 0, NULL, 6, 10, 1, '2022-03-17 16:20:21', '2022-03-17 16:20:21'),
	(14, 1, 4000, 1, 0, NULL, 6, 23, 1, '2022-03-17 16:20:21', '2022-03-17 16:20:21');
/*!40000 ALTER TABLE `pocedes` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. produits
DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `produit_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(20) NOT NULL,
  `titre_produit` varchar(1000) NOT NULL,
  `description_produit` varchar(1000) DEFAULT NULL,
  `quantite_produit` int(11) NOT NULL,
  `prix_produit` float NOT NULL,
  `idcategorie` int(11) DEFAULT NULL,
  `iduser` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`produit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.produits : ~26 rows (environ)
/*!40000 ALTER TABLE `produits` DISABLE KEYS */;
REPLACE INTO `produits` (`produit_id`, `reference`, `titre_produit`, `description_produit`, `quantite_produit`, `prix_produit`, `idcategorie`, `iduser`, `created_at`, `updated_at`) VALUES
	(10, 'ORDPT0001', 'desto tambu', 'qwefefdfdfdf', 1, 1000, 2, 1, '2022-03-09 13:02:17', '2022-03-11 15:33:26'),
	(11, 'ORDPT0001', 'grfrfre', 'rdgfgfgf', 1, 12, 2, 1, '2022-03-09 13:06:04', '2022-03-09 13:06:04'),
	(12, 'ORDPT0002', 'grfrfredfdsfdfdffgfgfgf', 'ughgjgj', 122, 212, 2, 1, '2022-03-09 13:06:25', '2022-03-09 13:06:25'),
	(13, 'MPPOT0001', 'grfrfrefsdfsdfdfdfd', 'yjhjhhjhj', 12, 212, 3, 1, '2022-03-09 13:06:49', '2022-03-09 13:06:49'),
	(14, 'MPPOT0002', 'pooijhkjhk', 'jjjhjhgjhj', 1, 12, 3, 1, '2022-03-09 13:07:16', '2022-03-09 13:07:16'),
	(15, 'ORDPT0003', 'hjgjhjhjhj', '', 2, 2, 2, 1, '2022-03-09 13:07:38', '2022-03-09 13:07:38'),
	(16, 'ORDPT0004', 'or11', 'eewweewew', 1, 1000, 2, 1, '2022-03-09 13:09:20', '2022-03-09 13:09:20'),
	(18, 'MPPOT0004', 'or33', 'fgfgfdfgfgfgfg', 11, 3000, 3, 1, '2022-03-09 13:09:20', '2022-03-09 13:09:20'),
	(19, 'ORDPT0005', 'or44', '', 12, 10000, 2, 1, '2022-03-09 13:09:20', '2022-03-09 13:09:20'),
	(20, 'ORDPT0006', 'pt11', '', 1, 1, 2, 1, '2022-03-09 13:12:56', '2022-03-09 13:12:56'),
	(23, 'ORDPT0008', 'pt44', 'iodfdfsdfdfdfdfd', 4, 4, 2, 1, '2022-03-09 13:12:56', '2022-03-11 14:53:27'),
	(24, 'ORDPT0009', 'uiuiyui', 'io', 2, 3, 2, 1, '2022-03-10 08:56:43', '2022-03-10 08:56:43'),
	(34, 'PLMB0002', 'seau de 15 litre IVISCO', 'Seau maçon de 15 litres', 5, 1000, 4, 1, '2022-03-10 10:45:18', '2022-03-10 10:45:18'),
	(41, 'PLMB0007', 'zxcxcxzcxc', 'sdfsdffsd', 1221, 1212, 4, 1, '2022-03-10 10:49:47', '2022-03-10 10:49:47'),
	(46, 'MPPOT0015', 'vfdsdfsdf', 'dfsdfdsfdf', 2, 3, 3, 1, '2022-03-11 08:49:13', '2022-03-11 08:49:13'),
	(48, 'ORDPT0013', 'dfdfdfds', 'dfdfdfdfdf', 3, 3, 2, 1, '2022-03-11 08:49:14', '2022-03-11 08:49:14'),
	(51, 'MPPOT0017', 'xzcxzxc', 'zzxczcxczxczxczxczxczxcczx', 2, 3, 3, 1, '2022-03-11 08:49:14', '2022-03-11 08:49:14'),
	(52, 'PLMB0011', 'dfgdffdgfdff', 'dfdfdfdfdfsdfdfdfdf', 2, 3, 4, 1, '2022-03-11 14:07:26', '2022-03-11 14:07:26'),
	(53, 'PLMB0012', 'dfdsfdf', 'sdfdfsddfdsfdf', 2, 3, 4, 1, '2022-03-11 14:07:27', '2022-03-11 14:07:27'),
	(55, 'MPPOT0019', 'vcxvxcvxcvxcv', 'dggdgfg', 3, 12212, 3, 1, '2022-03-11 14:12:04', '2022-03-11 14:12:04'),
	(60, 'PLMB0013', 'dvsdvggfdgfd', 'dfgfgfgfdgg', 1212012, 212, 4, 1, '2022-03-11 14:17:25', '2022-03-11 14:36:50'),
	(62, 'MPPOT0025', 'bgggb', 'erererer', 11, 0, 3, 1, '2022-03-11 14:50:40', '2022-03-11 14:50:40'),
	(63, 'MPPOT0026', 'segfgfgftyy', 'ttyytytytyt', 12, 212, 3, 1, '2022-03-11 14:59:44', '2022-03-11 14:59:44'),
	(64, 'MPPOT0027', 'tytytyt', 'tyuytuytu', 1, 21, 3, 1, '2022-03-11 14:59:44', '2022-03-11 14:59:44'),
	(65, 'MPPOT0028', 'desto tambu 2ddsd', 'fddfdffdf', 2, 3, 3, 1, '2022-03-11 15:00:13', '2022-03-11 15:37:48'),
	(66, 'MPPOT0029', 'xc cv', 'cxcxcxcxcccc', 2, 1000, 3, 1, '2022-03-14 12:33:32', '2022-03-14 12:33:32');
/*!40000 ALTER TABLE `produits` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. produit_factures
DROP TABLE IF EXISTS `produit_factures`;
CREATE TABLE IF NOT EXISTS `produit_factures` (
  `produit_f_id` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` int(11) NOT NULL,
  `prix` float NOT NULL,
  `remise` float DEFAULT NULL,
  `tva` float DEFAULT NULL,
  `num_serie` varchar(255) DEFAULT NULL,
  `idfacture` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`produit_f_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.produit_factures : ~18 rows (environ)
/*!40000 ALTER TABLE `produit_factures` DISABLE KEYS */;
REPLACE INTO `produit_factures` (`produit_f_id`, `quantite`, `prix`, `remise`, `tva`, `num_serie`, `idfacture`, `idproduit`, `iduser`, `created_at`, `updated_at`) VALUES
	(1, 1, 3, 1, 1, NULL, 2, 53, 1, '2022-03-18 12:01:35', '2022-03-18 12:01:35'),
	(2, 1, 212, 0, 0, NULL, 2, 12, 1, '2022-03-18 12:01:35', '2022-03-18 12:01:35'),
	(5, 1, 3, 1, 1, NULL, 4, 53, 1, '2022-03-18 12:03:24', '2022-03-18 12:03:24'),
	(6, 1, 212, 0, 0, NULL, 4, 12, 1, '2022-03-18 12:03:24', '2022-03-18 12:03:24'),
	(7, 1, 3, 1, 1, NULL, 5, 53, 1, '2022-03-18 12:05:54', '2022-03-18 12:05:54'),
	(8, 1, 212, 0, 0, NULL, 5, 12, 1, '2022-03-18 12:05:54', '2022-03-18 12:05:54'),
	(9, 1, 3, 1, 1, NULL, 6, 53, 1, '2022-03-18 12:06:22', '2022-03-18 12:06:22'),
	(10, 1, 212, 0, 0, NULL, 6, 12, 1, '2022-03-18 12:06:22', '2022-03-18 12:06:22'),
	(11, 15, 12213, 1, 1, NULL, 7, 55, 1, '2022-03-18 12:08:10', '2022-03-18 12:08:10'),
	(12, 1, 3000, 0, 0, NULL, 1, 12, 1, '2022-03-18 14:45:02', '2022-03-18 14:46:03'),
	(13, 1, 3, 1, 1, NULL, 8, 52, 1, '2022-03-19 13:46:46', '2022-03-19 15:00:32'),
	(14, 1, 3, 1, 1, NULL, 9, 52, 1, '2022-03-19 13:51:00', '2022-03-19 15:00:32'),
	(15, 2, 3, 2, 2, NULL, 10, 52, 1, '2022-03-22 10:22:09', '2022-03-22 10:22:09'),
	(16, 2, 3, 2, 2, NULL, 11, 52, 1, '2022-03-22 10:25:38', '2022-03-22 10:25:38'),
	(17, 1, 1212, 1, 1, NULL, 12, 41, 1, '2022-03-22 16:25:53', '2022-03-22 16:25:53'),
	(18, 1, 300, 0, 0, NULL, 12, 48, 1, '2022-03-22 16:25:53', '2022-03-22 16:25:53'),
	(19, 1, 1000, 1, 0, NULL, 12, 10, 1, '2022-03-22 16:25:53', '2022-03-22 16:25:53'),
	(20, 1, 4000, 1, 0, NULL, 12, 23, 1, '2022-03-22 16:25:53', '2022-03-22 16:25:53');
/*!40000 ALTER TABLE `produit_factures` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gsc-app.roles : ~2 rows (environ)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
REPLACE INTO `roles` (`id`, `title`) VALUES
	(1, 'administrateur'),
	(2, 'Utilisateur');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. taches
DROP TABLE IF EXISTS `taches`;
CREATE TABLE IF NOT EXISTS `taches` (
  `tache_id` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `date_ajout` date NOT NULL,
  `raison` varchar(1000) DEFAULT NULL,
  `nombre` int(11) NOT NULL,
  `prix` float NOT NULL,
  `idcharge` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `staut` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tache_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.taches : ~7 rows (environ)
/*!40000 ALTER TABLE `taches` DISABLE KEYS */;
REPLACE INTO `taches` (`tache_id`, `date_debut`, `date_fin`, `date_ajout`, `raison`, `nombre`, `prix`, `idcharge`, `iduser`, `staut`, `created_at`, `updated_at`) VALUES
	(2, '2022-03-05', '2022-03-05', '2022-03-05', 'Achat papier fini', 2, 250, 1, 1, 1, '2022-03-05 11:08:19', '2022-03-05 11:08:19'),
	(4, '2022-03-05', '2022-03-05', '2022-03-05', 'jhbbmnbnmv', 5, 555, 1, 1, 1, '2022-03-05 12:46:36', '2022-03-05 12:46:36'),
	(5, '2022-03-05', '2022-03-05', '2022-03-05', 'recouvrement', 4, 5000, 2, 1, 1, '2022-03-05 22:29:55', '2022-03-05 22:29:55'),
	(7, '2022-03-08', '2022-03-08', '2022-03-14', 'l\'eau pour ce mois cfdfdff zzxzx', 22, 1500, 9, 1, 1, '2022-03-08 08:33:40', '2022-03-14 12:10:37'),
	(8, '2022-03-16', '2022-03-16', '2022-03-14', 'dcasdsadsd', 4, 500, 10, 1, 1, '2022-03-14 12:01:42', '2022-03-14 12:13:10'),
	(10, '2022-03-14', '2022-03-14', '2022-03-14', 'recouvrement dffsdffs', 5, 5000, 10, 1, 1, '2022-03-14 12:14:39', '2022-03-14 12:14:39');
/*!40000 ALTER TABLE `taches` ENABLE KEYS */;

-- Listage de la structure de la table gsc-app. users
DROP TABLE IF EXISTS `users`;
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
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gsc-app.users : ~7 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `firstname`, `lastname`, `email`, `email_verified_at`, `password`, `remember_token`, `adresse`, `phone`, `is_active`, `is_admin`, `idrole`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'super', 'admin@gmail.com', NULL, '$2y$10$yITC8P8e2OkOY/KIbaLiC.ciIc6ki7gfFQxM0i7qFJzw3eGINDn9y', NULL, 'logpom', '679353205', 1, 1, 1, 'bg.jpg', NULL, '2022-03-04 15:52:22'),
	(2, 'Desto', 'super text', 'desto237@gmail.com', NULL, '$2y$10$vHI8Tf/pAc9qznSZnPWDmuVMwSck2gZ1HL1LKU5W2wAgrzEkEsvKy', NULL, 'logpom', '679353205', 1, 1, 1, NULL, NULL, NULL),
	(3, 'admin', 'simple', 'admin2@gmail.com', NULL, '$2y$10$DCOoonGQFtIZu5B/SonQKOZcIwI96FBaLaBpj3NP82MeT/qgAk58K', NULL, 'Makepe', '660041366', 1, 1, 1, NULL, NULL, NULL),
	(4, 'admin 1', 'simple 1', 'admin1@gmail.com', NULL, '$2y$10$0f2mIZCQC/TQOYQWqhxHW.AeoJH7Y7wMrqHJxvhEQIP1QJCftDCZO', NULL, 'Makepe', '660041366', 0, 1, 1, NULL, NULL, NULL),
	(5, 'user', 'user 1', 'user1@gmail.com', NULL, '$2y$10$V7sZ0entNBmu/GpR0m3hJub8NG5WLUURcK4X3Zbyr6MYXqD5E5efm', NULL, 'Douala', '660041366', 1, 0, 2, NULL, NULL, NULL),
	(7, 'user', 'user 3', 'user3@gmail.com', NULL, '$2y$10$NNTE081BsJ2G7YE45uqXB.CAB9D5S5FbjCGrjlZqep/sxSmQlsaDG', NULL, 'Douala', '660041366', 1, 0, 2, NULL, NULL, '2022-03-04 17:16:43');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
