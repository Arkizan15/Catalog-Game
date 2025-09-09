-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 09, 2025 at 03:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catalog-game`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int NOT NULL,
  `judul` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rilis` varchar(20) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `platform` varchar(100) DEFAULT NULL,
  `description` text,
  `developer` varchar(88) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `judul`, `rilis`, `genre`, `platform`, `description`, `developer`) VALUES
(1, 'A Space For The Unbound', '19 Januari 2023', 'Adventure, Narrative, Pixel Art', 'PC, Nintendo Switch, PS4/PS5, Xbox', 'A Space for the Unbound adalah game petualangan naratif dengan gaya pixel art yang indah, berlatar di sebuah kota kecil Indonesia pada era 1990-an. Kamu akan mengikuti kisah dua remaja yang berjuang mengatasi kecemasan, hubungan, dan realitas yang mulai retak oleh kekuatan misterius.', 'Mojiken Studios'),
(2, 'Celeste', '25 Januari 2018', 'Platformer, Indie, Pixel Art', 'PC (Windows), Nintendo Switch, PS4, Xbox One', 'Celeste adalah game platformer menantang tentang seorang gadis bernama Madeline yang mendaki Gunung Celeste. Game ini terkenal dengan gameplay presisi, musik indah, dan cerita emosional tentang perjuangan melawan kecemasan dan keraguan diri.', 'Maddy Makes Games'),
(3, 'Hollow Knight', '24 Februari 2017', 'Metroidvania, Action-Adventure', 'PC (Windows/macOS/Linux), Nintendo Switch, PS4, Xbox One', 'Hollow Knight adalah game Metroidvania 2D berlatar Hallownest—kerajaan bawah tanah yang luas. Eksplorasi non-linear, pertarungan presisi, upgrade kemampuan, dan boss menantang jadi inti pengalaman.', 'Team Cherry'),
(4, 'Minecraft', '18 November 2011', 'Sandbox, Survival, Adventure', 'PC, macOS, Linux, Xbox, PlayStation, Nintendo Switch, Mobile', 'Minecraft adalah game sandbox yang memungkinkan pemain membangun, menjelajah, bertahan hidup, dan berkreasi dalam dunia yang terdiri dari blok-blok 3D.', 'Mojang Studios'),
(5, 'OMORI', '25 Desember 2020', 'RPG, Psychological Horror, Indie', 'PC, macOS, Nintendo Switch, PS4, Xbox One', 'OMORI adalah game RPG psikologis yang bercerita tentang petualangan emosional di dunia penuh warna dan dunia gelap. Pemain akan menghadapi trauma, pertemanan, dan rahasia yang tersembunyi.', 'OMOCAT'),
(6, 'Persona 3 Reload', '2 Februari 2024', 'JRPG, Turn-Based, Story Rich', 'PC (Windows), PS4, PS5, Xbox One, Xbox Series X/S', 'Persona 3 Reload adalah remake modern dari Persona 3 klasik. Game ini menghadirkan grafis terbaru, gameplay turn-based RPG yang lebih halus, serta cerita mendalam tentang Persahabatan, Kehidupan Sekolah, dan pertempuran melawan Shadows di Dark Hour.', 'Atlus'),
(7, 'Persona 5', '15 September 2016', 'JRPG', 'PS3, PS4', 'Persona 5 adalah game role-playing Jepang yang dikembangkan oleh Atlus, bagian dari seri Persona, dengan cerita tentang Phantom Thieves of Hearts yang berjuang melawan ketidakadilan.', 'Atlus'),
(8, 'Stardew Valley', '26 Februari 2016', 'Simulation, RPG, Farming', 'PC, macOS, Linux, Nintendo Switch, PS4, Xbox One, Mobile', 'Stardew Valley adalah game simulasi pertanian dan RPG di mana pemain dapat bertani, beternak, menambang, memancing, serta menjalin hubungan dengan penduduk desa.', 'ConcernedApe'),
(9, 'Tekken 8', '26 Januari 2024', 'Fighting, Action', 'PC (Windows), PS5, Xbox Series X/S', 'Tekken 8 adalah seri terbaru dari franchise fighting legendaris Bandai Namco. Game ini hadir dengan grafis generasi terbaru menggunakan Unreal Engine 5, sistem Heat baru untuk pertempuran agresif, serta melanjutkan kisah konflik keluarga Mishima yang ikonik.', 'Bandai Namco Studios'),
(10, 'Ultraman Fighting Evolution 3', '9 December 2004', 'Fighting', 'PlayStation 2', 'Ultraman Fighting Evolution 3 adalah game pertarungan berbasis karakter Ultraman dengan berbagai mode cerita dan karakter dari seri Ultraman klasik hingga modern.', 'Banpresto'),
(11, 'Undertale', '15 September 2015', 'RPG, Indie', 'PC (Windows, macOS, Linux), PS4, PS Vita, Nintendo Switch, Xbox One', 'Undertale adalah RPG indie karya Toby Fox yang terkenal dengan sistem pertarungan uniknya, di mana pemain bisa memilih untuk bertarung atau berbelas kasih pada musuh. Ceritanya penuh humor, misteri, dan pilihan moral yang memengaruhi jalannya permainan.', 'Toby Fox');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(70) NOT NULL,
  `password` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'kiki', '$2y$10$jd9ENiwlIKDUXD6/.98Zz.GWocKKssbxX/BoHQBF9HbV.eVu0xAw.');

-- --------------------------------------------------------

--
-- Table structure for table `user_library`
--

CREATE TABLE `user_library` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `game_id` int NOT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_library`
--

INSERT INTO `user_library` (`id`, `user_id`, `game_id`, `added_at`) VALUES
(5, 1, 1, '2025-09-06 00:25:38'),
(8, 1, 7, '2025-09-08 01:47:27'),
(9, 1, 8, '2025-09-08 01:49:12'),
(10, 1, 6, '2025-09-08 01:49:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`,`username`);

--
-- Indexes for table `user_library`
--
ALTER TABLE `user_library`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_game` (`user_id`,`game_id`),
  ADD KEY `fk_game` (`game_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_library`
--
ALTER TABLE `user_library`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_library`
--
ALTER TABLE `user_library`
  ADD CONSTRAINT `fk_game` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
