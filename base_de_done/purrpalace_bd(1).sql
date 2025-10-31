-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 26 2025 г., 09:55
-- Версия сервера: 8.3.0
-- Версия PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `purrpalace_bd`
--

-- --------------------------------------------------------

--
-- Структура таблицы `biens`
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
  `user_id` int DEFAULT NULL,
  `emplacement_id` int DEFAULT NULL,
  `type_id` int DEFAULT NULL,
  `type_activite_id` int DEFAULT NULL,
  `date_inscription` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modification` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_1F9004DDA76ED395` (`user_id`),
  KEY `IDX_1F9004DDC4598A51` (`emplacement_id`),
  KEY `IDX_1F9004DDC54C8C93` (`type_id`),
  KEY `IDX_1F9004DDD0165F20` (`type_activite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `biens`
--

INSERT INTO `biens` (`id`, `adresse`, `description`, `prix`, `surface`, `nombre_de_chambres`, `disponibilite`, `luxe`, `user_id`, `emplacement_id`, `type_id`, `type_activite_id`, `date_inscription`, `date_modification`) VALUES
(1, 'Rue de la Poste 54', '<div>Le service immobilier vous présente un superbe appartement lumineux de 90m2 offrant de beaux espaces, situé au 2ième étage d\'un immeuble récent et à 2 pas de toutes les commodités (gare, grands axes, commerces ...). Composition: Hall d\'entrée, Living ouvert de 45m2 avec cuisine entièrement équipée, balcon, hall de nuit, salle de bain, 2 chambres, WC individuel avec lave-mains, espace de rangement et buanderie permettant l\'installation d\'une machine à laver et d\'un sèche-linge. Confort: Châssis PVC double vitrage, chauffage central au gaz avec chaudière individuelle,1 cave, ascenseur, (charges communes: 50€/mois). Libre à partir du 01/11. Venez découvrir la suite en contactant le 071/38.44.4&nbsp;</div>', 38000, 90, 5, 1, 0, 1, 1, 2, 3, '2025-10-22 16:31:57', '2025-10-25 20:19:36'),
(2, 'мауите пуцрку ', 'ауи тн ь кео65о гбш рео', 45000, 15, 3, 1, 1, 1, 1, 1, 1, '2025-10-24 09:56:47', '2025-10-24 09:56:48'),
(4, 'текьгб  урк ко', '<div>мшщкриеш цомкшу р5 зщОЩУЗПЦПГО5К омуп р</div>', 78000, 100, 3, 1, 1, 18, 1, 3, 3, '2025-10-24 14:55:04', '2025-10-25 20:03:12');

-- --------------------------------------------------------

--
-- Структура таблицы `bien_confort`
--

DROP TABLE IF EXISTS `bien_confort`;
CREATE TABLE IF NOT EXISTS `bien_confort` (
  `bien_id` int NOT NULL,
  `confort_id` int NOT NULL,
  PRIMARY KEY (`bien_id`,`confort_id`),
  KEY `IDX_C9154065BD95B80F` (`bien_id`),
  KEY `IDX_C9154065706A77EF` (`confort_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bien_confort`
--

INSERT INTO `bien_confort` (`bien_id`, `confort_id`) VALUES
(1, 3),
(1, 5),
(1, 6),
(1, 8),
(4, 1),
(4, 4),
(4, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `conforts`
--

DROP TABLE IF EXISTS `conforts`;
CREATE TABLE IF NOT EXISTS `conforts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `conforts`
--

INSERT INTO `conforts` (`id`, `name`) VALUES
(1, 'Wi-Fi'),
(2, 'Télévision'),
(3, 'Meublé'),
(4, 'Machine à laver'),
(5, 'Climatisation'),
(6, 'Chauffage'),
(7, 'Cuisine équipée'),
(8, 'Piscine'),
(9, 'Petit-déjeuner en chambre'),
(10, 'Service de chambre'),
(11, 'Vue sur la mer / l’océan'),
(12, 'Cheminée'),
(13, 'Quartier calme'),
(14, 'Jardin privé'),
(15, 'Terrasse ensoleillée'),
(16, 'Cuisine équipée'),
(17, 'Baignoire'),
(18, 'Fontaine de jouvence'),
(19, 'Lits à baldaquin enchantés'),
(20, 'Fenêtre sur les étoiles'),
(21, 'Parfum d’ambre et de miel'),
(22, 'Musique elfique le soir'),
(23, 'Animaux parlants'),
(24, 'Service de fée domestique'),
(25, 'Bibliothèque'),
(26, 'Garde royale à disposition'),
(27, 'Fontaine chantante'),
(28, 'Miroir des songes'),
(29, 'Salle d’alchimie'),
(30, 'Cave à vins'),
(31, 'Source thermale naturelle'),
(32, 'Hamac'),
(33, 'Balcon fleuri'),
(34, 'Air pur et chant des oiseaux'),
(35, 'Spa elfique');

-- --------------------------------------------------------

--
-- Структура таблицы `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_read` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `contact`
--

INSERT INTO `contact` (`id`, `nom`, `email`, `message`, `created_at`, `is_read`) VALUES
(1, 'Galadriel', 'galadriel@ex.com', 'mon premier message....', '2025-10-26 08:56:20', 0),
(2, 'Galadriel', 'galadriel@ex.com', 'mon premier message....', '2025-10-26 08:56:21', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Дамп данных таблицы `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20251016091450', '2025-10-16 09:15:49', 873),
('DoctrineMigrations\\Version20251016103310', '2025-10-16 10:34:11', 821),
('DoctrineMigrations\\Version20251016130422', '2025-10-16 13:04:53', 4841),
('DoctrineMigrations\\Version20251017074700', '2025-10-17 07:47:13', 575),
('DoctrineMigrations\\Version20251018140411', '2025-10-18 14:07:49', 556),
('DoctrineMigrations\\Version20251018142934', '2025-10-18 14:30:14', 418),
('DoctrineMigrations\\Version20251018144552', '2025-10-18 14:47:10', 69),
('DoctrineMigrations\\Version20251018145410', '2025-10-18 14:54:34', 242),
('DoctrineMigrations\\Version20251018145804', '2025-10-18 14:58:53', 340),
('DoctrineMigrations\\Version20251023181124', '2025-10-23 18:11:48', 213),
('DoctrineMigrations\\Version20251025212723', '2025-10-25 21:28:07', 310);

-- --------------------------------------------------------

--
-- Структура таблицы `emplacements`
--

DROP TABLE IF EXISTS `emplacements`;
CREATE TABLE IF NOT EXISTS `emplacements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `emplacements`
--

INSERT INTO `emplacements` (`id`, `pays`, `ville`, `code_postal`) VALUES
(1, 'Belgique', 'Bruxelles', 1150),
(2, 'Belgique', 'Namur', 1600),
(3, 'Avalon', 'Verger des Pommes', 1562),
(4, 'Camelot', 'Vieille Cité', 1820),
(5, 'Vallée des Moomins', 'Cœur de la Vallée', 1547),
(6, 'Narnia', 'Cair Paravel', 1965),
(7, 'Neverland', 'Baie des Pirates', 1326),
(8, 'Oz', 'Cité d’Émeraude', 1965),
(9, 'Nehwon', 'Lankhmar', 1365),
(10, 'Solla Sollew', 'Boulevard du Soleil', 1874),
(11, 'Sodor', 'Port de Brume', 6521),
(12, 'Terre du Milieu', 'Comté', 6554),
(13, 'Mordor', 'Plaine de Cendre', 666),
(14, 'Pays des Rêves', 'Rivage Lunaire', 9854),
(15, 'Pays des Merveilles', 'Jardin Royal', 5165),
(16, 'Fantasia', 'Tour de la Reine', 8451),
(17, 'Terabithia', 'Royaume Forestier', 3678),
(18, 'Utopie', 'Place de la Paix', 6584),
(19, 'Hyrule', 'Château d’Hyrule', 9234),
(20, 'Florin', 'Quartier du Palais', 7694),
(21, 'Neverland', 'Village des Fées', 5346),
(22, 'Oz', 'Village des Munchkins', 7566);

-- --------------------------------------------------------

--
-- Структура таблицы `offres_vente`
--

DROP TABLE IF EXISTS `offres_vente`;
CREATE TABLE IF NOT EXISTS `offres_vente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_modification` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `user_id` int DEFAULT NULL,
  `bien_id` int DEFAULT NULL,
  `date_inscription` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_6D25F513A76ED395` (`user_id`),
  KEY `IDX_6D25F513BD95B80F` (`bien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

DROP TABLE IF EXISTS `photos`;
CREATE TABLE IF NOT EXISTS `photos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bien_id` int DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_size` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_876E0D9BD95B80F` (`bien_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`id`, `bien_id`, `image_name`, `image_size`) VALUES
(1, 1, 'bien_68fa7000c5940.png', NULL),
(2, 1, 'bien_68fa703cdb5f3.jpg', NULL),
(3, 1, 'bien_68fa72ee0dae3.jpg', NULL),
(4, 2, '68fb4d5fae430.jpg', NULL),
(5, 4, '68fb934835308.jpg', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `recherches`
--

DROP TABLE IF EXISTS `recherches`;
CREATE TABLE IF NOT EXISTS `recherches` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mot_cle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget_max` double DEFAULT NULL,
  `surface_max` double DEFAULT NULL,
  `nombre_de_chambres` int DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `emplacement_id` int DEFAULT NULL,
  `type_activite_id` int DEFAULT NULL,
  `date_inscription` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modification` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_84050CB5A76ED395` (`user_id`),
  KEY `IDX_84050CB5C4598A51` (`emplacement_id`),
  KEY `IDX_84050CB5D0165F20` (`type_activite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `recherche_confort`
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
-- Структура таблицы `recherche_types_de_bien`
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
-- Структура таблицы `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  `date_inscription` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modification` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `user_id` int DEFAULT NULL,
  `bien_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4DA239A76ED395` (`user_id`),
  KEY `IDX_4DA239BD95B80F` (`bien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `types_activite`
--

DROP TABLE IF EXISTS `types_activite`;
CREATE TABLE IF NOT EXISTS `types_activite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_activite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `types_activite`
--

INSERT INTO `types_activite` (`id`, `type_activite`) VALUES
(1, 'Location court'),
(2, 'Location long'),
(3, 'Vente');

-- --------------------------------------------------------

--
-- Структура таблицы `types_de_bien`
--

DROP TABLE IF EXISTS `types_de_bien`;
CREATE TABLE IF NOT EXISTS `types_de_bien` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_de_bien` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `types_de_bien`
--

INSERT INTO `types_de_bien` (`id`, `type_de_bien`) VALUES
(1, 'Chambre'),
(2, 'Appartement'),
(3, 'Maison'),
(4, 'Studio'),
(5, 'Garage'),
(6, 'Château'),
(7, 'Taverne'),
(8, 'Cabine du capitaine'),
(9, 'Pavillon royal'),
(10, 'Tour');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
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
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_inscription` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modification` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `emplacement_id` int DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_size` int DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`),
  KEY `IDX_1483A5E9C4598A51` (`emplacement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `roles`, `password`, `nom`, `prenom`, `surnom`, `date_de_naissance`, `adresse`, `photo`, `date_inscription`, `date_modification`, `emplacement_id`, `telephone`, `image_name`, `image_size`, `is_verified`) VALUES
(1, 'angelina@ex.com', '[\"ROLE_PROPRIETAIRE\"]', '$2y$13$TGJaTbZQcjBg623ItS8zbOl1LEhdrgXMsAlwO1bsOuRqJRzY.nT1a', 'Jolieааа', 'Angelina', 'Maleficenta', '1975-06-04', 'Drévé du Bonheurаааа', NULL, '2025-10-18 22:32:12', '2025-10-22 11:32:36', 1, '+32 987 45 23 56', '68f4156bf221c.jpg', NULL, 1),
(12, 'olga3@ex.com', '[\"ROLE_PROPRIETAIRE\"]', '$2y$13$M0mAYkXK6QqOXt4kYKT6yeEu/EHyObs7i7YV2i8RuNrrHe8UPIScW', 'olalaa', 'olala', 'Olga', '5489-12-21', 'Drévé du Bonheur, 15', NULL, '2025-10-21 14:10:57', '2025-10-25 13:51:05', 1, '+32 987 45 23 154', 'edfb479beebc76c527dbba8bec0478608de7b4b4.jpg', NULL, 0),
(14, 'olga2@ex.com', '[\"ROLE_CLIENT\"]', '$2y$13$X/JquMZpuLwdpQb30AfwROpG/qeqRyz.TV630KWaJD2aYN/aY7ZWe', 'olga', 'olga', 'olga', '4598-12-21', 'Drévé du Bonheur', NULL, '2025-10-21 14:28:42', '2025-10-21 14:28:42', 1, '+32 987 45 23 56', 'sans_photo.png', NULL, 0),
(17, 'toto@ex.com', '[\"ROLE_PROPRIETAIRE\"]', '$2y$13$WGv//P3bidA/TDSJxZQGA.5gbC1t6Jcb6.8RqltH6CS6bsny3cw2q', 'иавр ек', ' кп ', 'нг лгшдшг', '1978-04-23', 'птн 45', NULL, '2025-10-24 13:30:48', '2025-10-24 13:31:14', 1, '45125978', 'sans_photo.png', NULL, 1),
(18, 'topo@ex.com', '[\"ROLE_PROPRIETAIRE\"]', '$2y$13$EwQDdO7lFPyHMrEw.c979.2Hto0.ZD8HEfhxCGK280sNZZR1keU7i', 'topo', 'totopo', 'pffff', '4895-12-12', 'paris', NULL, '2025-10-24 13:40:00', '2025-10-25 10:04:02', 1, '135458', 'sans_photo.png', NULL, 1),
(20, 'admin@purrpalace.com', '[\"ROLE_ADMIN\"]', '$2y$13$ACI45X4mKNQ9Ipwt3MqM3uirEF7ta8pZp/3lqrlnxg5yL2a2Duwcu', 'Banderas', 'Antonio', 'Le Chat Potté', '1960-08-10', 'Drévé du Bonheur, 15', NULL, '2025-10-24 21:18:12', '2025-10-24 21:18:45', 1, '+32 987 45 23 56', '68fbed147e0d4.png', NULL, 1),
(23, 'lolola@ex.com', '[\"ROLE_CLIENT\"]', '$2y$13$BV/7Lwnd2K1zpRrbTGRTQODgdrGL0ponTCOcxXQ3dU0RYSGhVDHHC', 'lolola', 'lolola', 'lolola', '1932-06-12', 'lolola', NULL, '2025-10-25 17:08:08', '2025-10-25 17:08:08', 1, NULL, '7078666f640547220847169789d54517c1e3f8cd.jpg', NULL, 0);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `biens`
--
ALTER TABLE `biens`
  ADD CONSTRAINT `FK_1F9004DDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_1F9004DDC4598A51` FOREIGN KEY (`emplacement_id`) REFERENCES `emplacements` (`id`),
  ADD CONSTRAINT `FK_1F9004DDC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `types_de_bien` (`id`),
  ADD CONSTRAINT `FK_1F9004DDD0165F20` FOREIGN KEY (`type_activite_id`) REFERENCES `types_activite` (`id`);

--
-- Ограничения внешнего ключа таблицы `bien_confort`
--
ALTER TABLE `bien_confort`
  ADD CONSTRAINT `FK_C9154065706A77EF` FOREIGN KEY (`confort_id`) REFERENCES `conforts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C9154065BD95B80F` FOREIGN KEY (`bien_id`) REFERENCES `biens` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `offres_vente`
--
ALTER TABLE `offres_vente`
  ADD CONSTRAINT `FK_6D25F513A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_6D25F513BD95B80F` FOREIGN KEY (`bien_id`) REFERENCES `biens` (`id`);

--
-- Ограничения внешнего ключа таблицы `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `FK_876E0D9BD95B80F` FOREIGN KEY (`bien_id`) REFERENCES `biens` (`id`);

--
-- Ограничения внешнего ключа таблицы `recherches`
--
ALTER TABLE `recherches`
  ADD CONSTRAINT `FK_84050CB5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_84050CB5C4598A51` FOREIGN KEY (`emplacement_id`) REFERENCES `emplacements` (`id`),
  ADD CONSTRAINT `FK_84050CB5D0165F20` FOREIGN KEY (`type_activite_id`) REFERENCES `types_activite` (`id`);

--
-- Ограничения внешнего ключа таблицы `recherche_confort`
--
ALTER TABLE `recherche_confort`
  ADD CONSTRAINT `FK_EEB80E4F1E6A4A07` FOREIGN KEY (`recherche_id`) REFERENCES `recherches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EEB80E4F706A77EF` FOREIGN KEY (`confort_id`) REFERENCES `conforts` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `recherche_types_de_bien`
--
ALTER TABLE `recherche_types_de_bien`
  ADD CONSTRAINT `FK_7F2A00B11E6A4A07` FOREIGN KEY (`recherche_id`) REFERENCES `recherches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_7F2A00B1B4E43F1C` FOREIGN KEY (`types_de_bien_id`) REFERENCES `types_de_bien` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `FK_4DA239A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_4DA239BD95B80F` FOREIGN KEY (`bien_id`) REFERENCES `biens` (`id`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_1483A5E9C4598A51` FOREIGN KEY (`emplacement_id`) REFERENCES `emplacements` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
