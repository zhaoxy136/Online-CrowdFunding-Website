create database CrowdFund;
use CrowdFund;
create table `Account` (
 `AccountID` varchar(45) not null,
 `Username` varchar(45) not null,
 `Password` varchar(45) not null,
 PRIMARY KEY (`AccountID`));

create table `User` (
  `AccountID` varchar(45) not null,
  `FirstName` varchar (45) null,
  `LastName` varchar(45) null,
  `Gender` varchar(25) null,
  `City` varchar(45) null,
  `State` varchar(45) null,
  `Cellphone` varchar(45) null,
  `EmailAddress` varchar(45) null,
  `CreditCardNumber` varchar(45) null,
  `Interests` varchar (45) NULL,
  PRIMARY KEY (`AccountID`),
  FOREIGN KEY (`AccountID`) REFERENCES `Account`(`AccountID`));
  
   create table `Following` (
  `AccountID` varchar(45) not null,
  `FollowerID` varchar(45) not null,
  PRIMARY KEY (`AccountID`, `FollowerID`),
  FOREIGN KEY (`AccountID`) REFERENCES `User`(`AccountID`),
  FOREIGN KEY (`FollowerID`) REFERENCES `User`(`AccountID`));
  
create table `Request` (
 `ReqID` int not null,
 `ReqName` varchar(45) not null,
 `Description` varchar(1500) not null,
 `OwnerID` varchar(45) not null,
 `MinFundValue` int not null,
 `MaxFundValue` int not null,
 `PostTime` datetime not null,
 `FundingEndtime` datetime not null,
 `TargetTime` datetime not null,
 `Status` varchar(45) DEFAULT'Funding',
 `LikeCount` int DEFAULT 0,
 PRIMARY KEY (`ReqID`),
 FOREIGN KEY (`OwnerID`) REFERENCES `User`(`AccountID`));
 
create table `Tags` (
 `Tag` varchar(45) not null,
 PRIMARY KEY (`Tag`));
 
create table `Label` (
 `ReqID` int not null,
 `Tag` varchar(45) not null,
 PRIMARY KEY (`ReqID`, `Tag`),
 FOREIGN KEY (`ReqID`) REFERENCES `Request`(`ReqID`),
 FOREIGN KEY (`Tag`) REFERENCES `Tags`(`Tag`));
 
create TABLE `Project` (
  `ProjID` int not null,
  `StartTime` datetime not null,
  `TargetTime` datetime not null,
  `CompleteTime` datetime null,
  `ActualFund` decimal(10,2) not null,
  `SponsorCount` int not null,
  `Rating` decimal(2,1) null,
  PRIMARY KEY (`ProjID`),
  FOREIGN KEY (`ProjID`) REFERENCES `Request` (`ReqID`));

create TABLE `SponsorShip` (
  `ReqID` int not null,
  `AccountID` varchar(45) not null,
  `PledgeTime` datetime not null,
  `Amount` decimal(10,2) not null,
  `CreditCardNumber` varchar(45) not null,
  `Status` varchar(45) not null,
  `ChargedTime` datetime null,
  PRIMARY KEY (`ReqID`, `AccountID`, `PledgeTime`),
  FOREIGN KEY (`ReqID`) REFERENCES `Request` (`ReqID`),
  FOREIGN KEY (`AccountID`) REFERENCES `User` (`AccountID`));

  CREATE TABLE `Reviews` (
  `AccountID` varchar(45) not null,
  `ProjID` int not null,
  `Rating` int not null,
  `RateTime` datetime not null,
  `Review` varchar(3000) null,
  PRIMARY KEY (`AccountID`, `ProjID`),
  FOREIGN KEY (`AccountID`) REFERENCES `SponsorShip`(`AccountID`),
  FOREIGN KEY (`ProjID`) REFERENCES `Project`(`ProjID`));

 create table `Like` (
  `AccountID` varchar(45) not null,
  `ReqID` int not null,
  PRIMARY KEY (`AccountID`, `ReqID`),
  FOREIGN KEY (`AccountID`) REFERENCES `User`(`AccountID`),
  FOREIGN KEY (`ReqID`) REFERENCES `Request`(`ReqID`));
  
  
  create table `Material` (
  `MID` int not null,
  `MName` varchar(45) not null,
  `AccountID` varchar(45) not null,
  `Path` varchar(255) not null,
  `UploadTime` datetime not null,
  PRIMARY KEY (`MID`),
  FOREIGN KEY (`AccountID`) REFERENCES `User` (`AccountID`));

  create table `Samples` (
  `MID` int not null,
  `ReqID` int not null,
  PRIMARY KEY (`MID`, `ReqID`),
  FOREIGN KEY (`MID`) REFERENCES `Material` (`MID`),
  FOREIGN KEY (`ReqID`) REFERENCES `Request` (`ReqID`));

  create table `Attach` (
  `MID` int not null,
  `ProjID` int not null,
  PRIMARY KEY (`MID`, `ProjID`),
  FOREIGN KEY (`MID`) REFERENCES `Material` (`MID`),
  FOREIGN KEY (`ProjID`) REFERENCES `Project` (`ProjID`));

 create table `Update` (
  `AccountID` varchar(45) not null,
  `ProjID` int not null,
  `MID` int not null,
  `UpdateTime` datetime not null,
  PRIMARY KEY (`AccountID`, `ProjID`, `MID`, `UpdateTime`),
  FOREIGN KEY (`AccountID`) REFERENCES `User` (`AccountID`),
  FOREIGN KEY (`ProjID`) REFERENCES `Project` (`ProjID`),
  FOREIGN KEY (`MID`) REFERENCES `Material` (`MID`));

 create table `Comments` (
  `AccountID` varchar(45) not null,
  `ReqID` int not null,
  `Comment` varchar(3000) not null,
  `CommentTime` datetime not null,
  PRIMARY KEY (`AccountID`, `ReqID`, `CommentTime`),
  FOREIGN KEY (`AccountID`) REFERENCES `User` (`AccountID`),
  FOREIGN KEY (`ReqID`) REFERENCES `Request` (`ReqID`));

create table `Charge` (
  `AccountID` varchar(45) not null,
  `ReqID` int not null,
  `CreditCardNumber` varchar(45) null,
  `Amount` decimal(10,2) not null,
  `PledgeTime` datetime not null,
  `ChargedTime` datetime not null,

  PRIMARY KEY (`AccountID`, `ReqID`, `PledgeTime`, `ChargedTime`),
  FOREIGN KEY (`AccountID`, `ReqID`, `PledgeTime`) REFERENCES `SponsorShip` (`AccountID`, `ReqID`, `PledgeTime`));

