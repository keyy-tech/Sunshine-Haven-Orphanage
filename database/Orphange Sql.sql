CREATE DATABASE ChildCareCenter;

USE ChildCareCenter;

CREATE TABLE children (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    dob DATE,
    gender ENUM('Male', 'Female'),
    nationality VARCHAR(255),
    special_needs TEXT
);