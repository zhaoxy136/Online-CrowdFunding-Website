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
	insert into `Activities` (`UID`, `ProjID`, `ProjName`, `HappenTime`, `ActiContent`, `ActiType`) values (NEW.OwnerID, NEW.ProjID, NEW.ProjName, NEW.PostTime, NEW.Description, 'post');
end$$

drop trigger if exists `AddStatusToActiAndAddCharges`$$
create trigger `AddStatusToActiAndAddCharges` after update on `Projects`
for each row
begin
	if NEW.Status <> OLD.Status then
		if NEW.Status = 'OnGoing' then
			insert into `Charges` (`ProjID`, `UID`, `Amount`, `CreditCardNumber`) 
				select ProjID, UID, Amount, CreditCardNumber from `Pledges` where Pledges.ProjID = NEW.ProjID;
			insert into `Activities` (`UID`, `ProjID`, `ProjName`, `HappenTime`, `ActiContent`, `ActiType`) values (NEW.OwnerID, NEW.ProjID, NEW.ProjName, NEW.StartTime, NEW.Description, 'ongoing');
        else if NEW.Status = 'Completed' then 
			insert into `Activities` (`UID`, `ProjID`, `ProjName`, `HappenTime`, `ActiContent`, `ActiType`) values (NEW.OwnerID, NEW.ProjID, NEW.ProjName, NEW.CompleteTime, NEW.Description, 'complete');
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
	insert into `Activities` (`UID`, `ProjID`, `ProjName`, `HappenTime`, `ActiContent`, `ActiType`) values (NEW.UID, NEW.ProjID, pname, NEW.CommentTime, NEW.UserComment, 'comment');
end$$

drop trigger if exists `AddReviewToActiAndChangeRate`$$
create trigger `AddReviewToActiAndChangeRate` after insert on `Reviews`
for each row
begin
	declare pname varchar(45);
    declare newrate decimal(2,1);
    select `ProjName` into pname from `Projects` where Projects.ProjID = NEW.ProjID;
    select avg(Rating) into newrate from `Reviews` where Reviews.ProjID = NEW.ProjID;
	insert into `Activities` (`UID`, `ProjID`, `ProjName`, `HappenTime`, `ActiContent`, `ActiType`) values (NEW.UID, NEW.ProjID, pname, NEW.RateTime, NEW.UserReview, 'review');
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
		update `Projects` set Status = 'Failed'
        where Projects.Status = 'Funding' and Projects.FundingEndtime <= now() and Projects.AlreadyFund < Projects.MinFundValue;
		update `Projects` set Projects.Status = 'Working'
        where Projects.Status = 'Funding' and Projects.FundingEndtime <= now() and Projects.AlreadyFund >= Projects.MinFundValue;
end$$

delimiter ;

show triggers;