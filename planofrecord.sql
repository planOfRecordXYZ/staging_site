-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 13, 2024 at 02:20 PM
-- Server version: 5.7.24
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `planofrecord`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `image_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `image_url` varchar(200) NOT NULL,
  `type` varchar(100) NOT NULL,
  `alt_text` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `project_id`, `image_url`, `type`, `alt_text`) VALUES
(4, 2, 'IMG-screen.png', 'Thumbnail', 'TomEllicot-thumbnail'),
(5, 5, 'pexels-pavel-danilyuk-8438865.jpg', 'Thumbnail', 'Thumbnail'),
(6, 5, 'pexels-kjbromme-16647824.jpg', 'Hover_image', 'Hover Image'),
(7, 5, '8566809-uhd_2160_3840_30fps.mp4', 'Project-image', 'Project Image'),
(8, 5, 'bence-boros-anapPhJFRhM-unsplash.jpg', 'Project-image', 'Project Image'),
(9, 5, 'east-riding-archives-UwMslmQ4BqM-unsplash.jpg', 'Project-image', 'Project Image'),
(10, 5, 'pexels-alilove69-4883682.jpg', 'Project-image', 'Project Image'),
(11, 5, 'lenny-kuhne-jHZ70nRk7Ns-unsplash.jpg', 'Project-image', 'Project Image'),
(12, 5, 'austrian-national-library-3c1Jv1EXYtc-unsplash.jpg', 'Project-image', 'Project Image'),
(13, 6, 'pexels-pavel-danilyuk-8438865.jpg', 'Thumbnail', 'Thumbnail'),
(14, 6, 'pexels-kjbromme-16647824.jpg', 'Hover_image', 'Hover Image'),
(15, 6, '8566809-uhd_2160_3840_30fps.mp4', 'Project-image', 'Project Image'),
(16, 6, 'bence-boros-anapPhJFRhM-unsplash.jpg', 'Project-image', 'Project Image'),
(17, 6, 'east-riding-archives-UwMslmQ4BqM-unsplash.jpg', 'Project-image', 'Project Image'),
(18, 6, 'pexels-alilove69-4883682.jpg', 'Project-image', 'Project Image'),
(19, 6, 'lenny-kuhne-jHZ70nRk7Ns-unsplash.jpg', 'Project-image', 'Project Image'),
(20, 6, 'austrian-national-library-3c1Jv1EXYtc-unsplash.jpg', 'Project-image', 'Project Image'),
(27, 8, 'Unicorn.jpg', 'Thumbnail', 'Thumbnail'),
(28, 8, 'Blue.jpg', 'Hover_image', 'Hover Image'),
(29, 8, 'Birthday.jpg', 'Project-image', 'Project Image'),
(30, 8, 'Blue.jpg', 'Project-image', 'Project Image'),
(31, 8, 'Color.jpg', 'Project-image', 'Project Image'),
(32, 8, 'heartscrapbook.jpg', 'Project-image', 'Project Image'),
(33, 8, 'Keychain.jpg', 'Project-image', 'Project Image'),
(34, 8, 'RecipeBook.jpg', 'Project-image', 'Project Image'),
(35, 8, 'Unicorn.jpg', 'Project-image', 'Project Image'),
(36, 8, 'Valentines.mp4', 'Project-image', 'Project Image'),
(37, 9, 'Birthday.jpg', 'Thumbnail', 'Thumbnail'),
(38, 9, 'Color.jpg', 'Hover_image', 'Hover Image'),
(39, 9, 'Color.jpg', 'Project-image', 'Project Image'),
(40, 9, 'heartscrapbook.jpg', 'Project-image', 'Project Image'),
(41, 9, 'Keychain.jpg', 'Project-image', 'Project Image'),
(42, 9, 'Logo.png', 'Project-image', 'Project Image'),
(43, 9, 'LogoMain.png', 'Project-image', 'Project Image'),
(44, 9, 'Logo-white.png', 'Project-image', 'Project Image'),
(45, 9, 'RecipeBook.jpg', 'Project-image', 'Project Image'),
(46, 9, 'Unicorn.jpg', 'Project-image', 'Project Image'),
(47, 9, 'Valentines.mp4', 'Project-image', 'Project Image'),
(48, 10, 'Keychain.jpg', 'Thumbnail', 'Thumbnail'),
(49, 10, 'RecipeBook.jpg', 'Hover_image', 'Hover Image'),
(50, 10, 'Color.jpg', 'Project-image', 'Project Image'),
(51, 10, 'heartscrapbook.jpg', 'Project-image', 'Project Image'),
(52, 10, 'Keychain.jpg', 'Project-image', 'Project Image'),
(53, 10, 'RecipeBook.jpg', 'Project-image', 'Project Image'),
(54, 10, 'Unicorn.jpg', 'Project-image', 'Project Image'),
(55, 10, 'Valentines.mp4', 'Project-image', 'Project Image'),
(56, 11, 'Home.png', 'Thumbnail', 'Thumbnail'),
(57, 11, 'FindRecipe.png', 'Hover_image', 'Hover Image'),
(58, 11, 'Nutrimatch.png', 'Project-image', 'Project Image'),
(59, 12, 'Nutrimatch.png', 'Thumbnail', 'Thumbnail'),
(60, 12, 'monika-grabkowska-pHeX8H9WQpY-unsplash.jpg', 'Hover_image', 'Hover Image'),
(61, 12, 'Nutrimatch.png', 'Project-image', 'Project Image'),
(62, 13, 'sebastian-scholz-nuki-IJkSskfEqrM-unsplash.jpg', 'Thumbnail', 'Thumbnail'),
(63, 13, 'pexels-pavel-danilyuk-8438865.jpg', 'Hover_image', 'Hover Image'),
(64, 13, '4941457-hd_1920_1080_25fps.mp4', 'Project-image', 'Project Image'),
(65, 13, 'pexels-pavel-danilyuk-8438865.jpg', 'Project-image', 'Project Image'),
(66, 13, 'sebastian-scholz-nuki-IJkSskfEqrM-unsplash.jpg', 'Project-image', 'Project Image'),
(67, 13, 'east-riding-archives-UwMslmQ4BqM-unsplash.jpg', 'Project-image', 'Project Image'),
(68, 13, 'pexels-alilove69-4883682.jpg', 'Project-image', 'Project Image'),
(69, 14, '3015488-hd_1920_1080_24fps.mp4', 'Thumbnail', 'Thumbnail'),
(70, 14, 'pexels-ella-olsson-1640770.jpg', 'Hover_image', 'Hover Image'),
(71, 14, 'pexels-ella-olsson-1640774.jpg', 'Project-image', 'Project Image'),
(72, 14, 'pexels-ella-olsson-1640770.jpg', 'Project-image', 'Project Image'),
(73, 14, 'monika-grabkowska-pHeX8H9WQpY-unsplash.jpg', 'Project-image', 'Project Image'),
(74, 14, 'patrick-tomasso-GXXYkSwndP4-unsplash.jpg', 'Project-image', 'Project Image'),
(75, 14, 'caroline-green-Pqt1yIF-Fw0-unsplash.jpg', 'Project-image', 'Project Image'),
(76, 14, 'jessica-flores-7mL9de-MA4M-unsplash.jpg', 'Project-image', 'Project Image'),
(77, 14, 'elevate-snnhGYNqm44-unsplash.jpg', 'Project-image', 'Project Image'),
(78, 15, '8401254-hd_1920_1080_30fps.mp4', 'Thumbnail', 'Thumbnail'),
(79, 15, '11.png', 'Hover_image', 'Hover Image'),
(98, 15, '2.png', 'Project-image', 'Project Image'),
(99, 15, '3.png', 'Project-image', 'Project Image'),
(100, 15, '4.png', 'Project-image', 'Project Image'),
(101, 15, '5.png', 'Project-image', 'Project Image'),
(102, 15, '6.png', 'Project-image', 'Project Image'),
(103, 15, '7.png', 'Project-image', 'Project Image'),
(104, 15, '8.png', 'Project-image', 'Project Image'),
(105, 15, '9.png', 'Project-image', 'Project Image'),
(106, 15, '10.png', 'Project-image', 'Project Image'),
(107, 15, '11.png', 'Project-image', 'Project Image'),
(108, 15, '12.png', 'Project-image', 'Project Image'),
(109, 15, '13.png', 'Project-image', 'Project Image'),
(110, 15, '14.png', 'Project-image', 'Project Image'),
(111, 15, '15.png', 'Project-image', 'Project Image'),
(112, 15, '16.png', 'Project-image', 'Project Image'),
(113, 15, '17.png', 'Project-image', 'Project Image'),
(114, 15, '18.png', 'Project-image', 'Project Image'),
(115, 15, '1.png', 'Project-image', 'Project Image'),
(116, 16, '8391365-hd_1920_1080_24fps.mp4', 'Thumbnail', 'Thumbnail'),
(117, 16, 'D.png', 'Hover_image', 'Hover Image'),
(118, 16, 'A.png', 'Project-image', 'Project Image'),
(119, 16, 'B.png', 'Project-image', 'Project Image'),
(120, 16, 'C.png', 'Project-image', 'Project Image'),
(121, 16, 'D.png', 'Project-image', 'Project Image'),
(122, 16, 'E.png', 'Project-image', 'Project Image'),
(123, 16, 'F.png', 'Project-image', 'Project Image'),
(124, 16, 'G.png', 'Project-image', 'Project Image'),
(125, 16, 'HH.png', 'Project-image', 'Project Image'),
(126, 16, 'I.png', 'Project-image', 'Project Image'),
(127, 17, '4799815-hd_1920_1080_30fps.mp4', 'Thumbnail', 'Thumbnail'),
(128, 17, 'sebastian-scholz-nuki-IJkSskfEqrM-unsplash.jpg', 'Hover_image', 'Hover Image'),
(129, 17, 'Haus.png', 'Project-image', 'Project Image'),
(130, 17, 'charlotte-coneybeer-FhfhQUZsy0A-unsplash.jpg', 'Project-image', 'Project Image'),
(131, 17, 'arno-smit-sKJ7zSylUao-unsplash.jpg', 'Project-image', 'Project Image'),
(132, 17, 'jonatan-hernandez-AWkEp5ap-vw-unsplash.jpg', 'Project-image', 'Project Image'),
(133, 17, 'pankaj-patel-6JVlSdgMacE-unsplash.jpg', 'Project-image', 'Project Image'),
(134, 17, 'ilya-pavlov-OqtafYT5kTw-unsplash.jpg', 'Project-image', 'Project Image');

-- --------------------------------------------------------

--
-- Table structure for table `layout`
--

CREATE TABLE `layout` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `layout_data` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `media_assignments` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `layout`
--

INSERT INTO `layout` (`id`, `project_id`, `layout_data`, `created_at`, `media_assignments`) VALUES
(12, 10, '[[\"block2\",\"block3\"],[\"block2\"],[\"block2\"]]', '2024-06-06 16:05:38', '[[[[\"Color.jpg\"],[\"Keychain.jpg\"]],[[\"RecipeBook.jpg\"]],[[\"Valentines.mp4\"]]]]'),
(15, 13, '[[\"block2\",\"block2\"],[\"block2\"]]', '2024-06-10 15:00:44', '[[[[\"pexels-pavel-danilyuk-8438865.jpg\"],[\"4941457-hd_1920_1080_25fps.mp4\"]],[[\"pexels-alilove69-4883682.jpg\"]]]]'),
(16, 14, '[[\"block1\",\"block1\"],[\"block5\"],[\"block3\",\"block3\"],[\"block4\",\"block4\",\"block4\"]]', '2024-06-11 14:50:33', '[[[[\"monika-grabkowska-pHeX8H9WQpY-unsplash.jpg\"],[\"caroline-green-Pqt1yIF-Fw0-unsplash.jpg\"]],[[\"patrick-tomasso-GXXYkSwndP4-unsplash.jpg\"]],[[\"pexels-ella-olsson-1640770.jpg\"],[\"jessica-flores-7mL9de-MA4M-unsplash.jpg\"]],[[\"elevate-snnhGYNqm44-unsplash.jpg\"],[\"3015488-hd_1920_1080_24fps.mp4\"],[\"jessica-flores-7mL9de-MA4M-unsplash.jpg\"]]]]'),
(17, 15, '[[\"block1\"],[\"block2\"],[\"block3\",\"block3\"],[\"block3\",\"block3\"],[\"block2\"],[\"block1\",\"block1\"],[\"block3\",\"block3\",\"block3\"],[\"block2\"],[\"block1\"],[\"block2\",\"block3\"],[\"block4\"],[\"block5\"]]', '2024-06-11 17:26:22', '[[[[\"11.png\"]],[[\"15.png\"]],[[\"4.png\"],[]],[[],[\"7.png\"]],[[\"10.png\"]],[[\"5.png\"],[\"8.png\"]],[[\"4.png\"],[\"6.png\"],[\"2.png\"]],[[\"1.png\"]],[[\"18.png\"]],[[\"8.png\"],[\"2.png\"]],[[\"5.png\"]],[[\"11.png\"]]]]'),
(18, 16, '[[\"block1\"],[\"block2\"],[\"block2\",\"block3\"],[\"block4\",\"block4\",\"block4\"],[\"block5\"],[\"block5\",\"block5\"]]', '2024-06-11 22:06:30', '[[[[\"C.png\"]],[[\"A.png\"]],[[\"D.png\"],[\"B.png\"]],[[\"F.png\"],[\"I.png\"],[\"G.png\"]],[[\"8391365-hd_1920_1080_24fps.mp4\"]],[[\"D.png\"],[\"C.png\"]]]]'),
(19, 17, '[[\"block1\",\"block1\"],[\"block2\"],[\"block3\",\"block3\",\"block3\"]]', '2024-06-12 18:13:06', '[[[[\"Haus.png\"],[\"charlotte-coneybeer-FhfhQUZsy0A-unsplash.jpg\"]],[[\"arno-smit-sKJ7zSylUao-unsplash.jpg\"]],[[\"jonatan-hernandez-AWkEp5ap-vw-unsplash.jpg\"],[\"Haus.png\"],[\"sebastian-scholz-nuki-IJkSskfEqrM-unsplash.jpg\"]]]]');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `client` varchar(100) NOT NULL,
  `description_short` varchar(200) NOT NULL,
  `description_long` varchar(1000) NOT NULL,
  `type_of_work` varchar(200) NOT NULL,
  `industry` varchar(200) NOT NULL,
  `year` int(11) NOT NULL,
  `url` varchar(200) DEFAULT NULL,
  `addedtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `descriptionBlock` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `client`, `description_short`, `description_long`, `type_of_work`, `industry`, `year`, `url`, `addedtime`, `descriptionBlock`) VALUES
(6, 'Automation', 'Automation', 'AutomationAutomationAutomationAutomationAutomationAutomationAutomationAutomation', 'Automation', 'Automation', 2022, '', '2024-06-04 12:10:24', NULL),
(10, 'TwistedCartoons', 'TwistedCartoons', 'TwistedCartoonsTwistedCartoons', 'TwistedCartoons', 'TwistedCartoons', 2012, '', '2024-06-06 12:03:01', NULL),
(13, 'Automation', 'Automation', 'AutomationAutomationAutomation', 'Automation', 'Automation', 2021, '', '2024-06-10 11:00:01', NULL),
(14, 'FoodBlog', 'FoodBlog is a blog page for food', 'FoodBlog is a blog page for foodFoodBlog is a blog page for foodFoodBlog is a blog page for foodFoodBlog is a blog page for foodFoodBlog is a blog page for foodFoodBlog is a blog page for foodFoodBlog is a blog page for foodFoodBlog is a blog page for foodFoodBlog is a blog page for foodFoodBlog is a blog page for foodFoodBlog is a blog page for foodFoodBlog is a blog page for foodFoodBlog is a blog page for foodFoodBlog is a blog page for food', 'Blog', 'Food', 2022, '', '2024-06-11 10:43:10', NULL),
(15, 'NOW Running ', 'Motion-driven brand for active individuals.', 'Founder Jay brought us his vision for NOW, a brand that pulses with the rhythm of movement and the essence of activewear fashion. NOW is built on the idea that motion is the thread that connects us—it defines our humanity. We are beings in perpetual motion—every day is race day. Aimed at \"Active Lifestylists,\" those who blend health, wellness, activity, culture, fashion, and aesthetics, NOW fuses the spirit of movement with artistic expression. Look good, feel good—NOW is where style meets energy.', 'Brand Identity', 'Fashion & Beauty', 2024, '', '2024-06-11 13:13:25', NULL),
(16, 'Aeva Health', 'A holistic platform for women with autoimmune diseases', 'Crafting a brand for a holistic women\'s health platform, the founder\'s mission is clear: to empower women with autoimmune conditions through self-management. By addressing the interconnectedness of mind, body, and soul, the platform strives to minimize symptoms and foster overall well-being. With a visionary goal of creating an inclusive haven for women, the branding reflects a minimalistic, clean aesthetic. Inspired by modern beauty brands, it seamlessly blends trustworthiness with freshness and innovation.', 'Brand Identity', 'Health & Wellness', 2012, '', '2024-06-11 18:05:18', NULL),
(17, 'Asseto', 'Software to automate Brand Asset Creation', 'Introducing our groundbreaking digital product— to an intuitive solution that\'s meticulously crafted and branded by our team to revolutionize brandedcontent creation. It offers precise execution, saving designers time and costs, and setting new efficiency and excellence standards. Powered by generative AI, it swiftly creates branded assets, seamlessly integrating brand guidelines and output requirements across ad platforms, ensuring effortless consistency and time savings.', 'Brand Identity, Product Design', 'Tech', 2024, '', '2024-06-12 14:12:20', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `layout`
--
ALTER TABLE `layout`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `layout`
--
ALTER TABLE `layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `layout`
--
ALTER TABLE `layout`
  ADD CONSTRAINT `layout_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
