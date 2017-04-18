#1

INSERT INTO ACCOUNT (AccountID, Password, Username)
Values ('renqingyu@nyu.edu', '123456', 'ryanyu');

#2 

SELECT ReqID, ReqName
FROM REQUEST 
WHERE ReqName like '%jazz%' and Status = 'funding'
Order by PostTime desc;

#3

Create View JazzRequest as
	SELECT ReqID
	FROM REQUEST r join Label l on r.ReqID = l.ReqID
	WHERE tag = 'jazz';

SELECT AccountID, sum(Amount) as totalamount
FROM JazzRequest j join SPONSORSHIP s on j.ReqID = s.ReqID
WHERE IsCharged = 'Charged'
Group by AccountID
Order by totalamount;

#4


Create View BadProject as
	SELECT OwnerID,ProjID
	FROM PROJECT p join REQUEST r on p.ProjID = r.ReqID
	WHERE Rating < 4.0 or Rating = 'null';

SELECT OwnerID
FROM REQUEST
WHERE Status = 'Completed' 
and  OwnerID not in BadProject
Group by OwnerID
having count(*)>=3;

#5

Create View BB as
	SELECT AccountID
	FROM ACCOUNT
	WHERE Username = 'BobInBrooklyn';

SELECT Comment,AccountID
FROM COMMENTS
WHERE AccountID in(
		SELECT AccountID
		FROM FOLLOWING
		WHERE FollowerID = BB)

#6


INSERT INTO REQUEST (ReqID, ReqName, Description, OwnerID, 
MinFundValue, MaxFundValue, PostTime, FundingEndTime, TargetTime, Status, LikeCount)
Values ('172', 'Magic Laundry Ball', 
	'This Magic Laundry Ball swooshes around in the laundry machine and just like coral, allows water to flow, while picking up those little pieces of microfiber and catching them in her stalks.',
	'renqingyu@nyu.edu','1000','5000','2017-04-09 11:20:00','2017-04-19 23:59:59','2017-08-01 00:00:00','Funding',null);

#7

INSERT INTO SPONSORSHIP (AccountID, Amount, ChargedTime, CreditCardNumber, PledgeTime, ReqID, IsCharged)
Values ('zhaoxiangyu@nyu.edu', '100', null, '2088000000001292', '2017-04-14 15:40:00', '172','uncharged');


#8

#The funding would end in two situations:
#First: The request/project has reached the maxfund value;
#Second: The funding time is over.

SET GLOBAL event_scheduler = on;

CREATE EVENT  evt_fundtimeover
        on schedule at timestamp FundingEndtime
        do insert into PROJECT (ActualFund, CompleteTime, ProjID, Rating, SponsorCount, StartTime, TargetTime)
        Values ('CurrentFund', null, 'ReqID', null, 'CurrentSponsorCount', current_timestamp, TargetTime);

        where 










