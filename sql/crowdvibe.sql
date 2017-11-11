DROP TABLE IF EXISTS rating;
DROP TABLE IF EXISTS eventAttendance;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
  profileId BINARY(16) NOT NULL,
  profileActivationToken CHAR(32),
  profileBio VARCHAR(255) NOT NULL,
  profileEmail VARCHAR(128) NOT NULL,
  profileFirstName VARCHAR(32) NOT NULL,
  profileHash CHAR(128) NOT NULL,
  profileImage VARCHAR(255),
  profileLastName VARCHAR(32) NOT NULL,
  profileSalt CHAR(64) NOT NULL,
  profileUsername VARCHAR(32) NOT NULL,
  UNIQUE (profileEmail),
  UNIQUE (profileUsername),
  -- this officiates the primary key for the entity
  PRIMARY KEY (profileId)
);

CREATE TABLE event (
  eventId BINARY(16) NOT NULL,
  eventProfileId BINARY(16) NOT NULL,
  eventAttendeeLimit SMALLINT UNSIGNED,
  eventEndDateTime DATETIME(6) NOT NULL,
  eventDetail VARCHAR(500) NOT NULL,
  eventImage VARCHAR (64),
  eventLat DECIMAL(9,6) NOT NULL,
  eventLong DECIMAL(9,6) NOT NULL,
  eventName VARCHAR(64) NOT NULL,
  eventPrice DECIMAL(7,2) NOT NULL,
  eventStartDateTime DATETIME(6) NOT NULL,
  INDEX (eventProfileId),
  INDEX (eventEndDateTime),
  INDEX (eventName),
  INDEX (eventPrice),
  INDEX (eventStartDateTime),
  FOREIGN KEY (eventProfileId) REFERENCES profile(profileId),
  PRIMARY KEY (eventId)
);

CREATE TABLE eventAttendance (
  eventAttendanceId BINARY(16) NOT NULL,
  eventAttendanceEventId BINARY (16) NOT NULL,
  eventAttendanceProfileId BINARY (16) NOT NULL,
  eventAttendanceCheckIn TINYINT UNSIGNED NOT NULL,
  eventAttendanceNumberAttending TINYINT UNSIGNED NOT NULL,
  INDEX (eventAttendanceProfileId),
  INDEX (eventAttendanceEventId),
  FOREIGN KEY (eventAttendanceEventId) REFERENCES event(eventId),
  FOREIGN KEY (eventAttendanceProfileId) REFERENCES profile(profileId),
  PRIMARY KEY (eventAttendanceId)
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

