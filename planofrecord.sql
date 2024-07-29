-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 29, 2024 at 05:02 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

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
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_hashed_token` varchar(255) DEFAULT NULL,
  `token_expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `email`, `password`, `password_hashed_token`, `token_expires_at`, `created_at`) VALUES
(10, 'Plan of Record', 'info@planofrecord.xyz', '$2y$10$FacNqIQFFv76IVVSDVyhee0/ypZCOqwK7QPsHHtKCygQMgpvcqpda', NULL, NULL, '2024-07-19 19:19:47'),
(11, 'Admin', 'admin@test.xyz', '$2y$10$Bbc3tUtNa0NXjJkGFZedJ.5zqQ3Xrr1jMEywnyED2QtamtryPVJti', NULL, NULL, '2024-07-23 15:18:47');

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
(410, 39, 'HPH_Train_Terminal_Posters_crop.mp4', 'Thumbnail', 'Thumbnail'),
(411, 39, 'Data Viz.png', 'Project-image', 'Project-image'),
(412, 39, 'Hoodie.png', 'Project-image', 'Project-image'),
(413, 39, 'IconPosters.png', 'Project-image', 'Project-image'),
(414, 39, 'IGPosts.png', 'Project-image', 'Project-image'),
(415, 39, 'NewsLetter.png', 'Project-image', 'Project-image'),
(416, 39, 'Tote.png', 'Project-image', 'Project-image'),
(417, 39, 'Magazine.png', 'Project-image', 'Project-image'),
(418, 39, '_HPH_IconConstruction.mp4', 'Project-image', 'Project-image'),
(419, 39, 'HPH_Principles_1280.mp4', 'Project-image', 'Project-image'),
(420, 39, 'StoryPages_Mockup 2.mp4', 'Project-image', 'Project-image'),
(421, 39, 'HPH_Airport_Lounge_screen_crop_1.mp4', 'Project-image', 'Project-image'),
(422, 39, 'HPH_Guidelines_main.mp4', 'Project-image', 'Project-image'),
(423, 39, 'torus_rays.gif', 'Project-image', 'Project-image'),
(424, 39, 'MM_Phone_HPH_Coffee_IG_Story_PoR_website.mp4', 'Project-image', 'Project-image'),
(432, 17, 'Haus.png', 'Project-image', 'Project-image');

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
(17, 15, '[[\"block1\"],[\"block2\"],[\"block3\",\"block3\"],[\"block3\",\"block3\"],[\"block2\"],[\"block1\",\"block1\"],[\"block3\",\"block3\",\"block3\"],[\"block2\"],[\"block1\"],[\"block2\",\"block3\"],[\"block4\"],[\"block5\"]]', '2024-06-11 17:26:22', '[[[[\"11.png\"]],[[\"15.png\"]],[[\"4.png\"],[]],[[],[\"7.png\"]],[[\"10.png\"]],[[\"5.png\"],[\"8.png\"]],[[\"4.png\"],[\"6.png\"],[\"2.png\"]],[[\"1.png\"]],[[\"18.png\"]],[[\"8.png\"],[\"2.png\"]],[[\"5.png\"]],[[\"11.png\"]]]]'),
(18, 16, '[[\"block1\"],[\"block2\"],[\"block2\",\"block3\"],[\"block4\",\"block4\",\"block4\"],[\"block5\"],[\"block5\",\"block5\"]]', '2024-06-11 22:06:30', '[[[[\"C.png\"]],[[\"A.png\"]],[[\"D.png\"],[\"B.png\"]],[[\"F.png\"],[\"I.png\"],[\"G.png\"]],[[\"8391365-hd_1920_1080_24fps.mp4\"]],[[\"D.png\"],[\"C.png\"]]]]'),
(19, 17, '[[\"block3\",\"block3\"]]', '2024-06-12 18:13:06', '[[[[\"Haus.png\"],[]]]]'),
(43, 39, '[[\"block5\"],[\"block5\"],[\"block5\"],[\"block5\"],[\"block5\"],[\"block5\"],[\"block5\"],[\"block5\"],[\"block5\"],[\"block5\"],[\"block5\"],[\"block5\"],[\"block5\"],[\"block5\"]]', '2024-07-11 18:12:30', '[[[[\"IconPosters.png\"]],[[\"_HPH_IconConstruction.mp4\"]],[[\"HPH_Guidelines_main.mp4\"]],[[\"HPH_Principles_1280.mp4\"]],[[\"IGPosts.png\"]],[[\"NewsLetter.png\"]],[[\"HPH_Airport_Lounge_screen_crop_1.mp4\"]],[[\"torus_rays.gif\"]],[[\"MM_Phone_HPH_Coffee_IG_Story_PoR_website.mp4\"]],[[\"Magazine.png\"]],[[\"Hoodie.png\"]],[[\"StoryPages_Mockup 2.mp4\"]],[[\"Data Viz.png\"]],[[\"Tote.png\"]]]]');

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
(15, 'NOW Running ', 'Motion-driven brand for active individuals.', 'Founder Jay brought us his vision for NOW, a brand that pulses with the rhythm of movement and the essence of activewear fashion. NOW is built on the idea that motion is the thread that connects us—it defines our humanity. We are beings in perpetual motion—every day is race day. Aimed at \"Active Lifestylists,\" those who blend health, wellness, activity, culture, fashion, and aesthetics, NOW fuses the spirit of movement with artistic expression. Look good, feel good—NOW is where style meets energy.', 'Brand Identity', 'Fashion & Beauty', 2024, '', '2024-06-11 13:13:25', NULL),
(16, 'Aeva Health', 'A holistic platform for women with autoimmune diseases', 'Crafting a brand for a holistic women\'s health platform, the founder\'s mission is clear: to empower women with autoimmune conditions through self-management. By addressing the interconnectedness of mind, body, and soul, the platform strives to minimize symptoms and foster overall well-being. With a visionary goal of creating an inclusive haven for women, the branding reflects a minimalistic, clean aesthetic. Inspired by modern beauty brands, it seamlessly blends trustworthiness with freshness and innovation.', 'Brand Identity', 'Health & Wellness', 2012, '', '2024-06-11 18:05:18', NULL),
(17, 'Asseto', 'Software to automate Brand Asset Creation', 'Introducing our groundbreaking digital product— to an intuitive solution that\'s meticulously crafted and branded by our team to revolutionize brandedcontent creation. It offers precise execution, saving designers time and costs, and setting new efficiency and excellence standards. Powered by generative AI, it swiftly creates branded assets, seamlessly integrating brand guidelines and output requirements across ad platforms, ensuring effortless consistency and time savings.', 'Brand Identity, Product Design', 'Tech', 2024, '', '2024-06-12 14:12:20', NULL),
(39, 'Harvard Public Health', 'Harvard Public Health', 'When Harvard Public Health sought to unify their magazine’s brand and marketing voice, they turned to us. We crafted a comprehensive 130-page brand guidelines, asset templates, and provided design recommendations for their editorial website. This brand toolkit amplifies the HPH brand across all promotional channels and audience touchpoints, ensuring a cohesive and memorable presence.', 'Brand Identity, Motion', 'Education, Health', 2024, '', '2024-07-11 14:12:22', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_hashed_token` (`password_hashed_token`) USING BTREE;

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
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=443;

--
-- AUTO_INCREMENT for table `layout`
--
ALTER TABLE `layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
