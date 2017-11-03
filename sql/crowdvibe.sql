--DROP TABLE IF EXISTS 'profile';
--DROP TABLE IF EXISTS 'rating';
--DROP TABLE IF EXISTS 'event';
--DROP TABLE IF EXISTS 'eventAttendance';

CREATE TABLE profile (
  profileId BINARY(16) NOT NULL ,
  profileActivationToken CHAR(32) ,
  profileEmail VARCHAR(128) ,
  profileUsername VARCHAR(32) ,
  profileHash CHAR(128) ,
  profileSalt CHAR(64) NOT NULL ,
  profileBio VARCHAR(280) ,
  profileFirstName VARCHAR(16) ,
  profileLastName VARCHAR(16) ,
  UNIQUE (profileEmail) ,
  UNIQUE (profileUsername) ,
  PRIMARY KEY (profileId)

);
CREATE TABLE