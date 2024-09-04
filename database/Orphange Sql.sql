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

CREATE TABLE Staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    contact_info VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL,
    certification TEXT NOT NULL
);

CREATE TABLE
    DailyActivities (
        ActivityID INT AUTO_INCREMENT PRIMARY KEY,
        ChildID INT,
        StaffID INT,
        Date DATE,
        ActivityType VARCHAR(50),
        Details TEXT,
        FOREIGN KEY (ChildID) REFERENCES Children (ChildID) ON DELETE CASCADE,
        FOREIGN KEY (StaffID) REFERENCES Staff (StaffID) ON DELETE CASCADE
    );