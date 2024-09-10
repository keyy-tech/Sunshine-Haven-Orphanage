CREATE DATABASE childcarecenter;

USE childcharecenter;
CREATE TABLE `adoption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_id` int(11) DEFAULT NULL,
  `family_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `date_of_placement` date DEFAULT NULL,
  `placement_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `child_id` (`child_id`),
  CONSTRAINT `adoption_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`)
);

CREATE TABLE `children` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `special_needs` text DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `dailyactivities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_id` int(11) DEFAULT NULL,
  `activity` varchar(100) DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `child_id` (`child_id`),
  CONSTRAINT `dailyactivities_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`)
);

CREATE TABLE `donations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `donation_date` date NOT NULL,
  PRIMARY KEY (`id`)
);
CREATE TABLE `educationalprogress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_id` int(11) DEFAULT NULL,
  `grade_level` int(11) DEFAULT NULL,
  `school_attendance` int(11) DEFAULT NULL,
  `academic_achievements` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `child_id` (`child_id`),
  CONSTRAINT `educationalprogress_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`)
);

CREATE TABLE `families` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `contact_info` varchar(255) NOT NULL,
  `parent_name` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
); 

CREATE TABLE `medicalrecords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_id` int(11) DEFAULT NULL,
  `record_date` date DEFAULT NULL,
  `details` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `child_id` (`child_id`),
  CONSTRAINT `medicalrecords_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`)
); 

CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `certifications` text DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) 
