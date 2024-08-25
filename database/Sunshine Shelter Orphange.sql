CREATE DATABASE SunshineShelter;
CREATE TABLE Children (
    ChildID VARCHAR(6) PRIMARY KEY,
    Name VARCHAR(100),
    DateOfBirth DATE,
    Gender VARCHAR(10),
    Nationality VARCHAR(50),
    SpecialNeeds TEXT
);

USE Sunshine_shelter;

CREATE TABLE Staff (
    StaffID VARCHAR(6) PRIMARY KEY,
    Name VARCHAR(100),
    ContactInfo VARCHAR(100),
    Role VARCHAR(50),
    Certifications TEXT
);

CREATE TABLE DailyActivities (
    ActivityID INT PRIMARY KEY,
    ChildID VARCHAR(6),
    StaffID VARCHAR(6),
    Date DATE,
    ActivityType VARCHAR(50),
    Details TEXT,
    FOREIGN KEY (ChildID) REFERENCES Children(ChildID)
    ON DELETE CASCADE,
    FOREIGN KEY (StaffID) REFERENCES Staff(StaffID)
    ON DELETE CASCADE
);

CREATE TABLE MedicalHistory (
    RecordID VARCHAR(6) PRIMARY KEY,
    ChildID VARCHAR(6),
    Date DATE,
    Vaccinations TEXT,
    Allergies TEXT,
    Treatments TEXT,
    FOREIGN KEY (ChildID) REFERENCES Children(ChildID)
    ON DELETE CASCADE
);

CREATE TABLE EducationalProgress (
    ProgressID VARCHAR(6) PRIMARY KEY,
    ChildID VARCHAR(6),
    GradeLevel VARCHAR(10),
    Attendance INT,
    Achievements TEXT,
    FOREIGN KEY (ChildID) REFERENCES Children(ChildID)
    ON DELETE CASCADE
);

CREATE TABLE Families (
    AdoptiveFamilyID VARCHAR(6) PRIMARY KEY,
    FamilyName VARCHAR(100),
    ManName VARCHAR(100),
    ManOccupation varchar(100),
    WomanName VARCHAR(100),
    WomanOccupation varchar(100),
    ContactInfo VARCHAR(100),
    Address TEXT
);

CREATE DATABASE SunshineShelter;
CREATE TABLE Children (
    ChildID VARCHAR(6) PRIMARY KEY,
    Name VARCHAR(100),
    DateOfBirth DATE,
    Gender VARCHAR(10),
    Nationality VARCHAR(50),
    SpecialNeeds TEXT
);

USE Sunshine_shelter;

CREATE TABLE Staff (
    StaffID VARCHAR(6) PRIMARY KEY,
    Name VARCHAR(100),
    ContactInfo VARCHAR(100),
    Role VARCHAR(50),
    Certifications TEXT
);

CREATE TABLE DailyActivities (
    ActivityID INT PRIMARY KEY,
    ChildID VARCHAR(6),
    StaffID VARCHAR(6),
    Date DATE,
    ActivityType VARCHAR(50),
    Details TEXT,
    FOREIGN KEY (ChildID) REFERENCES Children(ChildID)
    ON DELETE CASCADE,
    FOREIGN KEY (StaffID) REFERENCES Staff(StaffID)
    ON DELETE CASCADE
);

CREATE TABLE MedicalHistory (
    RecordID VARCHAR(6) PRIMARY KEY,
    ChildID VARCHAR(6),
    Date DATE,
    Vaccinations TEXT,
    Allergies TEXT,
    Treatments TEXT,
    FOREIGN KEY (ChildID) REFERENCES Children(ChildID)
    ON DELETE CASCADE
);

CREATE TABLE EducationalProgress (
    ProgressID VARCHAR(6) PRIMARY KEY,
    ChildID VARCHAR(6),
    GradeLevel VARCHAR(10),
    Attendance INT,
    Achievements TEXT,
    FOREIGN KEY (ChildID) REFERENCES Children(ChildID)
    ON DELETE CASCADE
);

CREATE TABLE Families (
    AdoptiveFamilyID VARCHAR(6) PRIMARY KEY,
    FamilyName VARCHAR(100),
    ManName VARCHAR(100),
    ManOccupation varchar(100),
    WomanName VARCHAR(100),
    WomanOccupation varchar(100),
    ContactInfo VARCHAR(100),
    Address TEXT
);

CREATE DATABASE SunshineShelter;
CREATE TABLE Children (
    ChildID VARCHAR(6) PRIMARY KEY,
    Name VARCHAR(100),
    DateOfBirth DATE,
    Gender VARCHAR(10),
    Nationality VARCHAR(50),
    SpecialNeeds TEXT
);

USE Sunshine_shelter;

CREATE TABLE Staff (
    StaffID VARCHAR(6) PRIMARY KEY,
    Name VARCHAR(100),
    ContactInfo VARCHAR(100),
    Role VARCHAR(50),
    Certifications TEXT
);

CREATE TABLE DailyActivities (
    ActivityID INT PRIMARY KEY,
    ChildID VARCHAR(6),
    StaffID VARCHAR(6),
    Date DATE,
    ActivityType VARCHAR(50),
    Details TEXT,
    FOREIGN KEY (ChildID) REFERENCES Children(ChildID)
    ON DELETE CASCADE,
    FOREIGN KEY (StaffID) REFERENCES Staff(StaffID)
    ON DELETE CASCADE
);

CREATE TABLE MedicalHistory (
    RecordID VARCHAR(6) PRIMARY KEY,
    ChildID VARCHAR(6),
    Date DATE,
    Vaccinations TEXT,
    Allergies TEXT,
    Treatments TEXT,
    FOREIGN KEY (ChildID) REFERENCES Children(ChildID)
    ON DELETE CASCADE
);

CREATE TABLE EducationalProgress (
    ProgressID VARCHAR(6) PRIMARY KEY,
    ChildID VARCHAR(6),
    GradeLevel VARCHAR(10),
    Attendance INT,
    Achievements TEXT,
    FOREIGN KEY (ChildID) REFERENCES Children(ChildID)
    ON DELETE CASCADE
);

CREATE TABLE Families (
    AdoptiveFamilyID VARCHAR(6) PRIMARY KEY,
    FamilyName VARCHAR(100),
    ManName VARCHAR(100),
    ManOccupation varchar(100),
    WomanName VARCHAR(100),
    WomanOccupation varchar(100),
    ContactInfo VARCHAR(100),
    Address TEXT
);

CREATE TABLE Adoptions (
    AdoptionID VARCHAR(6) PRIMARY KEY,
    ChildID VARCHAR(6),
    AdoptiveFamilyID VARCHAR(6),
    Status VARCHAR(50),
    DateOfPlacement DATE,
    FOREIGN KEY (ChildID) REFERENCES Children(ChildID)
    ON DELETE CASCADE,
    FOREIGN KEY (AdoptiveFamilyID) REFERENCES Families(AdoptiveFamilyID)
    ON DELETE CASCADE
);

CREATE TABLE Donations(
	DonationID Varchar(6) PRIMARY KEY,
    DonorName  Varchar(100),
    DonationDate Date,
    Amount Decimal(10,2),
    Purpose Varchar(100)
)