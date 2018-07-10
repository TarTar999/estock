-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 10 juil. 2018 à 18:41
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `estock_camtel`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_cmd` int(5) NOT NULL AUTO_INCREMENT,
  `nbre_mat_cmd` int(5) NOT NULL,
  `qte_mat_cmd` int(5) NOT NULL,
  `qte_mat_accordee` int(5) NOT NULL,
  `date_cmd` date NOT NULL,
  `employe_cmd` int(5) NOT NULL,
  PRIMARY KEY (`id_cmd`) USING BTREE,
  KEY `Index` (`employe_cmd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commandeligne`
--

DROP TABLE IF EXISTS `commandeligne`;
CREATE TABLE IF NOT EXISTS `commandeligne` (
  `id_lignecmd` int(5) NOT NULL AUTO_INCREMENT,
  `qte_cmd` int(5) NOT NULL,
  `qte_accordee` int(5) NOT NULL,
  `materiel` int(5) NOT NULL COMMENT 'Identifiant du materiel de la ligne de commande',
  `commande` int(5) NOT NULL COMMENT 'Identifiant de la commande à laquelle appartient la ligne commande',
  PRIMARY KEY (`id_lignecmd`),
  KEY `Index1` (`materiel`),
  KEY `Index2` (`commande`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

DROP TABLE IF EXISTS `employe`;
CREATE TABLE IF NOT EXISTS `employe` (
  `id_emp` int(5) NOT NULL AUTO_INCREMENT,
  `matricule_emp` varchar(20) NOT NULL,
  `nom_emp` varchar(50) NOT NULL,
  `prenom_emp` varchar(50) NOT NULL,
  `login_emp` varchar(20) NOT NULL,
  `pwd_emp` varchar(50) NOT NULL,
  `entite_emp` int(5) NOT NULL,
  `role_emp` int(5) NOT NULL,
  PRIMARY KEY (`id_emp`),
  KEY `Index2` (`role_emp`),
  KEY `Index1` (`entite_emp`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`id_emp`, `matricule_emp`, `nom_emp`, `prenom_emp`, `login_emp`, `pwd_emp`, `entite_emp`, `role_emp`) VALUES
(1, '112CAMT54', 'cecilia wangue', 'Theresa', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 1),
(2, 'TH971001WG', 'WANGUE', 'Theresa', 'WANGTher', '92b7a3069e241cef605c2ab0889ad390', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `entite`
--

DROP TABLE IF EXISTS `entite`;
CREATE TABLE IF NOT EXISTS `entite` (
  `id_entite` int(5) NOT NULL AUTO_INCREMENT,
  `nom_entite` varchar(50) NOT NULL,
  `nomenclature` varchar(255) NOT NULL,
  PRIMARY KEY (`id_entite`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entite`
--

INSERT INTO `entite` (`id_entite`, `nom_entite`, `nomenclature`) VALUES
(1, 'entite1', 'nomenclature1'),
(2, 'entite2', 'nomenclature2\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `entree`
--

DROP TABLE IF EXISTS `entree`;
CREATE TABLE IF NOT EXISTS `entree` (
  `id_entree` int(5) NOT NULL AUTO_INCREMENT,
  `qte_mat_entree` int(5) NOT NULL,
  `nbre_mat_entree` int(5) NOT NULL,
  `date_entree` date NOT NULL,
  `employe` int(5) NOT NULL COMMENT 'identifiant del''employé ayant reçu l''entrée',
  `entrepot` int(5) DEFAULT NULL COMMENT 'identifiant de l''entrepot dans lequel entre le matériel. si c''est nul alors l''entree n''est pas faite dans l''entrepot mais chez une entite',
  PRIMARY KEY (`id_entree`),
  KEY `Index1` (`employe`),
  KEY `Index2` (`entrepot`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entree`
--

INSERT INTO `entree` (`id_entree`, `qte_mat_entree`, `nbre_mat_entree`, `date_entree`, `employe`, `entrepot`) VALUES
(74, 10, 2, '2018-06-26', 1, 2),
(75, 10, 2, '2018-06-21', 1, 1),
(76, 10, 2, '2018-06-26', 1, 2),
(77, 8, 2, '2018-06-26', 1, 2),
(78, 8, 2, '2018-06-26', 1, 1),
(79, 6, 2, '2018-06-26', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `entreeligne`
--

DROP TABLE IF EXISTS `entreeligne`;
CREATE TABLE IF NOT EXISTS `entreeligne` (
  `id_ligneentre` int(5) NOT NULL AUTO_INCREMENT,
  `qte_entree` int(5) NOT NULL,
  `entree` int(5) NOT NULL,
  `materiel` int(5) NOT NULL,
  `etat` int(5) NOT NULL,
  PRIMARY KEY (`id_ligneentre`),
  KEY `Index1` (`entree`),
  KEY `Index2` (`materiel`) USING BTREE,
  KEY `index3` (`etat`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entreeligne`
--

INSERT INTO `entreeligne` (`id_ligneentre`, `qte_entree`, `entree`, `materiel`, `etat`) VALUES
(122, 3, 79, 2, 3),
(123, 3, 79, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `entrepot`
--

DROP TABLE IF EXISTS `entrepot`;
CREATE TABLE IF NOT EXISTS `entrepot` (
  `id_entrepot` int(5) NOT NULL AUTO_INCREMENT,
  `nom_entrepot` varchar(50) NOT NULL,
  `adresse_entrepot` varchar(50) NOT NULL,
  `capacite` int(10) NOT NULL,
  PRIMARY KEY (`id_entrepot`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entrepot`
--

INSERT INTO `entrepot` (`id_entrepot`, `nom_entrepot`, `adresse_entrepot`, `capacite`) VALUES
(1, 'entrepot1', 'ssadi1', 2000),
(2, 'entrepot2', 'ssadi2', 1000);

-- --------------------------------------------------------

--
-- Structure de la table `entrepotstock`
--

DROP TABLE IF EXISTS `entrepotstock`;
CREATE TABLE IF NOT EXISTS `entrepotstock` (
  `id_stockmat` int(5) NOT NULL AUTO_INCREMENT,
  `qte_disponible` int(5) NOT NULL,
  `materiel` int(5) NOT NULL COMMENT 'Identifiant du materiiel présent en stock',
  `entrepot` int(5) NOT NULL COMMENT 'Identfiant de l''entrepot où est stocké le materiel',
  PRIMARY KEY (`id_stockmat`),
  KEY `Index1` (`materiel`),
  KEY `Index2` (`entrepot`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entrepotstock`
--

INSERT INTO `entrepotstock` (`id_stockmat`, `qte_disponible`, `materiel`, `entrepot`) VALUES
(35, 12, 1, 2),
(36, 12, 2, 2),
(37, 4, 1, 1),
(38, 4, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `id_etat` int(5) NOT NULL AUTO_INCREMENT,
  `nom_etat` varchar(100) NOT NULL,
  PRIMARY KEY (`id_etat`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`id_etat`, `nom_etat`) VALUES
(1, 'defectueux'),
(2, 'au_rebut'),
(3, 'bon_etat');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
CREATE TABLE IF NOT EXISTS `fournisseur` (
  `id_fournisseur` int(5) NOT NULL AUTO_INCREMENT,
  `nom_fournisseur` varchar(50) NOT NULL,
  `adresse_fournisseur` varchar(50) NOT NULL,
  `tel_fournisseur` varchar(50) NOT NULL,
  PRIMARY KEY (`id_fournisseur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id_fournisseur`, `nom_fournisseur`, `adresse_fournisseur`, `tel_fournisseur`) VALUES
(2, 'Fournisseur1', 'Bepanda Kasmango', '693855215');

-- --------------------------------------------------------

--
-- Structure de la table `livraison`
--

DROP TABLE IF EXISTS `livraison`;
CREATE TABLE IF NOT EXISTS `livraison` (
  `id_livraison` int(5) NOT NULL AUTO_INCREMENT,
  `qte_mat_livree` int(5) NOT NULL,
  `nbre_mat_livree` int(5) NOT NULL,
  `date_livraison` date NOT NULL,
  `employe` int(5) NOT NULL,
  `fournisseur` int(5) NOT NULL,
  PRIMARY KEY (`id_livraison`),
  KEY `Index` (`employe`),
  KEY `Index1` (`fournisseur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `livraisonligne`
--

DROP TABLE IF EXISTS `livraisonligne`;
CREATE TABLE IF NOT EXISTS `livraisonligne` (
  `id_lignelivraison` int(5) NOT NULL AUTO_INCREMENT,
  `qte_livree` int(5) NOT NULL,
  `livraison` int(5) NOT NULL,
  `materiel` int(5) NOT NULL,
  `etat` int(5) NOT NULL,
  PRIMARY KEY (`id_lignelivraison`),
  KEY `Index1` (`livraison`),
  KEY `Index2` (`materiel`) USING BTREE,
  KEY `index3` (`etat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id_marque` int(5) NOT NULL AUTO_INCREMENT,
  `nom_marque` varchar(50) NOT NULL,
  PRIMARY KEY (`id_marque`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id_marque`, `nom_marque`) VALUES
(1, 'marque1'),
(2, 'marque2');

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

DROP TABLE IF EXISTS `materiel`;
CREATE TABLE IF NOT EXISTS `materiel` (
  `id_materiel` int(5) NOT NULL AUTO_INCREMENT,
  `numero_serie` varchar(50) NOT NULL,
  `nom_materiel` varchar(50) NOT NULL,
  `marque` int(5) NOT NULL COMMENT 'Identifiant de la marque du matériel',
  `type` int(5) NOT NULL COMMENT 'Identifiant du type de la marque',
  PRIMARY KEY (`id_materiel`),
  KEY `Index2` (`type`),
  KEY `Index1` (`marque`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `materiel`
--

INSERT INTO `materiel` (`id_materiel`, `numero_serie`, `nom_materiel`, `marque`, `type`) VALUES
(1, 'serialnumber1', 'materiel1', 1, 1),
(2, 'serialnumber2', 'materiel2', 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `reporting`
--

DROP TABLE IF EXISTS `reporting`;
CREATE TABLE IF NOT EXISTS `reporting` (
  `id_reporting` int(5) NOT NULL AUTO_INCREMENT,
  `debut_reporting` date NOT NULL,
  `fin_reporting` date NOT NULL,
  `report_entite` int(5) DEFAULT NULL COMMENT 'Si report_entite est non nul alors on prends toutes les actions faites pour l''entité dont l''id est report_entite. Sinon  on prend toutes les actions effectuées pendant le période donnée',
  `report_materiel` int(5) DEFAULT NULL COMMENT 'Si report_matériel est non nul alors on prends toutes les actions faites sur ce matériel dont l''id est report_matériel. Sinon  on prend toutes les actions effectuées pendant le période donnée',
  `employe` int(5) NOT NULL COMMENT 'Identifiant de l''émployé ayant créer le reporting',
  PRIMARY KEY (`id_reporting`),
  KEY `Index` (`employe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `reportingligne`
--

DROP TABLE IF EXISTS `reportingligne`;
CREATE TABLE IF NOT EXISTS `reportingligne` (
  `id_lignerep` int(5) NOT NULL AUTO_INCREMENT,
  `stock_depart` int(5) NOT NULL,
  `approvision` int(5) NOT NULL,
  `sem1` int(5) NOT NULL,
  `sem2` int(5) DEFAULT NULL,
  `sem3` int(5) DEFAULT NULL,
  `sem4` int(5) DEFAULT NULL,
  `materiel` int(5) NOT NULL COMMENT 'Identifiant du matériel intervenant dans la ligne de reporting',
  `reporting` int(5) NOT NULL COMMENT 'Identifiant du reporting auquel appartient la ligne',
  PRIMARY KEY (`id_lignerep`),
  KEY `Index1` (`materiel`),
  KEY `Index2` (`reporting`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int(5) NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_role`, `nom_role`) VALUES
(1, 'Administrateur'),
(2, 'Employe'),
(3, 'Directeur'),
(4, 'ChefServiceDIstribution'),
(5, 'MagasinierAgence'),
(6, 'Magasinier');

-- --------------------------------------------------------

--
-- Structure de la table `sortie`
--

DROP TABLE IF EXISTS `sortie`;
CREATE TABLE IF NOT EXISTS `sortie` (
  `id_sortie` int(5) NOT NULL AUTO_INCREMENT,
  `nbre_mat_sortie` int(5) NOT NULL,
  `qte_mat_sortie` int(5) NOT NULL,
  `date_sortie` date NOT NULL,
  `employe` int(5) NOT NULL COMMENT 'identifiant de l''employé ayant fait la sortie',
  `entrepot` int(5) NOT NULL,
  PRIMARY KEY (`id_sortie`),
  KEY `Index` (`employe`),
  KEY `Index1` (`entrepot`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sortie`
--

INSERT INTO `sortie` (`id_sortie`, `nbre_mat_sortie`, `qte_mat_sortie`, `date_sortie`, `employe`, `entrepot`) VALUES
(28, 2, 25, '2018-06-25', 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `sortieligne`
--

DROP TABLE IF EXISTS `sortieligne`;
CREATE TABLE IF NOT EXISTS `sortieligne` (
  `id_lignesortie` int(5) NOT NULL AUTO_INCREMENT,
  `qte_sortie` int(5) NOT NULL,
  `materiel` int(5) NOT NULL COMMENT 'Identifiant du matériel intervenant à la ligne ',
  `sortie` int(5) NOT NULL COMMENT 'Identifiant de la sortie à laquelle appartient la ligne',
  `entite` int(5) NOT NULL,
  `etat` int(5) NOT NULL,
  PRIMARY KEY (`id_lignesortie`),
  KEY `Index1` (`materiel`),
  KEY `Index2` (`sortie`),
  KEY `index3` (`entite`),
  KEY `index4` (`etat`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sortieligne`
--

INSERT INTO `sortieligne` (`id_lignesortie`, `qte_sortie`, `materiel`, `sortie`, `entite`, `etat`) VALUES
(18, 15, 2, 28, 1, 0),
(19, 10, 1, 28, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id_type` int(5) NOT NULL AUTO_INCREMENT,
  `nom_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id_type`, `nom_type`) VALUES
(1, 'Bureautique'),
(2, 'Technique');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`employe_cmd`) REFERENCES `employe` (`id_emp`);

--
-- Contraintes pour la table `commandeligne`
--
ALTER TABLE `commandeligne`
  ADD CONSTRAINT `commandeligne_ibfk_1` FOREIGN KEY (`commande`) REFERENCES `commande` (`id_cmd`),
  ADD CONSTRAINT `commandeligne_ibfk_2` FOREIGN KEY (`materiel`) REFERENCES `materiel` (`id_materiel`);

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `employe_ibfk_1` FOREIGN KEY (`entite_emp`) REFERENCES `entite` (`id_entite`),
  ADD CONSTRAINT `employe_ibfk_2` FOREIGN KEY (`role_emp`) REFERENCES `role` (`id_role`);

--
-- Contraintes pour la table `entree`
--
ALTER TABLE `entree`
  ADD CONSTRAINT `entree_ibfk_1` FOREIGN KEY (`employe`) REFERENCES `employe` (`id_emp`),
  ADD CONSTRAINT `entree_ibfk_2` FOREIGN KEY (`entrepot`) REFERENCES `entrepot` (`id_entrepot`);

--
-- Contraintes pour la table `entreeligne`
--
ALTER TABLE `entreeligne`
  ADD CONSTRAINT `entreeligne_ibfk_1` FOREIGN KEY (`entree`) REFERENCES `entree` (`id_entree`),
  ADD CONSTRAINT `entreeligne_ibfk_2` FOREIGN KEY (`materiel`) REFERENCES `materiel` (`id_materiel`);

--
-- Contraintes pour la table `entrepotstock`
--
ALTER TABLE `entrepotstock`
  ADD CONSTRAINT `entrepotstock_ibfk_1` FOREIGN KEY (`materiel`) REFERENCES `materiel` (`id_materiel`),
  ADD CONSTRAINT `entrepotstock_ibfk_2` FOREIGN KEY (`entrepot`) REFERENCES `entrepot` (`id_entrepot`);

--
-- Contraintes pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD CONSTRAINT `livraison_ibfk_1` FOREIGN KEY (`employe`) REFERENCES `employe` (`id_emp`),
  ADD CONSTRAINT `livraison_ibfk_2` FOREIGN KEY (`fournisseur`) REFERENCES `fournisseur` (`id_fournisseur`);

--
-- Contraintes pour la table `livraisonligne`
--
ALTER TABLE `livraisonligne`
  ADD CONSTRAINT `livraisonligne_ibfk_1` FOREIGN KEY (`livraison`) REFERENCES `livraison` (`id_livraison`),
  ADD CONSTRAINT `livraisonligne_ibfk_2` FOREIGN KEY (`materiel`) REFERENCES `materiel` (`id_materiel`);

--
-- Contraintes pour la table `materiel`
--
ALTER TABLE `materiel`
  ADD CONSTRAINT `materiel_ibfk_1` FOREIGN KEY (`marque`) REFERENCES `marque` (`id_marque`),
  ADD CONSTRAINT `materiel_ibfk_2` FOREIGN KEY (`type`) REFERENCES `type` (`id_type`);

--
-- Contraintes pour la table `reporting`
--
ALTER TABLE `reporting`
  ADD CONSTRAINT `reporting_ibfk_1` FOREIGN KEY (`employe`) REFERENCES `employe` (`id_emp`);

--
-- Contraintes pour la table `reportingligne`
--
ALTER TABLE `reportingligne`
  ADD CONSTRAINT `reportingligne_ibfk_1` FOREIGN KEY (`materiel`) REFERENCES `materiel` (`id_materiel`),
  ADD CONSTRAINT `reportingligne_ibfk_2` FOREIGN KEY (`reporting`) REFERENCES `reporting` (`id_reporting`);

--
-- Contraintes pour la table `sortie`
--
ALTER TABLE `sortie`
  ADD CONSTRAINT `sortie_ibfk_1` FOREIGN KEY (`employe`) REFERENCES `employe` (`id_emp`),
  ADD CONSTRAINT `sortie_ibfk_2` FOREIGN KEY (`entrepot`) REFERENCES `entrepot` (`id_entrepot`);

--
-- Contraintes pour la table `sortieligne`
--
ALTER TABLE `sortieligne`
  ADD CONSTRAINT `sortieligne_ibfk_1` FOREIGN KEY (`materiel`) REFERENCES `materiel` (`id_materiel`),
  ADD CONSTRAINT `sortieligne_ibfk_2` FOREIGN KEY (`sortie`) REFERENCES `sortie` (`id_sortie`),
  ADD CONSTRAINT `sortieligne_ibfk_3` FOREIGN KEY (`entite`) REFERENCES `entite` (`id_entite`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
