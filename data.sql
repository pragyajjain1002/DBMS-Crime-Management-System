USE FIRM;

SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE Citizen;
TRUNCATE TABLE Station;
TRUNCATE TABLE Permission;
TRUNCATE TABLE User;
TRUNCATE TABLE Officer;
TRUNCATE TABLE Fir;
TRUNCATE TABLE Court;
TRUNCATE TABLE Cases;
TRUNCATE TABLE Suspect;

INSERT INTO Citizen #aadhaar name birth gender addr
VALUES
(0, '', DATE '1-1-1', 'M', ''),
(11111, 'Siddhant Kar', DATE '1998-12-17', 'M', 'Kanpur'),
(22222, 'Harsh Patel', DATE '1999-12-17', 'M', 'Kanpur'),
(33333, 'Harshit Sharma', DATE '1998-12-17', 'M', 'Kanpur');

INSERT INTO Station #id name phone email
VALUES
(1, 'Kanpur', '7429845', 'kanpurthana@gov.in', 'Kanpur'),
(2, 'Lucknow', '7429846', 'lucknowthana@gov.in', 'Lucknow'),
(3, 'Delhi ', '7429847', 'delhithana@gov.in', 'Delhi');

INSERT INTO Permission #id name
VALUES
(0, 'Normal'),
(100, 'Officer'),
(777, 'Admin');

INSERT INTO Court #id name place
VALUES
(1, 'DC', 'Kanpur'),
(2, 'HC', 'Lucknow'),
(3, 'SC', 'Delhi');

INSERT INTO User #username password aadhaar permission email
VALUES
('admin', 'admin', 0, 777, 'admin@admin'),
('siddhk', 'password', 11111, 0, 'siddhk@iitk.ac.in'),
('siddh', 'password', 11111, 0, 'siddhk@iitk.ac.in'),
('sidd', 'password', 11111, 0, 'siddhk@iitk.ac.in'),
('harshit', 'password', 33333, 0, 'siddhk@iitk.ac.in');

INSERT INTO Officer #id aadhaar station
VALUES
(1, 11111, 1),
(2, 22222, 1);
DELETE FROM Officer WHERE OfficerID = 2;

INSERT INTO Fir(FirID, Descr, Lodger)
VALUES
(1, 'Robbed', 'siddhk');

INSERT INTO Cases(CaseID, Type, FirID, CourtID)
VALUES
(1, 'Criminal', 1, 1);

INSERT INTO Suspect(SuspectID, AadhaarID, CaseID)
VALUES
(1, 33333, 1);

UPDATE Cases SET Verdict = 'Guilty' WHERE CaseID = 1;
