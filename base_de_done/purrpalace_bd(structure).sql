-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 18 oct. 2025 à 11:19
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `purrpalace_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `biens`
--

DROP TABLE IF EXISTS `biens`;
CREATE TABLE IF NOT EXISTS `biens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `prix` double NOT NULL,
  `surface` double NOT NULL,
  `nombre_de_chambres` int NOT NULL,
  `disponibilite` tinyint(1) NOT NULL,
  `luxe` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `user_id` int DEFAULT NULL,
  `emplacement_id` int DEFAULT NULL,
  `type_id` int DEFAULT NULL,
  `type_activite_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1F9004DDA76ED395` (`user_id`),
  KEY `IDX_1F9004DDC4598A51` (`emplacement_id`),
  KEY `IDX_1F9004DDC54C8C93` (`type_id`),
  KEY `IDX_1F9004DDD0165F20` (`type_activite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `bien_confort`
--

DROP TABLE IF EXISTS `bien_confort`;
CREATE TABLE IF NOT EXISTS `bien_confort` (
  `bien_id` int NOT NULL,
  `confort_id` int NOT NULL,
  PRIMARY KEY (`bien_id`,`confort_id`),
  KEY `IDX_C9154065BD95B80F` (`bien_id`),
  KEY `IDX_C9154065706A77EF` (`confort_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `conforts`
--

DROP TABLE IF EXISTS `conforts`;
CREATE TABLE IF NOT EXISTS `conforts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20251016091450', '2025-10-16 09:15:49', 873),
('DoctrineMigrations\\Version20251016103310', '2025-10-16 10:34:11', 821),
('DoctrineMigrations\\Version20251016130422', '2025-10-16 13:04:53', 4841),
('DoctrineMigrations\\Version20251017074700', '2025-10-17 07:47:13', 575);

-- --------------------------------------------------------

--
-- Structure de la table `emplacements`
--

DROP TABLE IF EXISTS `emplacements`;
CREATE TABLE IF NOT EXISTS `emplacements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offres_vente`
--

DROP TABLE IF EXISTS `offres_vente`;
CREATE TABLE IF NOT EXISTS `offres_vente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_offre` date NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_modification` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `user_id` int DEFAULT NULL,
  `bien_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6D25F513A76ED395` (`user_id`),
  KEY `IDX_6D25F513BD95B80F` (`bien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

DROP TABLE IF EXISTS `photos`;
CREATE TABLE IF NOT EXISTS `photos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bien_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_876E0D9BD95B80F` (`bien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recherches`
--

DROP TABLE IF EXISTS `recherches`;
CREATE TABLE IF NOT EXISTS `recherches` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `mot_cle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget_max` double DEFAULT NULL,
  `surface_max` double DEFAULT NULL,
  `nombre_de_chambres` int DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `emplacement_id` int DEFAULT NULL,
  `type_activite_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_84050CB5A76ED395` (`user_id`),
  KEY `IDX_84050CB5C4598A51` (`emplacement_id`),
  KEY `IDX_84050CB5D0165F20` (`type_activite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recherche_confort`
--

DROP TABLE IF EXISTS `recherche_confort`;
CREATE TABLE IF NOT EXISTS `recherche_confort` (
  `recherche_id` int NOT NULL,
  `confort_id` int NOT NULL,
  PRIMARY KEY (`recherche_id`,`confort_id`),
  KEY `IDX_EEB80E4F1E6A4A07` (`recherche_id`),
  KEY `IDX_EEB80E4F706A77EF` (`confort_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recherche_types_de_bien`
--

DROP TABLE IF EXISTS `recherche_types_de_bien`;
CREATE TABLE IF NOT EXISTS `recherche_types_de_bien` (
  `recherche_id` int NOT NULL,
  `types_de_bien_id` int NOT NULL,
  PRIMARY KEY (`recherche_id`,`types_de_bien_id`),
  KEY `IDX_7F2A00B11E6A4A07` (`recherche_id`),
  KEY `IDX_7F2A00B1B4E43F1C` (`types_de_bien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  `date_creation` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modification` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `user_id` int DEFAULT NULL,
  `bien_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4DA239A76ED395` (`user_id`),
  KEY `IDX_4DA239BD95B80F` (`bien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `types_activite`
--

DROP TABLE IF EXISTS `types_activite`;
CREATE TABLE IF NOT EXISTS `types_activite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_activite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `types_de_bien`
--

DROP TABLE IF EXISTS `types_de_bien`;
CREATE TABLE IF NOT EXISTS `types_de_bien` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_de_bien` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surnom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_de_naissance` date NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_inscription` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modification` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `emplacement_id` int DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`),
  KEY `IDX_1483A5E9C4598A51` (`emplacement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `biens`
--
ALTER TABLE `biens`
  ADD CONSTRAINT `FK_1F9004DDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_1F9004DDC4598A51` FOREIGN KEY (`emplacement_id`) REFERENCES `emplacements` (`id`),
  ADD CONSTRAINT `FK_1F9004DDC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `types_de_bien` (`id`),
  ADD CONSTRAINT `FK_1F9004DDD0165F20` FOREIGN KEY (`type_activite_id`) REFERENCES `types_activite` (`id`);

--
-- Contraintes pour la table `bien_confort`
--
ALTER TABLE `bien_confort`
  ADD CONSTRAINT `FK_C9154065706A77EF` FOREIGN KEY (`confort_id`) REFERENCES `conforts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C9154065BD95B80F` FOREIGN KEY (`bien_id`) REFERENCES `biens` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `offres_vente`
--
ALTER TABLE `offres_vente`
  ADD CONSTRAINT `FK_6D25F513A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_6D25F513BD95B80F` FOREIGN KEY (`bien_id`) REFERENCES `biens` (`id`);

--
-- Contraintes pour la table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `FK_876E0D9BD95B80F` FOREIGN KEY (`bien_id`) REFERENCES `biens` (`id`);

--
-- Contraintes pour la table `recherches`
--
ALTER TABLE `recherches`
  ADD CONSTRAINT `FK_84050CB5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_84050CB5C4598A51` FOREIGN KEY (`emplacement_id`) REFERENCES `emplacements` (`id`),
  ADD CONSTRAINT `FK_84050CB5D0165F20` FOREIGN KEY (`type_activite_id`) REFERENCES `types_activite` (`id`);

--
-- Contraintes pour la table `recherche_confort`
--
ALTER TABLE `recherche_confort`
  ADD CONSTRAINT `FK_EEB80E4F1E6A4A07` FOREIGN KEY (`recherche_id`) REFERENCES `recherches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EEB80E4F706A77EF` FOREIGN KEY (`confort_id`) REFERENCES `conforts` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `recherche_types_de_bien`
--
ALTER TABLE `recherche_types_de_bien`
  ADD CONSTRAINT `FK_7F2A00B11E6A4A07` FOREIGN KEY (`recherche_id`) REFERENCES `recherches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_7F2A00B1B4E43F1C` FOREIGN KEY (`types_de_bien_id`) REFERENCES `types_de_bien` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `FK_4DA239A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_4DA239BD95B80F` FOREIGN KEY (`bien_id`) REFERENCES `biens` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_1483A5E9C4598A51` FOREIGN KEY (`emplacement_id`) REFERENCES `emplacements` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
