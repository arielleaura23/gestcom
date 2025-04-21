-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 21 avr. 2025 à 13:30
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestcom`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `cate_added` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `cate_added`) VALUES
(2, 'Vetements', 'Lorem', '2025-01-16'),
(3, 'accessoires', 'asdgfg', '2025-01-28');

-- --------------------------------------------------------

--
-- Structure de la table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name_customer` varchar(50) NOT NULL,
  `email_customer` varchar(100) NOT NULL,
  `phone_customer` int(11) NOT NULL,
  `register_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `customers`
--

INSERT INTO `customers` (`id`, `name_customer`, `email_customer`, `phone_customer`, `register_on`) VALUES
(5, 'nina mimi', 'nina@gmail.com', 696722992, '2025-01-19'),
(6, 'Abomo Foh Arielle Laura', 'abomoarielle43@gmail.com', 655418841, '2025-04-08');

-- --------------------------------------------------------

--
-- Structure de la table `customer_details`
--

CREATE TABLE `customer_details` (
  `id` int(11) NOT NULL,
  `name_customer` varchar(255) NOT NULL,
  `email_customer` varchar(255) NOT NULL,
  `phone_customer` int(11) NOT NULL,
  `register_on` date NOT NULL,
  `billing_name` varchar(255) NOT NULL,
  `billing_address` varchar(255) NOT NULL,
  `billing_country` varchar(255) NOT NULL,
  `billing_city` varchar(255) NOT NULL,
  `billing_phone` int(11) NOT NULL,
  `billing_zip` int(11) NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `shipping_country` varchar(255) NOT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `shipping_phone` int(11) NOT NULL,
  `shipping_zip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `customer_details`
--

INSERT INTO `customer_details` (`id`, `name_customer`, `email_customer`, `phone_customer`, `register_on`, `billing_name`, `billing_address`, `billing_country`, `billing_city`, `billing_phone`, `billing_zip`, `shipping_name`, `shipping_address`, `shipping_country`, `shipping_city`, `shipping_phone`, `shipping_zip`) VALUES
(5, 'nina mimi', 'nina@gmail.com', 696722992, '2025-01-19', 'nina mimi', 'etoug-ebe', 'United States', 'yaounde', 696722992, 237, 'nina mimi', 'etoug-ebe', 'United States', 'yaounde', 696722992, 237),
(6, 'Abomo Foh Arielle Laura', 'abomoarielle43@gmail.com', 655418841, '2025-04-08', 'Abomo Foh Arielle Laura', 'zsdxfcgv', 'United States', 'yaounde', 655418841, 0, 'Abomo Foh Arielle Laura', 'zsdxfcgv', 'United States', 'yaounde', 655418841, 0);

-- --------------------------------------------------------

--
-- Structure de la table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `advance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `amount_currency` varchar(10) NOT NULL DEFAULT 'FCFA',
  `invoice_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `customer_id`, `total_amount`, `advance`, `amount_currency`, `invoice_date`) VALUES
(33, 'IN000001#@09', 5, 10000.00, 10000.00, 'FCFA', '2025-04-10 11:10:08'),
(34, 'IN000002#@20', 6, 15000.00, 10002.00, 'FCFA', '2025-04-12 00:06:37');

-- --------------------------------------------------------

--
-- Structure de la table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `item_id`, `item_name`, `quantity`, `price`, `amount`) VALUES
(1, 33, 24, 'sacs', 2, 5000.00, 10000.00),
(2, 34, 24, 'sacs', 3, 5000.00, 15000.00);

-- --------------------------------------------------------

--
-- Structure de la table `invoice_payments_advance`
--

CREATE TABLE `invoice_payments_advance` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `payment_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `invoice_payments_advance`
--

INSERT INTO `invoice_payments_advance` (`id`, `invoice_id`, `amount`, `currency`, `payment_date`) VALUES
(1, 33, 5000.00, 'FCFA', '2025-04-10 13:10:08'),
(2, 33, 200.00, 'FCFA', '2025-04-10 13:42:44'),
(3, 33, 500.00, 'FCFA', '2025-04-10 14:13:38'),
(4, 33, 300.00, 'FCFA', '2025-04-10 14:14:09'),
(5, 33, 500.00, 'FCFA', '2025-04-10 16:27:02'),
(6, 33, 500.00, 'FCFA', '2025-04-11 00:35:47'),
(7, 33, 500.00, 'FCFA', '2025-04-11 00:35:47'),
(8, 33, 500.00, 'FCFA', '2025-04-11 00:35:59'),
(9, 33, 500.00, 'FCFA', '2025-04-11 00:35:59'),
(10, 33, 200.00, 'FCFA', '2025-04-11 00:51:15'),
(11, 33, 300.00, 'FCFA', '2025-04-11 02:06:01'),
(12, 33, 100.00, 'FCFA', '2025-04-12 01:43:21'),
(13, 33, 50.00, 'FCFA', '2025-04-12 01:51:51'),
(14, 33, 200.00, 'FCFA', '2025-04-12 01:57:13'),
(15, 33, 50.00, 'FCFA', '2025-04-12 02:04:39'),
(16, 34, 10000.00, 'FCFA', '2025-04-12 02:07:23'),
(21, 34, 1.00, 'EURO', '2025-04-12 02:42:27'),
(22, 34, 1.00, 'EURO', '2025-04-12 02:42:37'),
(23, 33, 600.00, 'FCFA', '2025-04-12 02:53:28');

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_image` varchar(255) NOT NULL,
  `item_category` varchar(255) NOT NULL,
  `price_per_unit` int(11) NOT NULL,
  `quantity_buyed` int(11) NOT NULL,
  `quantity_selled` int(11) NOT NULL,
  `quantity_rest` int(11) NOT NULL,
  `price_of_sale` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `items`
--

INSERT INTO `items` (`id`, `item_name`, `item_image`, `item_category`, `price_per_unit`, `quantity_buyed`, `quantity_selled`, `quantity_rest`, `price_of_sale`, `description`, `created_at`) VALUES
(23, 'pagnes', 'assets/photos/elections english.jpg', 'Vetements', 6000, 20, 6, 14, 12000, 'fhg', '2025-04-12 02:36:10'),
(24, 'sacs', 'assets/photos/elections.jpg', 'accessoires', 2000, 23, 12, 3, 5000, 'ed', '2025-04-12 02:19:51');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `product` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `delivery_address` text DEFAULT NULL,
  `delivery_fee` decimal(10,2) DEFAULT NULL,
  `special_instructions` text DEFAULT NULL,
  `order_status` varchar(50) DEFAULT 'En attente',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `preferences`
--

CREATE TABLE `preferences` (
  `id` int(11) NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `language` varchar(50) NOT NULL,
  `financial_year` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `preferences`
--

INSERT INTO `preferences` (`id`, `app_name`, `currency`, `language`, `financial_year`, `created_at`, `updated_at`) VALUES
(1, 'mami', 'FCFA', 'english', 'january-december', '2025-02-08 13:56:09', '2025-04-12 00:50:22');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `phone`, `address`, `image`) VALUES
(8, 'arielle43@gmail.com', 'Arielle Laura', '25d55ad283aa400af464c76d713c07ad', '655418841', 'sciences', '1739019426_IMG-20240926-WA0105.jpg'),
(9, 'joshuatchioffouo423@gmail.com', 'josue', '25d55ad283aa400af464c76d713c07ad', '', '', ''),
(10, 'lara@gmail.com', 'lara', '25d55ad283aa400af464c76d713c07ad', '', '', '1739021706_Sans_titre-1.jpg'),
(11, 'nina@gmail.com', 'nina mimi', '$2y$10$XlIEwv01u0bhMFbXTWD.AeoaRquy/le068UnWU69uo1sie/L1.ucO', '', '', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `customer_details`
--
ALTER TABLE `customer_details`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_ibfk_1` (`customer_id`);

--
-- Index pour la table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `invoice_items_ibfk_2` (`item_id`);

--
-- Index pour la table `invoice_payments_advance`
--
ALTER TABLE `invoice_payments_advance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Index pour la table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Index pour la table `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `customer_details`
--
ALTER TABLE `customer_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `invoice_payments_advance`
--
ALTER TABLE `invoice_payments_advance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `preferences`
--
ALTER TABLE `preferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`),
  ADD CONSTRAINT `invoice_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `invoice_payments_advance`
--
ALTER TABLE `invoice_payments_advance`
  ADD CONSTRAINT `invoice_payments_advance_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
