
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE users(
  user_id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(255) NOT NULL,
  location varchar(255) DEFAULT NULL,
  first_name varchar(255) NOT NULL,
  last_name varchar(255) NOT NULL,
  password varchar(50) NOT NULL,
  email varchar(255) NOT NULL,
  phone_number varchar(255) DEFAULT NULL,
  PRIMARY KEY (user_id),
  UNIQUE KEY username (username)
) 
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `location`, `first_name`, `last_name`, `password`, `email`, `phone_number`) VALUES
(1, 'bobkat21', 'Bremen', 'Bob', 'Dylan', 'mememe212121', 'bob@aol', '13212412'),
(2, 'johhnygreen', 'Texas', 'John', 'Green', 'password', 'johhngreeenn@aol', '113413242'),
(3, 'hankgreen', 'Texas', 'Hank', 'Green', 'password2', 'HANKgreeenn@aol', '113413243'),
(4, 'vahid', 'Bremen', 'Vahid', 'Nesro', 'iwillnotremember', 'vahidmenu@gmail.com', '4125551212'),
(6, 'vahid3456', 'Bremen', 'Vahid', 'Nesro', 'pass', 'vahidmenu@gmail.com', '4125551212'),
(7, 'sakar1313', 'Nepal', 'Sakar', 'Gurubacharia', 'reanrenarena', 'sakariscool@gmail.com', '2147483647');
