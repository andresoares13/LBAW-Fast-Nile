CREATE TABLE users (
   id SERIAL PRIMARY KEY,
   names TEXT NOT NULL,
   passwords TEXT NOT NULL,
   picture TEXT,
   email TEXT NOT NULL CONSTRAINT user_email_uk UNIQUE,
   addresss TEXT,
   wallet INT NOT NULL DEFAULT 0
);

CREATE TABLE auctioneer (
   id SERIAL PRIMARY KEY,
   names TEXT NOT NULL,
   passwords TEXT NOT NULL,
   picture TEXT,
   email TEXT NOT NULL CONSTRAINT auctioneer_email_uk UNIQUE,
   addresss TEXT,
   wallet INT NOT NULL DEFAULT 0
   phone INT NOT NULL CONSTRAINT auctioneer_email_uk UNIQUE,
   grade INT
);

CREATE TABLE administrator (
   id SERIAL PRIMARY KEY,
   names TEXT NOT NULL,
   passwords TEXT NOT NULL,
   picture TEXT,
   email TEXT NOT NULL CONSTRAINT administrator_email_uk UNIQUE,
   addresss TEXT
);

CREATE TABLE car (
   id SERIAL PRIMARY KEY,
   names TEXT NOT NULL,
   category TEXT NOT NULL,
   states TEXT NOT NULL,
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
   timeClose DATE NOT NULL,
   highestBidder INT,
   owners INT NOT NULL,
   states TEXT NOT NULL,
   CONSTRAINT fk_car FOREIGN KEY(idCar) REFERENCES car(id),
   CONSTRAINT fk_bidder FOREIGN KEY(highestBidder) REFERENCES user(id),
   CONSTRAINT fk_owner FOREIGN KEY(owners) REFERENCES auctioneer(id)
);

 CREATE TABLE bid (
   idUser INT,
   idAuction INT,
   valuee INT NOT NULL,
   PRIMARY KEY (idUser, idAuction),
   CONSTRAINT fk_user FOREIGN KEY(idUser) REFERENCES user(id),
   CONSTRAINT fk_auction FOREIGN KEY(idAuction) REFERENCES auction(id)
);  

 CREATE TABLE follow (
   idUser INT,
   idAuction INT,
   PRIMARY KEY (idUser, idAuction),
   CONSTRAINT fk_user FOREIGN KEY(idUser) REFERENCES user(id),
   CONSTRAINT fk_auction FOREIGN KEY(idAuction) REFERENCES auction(id)
);  

 CREATE TABLE notification (
   id SERIAL PRIMARY KEY, 
   idUser INT NOT NULL,
   idAuction INT NOT NULL,
   messages TEXT NOT NULL,
   CONSTRAINT fk_user FOREIGN KEY(idUser) REFERENCES user(id),
   CONSTRAINT fk_auction FOREIGN KEY(idAuction) REFERENCES auction(id)
);  

 CREATE TABLE rating (
   idUser INT,
   idAuctioneer INT,
   grade INT,
   PRIMARY KEY (idUser, idAuctioneer, grade),
   CONSTRAINT fk_user FOREIGN KEY(idUser) REFERENCES user(id),
   CONSTRAINT fk_auctioneer FOREIGN KEY(idAuctioneer) REFERENCES auctioneer(id)
);  