-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2025 at 02:09 PM
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
-- Database: `hasmin_users`
--

-- --------------------------------------------------------

--
-- Table structure for table `tools`
--

CREATE TABLE `tools` (
  `tool_id` int(11) NOT NULL,
  `tool_name` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('available','out_of_stock') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tools`
--

INSERT INTO `tools` (`tool_id`, `tool_name`, `category`, `stock_quantity`, `image_url`, `status`) VALUES
(1, 'Banana Split Plate', 'Glassware', 30, 'tools/banana-split-plate.png', 'available'),
(2, 'Bar Spoon', 'Silverware', 50, 'tools/bar-spoon.png', 'available'),
(3, 'Bar Tray', 'Servingware', 21, 'tools/bar-tray.png', 'available'),
(4, 'Beer Mug', 'Glassware', 11, 'tools/beer-mug.png', 'available'),
(5, 'Bread Knife', 'Silverware', 15, 'tools/bread-knife.png', 'available'),
(6, 'Butcher Knife', 'Silverware', 2, 'tools/butcher-knife.png', 'available'),
(7, 'Butter Knife', 'Silverware', 50, 'tools/butter-knife.png', 'available'),
(8, 'Cake Slicer', 'Silverware', 2, 'tools/cake-slicer.png', 'available'),
(9, 'Ceramic Ramekin', 'Baking Tools', 50, 'tools/ceramic-ramekin.png', 'available'),
(10, 'Champagne', 'Glassware', 2, 'tools/champagne.png', 'available'),
(11, 'Glass Pitcher', 'Glassware', 50, 'tools/glass-pitcher.png', 'available'),
(12, 'Goblet', 'Glassware', 50, 'tools/goblet.png', 'available'),
(13, 'Gravy Boat and Saucer', 'Tableware', 50, 'tools/gravy-boat-saucer.png', 'available'),
(14, 'Highball Glass', 'Glassware', 50, 'tools/high-ball.png', 'available'),
(15, 'Ice Scoop', 'Bar Tools', 50, 'tools/ice-scoop.png', 'available'),
(16, 'Jigger', 'Bar Tools', 50, 'tools/jigger.png', 'available'),
(17, 'Large Shaker', 'Bar Tools', 50, 'tools/large-shaker.png', 'available'),
(18, 'Lasagna Plate', 'Tableware', 50, 'tools/lasagna-plate.png', 'available'),
(19, 'Mami Bowl', 'Tableware', 50, 'tools/mami-bowl.png', 'available'),
(20, 'Measuring Spoons', 'Kitchenware', 50, 'tools/measuring-spoons.png', 'available'),
(21, 'Parfait Glass', 'Glassware', 50, 'tools/parfait.png', 'available'),
(22, 'Pina Colada Glass', 'Glassware', 50, 'tools/pina-colada.png', 'available'),
(23, 'Puto Molder', 'Baking Tools', 50, 'tools/puto-molder.png', 'available'),
(24, 'Red Wine Glass', 'Glassware', 50, 'tools/red-wine.png', 'available'),
(25, 'Rice Cooker', 'Kitchenware', 50, 'tools/rice-cooker.png', 'available'),
(26, 'Round Baking Pan', 'Baking Tools', 50, 'tools/round-baking-pans.png', 'available'),
(27, 'Salad Fork', 'Silverware', 50, 'tools/salad-fork.png', 'available'),
(28, 'Salt and Pepper Shaker', 'Tableware', 50, 'tools/salt-pepper-shaker.png', 'available'),
(29, 'Sauce Dish', 'Tableware', 50, 'tools/sauce-dish.png', 'available'),
(30, 'Sauce Pourer', 'Glassware', 50, 'tools/sauce-glass.png', 'available'),
(31, 'Saucer', 'Tableware', 50, 'tools/saucer.png', 'available'),
(32, 'Serving Fork', 'Silverware', 50, 'tools/serving-fork.png', 'available'),
(33, 'Serving Spoon', 'Silverware', 50, 'tools/serving-spoon.png', 'available'),
(34, 'Serving Tray', 'Servingware', 50, 'tools/serving-tray.png', 'available'),
(35, 'Silicon Spatula', 'Kitchenware', 50, 'tools/silicon-spatula.png', 'available'),
(36, 'Small Shaker', 'Bar Tools', 50, 'tools/small-shaker.png', 'available'),
(37, 'Soda Glass', 'Glassware', 50, 'tools/soda.png', 'available'),
(38, 'Soup Bowl', 'Tableware', 50, 'tools/soup-bowl.png', 'available'),
(39, 'Stainless Baking Pan', 'Baking Tools', 50, 'tools/stainless-baking-pan.png', 'available'),
(40, 'Stainless Steel Bowl', 'Baking Tools', 50, 'tools/stainless-bowl.png', 'available'),
(41, 'Stainless Steel Kettle', 'Kitchenware', 50, 'tools/stainless-kettle.png', 'available'),
(42, 'Stainless Steel Ladle', 'Kitchenware', 50, 'tools/stainless-ladle.png', 'available'),
(43, 'Stainless Steel Sianse', 'Kitchenware', 50, 'tools/stainless-sianse.png', 'available'),
(44, 'Stainless Steel Tong', 'Kitchenware', 50, 'tools/stainless-tong.png', 'available'),
(45, 'Strainer', 'Kitchenware', 50, 'tools/strainer.png', 'available'),
(46, 'Turn Table', 'Tableware', 50, 'tools/turn-table.png', 'available'),
(47, 'White Wine Glass', 'Glassware', 50, 'tools/white-wine.png', 'available'),
(48, 'Wooden Bowl', 'Tableware', 50, 'tools/wooden-bowl.png', 'available'),
(49, 'Wooden Plate', 'Tableware', 50, 'tools/wooden-plate.png', 'available');

--
-- Triggers `tools`
--
DELIMITER $$
CREATE TRIGGER `update_stock_status` BEFORE UPDATE ON `tools` FOR EACH ROW BEGIN
    IF NEW.stock_quantity = 0 THEN
        SET NEW.status = 'out_of_stock';
    ELSE
        SET NEW.status = 'available';
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tools`
--
ALTER TABLE `tools`
  ADD PRIMARY KEY (`tool_id`),
  ADD UNIQUE KEY `tool_name` (`tool_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tools`
--
ALTER TABLE `tools`
  MODIFY `tool_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
