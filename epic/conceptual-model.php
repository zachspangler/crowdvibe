<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>CrowdVibe | Conceptual Model</title>
	</head>
	<body>
		<h1>Conceptual Model</h1>
		<h4>PROFILE</h4>
		<ul>
			<li>profileId (primary key)</li>
			<li>profileActivationToken</li>
			<li>profileUserName</li>
			<li>profileFirstName</li>
			<li>profileLastName</li>
			<li>profileEmail</li>
			<li>profileHash</li>
			<li>profileSalt</li>
			<li>profileBio</li>
			<li>profileImage</li>
		</ul>
		<h4>EVENT</h4>
		<ul>
			<li>eventId (primary key)</li>
			<li>eventProfileId (foreign key) - host of event </li>
			<li>eventName</li>
			<li>eventDetail</li>
			<li>eventLocation</li>
			<li>eventDateTime</li>
			<li>eventDuration</li>
			<li>eventAttendeeLimit</li>
			<li>eventCategory</li>
			<li>eventImage</li>
			<li>eventPrice</li>
			<li>eventLat</li>
			<li>eventLong</li>
		</ul>
		<h4>RATING</h4>
		<ul>
			<li>ratingId (primary key)</li>
			<li>ratingRaterProfileId (foreign key) - For the person giving the rating</li>
			<li>ratingRateeProfileId (foreign key) - For the person receiving the rating</li>
			<li>ratingEventId (foreign key) - event that was attended </li>
			<li>ratingType - is this a rating for a person or an event</li>
			<li>ratingSocialScore</li>
			<li>ratingEventScore</li>
		</ul>
		<h4>EVENT ATTENDANCE</h4>
		<ul>
			<li>attendanceID (primary key)</li>
			<li>attendanceEventId (foreign key)</li>
			<li>attendanceProfileId (foreign key)</li>
			<li>attendanceNumberAttending</li>
			<li>attendanceCheckIn</li>
		</ul>
	</body>
</html>