DROP DATABASE if EXISTS covid19;
CREATE DATABASE covid19;
USE covid19;

CREATE TABLE users(
  username VARCHAR(128) NOT NULL,
  password VARCHAR(128) NOT NULL,
  email VARCHAR(128) NOT NULL,
  is_admin BOOLEAN NOT NULL,
  PRIMARY KEY(email)
);

CREATE TABLE pois (
poiid VARCHAR(255) NOT NULL,
poiname VARCHAR(255) DEFAULT NULL ,
poiaddress VARCHAR(255) DEFAULT NULL,
types JSON DEFAULT NULL,
lat FLOAT DEFAULT NULL,
lng FLOAT DEFAULT NULL,
rating FLOAT DEFAULT NULL,
rating_n INT DEFAULT NULL,
current_popularity INT(11) DEFAULT NULL,
populartimes JSON  DEFAULT NULL,
time_spent JSON DEFAULT NULL,
PRIMARY KEY(poiid)
);

CREATE TABLE popularity(
poiid1 VARCHAR(255),
userid1 VARCHAR(128),
date1 DATETIME,
popularity INT(11) DEFAULT NULL,
CONSTRAINT POI FOREIGN kEY(poiid1) REFERENCES pois(poiid)
ON DELETE CASCADE
ON UPDATE CASCADE,
CONSTRAINT USER FOREIGN kEY(userid1) REFERENCES users(email)
ON DELETE CASCADE
ON UPDATE CASCADE
);

CREATE TABLE visits(
uservisitid VARCHAR(255) ,
visitpoiid VARCHAR(255),
visittimestamp DATETIME,
spenttime INT(11),
CONSTRAINT VISITUSER FOREIGN KEY(uservisitid) REFERENCES users(email)
ON DELETE CASCADE,
CONSTRAINT VISITPOI FOREIGN KEY(visitpoiid) REFERENCES pois(poiid)
ON DELETE CASCADE
ON UPDATE CASCADE
);

CREATE TABLE mycovid(
coviddate DATE,
coviduserid VARCHAR(128),
CONSTRAINT COVIDUSER FOREIGN KEY (coviduserid) REFERENCES users(email)
ON DELETE CASCADE
);

INSERT INTO users(username,password,email,is_admin)
VALUES('AndreasZaf','AndreasZaf1995!%','andreaszafei@hotmail.com','1');
