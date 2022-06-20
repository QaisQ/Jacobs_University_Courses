
-- --------------------------------------------------------

--
-- Table structure for table `partner_organizations`
--

DROP TABLE IF EXISTS `partner_organizations`;
CREATE TABLE IF NOT EXISTS `partner_organizations` (
  `organization_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `legal_certification` varchar(200) NOT NULL,
  `location` varchar(255) NOT NULL,
  PRIMARY KEY (`organization_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `partner_organizations`
--

INSERT INTO `partner_organizations` (`organization_id`, `name`, `email`, `password`, `phone_number`, `legal_certification`, `location`) VALUES
(1, 'UNICEF', 'main@unicef.com', '0', '1243325765', 'NGO_exists.com', 'location'),
(2, 'WHO', 'who@unicef.com', '0', '2147483647', 'NGO_exists.com', 'Bremen'),
(3, 'Vahid Gives Narcissism ', 'idk@gmail.com', 'helllajdfef1', '9765121212', 'thisisreal.promise', 'germany'),
(4, 'Second One', 'this@gmail.com', 'letssee453', '4145235235', 'thisisreal.promise', 'New York'),
(5, 'Okay Final', 'john@gmail.com', '[j[,om2020', '12345', 'thisisreal.promise', 'New York');
