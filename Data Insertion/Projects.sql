#Projects Update

#p1rate: 4+5+5 / 3 = 4.7
INSERT INTO Projects (ProjID, ProjName, Description, OwnerID, MinFundValue, MaxFundValue, PostTime, 
					FundingEndtime, StartTime, TargetTime, CompleteTime, LikeCount, SponsorCount, AlreadyFund, Status, AvgRating)
Values ('86101','Behind the Black Widow', 'A musical show on love, friendship and family of the superhero Black Widow. 
	We want this show to be an engaging, beautiful and emotive piece of theater, that actually says something about the great woman, 
	and to contribute to the ever-expanding dialogue on superhero‘s psychological pressure.','ScarlettJohansson','5000', '7000',
	'2017-01-08 09:00:00', '2017-01-15 21:00:00', '2017-01-15 21:00:00', '2017-02-08 00:00:00','2017-02-01 14:00:00','9', '3','6000', 'Completed', '4.7');

#p2rate: 4+5 / 2 = 4.5
INSERT INTO Projects (ProjID, ProjName, Description, OwnerID, MinFundValue, MaxFundValue, PostTime, 
					FundingEndtime, StartTime, TargetTime, CompleteTime, LikeCount, SponsorCount, AlreadyFund, Status, AvgRating)
Values ('86102', 'Highway to Hollywood', 'Webseries documenting a beautiful actress on a road trip to Hollywood. 
	She would document every moment and there are 11 target cities she need to hit along the way', 'ScarlettJohansson','1000', '2000',
	'2017-01-16 14:00:00', '2017-1-20 00:00:00', '2017-1-20 00:00:00', '2017-01-31 00:00:00', '2017-01-30 18:00:00','4', '2','1000', 'Completed', '4.5');

#p3rate: null ongoing
INSERT INTO Projects (ProjID, ProjName, Description, OwnerID, MinFundValue, MaxFundValue, PostTime, 
					FundingEndtime, StartTime, TargetTime, CompleteTime, LikeCount, SponsorCount, AlreadyFund, Status, AvgRating)
Values ('86103', 'Ma Ma Land', 'I am self-distributing this serial movie of multi-award winning film La La Land. 
		The story happens in Manhattan thus it is called Ma Ma Land. The money I raise here will go towards prints, trailers, 
		and movie advertising so that we can spread the word on screenings.', 'RyanGosling', '8000', '12000', 
		'2017-02-14 14:00:00', '2017-04-07 18:00:00', '2017-04-02 13:00:00', '2017-07-07 00:00:00', null, '11', '5','14000', 'Ongoing', null);

#p4rate: 4+3+5 / 3 = 4.0
INSERT INTO Projects (ProjID, ProjName, Description, OwnerID, MinFundValue, MaxFundValue, PostTime, 
					FundingEndtime, StartTime, TargetTime, CompleteTime, LikeCount, SponsorCount, AlreadyFund, Status, AvgRating)
Values ('86104', 'Actors Co-op Easter Show', 'The Young Actors Co-op of California performs "An Easter Day Show" in April. 
		The sets will be huge! The cast is huge! The budget is small... ', 'ScarlettJohansson', '4000', '5000','2017-02-20 14:00:00', '2017-3-20 00:00:00',
		'2017-3-20 00:00:00', '2017-04-16 10:00:00', '2017-04-16 10:00:00', '5', '3', '4000', 'Completed', '4.0');

#p5 not enough fund
INSERT INTO Projects (ProjID, ProjName, Description, OwnerID, MinFundValue, MaxFundValue, PostTime, 
					FundingEndtime, StartTime, TargetTime, CompleteTime, LikeCount, SponsorCount, AlreadyFund, Status, AvgRating)
Values ('86105', 'JiangNan Leather Shoes', 'This is a series of leather shoes set from my hometown JiangNan, a famous city of China.
		There will be a total of 12 pairs of shoes representing the Chinese Zodiac that will be launched throughout the rest of the year. 
		Such as the Rooster, Dog, and Pig.', 'KatherineLangford','9000', '12000', '2017-01-28 06:00:00', '2017-2-28 09:00:00', 
		null, '2017-05-16 00:00:00', null, '2', '1','2000', 'Failed', null);

#p6 funding
INSERT INTO Projects (ProjID, ProjName, Description, OwnerID, MinFundValue, MaxFundValue, PostTime, 
					FundingEndtime, StartTime, TargetTime, CompleteTime, LikeCount, SponsorCount, AlreadyFund, Status, AvgRating)
Values ('86106', 'Dreamland - A Debut Jazz Album', 'Dreamland is the first debut album of my jazz band, Emma and her squd.
			For years I have played musical roles in various pictures which trained me as a jazz drummer.
			This album represents my true musical loves.', 'EmmaStone', '9000', '12000','2017-03-17 08:00:00', '2017-5-20 19:00:00', 
			null, '2017-07-17 00:00:00', null, '5', '3','6000', 'Funding', null);

#p7 funding
INSERT INTO Projects (ProjID, ProjName, Description, OwnerID, MinFundValue, MaxFundValue, PostTime, 
					FundingEndtime, StartTime, TargetTime, CompleteTime, LikeCount, SponsorCount, AlreadyFund, Status, AvgRating)
Values ('86107', 'Dreamland Tour - A Jazz Band Tour', 'I firmly believe that the Dreamland album will go off without a hitch in the studio. 
		After the album release on July 17th, we would launch a tour in five different cities.
		Any support is greatly appreciated. Let us make this happen together.', 'EmmaStone', '10000', '15000', '2017-04-01 18:00:00', '2017-7-20 06:00:00',
		null, '2017-09-01 00:00:00', null, '2', '1','2000','Funding',null);

#p8 funding
INSERT INTO Projects (ProjID, ProjName, Description, OwnerID, MinFundValue, MaxFundValue, PostTime, 
					FundingEndtime, StartTime, TargetTime, CompleteTime, LikeCount, SponsorCount, AlreadyFund, Status, AvgRating)
Values ('86108', 'Glowing Jacket','I have spent a lot of time over the past few years looking at different jacket designs.
			Now I wanted to take the concept of a glow jacket, which is a fashion jacket line 
			with illumination stuff on the classic jackets.', 'LeonardoDiCaprio', '6000', '9000', '2017-03-01 17:00:00', '2017-5-22 12:00:00', 
			null, '2017-06-15 00:00:00', null, '3', '2','3500', 'Funding', null);









