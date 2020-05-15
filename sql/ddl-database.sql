ALTER DATABASE cap28_datenight CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE profile(
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(97) NOT NULL,
	profileName VARCHAR(32) NOT NULL,
	UNIQUE (profileEmail),
	UNIQUE(profileName),
	PRIMARY KEY(profileId)
);

CREATE TABLE activity(
	activityId BINARY(16) NOT NULL,
	activityImageUrl VARCHAR(255),
	activityLat DECIMAL(9,6) NOT NULL,
	activityLink VARCHAR(255) NOT NULL,
	activityLng DECIMAL(9,6) NOT NULL,
	activityTitle VARCHAR(128) NOT NULL,
	INDEX (activityId),
	PRIMARY KEY(activityId)
);
/* WEAK ENTITY*/
CREATE TABLE favorite(
	favoriteProfileId BINARY(16) NOT NULL,
	favoriteActivityId BINARY(16) NOT NULL,
	favoriteDate DATETIME(6) NOT NULL,
	INDEX(favoriteProfileId),
	INDEX(favoriteActivityId),
	FOREIGN KEY(favoriteProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(favoriteActivityId) REFERENCES activity(activityId)
);

alter table activity modify activityTitle varchar(128) not null;