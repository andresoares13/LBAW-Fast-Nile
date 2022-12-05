create schema if not exists lbaw22144;

SET search_path TO lbaw22144;


DROP TABLE IF EXISTS administrator CASCADE;
DROP TABLE IF EXISTS bid CASCADE;
DROP TABLE IF EXISTS notification CASCADE;
DROP TABLE IF EXISTS follow CASCADE;
DROP TABLE IF EXISTS auction CASCADE;
DROP TABLE IF EXISTS car CASCADE;
DROP TABLE IF EXISTS rating CASCADE;
DROP TABLE IF EXISTS auctioneer CASCADE;
DROP TABLE IF EXISTS users CASCADE;

DROP TYPE IF EXISTS categories;
DROP TYPE IF EXISTS statesAuction;
DROP TYPE IF EXISTS statesCar;

-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE categories AS ENUM ('Sport', 'Coupe', 'Convertible','SUV', 'Pickup Truck');
CREATE TYPE statesAuction AS ENUM ('Active', 'Closed');
CREATE TYPE statesCar AS ENUM ('Wreck', 'Poor Condition', 'Normal Condition', 'High Condition', 'Brand New');


-----------------------------------------
-- Tables
-----------------------------------------


CREATE TABLE users (
   id SERIAL PRIMARY KEY,
   names TEXT NOT NULL,
   password TEXT NOT NULL,
   picture TEXT NOT NULL DEFAULT 'default.png',
   email TEXT NOT NULL CONSTRAINT user_email_uk UNIQUE,
   address TEXT,
   wallet INT NOT NULL DEFAULT 0,
   remember_token TEXT
);

CREATE TABLE auctioneer (
   id SERIAL PRIMARY KEY,
   idUser Int,
   phone TEXT NOT NULL CONSTRAINT auctioneer_phone_uk UNIQUE,
   grade FLOAT DEFAULT 0,
   CONSTRAINT fk_user FOREIGN KEY(idUser) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE administrator (
   id SERIAL PRIMARY KEY,
   names TEXT NOT NULL,
   password TEXT NOT NULL,
   picture TEXT NOT NULL DEFAULT 'default.png',
   email TEXT NOT NULL CONSTRAINT administrator_email_uk UNIQUE,
   address TEXT,
   remember_token TEXT
);

CREATE TABLE car (
   id SERIAL PRIMARY KEY,
   names TEXT NOT NULL,
   category categories NOT NULL,
   states statesCar NOT NULL,
   color TEXT NOT NULL,
   consumption FLOAT NOT NULL,
   kilometers INT NOT NULL,
   picture TEXT NOT NULL DEFAULT 'default.png'
);

CREATE TABLE auction (
   id SERIAL PRIMARY KEY,
   idCar INT NOT NULL,
   descriptions TEXT NOT NULL,
   priceStart INT NOT NULL,
   priceNow INT,
   priceClose INT,
   timeClose TIMESTAMP NOT NULL,
   highestBidder INT,
   owners INT,
   states statesAuction NOT NULL,
   title TEXT NOT NULL,
   ending BOOLEAN,
   CONSTRAINT fk_car FOREIGN KEY(idCar) REFERENCES car(id) ON DELETE CASCADE,
   CONSTRAINT fk_bidder FOREIGN KEY(highestBidder) REFERENCES users(id),
   CONSTRAINT fk_owner FOREIGN KEY(owners) REFERENCES auctioneer(id)
);

 CREATE TABLE bid (
   id SERIAL PRIMARY KEY,
   idUser INT,
   idAuction INT,
   valuee INT NOT NULL,
   CONSTRAINT fk_user FOREIGN KEY(idUser) REFERENCES users(id),
   CONSTRAINT fk_auction FOREIGN KEY(idAuction) REFERENCES auction(id) ON DELETE CASCADE
);  

 CREATE TABLE follow (
   idUser INT,
   idAuction INT,
   PRIMARY KEY (idUser, idAuction),
   CONSTRAINT fk_user FOREIGN KEY(idUser) REFERENCES users(id) ON DELETE CASCADE,
   CONSTRAINT fk_auction FOREIGN KEY(idAuction) REFERENCES auction(id) ON DELETE CASCADE
);  

 CREATE TABLE notification (
   id SERIAL PRIMARY KEY, 
   idUser INT NOT NULL,
   idAuction INT,
   messages TEXT NOT NULL,
   viewed BOOLEAN,
   CONSTRAINT fk_user FOREIGN KEY(idUser) REFERENCES users(id) ON DELETE CASCADE,
   CONSTRAINT fk_auction FOREIGN KEY(idAuction) REFERENCES auction(id)
);  

 CREATE TABLE rating (
   id SERIAL PRIMARY KEY,
   idUser INT,
   idAuctioneer INT,
   grade INT,
   CONSTRAINT fk_user FOREIGN KEY(idUser) REFERENCES users(id),
   CONSTRAINT fk_auctioneer FOREIGN KEY(idAuctioneer) REFERENCES auctioneer(id) ON DELETE CASCADE
);


-----------------------------------------
-- INDEXES
-----------------------------------------


CREATE INDEX active_auctions ON auction USING hash (states) WHERE states = 'Active';

CREATE INDEX bin_on_auction ON bid USING hash (idAuction);

CREATE INDEX notification_users ON notification USING hash (idUser);


-- FTS INDEXES
DROP TRIGGER IF EXISTS auction_search_update ON auction;

ALTER TABLE auction
ADD COLUMN tsvectors TSVECTOR;

CREATE OR REPLACE FUNCTION auction_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.title), 'A') ||
         setweight(to_tsvector('english', NEW.descriptions), 'B')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.descriptions <> OLD.descriptions OR NEW.title <> OLD.title) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.title), 'A') ||
             setweight(to_tsvector('english', NEW.descriptions), 'B')
           );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;


CREATE TRIGGER auction_search_update
 BEFORE INSERT OR UPDATE ON auction
 FOR EACH ROW
 EXECUTE PROCEDURE auction_search_update();


CREATE INDEX search_idx ON auction USING GIN (tsvectors);


-----------------------------------------
-- TRIGGERS and UDFs
-----------------------------------------

DROP TRIGGER IF EXISTS update_highest_bid ON bid;
DROP TRIGGER IF EXISTS user_same_bid ON bid;
DROP TRIGGER IF EXISTS update_bid_time ON bid;
DROP TRIGGER IF EXISTS smaller_bid ON bid;
DROP TRIGGER IF EXISTS auction_valid_time ON auction;
DROP TRIGGER IF EXISTS auction_noSame_auctioneer_bid ON bid;
DROP TRIGGER IF EXISTS rate_won_auctions ON rating;
DROP TRIGGER IF EXISTS min_auction_value ON auction;
DROP TRIGGER IF EXISTS min_wallet_value ON users;
DROP TRIGGER IF EXISTS bid_small_wallet ON bid;
DROP TRIGGER IF EXISTS valid_rating ON rating;
DROP TRIGGER IF EXISTS update_average_grade ON rating;
DROP TRIGGER IF EXISTS update_deleted_user_info ON users;
DROP TRIGGER IF EXISTS update_deleted_auctioneer ON auction;
DROP TRIGGER IF EXISTS min_bid_delete_auction ON auction;
DROP TRIGGER IF EXISTS new_bid_notification ON auction;
DROP TRIGGER IF EXISTS ending_notification ON auction;
DROP TRIGGER IF EXISTS ended_notification ON auction;




--t1

CREATE OR REPLACE FUNCTION update_highest_bid_function() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (SELECT priceNow from auction WHERE auction.id = new.idAuction) < new.valuee THEN  --guarantees that a bid cannot be placed unless its value is bigger than the current one
      UPDATE auction
         SET highestBidder = new.idUser, priceNow = new.valuee
         WHERE auction.id = new.idAuction;
    END IF;     
    return new;
END;
$BODY$
language plpgsql;


CREATE TRIGGER update_highest_bid
     AFTER INSERT ON bid
     FOR EACH ROW
     EXECUTE PROCEDURE update_highest_bid_function();




--t2

CREATE OR REPLACE FUNCTION user_same_bid_function() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM bid, auction WHERE NEW.idUser = auction.highestBidder AND auction.id = NEW.idAuction ) THEN
           RAISE EXCEPTION 'A user may only bid if their bid is not the highest';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER user_same_bid
        BEFORE INSERT OR UPDATE ON bid
        FOR EACH ROW
        EXECUTE PROCEDURE user_same_bid_function();




--t3

CREATE OR REPLACE FUNCTION update_bid_time_function() RETURNS TRIGGER AS
$BODY$
BEGIN
   IF (SELECT extract(epoch from (auction.timeclose - now())) / 60 FROM auction where auction.id = new.idAuction) < 15 THEN
      UPDATE auction
         SET timeclose = (select (select timeclose from auction where auction.id = new.idAuction) + (30 * interval '1 minute'))
         WHERE auction.id = new.idAuction;
   END IF;
   return new;
END;
$BODY$
language plpgsql;


CREATE TRIGGER update_bid_time
     AFTER INSERT ON bid
     FOR EACH ROW
     EXECUTE PROCEDURE update_bid_time_function();        



--t4

CREATE OR REPLACE FUNCTION smaller_bid_function() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF ((SELECT priceNow from auction WHERE auction.id = new.idAuction) * 1.05 ) > new.valuee THEN
           RAISE EXCEPTION 'A bid can only be made if it is higher than the current one by at least 5 percent';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER smaller_bid
        BEFORE INSERT ON bid
        FOR EACH ROW
        EXECUTE PROCEDURE smaller_bid_function();



--t5

CREATE OR REPLACE FUNCTION auction_valid_time_function() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF (SELECT extract(epoch from (new.timeclose - now())) / 60 ) <= 1440 THEN
           RAISE EXCEPTION 'The close date of an auction has to be greater than the opening date';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER auction_valid_time
        BEFORE INSERT ON auction
        FOR EACH ROW
        EXECUTE PROCEDURE auction_valid_time_function();       




--t6

CREATE OR REPLACE FUNCTION auction_noSame_auctioneer_bid_function() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF ((select owners from auction where id = new.idAuction) = (select id from auctioneer where idUser = new.idUser))  THEN
           RAISE EXCEPTION 'An auctioneer can`t bid in their own auction';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER auction_noSame_auctioneer_bid
        BEFORE INSERT ON bid
        FOR EACH ROW
        EXECUTE PROCEDURE auction_noSame_auctioneer_bid_function();  


  
--t7

CREATE OR REPLACE FUNCTION rate_won_auctions_function() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF (select count(id) from auction where states = 'Closed' AND highestBidder = new.idUser AND owners = new.idAuctioneer) <= (select count(id) from rating where idUser = new.idUser AND idAuctioneer = new.idAuctioneer)   THEN
           RAISE EXCEPTION 'To rate an auctioneer, a user has to win an auction of theirs';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER rate_won_auctions
        BEFORE INSERT ON rating
        FOR EACH ROW
        EXECUTE PROCEDURE rate_won_auctions_function(); 



--t8

CREATE OR REPLACE FUNCTION min_auction_value_function() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF (new.priceStart <= 0)  THEN
           RAISE EXCEPTION 'The starting value of the auction must be bigger than 0';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER min_auction_value
        BEFORE INSERT ON auction
        FOR EACH ROW
        EXECUTE PROCEDURE min_auction_value_function(); 



--t9

CREATE OR REPLACE FUNCTION min_wallet_value_function() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF (new.wallet < 0)  THEN
           RAISE EXCEPTION 'The value of the wallet can`t be less than 0';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER min_wallet_value
        BEFORE INSERT OR UPDATE ON users
        FOR EACH ROW
        EXECUTE PROCEDURE min_wallet_value_function(); 



--t10

CREATE OR REPLACE FUNCTION bid_small_wallet_function() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF (new.valuee > (select wallet from users where id = new.idUser))  THEN
           RAISE EXCEPTION 'The value of the user`s wallet must be equal or bigger than the value of the bid';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER bid_small_wallet
        BEFORE INSERT ON bid
        FOR EACH ROW
        EXECUTE PROCEDURE bid_small_wallet_function(); 


--t11

CREATE OR REPLACE FUNCTION valid_rating_function() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF (new.grade < 1 OR new.grade > 5)   THEN
           RAISE EXCEPTION 'The value of the rating must be between 1 and 5';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER valid_rating
        BEFORE INSERT ON rating
        FOR EACH ROW
        EXECUTE PROCEDURE valid_rating_function(); 


--t12

CREATE OR REPLACE FUNCTION update_average_grade_function() RETURNS TRIGGER AS
$BODY$
BEGIN
   UPDATE auctioneer
      SET grade = round( CAST(((new.grade + auctioneer.grade) / ( (select count(id) from rating where idAuctioneer = new.idAuctioneer))) AS numeric) , 2 )
      WHERE new.idAuctioneer = auctioneer.id;
    return new;
END;
$BODY$
language plpgsql;


CREATE TRIGGER update_average_grade
     AFTER INSERT ON rating
     FOR EACH ROW
     EXECUTE PROCEDURE update_average_grade_function();



--t13

CREATE OR REPLACE FUNCTION update_deleted_user_info_function() RETURNS TRIGGER AS
$BODY$
BEGIN
   UPDATE bid
      SET idUser = NULL
      WHERE old.id = idUser;
   UPDATE rating
      SET idUser = NULL
      WHERE old.id = rating.idUser;
   UPDATE auction 
      SET highestBidder = (select bid.idUser from auction,bid where bid.idAuction = auction.id and bid.idUser is not NULL order by valuee desc limit 1),
      priceNow = (select bid.valuee from auction,bid where bid.idAuction = auction.id and bid.idUser is not NULL order by valuee desc limit 1)
      WHERE old.id = auction.highestBidder and auction.states = 'Active';   
    return old;
END;
$BODY$
language plpgsql;


CREATE TRIGGER update_deleted_user_info
     BEFORE DELETE ON users
     FOR EACH ROW
     EXECUTE PROCEDURE update_deleted_user_info_function();




--t14

CREATE OR REPLACE FUNCTION update_deleted_auctioneer_function() RETURNS TRIGGER AS
$BODY$
BEGIN
   UPDATE auction
      SET owners = NULL
      where old.id = auction.owners and auction.states = 'Closed';
   IF EXISTS(select states from auction where auction.owners = old.id and auction.states = 'Active') THEN  
      DELETE FROM auction where auction.owners = old.id;
   END IF; 
    return old;
END;
$BODY$
language plpgsql;


CREATE TRIGGER update_deleted_auctioneer
     BEFORE DELETE ON auctioneer
     FOR EACH ROW
     EXECUTE PROCEDURE update_deleted_auctioneer_function();




--t15


CREATE OR REPLACE FUNCTION min_bid_delete_auction_function() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (select count(bid.id) from auction,bid where bid.idAuction = old.id) > 0 THEN 
        RAISE EXCEPTION 'An auction can´t be deleted if it has more than 0 bids';
	ELSE

     INSERT INTO notification (idUser,idAuction,messages,viewed)
	  SELECT users.id,NULL,(SELECT CONCAT('Your auction was canceled - ',old.title)),false
	  FROM users
	  WHERE users.id = (select idUser from auctioneer where id = old.owners); 

	  INSERT INTO notification (idUser,idAuction,messages,viewed)
      SELECT follow.idUser,NULL,(SELECT CONCAT('Followed auction was canceled - ',old.title)),false
	  FROM follow
	  WHERE follow.idAuction = old.id;
	  
	  
    END IF;
    RETURN old;
END;
$BODY$
language plpgsql;

CREATE TRIGGER min_bid_delete_auction
     BEFORE DELETE ON auction
     FOR EACH ROW
     EXECUTE PROCEDURE min_bid_delete_auction_function();



--t16

CREATE OR REPLACE FUNCTION new_bid_notification_function() RETURNS TRIGGER AS
$BODY$
BEGIN
      INSERT INTO notification (idUser,idAuction,messages,viewed)
      SELECT distinct bid.idUser,new.idAuction,'New bid on participating auction',false
	  FROM bid
	  WHERE bid.idAuction = new.idAuction and bid.idUser != new.idUser;
	  INSERT INTO notification (idUser,idAuction,messages,viewed)
	  SELECT users.id,new.idAuction,'New bid on your auction',false
	  FROM users
	  WHERE users.id = (select idUser from auctioneer where id = (select owners from auction where id = new.idAuction ));
    return new;
END;
$BODY$
language plpgsql;


CREATE TRIGGER new_bid_notification
     AFTER INSERT ON bid
     FOR EACH ROW
     EXECUTE PROCEDURE new_bid_notification_function();


--t17

CREATE OR REPLACE FUNCTION ending_notification_function() RETURNS TRIGGER AS
$BODY$
BEGIN
	IF new.ending=true AND (select ending from auction where id = new.id) = false THEN
      INSERT INTO notification (idUser,idAuction,messages,viewed)
      SELECT distinct bid.idUser,bid.idAuction,'Participating auction is ending',false
	  FROM bid
	  WHERE bid.idAuction = new.id;
	  INSERT INTO notification (idUser,idAuction,messages,viewed)
	  SELECT users.id,new.id,'Your auction is ending',false
	  FROM users
	  WHERE users.id = (select idUser from auctioneer where id = (select owners from auction where id = new.id ));
	END IF;  
    return new;
END;
$BODY$
language plpgsql;


CREATE TRIGGER ending_notification
     BEFORE UPDATE ON auction
     FOR EACH ROW
     EXECUTE PROCEDURE ending_notification_function();



--t18


CREATE OR REPLACE FUNCTION ended_notification_function() RETURNS TRIGGER AS
$BODY$
BEGIN
	IF new.states='Closed' AND (select states from auction where id = new.id) = 'Active' AND (select highestBidder from auction where id = new.id) IS NOT NULL THEN
      INSERT INTO notification (idUser,idAuction,messages,viewed)
      SELECT distinct bid.idUser,bid.idAuction,'Auction has ended',false
	  FROM bid
	  WHERE bid.idAuction = new.id;
	  
	  INSERT INTO notification (idUser,idAuction,messages,viewed)
	  SELECT users.id,new.id,'Your auction has ended',false
	  FROM users
	  WHERE users.id = (select idUser from auctioneer where id = (select owners from auction where id = new.id ));
	  
	  INSERT INTO notification (idUser,idAuction,messages,viewed)
      SELECT distinct bid.idUser,bid.idAuction,(SELECT CONCAT('The winner of the auction was ', (select names FROM users where id= (select highestBidder from auction where id=new.id)))),false
	  FROM bid
	  WHERE bid.idAuction = new.id;
	  
	  INSERT INTO notification (idUser,idAuction,messages,viewed)
	  SELECT users.id,new.id,(SELECT CONCAT('The winner of your auction was ', (select names FROM users where id= (select highestBidder from auction where id=new.id)))),false
	  FROM users
	  WHERE users.id = (select idUser from auctioneer where id = (select owners from auction where id = new.id ));
	END IF;  
    return new;
END;
$BODY$
language plpgsql;


CREATE TRIGGER ended_notification
     BEFORE UPDATE ON auction
     FOR EACH ROW
     EXECUTE PROCEDURE ended_notification_function();




     
     
     
insert into users (id, names, password, email, address, wallet) values (1, 'Alis', '2CgZjF7', 'ashortt0@friendfeed.com', '61 Nova Court', 100000);
insert into users (id, names, password, email, address) values (2, 'Vivie', 'FYjQYjHM2k4', 'vgashion1@163.com', '0110 Swallow Street');
insert into users (id, names, password, email, address) values (3, 'Tonnie', 'PsOQktLQD', 'truselin2@state.tx.us', '8928 Comanche Lane');
insert into users (id, names, password, email, address) values (4, 'Gussy', 'v2POgmxWEf5B', 'gwaugh3@naver.com', '2 Corben Alley');
insert into users (id, names, password, email, address) values (5, 'Stevie', 'heaZJkG', 'sickov4@de.vu', '1 Rockefeller Place');
insert into users (id, names, password, email, address) values (6, 'Ulrich', 'oFJqT6', 'uchicchelli5@loc.gov', '3 Valley Edge Place');
insert into users (id, names, password, email, address) values (7, 'Raye', '1tJXKiVZf', 'rbiagioni6@feedburner.com', '97 Shopko Alley');
insert into users (id, names, password, email, address) values (8, 'Dolf', 'xtRqXw7x2', 'dtotterdell7@vinaora.com', '72 Badeau Place');
insert into users (id, names, password, email, address) values (9, 'Axe', 'reXP8LbG8Hb', 'amorteo8@deliciousdays.com', '6 Burning Wood Way');
insert into users (id, names, password, email, address) values (10, 'Anabal', 'q8k37mIEIKM9', 'aadlard9@arizona.edu', '32 Helena Junction');
insert into users (id, names, password, email, address) values (11, 'Myrtia', 'Q3zBpUia8T', 'mtunnya@tumblr.com', '9507 Becker Place');
insert into users (id, names, password, email, address) values (12, 'Jaquelyn', '8vE70Nb9fs', 'jhitchensb@gnu.org', '818 Lindbergh Road');
insert into users (id, names, password, email, address) values (13, 'Leanor', 'jbXVu3', 'lbenhamc@bravesites.com', '4 Oriole Alley');
insert into users (id, names, password, email, address) values (14, 'Sydelle', 'k9oFs0cBTo', 'sbonneyd@opera.com', '5834 Lindbergh Street');
insert into users (id, names, password, email, address) values (15, 'Germayne', 'y2le2fLha', 'gbelze@imageshack.us', '6472 Homewood Way');
insert into users (id, names, password, email, address) values (16, 'Julie', '7dY3Nqk3lytm', 'jorpinf@instagram.com', '09788 Loomis Plaza');
insert into users (id, names, password, email, address) values (17, 'Daryle', 'IrZb4hq6', 'dcuniog@google.cn', '368 Anzinger Road');
insert into users (id, names, password, email, address) values (18, 'Sioux', 'WsrSCCrkWC', 'sleprovosth@rambler.ru', '2697 Mallard Point');
insert into users (id, names, password, email, address) values (19, 'Charmane', 'Mb0Wuach', 'cbeetoni@mapquest.com', '86483 Hoffman Center');
insert into users (id, names, password, email, address) values (20, 'Moises', 'L4xemVc5a3Lw', 'mbahlsj@yahoo.co.jp', '8 Sherman Drive');
insert into users (id, names, password, email, address) values (21, 'Neille', 'KpXqjEyV', 'nmairsk@drupal.org', '40149 Buhler Place');
insert into users (id, names, password, email, address) values (22, 'Kristian', 'WmDFgXpQ', 'kstrutherl@independent.co.uk', '22424 Bonner Plaza');
insert into users (id, names, password, email, address) values (23, 'Ophelia', '0mRqfHykkG', 'ohryncewiczm@sbwire.com', '520 Lakeland Avenue');
insert into users (id, names, password, email, address) values (24, 'Verla', 'FRw9JE', 'vhryskiewiczn@g.co', '07550 Emmet Trail');
insert into users (id, names, password, email, address) values (25, 'Elysee', '0trP26qmRCGf', 'esivetero@goodreads.com', '80110 Eastwood Terrace');
insert into users (id, names, password, email, address) values (26, 'Ainslee', 'SNKibtrJWy', 'amelhuishp@samsung.com', '25 Pond Terrace');
insert into users (id, names, password, email, address) values (27, 'Camey', 'irA8YMAbi', 'cpandieq@mlb.com', '0878 Packers Drive');
insert into users (id, names, password, email, address) values (28, 'Yuri', 'IR6WqUC8A', 'ytarzeyr@ovh.net', '717 Di Loreto Pass');
insert into users (id, names, password, email, address) values (29, 'Jerrilyn', 'JcmDtKykh', 'jthorntons@devhub.com', '321 Sauthoff Avenue');
insert into users (id, names, password, email, address) values (30, 'Tiphanie', 'KHO5UYXz0Z', 'tmacdunleavyt@unesco.org', '97 Crowley Alley');
insert into users (id, names, password, email, address) values (31, 'Lief', 'GTSEXmawCGNH', 'lscallonu@nationalgeographic.com', '768 Hoard Hill');
insert into users (id, names, password, email, address) values (32, 'Vasili', 'ETdOBmpQGN', 'vdossetterv@about.me', '83 Springview Drive');
insert into users (id, names, password, email, address) values (33, 'Tobias', 'ShoC5Xc8um5', 'tmcparlandw@vistaprint.com', '363 Graceland Hill');
insert into users (id, names, password, email, address) values (34, 'Evangeline', 'x5B4XvXwl', 'esircombx@omniture.com', '47 Stephen Plaza');
insert into users (id, names, password, email, address) values (35, 'Adaline', 'Cq4MSo', 'aothicky@bluehost.com', '367 Grover Avenue');
insert into users (id, names, password, email, address) values (36, 'Truman', 'fqD1qZz', 'tcounterz@free.fr', '77734 Colorado Avenue');
insert into users (id, names, password, email, address) values (37, 'Peterus', 'mzeQpHR', 'ppriestner10@independent.co.uk', '69 Forest Run Crossing');
insert into users (id, names, password, email, address) values (38, 'Calypso', 'qfVG8e', 'cdehooch11@salon.com', '2129 Banding Trail');
insert into users (id, names, password, email, address) values (39, 'Angil', 'ZsIbhXYLZJ', 'aescofier12@chron.com', '18217 Vernon Way');
insert into users (id, names, password, email, address) values (40, 'Ford', 'QSvWqsd8', 'fenriquez13@spotify.com', '38 Buell Terrace');
insert into users (id, names, password, email, address) values (41, 'Fleur', 'Ytp7Fx', 'fspatoni14@a8.net', '736 Arrowood Parkway');
insert into users (id, names, password, email, address) values (42, 'Shea', '7lEgdD', 'slamminam15@engadget.com', '0614 Fremont Trail');
insert into users (id, names, password, email, address) values (43, 'Jacklyn', '3pHl9YfCj', 'jchowne16@rambler.ru', '0 Lunder Alley');
insert into users (id, names, password, email, address) values (44, 'Alida', '19SIE2dU', 'ablackboro17@scribd.com', '17 Talmadge Park');
insert into users (id, names, password, email, address) values (45, 'Jarvis', 'VcCNoWU4', 'jocuolahan18@hostgator.com', '8569 Hoffman Drive');
insert into users (id, names, password, email, address) values (46, 'Devi', '5Fg5QlhuEJ', 'dcubbini19@furl.net', '2 Atwood Court');
insert into users (id, names, password, email, address) values (47, 'Leanna', 'lHA0Ra', 'lmapledorum1a@cam.ac.uk', '0962 Carpenter Hill');
insert into users (id, names, password, email, address) values (48, 'Hanson', 'x6vLNd6', 'hcristoferi1b@instagram.com', '7 Division Hill');
insert into users (id, names, password, email, address) values (49, 'Klemens', 'a1KJcVjP', 'kcleyne1c@ameblo.jp', '98595 Vernon Street');
insert into users (id, names, password, email, address) values (50, 'Charlotte', 'PKDdmobUMA', 'cgrist1d@whitehouse.gov', '4584 Norway Maple Drive');
insert into users (id, names, password, email, address) values (51, 'Elwira', 'n6JCJNQDH', 'ebatt1e@dot.gov', '7743 Clove Hill');
insert into users (id, names, password, email, address) values (52, 'Noland', 'qo1YNk7BGq', 'nbrown1f@dyndns.org', '19499 Portage Road');
insert into users (id, names, password, email, address) values (53, 'Alica', 'H1KbAlayqc', 'awaymont1g@instagram.com', '3824 Everett Alley');
insert into users (id, names, password, email, address) values (54, 'Darelle', 'Wu5mNc6SM', 'dluckwell1h@symantec.com', '1 Straubel Avenue');
insert into users (id, names, password, email, address) values (55, 'Conway', 'WeZnYKznOim', 'cmassingberd1i@archive.org', '777 Division Road');
insert into users (id, names, password, email, address) values (56, 'Tomlin', 'LqtMHQ', 'thacking1j@archive.org', '76 Forest Court');
insert into users (id, names, password, email, address) values (57, 'Herb', 'GmqiCHJpMi', 'hminchella1k@unblog.fr', '68633 Kingsford Street');
insert into users (id, names, password, email, address) values (58, 'Neille', '0984MD3zB', 'nnorman1l@wikipedia.org', '4317 2nd Parkway');
insert into users (id, names, password, email, address) values (59, 'Gawain', 'oUV4MpT', 'gwimsett1m@stumbleupon.com', '3517 3rd Hill');
insert into users (id, names, password, email, address) values (60, 'Stevena', 'sboAtZG', 'smalecky1n@hugedomains.com', '1 Paget Crossing');
insert into users (id, names, password, email, address) values (61, 'Darryl', 'wstyALDnCL', 'dlowater1o@tinypic.com', '26 Toban Circle');
insert into users (id, names, password, email, address) values (62, 'Calida', 'lmTOKhCnN', 'cmacairt1p@shinystat.com', '96605 Fisk Point');
insert into users (id, names, password, email, address) values (63, 'Myra', 'ttjua9', 'mangus1q@reference.com', '28276 Talisman Pass');
insert into users (id, names, password, email, address) values (64, 'Karyl', 'G2m8SrKloT', 'kpretorius1r@virginia.edu', '7 Stone Corner Hill');
insert into users (id, names, password, email, address) values (65, 'Sherline', 'elhHW0', 'ssollett1s@ow.ly', '5707 Sloan Place');
insert into users (id, names, password, email, address) values (66, 'Rodrigo', 'OmZKX4ORw', 'ralwen1t@domainmarket.com', '6 Quincy Drive');
insert into users (id, names, password, email, address) values (67, 'Gabey', 'aWA4jzuAxVh', 'gfrancescozzi1u@cnn.com', '1 Aberg Park');
insert into users (id, names, password, email, address) values (68, 'Evaleen', 'LpjW0NmzX', 'eduding1v@yahoo.co.jp', '412 Elmside Avenue');
insert into users (id, names, password, email, address) values (69, 'Frannie', 'AD5Yv8iXZTy', 'fabraham1w@jiathis.com', '4732 Mallory Lane');
insert into users (id, names, password, email, address) values (70, 'Malvina', '6TCYcP8k', 'modowgaine1x@exblog.jp', '5 Waywood Point');
insert into users (id, names, password, email, address) values (71, 'Yolanthe', '6ojH7oYkRC2', 'ydineen1y@spotify.com', '31802 Hagan Circle');
insert into users (id, names, password, email, address) values (72, 'Jard', 'WkKhE8u5lomp', 'jiley1z@buzzfeed.com', '83473 Porter Avenue');
insert into users (id, names, password, email, address) values (73, 'Walsh', 'ZbBoaUv', 'wsimmgen20@woothemes.com', '50307 Stoughton Hill');
insert into users (id, names, password, email, address) values (74, 'Hobard', 'qCqkMx5nxq', 'hgarstan21@mtv.com', '62 Clove Parkway');
insert into users (id, names, password, email, address) values (75, 'Nicola', 'yzUNS7viQv2g', 'naverill22@odnoklassniki.ru', '68 Dovetail Trail');
insert into users (id, names, password, email, address) values (76, 'Timmy', 'e8TRA1c', 'tpulham23@jalbum.net', '141 Florence Circle');
insert into users (id, names, password, email, address) values (77, 'Emyle', 'Vx5TaC', 'ecockett24@blogs.com', '19251 Schiller Court');
insert into users (id, names, password, email, address) values (78, 'Basil', 'HB6VFWKb', 'bfussen25@imageshack.us', '3 Linden Parkway');
insert into users (id, names, password, email, address) values (79, 'Tabatha', 'V7zSVf', 'ttennick26@jugem.jp', '09 Mesta Terrace');
insert into users (id, names, password, email, address) values (80, 'Paolo', 'MEPBxuZ', 'pbrotherhead27@irs.gov', '801 Fieldstone Junction');
insert into users (id, names, password, email, address) values (81, 'Gae', 'QxFvIlMa', 'gkynforth28@gnu.org', '69 Old Shore Road');
insert into users (id, names, password, email, address) values (82, 'Sybille', 'Aq2W8V', 'srizzardo29@skyrock.com', '153 Fisk Alley');
insert into users (id, names, password, email, address) values (83, 'Archer', 'a4Y2YaCCzC0u', 'atrayford2a@skyrock.com', '99031 Del Sol Hill');
insert into users (id, names, password, email, address) values (84, 'Tim', 'nLsPpEXvhuqQ', 'tgirardet2b@merriam-webster.com', '70 Parkside Parkway');
insert into users (id, names, password, email, address) values (85, 'Glen', '3uMKBw', 'gvandermark2c@economist.com', '8350 Thompson Circle');
insert into users (id, names, password, email, address) values (86, 'Cornie', 'mzdbbP5di5cc', 'chardison2d@marketwatch.com', '4 Manley Center');
insert into users (id, names, password, email, address) values (87, 'Gardener', 'XDHNVb', 'gcamamile2e@360.cn', '15 Nelson Way');
insert into users (id, names, password, email, address) values (88, 'Leisha', 'mPBJEZAG20z', 'lgilloran2f@hugedomains.com', '425 Tomscot Pass');
insert into users (id, names, password, email, address) values (89, 'Ketty', 'NL4lG6ZxX1z', 'kpilkington2g@squidoo.com', '6 Mandrake Junction');
insert into users (id, names, password, email, address) values (90, 'Roderic', 'vOseh3', 'rdearan2h@sogou.com', '7 Clove Trail');
insert into users (id, names, password, email, address) values (91, 'Hestia', 'qtTtsNs', 'hmerrikin2i@fda.gov', '44729 Village Plaza');
insert into users (id, names, password, email, address) values (92, 'Jena', 'jkQSsgoCUvqo', 'jsteuart2j@cdbaby.com', '038 Doe Crossing Junction');
insert into users (id, names, password, email, address) values (93, 'Kendal', '7zvMN6TSwb', 'kgrocott2k@shop-pro.jp', '00328 1st Plaza');
insert into users (id, names, password, email, address) values (94, 'Rosaline', 'NoAFlg', 'rbroseman2l@xrea.com', '4094 Hagan Center');
insert into users (id, names, password, email, address) values (95, 'Chevalier', 'HetgTngKJh', 'cfoker2m@ameblo.jp', '35 Farragut Pass');
insert into users (id, names, password, email, address) values (96, 'Adelheid', 'HoJX5T', 'apedrielli2n@51.la', '250 Little Fleur Parkway');
insert into users (id, names, password, email, address) values (97, 'Lyndsey', 'NveSNEm9', 'lleblanc2o@intel.com', '7052 Glacier Hill Center');
insert into users (id, names, password, email, address) values (98, 'Archie', 'A3kHJAM1w', 'astopforth2p@cdc.gov', '154 Esch Way');
insert into users (id, names, password, email, address) values (99, 'Nell', 'Bt81emGixz', 'nforce2q@sourceforge.net', '00 Manitowish Plaza');
insert into users (id, names, password, email, address) values (100, 'Kristoffer', 'LdgELSc9q1b', 'kjagg2r@unicef.org', '687 Gateway Road');


insert into auctioneer (id, idUser, phone) values (1, 1, '8868562100');
insert into auctioneer (id, idUser, phone) values (2, 2, '7365078377');
insert into auctioneer (id, idUser, phone) values (3, 3, '2955619809');
insert into auctioneer (id, idUser, phone) values (4, 4, '9923971062');
insert into auctioneer (id, idUser, phone) values (5, 5, '1444492177');
insert into auctioneer (id, idUser, phone) values (6, 6, '6004471105');
insert into auctioneer (id, idUser, phone) values (7, 7, '4807807358');
insert into auctioneer (id, idUser, phone) values (8, 8, '1691794426');
insert into auctioneer (id, idUser, phone) values (9, 9, '5216634832');
insert into auctioneer (id, idUser, phone) values (10, 10, '3021461470');
insert into auctioneer (id, idUser, phone) values (11, 11, '5584352412');
insert into auctioneer (id, idUser, phone) values (12, 12, '5144050038');
insert into auctioneer (id, idUser, phone) values (13, 13, '9971598788');
insert into auctioneer (id, idUser, phone) values (14, 14, '7349213121');
insert into auctioneer (id, idUser, phone) values (15, 15, '9653623921');
insert into auctioneer (id, idUser, phone) values (16, 16, '8255405826');
insert into auctioneer (id, idUser, phone) values (17, 17, '3588578271');
insert into auctioneer (id, idUser, phone) values (18, 18, '8152716391');
insert into auctioneer (id, idUser, phone) values (19, 19, '6458546389');
insert into auctioneer (id, idUser, phone) values (20, 20, '3465454211');
insert into auctioneer (id, idUser, phone) values (21, 21, '8051239041');
insert into auctioneer (id, idUser, phone) values (22, 22, '7827181234');
insert into auctioneer (id, idUser, phone) values (23, 23, '8072078753');
insert into auctioneer (id, idUser, phone) values (24, 24, '1638200613');
insert into auctioneer (id, idUser, phone) values (25, 25, '2603736472');
insert into auctioneer (id, idUser, phone) values (26, 26, '3224263459');
insert into auctioneer (id, idUser, phone) values (27, 27, '1303943927');
insert into auctioneer (id, idUser, phone) values (28, 28, '6774338834');
insert into auctioneer (id, idUser, phone) values (29, 29, '5804873187');
insert into auctioneer (id, idUser, phone) values (30, 30, '5943036016');
insert into auctioneer (id, idUser, phone) values (31, 31, '6361603696');
insert into auctioneer (id, idUser, phone) values (32, 32, '3605878680');
insert into auctioneer (id, idUser, phone) values (33, 33, '5585959916');
insert into auctioneer (id, idUser, phone) values (34, 34, '5595909585');
insert into auctioneer (id, idUser, phone) values (35, 35, '4953932373');
insert into auctioneer (id, idUser, phone) values (36, 36, '4544553245');
insert into auctioneer (id, idUser, phone) values (37, 37, '7543678507');
insert into auctioneer (id, idUser, phone) values (38, 38, '9258619674');
insert into auctioneer (id, idUser, phone) values (39, 39, '9229614888');
insert into auctioneer (id, idUser, phone) values (40, 40, '2848768899');


insert into administrator (id, names, passwords, email, address) values (1, 'Marline', 'tczbZa6UujE8', 'mvandervelden0@a8.net', '64 Loomis Circle');
insert into administrator (id, names, passwords, email, address) values (2, 'Rianon', 'OWB1vDbSC8q', 'ryggo1@skyrock.com', '768 Riverside Plaza');
insert into administrator (id, names, passwords, email, address) values (3, 'Kirsteni', 'UpeSdvqnqA', 'kcornels2@go.com', '41189 Di Loreto Parkway');
insert into administrator (id, names, passwords, email, address) values (4, 'Thekla', 'UdZtJCOeENmr', 'tcustard3@harvard.edu', '2732 Oakridge Terrace');

insert into car (id, names, category, states, color, consumption, kilometers) values (1, 'Dodge', 'Coupe', 'Brand New', 'Violet', 9.2, 566);
insert into car (id, names, category, states, color, consumption, kilometers) values (2, 'Mercedes-Benz', 'Sport', 'Normal Condition', 'Indigo', 11.8, 651);
insert into car (id, names, category, states, color, consumption, kilometers) values (3, 'Mercury', 'Sport', 'High Condition', 'Puce', 9.2, 729);
insert into car (id, names, category, states, color, consumption, kilometers) values (4, 'Toyota', 'Coupe', 'Poor Condition', 'Blue', 9.1, 777);
insert into car (id, names, category, states, color, consumption, kilometers) values (5, 'Dodge', 'Sport', 'Wreck', 'Turquoise', 7.0, 577);
insert into car (id, names, category, states, color, consumption, kilometers) values (6, 'Dodge', 'Sport', 'Wreck', 'Turquoise', 7.0, 577);


insert into auction (id, idCar, descriptions, priceStart, priceNow, timeClose, owners, states, title) values (1, 1, 'Super Fast Car', 6903, 6903, '2023-01-04 04:21:09', 1, 'Active','Violet Coupe');
insert into auction (id, idCar, descriptions, priceStart, priceNow, timeClose, owners, states, title) values (2, 2, '', 4236, 4236, '2022-12-20 01:07:28', 2, 'Active','');
insert into auction (id, idCar, descriptions, priceStart, priceNow, timeClose, owners, states, title) values (3, 3, '', 11332, 11332, '2023-02-02 11:51:40', 3, 'Active','');
insert into auction (id, idCar, descriptions, priceStart, priceNow, timeClose, owners, states, title) values (4, 4, '', 12637, 12637, '2023-02-13 09:11:11', 4, 'Active','');
insert into auction (id, idCar, descriptions, priceStart, priceNow, timeClose, owners, states, title) values (5, 5, '', 7714, 7714, '2022-12-11 10:04:05', 5, 'Active','');
insert into auction (id, idCar, descriptions, priceStart, priceNow, timeClose, highestBidder, owners, states, title) values (6, 6, 'Everyone is a ferrari fan', 7714, 7714, '2022-11-28 10:04:05', 1, 6, 'Closed','Ferrari confort');

insert into bid (id, idUser, idAuction, valuee) values (1,1,6,9000);

insert into follow (idUser, idAuction) values (1, 2);
insert into follow (idUser, idAuction) values (2, 1);
insert into follow(iDuser,iDauction) values (2,2);

insert into rating (id,idUser,idAuctioneer,grade) values (1,1,6,5);     



insert into users (id, names, password, email, address) values (101, 'Vivie', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'admin@example.com', '0110 Swallow Street');

