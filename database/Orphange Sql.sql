CREATE DATABASE ChildCareCenter;

USE ChildCareCenter;

CREATE TABLE Children (
    id INT PRIMARY KEY,
    full_name VARCHAR(100),
    dob DATE,
    gender CHAR(1),
    nationality VARCHAR(50),
    special_needs TEXT
);

CREATE TABLE Staff (
    id INT PRIMARY KEY,
    name VARCHAR(100),
    contact_info VARCHAR(100),
    role VARCHAR(50),
    certifications TEXT
);

CREATE TABLE DailyActivities (
    id INT PRIMARY KEY,
    child_id INT,
    activity VARCHAR(100),
    time TIME,
    FOREIGN KEY (child_id) REFERENCES Children(id)
);

CREATE TABLE MedicalRecords (
    id INT PRIMARY KEY,
    child_id INT,
    record_date DATE,
    details TEXT,
    FOREIGN KEY (child_id) REFERENCES Children(id)
);

CREATE TABLE EducationalProgress (
    id INT PRIMARY KEY,
    child_id INT,
    grade_level INT,
    school_attendance INT,
    academic_achievements TEXT,
    FOREIGN KEY (child_id) REFERENCES Children(id)
);

CREATE TABLE Adoption (
    id INT PRIMARY KEY,
    child_id INT,
    family_id INT,
    status VARCHAR(50),
    FOREIGN KEY (child_id) REFERENCES Children(id)
);
ALTER TABLE Adoption ADD COLUMN date_of_placement DATE;
