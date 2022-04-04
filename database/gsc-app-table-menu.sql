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

-- Listage de la structure de la table gsc-app. menus
DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(11) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Listage des données de la table gsc-app.menus : ~0 rows (environ)
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
	(10, -1, 'NT', 'Notifications', 'Voir les notifications');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
