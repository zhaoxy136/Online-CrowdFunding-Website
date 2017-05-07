drop database if exists CrowdFund;
create database CrowdFund;
use CrowdFund;

drop table if exists `Accounts`;
create table `Accounts` (
 `UID` varchar(45) not null,
 `Passcode` varchar(45) not null,
 PRIMARY KEY (`UID`));
 
drop table if exists `UserProfiles`;
create table `UserProfiles` (
  `UID` varchar(45) not null,
  `FirstName` varchar (45) null,
  `LastName` varchar(45) null,
  `Avatar` varchar(255) null,
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
 `ProjID` int unsigned not null auto_increment,
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
 `Status` varchar(45) DEFAULT 'Funding',
 `AvgRating` decimal(2,1) null,
 PRIMARY KEY (`ProjID`),
 FOREIGN KEY (`OwnerID`) REFERENCES `UserProfiles`(`UID`));

alter table `Projects` auto_increment = 86101;

drop table if exists `Tags`;
create table `Tags` (
 `Tag` varchar(45) not null,
 PRIMARY KEY (`Tag`));


drop table if exists `Label`; 
create table `Label` (
 `ProjID` int unsigned not null,
 `Tag` varchar(45) not null,
 PRIMARY KEY (`ProjID`, `Tag`),
 FOREIGN KEY (`ProjID`) REFERENCES `Projects`(`ProjID`),
 FOREIGN KEY (`Tag`) REFERENCES `Tags`(`Tag`));

drop table if exists `Pledges`;
create TABLE `Pledges` (
  `ProjID` int unsigned not null,
  `UID` varchar(45) not null,
  `PledgeTime` datetime not null,
  `Amount` decimal(10,2) not null,
  `CreditCardNumber` varchar(45) not null,
  PRIMARY KEY (`ProjID`, `UID`),
  FOREIGN KEY (`ProjID`) REFERENCES `Projects` (`ProjID`),
  FOREIGN KEY (`UID`) REFERENCES `UserProfiles` (`UID`));

drop table if exists `Charges`;
create table `Charges` (
  `ProjID` int unsigned not null,
  `UID` varchar(45) not null,
  `Amount` decimal(10,2) not null,
  `CreditCardNumber` varchar(45) not null,
  `ChargedTime` datetime default current_timestamp,
  PRIMARY KEY (`UID`, `ProjID`),
  FOREIGN KEY (`UID`, `ProjID`) REFERENCES `Pledges` (`UID`, `ProjID`));

drop table if exists `Likes`;
create table `Likes` (
  `UID` varchar(45) not null,
  `ProjID` int unsigned not null,
  PRIMARY KEY (`UID`, `ProjID`),
  FOREIGN KEY (`UID`) REFERENCES `UserProfiles`(`UID`),
  FOREIGN KEY (`ProjID`) REFERENCES `Projects`(`ProjID`));

drop table if exists `Materials`;
create table `Materials` (
  `MID` int unsigned not null auto_increment,
  `MName` varchar(45) not null,
  `MDescription` varchar(255) null,
  `UID` varchar(45) not null,
  `MPath` varchar(255) not null,
  `UploadTime` datetime not null,
  PRIMARY KEY (`MID`),
  FOREIGN KEY (`UID`) REFERENCES `UserProfiles` (`UID`));
  
  alter table `Materials` auto_increment = 123001;

drop table if exists `Reviews`;
create table `Reviews` (
  `UID` varchar(45) not null,
  `ProjID` int unsigned not null,
  `Rating` int unsigned not null,
  `RateTime` datetime not null,
  `UserReview` varchar(3000) null,
  PRIMARY KEY (`UID`, `ProjID`),
  FOREIGN KEY (`UID`, `ProjID`) REFERENCES `Pledges`(`UID`, `ProjID`));
  
drop table if exists `Attach`;
create table `Attach` (
  `MID` int unsigned not null,
  `ProjID` int unsigned not null,
  PRIMARY KEY (`MID`, `ProjID`),
  FOREIGN KEY (`MID`) REFERENCES `Materials` (`MID`),
  FOREIGN KEY (`ProjID`) REFERENCES `Projects` (`ProjID`));


drop table if exists `StageUpdate`;
create table `StageUpdate` (
  `UID` varchar(45) not null,
  `ProjID` int unsigned not null,
  `MID` int unsigned not null,
  `UpdateTime` datetime not null,
  PRIMARY KEY (`UID`, `ProjID`, `MID`, `UpdateTime`),
  FOREIGN KEY (`UID`) REFERENCES `UserProfiles` (`UID`),
  FOREIGN KEY (`ProjID`) REFERENCES `Projects` (`ProjID`),
  FOREIGN KEY (`MID`) REFERENCES `Materials` (`MID`));

drop table if exists `Comments`;
create table `Comments` (
  `UID` varchar(45) not null,
  `ProjID` int unsigned not null,
  `UserComment` varchar(3000) not null,
  `CommentTime` datetime not null,
  PRIMARY KEY (`UID`, `ProjID`, `CommentTime`),
  FOREIGN KEY (`UID`) REFERENCES `UserProfiles` (`UID`),
  FOREIGN KEY (`ProjID`) REFERENCES `Projects` (`ProjID`));


 drop table if exists `Activities`;
 create table `Activities` (
  `AID` int not null auto_increment,
  `UID` varchar(45) not null,
  `ProjID` int unsigned not null,
  `ProjName` varchar(45) not null,
  `HappenTime` datetime not null,
  `ActiType` varchar(45) not null,
  PRIMARY KEY (`AID`),
  FOREIGN KEY (`UID`) REFERENCES `UserProfiles`(`UID`), 
  FOREIGN KEY (`ProjID`) REFERENCES `Projects`(`ProjID`));

alter table `Activities` auto_increment = 101;



##Triggers
delimiter $$
drop trigger if exists `AddLikeToActi`$$
create trigger `AddLikeToActi` after insert on `Likes`
for each row
begin 
	declare pname varchar(45);
    select `ProjName` into pname from `Projects` where Projects.ProjID = NEW.ProjID;
    insert into `Activities` (`UID`, `ProjID`, `ProjName`, `HappenTime`, `ActiType`) values (NEW.UID, NEW.ProjID, pname, now(), 'like');
    update `Projects` set Projects.LikeCount = Projects.LikeCount + 1 where Projects.ProjID = NEW.ProjID;
end$$
    
drop trigger if exists `RemoveLikeFromActi`$$
create trigger `RemoveLikeFromActi` after delete on `Likes`
for each row
begin
	delete from `Activities` where UID = OLD.UID and ProjID = OLD.ProjID;
	update `Projects` set Projects.LikeCount = Projects.LikeCount - 1 where Projects.ProjID = OLD.ProjID;
end$$

drop trigger if exists `AddPostToActi`$$
create trigger `AddPostToActi` after insert on `Projects`
for each row
begin
	insert into `Activities` (`UID`, `ProjID`, `ProjName`, `HappenTime`, `ActiType`) values (NEW.OwnerID, NEW.ProjID, NEW.ProjName, NEW.PostTime, 'post');
end$$

drop trigger if exists `AddStatusToActiAndAddCharges`$$
create trigger `AddStatusToActiAndAddCharges` after update on `Projects`
for each row
begin
	if NEW.Status <> OLD.Status then
		if NEW.Status = 'OnGoing' then
			insert into `Charges` (`ProjID`, `UID`, `Amount`, `CreditCardNumber`) 
				select ProjID, UID, Amount, CreditCardNumber from `Pledges` where Pledges.ProjID = NEW.ProjID;
			insert into `Activities` (`UID`, `ProjID`, `ProjName`, `HappenTime`, `ActiType`) values (NEW.OwnerID, NEW.ProjID, NEW.ProjName, NEW.StartTime, 'ongoing');
        else if NEW.Status = 'Completed' then 
			insert into `Activities` (`UID`, `ProjID`, `ProjName`, `HappenTime`, `ActiType`) values (NEW.OwnerID, NEW.ProjID, NEW.ProjName, NEW.CompleteTime, 'complete');
        end if;
        end if;
	end if;
end$$


drop trigger if exists `AddCommentToActi`$$
create trigger `AddCommentToActi` after insert on `Comments`
for each row
begin
	declare pname varchar(45);
    select `ProjName` into pname from `Projects` where Projects.ProjID = NEW.ProjID;
	insert into `Activities` (`UID`, `ProjID`, `ProjName`, `HappenTime`, `ActiType`) values (NEW.UID, NEW.ProjID, pname, NEW.CommentTime, 'comment');
end$$

drop trigger if exists `AddReviewToActiAndChangeRate`$$
create trigger `AddReviewToActiAndChangeRate` after insert on `Reviews`
for each row
begin
	declare pname varchar(45);
    declare newrate decimal(2,1);
    select `ProjName` into pname from `Projects` where Projects.ProjID = NEW.ProjID;
    select avg(Rating) into newrate from `Reviews` where Reviews.ProjID = NEW.ProjID;
	insert into `Activities` (`UID`, `ProjID`, `ProjName`, `HappenTime`, `ActiType`) values (NEW.UID, NEW.ProjID, pname, NEW.RateTime, 'review');
    update `Projects` set Projects.AvgRating = newrate;
end$$

drop trigger if exists `AddPledgeToActiAndCheckMeetMax`$$
create trigger `AddPledgeToActiAndCheckMeetMax` after insert on `Pledges`
for each row
begin
	declare pname varchar(45);
    select `ProjName` into pname from `Projects` where Projects.ProjID = NEW.ProjID;
    insert into `Activities` (`UID`, `ProjID`, `ProjName`, `HappenTime`, `ActiType`) values (NEW.UID, NEW.ProjID, pname, NEW.PledgeTime, 'pledge');
    update `Projects`
		set Projects.Status = 'OnGoing', Projects.StartTime = now() 
        where Projects.Status = 'Funding' and Projects.ProjID = NEW.ProjID and Projects.AlreadyFund >= Projects.MaxfundValue;
end$$

drop trigger if exists `AddUpdateToActi`$$
create trigger `AddUpdateToActi` after insert on `StageUpdate`
for each row
begin
	declare pname varchar(45);
    select `ProjName` into pname from `Projects` where Projects.ProjID = NEW.ProjID;
    insert into `Activities` (`UID`, `ProjID`, `ProjName`, `HappenTime`, `ActiType`) values (NEW.UID, NEW.ProjID, pname, NEW.UpdateTime, 'update');
end$$

drop trigger if exists `UpdateAmount`$$
create trigger `UpdateAmount` before insert on `Pledges`
for each row
begin
	update `Projects`
		set Projects.AlreadyFund = Projects.AlreadyFund + New.Amount,
		Projects.SponsorCount = Projects.SponsorCount + 1
        where Projects.ProjID = New.ProjID;
end$$

SET GLOBAL event_scheduler = ON$$
drop event if exists `DailyCheckFundEndTime`$$
create event `DailyCheckFundEndTime` 
on schedule every 1 day
do 
	begin
		update `Projects` set Projects.Status = 'Failed'
        where Projects.Status = 'Funding' and Projects.FundingEndtime <= now() and Projects.AlreadyFund < Projects.MinFundValue;
		update `Projects` set Projects.Status = 'OnGoing', Projects.StartTime = now()
        where Projects.Status = 'Funding' and Projects.FundingEndtime <= now() and Projects.AlreadyFund >= Projects.MinFundValue;
end$$


delimiter ;

show triggers;



##Test cases
 insert into `Accounts`(UID, Passcode) values('BarryZhao', 'Zz1234');
 insert into `Accounts`(UID, Passcode) values('RyanYu', 'Xx1234');
select * from `Accounts`;

insert into `UserProfiles`(`UID`, `FirstName`, `LastName`, `Avatar`, `Gender`, `City`, `State`, `Cellphone`, `EmailAddress`, `CreditCardNumber`, `Interests`)
	values ('BarryZhao', 'Xiangyu', 'Zhao', null, 'Male', 'New York', 'NY', '9176984062', 'zhaoxy136@gmail.com', null, null);
insert into `UserProfiles`(`UID`, `FirstName`, `LastName`, `Avatar`, `Gender`, `City`, `State`, `Cellphone`, `EmailAddress`, `CreditCardNumber`, `Interests`)
	values ('RyanYu', 'Renqing', 'Yu', null, 'Male', 'New York', 'NY', null, null, null, null);
select * from `UserProfiles`;

INSERT INTO Projects (ProjID, ProjName, Description, OwnerID, MinFundValue, MaxFundValue, PostTime, 
					FundingEndtime, StartTime, TargetTime, CompleteTime, LikeCount, SponsorCount, AlreadyFund, Status, AvgRating)
Values ('86103', 'Ma Ma Land', 'I am self-distributing this serial movie of multi-award winning film La La Land. 
		The story happens in Manhattan thus it is called Ma Ma Land. The money I raise here will go towards prints, trailers, 
		and movie advertising so that we can spread the word on screenings.', 'RyanYu', '8000', '12000', 
		'2017-02-14 14:00:00', '2017-04-07 18:00:00', null, '2017-07-07 00:00:00', null, '11', '5','0', 'Funding', null);
select * from `Projects`; 

##Test trigger AddPostToActi -- success
delete from `Projects` where ProjID = '86103';
INSERT INTO Projects (ProjID, ProjName, Description, OwnerID, MinFundValue, MaxFundValue, PostTime, 
					FundingEndtime, StartTime, TargetTime, CompleteTime, LikeCount, SponsorCount, AlreadyFund, Status, AvgRating)
Values ('86103', 'Ma Ma Land', 'I am self-distributing this serial movie of multi-award winning film La La Land. 
		The story happens in Manhattan thus it is called Ma Ma Land. The money I raise here will go towards prints, trailers, 
		and movie advertising so that we can spread the word on screenings.', 'RyanYu', '8000', '12000', 
		'2017-02-14 14:00:00', '2017-04-07 18:00:00', '2017-04-02 13:00:00', '2017-07-07 00:00:00', null, '11', '5','14000', 'Funding', null);
select * from `Projects`;
select * from `Activities`;

##Test trigger AddLikeToActi -- success
delete from `Likes` where ProjID = '86103';
insert into `Likes` (`UID`, `ProjID`) values ('BarryZhao', '86103');
select * from `Likes`;
select * from `Activities`;

##Test trigger RemoveLikeFromActi -- success
delete from `Likes` where UID = 'BarryZhao';
select * from `Likes`;
select * from `Activities`;



##Test trigger AddStatusToActiAndAddCharges -- success
select * from `Projects`;
update `Projects` set `Status` = 'OnGoing' where `ProjID` = '86103';
select * from `Projects`;
select * from `Activities`;
update `Projects` set `Status` = 'Completed' , `CompleteTime` = '2017-04-22 13:00:00' where `ProjID` = '86103';
select * from `Projects`;
select * from `Activities`;
select * from `Charges`;

##Test trigger AddCommentToActi -- success
select * from `Comments`;
insert into `Comments`(`UID`, `ProjID`, `UserComment`, `CommentTime`) values ('BarryZhao', '86103', 'very nice', '2017-04-06 13:00:00');
select * from `Comments`;
select * from `Activities`;
delete from `Comments` where ProjID = '86103';
delete from `Activities` where UID = 'BarryZhao';

##Test trigger AddReviewToActiAndChangeRate -- success
select * from `Reviews`;
SET SQL_SAFE_UPDATES = 0;
insert into `Pledges` (`ProjID`, `UID`, `PledgeTime`, `Amount`, `CreditCardNumber`) values ('86103', 'BarryZhao', '2017-03-02 15:00:00', '100', '110');
insert into `Reviews`(`UID`, `ProjID`, `Rating`, `RateTime`, `UserReview`) values ('BarryZhao', '86103', '4', '2017-04-16 13:00:00', 'Well done!');
insert into `Reviews`(`UID`, `ProjID`, `Rating`, `RateTime`, `UserReview`) values ('RyanYu', '86103', '5', '2017-04-17 13:00:00', 'I did it!');
select * from `Reviews`;
select * from `Activities`;
select * from `Projects`;
delete from `Reviews` where UID = 'BarryZhao';

##Test trigger AddPledgeToActiAndCheckMeetMax -- success

select * from `Pledges`;
insert into `Pledges` (`ProjID`, `UID`, `PledgeTime`, `Amount`, `CreditCardNumber`) values ('86103', 'RyanYu', '2017-03-02 15:00:00', '3000', '110');
insert into `Pledges` (`ProjID`, `UID`, `PledgeTime`, `Amount`, `CreditCardNumber`) values ('86103', 'BarryZhao', '2017-03-03 15:00:00', '6000', '120');
select * from `Pledges`;
select * from `Activities`;
select * from `Projects`;

##Test trigger AddUpdateToActi -- success
insert into `Materials` (`MName`, `MDescription`, `UID`, `MPath`, `UploadTime`) values ('testm', null, 'RyanYu', 'www', '2017-04-01 14:00:00');
select * from `Materials`;
insert into `StageUpdate` (`UID`, `ProjID`, `MID`, `UpdateTime`) values ('RyanYu', '86103', '1', '2017-04-01 14:10:00');
select * from `StageUpdate`;
select * from `Activities`;



##Test event DailyCheckFundEndTime -- 

delimiter $$

drop event if exists `DailyCheckFundEndTime`$$
create event `DailyCheckFundEndTime` 
on schedule every 1 minute
do 
	begin
		update `Projects` set Projects.Status = 'Failed'
        where Projects.Status = 'Funding' and Projects.FundingEndtime <= now() and Projects.AlreadyFund < Projects.MinFundValue;
		update `Projects` set Projects.Status = 'OnGoing', Projects.StartTime = now()
        where Projects.Status = 'Funding' and Projects.FundingEndtime <= now() and Projects.AlreadyFund >= Projects.MinFundValue;
end$$

delimiter ;

        
INSERT INTO Projects (ProjID, ProjName, Description, OwnerID, MinFundValue, MaxFundValue, PostTime, 
					FundingEndtime, StartTime, TargetTime, CompleteTime, LikeCount, SponsorCount, AlreadyFund, AvgRating)
Values ('86103', 'Ma Ma Land', 'I am self-distributing this serial movie of multi-award winning film La La Land. 
		The story happens in Manhattan thus it is called Ma Ma Land. The money I raise here will go towards prints, trailers, 
		and movie advertising so that we can spread the word on screenings.', 'RyanYu', '8000', '12000', 
		'2017-02-14 14:00:00', '2017-05-04 18:00:00', null, '2017-07-07 00:00:00', null, '11', '5','0', null);
select * from `Projects`; 
delete from `Charges` where ProjID = '86103';
delete from `Pledges` where ProjID = '86103';
delete from `Activities` where ProjID = '86103';
delete from `Projects` where ProjID = '86103';

insert into `Pledges` (`ProjID`, `UID`, `PledgeTime`, `Amount`, `CreditCardNumber`) values ('86103', 'RyanYu', '2017-03-02 15:00:00', '6000', '110');
insert into `Pledges` (`ProjID`, `UID`, `PledgeTime`, `Amount`, `CreditCardNumber`) values ('86103', 'BarryZhao', '2017-03-03 15:00:00', '3000', '120');
select * from `Pledges`;
select * from `Activities`;
select * from `Projects`;
select * from `Charges`;



show events;











