--DROP TABLE IF EXISTS 'profile';
--DROP TABLE IF EXISTS 'rating';
--DROP TABLE IF EXISTS 'event';
--DROP TABLE IF EXISTS 'eventAttendance';

CREATE TABLE profile (
  profileId BINARY(16) NOT NULL ,
  profileActivationToken CHAR(32) NOT NULL,
  profileEmail VARCHAR(128) NOT NULL ,
  profileUsername VARCHAR(32) NOT NULL ,
  profileHash CHAR(128) NOT NULL ,
  profileSalt CHAR(64) NOT NULL ,
  profileBio VARCHAR(280) NOT NULL ,
  profileFirstName VARCHAR(16) NOT NULL ,
  profileLastName VARCHAR(16) NOT NULL ,
  UNIQUE (profileEmail) ,
  UNIQUE (profileUsername) ,
  -- this officiates the primary key for the entity
  PRIMARY KEY (profileId)

);
CREATE TABLE rating (
  ratingId BINARY(16) NOT NULL,
  ratingEventId BINARY(16) NOT NULL,
  ratingRateeProfileId BINARY (16) NOT NULL,
  ratingRaterProfileId BINARY (16) NOT NULL,
  ratingScore TINYINT(100) NOT NULL,
  ratingType CHAR(1) NOT NULL,

  FOREIGN KEY (ratingEventId),
  FOREIGN KEY (ratingRateeProfileId),
  FOREIGN KEY (ratingRaterProfileId),
  PRIMARY KEY (ratingId),

);

CREATE TABLE event (
  eventId BINARY(16) NOT NULL,
  eventProfileId BINARY(16) NOT NULL,
  eventAttendeeLimit SMALLINT(500),
  eventStartDateTime DATETIME(6) NOT NULL,
  eventEndDateTime DATETIME(6) NOT NULL,
  eventImage VARCHAR (64) NOT NULL,
  eventName VARCHAR(72) NOT NULL,
  eventPrice DECIMAL(7,2) NOT NULL,
  eventDetail VARCHAR(500) NOT NULL,
  eventLat DECIMAL(12) NOT NULL,
  eventLong DECIMAL(12) NOT NULL,
  eventCategory VARCHAR(32) NOT NULL,

);

CREATE TABLE eventAttendance (
  attendanceId BINARY(16) NOT NULL,
  attendanceEventId BINARY (16) NOT NULL,
  attendanceProfileId BINARY (16) NOT NULL,
  attendanceCheckIn BOOLEAN NOT NULL,
  attendanceNumberAttending TINYINT NOT NULL,

);