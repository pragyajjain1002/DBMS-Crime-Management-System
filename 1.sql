DROP DATABASE IF EXISTS FIR_Mgmt;
CREATE DATABASE FIR_Mgmt;
USE FIR_Mgmt;

DROP TABLE IF EXISTS Citizen,
                     Station,
                     Permission,
                     User,
                     -- Login,
                     Officer,
                     Fir,
                     Court,
                     Cases,
                     Suspect,
                     CaseSuspects;

 CREATE TABLE Citizen (
     AadhaarID   INT             PRIMARY KEY,
     Name        VARCHAR(255)    NOT NULL,
     BirthDate   DATE            NOT NULL,
     Gender      ENUM('M','F')   NOT NULL,
     Address     VARCHAR(255)    NOT NULL
     -- Zone        INT             NOT NULL,
 );

 CREATE TABLE Station (
   StationID   INT             PRIMARY KEY,
   Name        VARCHAR(255)    NOT NULL,
   Phone       INT             NOT NULL,
   Email       VARCHAR(255)    NOT NULL,
   Address     VARCHAR(255)    NOT NULL
   -- Zone        INT             NOT NULL,
 );

 CREATE TABLE Permission (
     PerID       INT             PRIMARY KEY,
     PerName     VARCHAR(255)    NOT NULL
 );

CREATE TABLE User (
    Username    VARCHAR(255)    PRIMARY KEY,
    Password    VARCHAR(255)    NOT NULL,
    AadhaarID   INT             NOT NULL,
    PerID       INT             NOT NULL,
    -- Name        VARCHAR(255)    NOT NULL,
    -- Email       VARCHAR(255)    NOT NULL,
    -- FOREIGN KEY (AadhaarID) REFERENCES Citizen(AadhaarID),
    FOREIGN KEY (PerID) REFERENCES Permission(PerID)
);

-- CREATE TABLE Login (
--     LoginID     INT             NOT NULL,
--     Username    VARCHAR(255)    NOT NULL,
--     Password    VARCHAR(255)    NOT NULL,
--     PRIMARY KEY (LoginID)
-- );

-- CREATE TABLE Has (
--     UserID      INT             NOT NULL,
--     LoginID     INT             NOT NULL,
--     PerID       INT             NOT NULL,
--     PRIMARY KEY (UserID, LoginID, PerID),
--     FOREIGN KEY (UserID) REFERENCES User(UserID),
--     FOREIGN KEY (LoginID) REFERENCES Login(LoginID),
--     FOREIGN KEY (PerID) REFERENCES Permission(PerID)
-- );

CREATE TABLE Officer (
    OfficerID   INT             PRIMARY KEY,
    AadhaarID   INT             NOT NULL
    -- StationID   INT             NOT NULL,
    -- FOREIGN KEY (AadhaarID) REFERENCES Citizen(AadhaarID),
    -- FOREIGN KEY (StationID) REFERENCES Station(StationID)
);

CREATE TABLE Fir (
    FirID       INT             PRIMARY KEY,
    LodgeDate   DATE            NOT NULL,
    Descr       VARCHAR(255)    NOT NULL,
    -- Type        VARCHAR(255)    NOT NULL,
    Status      ENUM('Pending','In Court','Completed'),
    Lodger      VARCHAR(255)    NOT NULL,
    Manager     INT,
    StationID   INT,
    FOREIGN KEY (Lodger) REFERENCES User(Username),
    FOREIGN KEY (Manager) REFERENCES Officer(OfficerID),
    FOREIGN KEY (StationID) REFERENCES Station(StationID)
);

CREATE TABLE Court (
    CourtID     VARCHAR(3)      NOT NULL,
    Name        VARCHAR(255)    NOT NULL,
    Place       VARCHAR(255)    NOT NULL,
    PRIMARY KEY (CourtID)
);

CREATE TABLE Cases (
    CaseID      INT             PRIMARY KEY,
    Type        ENUM('Criminal','Civil'),
    Status      ENUM('Pending','Not Guilty','Found Guilty'),
    Result      VARCHAR(255)    NOT NULL,
    FirID       INT             NOT NULL,
    CourtID     VARCHAR(3)      NOT NULL,
    PRIMARY KEY (CaseID),
    FOREIGN KEY (FirID) REFERENCES Fir(FirID),
    FOREIGN KEY (CourtID) REFERENCES Court(CourtID)
);

CREATE TABLE Suspect (
    SuspectID   INT             NOT NULL,
    AadhaarID   INT             NOT NULL,
    CaseID      INT
    PRIMARY KEY (SuspectID),
    FOREIGN KEY (AadhaarID) REFERENCES Citizen(AadhaarID)
);

-- CREATE TABLE CaseSuspects (
--     SuspectID   INT             NOT NULL,
--     CaseID      INT             NOT NULL,
--     Guilty      ENUM('Y','N')   NOT NULL,
--     PRIMARY KEY (SuspectID, CaseID),
--     FOREIGN KEY (SuspectID) REFERENCES Suspect(SuspectID),
--     FOREIGN KEY (CaseID) REFERENCES Cases(CaseID)
-- );

DELIMITER |
CREATE TRIGGER ChangePerID BEFORE INSERT ON Officer
FOR EACH ROW
BEGIN
  UPDATE User SET PerID = 2 WHERE User.AadhaarID = NEW.AadhaarID;
END |
DELIMITER ;
