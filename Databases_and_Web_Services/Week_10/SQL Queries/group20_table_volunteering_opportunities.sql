
-- --------------------------------------------------------

--
-- Table structure for table `volunteering_opportunities`
--

DROP TABLE IF EXISTS `volunteering_opportunities`;
CREATE TABLE IF NOT EXISTS `volunteering_opportunities` (
  `volunteering_id` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `organization_name` varchar(200) NOT NULL,
  PRIMARY KEY (`volunteering_id`),
  UNIQUE KEY `name` (`event`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `volunteering_opportunities`
--

INSERT INTO `volunteering_opportunities` (`volunteering_id`, `event`, `email`, `contact_number`, `location`, `duration`, `organization_name`) VALUES
(1, 'Cloth Drive', 'main@UNICEF.com', '122222', 'London', '4 hours', 'UNICEF'),
(2, 'Be a Friend', 'vahidmenu@gmail.com', '4125551212', 'Bremen', '12 hours', 'YouNeedHelp.com'),
(3, 'Be a Friend2', 'main@gmail.com', '9877511122', 'Farmers Market, Idaho', '13 Hours', 'UNICEF');
