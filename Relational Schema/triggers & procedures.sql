
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
create event `CheckFundingEndtime` 
on schedule every 1 day 
do begin
	call CheckFundingEndtime();
end//

create procedure CheckFundingEndtime()
begin
	declare done int default false;
    declare id, counts int;
    declare target datetime;
    declare money, minvalue decimal(10,2);

	declare cursor1 cursor for select ProjID, TargetTime, AlreadyFund, MinFundValue, SponsorCount from `Projects` where Status = 'Funding' AND date(FundingEndtime) = curdate();
	declare continue handler for not found set done = true;
	
    open cursor1;
    read_loop: LOOP
		FETCH cursor1 into id, target, money, minvalue, counts;
        if done then 
			LEAVE read_loop;
		end if;
		if money < minvalue then
			update `Projects`
			set Projects.Status = 'Failed';
		else
			update `Projects`
			set Projects.Status = 'OnGoing', Projects.StartTime = now();
		end if;
	end loop;
    
	close cursor1;
end//

delimiter ;


#create trigger `AddLike` after insert on `Endorse`
