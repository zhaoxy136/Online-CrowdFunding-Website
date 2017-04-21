
#Test Query1
INSERT INTO ACCOUNTs (UID, Passcode) Values ('HumanTeddy', 'hl2530');
INSERT INTO UserProfiles (UID, FirstName, LastName, Gender, City, State, Cellphone, EmailAddress, CreditCardNumber, Interests)
Values ('HumanTeddy', 'Hanyu', 'Liu', null, null, null, null, null, null, null);

select * from `Accounts` natural join `UserProfiles`
where UID = 'HumanTeddy';

#Test Query2
SELECT ProjID, ProjName, PostTime
FROM Projects 
WHERE ProjName like '%jazz%' and Status = 'Funding'
Order by PostTime desc;

#Test Query3
Create View JazzProjects as
	SELECT ProjID
	FROM Tags natural join Label
	WHERE tag = 'jazz';

select * from JazzProjects;
SELECT UID, sum(Amount) as totalamount
FROM JazzProjects j join Charges ch on j.ProjID = ch.ProjID
Group by UID
Order by totalamount desc;

#Test Query4
SELECT OwnerID
FROM PROJECTs 
WHERE Status = 'Completed' and OwnerID not in (SELECT OwnerID
	FROM PROJECTs
	WHERE AvgRating < 4.0 or AvgRating = null)
Group by OwnerID
having count(*)>=3;

#Test Query5
SELECT UID, UserComment
FROM COMMENTS
WHERE UID in(
		SELECT UID
		FROM FOLLOWING
		WHERE FollowerID = 'BobInBrooklyn');

#Test Query6
INSERT INTO Projects (ProjID, ProjName, Description, OwnerID, MinFundValue, MaxFundValue, PostTime, 
					FundingEndtime, StartTime, TargetTime, CompleteTime, LikeCount, SponsorCount, AlreadyFund, Status, AvgRating)
Values ('86109','Magic Laundry Ball', 
	'This Magic Laundry Ball swooshes around in the laundry machine and just like coral, allows water to flow, while picking up those little pieces of microfiber and catching them in her stalks.', 
    'RyanYu', '1000', '5000', '2017-04-09 11:20:00', '2017-04-21 13:03:00', null, '2017-08-01 00:00:00', null, '0', '0', '0', 'Funding', null);
delete from `Projects` where ProjID = '86109';

#Test Query7
delete from Pledges where ProjID = '86109';
INSERT INTO Pledges (ProjID, UID, PledgeTime, Amount, CreditCardNumber)
Values ('86109', 'BarryZhao', '2017-04-14 15:40:00', '100', '2088000000001292');

INSERT INTO Pledges (ProjID, UID, PledgeTime, Amount, CreditCardNumber)
Values ('86109', 'LeonardoDiCaprio', '2017-04-19 16:40:00', '1000', '9288763611109223');

INSERT INTO Pledges (ProjID, UID, PledgeTime, Amount, CreditCardNumber)
Values ('86109', 'WentworthMiller', '2017-04-19 18:00:00', '4000', '8097233467631881');

select * from Projects where OwnerID = 'RyanYu';
select * from Pledges;

#Test Query8
delimiter //
#update funding value and sponsor counts
create trigger `UpdateAmount` after insert on `Pledges`
for each row
begin
	update `Projects`
		set Projects.AlreadyFund = Projects.AlreadyFund + New.Amount,
		Projects.SponsorCount = Projects.SponsorCount + 1
        where Projects.ProjID = New.ProjID;
end//

#check if funding value meet maxfund limit
create trigger `MeetMaxFund` after insert on `Pledges`
for each row follows `UpdateAmount`
begin
	declare funded, maxfunded decimal(10,2);
    select AlreadyFund, MaxfundValue into funded, maxfunded from `Projects` where Projects.ProjID = NEW.ProjID;
	if funded >= maxfunded then
		update `Projects`
			set Projects.Status = 'OnGoing', Projects.StartTime = now()
			where Projects.ProjID = New.ProjID;
    end if;
end//

#check everyday updating the request should end with either starting the project or becoming failed
#using cursor

create event `DailyCheckFET` 
on schedule every 1 day
do begin
	call CheckFundingEndtime();
end//

create procedure CheckFundingEndtime()
begin
	declare id int;
	declare counts, i int default 0;
    declare money, minvalue decimal(10,2);
	select count(*) into counts from `Projects` where date(FundingEndtime) = curdate();
    set i = 0;
    WHILE i < counts DO
		select ProjID, AlreadyFund, MinFundValue into id, money, minvalue from `Projects` where date(FundingEndtime) = curdate() limit i, 1;
		if money < minvalue then
			update `Projects`
			set Projects.Status = 'Failed'
            where Projects.ProjID = id;
		else
			update `Projects`
			set Projects.Status = 'OnGoing', Projects.StartTime = now()
            where Projects.ProjID = id;
		end if;
    END WHILE;
end//
delimiter ;
