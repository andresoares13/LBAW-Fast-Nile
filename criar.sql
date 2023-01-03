DROP DATABASE IF EXISTS fastniledb;

CREATE DATABASE fastniledb;
\c fastniledb



DROP SCHEMA IF EXISTS lbaw22144 CASCADE;
CREATE SCHEMA lbaw22144; --omit this lines above while at feup server


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
DROP TABLE IF EXISTS password_resets CASCADE;
DROP TABLE IF EXISTS block CASCADE;

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

CREATE TABLE password_resets (
   id SERIAL PRIMARY KEY,
   email TEXT,
   token TEXT,
   created_at TIMESTAMP
);

 CREATE TABLE block (
   id SERIAL PRIMARY KEY, 
   idUser INT NOT NULL,
   idAdmin INT NOT NULL,
   justification TEXT NOT NULL,
   CONSTRAINT fk_user FOREIGN KEY(idUser) REFERENCES users(id) ON DELETE CASCADE,
   CONSTRAINT fk_admin FOREIGN KEY(idAdmin) REFERENCES administrator(id)
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
DROP TRIGGER IF EXISTS fix_auction_price ON auction;
DROP TRIGGER IF EXISTS update_bid_wallet ON bid;


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
      SET grade = round( CAST(((((auctioneer.grade * (select count(id) -1 from rating where idAuctioneer = new.idAuctioneer)) + new.grade)) / ( (select count(id) from rating where idAuctioneer = new.idAuctioneer))) AS numeric) , 2 )
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
      SET highestBidder = (select bid.idUser from auction,bid where bid.idAuction = auction.id and old.id = auction.highestBidder and bid.idUser is not NULL order by valuee desc limit 1),
      priceNow = (select bid.valuee from auction,bid where bid.idAuction = auction.id and old.id = auction.highestBidder and bid.idUser is not NULL order by valuee desc limit 1)
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
    IF (select count(bid.id) from auction,bid where bid.idAuction = old.id and bid.iduser is not null) > 0 THEN 
        RAISE EXCEPTION 'An auction cannot be deleted if it has more than 0 bids';
	ELSE

     UPDATE notification
     SET idAuction = NULL
     WHERE idAuction = old.id;

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
	  WHERE bid.idAuction = new.id and bid.idUser is not null;
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
	  WHERE bid.idAuction = new.id and bid.idUser is not null;
	  
	  INSERT INTO notification (idUser,idAuction,messages,viewed)
	  SELECT users.id,new.id,'Your auction has ended',false
	  FROM users
	  WHERE users.id = (select idUser from auctioneer where id = (select owners from auction where id = new.id ));
	  
	  INSERT INTO notification (idUser,idAuction,messages,viewed)
      SELECT distinct bid.idUser,bid.idAuction,(SELECT CONCAT('The winner of the auction was ', (select names FROM users where id= (select highestBidder from auction where id=new.id)))),false
	  FROM bid
	  WHERE bid.idAuction = new.id and bid.idUser is not null;
	  
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


--t19

CREATE OR REPLACE FUNCTION fix_auction_price_function() RETURNS TRIGGER AS
$BODY$
BEGIN
   IF (new.priceNow is null) THEN
      UPDATE auction
         SET priceNow = priceStart where id = new.id;
   END IF;
   return new;
END;
$BODY$
language plpgsql;


CREATE TRIGGER fix_auction_price
     AFTER UPDATE ON auction
     FOR EACH ROW
     EXECUTE PROCEDURE fix_auction_price_function();     


--t20

CREATE OR REPLACE FUNCTION update_bid_wallet_function() RETURNS TRIGGER AS
$BODY$
BEGIN
   UPDATE users
   SET wallet = wallet - new.valuee 
   WHERE users.id = new.idUser;
   
   UPDATE users
   SET wallet = wallet + (select valuee from bid where idAuction = new.idAuction and id != new.id ORDER BY id DESC limit 1)
   WHERE users.id = (select idUser from bid where idAuction = new.idAuction and id != new.id ORDER BY id DESC limit 1);
   
   return new;
END;
$BODY$
language plpgsql;


CREATE TRIGGER update_bid_wallet
     AFTER INSERT ON bid
     FOR EACH ROW
     EXECUTE PROCEDURE update_bid_wallet_function(); 
     
  



