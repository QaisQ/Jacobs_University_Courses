
-- --------------------------------------------------------

--
-- Table structure for table `bank_details_partners`
--

DROP TABLE IF EXISTS `bank_details_partners`;
CREATE TABLE IF NOT EXISTS `bank_details_partners` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) DEFAULT NULL,
  `bank_name` varchar(255) NOT NULL,
  `BIC` varchar(20) NOT NULL,
  `IBAN` varchar(20) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`bank_id`),
  UNIQUE KEY `IBAN` (`IBAN`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
