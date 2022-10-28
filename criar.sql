DROP DATABASE IF EXISTS fastniledb;

CREATE DATABASE fastniledb;
\c fastniledb



DROP SCHEMA IF EXISTS lbaw22g144 CASCADE;
CREATE SCHEMA lbaw22g144; --omit this lines above while at feup server


SET search_path TO lbaw22g144;


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
   passwords TEXT NOT NULL,
   picture TEXT NOT NULL DEFAULT 'default.png',
   email TEXT NOT NULL CONSTRAINT user_email_uk UNIQUE,
   address TEXT,
   wallet INT NOT NULL DEFAULT 0
);

CREATE TABLE auctioneer (
   id SERIAL PRIMARY KEY,
   idUser Int,
   phone TEXT NOT NULL CONSTRAINT auctioneer_phone_uk UNIQUE,
   grade INT,
   CONSTRAINT fk_user FOREIGN KEY(idUser) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE administrator (
   id SERIAL PRIMARY KEY,
   names TEXT NOT NULL,
   passwords TEXT NOT NULL,
   picture TEXT NOT NULL DEFAULT 'default.png',
   email TEXT NOT NULL CONSTRAINT administrator_email_uk UNIQUE,
   address TEXT
);

CREATE TABLE car (
   id SERIAL PRIMARY KEY,
   names TEXT NOT NULL,
   category categories NOT NULL,
   states statesCar NOT NULL,
   color TEXT NOT NULL,
   consumption FLOAT NOT NULL,
   kilometers INT NOT NULL
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
   owners INT NOT NULL,
   states statesAuction NOT NULL,
   title TEXT NOT NULL,
   CONSTRAINT fk_car FOREIGN KEY(idCar) REFERENCES car(id) ON DELETE CASCADE,
   CONSTRAINT fk_bidder FOREIGN KEY(highestBidder) REFERENCES users(id),
   CONSTRAINT fk_owner FOREIGN KEY(owners) REFERENCES auctioneer(id)
);

 CREATE TABLE bid (
   id SERIAL PRIMARY KEY,
   idUser INT,
   idAuction INT,
   valuee INT NOT NULL,
   CONSTRAINT fk_user FOREIGN KEY(idUser) REFERENCES users(id) ON DELETE CASCADE,
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
   idAuction INT NOT NULL,
   messages TEXT NOT NULL,
   CONSTRAINT fk_user FOREIGN KEY(idUser) REFERENCES users(id) ON DELETE CASCADE,
   CONSTRAINT fk_auction FOREIGN KEY(idAuction) REFERENCES auction(id) 
);  

 CREATE TABLE rating (
   idUser INT,
   idAuctioneer INT,
   grade INT,
   PRIMARY KEY (idUser, idAuctioneer, grade),
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
        IF (SELECT priceNow from auction WHERE auction.id = new.idAuction) >= new.valuee THEN
           RAISE EXCEPTION 'A bid can only be made if it is higher than the current one';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER smaller_bid
        BEFORE INSERT OR UPDATE ON bid
        FOR EACH ROW
        EXECUTE PROCEDURE smaller_bid_function();



--t5

CREATE OR REPLACE FUNCTION auction_valid_time_function() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF (SELECT extract(epoch from (new.timeclose - now())) / 60 ) <= 0 THEN
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





