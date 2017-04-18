drop database if exists CrowdFund;
create database CrowdFund;
use CrowdFund;

drop table if exists `Accounts`;
create table `Accounts` (
 `UID` varchar(45) not null,
 `Password` varchar(45) not null,
 PRIMARY KEY (`UID`));

drop table if exists `UserProfiles`;
create table `UserProfiles` (
  `UID` varchar(45) not null,
  `FirstName` varchar (45) null,
  `LastName` varchar(45) null,
  `Gender` varchar(25) null,
  `City` varchar(45) null,
  `State` varchar(45) null,
  `Cellphone` varchar(45) null,
  `EmailAddress` varchar(45) null,
  `CreditCardNumber` varchar(45) null,
  `Interests` varchar (140) NULL,
  PRIMARY KEY (`UID`),
  FOREIGN KEY (`UID`) REFERENCES `Accounts`(`UID`));

drop table if exists `Following`;
create table `Following` (
  `UID` varchar(45) not null,
  `FollowerID` varchar(45) not null,
  PRIMARY KEY (`UID`, `FollowerID`),
  FOREIGN KEY (`UID`) REFERENCES `UserProfiles`(`UID`),
  FOREIGN KEY (`FollowerID`) REFERENCES `UserProfiles`(`UID`));
  
drop table if exists `Projects`;
create table `Projects` (
 `ProjID` int not null,
 `ProjName` varchar(45) not null,
 `Description` varchar(1500) not null,
 `OwnerID` varchar(45) not null,
 `MinFundValue` int not null,
 `MaxFundValue` int not null,
 `PostTime` datetime not null,
 `FundingEndtime` datetime not null,
 `StartTime` datetime null,
 `TargetTime` datetime not null,
 `CompleteTime` datetime null,
 `LikeCount` int DEFAULT 0,
 `SponsorCount` int DEFAULT 0,
 `AlreadyFund` decimal(10,2) DEFAULT 0.00,
 `Status` varchar(45) DEFAULT'Funding',
 `AvgRating` decimal(2,1) null,
 PRIMARY KEY (`ProjID`),
 FOREIGN KEY (`OwnerID`) REFERENCES `UserProfiles`(`UID`));
 
drop table if exists `Tags`;
create table `Tags` (
 `Tag` varchar(45) not null,
 PRIMARY KEY (`Tag`));

drop table if exists `Label`; 
create table `Label` (
 `ProjID` int not null,
 `Tag` varchar(45) not null,
 PRIMARY KEY (`ProjID`, `Tag`),
 FOREIGN KEY (`ProjID`) REFERENCES `Projects`(`ProjID`),
 FOREIGN KEY (`Tag`) REFERENCES `Tags`(`Tag`));
 
drop table if exists `Pledges`;
create TABLE `Pledges` (
  `ProjID` int not null,
  `UID` varchar(45) not null,
  `PledgeTime` datetime not null,
  `Amount` decimal(10,2) not null,
  `CreditCardNumber` varchar(45) not null,
  PRIMARY KEY (`ProjID`, `UID`),
  FOREIGN KEY (`ProjID`) REFERENCES `Projects` (`ProjID`),
  FOREIGN KEY (`UID`) REFERENCES `UserProfiles` (`UID`));

drop table if exists `Charges`;
create table `Charges` (
  `ProjID` int not null,
  `UID` varchar(45) not null,
  `Amount` decimal(10,2) not null,
  `CreditCardNumber` varchar(45) not null,
  `ChargedTime` datetime not null,
  PRIMARY KEY (`UID`, `ProjID`),
  FOREIGN KEY (`UID`, `ProjID`) REFERENCES `Pledges` (`UID`, `ProjID`));

drop table if exists `Reviews`;
create table `Reviews` (
  `UID` varchar(45) not null,
  `ProjID` int not null,
  `Rating` int not null,
  `RateTime` datetime not null,
  `UserReview` varchar(3000) null,
  PRIMARY KEY (`UID`, `ProjID`),
  FOREIGN KEY (`UID`, `ProjID`) REFERENCES `Pledges`(`UID`, `ProjID`));

drop table if exists `Likes`;
create table `Likes` (
  `UID` varchar(45) not null,
  `ProjID` int not null,
  PRIMARY KEY (`UID`, `ProjID`),
  FOREIGN KEY (`UID`) REFERENCES `UserProfiles`(`UID`),
  FOREIGN KEY (`ProjID`) REFERENCES `Projects`(`ProjID`));
  
drop table if exists `Materials`;
create table `Materials` (
  `MID` int not null,
  `MName` varchar(45) not null,
  `UID` varchar(45) not null,
  `Path` varchar(255) not null,
  `UploadTime` datetime not null,
  PRIMARY KEY (`MID`),
  FOREIGN KEY (`UID`) REFERENCES `UserProfiles` (`UID`));

drop table if exists `Attach`;
create table `Attach` (
  `MID` int not null,
  `ProjID` int not null,
  PRIMARY KEY (`MID`, `ProjID`),
  FOREIGN KEY (`MID`) REFERENCES `Materials` (`MID`),
  FOREIGN KEY (`ProjID`) REFERENCES `Projects` (`ProjID`));

drop table if exists `StageUpdate`;
create table `StageUpdate` (
  `UID` varchar(45) not null,
  `ProjID` int not null,
  `MID` int not null,
  `UpdateTime` datetime not null,
  PRIMARY KEY (`UID`, `ProjID`, `MID`, `UpdateTime`),
  FOREIGN KEY (`UID`) REFERENCES `UserProfiles` (`UID`),
  FOREIGN KEY (`ProjID`) REFERENCES `Projects` (`ProjID`),
  FOREIGN KEY (`MID`) REFERENCES `Materials` (`MID`));

drop table if exists `Comments`;
create table `Comments` (
  `UID` varchar(45) not null,
  `ProjID` int not null,
  `UserComment` varchar(3000) not null,
  `CommentTime` datetime not null,
  PRIMARY KEY (`UID`, `ProjID`, `CommentTime`),
  FOREIGN KEY (`UID`) REFERENCES `UserProfiles` (`UID`),
  FOREIGN KEY (`ProjID`) REFERENCES `Projects` (`ProjID`));

create table `Charge` (
  `AccountID` varchar(45) not null,
  `ReqID` int not null,
  `CreditCardNumber` varchar(45) null,
  `Amount` decimal(10,2) not null,
  `PledgeTime` datetime not null,
  `ChargedTime` datetime not null,

  PRIMARY KEY (`AccountID`, `ReqID`, `PledgeTime`, `ChargedTime`),
  FOREIGN KEY (`AccountID`, `ReqID`, `PledgeTime`) REFERENCES `SponsorShip` (`AccountID`, `ReqID`, `PledgeTime`));

