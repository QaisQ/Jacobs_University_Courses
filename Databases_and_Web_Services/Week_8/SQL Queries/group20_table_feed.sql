
-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

DROP TABLE IF EXISTS `feed`;
CREATE TABLE IF NOT EXISTS `feed` (
  `post_id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `content` blob NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `emergency_status` varchar(255) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
