
-- --------------------------------------------------------

--
-- Table structure for table `fundraisers`
--

DROP TABLE IF EXISTS `fundraisers`;
CREATE TABLE IF NOT EXISTS `fundraisers` (
  `fundraiser_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `login_key` int(11) NOT NULL,
  `contact_number` int(11) NOT NULL,
  PRIMARY KEY (`fundraiser_id`),
  UNIQUE KEY `name` (`name`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
