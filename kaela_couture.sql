-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 12 nov. 2024 à 17:07
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `kaela_couture`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `page_title` varchar(200) NOT NULL,
  `page_description` text NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `name`, `description`, `page_title`, `page_description`, `slug`) VALUES
(1, 'Latest collection', 'Discover our latest collection featuring trendy and stylish dresses for every occasion.', 'Majestic Midnight', 'Our evening dress creations for an imperial allure.', 'latest-collection'),
(2, 'Evening dresses', 'Explore our exquisite evening dresses designed to make you feel elegant and glamorous.', 'Scarlet Sensation,', 'Ignite your passion with the latest red collection, designed to make you stand out in any crowd.', 'evening-dresses'),
(3, 'no category', 'no category', 'no category', 'no category', 'no-category');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `is_archived` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `email` varchar(120) NOT NULL,
  `object` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `date_send_msg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Structure de la table `information`
--

CREATE TABLE `information` (
  `id` int(11) NOT NULL,
  `description` text,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `information`
--

INSERT INTO `information` (`id`, `description`, `mobile`, `email`, `address`) VALUES
(1, 'Based in Instanbul, i am a stylist specializing in the creation of evening and bridal growns.', '90 553 871 48 82', 'kaelacouture@gmail.com', 'Rumeli 34363 Şişli/İstanbul, Turquie'),
(2, 'From an early age, I\'ve always had a passion for fashion and design. This passion led me to Paris, the fashion capital of the world, where I had the chance to study and perfect my haute couture skills. During my studies, I had the opportunity to work alongside some of the biggest names in the industry, giving me invaluable experience and an in-depth knowledge of the art of creating unique and sophisticated garments.', '', '', ''),
(4, 'After graduating, I moved to Istanbul, a dynamic city at the crossroads of cultures. In the chic district of Nişantaşı, I opened my couture atelier, an ideal setting to express my creativity and present my unique creations to the world.', '', '', ''),
(5, 'At Kaela Couture, every dress is a unique piece, crafted with meticulous attention to detail and dedication to craftsmanship. My atelier in Nişantaşı is a space where innovation meets tradition, offering a bespoke experience to bring high-fashion dreams to life. I continue to push the boundaries of fashion with bold, timeless creations embodying elegance and sophistication.', '', '', ''),
(6, 'In my boutique, I offer each customer a personalised and intimate experience. Each visit begins with an individual consultation to understand each woman\'s desires, inspirations and personal style. I firmly believe that every woman deserves a piece that reflects not only her beauty, but also her unique personality. That\'s why I work hand in hand with my customers to create bespoke garments that make them look their very best. Whether it\'s for a special occasion or simply to treat yourself, each Kaela Couture creation is designed to celebrate the wearer\'s uniqueness and sophistication.', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `path` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `categorie_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `path`, `slug`, `created_at`, `updated_at`, `categorie_id`, `section_id`) VALUES
(53, 'Lorem ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'lorem-ipsum-53-3.webp', 'lorem-ipsum', '2024-11-12 17:12:01', '2024-11-12 17:12:01', 3, 2),
(54, 'Lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'lorem-54-3.webp', 'lorem', '2024-11-12 17:12:22', '2024-11-12 17:12:22', 3, 2),
(55, 'Lorem dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'lorem-dolor-55-3.webp', 'lorem-dolor', '2024-11-12 17:12:45', '2024-11-12 17:12:45', 3, 2),
(56, 'Dolor amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'dolor-amet-56-1.webp', 'dolor-amet', '2024-11-12 17:13:32', '2024-11-12 17:13:32', 1, 3),
(57, 'Dolor set amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'dolor-set-amet-57-2.webp', 'dolor-set-amet', '2024-11-12 17:14:08', '2024-11-12 17:14:08', 2, 3),
(59, 'Zesta dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'zesta-dolor-59-1.webp', 'zesta-dolor', '2024-11-12 17:15:14', '2024-11-12 17:15:14', 1, 5),
(60, 'Set amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'set-amet-60-1.webp', 'set-amet', '2024-11-12 17:15:36', '2024-11-12 17:15:36', 1, 5),
(61, 'Aria lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'aria-lorem-61-1.webp', 'aria-lorem', '2024-11-12 17:15:59', '2024-11-12 17:15:59', 1, 5),
(62, 'Zesta', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'zesta-62-1.webp', 'zesta', '2024-11-12 17:16:25', '2024-11-12 17:16:25', 1, 5),
(63, 'Asela lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'asela-lorem-63-2.webp', 'asela-lorem', '2024-11-12 17:16:50', '2024-11-12 17:16:50', 2, 4),
(64, 'Lorem asela dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'lorem-asela-dolor-64-2.webp', 'lorem-asela-dolor', '2024-11-12 17:17:10', '2024-11-12 17:17:10', 2, 4),
(65, 'Alita', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'alita-65-2.webp', 'alita', '2024-11-12 17:17:45', '2024-11-12 17:17:45', 2, 4),
(66, 'Azeta', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'azeta-66-2.webp', 'azeta', '2024-11-12 17:18:15', '2024-11-12 17:18:15', 2, 4),
(67, 'Delia lor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'delia-lor-67-3.webp', 'delia-lor', '2024-11-12 17:18:46', '2024-11-12 17:18:46', 3, 6),
(68, 'Laria lo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'laria-lo-68-3.webp', 'laria-lo', '2024-11-12 17:19:18', '2024-11-12 17:19:18', 3, 6),
(69, 'Laya', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'laya-69-3.webp', 'laya', '2024-11-12 17:19:35', '2024-11-12 17:19:35', 3, 6),
(70, 'Lorem dolor alia', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'lorem-dolor-alia-70-3.webp', 'lorem-dolor-alia', '2024-11-12 18:02:09', '2024-11-12 18:02:09', 3, 6),
(71, 'Lalem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'lalem-71-3.webp', 'lalem', '2024-11-12 18:02:40', '2024-11-12 18:02:40', 3, 6),
(72, 'Set amer', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'set-amer-72-3.webp', 'set-amer', '2024-11-12 18:02:58', '2024-11-12 18:02:58', 3, 6),
(73, 'Seret amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'seret-amet-73-3.webp', 'seret-amet', '2024-11-12 18:03:26', '2024-11-12 18:03:26', 3, 6),
(74, 'Azera', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor dolor ac orci varius, nec elementum sapien suscipit.', 'azera-74-3.webp', 'azera', '2024-11-12 18:03:59', '2024-11-12 18:03:59', 3, 6);

-- --------------------------------------------------------

--
-- Structure de la table `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `section`
--

INSERT INTO `section` (`id`, `name`, `slug`) VALUES
(1, 'All', 'all'),
(2, 'Home Header', 'home-header'),
(3, 'Collection', 'collection'),
(4, 'Evening dresses', 'evening-dresses'),
(5, 'Latest Collection', 'latest-collection'),
(6, 'About me', 'about-me');

-- --------------------------------------------------------

--
-- Structure de la table `social_network`
--

CREATE TABLE `social_network` (
  `id` int(11) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `social_network`
--

INSERT INTO `social_network` (`id`, `platform`, `url`, `created_at`, `updated_at`) VALUES
(2, 'Instagram', 'https://www.instagram.com/kaela_couture', '2024-07-25 16:55:31', '2024-11-09 17:57:13'),
(5, 'Whatsapp', 'https://www.whatsapp.com', '2024-08-21 20:28:09', '2024-08-27 10:15:40'),
(7, 'Facebook', 'https://www.facebook.com', '2024-08-21 20:29:32', '2024-08-28 11:22:42');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(70) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(150) NOT NULL,
  `date_register` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(20) DEFAULT 'user',
  `last_active_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`name`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Comment_User` (`user_id`),
  ADD KEY `FK_Comment_Product` (`product_id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Contact_User` (`user_id`);

--
-- Index pour la table `information`
--
ALTER TABLE `information`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `FK_Product_Categorie` (`categorie_id`),
  ADD KEY `FK_Product_Section` (`section_id`);

--
-- Index pour la table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `social_network`
--
ALTER TABLE `social_network`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_platform` (`platform`),
  ADD UNIQUE KEY `unique_url` (`url`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `information`
--
ALTER TABLE `information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT pour la table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `social_network`
--
ALTER TABLE `social_network`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `FK_Contact_User` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
