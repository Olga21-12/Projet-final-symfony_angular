-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 03 2025 г., 09:18
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
  `date_modification` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_1F9004DDA76ED395` (`user_id`),
  KEY `IDX_1F9004DDC4598A51` (`emplacement_id`),
  KEY `IDX_1F9004DDC54C8C93` (`type_id`),
  KEY `IDX_1F9004DDD0165F20` (`type_activite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `biens`
--

INSERT INTO `biens` (`id`, `adresse`, `description`, `prix`, `surface`, `nombre_de_chambres`, `disponibilite`, `luxe`, `user_id`, `emplacement_id`, `type_id`, `type_activite_id`, `date_inscription`, `date_modification`) VALUES
(1, 'Rue des Brumes 3', '<div>🏰 Château Noir d’Avalon — demeure de Maléfique<br>Niché au sommet des collines d’Avalon, le Château Noir s’élève au milieu des brumes argentées et des roseraies enchantées.<br>Chaque salle est imprégnée d’une magie ancienne : les chandeliers s’allument d’eux-mêmes au crépuscule, et les vitraux diffusent une lumière ambrée même sous la pluie.<br>Une grande cheminée de pierre réchauffe le salon principal, tandis que la tour centrale offre une vue imprenable sur les forêts éternelles.<br>Idéal pour les voyageurs en quête de solitude, de puissance ou d’inspiration.<br><br>🌹 Atouts : jardin des roses éternelles, miroir des songes, musique nocturne des hiboux, cheminée ancienne et cloche de sérénité.</div>', 1338000, 1255, 150, 1, 1, 1, 3, 6, 3, '2025-10-22 16:31:57', '2025-10-28 21:07:01'),
(5, 'Rue du Vin 8', '<div>🍷 <strong>Taverne “À la Griffe Dorée” — demeure du Chat Botté (Florin)<br></strong><br></div><div>Au cœur du vieux quartier de Florin, la <strong>Taverne “À la Griffe Dorée”</strong> accueille voyageurs, conteurs et rêveurs autour d’un verre de vin enchanté.<br> Les poutres en bois doré racontent les exploits du célèbre Chat Botté, et le feu de la cheminée ne s’éteint jamais vraiment.<br> À l’étage, des chambres confortables offrent une vue sur la place du marché, tandis que la terrasse fleurie s’anime de musique elfique à la tombée du soir.<br> Un lieu parfait pour ceux qui aiment les histoires, les rires et les nuits étoilées.<br><br></div><div>🐾 <strong>Atouts :</strong> cave à vins enchantée, terrasse ensoleillée, musique elfique le soir, air pur et chant des oiseaux, chemin de lanternes.<br><br></div>', 165000, 158, 1, 0, 0, 20, 20, 7, 1, '2025-10-26 17:28:44', '2025-10-31 06:08:46'),
(8, 'Rue des Fées 10', '<div>&nbsp;Au cœur de la Forêt d’Argent, la <strong>Cabane des Murmures</strong> offre un refuge paisible aux âmes en quête de repos et de magie douce.<br> Construite en bois d’if et entourée de fleurs lumineuses, elle semble respirer avec la forêt.<br> Chaque matin, les brumes dévoilent un ruisseau argenté où les fées viennent danser.<br> Un lieu idéal pour les voyageurs solitaires, les poètes ou les couples en quête d’un séjour hors du temps.&nbsp;</div>', 489.99, 45, 2, 0, 0, 1, 23, 11, 1, '2025-10-27 08:48:00', '2025-11-01 15:41:12'),
(10, 'Rue du Graal 9', 'Perchée au sommet d’une ancienne tour de Camelot, la Chambre de la Tour de Lune est un nid suspendu entre rêve et légende.\r\nLe soir, les vitraux projettent sur les murs des reflets argentés, et la brise transporte le parfum du miel et du feu de bois.\r\nLe balcon offre une vue exceptionnelle sur les toits du vieux Camelot et les collines d’Avalon.\r\nUn havre romantique pour voyageurs discrets et rêveurs nocturnes.', 150, 28, 1, 0, 1, 1, 4, 1, 1, '2025-10-29 16:06:47', '2025-10-30 21:58:18'),
(11, 'Rue des Brumes 14', '<div>&nbsp;La <strong>Tour des Brumes</strong> est l’une des plus mystérieuses résidences de Narnia.<br> Entourée d’un jardin où le givre scintille même en été, elle domine la vallée des neiges éternelles.<br> Chaque pièce conserve la chaleur d’un feu ancien et la magie d’un lieu où le temps semble s’arrêter.<br> Depuis la tour d’observation, on peut apercevoir les lueurs du Cair Paravel à l’horizon.<br> Un bien rare, réservé aux collectionneurs de silence et de secrets.&nbsp;</div>', 265000, 120, 4, 0, 1, 1, 24, 10, 3, '2025-10-29 16:46:30', '2025-10-30 21:59:05'),
(12, 'Quai du Crochet 2, Port de la Baie des Pirates', 'Embarquez pour une nuit inoubliable à bord du “Jolly Roger”, amarré dans la baie des Pirates.\r\nLa Cabine du Capitaine offre tout le confort d’une demeure maritime : planchers en bois poli, hublots dorés, et une vue directe sur les eaux mouvantes de Neverland.\r\nLe soir, les vagues fredonnent d’anciennes chansons de corsaires, et la brise porte le parfum du sel et de l’aventure.\r\nUn lieu parfait pour les âmes libres et les rêveurs des mers.\r\n🌸 Conforts :\r\nVue sur l’océan 🌊\r\nHamac suspendu entre deux mâts 🌴\r\nCheminée de bord 🔥\r\nService de chambre pirate 🧺\r\nBouteille de rhum enchanté 🍾\r\nAir marin et brise tropicale 🌬️\r\n', 230, 36, 2, 1, 1, 29, 7, 8, 1, '2025-10-29 21:45:21', '2025-10-30 12:55:16'),
(15, 'Allée du Lion 5', 'Dominant les falaises blanches de Cair Paravel, le Pavillon Royal du Lion est un joyau de pierre dorée baigné de lumière.\r\nChaque matin, les vagues saluent le soleil, et les vents murmurent des légendes anciennes.\r\nLe grand hall, orné de mosaïques représentant l’histoire de Narniа, ouvre sur une terrasse où les neiges scintillent jusqu’à l’horizon.\r\nUn bien rare, symbole de sagesse et de paix, réservé aux âmes nobles.\r\n🌸 Conforts :\r\nVue panoramique sur la mer glacée ❄️\r\nCheminée monumentale 🔥\r\nBibliothèque infinie 📚\r\nJardin des lys et des roses 🌸\r\nCloche de sérénité 🔔\r\nFontaine de jouvence 💧', 475000, 240, 6, 1, 1, 30, 6, 6, 3, '2025-10-30 12:48:03', '2025-10-30 17:02:53'),
(16, 'Rue des Lucioles 5', 'À l’écart du tumulte des mers, le Capitaine a trouvé son havre : la Cabane du Crochet, cachée dans une clairière où dansent les lucioles.\r\nConstruite en bois de navire échoué, elle conserve le charme du large et la paix du sous-bois.\r\nLe jardin accueille des feux de camp et des soirées à la guitare, tandis que les papillons et les fées font office de gardiens nocturnes.\r\nUne demeure rare, à la fois sauvage et apaisante — parfaite pour les pirates repenties.\r\n🌸 Conforts :\r\nCheminée en pierre 🔥\r\nJardin avec feu de camp 🌾\r\nHamac entre deux palmiers 🌴\r\nFontaine de jouvence miniature 💧\r\nQuartier calme et secret 🌿\r\nParfum de bois et de rhum 🍃', 175, 85, 3, 0, 0, 29, 25, 11, 3, '2025-10-31 06:00:17', '2025-11-01 11:59:30'),
(17, 'Rue des Souliers 11', 'Étonnamment raffiné pour un pirate, l’Appartement du Capitaine allie le luxe d’Oz à la fantaisie de Neverland.\r\nSitué dans une ruelle pavée d’émeraudes, il offre un confort rare : une lumière verte apaisante, un balcon sur la grande place et un calme presque suspect.\r\nLe capitaine y séjourne entre deux aventures — pour écrire ses mémoires, polir son crochet et observer les couchers de soleil.\r\nIdéal pour ceux qui aiment l’élégance avec un soupçon de danger.\r\n🌸 Conforts :\r\nVue sur la Cité d’Émeraude 💎\r\nCuisine équipée avec chaudron magique 🍳\r\nTerrasse ensoleillée ☀️\r\nWi-Fi magique 📶\r\nService de nettoyage par sorcière 🧹\r\nFontaine chantante 🎵', 950, 54, 2, 1, 1, 29, 8, 2, 2, '2025-10-31 06:09:54', '2025-10-31 06:12:52'),
(18, 'Rue des Brumes 6', 'Blottie au pied des collines enneigées, la Maison des Neiges Douces invite au calme et à la contemplation.\r\nLa lumière y est pâle et dorée, comme un matin d’hiver sans fin.\r\nLes tapis en laine, les poutres en bois clair et la chaleur du feu créent un cocon parfait pour ceux qui cherchent refuge après une longue quête.\r\nUn lieu d’équilibre et de repos, où l’on entend parfois un rugissement lointain porté par le vent.\r\n🌸 Conforts :\r\nCheminée en pierre blanche 🔥\r\nFenêtre sur les montagnes enneigées ❄️\r\nPetit-déjeuner en chambre 🍯\r\nAir pur et chant des oiseaux 🕊️\r\nCloche de sérénité 🔔\r\nQuartier calme 🌿', 150, 98, 3, 0, 0, 30, 24, 3, 1, '2025-10-31 06:26:44', '2025-11-01 19:25:29'),
(20, 'Rue des Sages 10', 'La Tour des Savoirs Étoilés domine les vallées brumeuses de Fondcombe.\r\nLieu de silence et de lumière, elle abrite une bibliothèque où les grimoires s’ouvrent d’eux-mêmes au bon chapitre.\r\nLes soirs de pleine lune, les murs semblent murmurer des vers anciens, et la tour scintille d’un éclat doux venu des cieux.\r\nUn bien rare pour ceux qui cherchent à étudier, méditer et contempler l’infini.\r\n🛏️ Pièces : 5 (grande salle, bibliothèque, observatoire, 2 chambres)\r\n🌸 Conforts :\r\nBibliothèque infinie 📚\r\nFenêtre sur les étoiles ✨\r\nCheminée ancienne 🔥\r\nSalle d’alchimie 🔮\r\nCloche de sérénité 🔔\r\nJardin secret des herbes médicinales 🌿', 590000, 220, 5, 1, 0, 32, 27, 10, 3, '2025-11-01 12:54:19', '2025-11-01 13:00:53'),
(23, 'Rue du Sable 3, Port Miniature', 'Perchée sur les rochers d’une côte minuscule, la Maison du Vent et des Vagues est un refuge paisible où la mer parle doucement.\r\nConstruite par des artisans lilliputiens à partir de coquillages et de bois flotté, elle mêle charme marin et fantaisie magique.\r\nLe soir, la lumière du phare danse sur les murs, et l’air emplit la maison d’un calme infini.\r\nIdéal pour les voyageurs contemplatifs, les poètes de mer et les mages en vacances.\r\n🛏️ Pièces : 2 (salon avec cheminée + chambre avec vue mer)\r\n🌸 Conforts :\r\nVue sur l’océan 🌊\r\nTerrasse fleurie 🌺\r\nCuisine équipée 🍳\r\nHammac entre deux coquillages 🐚\r\nAir marin et parfums d’algues 🌬️\r\nFontaine chantante 🎵', 640, 52, 2, 1, 0, 32, 28, 3, 1, '2025-11-01 13:50:59', '2025-11-01 13:58:05'),
(24, 'Rue du Cratère 1', 'Sur une île perdue dans le brouillard du temps, la Forteresse de l’Aube Sauvage se dresse au cœur d’une jungle préhistorique.\r\nBâtie en pierre volcanique, elle résiste aussi bien aux tempêtes qu’aux rugissements des créatures anciennes.\r\nDepuis la terrasse, on peut apercevoir les silhouettes majestueuses des dinosaures traversant la vallée.\r\nUn lieu unique, réservé aux aventuriers érudits et aux gardiens des mystères anciens.\r\n🛏️ Pièces : 7 (grande salle, 3 chambres, observatoire, salle d’armes, tour de garde)\r\n🌸 Conforts :\r\nVue panoramique sur la jungle 🦕\r\nCheminée en pierre volcanique 🔥\r\nTerrasse d’observation 🌄\r\nGarde magique de pierre 🛡️\r\nFontaine d’énergie ancestrale 💧\r\nCave à vins enchantée 🍷', 835000, 310, 7, 1, 0, 32, 29, 12, 3, '2025-11-01 14:03:27', '2025-11-01 14:10:54'),
(25, 'Rue du Crépuscule 11', 'À la frontière du jour et de la nuit, le Refuge du Soleil Levant s’ouvre sur les vastes plaines dorées de Narnia.\r\nC’est une demeure où la lumière change à chaque instant, caressant les murs comme une bénédiction.\r\nLe soir, le chant des harpistes se mêle à celui des cigales, et l’air porte encore un parfum de miel et de neige fondue.\r\nIdéal pour les esprits sages, les voyageurs du crépuscule et les cœurs fidèles à la lumière.\r\n🛏️ Pièces : 4 (salon ouvert, 2 chambres, salle d’étude, jardin)\r\n🌸 Conforts :\r\nTerrasse ensoleillée ☀️\r\nFontaine chantante 🎵\r\nJardin privé 🌺\r\nMusique des harpistes le soir 🎶\r\nFenêtre sur les étoiles ✨\r\nService de fée domestique 🧚', 320000, 160, 4, 1, 0, 30, 30, 3, 3, '2025-11-01 18:05:20', '2025-11-01 18:18:36'),
(26, 'Rue du Lapin 3', 'Entre les rosiers bavards et les horloges folles, la Maison du Thé Perpétuel est un lieu où le temps s’arrête pour danser.\r\nChaque tasse se remplit seule, chaque conversation s’achève en éclat de rire.\r\nLa chambre mansardée ouvre sur un ciel violet constellé d’étoiles en forme de gâteaux.\r\nUn endroit parfait pour rêver sans limite — ou pour rater l’heure du thé avec style.\r\n🛏️ Pièces : 2 (salon à thé + chambre mansardée)\r\n🌸 Conforts :\r\nService de thé infini 🍵\r\nJardin des roses éternelles 🌹\r\nHorloge déroutée ⏰\r\nMusique joyeuse du matin 🎶\r\nBalcon fleuri 🌺', 210, 40, 2, 1, 0, 33, 15, 3, 1, '2025-11-01 18:31:32', '2025-11-01 18:35:25'),
(27, 'Rue des Miroirs 7', 'L’Atelier des Chapeaux Égarés est une demeure pleine de fantaisie et de souvenirs sucrés.\r\nChaque chapeau garde l’histoire de celui qui l’a porté, et le grenier semble grandir chaque fois qu’on y monte.\r\nLes murs chuchotent des secrets d’élégance et les horloges battent au rythme des rêves.\r\nUn lieu rare, idéal pour les artistes et les esprits un peu fous.\r\n🛏️ Pièces : 3 (atelier, salon à thé privé, grenier magique)\r\n🌸 Conforts :\r\nCheminée en cuivre 🔥\r\nBibliothèque de recettes absurdes 📖\r\nMiroir des songes 🌙\r\nJardin miniature suspendu 🌿\r\nCloche de sérénité 🔔', 320000, 110, 3, 1, 0, 33, 15, 13, 3, '2025-11-01 18:38:36', '2025-11-01 18:38:36'),
(28, 'Rue des Ténèbres 1', 'Le Palais des Échos, demeure du Roi Jareth, brille au centre du Labyrinthe comme un rêve suspendu.\r\nLes couloirs changent de forme selon l’humeur du lieu, et les miroirs révèlent parfois plus que des reflets.\r\nC’est un palais pour ceux qui aiment les illusions, les mystères et les danses de minuit.\r\nUn bien unique, vibrant d’énergie magique et de nostalgie.\r\n🛏️ Pièces : 6 (grande salle, 2 chambres, bibliothèque, observatoire, salle des miroirs)\r\n🌸 Conforts :\r\nMiroirs vivants 🌙\r\nSalle de bal enchantée 💃\r\nMusique éternelle de cristal 🎶\r\nFenêtres mouvantes 🌀\r\nFontaine chantante 🎵\r\nVue sur le cœur du Labyrinthe 🌾', 670000, 260, 6, 1, 0, 34, 31, 6, 3, '2025-11-01 19:02:40', '2025-11-01 19:02:40'),
(29, 'Rue des Lanternes 6', 'La Maison du Gardien des Couloirs est un refuge discret, caché entre deux illusions.\r\nLes murs gardent le souvenir de milliers de pas perdus, et la lumière y change de couleur à chaque heure du jour.\r\nC’est un havre pour les voyageurs égarés, les chercheurs de vérité ou les alchimistes du silence.\r\nUn lieu simple et étrange — à l’image du Labyrinthe lui-même.\r\n🛏️ Pièces : 3 (salon, chambre, atelier des potions)\r\n🌸 Conforts :\r\nCheminée en pierre noire 🔥\r\nLumières mouvantes ✨\r\nAir parfumé de sauge 🌿\r\nFontaine souterraine 💧\r\nService de fée domestique 🧚\r\nQuartier calme (sauf la nuit des lunes jumelles) 🌕', 530, 75, 3, 1, 1, 34, 32, 3, 1, '2025-11-01 19:08:09', '2025-11-01 19:08:09'),
(30, 'Rue des Bonbons 12', 'Située à deux pas des champs dorés du Pays d’Oz, la Grange à Tracteur Magique est un petit bijou pour les amoureux de mécanique enchantée.\r\nConstruite en briques bleues typiques du village des Munchkins, elle abrite un espace spacieux pour un ou deux véhicules agricoles — ou pour un balai volant de grande taille.\r\nSon atelier attenant dispose d’outils auto-affûtants et d’une étagère intelligente qui range les boulons par humeur.\r\nIdéal pour les artisans, jardiniers célestes ou collectionneurs de machines à vapeur enchantées.\r\nPièces : 2 (garage principal + atelier magique)\r\nConforts :\r\nPorte automatique à manivelle enchantée ⚙️\r\nFontaine d’huile éternelle 💧\r\nParfum de menthe et de métal 🌿\r\nBanc de réparation en bois doré 🪵\r\nÉclairage aux lucioles industrielles 💡\r\nCloche de sérénité 🔔', 42000, 48, 2, 0, 1, 35, 22, 5, 3, '2025-11-01 19:19:33', '2025-11-02 09:24:29');

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
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 6),
(1, 10),
(1, 11),
(1, 12),
(1, 15),
(1, 17),
(1, 23),
(1, 24),
(1, 25),
(1, 28),
(1, 30),
(1, 33),
(1, 34),
(1, 35),
(5, 1),
(5, 3),
(5, 4),
(5, 7),
(5, 12),
(5, 15),
(5, 22),
(5, 23),
(5, 30),
(5, 34),
(8, 3),
(8, 7),
(8, 9),
(8, 10),
(8, 14),
(8, 15),
(8, 20),
(8, 21),
(8, 22),
(8, 23),
(8, 34),
(10, 3),
(10, 4),
(10, 5),
(10, 6),
(10, 9),
(10, 10),
(10, 19),
(10, 20),
(10, 22),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(11, 6),
(11, 7),
(11, 9),
(11, 10),
(11, 12),
(11, 14),
(11, 15),
(11, 20),
(11, 23),
(11, 30),
(12, 3),
(12, 9),
(12, 10),
(12, 11),
(12, 12),
(12, 32),
(15, 3),
(15, 4),
(15, 6),
(15, 7),
(15, 8),
(15, 9),
(15, 10),
(15, 11),
(15, 12),
(15, 14),
(15, 15),
(15, 17),
(15, 18),
(15, 19),
(15, 23),
(15, 25),
(15, 26),
(15, 30),
(15, 33),
(15, 34),
(16, 6),
(16, 7),
(16, 13),
(16, 14),
(16, 15),
(16, 17),
(16, 21),
(16, 32),
(16, 34),
(18, 3),
(18, 4),
(18, 6),
(18, 7),
(18, 12),
(18, 13),
(18, 15),
(18, 17),
(18, 20),
(20, 3),
(20, 7),
(20, 10),
(20, 11),
(20, 12),
(20, 14),
(20, 15),
(20, 20),
(20, 25),
(20, 29),
(20, 30),
(20, 32),
(23, 3),
(23, 7),
(23, 11),
(23, 12),
(23, 14),
(23, 15),
(23, 27),
(23, 32),
(24, 3),
(24, 7),
(24, 10),
(24, 11),
(24, 12),
(24, 14),
(24, 15),
(24, 25),
(24, 30),
(24, 32),
(24, 33),
(25, 3),
(25, 7),
(25, 10),
(25, 12),
(25, 13),
(25, 14),
(25, 15),
(25, 17),
(25, 20),
(25, 21),
(25, 24),
(25, 25),
(25, 27),
(25, 33),
(26, 3),
(26, 14),
(26, 15),
(26, 33),
(28, 1),
(28, 2),
(28, 3),
(28, 4),
(28, 5),
(28, 6),
(28, 7),
(28, 8),
(28, 10),
(28, 12),
(28, 14),
(28, 15),
(28, 17),
(28, 20),
(28, 25),
(28, 28),
(28, 30),
(28, 32),
(28, 33),
(29, 1),
(29, 3),
(29, 6),
(29, 7),
(29, 9),
(29, 10),
(29, 13),
(29, 14),
(29, 15),
(29, 17),
(29, 21),
(29, 33);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `contact`
--

INSERT INTO `contact` (`id`, `nom`, `email`, `message`, `created_at`, `is_read`) VALUES
(1, 'Galadriel', 'galadriel@ex.com', 'mon premier message....', '2025-10-26 08:56:20', 0),
(2, 'Galadriel', 'galadriel@ex.com', 'mon premier message....', '2025-10-26 08:56:21', 0),
(3, 'Galadriel', 'galadriel@ex.com', 'Bonjour!', '2025-10-29 14:02:59', 0),
(4, 'Galadriel', 'galadriel@ex.com', 'Bonjour!', '2025-10-29 14:02:59', 0);

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
('DoctrineMigrations\\Version20251025212723', '2025-10-25 21:28:07', 310),
('DoctrineMigrations\\Version20251026163156', '2025-10-26 16:32:20', 640),
('DoctrineMigrations\\Version20251030192454', '2025-10-30 19:26:06', 2158),
('DoctrineMigrations\\Version20251102095941', '2025-11-02 10:00:05', 761);

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(22, 'Oz', 'Village des Munchkins', 7566),
(23, 'Avalon', 'Forêt d’Argent', 1188),
(24, 'Narnia', 'Colline du Nord', 4897),
(25, 'Neverland', 'Clairière du Croissant', 8720),
(26, 'Terre du Milieu', 'Forêt Dorée', 8833),
(27, 'Terre du Milieu', 'Fondcombe', 7544),
(28, 'Pays des Lilliputiens', 'Côte de Brise-Marine', 5544),
(29, 'Île des Dinosaures', 'Archipel du Temps Perdu', 1),
(30, 'Narnia', 'Plaine Dorée', 6285),
(31, 'Labyrinthe', 'Cité des Illusions', 9966),
(32, 'Labyrinthe', 'Faubourg des Ténèbres', 3564),
(33, 'Neverland', 'Baie des Fées', 3201);

-- --------------------------------------------------------

--
-- Структура таблицы `offres_vente`
--

DROP TABLE IF EXISTS `offres_vente`;
CREATE TABLE IF NOT EXISTS `offres_vente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_modification` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `user_id` int DEFAULT NULL,
  `bien_id` int DEFAULT NULL,
  `date_inscription` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_6D25F513A76ED395` (`user_id`),
  KEY `IDX_6D25F513BD95B80F` (`bien_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `offres_vente`
--

INSERT INTO `offres_vente` (`id`, `statut`, `date_modification`, `user_id`, `bien_id`, `date_inscription`) VALUES
(2, 'vendu', '2025-10-30 21:59:05', 17, 11, '2025-10-30 21:59:05'),
(3, 'vendu', '2025-11-01 11:59:30', 31, 16, '2025-11-01 11:59:30');

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
  `date_inscription` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modification` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_876E0D9BD95B80F` (`bien_id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`id`, `bien_id`, `image_name`, `image_size`, `date_inscription`, `date_modification`) VALUES
(12, 5, 'bien_68fe64c02327f.png', NULL, '2025-10-26 18:13:20', '2025-10-26 18:13:20'),
(13, 5, 'bien_68fe6ff7379f4.png', NULL, '2025-10-26 19:01:11', '2025-10-26 19:01:11'),
(14, 5, 'bien_68fe7013c9397.png', NULL, '2025-10-26 19:01:39', '2025-10-26 19:01:39'),
(15, 5, 'bien_68fe70425bfd5.png', NULL, '2025-10-26 19:02:26', '2025-10-26 19:02:26'),
(16, 1, 'bien_68fe723581b69.jpg', NULL, '2025-10-26 19:10:45', '2025-10-26 19:10:45'),
(17, 1, 'bien_68fe72559e2d0.jpg', NULL, '2025-10-26 19:11:17', '2025-10-26 19:11:17'),
(19, 1, 'bien_68fe729e759b4.jpg', NULL, '2025-10-26 19:12:30', '2025-10-26 19:12:30'),
(20, 1, 'bien_68fe72da42e83.webp', NULL, '2025-10-26 19:13:30', '2025-10-26 19:13:30'),
(21, 8, 'bien_68ff3333637ab.jpg', NULL, '2025-10-27 08:54:11', '2025-10-27 08:54:11'),
(22, 8, 'bien_68ff33645f9dc.jpg', NULL, '2025-10-27 08:55:00', '2025-10-27 08:55:00'),
(23, 8, 'bien_68ff3385330ee.jpg', NULL, '2025-10-27 08:55:33', '2025-10-27 08:55:33'),
(24, 8, 'bien_68ff33da1a8f4.jpg', NULL, '2025-10-27 08:56:58', '2025-10-27 08:56:58'),
(25, 10, '69023b982105b.avif', NULL, '2025-10-29 16:06:48', '2025-10-29 16:06:48'),
(26, 11, 'bien_6902451c2d7ce.png', NULL, '2025-10-29 16:47:24', '2025-10-29 16:47:24'),
(27, 11, 'bien_690245466a58f.png', NULL, '2025-10-29 16:48:06', '2025-10-29 16:48:06'),
(28, 11, 'bien_690245809765a.png', NULL, '2025-10-29 16:49:04', '2025-10-29 16:49:04'),
(42, 12, 'bien_69035fc8d62df.jpg', NULL, '2025-10-30 12:53:28', '2025-10-30 12:53:28'),
(43, 12, 'bien_69035ff54c293.jpg', NULL, '2025-10-30 12:54:13', '2025-10-30 12:54:13'),
(44, 12, 'bien_690360344122f.jpg', NULL, '2025-10-30 12:55:16', '2025-10-30 12:55:16'),
(45, 15, 'bien_690399a696b4c.jpg', NULL, '2025-10-30 17:00:22', '2025-10-30 17:00:22'),
(46, 15, 'bien_69039a3dc931a.png', NULL, '2025-10-30 17:02:53', '2025-10-30 17:02:53'),
(47, 16, '69045071861d8.jpg', NULL, '2025-10-31 06:00:17', '2025-10-31 06:00:17'),
(48, 16, 'bien_6904509d0033a.jpg', NULL, '2025-10-31 06:01:01', '2025-10-31 06:01:01'),
(51, 16, 'bien_69045210ca529.jpg', NULL, '2025-10-31 06:07:12', '2025-10-31 06:07:12'),
(52, 16, 'bien_6904524ec11e4.jpg', NULL, '2025-10-31 06:08:14', '2025-10-31 06:08:14'),
(53, 17, '690452b2e33cb.webp', NULL, '2025-10-31 06:09:54', '2025-10-31 06:09:54'),
(54, 17, 'bien_690452e28dbdd.webp', NULL, '2025-10-31 06:10:42', '2025-10-31 06:10:42'),
(55, 17, 'bien_69045364877c5.webp', NULL, '2025-10-31 06:12:52', '2025-10-31 06:12:52'),
(56, 18, '690456a515c91.png', NULL, '2025-10-31 06:26:45', '2025-10-31 06:26:45'),
(57, 18, 'bien_690457bd3025a.png', NULL, '2025-10-31 06:31:25', '2025-10-31 06:31:25'),
(58, 18, 'bien_6904590b577ed.png', NULL, '2025-10-31 06:36:59', '2025-10-31 06:36:59'),
(59, 18, 'bien_690459c4366d1.png', NULL, '2025-10-31 06:40:04', '2025-10-31 06:40:04'),
(60, 20, '690602fb80e92.jpg', NULL, '2025-11-01 12:54:19', '2025-11-01 12:54:19'),
(61, 20, 'bien_69060378edd69.jpg', NULL, '2025-11-01 12:56:24', '2025-11-01 12:56:24'),
(62, 20, 'bien_690603ce96d4b.jpg', NULL, '2025-11-01 12:57:50', '2025-11-01 12:57:50'),
(63, 20, 'bien_690604854821f.jpg', NULL, '2025-11-01 13:00:53', '2025-11-01 13:00:53'),
(65, 23, '6906104368cd1.avif', NULL, '2025-11-01 13:50:59', '2025-11-01 13:50:59'),
(66, 23, 'bien_690610c28868f.jpg', NULL, '2025-11-01 13:53:06', '2025-11-01 13:53:06'),
(67, 23, 'bien_6906111d9bd31.webp', NULL, '2025-11-01 13:54:37', '2025-11-01 13:54:37'),
(68, 23, 'bien_690611ed42a39.webp', NULL, '2025-11-01 13:58:05', '2025-11-01 13:58:05'),
(69, 24, '6906132f3c8d9.jpg', NULL, '2025-11-01 14:03:27', '2025-11-01 14:03:27'),
(70, 24, 'bien_6906139e128f8.jpg', NULL, '2025-11-01 14:05:18', '2025-11-01 14:05:18'),
(71, 24, 'bien_690613c3c22de.webp', NULL, '2025-11-01 14:05:55', '2025-11-01 14:05:55'),
(72, 24, 'bien_690614ee13d53.png', NULL, '2025-11-01 14:10:54', '2025-11-01 14:10:54'),
(73, 25, '69064be07b070.jpg', NULL, '2025-11-01 18:05:20', '2025-11-01 18:05:20'),
(74, 25, 'bien_69064d383253d.png', NULL, '2025-11-01 18:11:04', '2025-11-01 18:11:04'),
(75, 25, 'bien_69064d98228a9.jpg', NULL, '2025-11-01 18:12:40', '2025-11-01 18:12:40'),
(76, 25, 'bien_69064e0bda8f9.jpg', NULL, '2025-11-01 18:14:35', '2025-11-01 18:14:35'),
(77, 25, 'bien_69064e4d88f98.jpg', NULL, '2025-11-01 18:15:41', '2025-11-01 18:15:41'),
(78, 25, 'bien_69064efc02500.jpg', NULL, '2025-11-01 18:18:36', '2025-11-01 18:18:36'),
(79, 26, '69065204f2362.jpg', NULL, '2025-11-01 18:31:33', '2025-11-01 18:31:33'),
(80, 26, 'bien_690652eda1d65.jpg', NULL, '2025-11-01 18:35:25', '2025-11-01 18:35:25'),
(81, 27, '690653ac18125.jpg', NULL, '2025-11-01 18:38:36', '2025-11-01 18:38:36'),
(82, 28, '69065950c7734.jpg', NULL, '2025-11-01 19:02:40', '2025-11-01 19:02:40'),
(83, 29, '69065a9987945.jpg', NULL, '2025-11-01 19:08:09', '2025-11-01 19:08:09'),
(84, 30, '69065d4602af4.jpg', NULL, '2025-11-01 19:19:34', '2025-11-01 19:19:34');

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
  `date_modification` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_bien` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_84050CB5A76ED395` (`user_id`),
  KEY `IDX_84050CB5C4598A51` (`emplacement_id`),
  KEY `IDX_84050CB5D0165F20` (`type_activite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `recherches`
--

INSERT INTO `recherches` (`id`, `mot_cle`, `budget_max`, `surface_max`, `nombre_de_chambres`, `ville`, `user_id`, `emplacement_id`, `type_activite_id`, `date_inscription`, `date_modification`, `pays`, `type_bien`) VALUES
(14, NULL, NULL, NULL, NULL, '', 14, NULL, NULL, '2025-10-30 19:32:31', '2025-10-30 19:32:31', 'Avalon', ''),
(15, NULL, NULL, NULL, NULL, '', 14, NULL, NULL, '2025-10-30 19:33:08', '2025-10-30 19:33:08', '', 'Pavillon royal'),
(16, NULL, NULL, NULL, NULL, '', 14, NULL, NULL, '2025-10-30 19:33:35', '2025-10-30 19:33:35', '', 'Tour'),
(17, NULL, NULL, NULL, NULL, '', 14, NULL, NULL, '2025-10-30 19:59:30', '2025-10-30 19:59:30', 'Avalon', ''),
(18, NULL, NULL, NULL, NULL, '', 29, NULL, NULL, '2025-10-31 05:57:33', '2025-10-31 05:57:33', '', 'Cabane'),
(19, NULL, NULL, NULL, NULL, '', 29, NULL, NULL, '2025-10-31 06:11:13', '2025-10-31 06:11:13', '', ''),
(20, NULL, NULL, NULL, NULL, '', 31, NULL, NULL, '2025-11-01 12:00:11', '2025-11-01 12:00:11', '', ''),
(21, NULL, NULL, NULL, NULL, '', 31, NULL, NULL, '2025-11-01 12:00:27', '2025-11-01 12:00:27', 'Oz', ''),
(22, NULL, NULL, NULL, NULL, '', 31, NULL, NULL, '2025-11-01 12:00:41', '2025-11-01 12:00:41', '', 'Château');

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
  `date_modification` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `user_id` int DEFAULT NULL,
  `bien_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4DA239A76ED395` (`user_id`),
  KEY `IDX_4DA239BD95B80F` (`bien_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `reservations`
--

INSERT INTO `reservations` (`id`, `date_debut`, `date_fin`, `date_inscription`, `date_modification`, `user_id`, `bien_id`) VALUES
(2, '2025-10-30', '2025-10-31', '2025-10-30 21:58:18', '2025-10-30 21:58:18', 12, 10),
(3, '2025-10-31', '2025-11-03', '2025-10-31 06:08:46', '2025-10-31 06:08:46', 29, 5),
(4, '2025-11-01', '2025-11-04', '2025-11-01 15:41:11', '2025-11-01 15:41:11', 31, 8),
(5, '2025-11-01', '2025-12-01', '2025-11-01 19:25:29', '2025-11-01 19:25:29', 36, 18);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(10, 'Tour'),
(11, 'Cabane'),
(12, 'Forteresse'),
(13, 'Atelier');

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
  `date_modification` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `emplacement_id` int DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_size` int DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`),
  KEY `IDX_1483A5E9C4598A51` (`emplacement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `roles`, `password`, `nom`, `prenom`, `surnom`, `date_de_naissance`, `adresse`, `photo`, `date_inscription`, `date_modification`, `emplacement_id`, `telephone`, `image_name`, `image_size`, `is_verified`) VALUES
(1, 'angelina@ex.com', '[\"ROLE_PROPRIETAIRE\"]', '$2y$13$YSHDJ63wW3A3XjYHraQR3eF.BToopnOABTlNrZOIZUKRH801vp.Hi', 'Jolie', 'Angelina', 'Maleficenta', '1975-06-04', 'Drévé du Bonheur', NULL, '2025-10-18 22:32:12', '2025-10-29 08:58:13', 1, '+32 987 45 23 56', '68f4156bf221c.jpg', NULL, 1),
(12, 'olga3@ex.com', '[\"ROLE_PROPRIETAIRE\"]', '$2y$13$qQ2XgvJZviIjR1.Q4K1Cee6ANyxX1Hr0jGHLkYfYmqg6PdqDPgpj2', 'olala', 'olala', 'Olga', '5489-12-21', 'Drévé du Bonheur, 15', NULL, '2025-10-21 14:10:57', '2025-10-29 11:27:37', 1, '+32 987 45 23 154', 'edfb479beebc76c527dbba8bec0478608de7b4b4.jpg', NULL, 0),
(14, 'olga2@ex.com', '[\"ROLE_CLIENT\"]', '$2y$13$hudKQQiJmjVwGY6bUpmk6.U1y9VIxlgS3Z428D51YtlsuH8jY.9XW', 'olga', 'olga', 'olga', '4598-12-21', 'Drévé du Bonheur', NULL, '2025-10-21 14:28:42', '2025-10-30 13:15:42', 1, '+32 987 45 23 56', '690364feec7c5.jpg', 57587, 0),
(17, 'toto@ex.com', '[\"ROLE_CLIENT\"]', '$2y$13$WGv//P3bidA/TDSJxZQGA.5gbC1t6Jcb6.8RqltH6CS6bsny3cw2q', 'Toto', 'Toto', 'Toto', '1978-04-23', 'Toto 45', NULL, '2025-10-24 13:30:48', '2025-10-29 16:51:55', 1, '45125978', '69023199deb04.png', NULL, 1),
(20, 'admin@purrpalace.com', '[\"ROLE_ADMIN\"]', '$2y$13$jgZzAE0TmRj4gqRFcFkMduJQqF7TIFRw1pi5Tb1SQmdIUUXhSNE3G', 'Banderas', 'Antonio', 'Le Chat Potté', '1960-08-10', 'Rue du Prince 2', NULL, '2025-10-24 21:18:12', '2025-10-26 10:58:55', 20, '+32 987 45 23 56', '68fbed147e0d4.png', NULL, 1),
(29, 'isaacs@ex.com', '[\"ROLE_PROPRIETAIRE\"]', '$2y$13$Akq0iPtQExrJ5i8axNVX9eT4IOIOy7CU6Q6DVUBq/Bqi9BDYf.UIK', 'Isaacs', 'Jason', 'Capitaine Crochet', '1963-06-06', 'Quai du Crochet 1', NULL, '2025-10-29 13:59:22', '2025-10-30 17:56:08', 7, '+52 100 100', '69021e0ba0e05.jpg', NULL, 1),
(30, 'liam@ex.com', '[\"ROLE_PROPRIETAIRE\"]', '$2y$13$MqlyLRbR9uPmBQjii1D9Oul6HxRQiekROyDJ.CRbDjV3.IVZ8OdT6', 'Neeson', 'Liam', 'Aslan', '1952-06-07', 'Allée du Lion 1', NULL, '2025-10-30 12:39:15', '2025-10-31 04:44:18', 6, '95 78 78 78', '69039a59f1d4a.jpg', NULL, 1),
(31, 'cate@ex.com', '[\"ROLE_CLIENT\"]', '$2y$13$kgg70N8L990OEXCf5FTzOun3fptyatoI6n0lLsELD2TrilDW8Xcua', 'Blanchett', 'Catherine', 'Galadriel', '1969-05-14', 'Rue des Étoiles 6, Lothlórien', NULL, '2025-11-01 11:49:33', '2025-11-01 11:55:03', 26, '+32659847', '6905f51740e4d.avif', 123789, 0),
(32, 'Ian@ex.com', '[\"ROLE_PROPRIETAIRE\"]', '$2y$13$XXLVIS7ySYOI8duBXsQKp.UK0rslfLkCKXOasqp8hRHrvN..r1sZa', 'McKellen', 'Ian', 'Gandalf', '1939-05-25', 'Rue des Sages 10', NULL, '2025-11-01 12:04:15', '2025-11-01 12:55:26', 27, '875462', '6905f73fed518.avif', NULL, 1),
(33, 'depp@ex.com', '[\"ROLE_PROPRIETAIRE\"]', '$2y$13$zKwbiPRxHBMHV2Wxb.Ho8uqghLhCVvvg7b44fqhMDRtCBgFF7VXWu', 'Depp', 'Johnny', 'Chapelier Fou', '1963-06-09', 'Rue du Lapin 3', NULL, '2025-11-01 18:28:56', '2025-11-01 18:29:47', 15, '1000700', '6906516874b53.jpg', NULL, 1),
(34, 'bowie@ex.com', '[\"ROLE_PROPRIETAIRE\"]', '$2y$13$E6eaw7k95/3V.n2HLsHIsOkqYD7E/963Q1ULtJixYDtc.r32cbJg.', 'Bowie', 'David', 'Jareth', '1947-01-08', 'Rue des Ténèbres 15', NULL, '2025-11-01 18:56:59', '2025-11-01 18:57:13', 31, '+981546', '690657fb38988.jpg', NULL, 1),
(35, 'toby@ex.com', '[\"ROLE_PROPRIETAIRE\"]', '$2y$13$Qd4TL12fFWNyXBIX18NDqelm1trEK.iTCi1qyWL3k48WZhgPlE7z2', 'Champignon', 'Toby', 'Toby Champignon', '1988-12-12', 'Rue des Bonbons 12', NULL, '2025-11-01 19:15:01', '2025-11-01 19:15:20', 22, '988765', '69065c3527846.jpg', NULL, 1),
(36, 'julia@ex.com', '[\"ROLE_CLIENT\"]', '$2y$13$AIKkZrXF0XijLqZmfGT3cujI7FN3OdfCvhERfZRpQl/R4qJ5H4ob.', 'Roberts', 'Julia', 'Tinker Bell', '1967-10-28', 'Rue des Lumières 4', NULL, '2025-11-01 19:24:31', '2025-11-01 19:24:46', 33, '00001', '69065e6fce101.jpg', NULL, 1),
(37, 'eva@ex.com', '[\"ROLE_CLIENT\"]', '$2y$13$XbWdSmebPqH94NYeEsa3M.i9kGVGfhnp4j6z3/Ok3HJZkbaLwTYLq', 'Green', 'Eva', 'Morgane Pendragon', '1980-07-06', 'Rue des Brumes 2', NULL, '2025-11-01 19:30:00', '2025-11-01 19:30:14', 3, '985412222', '69065fb7ef229.avif', NULL, 1),
(38, 'alex@ex.com', '[\"ROLE_PROPRIETAIRE\"]', '$2y$13$vh6vqhe1eHGZy4TEbrutyexRqZiBAx8IcPp8OCBbDvEzie3CzJsIG', 'Alex', 'Alex', 'Alex', '2000-02-10', 'Drévé du Bonheur', NULL, '2025-11-03 09:14:22', '2025-11-03 09:16:16', 1, '+32 987 45 23 56', '6908726e66690.jpg', NULL, 1);

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
