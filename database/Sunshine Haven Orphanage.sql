CREATE DATABASE Sunshine_Haven_Orphanage;
USE Sunshine_Haven_Orphanage;

CREATE TABLE Children (
    ChildID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100),
    DateOfBirth DATE,
    Gender VARCHAR(10),
    Nationality VARCHAR(50),
    SpecialNeeds TEXT
);

CREATE TABLE Staff (
    StaffID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100),
    ContactInfo VARCHAR(100),
    Role VARCHAR(50),
    Certifications TEXT
);

CREATE TABLE DailyActivities (
    ActivityID INT AUTO_INCREMENT PRIMARY KEY,
    ChildID INT,
    StaffID INT,
    Date DATE,
    ActivityType VARCHAR(50),
    Details TEXT,
    FOREIGN KEY (ChildID) REFERENCES Children(ChildID)
    ON DELETE CASCADE,
    FOREIGN KEY (StaffID) REFERENCES Staff(StaffID)
    ON DELETE CASCADE
);

CREATE TABLE MedicalHistory (
    RecordID INT AUTO_INCREMENT PRIMARY KEY,
    ChildID INT,
    Date DATE,
    Vaccinations TEXT,
    Allergies TEXT,
    Treatments TEXT,
    FOREIGN KEY (ChildID) REFERENCES Children(ChildID)
    ON DELETE CASCADE
);

CREATE TABLE EducationalProgress (
    ProgressID INT AUTO_INCREMENT PRIMARY KEY,
    ChildID INT,
    GradeLevel VARCHAR(10),
    Attendance INT,
    Achievements TEXT,
    FOREIGN KEY (ChildID) REFERENCES Children(ChildID)
    ON DELETE CASCADE
);

CREATE TABLE Families (
    AdoptiveFamilyID INT AUTO_INCREMENT PRIMARY KEY,
    FamilyName VARCHAR(100),
    ManName VARCHAR(100),
    ManOccupation varchar(100),
    WomanName VARCHAR(100),
    WomanOccupation varchar(100),
    ContactInfo VARCHAR(100),
    Address TEXT
);

CREATE TABLE Adoptions (
    AdoptionID INT AUTO_INCREMENT PRIMARY KEY,
    ChildID INT,
    AdoptiveFamilyID INT,
    Status VARCHAR(50),
    DateOfPlacement DATE,
    FOREIGN KEY (ChildID) REFERENCES Children(ChildID)
    ON DELETE CASCADE,
    FOREIGN KEY (AdoptiveFamilyID) REFERENCES Families(AdoptiveFamilyID)
    ON DELETE CASCADE
);

CREATE TABLE Donations(
    DonationID INT AUTO_INCREMENT PRIMARY KEY,
    DonorName  Varchar(100),
    DonationDate Date,
    Amount Decimal(10,2),
    Purpose Varchar(100)
);