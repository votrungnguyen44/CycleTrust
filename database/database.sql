-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2026 at 07:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cycle_trust`
--

-- --------------------------------------------------------

--
-- Table structure for table `bikes`
--

CREATE TABLE `bikes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `condition_status` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `status` enum('available','sold','hidden') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bikes`
--

INSERT INTO `bikes` (`id`, `user_id`, `category_id`, `title`, `price`, `brand`, `condition_status`, `description`, `image_url`, `location`, `status`, `created_at`) VALUES
(2, 1, 1, 'Giant TCR Advanced Pro 1 Disc', 75000000.00, 'Giant', 'Đã sử dụng', 'Xe full carbon, group Ultegra, còn mới 95%. Lên dốc cực nhẹ.', NULL, 'TP.HCM', 'available', '2026-03-31 16:26:07'),
(3, 1, 2, 'Trek Marlin 7 Gen 2', 18500000.00, 'Trek', 'Mới', 'Xe đạp địa hình leo núi bền bỉ, phuộc RockShox êm ái, thắng đĩa thủy lực.', NULL, 'Hà Nội', 'available', '2026-03-31 16:26:07'),
(4, 1, 1, 'Specialized Tarmac SL7 Expert', 120000000.00, 'Specialized', 'Đã sử dụng', 'Hàng lướt, khung carbon FACT 10r siêu nhẹ, xé gió cực mượt.', NULL, 'Đà Nẵng', 'available', '2026-03-31 16:26:07'),
(5, 1, 3, 'Asama TRK FL2601', 3500000.00, 'Asama', 'Mới', 'Xe đạp cào cào thành phố, có baga tiện lợi đi chợ, đi học.', NULL, 'Hải Phòng', 'available', '2026-03-31 16:26:07'),
(6, 1, 1, 'Cannondale CAAD13 105', 45000000.00, 'Cannondale', 'Đã sử dụng', 'Vua nhôm, nhẹ ngang carbon, đạp cực bốc. Khung không vết xước.', NULL, 'TP.HCM', 'available', '2026-03-31 16:26:07'),
(7, 1, 2, 'Giant Roam 2 Disc', 14000000.00, 'Giant', 'Đã sử dụng', 'Xe touring lai MTB, đi xa thoải mái, bánh 700c lướt nhanh.', NULL, 'Hà Nội', 'available', '2026-03-31 16:26:07'),
(8, 1, 1, 'Pinarello Dogma F12', 250000000.00, 'Pinarello', 'Đã sử dụng', 'Siêu xe đạp đua chuyên nghiệp, groupset Dura-Ace Di2 điện tử.', NULL, 'TP.HCM', 'sold', '2026-03-31 16:26:07'),
(9, 1, 3, 'Trinx Free 2.0', 5500000.00, 'Trinx', 'Mới', 'Xe đạp phố giá rẻ, phù hợp sinh viên đi dạo, đi làm gần.', NULL, 'Đà Nẵng', 'available', '2026-03-31 16:26:07'),
(10, 1, 2, 'GT Avalanche Comp', 16000000.00, 'GT', 'Đã sử dụng', 'Khung nhôm Triple Triangle huyền thoại, chịu lực cực tốt.', NULL, 'Cần Thơ', 'available', '2026-03-31 16:26:07'),
(11, 1, 1, 'Cervelo S5', 180000000.00, 'Cervelo', 'Đã sử dụng', 'Xe Aero xé gió cực tốt, bánh mâm carbon 50mm.', NULL, 'Hà Nội', 'available', '2026-03-31 16:26:07'),
(12, 1, 1, 'Giant TCR Advanced Pro 1', 75000000.00, 'Giant', 'Đã sử dụng', 'Xe full carbon, group Ultegra. Lên dốc cực nhẹ.', 'https://images.unsplash.com/photo-1485965120184-e220f721d03e?auto=format&fit=crop&w=800&q=80', 'TP.HCM', 'available', '2026-03-31 16:28:16'),
(13, 1, 2, 'Trek Marlin 7 Gen 2', 18500000.00, 'Trek', 'Mới', 'Xe đạp địa hình leo núi bền bỉ, phuộc êm ái.', 'https://images.unsplash.com/photo-1534723452862-4c874018d66d?auto=format&fit=crop&w=800&q=80', 'Hà Nội', 'available', '2026-03-31 16:28:16'),
(14, 1, 1, 'Specialized Tarmac SL7', 120000000.00, 'Specialized', 'Đã sử dụng', 'Hàng lướt, khung carbon FACT 10r siêu nhẹ.', 'https://images.unsplash.com/photo-1532298229144-0ec0c57515c7?auto=format&fit=crop&w=800&q=80', 'Đà Nẵng', 'available', '2026-03-31 16:28:16'),
(15, 1, 3, 'Asama TRK City Bike', 3500000.00, 'Asama', 'Mới', 'Xe đạp cào cào thành phố, có baga tiện lợi.', 'https://images.unsplash.com/photo-1507035895480-2b3156c31fc8?auto=format&fit=crop&w=800&q=80', 'Hải Phòng', 'available', '2026-03-31 16:28:16'),
(16, 1, 1, 'Cannondale CAAD13', 45000000.00, 'Cannondale', 'Đã sử dụng', 'Vua nhôm, nhẹ ngang carbon, đạp cực bốc.', 'https://images.unsplash.com/photo-1511994298241-608e28f14fde?auto=format&fit=crop&w=800&q=80', 'TP.HCM', 'available', '2026-03-31 16:28:16'),
(17, 1, 2, 'Giant Roam Touring', 14000000.00, 'Giant', 'Đã sử dụng', 'Xe touring lai MTB, đi xa thoải mái.', 'https://images.unsplash.com/photo-1528629297340-d1d466945dc5?auto=format&fit=crop&w=800&q=80', 'Hà Nội', 'available', '2026-03-31 16:28:16'),
(18, 1, 1, 'Pinarello Dogma F12', 250000000.00, 'Pinarello', 'Đã sử dụng', 'Siêu xe đạp đua chuyên nghiệp.', 'https://images.unsplash.com/photo-1576435728678-68dd0f08ce13?auto=format&fit=crop&w=800&q=80', 'TP.HCM', 'sold', '2026-03-31 16:28:16'),
(19, 1, 2, 'GT Avalanche Comp MTB', 16000000.00, 'GT', 'Mới', 'Khung nhôm Triple Triangle huyền thoại.', 'https://images.unsplash.com/photo-1544188237-700810db69bb?auto=format&fit=crop&w=800&q=80', 'Cần Thơ', 'available', '2026-03-31 16:28:16'),
(50, 1, 1, 'Pinarello Dogma F12 (Like New)', 210000000.00, 'Pinarello', 'Mới 99%', 'Siêu xe đua hàng đầu thế giới. Khung carbon cao cấp, group Dura-Ace Di2 12 speed. Không xước một vết nhỏ.', 'https://images.unsplash.com/photo-1511994298241-608e281149c0?q=80&w=800', 'Quận 2, TP.HCM', 'available', '2026-04-01 04:23:52'),
(51, 1, 2, 'Giant Talon 2 2023', 12500000.00, 'Giant', 'Mới', 'Xe đạp địa hình quốc dân cho anh em mới chơi. Phuộc nhún mượt, phanh đĩa thủy lực an toàn.', 'https://images.unsplash.com/photo-1507035895480-2b3156c31fc8?q=80&w=800', 'Cầu Giấy, Hà Nội', 'available', '2026-04-01 04:23:52'),
(52, 1, 3, 'Asama TRK City Bike', 3500000.00, 'Asama', 'Đã sử dụng', 'Xe đạp cào cào thành phố, có baga tiện lợi đi chợ, chở đồ nhẹ nhàng. Phuộc cứng, dễ bảo dưỡng.', 'https://images.unsplash.com/photo-1532298229144-0ec0c57515c7?q=80&w=800', 'Hải Phòng', 'available', '2026-04-01 04:23:52'),
(53, 1, 1, 'Specialized Tarmac SL7 Expert', 145000000.00, 'Specialized', 'Mới 95%', 'Hàng lướt, khung carbon FACT 10r siêu nhẹ, xé gió cực tốt. Bánh Roval carbon mâm cao.', 'https://images.unsplash.com/photo-1485965120184-e220f721d03e?q=80&w=800', 'Đà Nẵng', 'available', '2026-04-01 04:23:52'),
(54, 1, 2, 'Trek Marlin 7 Gen 2', 18500000.00, 'Trek', 'Mới', 'Xe đạp địa hình leo núi bền bỉ. Phuộc RockShox êm ái, bộ truyền động Shimano Deore 1x10.', 'https://images.unsplash.com/photo-1576435728678-68ce0f622473?q=80&w=800', 'Quận 1, TP.HCM', 'available', '2026-04-01 04:23:52'),
(55, 1, 3, 'Trinx Free 2.0', 5500000.00, 'Trinx', 'Đã sử dụng', 'Xe đạp phố giá rẻ cho sinh viên. Group Shimano Tourney 21 tốc độ, đi học đi làm cực tiện.', 'https://images.unsplash.com/photo-1511994298241-608e281149c0?q=80&w=800', 'Thủ Đức, TP.HCM', 'available', '2026-04-01 04:23:52'),
(56, 1, 1, 'Cannondale CAAD13 105', 45000000.00, 'Cannondale', 'Đã sử dụng', 'Vua nhôm, nhẹ ngang carbon, đạp cực bốc. Khung không vết móp, group Shimano 105 r7000.', 'https://images.unsplash.com/photo-1507035895480-2b3156c31fc8?q=80&w=800', 'Thanh Xuân, Hà Nội', 'available', '2026-04-01 04:23:52'),
(57, 1, 2, 'GT Avalanche Comp', 16000000.00, 'GT', 'Mới 99%', 'Khung nhôm Triple Triangle huyền thoại, chịu lực cực tốt. Phuộc Suntour XCM 100mm.', 'https://images.unsplash.com/photo-1532298229144-0ec0c57515c7?q=80&w=800', 'Cần Thơ', 'available', '2026-04-01 04:23:52'),
(58, 1, 3, 'Giant Roam 2 Disc', 14000000.00, 'Giant', 'Mới', 'Xe touring lai MTB, đi xa thoải mái, bánh 700c lướt nhanh nhưng vẫn có phuộc nhún êm ái.', 'https://images.unsplash.com/photo-1485965120184-e220f721d03e?q=80&w=800', 'Bình Thạnh, TP.HCM', 'available', '2026-04-01 04:23:52'),
(59, 1, 1, 'Cervelo S5 (Khung sườn)', 110000000.00, 'Cervelo', 'Mới', 'Chỉ bán khung sườn (Frame kit) Cervelo S5 đời mới nhất. Kèm ghi đông potang carbon nguyên khối.', 'https://images.unsplash.com/photo-1576435728678-68ce0f622473?q=80&w=800', 'Quận 7, TP.HCM', 'available', '2026-04-01 04:23:52'),
(60, 1, 2, 'Santa Cruz Hightower', 95000000.00, 'Santa Cruz', 'Đã sử dụng', 'Quái vật Enduro, leo dốc tốt, đổ đèo bao phê. Phuộc trước sau hành trình dài, bảo dưỡng mỡ bò đầy đủ.', 'https://images.unsplash.com/photo-1511994298241-608e281149c0?q=80&w=800', 'Đà Lạt', 'available', '2026-04-01 04:23:52'),
(61, 1, 3, 'Thống Nhất Nữ 24 inch', 2500000.00, 'Thống Nhất', 'Đã sử dụng', 'Xe đạp nữ màu hồng phấn, giỏ xe rộng, yên nệm lò xo cực êm. Phù hợp các mẹ đi chợ.', 'https://images.unsplash.com/photo-1507035895480-2b3156c31fc8?q=80&w=800', 'Gò Vấp, TP.HCM', 'available', '2026-04-01 04:23:52'),
(62, 1, 1, 'Merida Scultura 400', 25000000.00, 'Merida', 'Mới 95%', 'Xe road khung nhôm siêu nhẹ, phuộc carbon. Nước sơn zin còn bóng loáng, líp sên chưa mòn.', 'https://images.unsplash.com/photo-1532298229144-0ec0c57515c7?q=80&w=800', 'Nha Trang', 'available', '2026-04-01 04:23:52'),
(63, 1, 2, 'Cube Aim Pro', 14500000.00, 'Cube', 'Mới', 'Hàng nhập Đức, thiết kế khung giấu dây tinh tế. Phanh đĩa Tektro bóp cực ăn.', 'https://images.unsplash.com/photo-1485965120184-e220f721d03e?q=80&w=800', 'Quận 3, TP.HCM', 'available', '2026-04-01 04:23:52'),
(64, 1, 3, 'Brompton C Line (Xe gấp)', 48000000.00, 'Brompton', 'Mới 99%', 'Xe gấp gọn chuẩn Anh Quốc, bỏ cốp ô tô hoặc mang lên tàu điện ngầm thoải mái. Bản 6 líp.', 'https://images.unsplash.com/photo-1576435728678-68ce0f622473?q=80&w=800', 'Hoàn Kiếm, Hà Nội', 'available', '2026-04-01 04:23:52');

-- --------------------------------------------------------

--
-- Table structure for table `bike_images`
--

CREATE TABLE `bike_images` (
  `id` int(11) NOT NULL,
  `bike_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Road Bike', 'road'),
(2, 'Mountain Bike', 'mtb'),
(3, 'City Bike', 'city');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bike_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `reviewed_user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `phone`, `role`, `created_at`) VALUES
(1, 'pain1', 'p@p.com', '$2y$10$k9Eti5IRED1ge0j1osWYt.ngzDcNcLgTyfYejSD./OHHQp9znDf/e', '0123456789', 'user', '2026-03-31 04:48:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bikes`
--
ALTER TABLE `bikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `bike_images`
--
ALTER TABLE `bike_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bike_id` (`bike_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_bike` (`user_id`,`bike_id`),
  ADD KEY `bike_id` (`bike_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviewer_id` (`reviewer_id`),
  ADD KEY `reviewed_user_id` (`reviewed_user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bikes`
--
ALTER TABLE `bikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `bike_images`
--
ALTER TABLE `bike_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bikes`
--
ALTER TABLE `bikes`
  ADD CONSTRAINT `bikes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bikes_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `bike_images`
--
ALTER TABLE `bike_images`
  ADD CONSTRAINT `bike_images_ibfk_1` FOREIGN KEY (`bike_id`) REFERENCES `bikes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`bike_id`) REFERENCES `bikes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`reviewed_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- Xóa tất cả xe không có ảnh (NULL) hoặc để trống đường dẫn
