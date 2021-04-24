-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mer. 21 avr. 2021 à 21:52
-- Version du serveur :  10.4.13-MariaDB
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `rodavdali`
--
CREATE DATABASE IF NOT EXISTS `rodavdali` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `rodavdali`;


-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `commande_id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT,
  `commande_date` datetime NOT NULL,
  `commande_produit_id` int(15) UNSIGNED NOT NULL,
  `commande_user_id` int(10) UNSIGNED NOT NULL,
  `commande_quantity` int(5) UNSIGNED NOT NULL DEFAULT 1,
  `commande_prenom_nom` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `commande_adresse` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `commande_ville_pays` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`commande_id`),
  KEY `commande_produit_id` (`commande_produit_id`),
  KEY `commande_user_id` (`commande_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int(25) UNSIGNED NOT NULL AUTO_INCREMENT,
  `panier_user_id` int(10) UNSIGNED NOT NULL,
  `panier_produit_id` int(15) UNSIGNED NOT NULL,
  `panier_quantity` int(10) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `panier_produit_id` (`panier_produit_id`),
  KEY `panier_produit_quantity` (`panier_quantity`),
  KEY `panier_user_id` (`panier_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `produit_id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT,
  `produit_title` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `produit_author` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `produit_year` int(4) UNSIGNED NOT NULL,
  `produit_cat` int(10) UNSIGNED DEFAULT NULL,
  `produit_price` double(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `produit_quantity` int(5) UNSIGNED NOT NULL DEFAULT 0,
  `produit_src` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'img/cover_default.jpg',
  PRIMARY KEY (`produit_id`),
  KEY `produit_cat` (`produit_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `categorie_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categorie_title` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_role` int(1) UNSIGNED NOT NULL DEFAULT 1,
  `user_email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_pseudo` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_dateinscription` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`commande_produit_id`) REFERENCES `produit` (`produit_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`commande_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`panier_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`panier_produit_id`) REFERENCES `produit` (`produit_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`produit_cat`) REFERENCES `categorie` (`categorie_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
