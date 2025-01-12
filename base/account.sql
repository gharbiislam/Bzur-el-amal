-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2025 at 08:05 PM
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
(1, 'Islem Gharbi', 'test@test', 'test1234'),
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
(12, 35, 'h_multiple', 'klj', ''),
(13, 36, 'h_multiple', 'jjkk', ''),
(14, 37, 'h_audictive', 'jjjjjjjjj', 'icons8-lightning-bolt-100.png'),
(15, 41, 'h_moteur', 'jjjjjjjjj', 'icons8-medical-doctor-100.png'),
(16, 43, 'h_moteur', 'test', 'diagramme de classe.png'),
(17, 44, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `donateur`
--

CREATE TABLE `donateur` (
  `id_donateur` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type_don` enum('equipment','financiere') DEFAULT NULL,
  `date_dernier_don` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donateur`
--

INSERT INTO `donateur` (`id_donateur`, `user_id`, `type_don`, `date_dernier_don`) VALUES
(7, 67, 'financiere', '0000-00-00 00:00:00'),
(9, 70, 'equipment', '2024-11-19 19:45:27'),
(76, 75, 'financiere', '2024-11-22 13:37:50'),
(77, 73, 'financiere', '2024-12-18 23:55:09');

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
(2, 9, 2, 'prothese main', 'uploads/prothèse3.jpg', 'prothese pour adulte', 'occasion', 'disponible', '2024-11-20', 'prothèse ', 'oui'),
(3, 7, 5, 'béquilles', 'uploads/bequilles8.jpg', 'bequilles pour enfant et adulte', 'neuf', 'disponible', '2024-11-20', 'bequilles', 'oui'),
(4, 7, 1, 'chaise roulante', 'uploads/chaise9.jpg', 'chaise pour enfant', 'occasion', 'disponible', '2024-11-20', 'chaise', 'oui'),
(5, 77, 1, 'prothese jambe', 'uploads/prothese3.webp', 'aaa', 'neuf', 'indisponible', '2024-11-20', 'prothèse ', 'oui'),
(7, 77, 1, 'béquilles', 'uploads/bequilles2.jpg', 'aaaaaaaaaaaaaaa', 'neuf', 'disponible', '2024-11-20', 'bequilles', 'non'),
(8, 77, 1, 'prothese jambe', 'uploads/prothese1.jpg', 'aaaaaaaa', 'neuf', 'disponible', '2024-11-20', 'prothèse ', 'non'),
(9, 77, 2, 'prothese jambe', 'uploads/prothese8.png', 'pour enfant', 'neuf', 'disponible', '2024-12-04', 'prothese', 'non'),
(10, 76, 1, 'prothese main', 'uploads/prothèse2.jpg', 'pour adulte', 'occasion', 'disponible', '2024-12-04', 'prothese', 'non'),
(11, 76, 2, 'béquilles', 'uploads/bequilles1.png', 'pour enfant', 'occasion', 'disponible', '2024-12-04', 'bequilles', 'non'),
(12, 77, 1, 'béquilles', 'uploads/bequilles1.jpg', 'pour enfants', 'occasion', 'disponible', '2024-12-13', 'bequilles ', 'non');

-- --------------------------------------------------------

--
-- Table structure for table `dons_financieres`
--

CREATE TABLE `dons_financieres` (
  `new_id` int(11) NOT NULL,
  `id_don` int(11) NOT NULL,
  `id_donateur` int(11) DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_don` datetime DEFAULT current_timestamp(),
  `mode_paiement` varchar(50) DEFAULT NULL,
  `categorie` enum('soinsmedicaux','operations','equipments') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dons_financieres`
--

INSERT INTO `dons_financieres` (`new_id`, `id_don`, `id_donateur`, `montant`, `date_don`, `mode_paiement`, `categorie`) VALUES
(79, 0, 77, 30.00, '2024-12-11 10:55:04', 'bank_transfer', 'operations'),
(81, 0, 77, 120.00, '2024-12-11 10:56:27', 'bank_transfer', 'operations'),
(83, 0, 77, 129.00, '2024-12-11 10:58:14', 'bank_transfer', 'soinsmedicaux'),
(84, 0, 77, 129.00, '2024-12-11 11:24:02', 'bank_transfer', 'equipments'),
(85, 0, 77, 90.00, '2024-12-11 11:34:56', 'bank_transfer', 'operations'),
(86, 0, 77, 10.00, '2024-12-11 11:48:19', 'bank_transfer', 'equipments');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id_request` int(11) NOT NULL,
  `id_equipment` int(11) DEFAULT NULL,
  `date_demande` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved` enum('en cours','Acceptée','Rejetée','En attente') DEFAULT 'En attente',
  `dateReponse` timestamp NULL DEFAULT current_timestamp(),
  `documents` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id_request`, `id_equipment`, `date_demande`, `approved`, `dateReponse`, `documents`, `user_id`) VALUES
(23, 4, '2024-12-04 10:25:21', 'En attente', '2024-12-04 10:41:31', 'uploads/grp-02.png', 72),
(24, 3, '2024-12-04 10:28:34', 'En attente', '2024-12-04 10:41:28', 'uploads/Projet_unity 3D.pdf', 72),
(25, 2, '2024-12-04 11:34:22', 'En attente', '2024-12-06 08:31:47', 'uploads/Bzur el amal.pdf', 72),
(26, 4, '2024-12-06 08:21:03', 'En attente', '2024-12-06 08:31:50', 'uploads/Bzur el amal.pdf', 74),
(27, 3, '2024-12-06 08:21:26', 'En attente', '2024-12-06 08:31:55', 'uploads/www.redcross.org_donate_holiday-giving_help-where-its-needed-most.html_.png', 74),
(28, 2, '2024-12-06 08:22:54', 'En attente', '2024-12-06 08:31:52', 'uploads/www.redcross.org_donate_holiday-giving_help-where-its-needed-most.html_ (1).png', 74),
(29, 3, '2024-12-06 08:25:47', 'En attente', '2024-12-06 08:31:58', 'uploads/www.redcross.org_donate_holiday-giving_help-where-its-needed-most.html_ (1).png', 76);

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
(1, 72, 'equipments', 452.00, 'je besoins chaise roulante', 'uploads/www.redcross.org_donate_holiday-giving_help-where-its-needed-most.html_.png', '2024-12-06 23:04:31', 'En attente', '2024-12-06 23:04:31');

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
(35, 'Islem Gharbi', 'gharbiislem14@gmail.com', 'bhyyhb', 'donateur', '2024-11-06 10:24:37', 'ariana', '23409233'),
(36, 'Islem Gharbi', 'gharbiislem@gmail.com', 'bhyyhb', 'donateur', '2024-11-06 10:28:08', 'menihla', '23409233'),
(37, 'hela', 'gharbiislem14@gmail.co', 'jj', 'donateur', '2024-11-06 10:47:00', 'menihla', '23409233'),
(41, 'nour', 'test0@test', 'bbbbbbb', 'beneficiaire', '2024-11-06 11:57:50', 'menihla', '23409233'),
(43, 'ahmed', 'test@test.test', 'test', 'beneficiaire', '2024-11-06 13:30:19', 'rue 196 cité ennaser menihla', '23409233'),
(44, '', 'gha@gha', '', '', '2024-11-06 14:03:15', 'ben aarous', '78787474'),
(67, 'nour ', 'nour@gmail', 'aaaaaa', 'donateur', '2024-11-13 11:43:13', '', '23409233'),
(70, 'islem  gharbiiiiiiiiiiii', 'igharbi917@gmail.com', 'bhyyhb', 'donateur', '2024-11-14 11:43:29', '', '23409233'),
(72, 'Mohamed ', 'test1@test', 'bhyyhb', 'beneficiaire', '2024-11-20 10:09:54', 'mnihla', '58-123-100'),
(73, 'Khaled ben ali', 'test2@test', 'bhyyhb', 'donateur', '2024-11-20 10:09:54', 'touzer', '56234568'),
(74, 'Leila Zine', 'test3@test', 'bhyyhb', 'beneficiaire', '2024-11-20 10:09:54', '', '29-345-6789'),
(75, 'Aymen Jaziri', 'test4@test', 'bhyyhb', 'donateur', '2024-11-20 10:09:54', '78 Rue Hédi Chaker, Sousse', '55-456-7890'),
(76, 'Sabrine Fadhel', 'test5@test', 'bhyyhb', 'beneficiaire', '2024-11-20 10:09:54', '34 Rue de la Liberté, Nabeul', '72-567-8901'),
(77, 'Ahmed', 'test6@test.com', 'bhyyhb', 'donateur', '2024-12-04 13:52:50', 'Tunis, Habib Bourguiba Avenue', '254123456'),
(78, 'Sara', 'test7@test.com', 'jhghgh', 'donateur', '2024-12-04 13:52:50', 'Sfax, Mohamed Ali Street', '952345678'),
(79, 'Moez', 'test8@test.com', 'kjhgkj', 'donateur', '2024-12-04 13:52:50', 'Nabeul, Hedi Chaker Avenue', '954567890'),
(80, 'Leila', 'test9@test.com', 'zxcvbnm', 'donateur', '2024-12-04 13:52:50', 'Kairouan, Ibn Khaldoun Street', '956789012');

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
  ADD PRIMARY KEY (`new_id`),
  ADD KEY `id_donateur` (`id_donateur`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `id_equipment` (`id_equipment`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `request_financiere`
--
ALTER TABLE `request_financiere`
  ADD PRIMARY KEY (`id_request`),
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
-- AUTO_INCREMENT for table `donateur`
--
ALTER TABLE `donateur`
  MODIFY `id_donateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `dons_equipment`
--
ALTER TABLE `dons_equipment`
  MODIFY `id_equipment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dons_financieres`
--
ALTER TABLE `dons_financieres`
  MODIFY `new_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `request_financiere`
--
ALTER TABLE `request_financiere`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

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
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`id_beneficaire`) REFERENCES `bénéficiaire` (`id_beneficaire`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`id_equipment`) REFERENCES `dons_equipment` (`id_equipment`);

--
-- Constraints for table `request_financiere`
--
ALTER TABLE `request_financiere`
  ADD CONSTRAINT `request_financiere_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
