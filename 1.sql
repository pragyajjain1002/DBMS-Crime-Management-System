DROP DATABASE IF EXISTS FIR_Mgmt;
CREATE DATABASE FIR_Mgmt;
USE FIR_Mgmt;

DROP TABLE IF EXISTS User,
                     Login,
                     Permission,
                     Fir,
                     Station,
                     Officer,
                     Citizen,
                     Suspect,
                     Cases,
                     Court;

CREATE TABLE User (
    UserID      INT             NOT NULL,
    Name        VARCHAR(255)    NOT NULL,
    Mobile      INT(10)         NOT NULL,
    Email       VARCHAR(255)    NOT NULL,
    PRIMARY KEY (UserID)
);

CREATE TABLE Login (
    LoginID     INT             NOT NULL,
    Username    VARCHAR(255)    NOT NULL,
    Password    VARCHAR(255)    NOT NULL,
    PRIMARY KEY (LoginID)
);

CREATE TABLE Permission (
    PerID       INT             NOT NULL,
    PerName     VARCHAR(255)    NOT NULL,
    Module      VARCHAR(255)    NOT NULL,
    PRIMARY KEY (PerID)
);

CREATE TABLE Has (
    UserID      INT             NOT NULL,
    LoginID     INT             NOT NULL,
    PerID       INT             NOT NULL,
    PRIMARY KEY (UserID, LoginID, PerID),
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (LoginID) REFERENCES Login(LoginID),
    FOREIGN KEY (PerID) REFERENCES Permission(PerID)
);

CREATE TABLE Citizen (
    CitizenID   INT             NOT NULL,
    Name        VARCHAR(255)    NOT NULL,
    BirthDate   DATE            NOT NULL,
    Gender      ENUM('M','F')   NOT NULL,
    Address     VARCHAR(255)    NOT NULL,
    Zone        INT             NOT NULL,
    PRIMARY KEY (CitizenID)
);

CREATE TABLE Station (
    StationID   VARCHAR(3)      NOT NULL,
    Name        VARCHAR(255)    NOT NULL,
    Phone       INT             NOT NULL,
    Email       VARCHAR(255)    NOT NULL,
    Address     VARCHAR(255)    NOT NULL,
    Zone        INT             NOT NULL,
    PRIMARY KEY (StationID)
);

CREATE TABLE Officer (
    OfficerID   INT             NOT NULL,
    UserID      INT             NOT NULL,
    CitizenID   INT             NOT NULL,
    StationID   VARCHAR(3)      NOT NULL,
    PRIMARY KEY (OfficerID),
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (CitizenID) REFERENCES Citizen(CitizenID),
    FOREIGN KEY (StationID) REFERENCES Station(StationID)
);

CREATE TABLE Fir (
    FirID       INT             NOT NULL,
    LodgeDate   DATE            NOT NULL,
    Descr       VARCHAR(255)    NOT NULL,
    Type        VARCHAR(255)    NOT NULL,
    Status      ENUM('P','FR','CS')     NOT NULL,
    Lodger      INT             NOT NULL,
    Manager     INT             NOT NULL,
    StationID   VARCHAR(3)      NOT NULL,
    PRIMARY KEY (FirID),
    FOREIGN KEY (Lodger) REFERENCES User(UserID),
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
    CaseID      INT             NOT NULL,
    Type        VARCHAR(255)    NOT NULL,
    Status      ENUM('P','C')   NOT NULL,
    Result      VARCHAR(255)    NOT NULL,
    FirID       INT             NOT NULL,
    CourtID     VARCHAR(3)      NOT NULL,
    PRIMARY KEY (CaseID),
    FOREIGN KEY (FirID) REFERENCES Fir(FirID),
    FOREIGN KEY (CourtID) REFERENCES Court(CourtID)
);

CREATE TABLE Suspect (
    SuspectID   INT             NOT NULL,
    CitizenID   INT             NOT NULL,
    Name        VARCHAR(255)    NOT NULL,
    BirthDate   DATE            NOT NULL,
    Gender      ENUM('M','F')   NOT NULL,
    PRIMARY KEY (SuspectID),
    FOREIGN KEY (CitizenID) REFERENCES Citizen(CitizenID)
);

CREATE TABLE CaseSuspects (
    SuspectID   INT             NOT NULL,
    CaseID      INT             NOT NULL,
    Guilty      ENUM('Y','N')   NOT NULL,
    PRIMARY KEY (SuspectID, CaseID),
    FOREIGN KEY (SuspectID) REFERENCES Suspect(SuspectID),
    FOREIGN KEY (CaseID) REFERENCES Cases(CaseID)
);
