
-- --------------------------------------------------------

--
-- Table structure for table `donates_to`
--

DROP TABLE IF EXISTS `donates_to`;
CREATE TABLE IF NOT EXISTS `donates_to` (
  `donation_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`donation_id`),
  KEY `organization_id` (`organization_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
