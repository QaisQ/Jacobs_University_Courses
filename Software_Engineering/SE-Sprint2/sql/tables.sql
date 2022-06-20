CREATE DATABASE
IF NOT EXISTS seteam26;

USE `seteam26`;

DROP TABLE IF EXISTS `Visitor`;

CREATE TABLE `Visitor` (
  `citizen_id` int NOT NULL AUTO_INCREMENT,
  `visitor_name` varchar(50) NOT NULL,
  `address` varchar(150) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `device_id` varchar(50) NOT NULL,
  `infected` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`citizen_id`)
);

DROP TABLE IF EXISTS `Places`;

CREATE TABLE `Places` (
  `place_id` int NOT NULL AUTO_INCREMENT,
  `place_name` varchar(50) NOT NULL,
  `address` varchar(150) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `QRcode` varchar(150) NOT NULL,
  PRIMARY KEY (`place_id`)
);

DROP TABLE IF EXISTS `VisitorToPlaces`;

CREATE TABLE `VisitorToPlaces` (
  `QRcode` varchar(150) NOT NULL,
  `device_id` varchar(50) NOT NULL,
  `entry_timestamp` timestamp NOT NULL,
  `exit_timestamp` timestamp NOT NULL,
  `citizen_id` int NOT NULL,
  `place_id` int NOT NULL,
  PRIMARY KEY (`QRcode`),
  FOREIGN KEY (`citizen_id`) REFERENCES Visitor(`citizen_id`),
  FOREIGN KEY (`place_id`) REFERENCES Places(`place_id`)

);
DROP TABLE IF EXISTS `Agent`;

CREATE TABLE `Agent` (
  `agent_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`agent_id`)
);

DROP TABLE IF EXISTS `Hospital`;

CREATE TABLE `Hospital` (
  `hospital_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`hospital_id`)
);

INSERT INTO `Agent` (`username`, `password`) VALUES ('agent1','arM54764jd?');
INSERT INTO `Hospital` (`username`, `password`) VALUES ('hospital1', 'wersdc?44');

-- CREATING USER
CREATE USER 'seteam26'@'localhost' IDENTIFIED BY 'oi8CFtOc';
GRANT ALL PRIVILEGES ON seteam26 . * TO 'seteam26'@'localhost';