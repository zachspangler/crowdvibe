DROP TABLE IF EXISTS 'profile';
DROP TABLE IF EXISTS 'event';
DROP TABLE IF EXISTS 'eventAttendance';
DROP TABLE IF EXISTS 'rating';

CREATE TABLE profile (
  profileId BINARY(16) NOT NULL,
  profileActivationToken CHAR(32) NOT NULL,
  profileEmail VARCHAR(128) NOT NULL,
  profileUsername VARCHAR(32) NOT NULL,
  profileHash CHAR(128) NOT NULL,
  profileSalt CHAR(64) NOT NULL,
  profileBio VARCHAR(255) NOT NULL,
  profileFirstName VARCHAR(32) NOT NULL,
  profileLastName VARCHAR(32) NOT NULL,
  UNIQUE (profileEmail),
  UNIQUE (profileUsername),
  -- this officiates the primary key for the entity
  PRIMARY KEY (profileId)
);

CREATE TABLE event (
  eventId BINARY(16) NOT NULL,
  eventProfileId BINARY(16) NOT NULL,
  eventAttendeeLimit SMALLINT UNSIGNED,
  eventStartDateTime DATETIME(6) NOT NULL,
  eventEndDateTime DATETIME(6) NOT NULL,
  eventImage VARCHAR (64),
  eventName VARCHAR(64) NOT NULL,
  eventPrice DECIMAL(7,2) NOT NULL,
  eventDetail VARCHAR(500) NOT NULL,
  eventLat DECIMAL(9,6) NOT NULL,
  eventLong DECIMAL(9,6) NOT NULL,
  INDEX (eventProfileId),
  INDEX (eventName),
  INDEX (eventEndDateTime),
  INDEX (eventStartDateTime),
  INDEX (eventPrice),
  FOREIGN KEY (eventProfileId) REFERENCES profile(profileId),
  PRIMARY KEY (eventId)
);

CREATE TABLE eventAttendance (
  attendanceId BINARY(16) NOT NULL,
  attendanceEventId BINARY (16) NOT NULL,
  attendanceProfileId BINARY (16) NOT NULL,
  attendanceCheckIn TINYINT UNSIGNED NOT NULL,
  attendanceNumberAttending TINYINT UNSIGNED NOT NULL,
  INDEX (attendanceProfileId),
  INDEX (attendanceEventId),
  FOREIGN KEY (attendanceEventId) REFERENCES event(eventId),
  FOREIGN KEY (attendanceProfileId) REFERENCES profile(profileId),
  PRIMARY KEY (attendanceId)
);

CREATE TABLE rating (
  ratingId BINARY(16) NOT NULL,
  ratingEventAttendanceId BINARY(16) NOT NULL,
  ratingRateeProfileId BINARY (16),
  ratingRaterProfileId BINARY (16) NOT NULL,
  ratingScore TINYINT UNSIGNED NOT NULL,
  INDEX (ratingEventAttendanceId),
  INDEX (ratingRateeProfileId),
  INDEX (ratingRaterProfileId),
  FOREIGN KEY (ratingEventAttendanceId) REFERENCES eventAttendance(attendanceId),
  FOREIGN KEY (ratingRateeProfileId) REFERENCES profile(profileId),
  FOREIGN KEY (ratingRaterProfileId) REFERENCES profile(profileId),
  PRIMARY KEY (ratingId)
);

