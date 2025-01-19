-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2025 at 10:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `account`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id_admin` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `email` varchar(300) NOT NULL,
  `mdp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id_admin`, `name`, `email`, `mdp`) VALUES
(1, 'Islem Gharbiiiiiiiiiiiii', 'test@test', 'Test1234'),
(2, 'azerty', 'i@g', 'test1234');

-- --------------------------------------------------------

--
-- Table structure for table `bénéficiaire`
--

CREATE TABLE `bénéficiaire` (
  `id_beneficaire` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `handicap_type` varchar(100) NOT NULL,
  `needs` text NOT NULL,
  `documents` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bénéficiaire`
--

INSERT INTO `bénéficiaire` (`id_beneficaire`, `user_id`, `handicap_type`, `needs`, `documents`) VALUES
(12, 35, 'handicap multiple', 'klj', 'uploads/help.pdf'),
(13, 36, 'handicap multiple', 'jjkk', 'uploads/help.pdf'),
(14, 37, 'handicap moteur', 'jjjjjjjjj', 'uploads/help.pdf'),
(15, 41, 'handicap moteur', 'i need chaise roulatnte', 'uploads/help.pdf'),
(16, 43, 'handicap moteur', 'test', 'uploads/help.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `phone` int(8) NOT NULL,
  `msg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `nom`, `email`, `phone`, `msg`) VALUES
(8, 'Islem Gharbi', 'igharbi917@gmail.com', 27548745, 'hello can i ask');

-- --------------------------------------------------------

--
-- Table structure for table `donateur`
--

CREATE TABLE `donateur` (
  `id_donateur` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_dernier_don` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donateur`
--

INSERT INTO `donateur` (`id_donateur`, `user_id`, `date_dernier_don`) VALUES
(1, 77, '2025-01-01 03:16:24'),
(7, 67, '2024-01-02 12:13:00'),
(9, 70, '2024-11-19 19:45:27'),
(76, 75, '2024-04-05 00:00:00'),
(77, 73, '2024-12-18 23:55:09'),
(79, 82, NULL),
(80, 35, '2025-01-10 00:00:00'),
(81, 37, '2025-01-11 00:00:00'),
(82, 67, '2025-01-12 00:00:00'),
(83, 70, '2025-01-13 00:00:00'),
(84, 73, '2025-01-14 00:00:00'),
(85, 75, '2025-01-15 00:00:00'),
(86, 78, '2025-01-16 00:00:00'),
(87, 79, '2025-01-17 00:00:00'),
(88, 80, '2025-01-18 00:00:00'),
(89, 82, '2025-01-19 00:00:00'),
(90, 84, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dons_equipment`
--

CREATE TABLE `dons_equipment` (
  `id_equipment` int(11) NOT NULL,
  `id_donateur` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `type_equipment` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `etat` enum('neuf','occasion') NOT NULL,
  `disponabilite` enum('disponible','indisponible') NOT NULL DEFAULT 'disponible',
  `date_don` date NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `approve` enum('oui','non') DEFAULT 'non'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dons_equipment`
--

INSERT INTO `dons_equipment` (`id_equipment`, `id_donateur`, `quantite`, `type_equipment`, `image_path`, `description`, `etat`, `disponabilite`, `date_don`, `name`, `approve`) VALUES
(2, 9, 2, 'prothese main', 'uploads/pro1.jpeg', 'prothese pour adulte', 'occasion', 'disponible', '2024-11-20', 'prothèse ', 'oui'),
(3, 7, 5, 'béquilles', 'uploads/beq1.jpeg', 'bequilles pour enfant et adulte', 'neuf', 'disponible', '2024-11-20', 'bequilles', 'oui'),
(4, 7, 1, 'chaise roulante', 'uploads/ch1.jpg', 'chaise pour enfant', 'occasion', 'disponible', '2024-11-20', 'chaise', 'oui'),
(5, 77, 1, 'prothese jambe', 'uploads/proJ1.jpg', 'aaa', 'neuf', 'indisponible', '2024-11-20', 'prothèse ', 'oui'),
(7, 77, 1, 'béquilles', 'uploads/beq2.jpeg', 'aaaaaaaaaaaaaaa', 'neuf', 'disponible', '2024-11-20', 'bequilles', 'oui'),
(8, 77, 1, 'prothese jambe', 'uploads/proj4.jpg', 'aaaaaaaa', 'neuf', 'disponible', '2024-11-20', 'prothèse ', 'non'),
(9, 77, 2, 'prothese jambe', 'uploads/proJ5.jpeg', 'pour enfant', 'neuf', 'disponible', '2024-12-04', 'prothese', 'non'),
(10, 76, 1, 'prothese main', 'uploads/pro2.jpeg', 'pour adulte', 'occasion', 'disponible', '2024-12-04', 'prothese', 'oui'),
(11, 76, 2, 'béquilles', 'uploads/beq3.jpeg', 'pour enfant', 'occasion', 'indisponible', '2024-12-04', 'bequilles', 'oui'),
(12, 77, 1, 'béquilles', 'uploads/beq4.jpeg', 'pour enfants', 'occasion', 'disponible', '2024-12-13', 'bequilles ', 'non'),
(23, 79, 8888, 'béquilles', '', 'zz', 'neuf', 'disponible', '2025-01-17', '77777', 'non');

-- --------------------------------------------------------

--
-- Table structure for table `dons_financieres`
--

CREATE TABLE `dons_financieres` (
  `id_finance` int(11) NOT NULL,
  `id_donateur` int(11) DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_don` datetime DEFAULT current_timestamp(),
  `mode_paiement` varchar(50) DEFAULT NULL,
  `categorie` enum('soinsmedicaux','operations','equipments') NOT NULL,
  `approve` varchar(3) DEFAULT 'non'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dons_financieres`
--

INSERT INTO `dons_financieres` (`id_finance`, `id_donateur`, `montant`, `date_don`, `mode_paiement`, `categorie`, `approve`) VALUES
(90, 76, 150.00, '2025-01-15 12:15:47', 'bank_transfer', 'equipments', 'oui'),
(92, 79, 20.00, '2025-01-15 13:06:27', 'bank_transfer', 'soinsmedicaux', 'non'),
(163, 79, 150.00, '2025-01-15 21:27:22', 'credit_card', 'operations', 'non'),
(164, 9, 15.00, '2025-01-10 00:00:00', 'credit_card', 'operations', 'oui'),
(165, 7, 20.00, '2025-01-11 00:00:00', 'bank_transfer', 'equipments', 'non'),
(167, 77, 25.00, '2025-01-13 00:00:00', 'bank_transfer', 'operations', 'oui'),
(168, 79, 10.00, '2025-01-14 00:00:00', 'credit_card', 'equipments', 'non'),
(170, 87, 50.00, '2025-01-16 00:00:00', 'credit_card', 'operations', 'non'),
(171, 89, 35.00, '2025-01-17 00:00:00', 'bank_transfer', 'equipments', 'non'),
(173, 82, 220.00, '2025-01-19 00:00:00', 'bank_transfer', 'operations', 'non'),
(174, 81, 150.00, '2025-01-10 00:00:00', 'credit_card', 'operations', 'oui'),
(175, 83, 10.00, '2025-01-11 00:00:00', 'bank_transfer', 'equipments', 'oui'),
(176, 85, 40.00, '2025-01-12 00:00:00', 'credit_card', 'soinsmedicaux', 'oui'),
(177, 86, 250.00, '2025-01-13 00:00:00', 'bank_transfer', 'operations', 'oui'),
(178, 88, 30.00, '2025-01-14 00:00:00', 'credit_card', 'operations', 'oui'),
(179, 89, 20.00, '2025-01-15 00:00:00', 'bank_transfer', 'soinsmedicaux', 'non'),
(186, 1, 10.00, '2025-01-17 03:47:38', 'credit_card', 'equipments', 'oui'),
(198, 79, 12.00, '2025-01-17 14:46:24', 'credit_card', 'equipments', 'oui'),
(199, 79, 10.00, '2025-01-17 14:47:09', 'credit_card', 'equipments', 'non'),
(200, 79, 120.00, '2025-01-17 15:02:36', 'credit_card', 'equipments', 'non');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id_request` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_equipment` int(11) NOT NULL,
  `date_demande` datetime NOT NULL DEFAULT current_timestamp(),
  `approved` enum('En attente','Approuvé','Refusé') DEFAULT 'En attente',
  `dateReponse` datetime DEFAULT NULL,
  `documents` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id_request`, `user_id`, `id_equipment`, `date_demande`, `approved`, `dateReponse`, `documents`) VALUES
(9, 72, 2, '2025-01-17 06:51:14', 'En attente', '2025-01-17 12:39:28', 'uploads/help.pdf'),
(11, 43, 3, '2025-01-17 00:00:00', 'En attente', '2025-01-18 00:00:00', 'help.pdf'),
(12, 44, 4, '2025-01-17 00:00:00', 'En attente', '2025-01-18 00:00:00', 'help.pdf'),
(13, 74, 5, '2025-01-17 00:00:00', 'En attente', '2025-01-18 00:00:00', 'help.pdf'),
(14, 76, 8, '2025-01-17 00:00:00', 'En attente', '2025-01-18 00:00:00', 'help.pdf'),
(15, 72, 2, '2025-01-17 15:04:24', 'En attente', NULL, 'uploads/help.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `request_financiere`
--

CREATE TABLE `request_financiere` (
  `id_request` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `categorie` varchar(255) DEFAULT NULL,
  `montant` decimal(10,2) NOT NULL,
  `details` text DEFAULT NULL,
  `documents` text DEFAULT NULL,
  `date_request` datetime DEFAULT current_timestamp(),
  `approved` enum('En attente','En cours','Acceptée','Rejetée') DEFAULT 'En attente',
  `date_reponse` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_financiere`
--

INSERT INTO `request_financiere` (`id_request`, `user_id`, `categorie`, `montant`, `details`, `documents`, `date_request`, `approved`, `date_reponse`) VALUES
(1, 72, 'equipments', 120.00, 'je besoins chaise roulante', 'uploads/help.pdf', '2024-12-06 23:04:31', 'Acceptée', '2024-12-06 23:04:31'),
(2, 41, 'soinsmedicaux', 700.00, 'Je rencontre des difficultés pour finaliser le paiement de mon massage d\'un montant de 1020 DT.', 'uploads/help.pdf', '2025-01-15 13:20:37', 'Acceptée', '2025-01-15 13:20:37'),
(3, 41, 'operations', 1500.00, 'Demande de financement pour des interventions chirurgicales', 'uploads/help/operation_41.pdf', '2025-01-10 00:00:00', 'Acceptée', NULL),
(4, 43, 'equipments', 200.00, 'Demande pour l\'achat d\'équipements médicaux pour personnes handicapées', 'uploads/help/equipment_43.pdf', '2025-01-11 00:00:00', 'Acceptée', NULL),
(5, 44, 'soinsmedicaux', 450.00, 'Demande de prise en charge des soins médicaux urgents', 'uploads/help/soins_44.pdf', '2025-01-12 00:00:00', 'Acceptée', '2025-01-14 00:00:00'),
(6, 72, 'operations', 1800.00, 'Demande pour financer une opération cardiaque', 'uploads/help/operation_72.pdf', '2025-01-13 00:00:00', 'Acceptée', '2025-01-15 00:00:00'),
(7, 74, 'equipments', 350.00, 'Demande pour acheter des fauteuils roulants et prothèses', 'uploads/help/equipment_74.pdf', '2025-01-14 00:00:00', 'En attente', NULL),
(8, 76, 'soinsmedicaux', 1000.00, 'Demande de remboursement pour des soins médicaux nécessaires', 'uploads/help/soins_76.pdf', '2025-01-15 00:00:00', 'En cours', NULL),
(9, 72, 'soinsmedicaux', 120.00, 'qq', 'uploads/help.pdf', '2025-01-17 15:03:40', 'En attente', '2025-01-17 15:03:40'),
(10, 72, 'soinsmedicaux', 120000.00, 'qq', 'uploads/help.pdf', '2025-01-17 15:03:54', 'En attente', '2025-01-17 15:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `review_text`, `rating`, `created_at`) VALUES
(25, 35, 'I am very happy to contribute to such an important cause.', 5, '2025-01-15 10:09:44'),
(26, 36, 'Très satisfait de la possibilité de contribuer. Merci beaucoup.', 4, '2025-01-15 10:09:44'),
(27, 67, 'The donation process was smooth and efficient.', 5, '2025-01-15 10:09:44'),
(28, 70, 'C\'est un plaisir d\'aider les personnes dans le besoin.', 4, '2025-01-15 10:09:44'),
(29, 73, 'A wonderful platform to make a difference!', 5, '2025-01-15 10:09:44'),
(30, 41, 'Je suis très reconnaissant pour l\'aide que j\'ai reçue.', 5, '2025-01-15 10:09:44'),
(31, 43, 'The support provided was extremely helpful. Thank you!', 4, '2025-01-15 10:09:44'),
(32, 44, 'Les dons ont vraiment fait une grande différence dans ma vie.', 5, '2025-01-15 10:09:44'),
(33, 72, 'Thank you so much for the assistance. It means a lot.', 4, '2025-01-15 10:09:44'),
(34, 74, 'Cette plateforme a changé ma vie. Merci infiniment pour votre soutien.', 5, '2025-01-15 10:09:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(25) NOT NULL,
  `role` enum('donateur','beneficiaire') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `adress` varchar(255) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `pass`, `role`, `created_at`, `adress`, `phone_number`) VALUES
(35, 'Islem Gharbi', 'gharbiislem14@gmail.com', 'Bhyyhb4', 'donateur', '2024-11-06 10:24:37', 'ariana', '23409233'),
(36, 'Islem Gharbi', 'gharbiislem@gmail.com', 'Bhyyhb1', 'donateur', '2024-11-06 10:28:08', 'menihla', '23409233'),
(37, 'hela', 'gharbiislem14@gmail.co', 'Bhyyhb14', 'donateur', '2024-11-06 10:47:00', 'menihla', '23409233'),
(41, 'nourrrrrrrrrrrrrrrrrrrrrr', 'test0@testss', 'Bhyyhb0', 'beneficiaire', '2024-11-06 11:57:50', 'menihla', '56234567'),
(43, 'ahmed', 'test@test.test', 'Test14', 'beneficiaire', '2024-11-06 13:30:19', 'rue 196 cité ennaser menihla', '23409233'),
(44, 'aa', 'gha@gha', 'Gharbi0', 'beneficiaire', '2024-11-06 14:03:15', 'ben aarous', '58787474'),
(67, 'nour ', 'nour@gmail', 'Nour0', 'donateur', '2024-11-13 11:43:13', 'sousse', '52541741'),
(70, 'islem  gharbiiiiiiiiiiii', 'igharbi917@gmail.com', 'Bhyyhb917', 'donateur', '2024-11-14 11:43:29', '34 Rue de la Liberté, Tunis', '23409233'),
(72, 'Mohamed ', 'test1@test', 'Bhyyhb1', 'beneficiaire', '2024-11-20 10:09:54', 'sousssssss', '56874741'),
(73, 'Khaled ben ali', 'test2@test', 'Bhyyhb2', 'donateur', '2024-11-20 10:09:54', 'touzer', '56234568'),
(74, 'Leila Zine', 'test3@test', 'Bhyyhb3', 'beneficiaire', '2024-11-20 10:09:54', 'manouba', '29345789'),
(75, 'Aymen Jaziri', 'test4@test', 'Bhyyhb4', 'donateur', '2024-11-20 10:09:54', 'sousse', '24157415'),
(76, 'Sabrine Fadhel', 'test5@test', 'Bhyyhb5', 'beneficiaire', '2024-11-20 10:09:54', '34 Rue de la Liberté, Nabeul', '25632987'),
(77, 'Ahmed', 'test6@test', 'Bhyyhb6', 'donateur', '2024-12-04 13:52:50', 'Tunis, Habib Bourguiba Avenue', '25412345'),
(78, 'Sara', 'test7@test.com', 'Bhyyhb7', 'donateur', '2024-12-04 13:52:50', 'Sfax, Mohamed Ali Street', '952345678'),
(79, 'Moez', 'test8@test.com', 'Bhyyhb8', 'donateur', '2024-12-04 13:52:50', 'Nabeul, Hedi Chaker Avenue', '954567890'),
(80, 'Leila', 'test9@test.com', 'Bhyyhb9', 'donateur', '2024-12-04 13:52:50', 'Kairouan, Ibn Khaldoun Street', '956789012'),
(82, 'salma ben salah', 'salma@test', 'Salma0', 'donateur', '2025-01-15 13:00:08', 'sousse', '25456785'),
(84, 'Islem Gharbi', 'igharbi918@gmail.com', '123456M', 'donateur', '2025-01-17 14:39:02', 'csdddddddds', '27548745');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bénéficiaire`
--
ALTER TABLE `bénéficiaire`
  ADD PRIMARY KEY (`id_beneficaire`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donateur`
--
ALTER TABLE `donateur`
  ADD PRIMARY KEY (`id_donateur`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dons_equipment`
--
ALTER TABLE `dons_equipment`
  ADD PRIMARY KEY (`id_equipment`),
  ADD KEY `id_donateur` (`id_donateur`);

--
-- Indexes for table `dons_financieres`
--
ALTER TABLE `dons_financieres`
  ADD PRIMARY KEY (`id_finance`),
  ADD KEY `id_donateur` (`id_donateur`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id_equipment` (`id_equipment`);

--
-- Indexes for table `request_financiere`
--
ALTER TABLE `request_financiere`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bénéficiaire`
--
ALTER TABLE `bénéficiaire`
  MODIFY `id_beneficaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `donateur`
--
ALTER TABLE `donateur`
  MODIFY `id_donateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `dons_equipment`
--
ALTER TABLE `dons_equipment`
  MODIFY `id_equipment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `dons_financieres`
--
ALTER TABLE `dons_financieres`
  MODIFY `id_finance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `request_financiere`
--
ALTER TABLE `request_financiere`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bénéficiaire`
--
ALTER TABLE `bénéficiaire`
  ADD CONSTRAINT `bénéficiaire_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `donateur`
--
ALTER TABLE `donateur`
  ADD CONSTRAINT `donateur_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `dons_equipment`
--
ALTER TABLE `dons_equipment`
  ADD CONSTRAINT `dons_equipment_ibfk_1` FOREIGN KEY (`id_donateur`) REFERENCES `donateur` (`id_donateur`);

--
-- Constraints for table `dons_financieres`
--
ALTER TABLE `dons_financieres`
  ADD CONSTRAINT `dons_financieres_ibfk_1` FOREIGN KEY (`id_donateur`) REFERENCES `donateur` (`id_donateur`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`id_equipment`) REFERENCES `dons_equipment` (`id_equipment`);

--
-- Constraints for table `request_financiere`
--
ALTER TABLE `request_financiere`
  ADD CONSTRAINT `request_financiere_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
