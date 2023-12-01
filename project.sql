-- Drop existing tables
DROP TABLE PaymentsHistory ;
DROP TABLE Locker ;
DROP TABLE Attendances ;
DROP TABLE GuestPass ;
DROP TABLE RegistersFor ;
DROP TABLE WorkshopScheduleSub ;
DROP TABLE RegularMemberBranches ;
DROP TABLE PremiumMemberBranches ;
DROP TABLE Coach ;
DROP TABLE GymBranches ;
DROP TABLE Members ;


-- Create Members table
CREATE TABLE Members (
    MemberID INTEGER PRIMARY KEY,
    Email VARCHAR2(100) UNIQUE,
    Name VARCHAR2(50),
    Age INTEGER,
    StartDate DATE,
    MemberType VARCHAR2(10) CHECK (MemberType IN ('regular', 'premium'))
);
GRANT SELECT ON Members TO PUBLIC;

-- Create GymBranches table
CREATE TABLE GymBranches (
    BranchID INTEGER PRIMARY KEY,
    Address VARCHAR2(100),
    Capacity INTEGER,
    CurrentUsers INTEGER
);
GRANT SELECT ON GymBranches TO PUBLIC;

-- Create Coach table
CREATE TABLE Coach (
    CoachID INTEGER PRIMARY KEY,
    Name VARCHAR2(50),
    YearOfExperience INTEGER
);
GRANT SELECT ON Coach TO PUBLIC;

-- Create RegularMemberBranches table
CREATE TABLE RegularMemberBranches (
    MemberID INTEGER PRIMARY KEY REFERENCES Members(MemberID) ON DELETE CASCADE,
    BranchID INTEGER NOT NULL REFERENCES GymBranches(BranchID) ON DELETE CASCADE
);
GRANT SELECT ON RegularMemberBranches TO PUBLIC;

-- Create PremiumMemberBranches table
CREATE TABLE PremiumMemberBranches (
    MemberID INTEGER,
    BranchID INTEGER NOT NULL,
    PRIMARY KEY (MemberID, BranchID),
    FOREIGN KEY (MemberID) REFERENCES Members(MemberID) ON DELETE CASCADE,
    FOREIGN KEY (BranchID) REFERENCES GymBranches(BranchID) ON DELETE CASCADE
);
GRANT SELECT ON PremiumMemberBranches TO PUBLIC;

-- Create WorkshopScheduleSub table
CREATE TABLE WorkshopScheduleSub (
    WorkshopID INTEGER PRIMARY KEY,
    WorkshopName VARCHAR2(50),
    WorkshopDuration INTERVAL DAY TO SECOND,
    CoachID INTEGER NOT NULL REFERENCES Coach(CoachID) ON DELETE CASCADE,
    WorkshopDate DATE,
    BranchID INTEGER REFERENCES GymBranches(BranchID) ON DELETE CASCADE
);
GRANT SELECT ON WorkshopScheduleSub TO PUBLIC;

-- Create PaymentsHistory table
CREATE TABLE PaymentsHistory (
    PaymentID INTEGER PRIMARY KEY,
    MemberID INTEGER NOT NULL REFERENCES Members(MemberID) ON DELETE CASCADE,
    Amount FLOAT,
    Title VARCHAR2(50),
    PaymentDate DATE,
    PaymentMethod VARCHAR2(20)
);
GRANT SELECT ON PaymentsHistory TO PUBLIC;

-- Create Locker table
CREATE TABLE Locker (
    LockerNo INTEGER,
    BranchID INTEGER,
    IsAvailable CHAR(1) CHECK (IsAvailable IN ('Y', 'N')),
    PRIMARY KEY (LockerNo, BranchID),
    FOREIGN KEY (BranchID) REFERENCES GymBranches(BranchID) ON DELETE CASCADE
);
GRANT SELECT ON Locker TO PUBLIC;

-- Create Attendances table
CREATE TABLE Attendances (
    MemberID INTEGER,
    AttendanceDate DATE,
    CheckInTime INTERVAL DAY TO SECOND,
    CheckOutTime INTERVAL DAY TO SECOND,
    BranchID INTEGER,
    PRIMARY KEY (MemberID, AttendanceDate, CheckInTime, CheckOutTime),
    FOREIGN KEY (MemberID) REFERENCES Members(MemberID) ON DELETE CASCADE,
    FOREIGN KEY (BranchID) REFERENCES GymBranches(BranchID) ON DELETE CASCADE
);
GRANT SELECT ON Attendances TO PUBLIC;

-- Create GuestPass table
CREATE TABLE GuestPass (
    PassID INTEGER PRIMARY KEY,
    MemberID INTEGER NOT NULL REFERENCES Members(MemberID) ON DELETE CASCADE,
    StartDate DATE,
    EndDate DATE
);
GRANT SELECT ON GuestPass TO PUBLIC;

-- Create RegistersFor table
CREATE TABLE RegistersFor (
    MemberID INTEGER,
    WorkshopID INTEGER,
    PRIMARY KEY (MemberID, WorkshopID),
    FOREIGN KEY (MemberID) REFERENCES Members(MemberID) ON DELETE CASCADE,
    FOREIGN KEY (WorkshopID) REFERENCES WorkshopScheduleSub(WorkshopID) ON DELETE CASCADE
);
GRANT SELECT ON RegistersFor TO PUBLIC;

-- Insert Data into Members table
INSERT INTO Members (MemberID, Email, Name, Age, StartDate, MemberType) VALUES (1, 'member1@email.com', 'John Doe', 20, TO_DATE('2023-01-01', 'YYYY-MM-DD'), 'regular');
INSERT INTO Members (MemberID, Email, Name, Age, StartDate, MemberType) VALUES (2, 'member2@email.com', 'Jane Doe', 30, TO_DATE('2023-02-01', 'YYYY-MM-DD'), 'premium');
INSERT INTO Members (MemberID, Email, Name, Age, StartDate, MemberType) VALUES (3, 'member3@email.com', 'Alice Smith', 23, TO_DATE('2023-01-15', 'YYYY-MM-DD'), 'regular');
INSERT INTO Members (MemberID, Email, Name, Age, StartDate, MemberType) VALUES (4, 'member4@email.com', 'Bob Johnson', 26, TO_DATE('2023-02-20', 'YYYY-MM-DD'), 'regular');
INSERT INTO Members (MemberID, Email, Name, Age, StartDate, MemberType) VALUES (5, 'member5@email.com', 'Ema Washington', 28, TO_DATE('2023-02-26', 'YYYY-MM-DD'), 'premium');


-- Insert Data into GymBranches table
INSERT INTO GymBranches (BranchID, Address, Capacity, CurrentUsers) VALUES (101, '123 Gym Street', 100, 50);
INSERT INTO GymBranches (BranchID, Address, Capacity, CurrentUsers) VALUES (102, '456 Fitness Ave', 150, 75);
INSERT INTO GymBranches (BranchID, Address, Capacity, CurrentUsers) VALUES (103, '789 Wellness Blvd', 120, 60);
INSERT INTO GymBranches (BranchID, Address, Capacity, CurrentUsers) VALUES (104, '321 Fitness St', 200, 100);

-- Insert Data into Coach table
INSERT INTO Coach (CoachID, Name, YearOfExperience) VALUES (1, 'Coach A', 5);
INSERT INTO Coach (CoachID, Name, YearOfExperience) VALUES (2, 'Coach B', 3);
INSERT INTO Coach (CoachID, Name, YearOfExperience) VALUES (3, 'Coach C', 7);
INSERT INTO Coach (CoachID, Name, YearOfExperience) VALUES (4, 'Coach D', 4);
INSERT INTO Coach (CoachID, Name, YearOfExperience) VALUES (5, 'Coach A', 5);
INSERT INTO Coach (CoachID, Name, YearOfExperience) VALUES (6, 'Coach B', 5);
INSERT INTO Coach (CoachID, Name, YearOfExperience) VALUES (7, 'Coach C', 3);
INSERT INTO Coach (CoachID, Name, YearOfExperience) VALUES (8, 'Coach D', 2);

-- Insert Data into RegularMemberBranches table
INSERT INTO RegularMemberBranches (MemberID, BranchID) VALUES (1, 101);
INSERT INTO RegularMemberBranches (MemberID, BranchID) VALUES (3, 103);
INSERT INTO RegularMemberBranches (MemberID, BranchID) VALUES (4, 103);

-- Insert Data into PremiumMemberBranches table
INSERT INTO PremiumMemberBranches (MemberID, BranchID) VALUES (2, 101);
INSERT INTO PremiumMemberBranches (MemberID, BranchID) VALUES (2, 102);
INSERT INTO PremiumMemberBranches (MemberID, BranchID) VALUES (2, 103);
INSERT INTO PremiumMemberBranches (MemberID, BranchID) VALUES (2, 104);
INSERT INTO PremiumMemberBranches (MemberID, BranchID) VALUES (5, 101);
INSERT INTO PremiumMemberBranches (MemberID, BranchID) VALUES (5, 102);
INSERT INTO PremiumMemberBranches (MemberID, BranchID) VALUES (5, 103);

-- Insert Data into WorkshopScheduleSub table
INSERT INTO WorkshopScheduleSub (WorkshopID, WorkshopName, WorkshopDuration, CoachID, WorkshopDate, BranchID)
VALUES (1, 'Yoga Class', INTERVAL '1' HOUR, 1, TO_DATE('2023-03-15', 'YYYY-MM-DD'), 101);
INSERT INTO WorkshopScheduleSub (WorkshopID, WorkshopName, WorkshopDuration, CoachID, WorkshopDate, BranchID)
VALUES (2, 'Pilates Class', INTERVAL '1' HOUR, 2, TO_DATE('2023-03-16', 'YYYY-MM-DD'), 102);
INSERT INTO WorkshopScheduleSub (WorkshopID, WorkshopName, WorkshopDuration, CoachID, WorkshopDate, BranchID)
VALUES (3, 'Kickboxing', INTERVAL '1' HOUR, 3, TO_DATE('2023-03-20', 'YYYY-MM-DD'), 103);
INSERT INTO WorkshopScheduleSub (WorkshopID, WorkshopName, WorkshopDuration, CoachID, WorkshopDate, BranchID)
VALUES (4, 'Spin Class', INTERVAL '1' HOUR, 4, TO_DATE('2023-03-21', 'YYYY-MM-DD'), 104);

-- Insert Data into PaymentsHistory table
INSERT INTO PaymentsHistory (PaymentID, MemberID, Amount, Title, PaymentDate, PaymentMethod)
VALUES (1, 1, 100.0, 'Monthly Fee', TO_DATE('2023-03-01', 'YYYY-MM-DD'), 'Credit Card');
INSERT INTO PaymentsHistory (PaymentID, MemberID, Amount, Title, PaymentDate, PaymentMethod)
VALUES (2, 2, 150.0, 'Monthly Fee', TO_DATE('2023-03-02', 'YYYY-MM-DD'), 'Debit');
INSERT INTO PaymentsHistory (PaymentID, MemberID, Amount, Title, PaymentDate, PaymentMethod)
VALUES (3, 3, 80.0, 'Monthly Fee', TO_DATE('2023-03-15', 'YYYY-MM-DD'), 'Cash');
INSERT INTO PaymentsHistory (PaymentID, MemberID, Amount, Title, PaymentDate, PaymentMethod)
VALUES (4, 4, 120.0, 'Monthly Fee', TO_DATE('2023-03-25', 'YYYY-MM-DD'), 'Credit Card');
INSERT INTO PaymentsHistory (PaymentID, MemberID, Amount, Title, PaymentDate, PaymentMethod)
VALUES (5, 5, 150.0, 'Monthly Fee', TO_DATE('2023-03-01', 'YYYY-MM-DD'), 'Credit Card');

-- Insert Data into Locker table
INSERT INTO Locker (LockerNo, BranchID, IsAvailable) VALUES (1, 101, 'Y');
INSERT INTO Locker (LockerNo, BranchID, IsAvailable) VALUES (2, 101, 'Y');
INSERT INTO Locker (LockerNo, BranchID, IsAvailable) VALUES (1, 102, 'N');
INSERT INTO Locker (LockerNo, BranchID, IsAvailable) VALUES (2, 102, 'N');
INSERT INTO Locker (LockerNo, BranchID, IsAvailable) VALUES (3, 102, 'Y');
INSERT INTO Locker (LockerNo, BranchID, IsAvailable) VALUES (1, 103, 'Y');
INSERT INTO Locker (LockerNo, BranchID, IsAvailable) VALUES (2, 103, 'Y');
INSERT INTO Locker (LockerNo, BranchID, IsAvailable) VALUES (3, 103, 'Y');
INSERT INTO Locker (LockerNo, BranchID, IsAvailable) VALUES (1, 104, 'Y');
INSERT INTO Locker (LockerNo, BranchID, IsAvailable) VALUES (2, 104, 'N');
INSERT INTO Locker (LockerNo, BranchID, IsAvailable) VALUES (3, 104, 'Y');
INSERT INTO Locker (LockerNo, BranchID, IsAvailable) VALUES (4, 104, 'N');

-- Insert Data into Attendances table
INSERT INTO Attendances (MemberID, AttendanceDate, CheckInTime, CheckOutTime, BranchID)
VALUES (1, TO_DATE('2023-03-10', 'YYYY-MM-DD'), INTERVAL '09:00' HOUR TO MINUTE, INTERVAL '11:00' HOUR TO MINUTE, 101);
INSERT INTO Attendances (MemberID, AttendanceDate, CheckInTime, CheckOutTime, BranchID)
VALUES (2, TO_DATE('2023-03-11', 'YYYY-MM-DD'), INTERVAL '10:00' HOUR TO MINUTE, INTERVAL '12:00' HOUR TO MINUTE, 102);
INSERT INTO Attendances (MemberID, AttendanceDate, CheckInTime, CheckOutTime, BranchID)
VALUES (2, TO_DATE('2023-03-10', 'YYYY-MM-DD'), INTERVAL '09:00' HOUR TO MINUTE, INTERVAL '11:00' HOUR TO MINUTE, 101);
INSERT INTO Attendances (MemberID, AttendanceDate, CheckInTime, CheckOutTime, BranchID)
VALUES (2, TO_DATE('2023-03-15', 'YYYY-MM-DD'), INTERVAL '10:00' HOUR TO MINUTE, INTERVAL '12:00' HOUR TO MINUTE, 103);
INSERT INTO Attendances (MemberID, AttendanceDate, CheckInTime, CheckOutTime, BranchID)
VALUES (2, TO_DATE('2023-03-16', 'YYYY-MM-DD'), INTERVAL '08:00' HOUR TO MINUTE, INTERVAL '10:00' HOUR TO MINUTE, 104);
INSERT INTO Attendances (MemberID, AttendanceDate, CheckInTime, CheckOutTime, BranchID)
VALUES (3, TO_DATE('2023-03-15', 'YYYY-MM-DD'), INTERVAL '10:00' HOUR TO MINUTE, INTERVAL '12:00' HOUR TO MINUTE, 103);
INSERT INTO Attendances (MemberID, AttendanceDate, CheckInTime, CheckOutTime, BranchID)
VALUES (4, TO_DATE('2023-03-16', 'YYYY-MM-DD'), INTERVAL '08:00' HOUR TO MINUTE, INTERVAL '10:00' HOUR TO MINUTE, 104);
INSERT INTO Attendances (MemberID, AttendanceDate, CheckInTime, CheckOutTime, BranchID)
VALUES (5, TO_DATE('2023-04-01', 'YYYY-MM-DD'), INTERVAL '10:00' HOUR TO MINUTE, INTERVAL '12:00' HOUR TO MINUTE, 102);
INSERT INTO Attendances (MemberID, AttendanceDate, CheckInTime, CheckOutTime, BranchID)
VALUES (5, TO_DATE('2023-04-10', 'YYYY-MM-DD'), INTERVAL '09:00' HOUR TO MINUTE, INTERVAL '11:00' HOUR TO MINUTE, 101);
INSERT INTO Attendances (MemberID, AttendanceDate, CheckInTime, CheckOutTime, BranchID)
VALUES (5, TO_DATE('2023-05-15', 'YYYY-MM-DD'), INTERVAL '10:00' HOUR TO MINUTE, INTERVAL '12:00' HOUR TO MINUTE, 103);
INSERT INTO Attendances (MemberID, AttendanceDate, CheckInTime, CheckOutTime, BranchID)
VALUES (5, TO_DATE('2023-05-16', 'YYYY-MM-DD'), INTERVAL '08:00' HOUR TO MINUTE, INTERVAL '10:00' HOUR TO MINUTE, 104);

-- Insert Data into GuestPass table
INSERT INTO GuestPass (PassID, MemberID, StartDate, EndDate) VALUES (1, 1, TO_DATE('2023-03-05', 'YYYY-MM-DD'), TO_DATE('2023-03-12', 'YYYY-MM-DD'));
INSERT INTO GuestPass (PassID, MemberID, StartDate, EndDate) VALUES (2, 2, TO_DATE('2023-03-06', 'YYYY-MM-DD'), TO_DATE('2023-03-13', 'YYYY-MM-DD'));
INSERT INTO GuestPass (PassID, MemberID, StartDate, EndDate) VALUES (3, 3, TO_DATE('2023-03-10', 'YYYY-MM-DD'), TO_DATE('2023-03-17', 'YYYY-MM-DD'));
INSERT INTO GuestPass (PassID, MemberID, StartDate, EndDate) VALUES (4, 4, TO_DATE('2023-03-12', 'YYYY-MM-DD'), TO_DATE('2023-03-19', 'YYYY-MM-DD'));
INSERT INTO GuestPass (PassID, MemberID, StartDate, EndDate) VALUES (5, 5, TO_DATE('2023-02-26', 'YYYY-MM-DD'), TO_DATE('2023-03-05', 'YYYY-MM-DD'));

-- Insert Data into RegistersFor table
INSERT INTO RegistersFor (MemberID, WorkshopID) VALUES (1, 1);
INSERT INTO RegistersFor (MemberID, WorkshopID) VALUES (2, 2);
INSERT INTO RegistersFor (MemberID, WorkshopID) VALUES (3, 3);
INSERT INTO RegistersFor (MemberID, WorkshopID) VALUES (4, 3);
INSERT INTO RegistersFor (MemberID, WorkshopID) VALUES (5, 4);

