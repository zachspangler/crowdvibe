<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Let's Chill | Conceptual Model</title>
	</head>
	<body>
		<h3>PROFILE</h3>
		<ul>
			<li>profileId (primary key)</li>
			<li>profileActivationToken</li>
			<li>profileUserName</li>
			<li>profileEmail</li>
			<li>profileHash</li>
			<li>profileSalt</li>
			<li>profileBio</li>
			<li>profileImage</li>
		</ul>
		<h3>EVENT</h3>
		<ul>
			<li>eventId (primary key)</li>
			<li>eventProfileId (foreign key) - host of event </li>
			<li>eventName</li>
			<li>eventDetail</li>
			<li>eventLocation</li>
			<li>eventDateTime</li>
			<li>eventDuration</li>
			<li>eventCategory</li>
			<li>eventImage</li>
			<li>eventPrice</li>
			<li>eventType - public or private event</li>
		</ul>
		<h3>ATTENDEE RATING</h3>
		<ul>
			<li>attendeeRatingId (primary key)</li>
			<li>attendeeProfileId (foreign key) - For the person giving the rating</li>
			<li>attendeeProfileId (foreign key) - For the person receiving the rating</li>
			<li>attendeeEventId (foreign key) - What event the profile is being rated from</li>
			<li>attendeeSocialScore</li>
			<li>attendeeFlakeFactor</li>
		</ul>
		<h3>EVENT RATING</h3>
		<ul>
			<li>eventRatingId (primary key)</li>
			<li>eventRatingProfileId (foreign key) - For the person giving the rating</li>
			<li>eventRatingEventId (foreign key)</li>
			<li>eventRatingEventScore</li>
			<li>eventRatingClosed</li>
		</ul>
		<h3>EVENT ATTENDANCE</h3>
		<ul>
			<li>attendanceID (primary key)</li>
			<li>attendanceEventId (foreign key)</li>
			<li>attendanceProfileId (foreign key)</li>
			<li>attendanceStatus</li>
			<li>attendanceNumberAttending</li>
			<li>attendanceActivationToken</li>
			<li>attendanceCheckIn</li>
		</ul>
		<h3>FRIENDS</h3>
		<ul>
			<li>friendID (primary key)</li>
			<li>friendProfileId (foreign key) - this is the root friend</li>
			<li>friendProfileId (foreign key) - this is the profile of the friend of the user</li>
			<li>friendGroupName</li>
			<li>friendActivationToken</li>
		</ul>
		<h3>INTERESTS</h3>
		<ul>
			<li>interestID (primary key)</li>
			<li>interestTag</li>
		</ul>
	</body>
</html>