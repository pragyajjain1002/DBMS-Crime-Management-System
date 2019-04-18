USE FIRM;

INSERT INTO Citizen #aadhaar name birth gender addr
VALUES
(0, '', DATE '2000-1-1', 'M', ''),
(11111, 'Siddhant Kar', DATE '1998-12-17', 'M', 'Kanpur'),
(22222, 'Harsh Patel', DATE '1999-12-17', 'M', 'Kanpur'),
(33333, 'Harshit Sharma', DATE '1998-12-17', 'M', 'Kanpur');

INSERT INTO Station #id name phone email
VALUES
(1, 'Kanpur', '7429845', 'kanpurthana@gov.in', 'Kanpur');

INSERT INTO Permission #id name
VALUES
(0, 'Normal'),
(100, 'Officer'),
(777, 'Admin');

INSERT INTO Court #id name place
VALUES
(1, 'HC', 'Kanpur');

INSERT INTO User #username password aadhaar permission email
VALUES
('admin', 'admin', 0, 777, 'admin@admin'),
('siddhk', 'password', 11111, 0, 'siddhk@iitk.ac.in'),
('siddh', 'password', 11111, 0, 'siddhk@iitk.ac.in'),
('sidd', 'password', 11111, 0, 'siddhk@iitk.ac.in'),
('sid', 'password', 11111, 0, 'siddhk@iitk.ac.in');

INSERT INTO Officer #id aadhaar station
VALUES (1, 11111, 1);

DELETE FROM Officer WHERE StationID = 1;
